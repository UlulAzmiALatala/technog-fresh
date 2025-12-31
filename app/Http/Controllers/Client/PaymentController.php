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
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Generate duration options with standard professional labels.
     */
    private function generateDurationOptions(Order $order)
    {
        $service = $order->detailOrders->first()->service;
        if (!$service || !$service->estimated_duration) {
            return [];
        }

        $basePrice = (float) $order->detailOrders->sum(fn($detail) => (float) $detail->price * $detail->quantity);
        $options = [];

        $options['standard'] = [
            'days' => $service->estimated_duration,
            'label' => 'Standard Delivery',
            'price' => $basePrice
        ];

        if ($service->duration_fast_multiplier) {
            $options['fast'] = [
                'days' => (int) ceil($service->estimated_duration * $service->duration_fast_multiplier),
                'label' => 'Fast Delivery',
                'price' => ($order->negotiated_price_fast !== null) ? $basePrice + (float) $order->negotiated_price_fast : null
            ];
        }

        if ($service->duration_express_multiplier) {
            $options['express'] = [
                'days' => (int) ceil($service->estimated_duration * $service->duration_express_multiplier),
                'label' => 'Express Delivery',
                'price' => ($order->negotiated_price_express !== null) ? $basePrice + (float) $order->negotiated_price_express : null
            ];
        }

        return $options;
    }

    public function choosePayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $durationOptions = $this->generateDurationOptions($order);
        return view('client.payment.choose', compact('order', 'durationOptions'));
    }

    public function saveNotesAndProceed(Request $request, Order $order)
    {
        $durationOptions = $this->generateDurationOptions($order);
        $durationKeys = array_keys($durationOptions);

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:5000',
            'duration' => 'required|in:' . implode(',', $durationKeys),
            'payment_type' => 'required|in:full,dp',
            'payment_method' => 'required|in:midtrans,manual',
            'id_card_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discount_code' => 'nullable|string',
        ]);

        $validator->after(function ($validator) use ($request, $durationOptions) {
            $selectedKey = $request->duration;
            if (isset($durationOptions[$selectedKey]) && $durationOptions[$selectedKey]['price'] === null) {
                $validator->errors()->add('duration', 'This delivery plan is currently unavailable. Please contact support.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $selectedDurationData = $durationOptions[$request->duration];
        $priceBasedOnDuration = (float) $selectedDurationData['price'];

        $discountAmount = 0.00;
        $discountToApply = null;

        if ($request->filled('discount_code')) {
            $discount = Discount::where('code', $request->discount_code)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now()->startOfDay());
                })->first();

            if ($discount) {
                if (!is_null($discount->max_uses) && $discount->current_uses >= $discount->max_uses) {
                    return back()->withInput()->withErrors(['discount_code' => 'This discount code has reached its usage limit.']);
                }
                $discountAmount = (float) $discount->amount;
                $discountToApply = $discount;
            }
        }

        $finalPrice = max(0, $priceBasedOnDuration - $discountAmount);
        $dueDate = now()->addDays($selectedDurationData['days']);

        if ($request->hasFile('id_card_image')) {
            $user = Auth::user();
            if ($user && !$user->id_card_image) {
                $user->id_card_image = $request->file('id_card_image')->store('identity_cards', 'public');
                $user->save();
            }
        }

        try {
            DB::beginTransaction();

            $order->update([
                'notes' => $request->notes,
                'total_price' => $finalPrice,
                'due_date' => $dueDate,
                'delivery_option' => $request->duration,
                'payment_type' => $request->payment_type,
                'dp_amount' => ($request->payment_type === 'dp') ? (float) $request->dp_amount : null,
                'discount_code' => $discountToApply ? $discountToApply->code : null,
                'discount_amount' => $discountAmount,
            ]);

            if ($discountToApply) {
                $discountToApply->increment('current_uses');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: Could not finalize the order. Please try again.');
        }

        $amountToPay = ($request->payment_type === 'dp') ? (float) $request->dp_amount : $finalPrice;

        if ($request->payment_method === 'midtrans') {
            return $this->payWithMidtrans($request, $order, $amountToPay);
        }

        return redirect()->route('client.payment.create', ['order' => $order, 'amount' => $amountToPay]);
    }

    public function validateDiscountCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        $discount = Discount::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now()->startOfDay());
            })->first();

        if (!$discount) {
            return response()->json(['valid' => false, 'message' => 'Invalid or expired discount code.']);
        }

        return response()->json([
            'valid' => true,
            'code' => $discount->code,
            'amount' => (float) $discount->amount,
        ]);
    }

    public function payWithMidtrans(Request $request, Order $order, $amount)
    {
        // Standard English status mapping
        $isSettlement = ($order->status === 'Processing' && $order->payment_type === 'dp');

        if ($order->user_id !== Auth::id() || !($order->status === 'Pending Payment' || $isSettlement)) {
            abort(403, 'Unauthorized action.');
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
            return back()->with('error', 'Payment Error: ' . $e->getMessage());
        }
    }

    public function create(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $amountToPay = $request->query('amount', $order->total_price);
        return view('client.payment.manual', compact('order', 'amountToPay'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'amount' => 'required|numeric'
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $invoice = $order->invoice()->firstOrCreate(
            ['order_id' => $order->id],
            [
                'invoice_number' => 'INV-' . time() . '-' . $order->id,
                'amount' => $order->total_price,
                'due_date' => now()->addDays(3),
                'status' => 'Unpaid',
            ]
        );

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_proof' => $path,
            'method' => 'Bank Transfer',
            'payment_date' => null,
        ]);

        // Updated to professional English status
        $order->update(['status' => 'Awaiting Confirmation']);
        return redirect()->route('client.payment.pending', $order->id);
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        return view('client.payment.success', compact('order'));
    }

    /**
     * Generate standard PDF Invoice.
     */
    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['detailOrders.service', 'invoice.payments', 'user']);

        $pdf = Pdf::loadView('client.payment.invoice_pdf', [
            'order' => $order
        ]);

        return $pdf->stream('Invoice-' . $order->invoice->invoice_number . '.pdf');
    }

    public function showSettlementPage(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        if ($order->payment_type !== 'dp') {
            return redirect()->route('client.orders.show', $order)->with('info', 'This order is already fully paid.');
        }

        $amountPaid = (float) $order->payments()->whereNotNull('payment_date')->sum('amount');
        $remainingAmount = (float) $order->total_price - $amountPaid;

        if ($remainingAmount <= 0) {
            return redirect()->route('client.orders.show', $order)->with('success', 'Order is already fully paid.');
        }

        return view('client.payment.settlement', compact('order', 'amountPaid', 'remainingAmount'));
    }

    public function processSettlement(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $request->validate(['payment_method' => 'required|in:midtrans,manual']);

        $amountPaid = (float) $order->payments()->whereNotNull('payment_date')->sum('amount');
        $remainingAmount = (float) $order->total_price - $amountPaid;

        if ($request->payment_method === 'midtrans') {
            return $this->payWithMidtrans($request, $order, $remainingAmount);
        }

        return redirect()->route('client.payment.create', ['order' => $order, 'amount' => $remainingAmount]);
    }
}
