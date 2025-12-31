<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Service;
use App\Models\Discount; // Untuk fitur diskon
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB; // Untuk keamanan database transaction

class ServiceListController extends Controller
{
    /**
     * Menampilkan halaman katalog layanan untuk client.
     */
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $serviceCategories = Category::where('type', 'service')
            ->with(['services' => function ($query) {
                $query->orderBy('price', 'asc');
            }])
            ->get();

        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = $serviceCategories->firstWhere('slug', $categorySlug);
        }

        $servicesByCategory = [];
        foreach ($serviceCategories as $category) {
            $servicesByCategory[$category->id] = $category->services->groupBy('package_plan');
        }

        return view('client.services.index', compact(
            'serviceCategories',
            'servicesByCategory',
            'selectedCategory'
        ));
    }

    /**
     * Memproses pemesanan dengan dukungan Diskon & Keamanan Transaksi.
     */
    public function order(Request $request, Service $service)
    {
        $originalPrice = (float) $service->price;
        $discountAmount = 0.00;
        $discountCode = null;

        // Logika Validasi Diskon (Case Insensitive)
        if ($request->filled('discount_code')) {
            $inputCode = strtoupper($request->discount_code);

            $discount = Discount::where('code', $inputCode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now()->startOfDay());
                })
                ->first();

            if ($discount && (is_null($discount->max_uses) || $discount->current_uses < $discount->max_uses)) {
                $discountAmount = (float) $discount->amount;
                $discountCode = $discount->code;
            } else {
                return back()->with('error', 'Invalid or expired discount code.');
            }
        }

        $totalPrice = max(0, $originalPrice - $discountAmount);

        // Database Transaction agar data konsisten (Anti-Ghost Bug)
        return DB::transaction(function () use ($service, $totalPrice, $discountCode, $discountAmount) {

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'total_price' => $totalPrice,
                'status' => 'Menunggu Pembayaran',
                'discount_code' => $discountCode,
                'discount_amount' => $discountAmount,
            ]);

            DetailOrder::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'quantity' => 1,
                'price' => $service->price,
            ]);

            if ($discountCode) {
                Discount::where('code', $discountCode)->increment('current_uses');
            }

            $usersToNotify = User::role(['Founder', 'Pemasukan dan Pengeluaran'])->get();
            Notification::send($usersToNotify, new NewOrderNotification($order));

            return redirect()->route('client.payment.choose', $order->id)
                ->with('success', 'Order created successfully!');
        });
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
