<?php

namespace App\Http\Controllers\Admin\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Worker;
use App\Models\ExpenseCategory; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan fitur filter dan pencarian.
     */
    public function index(Request $request)
    {
        $totalOrders = Order::count();
        $pendingConfirmationCount = Order::where('status', 'Awaiting Confirmation')->count();
        $inProgressCount = Order::where('status', 'Processing')->count();
        $totalRevenue = Order::where('status', 'Completed')->sum('total_price');

        $query = Order::with('user', 'invoice')->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', '%' . $searchTerm . '%');
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
     * Menampilkan detail pesanan lengkap dengan riwayat pembayaran.
     */
    public function show(Order $order)
    {
        $order->load('user', 'detailOrders.service', 'invoice.payments', 'expenses.worker');

        $amountPaid = 0;
        if ($order->invoice) {
            $amountPaid = $order->payments()->whereNotNull('payment_date')->sum('payments.amount');
        }
        $remainingAmount = max(0, $order->total_price - $amountPaid);

        return view('admin.pemasukan.orders.show', compact('order', 'amountPaid', 'remainingAmount'));
    }

    /**
     * Memperbarui status pesanan secara manual.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending Payment,Awaiting Confirmation,Processing,Completed,Cancelled',
        ]);

        DB::transaction(function () use ($request, $order) {
            $order->update(['status' => $request->status]);

            $client = $order->user;
            $url = route('client.orders.show', $order->id);
            $icon = 'fas fa-sync-alt';
            $message = "Order status updated to: " . $request->status;

            if ($request->status === 'Processing') {
                $message = "Your order #{$order->id} is now being processed.";
                $icon = 'fas fa-cogs';
            } elseif ($request->status === 'Completed') {
                $message = "Order #{$order->id} is now complete. Thank you!";
                $icon = 'fas fa-check-double';
            } elseif ($request->status === 'Cancelled') {
                $message = "Order #{$order->id} has been cancelled.";
                $icon = 'fas fa-ban';
            }

            Notification::send($client, new ClientNotification($message, $url, $icon));
        });

        return redirect()->route('admin.pemasukan.orders.show', $order->id)
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Memperbarui biaya negosiasi pengiriman.
     */
    public function updateNegotiatedPrice(Request $request, Order $order)
    {
        $request->validate([
            'negotiated_price_fast' => 'nullable|numeric|min:0',
            'negotiated_price_express' => 'nullable|numeric|min:0',
            'negotiated_price_custom' => 'nullable|numeric|min:0',
        ]);

        $order->update([
            'negotiated_price_fast' => $request->negotiated_price_fast,
            'negotiated_price_express' => $request->negotiated_price_express,
            'negotiated_price_custom' => $request->negotiated_price_custom,
        ]);

        return back()->with('success', 'Negotiated pricing has been updated.');
    }

    /**
     * Verifikasi bukti pembayaran manual dari klien.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
            'payment_id' => 'required|exists:payments,id'
        ]);

        return DB::transaction(function () use ($request, $order) {
            $payment = Payment::findOrFail($request->payment_id);
            $invoice = $order->invoice;
            $client = $order->user;
            $url = route('client.orders.show', $order->id);

            if (!$invoice || $payment->invoice_id !== $invoice->id) {
                return back()->with('error', 'Mismatch error: Invoice not found.');
            }

            if ($request->action === 'accept') {
                $payment->update(['payment_date' => now()]);
                $totalPaid = $invoice->payments()->whereNotNull('payment_date')->sum('amount');
                $message = "Payment of $ " . number_format($payment->amount, 2) . " approved.";

                if ($totalPaid >= $order->total_price) {
                    $invoice->update(['status' => 'Paid']);
                    $message .= ' Order is now fully PAID.';
                }

                if ($order->status === 'Awaiting Confirmation') {
                    $order->update(['status' => 'Processing']);
                }

                Notification::send($client, new ClientNotification($message, $url, 'fas fa-check-circle'));
                return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', $message);
            } else {
                $proofPath = $payment->payment_proof;
                $payment->delete();
                if ($proofPath) Storage::disk('public')->delete($proofPath);

                if ($invoice->payments()->whereNotNull('payment_date')->count() === 0) {
                    $order->update(['status' => 'Pending Payment']);
                }

                $rejectMessage = "Payment proof for order #{$order->id} rejected. Please re-upload.";
                Notification::send($client, new ClientNotification($rejectMessage, $url, 'fas fa-times-circle'));

                return redirect()->route('admin.pemasukan.orders.show', $order->id)->with('success', 'Payment proof rejected.');
            }
        });
    }

    /**
     * Memperbarui progress pengerjaan proyek.
     */
    public function updateProgress(Request $request, Order $order)
    {
        $request->validate(['progress' => 'required|integer|min:0|max:100']);
        $order->update(['progress' => $request->progress]);

        $client = $order->user;
        $message = "Project progress for #{$order->id} is now at {$request->progress}%.";
        $url = route('client.orders.show', $order->id);
        Notification::send($client, new ClientNotification($message, $url, 'fas fa-tasks'));

        return back()->with('success', 'Progress updated.');
    }

    /**
     * Menyimpan data pembayaran fee ke Worker (Pengeluaran Project).
     */
    public function storeWorkerPayout(Request $request, Order $order)
    {
        $request->validate([
            'worker_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request, $order) {
            // 1. Dapatkan atau buat Worker
            $worker = Worker::firstOrCreate(['name' => $request->worker_name]);

            // 2. PERBAIKAN: Buat kategori tanpa kolom 'description'
            // Kita hanya mengirim 'name' karena database kamu belum punya kolom description
            $category = ExpenseCategory::firstOrCreate(
                ['name' => 'Project Cost']
            );

            // 3. Simpan sebagai Expense (Project Type)
            $expense = $order->expenses()->create([
                'user_id' => auth()->id(),
                'worker_id' => $worker->id,
                'category_id' => $category->id,
                'amount' => $request->amount,
                'description' => $request->description ?? "Payout for Project #{$order->id} to {$worker->name}",
                'expense_date' => now(),
                'type' => 'project',
                'status' => 'Pending',
            ]);

            // 4. Catat otomatis ke Arus Kas (Transactions)
            if (method_exists($expense, 'transaction')) {
                $expense->transaction()->create([
                    'user_id' => auth()->id(),
                    'type' => 'Pengeluaran',
                    'amount' => $request->amount,
                    'description' => "Worker Payout: {$worker->name} for Order #{$order->id}",
                ]);
            }

            return back()->with('success', 'Worker payout recorded successfully.');
        });
    }
}
