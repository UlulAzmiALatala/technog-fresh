<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'order.detailOrders.service'])
            ->latest()
            ->paginate(15);

        $users = User::role('Client')->orderBy('name')->get();
        $orders = Order::with('detailOrders.service')->get();

        return view('admin.founder.testimonials.index', compact('testimonials', 'users', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'modal_form' => 'required|string',
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
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'modal_form' => 'required|string',
        ]);

        $testimonial->update([
            'rating' => $request->rating,
            'content' => $request->content,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.founder.testimonials.index')
            ->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.founder.testimonials.index')
            ->with('success', 'Testimonial berhasil dihapus.');
    }
}
