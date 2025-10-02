<?php

namespace App\Http\Controllers\Admin\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Menampilkan daftar pengeluaran (expenses).
     */
    public function index(Request $request)
    {
        // [BAGIAN BARU] Menghitung total pengeluaran bulan ini
        $totalThisMonth = Expense::whereBetween('expense_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');

        // Kode Anda yang sudah ada
        $categories = Category::where('type', 'expense')->get();
        $query = Expense::with(['category', 'user'])->latest('expense_date'); // Diurutkan berdasarkan tanggal pengeluaran

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $expenses = $query->paginate(10)->withQueryString();

        // [MODIFIKASI] Mengirim variabel baru ke view
        return view('admin.pengeluaran.index', compact(
            'expenses',
            'categories',
            'totalThisMonth'
        ));
    }

    /**
     * Menampilkan form untuk membuat pengeluaran baru.
     */
    public function create()
    {
        // PERBAIKAN: Ambil hanya kategori dengan tipe 'expense'
        $categories = Category::where('type', 'expense')->get();
        return view('admin.pengeluaran.create', compact('categories'));
    }

    /**
     * Menyimpan pengeluaran baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi ke tabel categories
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Full,DP', // Validasi baru
        ]);

        Expense::create($request->all() + ['user_id' => Auth::id()]);

        return redirect()->route('admin.pengeluaran.expenses.index')
            ->with('success', 'Pengeluaran baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengeluaran.
     */
    public function edit(Expense $expense)
    {
        // PERBAIKAN: Ambil hanya kategori dengan tipe 'expense'
        $categories = Category::where('type', 'expense')->get();
        return view('admin.pengeluaran.edit', compact('expense', 'categories'));
    }

    /**
     * Memperbarui pengeluaran di database.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validasi ke tabel categories
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Full,DP', // Validasi baru
        ]);

        $expense->update($request->all());

        return redirect()->route('admin.pengeluaran.expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    /**
     * Menghapus pengeluaran dari database.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.pengeluaran.expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
