<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;

class OrderManagementController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan fungsionalitas filter dan pencarian.
     */
    public function index(Request $request)
    {
        // ... (Logika index tidak berubah) ...
        $totalOrders = Order::count();
        $pendingConfirmationCount = Order::where('status', 'Menunggu Konfirmasi')->count();
        $inProgressCount = Order::where('status', 'Diproses')->count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');

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

        return view('admin.pemasukan.orders.index', compact(
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
        // ... (Logika show tidak berubah) ...
        $order->load('user', 'detailOrders.service', 'invoice.payments');

        $amountPaid = 0;
        if ($order->invoice) {
            $amountPaid = $order->payments()->whereNotNull('payment_date')->sum('payments.amount');
        }
        $remainingAmount = $order->total_price - $amountPaid;

        return view('admin.pemasukan.orders.show', compact('order', 'amountPaid', 'remainingAmount'));
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

        // --- 3. KIRIM NOTIFIKASI KE KLIEN ---
        $client = $order->user;
        $url = route('client.orders.show', $order->id);
        $message = "Your order status has been updated to: " . $request->status;
        $icon = 'fas fa-sync-alt';

        // Tentukan pesan yang lebih spesifik berdasarkan status
        if ($request->status === 'Diproses') {
            $message = "Your order #" . $order->id . " is now being processed.";
            $icon = 'fas fa-cogs';
        } elseif ($request->status === 'Selesai') {
            $message = "Great news! Your order #" . $order->id . " is now complete.";
            $icon = 'fas fa-check-double';
        } elseif ($request->status === 'Dibatalkan') {
            $message = "Your order #" . $order->id . " has been cancelled.";
            $icon = 'fas fa-ban';
        }

        Notification::send($client, new ClientNotification($message, $url, $icon));
        // --- AKHIR NOTIFIKASI ---

        return redirect()->route('admin.pemasukan.orders.show', $order->id)
            ->with('success', 'Order status has been updated.'); // <-- 4. Terjemahan (Sudah B.Inggris)
    }

    /**
     * Memperbarui harga negosiasi untuk opsi pengiriman cepat.
     */
    public function updateNegotiatedPrice(Request $request, Order $order)
    {
        $validated = $request->validate([
            'negotiated_price_fast' => 'nullable|numeric|min:0',
            'negotiated_price_express' => 'nullable|numeric|min:0',
        ]);

        $order->update($validated);

        // --- 3. KIRIM NOTIFIKASI KE KLIEN ---
        $client = $order->user;
        $message = "A new negotiated price has been set for your order #" . $order->id . ".";
        $url = route('client.orders.show', $order->id);
        Notification::send($client, new ClientNotification($message, $url, 'fas fa-dollar-sign'));
        // --- AKHIR NOTIFIKASI ---

        return redirect()->route('admin.pemasukan.orders.show', $order->id)
            ->with('success', 'Negotiated prices have been successfully updated.'); // <-- 4. Terjemahan (Sudah B.Inggris)
    }

    /**
     * Verifikasi pembayaran per-item dengan nilai action yang benar.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
            'payment_id' => 'required|exists:payments,id'
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        $invoice = $order->invoice;
        $client = $order->user; // <-- 3. Ambil Klien
        $url = route('client.orders.show', $order->id); // <-- 3. Siapkan URL

        if (!$invoice || $payment->invoice_id !== $invoice->id) {
            return back()->with('error', 'Invalid action.'); // <-- 4. Terjemahan
        }

        if ($request->action === 'accept') {
            $payment->update(['payment_date' => now()]);

            $totalPaid = $invoice->payments()->whereNotNull('payment_date')->sum('payments.amount');

            // 4. Terjemahan pesan
            $message = "Payment of $ " . number_format($payment->amount, 0) . " has been approved.";

            // --- 3. KIRIM NOTIFIKASI (DISETUJUI) ---
            Notification::send($client, new ClientNotification($message, $url, 'fas fa-check-circle'));
            // --- AKHIR NOTIFIKASI ---

            if ($totalPaid >= $order->total_price) {
                $invoice->update(['status' => 'Lunas']);
                $message .= ' This order is now fully PAID.'; // 4. Terjemahan
            }

            $hasOtherPendingPayments = $invoice->payments()->whereNull('payment_date')->exists();
            if (!$hasOtherPendingPayments && $order->status === 'Menunggu Konfirmasi') {
                $order->update(['status' => 'Diproses']);

                // --- 3. KIRIM NOTIFIKASI (DIPROSES) ---
                $statusMessage = "Your order #" . $order->id . " is now being processed.";
                Notification::send($client, new ClientNotification($statusMessage, $url, 'fas fa-cogs'));
                // --- AKHIR NOTIFIKASI ---
            }

            return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', $message);
        } else { // action === 'reject'
            Storage::disk('public')->delete($payment->payment_proof);
            $payment->delete();

            // --- 3. KIRIM NOTIFIKASI (DITOLAK) ---
            $rejectMessage = "Your payment proof for order #" . $order->id . " has been rejected.";
            Notification::send($client, new ClientNotification($rejectMessage, $url, 'fas fa-times-circle'));
            // --- AKHIR NOTIFIKASI ---

            if ($invoice->payments()->count() === 0) {
                $order->update(['status' => 'Menunggu Pembayaran']);
                $invoice->delete();
            }

            // 4. Terjemahan
            return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', 'Payment proof has been rejected and deleted.');
        }
    }

    public function updateProgress(Request $request, Order $order)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $order->update(['progress' => $request->progress]);

        // --- 3. KIRIM NOTIFIKASI KE KLIEN ---
        $client = $order->user;
        $message = "Your order progress for #" . $order->id . " is now " . $request->progress . "%.";
        $url = route('client.orders.show', $order->id);
        Notification::send($client, new ClientNotification($message, $url, 'fas fa-tasks'));
        // --- AKHIR NOTIFIKASI ---

        return back()->with('success', 'Order progress has been updated.'); // <-- 4. Terjemahan (Sudah B.Inggris)
    }
}
