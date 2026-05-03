<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('type', 'post')->orderBy('name')->get();

        $query = Post::with('user', 'category')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(15)->withQueryString();

        return view('admin.founder.posts.index', compact('posts', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'modal_form' => 'required|string',
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
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:DRAFT,PUBLISHED',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'modal_form' => 'required|string',
        ]);

        $data = $request->except(['image', 'modal_form']);
        $data['slug'] = Str::slug($request->title) . '-' . $post->id;

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('post_images', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.founder.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
