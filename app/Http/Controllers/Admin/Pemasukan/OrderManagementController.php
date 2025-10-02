<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class OrderManagementController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        // [BAGIAN BARU] Menghitung data statistik untuk kartu di atas
        $totalOrders = Order::count();
        $pendingConfirmationCount = Order::where('status', 'Menunggu Konfirmasi')->count();
        $inProgressCount = Order::where('status', 'Diproses')->count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');

        // Logika query Anda yang sudah ada
        $query = Order::with('user', 'invoice')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($subQ) use ($request) {
                        $subQ->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        // [MODIFIKASI] Mengirim semua variabel (termasuk statistik) ke view
        return view('admin.pemasukan.orders', compact(
            'orders',
            'totalOrders',
            'pendingConfirmationCount',
            'inProgressCount',
            'totalRevenue'
        ));
    }
    /**
     * Menampilkan halaman detail pesanan dengan ringkasan pembayaran.
     */
    public function show(Order $order)
    {
        $order->load('user', 'detailOrders.service', 'invoice.payments');

        $amountPaid = 0;
        if ($order->invoice) {
            // Menghitung jumlah yang sudah DIVERIFIKASI saja
            $amountPaid = $order->payments()->whereNotNull('payment_date')->sum('payments.amount');
        }
        $remainingAmount = $order->total_price - $amountPaid;

        return view('admin.pemasukan.order-detail', compact('order', 'amountPaid', 'remainingAmount'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Pembayaran,Menunggu Konfirmasi,Diproses,Selesai,Dibatalkan',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.pemasukan.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * [DIPERBARUI] Verifikasi pembayaran per-item dengan nilai action yang benar.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            // [FIX] Mengganti 'approve' menjadi 'accept' agar cocok dengan form
            'action' => 'required|in:accept,reject',
            'payment_id' => 'required|exists:payments,id'
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        $invoice = $order->invoice;

        if (!$invoice || $payment->invoice_id !== $invoice->id) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        if ($request->action === 'accept') {
            $payment->update(['payment_date' => now()]);

            // [FIX] Menggunakan 'payments.amount' untuk menghindari error ambiguous column
            $totalPaid = $invoice->payments()->whereNotNull('payment_date')->sum('payments.amount');
            $message = "Pembayaran sebesar Rp " . number_format($payment->amount, 0, ',', '.') . " telah disetujui.";

            if ($totalPaid >= $order->total_price) {
                $invoice->update(['status' => 'Lunas']);
                $message .= ' Pesanan ini sekarang sudah LUNAS.';
            }

            $hasOtherPendingPayments = $invoice->payments()->whereNull('payment_date')->exists();
            if (!$hasOtherPendingPayments && $order->status === 'Menunggu Konfirmasi') {
                $order->update(['status' => 'Diproses']);
            }

            return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', $message);
        } else { // action === 'reject'
            Storage::disk('public')->delete($payment->payment_proof);
            $payment->delete();

            if ($invoice->payments()->count() === 0) {
                $order->update(['status' => 'Menunggu Pembayaran']);
                $invoice->delete();
            }

            return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', 'Bukti pembayaran telah ditolak dan dihapus.');
        }
    }
}
