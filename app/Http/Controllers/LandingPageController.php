<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Post;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Models\Category;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil 3 layanan terbaru BESERTA KATEGORINYA
        $services = Service::with('category')->latest()->take(3)->get();

        // Ambil 3 artikel blog terbaru BESERTA KATEGORINYA
        $posts = Post::with('category')->where('status', 'PUBLISHED')->latest()->take(3)->get();

        // Ambil 2 studi kasus terbaru BESERTA KATEGORINYA
        $caseStudies = CaseStudy::with('category')->latest()->take(2)->get();

        return view('welcome', compact('services', 'posts', 'caseStudies'));
    }

    public function about()
    {
        return view('public.about');
    }

    /**
     * Menampilkan halaman layanan publik dengan data yang benar.
     */
    public function services()
    {
        // 1. Ambil semua kategori 'service' dan langsung load relasi 'services' nya.
        // Ini jauh lebih efisien dan scalable.
        $serviceCategories = Category::where('type', 'service')
            ->whereHas('services') // Ini bagus, pertahankan untuk tidak menampilkan kategori kosong
            ->with(['services' => function ($query) {
                $query->orderBy('price', 'asc'); // Urutkan layanan dari harga termurah
            }])
            ->get();

        // 2. Kelompokkan layanan yang sudah di-load berdasarkan package_plan
        $groupedServices = [];
        foreach ($serviceCategories as $category) {
            $groupedServices[$category->id] = $category->services->groupBy('package_plan');
        }

        // 3. Kirim data yang sudah terstruktur ke view.
        return view('public.services', compact('serviceCategories', 'groupedServices'));
    }

    public function portfolio()
    {
        $caseStudies = CaseStudy::with('category')->latest()->paginate(10); // Gunakan paginate jika datanya banyak
        return view('public.portfolio', compact('caseStudies'));
    }

    public function showCaseStudy(CaseStudy $caseStudy)
    {
        return view('public.portfolio-show', compact('caseStudy'));
    }

    public function blog()
    {
        $posts = Post::where('status', 'PUBLISHED')
            ->with('user', 'category')
            ->latest()
            ->paginate(9);

        $categories = Category::where('type', 'post')->get();

        return view('public.blog', compact('posts', 'categories'));
    }

    public function showPost(Post $post)
    {
        if ($post->status !== 'PUBLISHED') {
            abort(404);
        }

        $relatedPosts = Post::where('status', 'PUBLISHED')
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('public.blog-show', compact('post', 'relatedPosts'));
    }

    /**
     * [METHOD BARU] Menampilkan halaman "Why Choose Us".
     */
    public function whyChooseUs()
    {
        // [PERBAIKAN] Hapus filter status karena kolomnya tidak ada
        $caseStudies = CaseStudy::with('category')
            ->latest()
            ->take(3)
            ->get();

        return view('public.why-choose-us', compact('caseStudies'));
    }


    public function contact()
    {
        return view('public.contact');
    }
}
