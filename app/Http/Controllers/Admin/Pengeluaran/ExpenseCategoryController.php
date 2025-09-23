<?php

namespace App\Http\Controllers\Admin\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Category; // Gunakan model Category terpusat
use App\Models\Expense;  // Import model Expense untuk pengecekan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; // PERBAIKAN: Import Str helper

class ExpenseCategoryController extends Controller
{
    /**
     * Menyimpan kategori baru melalui permintaan AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where('type', 'expense')
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique'   => 'Kategori pengeluaran dengan nama ini sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // PERBAIKAN: Buat slug secara otomatis
            'type' => 'expense',
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Kategori baru berhasil ditambahkan.',
            'category' => $category,
        ]);
    }

    /**
     * Memperbarui kategori yang ada melalui permintaan AJAX.
     */
    public function updateAjax(Request $request, Category $category)
    {
        if ($category->type !== 'expense') {
            return response()->json(['message' => 'Kategori tidak valid.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where('type', 'expense')->ignore($category->id)
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique'   => 'Kategori pengeluaran dengan nama ini sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // PERBAIKAN: Update slug juga saat nama berubah
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Kategori berhasil diperbarui.',
            'category' => $category,
        ]);
    }

    /**
     * Menghapus kategori yang ada melalui permintaan AJAX.
     */
    public function destroyAjax(Category $category)
    {
        if ($category->type !== 'expense') {
            return response()->json(['message' => 'Kategori tidak valid.'], 403);
        }

        if (Expense::where('category_id', $category->id)->exists()) {
            return response()->json(['message' => 'Kategori tidak bisa dihapus karena masih digunakan oleh data pengeluaran.'], 409);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}
