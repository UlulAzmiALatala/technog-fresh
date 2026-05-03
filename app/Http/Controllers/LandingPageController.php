<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Post;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Setting;     // <-- Tambahan Import
use App\Models\SocialLink;  // <-- Tambahan Import

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
        $serviceCategories = Category::where('type', 'service')
            ->whereHas('services')
            ->with(['services' => function ($query) {
                $query->orderBy('price', 'asc');
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
        $caseStudies = CaseStudy::where('status', 'PUBLISHED')->with('category')->latest()->paginate(10);
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
     * Menampilkan halaman "Why Choose Us" dengan data dinamis.
     */
    public function whyChooseUs()
    {
        $caseStudies = CaseStudy::with('category')
            ->latest()
            ->take(3)
            ->get();

        // 2. Ambil testimoni yang ditandai sebagai 'featured'
        $testimonials = Testimonial::where('is_featured', true)
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        // 3. Kirim data caseStudies dan testimonials ke view
        return view('public.why-choose-us', compact('caseStudies', 'testimonials'));
    }

    /**
     * Menampilkan halaman Kontak Publik dengan data dinamis dari Admin Settings
     */
    public function contact()
    {
        // 1. Ambil data settings (berupa array key-value)
        $settings = Setting::pluck('value', 'key');

        // 2. Ambil data social media
        $socialLinks = SocialLink::orderBy('sort_order')->get();

        // 3. Kirim ke view
        return view('public.contact', compact('settings', 'socialLinks'));
    }
}
