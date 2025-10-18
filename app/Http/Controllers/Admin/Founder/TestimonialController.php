<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar semua testimoni.
     */
    public function index()
    {
        // Ambil semua testimoni, urutkan dari yang terbaru
        // Eager load relasi user dan order untuk menampilkan info klien & proyek
        $testimonials = Testimonial::with(['user', 'order'])
            ->latest()
            ->get();

        return view('admin.founder.testimonials.index', compact('testimonials'));
    }

    /**
     * Memperbarui status 'is_featured' dari sebuah testimoni.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // Toggle (membalik) status is_featured
        // Jika sedang true, akan jadi false, begitu juga sebaliknya.
        $testimonial->is_featured = !$testimonial->is_featured;
        $testimonial->save();

        return back()->with('success', 'Testimonial status has been updated successfully.');
    }
}
