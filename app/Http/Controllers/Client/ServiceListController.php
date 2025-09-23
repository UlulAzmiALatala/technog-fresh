<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ServiceListController extends Controller
{
    /**
     * Menampilkan halaman katalog layanan untuk client.
     */
    public function index()
    {
        // 1. Ambil semua KATEGORI yang tipenya 'service' untuk dijadikan tab
        $serviceCategories = Category::where('type', 'service')->get();

        // 2. Ambil semua LAYANAN dan eager load relasi kategorinya
        $services = Service::with('category')->latest()->get();

        // 3. Buat struktur data bertingkat: Kelompokkan berdasarkan kategori, lalu di dalamnya kelompokkan lagi berdasarkan paket
        $groupedServices = [];
        foreach ($serviceCategories as $category) {
            $servicesInCategory = $services->where('category_id', $category->id);
            $groupedServices[$category->id] = $servicesInCategory->groupBy('package_plan');
        }

        // 4. Kirim data ke view
        return view('client.services', compact('serviceCategories', 'groupedServices'));
    }

    /**
     * Memproses pemesanan.
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
