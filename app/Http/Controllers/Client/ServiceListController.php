<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request; // <-- PASTIKAN USE STATEMENT INI ADA
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ServiceListController extends Controller
{
    /**
     * Menampilkan halaman katalog layanan untuk client.
     * Halaman ini sekarang mendukung query parameter '?category=slug-kategori'.
     */
    public function index(Request $request)
    {
        // 1. Ambil slug kategori dari URL, contoh: ?category=it-solution
        $categorySlug = $request->query('category');

        // 2. Ambil semua kategori 'service' beserta relasi layanannya (sudah teroptimasi)
        // Kita juga langsung urutkan service di dalamnya berdasarkan harga termurah
        $serviceCategories = Category::where('type', 'service')
            ->with(['services' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->get();

        // 3. Tentukan kategori mana yang harus aktif saat halaman pertama kali dibuka
        $selectedCategory = null;
        if ($categorySlug) {
            // Jika ada slug di URL, cari kategori yang cocok dari koleksi yang sudah kita ambil
            $selectedCategory = $serviceCategories->firstWhere('slug', $categorySlug);
        }

        // 4. Kelompokkan layanan berdasarkan 'package_plan' untuk setiap kategori
        $servicesByCategory = [];
        foreach ($serviceCategories as $category) {
            $servicesByCategory[$category->id] = $category->services->groupBy('package_plan');
        }

        // 5. Kirim semua data yang dibutuhkan ke view dengan path yang BARU
        return view('client.services.index', compact(
            'serviceCategories',
            'servicesByCategory',
            'selectedCategory' // Variabel ini berisi kategori yang dipilih dari URL atau null
        ));
    }

    /**
     * Memproses pemesanan.
     * (Tidak ada perubahan di method ini)
     */
    public function order(Service $service)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_price' => $service->price,
            'status' => 'Menunggu Pembayaran',
        ]);

        DetailOrder::create([
            'order_id' => $order->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'price' => $service->price,
        ]);

        $usersToNotify = User::role(['Founder', 'Pemasukan dan Pengeluaran'])->get();
        Notification::send($usersToNotify, new NewOrderNotification($order));

        return redirect()->route('client.payment.choose', $order->id);
    }

    /**
     * Menampilkan halaman detail layanan.
     * (Tidak ada perubahan di method ini)
     */
    public function show(Service $service)
    {
        $relatedServices = Service::where('package_plan', $service->package_plan)
            ->where('id', '!=', $service->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('client.services.show', compact('service', 'relatedServices'));
    }
}
