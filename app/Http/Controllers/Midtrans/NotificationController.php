<?php
// Lokasi: app/Http/Controllers/Midtrans/NotificationController.php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class NotificationController extends Controller
{
    /**
     * Menangani notifikasi pembayaran dari Midtrans.
     */
    public function handle(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        // Buat instance notifikasi
        $notification = new Notification();

        // Ambil data dari notifikasi
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        // Cari pesanan di database
        $order = Order::find($orderId);

        if ($order) {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // Pembayaran berhasil dan aman
                    $order->update(['status' => 'Selesai']);
                }
            } else if ($transactionStatus == 'settlement') {
                // Pembayaran berhasil
                $order->update(['status' => 'Selesai']);
            } else if ($transactionStatus == 'pending') {
                // Pembayaran masih pending
                // Tidak perlu melakukan apa-apa, biarkan status 'Menunggu Pembayaran'
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Pembayaran gagal atau dibatalkan
                $order->update(['status' => 'Dibatalkan']);
            }
        }

        // Beri respons OK ke Midtrans
        return response()->json(['status' => 'ok']);
    }
}
