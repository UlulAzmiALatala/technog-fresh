<?php
// Lokasi: app/Http/Controllers/Client/OrderController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Testimonial; // 1. Import model Testimonial
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan dengan filter, pencarian, dan paginasi.
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
     * Menampilkan halaman detail pesanan dan data testimoni.
     */
    public function show(Order $order)
    {
        // Pastikan client hanya bisa melihat order miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Eager load relasi testimoni untuk order ini
        $order->load('testimonial');

        // 3. Kirim data order ke view. View akan memeriksa apakah $order->testimonial ada atau tidak.
        return view('client.orders.show', compact('order'));
    }

    /**
     * METHOD BARU: Menyimpan testimoni dari klien.
     */
    public function storeTestimonial(Request $request, Order $order)
    {
        // 1. Validasi Keamanan & Otorisasi
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($order->status !== 'Selesai') {
            return back()->with('error', 'Anda hanya bisa memberikan ulasan untuk proyek yang sudah selesai.');
        }
        if ($order->testimonial) {
            return back()->with('error', 'Anda sudah pernah memberikan ulasan untuk proyek ini.');
        }

        // 2. Validasi Input Form
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:1000',
        ]);

        // 3. Buat Testimoni Baru
        Testimonial::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'is_featured' => false, // Default tidak featured, admin yang akan menentukan
        ]);

        // 4. Redirect Kembali dengan Pesan Sukses
        return back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil dikirim.');
    }

    public function downloadInvoice(Order $order)
    {
        // 1. Otorisasi: Pastikan client hanya bisa melihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Validasi: Pastikan invoice sudah 'Lunas'
        // Kita gunakan optional() agar aman jika relasi invoice belum ada
        if (optional($order->invoice)->status !== 'Lunas') {
            return back()->with('error', 'Bukti pembayaran hanya tersedia untuk order yang sudah lunas.');
        }

        // 3. Eager Load semua relasi yang dibutuhkan untuk PDF
        $order->load('user', 'invoice.payments', 'detailOrders.service');

        // 4. Buat nama file yang dinamis
        $filename = 'invoice-' . $order->invoice->invoice_number . '.pdf';

        // 5. Render view Blade ke PDF
        $pdf = Pdf::loadView('client.payment.invoice_pdf', compact('order'));

        // 6. Kembalikan sebagai download
        return $pdf->download($filename);
    }
}
