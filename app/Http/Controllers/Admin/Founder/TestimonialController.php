<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar semua testimoni dengan pagination.
     */
    public function index()
    {
        // === PERBAIKAN DI SINI ===
        // Kita eager load relasi bersarang: order, dan di dalam order, kita load detailOrders,
        // dan di dalam detailOrders, kita load service.
        $testimonials = Testimonial::with(['user', 'order.detailOrders.service'])
            ->latest()
            ->paginate(15);

        // Ambil semua klien (untuk dropdown modal 'Add')
        $users = User::role('Client')->orderBy('name')->get();

        // === PERBAIKAN DI SINI ===
        // Ambil semua order (untuk dropdown modal 'Add')
        // Kita juga eager load relasi bersarang di sini.
        $orders = Order::with('detailOrders.service')->get();

        return view('admin.founder.testimonials.index', compact('testimonials', 'users', 'orders'));
    }

    /**
     * Menyimpan testimoni baru.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'order_id' => 'required|exists:orders,id',
                'rating' => 'required|integer|min:1|max:5',
                'content' => 'required|string',
                'is_featured' => 'nullable|boolean',
            ]);

            Testimonial::create([
                'user_id' => $request->user_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'content' => $request->content,
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return redirect()->route('admin.founder.testimonials.index')
                ->with('success', 'Testimonial baru berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return redirect()->route('admin.founder.testimonials.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', 'add');
        }
    }

    /**
     * Memperbarui testimoni yang ada.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        try {
            $request->validate([
                'id' => 'required|exists:testimonials,id', // Pastikan ID ada
                'rating' => 'required|integer|min:1|max:5',
                'content' => 'required|string',
                'is_featured' => 'nullable|boolean',
            ]);

            // Temukan testimonial lagi untuk memastikan (atau gunakan $testimonial dari route model binding)
            $testimonialToUpdate = Testimonial::findOrFail($request->id);

            $testimonialToUpdate->update([
                'rating' => $request->rating,
                'content' => $request->content,
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return redirect()->route('admin.founder.testimonials.index')
                ->with('success', 'Testimonial berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->route('admin.founder.testimonials.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_form', 'edit');
        }
    }

    /**
     * Menghapus testimoni.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.founder.testimonials.index')
            ->with('success', 'Testimonial berhasil dihapus.');
    }
}
