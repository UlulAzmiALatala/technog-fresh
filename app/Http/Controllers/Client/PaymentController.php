<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    private function generateDurationOptions(Order $order)
    {
        $service = $order->detailOrders->first()->service;

        if (!$service || !$service->estimated_duration) {
            return [];
        }

        $options = [];

        // 1. Opsi Standard (selalu ada)
        $options['standard'] = [
            'days' => $service->estimated_duration, // Menggunakan kolom Anda
            'label' => 'Standard',
            'multiplier' => 1.0
        ];

        // 2. Opsi Cepat (jika ada multiplier di database)
        if ($service->price_fast_multiplier && $service->duration_fast_multiplier) {
            $options['fast'] = [
                // Bulatkan hari ke atas
                'days' => ceil($service->estimated_duration * $service->duration_fast_multiplier),
                'label' => 'Cepat',
                'multiplier' => $service->price_fast_multiplier
            ];
        }

        // 3. Opsi Ekspres (jika ada multiplier di database)
        if ($service->price_express_multiplier && $service->duration_express_multiplier) {
            $options['express'] = [
                'days' => ceil($service->estimated_duration * $service->duration_express_multiplier),
                'label' => 'Ekspres',
                'multiplier' => $service->price_express_multiplier
            ];
        }

        return $options;
    }

    /**
     * (DIUBAH) Menampilkan halaman pilihan metode pembayaran dengan opsi durasi dinamis.
     */
    public function choosePayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(43);
        }

        // Memanggil fungsi baru untuk generate opsi durasi
        $durationOptions = $this->generateDurationOptions($order);

        // Jika tidak ada opsi durasi yang bisa dibuat (misal: service belum di-setup),
        // bisa ditambahkan logika untuk redirect atau menampilkan error.
        if (empty($durationOptions)) {
            // Contoh: abort(500, 'Konfigurasi layanan ini belum lengkap.');
        }

        return view('client.payment.choose', compact('order', 'durationOptions'));
    }

    /**
     * (DIUBAH) Menyimpan pesanan dengan kalkulasi dari data dinamis.
     */
    public function saveNotesAndProceed(Request $request, Order $order)
    {
        $basePrice = $order->detailOrders->sum(fn($detail) => $detail->price * $detail->quantity);

        // (DIUBAH) Mengambil opsi durasi dinamis untuk validasi
        $durationOptions = $this->generateDurationOptions($order);
        $durationKeys = array_keys($durationOptions);

        $request->validate([
            'notes' => 'nullable|string|max:5000',
            'duration' => 'required|in:' . implode(',', $durationKeys),
            'payment_type' => 'required|in:full,dp',
            'payment_method' => 'required|in:midtrans,manual',
            'id_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // (DIUBAH) Kalkulasi final berdasarkan multiplier dari database
        $selectedDurationKey = $request->duration;
        $selectedDurationData = $durationOptions[$selectedDurationKey];
        $finalPrice = $basePrice * $selectedDurationData['multiplier'];
        $dueDate = now()->addDays($selectedDurationData['days']);

        $minDp = $finalPrice * 0.5;
        $request->validate([
            'dp_amount' => "required_if:payment_type,dp|numeric|min:{$minDp}|max:{$finalPrice}",
        ]);

        if ($request->hasFile('id_card_image')) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user && !$user->id_card_image) {
                $path = $request->file('id_card_image')->store('identity_cards', 'public');
                // (DIPERBAIKI) Menggunakan save() yang lebih robust
                $user->id_card_image = $path;
                $user->save();
            }
        }

        $amountToPay = ($request->payment_type === 'dp') ? $request->dp_amount : $finalPrice;

        $order->update([
            'notes' => $request->notes,
            'total_price' => $finalPrice,
            'due_date' => $dueDate,
            'delivery_option' => $selectedDurationKey,
            'payment_type' => $request->payment_type,
            'dp_amount' => ($request->payment_type === 'dp') ? $request->dp_amount : null,
        ]);

        if ($request->payment_method === 'midtrans') {
            return $this->payWithMidtrans($request, $order, $amountToPay);
        } elseif ($request->payment_method === 'manual') {
            return redirect()->route('client.payment.create', ['order' => $order, 'amount' => $amountToPay]);
        }

        return back()->with('error', 'Metode pembayaran tidak valid.');
    }

    // --- Sisa fungsi-fungsi lainnya (payWithMidtrans, create, store, dll.) tetap sama ---
    // ... (kode dari controller Anda sebelumnya) ...
    /**
     * Menghasilkan Snap Token dengan jumlah pembayaran yang dinamis.
     */
    public function payWithMidtrans(Request $request, Order $order, $amount)
    {
        $isSettlement = ($order->status === 'Diproses' && $order->payment_type === 'dp');

        if ($order->user_id !== Auth::id() || !($order->status === 'Menunggu Pembayaran' || $isSettlement)) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $user = Auth::user();
        $params = [
            'transaction_details' => ['order_id' => $order->id . '-' . time(), 'gross_amount' => $amount],
            'customer_details' => ['first_name' => $user->name, 'email' => $user->email],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            return view('client.payment.midtrans', compact('order'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk konfirmasi pembayaran manual.
     */
    public function create(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $amountToPay = $request->query('amount', $order->total_price);

        return view('client.payment.manual', compact('order', 'amountToPay'));
    }

    /**
     * Menyimpan data konfirmasi pembayaran manual dan redirect ke halaman pending.
     */
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'amount' => 'required|numeric'
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $paymentAmount = $request->amount;

        $invoice = $order->invoice()->firstOrCreate(
            ['order_id' => $order->id],
            [
                'invoice_number' => 'INV-' . time() . '-' . $order->id,
                'amount' => $order->total_price,
                'due_date' => now()->addDays(3),
                'status' => 'Belum Lunas',
            ]
        );

        // INI BAGIAN PENTINGNYA
        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $paymentAmount,
            'payment_proof' => $path,
            'method' => 'Transfer Bank',
            'payment_date' => null, // Secara eksplisit diatur menjadi null
        ]);

        $order->update(['status' => 'Menunggu Konfirmasi']);

        return redirect()->route('client.payment.pending', $order->id);
    }

    /**
     * [PERBAIKAN] Menampilkan halaman menunggu konfirmasi, dengan pengecekan status.
     */
    public function pending(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Jika status BUKAN lagi 'Menunggu Konfirmasi' (misal: sudah 'Diproses' oleh admin),
        // maka otomatis alihkan ke halaman sukses.
        if ($order->status !== 'Menunggu Konfirmasi') {
            return redirect()->route('client.payment.success', $order);
        }

        // Jika status masih 'Menunggu Konfirmasi', tetap tampilkan halaman ini.
        return view('client.payment.pending', compact('order'));
    }

    /**
     * Menampilkan halaman sukses berdasarkan status order dari admin.
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika admin belum memproses (masih menunggu), arahkan kembali ke halaman pending.
        if ($order->status === 'Menunggu Konfirmasi') {
            return redirect()->route('client.payment.pending', $order);
        }

        if ($order->status === 'Menunggu Pembayaran') {
            return redirect()->route('client.payment.choose', $order);
        }

        // Hanya tampilkan halaman sukses (langkah ke-4) jika statusnya sudah 'Diproses' atau 'Selesai'.
        return view('client.payment.success', compact('order'));
    }

    /**
     * Menampilkan halaman pelunasan dengan kalkulasi yang benar.
     */
    public function showSettlementPage(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_type !== 'dp' || optional($order->invoice)->status !== 'Belum Lunas') {
            return redirect()->route('client.orders.show', $order)->with('error', 'Pesanan ini tidak memerlukan pelunasan.');
        }

        $amountPaid = $order->payments()->whereNotNull('payment_date')->sum('payments.amount');
        $remainingAmount = $order->total_price - $amountPaid;

        if ($remainingAmount <= 0) {
            $order->invoice->update(['status' => 'Lunas']);
            return redirect()->route('client.orders.show', $order)->with('info', 'Pesanan ini sudah lunas.');
        }

        return view('client.payment.settlement', compact('order', 'amountPaid', 'remainingAmount'));
    }

    /**
     * Memproses pelunasan dengan kalkulasi yang benar.
     */
    public function processSettlement(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['payment_method' => 'required|in:midtrans,manual']);

        $amountPaid = $order->payments()->whereNotNull('payment_date')->sum('payments.amount');
        $remainingAmount = $order->total_price - $amountPaid;

        if ($remainingAmount <= 0) {
            return redirect()->route('client.orders.show', $order)->with('error', 'Pesanan ini sudah lunas.');
        }

        if ($request->payment_method === 'midtrans') {
            return $this->payWithMidtrans($request, $order, $remainingAmount);
        }

        if ($request->payment_method === 'manual') {
            return redirect()->route('client.payment.create', ['order' => $order, 'amount' => $remainingAmount]);
        }

        return back()->with('error', 'Metode pembayaran tidak valid.');
    }
}
