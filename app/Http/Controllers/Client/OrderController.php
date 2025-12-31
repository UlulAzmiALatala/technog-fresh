<?php
// Location: app/Http/Controllers/Client/OrderController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display order history with filters, search, and pagination.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->orders()->with('detailOrders.service')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                    ->orWhereHas('detailOrders.service', function ($serviceQuery) use ($searchTerm) {
                        $serviceQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('client.orders', compact('orders'));
    }

    /**
     * Display order details and associated testimonial data.
     */
    public function show(Order $order)
    {
        // Ensure the client can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load testimonial relation for this order
        $order->load('testimonial');

        return view('client.orders.show', compact('order'));
    }

    /**
     * Store a new project review/testimonial from the client.
     */
    public function storeTestimonial(Request $request, Order $order)
    {
        // 1. Security & Authorization Validation
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the order status is 'Completed' (Selesai)
        if ($order->status !== 'Completed' && $order->status !== 'Selesai') {
            return back()->with('error', 'Reviews can only be submitted for completed projects.');
        }

        if ($order->testimonial) {
            return back()->with('error', 'You have already submitted a review for this project.');
        }

        // 2. Input Validation
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);

        // 3. Create New Testimonial
        Testimonial::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'is_featured' => false, // Default to not featured, pending admin approval
        ]);

        // 4. Redirect with Success Message
        return back()->with('success', 'Thank you! Your review has been successfully submitted.');
    }

    /**
     * Generate and download the official receipt/invoice PDF.
     */
    public function downloadInvoice(Order $order)
    {
        // 1. Authorization Check
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validation: Ensure invoice is 'Paid' (Lunas)
        if (optional($order->invoice)->status !== 'Paid' && optional($order->invoice)->status !== 'Lunas') {
            return back()->with('error', 'Payment proof is only available for fully paid orders.');
        }

        // 3. Eager Load required relations for PDF generation
        $order->load(['user', 'invoice.payments', 'detailOrders.service']);

        // 4. Generate dynamic filename
        $filename = 'Invoice-' . $order->invoice->invoice_number . '.pdf';

        // 5. Render Blade view to PDF
        $pdf = Pdf::loadView('client.payment.invoice_pdf', compact('order'));

        // 6. Return as stream or download
        return $pdf->download($filename);
    }
}
