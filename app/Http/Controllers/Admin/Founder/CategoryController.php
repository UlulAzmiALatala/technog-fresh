<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Menyimpan kategori post baru via AJAX.
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where('type', 'post'),
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Kategori post dengan nama ini sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => 'post',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'category' => $category
        ]);
    }

    /**
     * Menyimpan kategori studi kasus via AJAX.
     */
    public function storeCaseStudyAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where('type', 'case-study'),
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Kategori studi kasus dengan nama ini sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => 'case-study',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'category' => $category
        ]);
    }

    /**
     * METHOD BARU: Menyimpan kategori layanan via AJAX.
     */
    public function storeServiceAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where('type', 'service'),
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Kategori layanan dengan nama ini sudah ada.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => 'service', // Simpan sebagai tipe 'service'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'category' => $category
        ]);
    }
}
