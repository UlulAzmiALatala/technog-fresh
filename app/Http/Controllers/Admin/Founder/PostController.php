<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;
// [PERBAIKAN] Impor ini untuk menangani validation errors
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // [PERBAIKAN] Ambil kategori 'post' untuk "otak" Alpine.js
        $categories = Category::where('type', 'post')->orderBy('name')->get();

        $query = Post::with('user', 'category')->latest(); // Tambahkan 'category'

        // Filter berdasarkan pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // [PERBAIKAN] Gunakan paginate(), bukan get()
        $posts = $query->paginate(15)->withQueryString();

        // [PERBAIKAN] Kirim $categories ke view
        return view('admin.founder.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // [REFACTOR] Method create() sudah tidak diperlukan, digantikan modal
    // public function create() { ... }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // [REFACTOR] Tambahkan try...catch untuk validation errors
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'status' => 'required|in:DRAFT,PUBLISHED',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category_id' => 'required|exists:categories,id',
                'modal_form' => 'required|string', // Pastikan ini ada
            ]);

            $data = $request->except(['image', 'modal_form']);
            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug($request->title) . '-' . time();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('post_images', 'public');
            }

            Post::create($data);

            return redirect()->route('admin.founder.posts.index')
                ->with('success', 'Artikel baru berhasil disimpan.');
        } catch (ValidationException $e) {
            // Jika validasi gagal, kembali ke index & buka modal yang benar
            return redirect()->route('admin.founder.posts.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', $request->input('modal_form'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    // [REFACTOR] Method edit() sudah tidak diperlukan, digantikan modal
    // public function edit(Post $post) { ... }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // [REFACTOR] Tambahkan try...catch untuk validation errors
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'required|string',
                'status' => 'required|in:DRAFT,PUBLISHED',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category_id' => 'required|exists:categories,id',
                'modal_form' => 'required|string', // Pastikan ini ada
            ]);

            $data = $request->except(['image', 'modal_form']);
            $data['slug'] = Str::slug($request->title) . '-' . $post->id; // Gunakan ID post agar slug stabil

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $request->file('image')->store('post_images', 'public');
            }

            $post->update($data);

            return redirect()->route('admin.founder.posts.index')
                ->with('success', 'Artikel berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Jika validasi gagal, kembali ke index & buka modal yang benar
            return redirect()->route('admin.founder.posts.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', $request->input('modal_form'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // (Logika ini sudah benar, tidak perlu diubah)
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
