<?php

namespace App\Http\Controllers\Admin\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Worker; // Import Model Worker
use App\Models\Order;  // Import Model Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectExpenseController extends Controller
{
    /**
     * Menampilkan daftar pengeluaran project (Grouping by Order).
     */
    public function index(Request $request)
    {
        // Ambil Order yang punya expense project, filter jika ada search
        $query = \App\Models\Order::whereHas('expenses', function ($q) {
            $q->where('type', 'project');
        })->with(['expenses' => function ($q) {
            $q->where('type', 'project')->with('worker');
        }]);

        if ($request->filled('search')) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $ordersWithExpenses = $query->latest()->paginate(10)->withQueryString();

        // Data untuk modal
        $workers = \App\Models\Worker::orderBy('name', 'asc')->get();
        $allOrders = \App\Models\Order::select('id', 'status')->latest()->get();

        return view('admin.pengeluaran.projects.index', compact('ordersWithExpenses', 'workers', 'allOrders'));
    }

    /**
     * Memperbarui data pengeluaran project (Dijalankan dari Edit Modal).
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'order_id'    => 'required|exists:orders,id',
            'worker_id'   => 'required|exists:workers,id',
            'amount'      => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:Pending,Paid',
        ]);

        // Update data dasar
        $expense->update([
            'order_id'    => $request->order_id,
            'worker_id'   => $request->worker_id,
            'amount'      => $request->amount,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return back()->with('success', 'Data payout worker berhasil diperbarui.');
    }

    /**
     * Menghapus data pengeluaran project.
     */
    public function destroy(Expense $expense)
    {
        DB::transaction(function () use ($expense) {
            // Hapus file bukti transfer jika ada di storage
            if ($expense->transfer_proof) {
                Storage::disk('public')->delete($expense->transfer_proof);
            }

            // Hapus transaksi terkait di tabel transactions (jika sistem kamu mencatat double-entry)
            if ($expense->transaction) {
                $expense->transaction->delete();
            }

            $expense->delete();
        });

        return back()->with('success', 'Record pengeluaran project berhasil dihapus.');
    }

    /**
     * Upload bukti transfer & update status ke Paid.
     */
    public function uploadProof(Request $request, Expense $expense)
    {
        $request->validate([
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'transfer_note'  => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('transfer_proof')) {
            // Hapus foto lama agar storage tidak bengkak
            if ($expense->transfer_proof) {
                Storage::disk('public')->delete($expense->transfer_proof);
            }

            $path = $request->file('transfer_proof')->store('transfer_proofs', 'public');

            $expense->update([
                'transfer_proof' => $path,
                'transfer_note'  => $request->transfer_note,
                'status'         => 'Paid'
            ]);
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah dan status diperbarui.');
    }

    /**
     * Shortcut untuk mengubah status tanpa upload file.
     */
    public function markAsPaid(Expense $expense)
    {
        $expense->update(['status' => 'Paid']);
        return back()->with('success', 'Status pembayaran diperbarui ke PAID.');
    }
}
