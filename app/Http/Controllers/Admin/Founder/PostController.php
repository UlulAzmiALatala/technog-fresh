<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user')->latest();

        // Filter berdasarkan pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->get();

        return view('admin.founder.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('type', 'post')->get();
        return view('admin.founder.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id', // Validasi baru
        ]);

        $data = $request->except('image');
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('post_images', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel baru berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // PERBAIKAN: Ambil hanya kategori dengan tipe 'post'
        $categories = Category::where('type', 'post')->get();
        return view('admin.founder.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id', // Validasi baru
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title) . '-' . $post->id; // Gunakan ID post agar slug stabil

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('post_images', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar terkait jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
