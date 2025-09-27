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
        // 1. Ambil semua kategori yang tipenya 'service' dan memiliki setidaknya satu layanan.
        $serviceCategories = Category::where('type', 'service')->whereHas('services')->get();

        // 2. Ambil semua layanan, lalu kelompokkan berdasarkan ID kategori mereka.
        $services = Service::with('category')->get();

        // 3. Kelompokkan layanan berdasarkan category_id, lalu di dalamnya kelompokkan lagi berdasarkan package_plan
        $groupedServices = [];
        $servicesByCategory = $services->groupBy('category_id');

        foreach ($servicesByCategory as $categoryId => $categoryServices) {
            $groupedServices[$categoryId] = $categoryServices->groupBy('package_plan');
        }

        // 4. Kirim data yang sudah terstruktur ke view.
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
