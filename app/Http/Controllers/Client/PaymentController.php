<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // <-- PENTING: Import DB facade
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Menghasilkan opsi durasi dengan logika harga custom dari admin.
     * Harga diambil dari kolom 'negotiated_price' di tabel order.
     */
    private function generateDurationOptions(Order $order)
    {
        $service = $order->detailOrders->first()->service;
        if (!$service || !$service->estimated_duration) {
            return [];
        }

        $basePrice = $order->detailOrders->sum(fn($detail) => $detail->price * $detail->quantity);
        $options = [];

        // Opsi Standard selalu ada dan menggunakan harga dasar
        $options['standard'] = [
            'days' => $service->estimated_duration,
            'label' => 'Standard',
            'price' => $basePrice
        ];

        // Opsi Cepat sekarang mengambil harga dari kolom 'negotiated_price_fast' di order
        if ($service->duration_fast_multiplier) {
            $options['fast'] = [
                'days' => ceil($service->estimated_duration * $service->duration_fast_multiplier),
                'label' => 'Fast',
                'price' => ($order->negotiated_price_fast !== null) ? $basePrice + $order->negotiated_price_fast : null
            ];
        }

        // Opsi Ekspres sekarang mengambil harga dari kolom 'negotiated_price_express'
        if ($service->duration_express_multiplier) {
            $options['express'] = [
                'days' => ceil($service->estimated_duration * $service->duration_express_multiplier),
                'label' => 'Express',
                'price' => ($order->negotiated_price_express !== null) ? $basePrice + $order->negotiated_price_express : null
            ];
        }

        return $options;
    }

    /**
     * Menampilkan halaman pilihan pembayaran.
     */
    public function choosePayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $durationOptions = $this->generateDurationOptions($order);
        return view('client.payment.choose', compact('order', 'durationOptions'));
    }

    /**
     * Menyimpan pilihan pembayaran, durasi, dan diskon.
     */
    public function saveNotesAndProceed(Request $request, Order $order)
    {
        // 1. Validasi Awal & Regenerasi Opsi
        $durationOptions = $this->generateDurationOptions($order);
        $durationKeys = array_keys($durationOptions);

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:5000',
            'duration' => 'required|in:' . implode(',', $durationKeys),
            'payment_type' => 'required|in:full,dp',
            'payment_method' => 'required|in:midtrans,manual',
            'id_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discount_code' => 'nullable|string',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        // 2. Custom Validation: Cek apakah durasi yang dipilih 'terkunci'
        $validator->after(function ($validator) use ($request, $durationOptions) {
            $selectedDurationKey = $request->duration;
            if (isset($durationOptions[$selectedDurationKey]) && $durationOptions[$selectedDurationKey]['price'] === null) {
                $validator->errors()->add(
                    'duration',
                    'This duration option is locked. Please contact admin for a price quote.'
                );
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 3. Kalkulasi Harga
        $selectedDurationKey = $request->duration;
        $selectedDurationData = $durationOptions[$selectedDurationKey];
        $priceBasedOnDuration = $selectedDurationData['price'];

        // --- PERUBAHAN 2.1: Verifikasi diskon dan stok di backend ---
        $discountAmount = 0;
        $discountToApply = null; // Kita simpan objek diskonnya

        if ($request->filled('discount_code')) {
            $discount = Discount::where('code', $request->discount_code)->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhereDate('expires_at', '>=', now());
                })->first();

            if ($discount) {
                // Cek stok sekali lagi (keamanan)
                if (!is_null($discount->max_uses) && $discount->current_uses >= $discount->max_uses) {
                    return back()->withInput()->withErrors(['discount_code' => 'This discount code has just run out of stock. Please try again.']);
                }

                $discountAmount = $discount->amount;
                $discountToApply = $discount; // Simpan objek untuk di-increment nanti
            }
            // Jika diskon tidak valid, $discountAmount tetap 0, order tetap lanjut.
        }

        $finalPrice = max(0, $priceBasedOnDuration - $discountAmount);
        $dueDate = now()->addDays($selectedDurationData['days']);

        // 4. Validasi DP berdasarkan Final Price
        $minDp = $finalPrice * 0.5;
        $request->validate([
            'dp_amount' => "required_if:payment_type,dp|numeric|min:{$minDp}|max:{$finalPrice}",
        ]);

        // 5. Simpan file KTP jika ada
        if ($request->hasFile('id_card_image')) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user && !$user->id_card_image) {
                $path = $request->file('id_card_image')->store('identity_cards', 'public');
                $user->id_card_image = $path;
                $user->save();
            }
        }

        // --- PERUBAHAN 2.2: Gunakan DB Transaction ---
        try {
            DB::beginTransaction();

            // 6. Update Order
            $order->update([
                'notes' => $request->notes,
                'total_price' => $finalPrice,
                'due_date' => $dueDate,
                'delivery_option' => $selectedDurationKey,
                'payment_type' => $request->payment_type,
                'dp_amount' => ($request->payment_type === 'dp') ? $request->dp_amount : null,
                'discount_code' => $discountToApply ? $discountToApply->code : null, // Ambil dari objek
                'discount_amount' => $discountAmount,
            ]);

            // 7. Update Stok Diskon (HANYA JIKA DISKON DIGUNAKAN)
            if ($discountToApply) {
                $discountToApply->increment('current_uses'); // Tambah 1 ke penghitung
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // \Log::error('Discount application failed: ' . $e->getMessage()); // Opsional: logging
            return back()->with('error', 'An error occurred while saving your order. Please try again.');
        }

        // 8. Lanjutkan ke Pembayaran
        $amountToPay = ($request->payment_type === 'dp') ? $request->dp_amount : $finalPrice;

        if ($request->payment_method === 'midtrans') {
            return $this->payWithMidtrans($request, $order, $amountToPay);
        } elseif ($request->payment_method === 'manual') {
            return redirect()->route('client.payment.create', ['order' => $order, 'amount' => $amountToPay]);
        }

        return back()->with('error', 'Invalid payment method.');
    }

    /**
     * Endpoint API untuk validasi kode diskon dari frontend.
     */
    public function validateDiscountCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['valid' => false, 'message' => 'Invalid request.'], 400);
        }

        $discount = Discount::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhereDate('expires_at', '>=', now());
            })->first();

        if (!$discount) {
            return response()->json(['valid' => false, 'message' => 'Invalid or expired discount code.']);
        }

        // --- PERUBAHAN 1.1: Cek Stok Diskon ---
        if (!is_null($discount->max_uses) && $discount->current_uses >= $discount->max_uses) {
            return response()->json(['valid' => false, 'message' => 'This discount code has reached its usage limit.']);
        }
        // --- Akhir Perubahan ---

        return response()->json([
            'valid' => true,
            'code' => $discount->code,
            'amount' => $discount->amount,
        ]);
    }


    // --- FUNGSI-FUNGSI DI BAWAH INI TIDAK ADA PERUBAHAN ---

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

    public function create(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $amountToPay = $request->query('amount', $order->total_price);
        return view('client.payment.manual', compact('order', 'amountToPay'));
    }

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

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $paymentAmount,
            'payment_proof' => $path,
            'method' => 'Transfer Bank',
            'payment_date' => null,
        ]);

        $order->update(['status' => 'Menunggu Konfirmasi']);
        return redirect()->route('client.payment.pending', $order->id);
    }

    public function pending(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
        if ($order->status !== 'Menunggu Konfirmasi') {
            return redirect()->route('client.payment.success', $order);
        }
        return view('client.payment.pending', compact('order'));
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'Menunggu Konfirmasi') {
            return redirect()->route('client.payment.pending', $order);
        }

        if ($order->status === 'Menunggu Pembayaran') {
            return redirect()->route('client.payment.choose', $order);
        }

        return view('client.payment.success', compact('order'));
    }


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
