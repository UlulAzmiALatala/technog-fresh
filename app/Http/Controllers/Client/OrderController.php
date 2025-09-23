<?php
// Lokasi: app/Http/Controllers/Client/OrderController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * [PERUBAHAN] Menampilkan riwayat pesanan dengan filter, pencarian, dan paginasi.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Mulai query dengan data pesanan milik user yang login, diurutkan dari terbaru
        $query = $user->orders()->with('detailOrders.service')->latest();

        // Terapkan filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Terapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // [PERBAIKAN] Ganti pencarian ke kolom primary key 'id'
                $q->where('id', 'like', "%{$searchTerm}%")
                    // atau cari di nama layanan melalui relasi
                    ->orWhereHas('detailOrders.service', function ($serviceQuery) use ($searchTerm) {
                        $serviceQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Ambil hasil query dengan paginasi (misal: 10 item per halaman)
        // withQueryString() penting agar filter tetap aktif saat pindah halaman
        $orders = $query->paginate(10)->withQueryString();

        return view('client.orders', compact('orders'));
    }

    /**
     * METHOD BARU: Menampilkan halaman detail pesanan.
     */
    public function show(Order $order)
    {
        // Pastikan client hanya bisa melihat order miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Arahkan ke view detail
        // Pastikan file view ada di resources/views/client/orders/show.blade.php
        return view('client.orders.show', compact('order'));
    }
}
