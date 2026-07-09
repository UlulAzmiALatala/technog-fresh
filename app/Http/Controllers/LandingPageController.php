<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Post;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\SocialLink;

// Menyimpan import ini sebagai referensi syntax untuk kebutuhan mendatang
use App\Models\User;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;

class LandingPageController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->latest()->take(3)->get();
        $posts = Post::with('category')->where('status', 'PUBLISHED')->latest()->take(3)->get();
        $caseStudies = CaseStudy::with('category')->latest()->take(2)->get();

        return view('welcome', compact('services', 'posts', 'caseStudies'));
    }

    public function about()
    {
        return view('public.about');
    }

    /**
     * Menampilkan halaman daftar layanan publik.
     */
    public function services()
    {
        $serviceCategories = Category::where('type', 'service')
            ->whereHas('services')
            ->with(['services' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->get();

        return view('public.services', compact('serviceCategories'));
    }

    /**
     * Menampilkan Halaman Detail Service Spesifik
     */
    public function showService(Service $service)
    {
        $service->load('category');

        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('public.services-show', compact('service', 'relatedServices'));
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

    public function whyChooseUs()
    {
        $caseStudies = CaseStudy::with('category')
            ->latest()
            ->take(3)
            ->get();

        $testimonials = Testimonial::where('is_featured', true)
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('public.why-choose-us', compact('caseStudies', 'testimonials'));
    }

    public function contact()
    {
        $settings = Setting::pluck('value', 'key');
        $socialLinks = SocialLink::orderBy('sort_order')->get();

        return view('public.contact', compact('settings', 'socialLinks'));
    }
}
