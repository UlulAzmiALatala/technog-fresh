{{-- Lokasi: resources/views/client/payment/pending.blade.php (English Version) --}}

@php
    // Get the last payment submission for this order
    $lastPayment = $order->payments()->latest()->first();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Waiting for Payment Confirmation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-payment-steps :step="3" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 md:p-12 text-center">
                    
                    <div class="mb-6">
                        <i class="fas fa-hourglass-half fa-5x text-yellow-500 animate-spin" style="animation-duration: 3s;"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Confirmation Sent!</h3>
                    <p class="text-gray-600 mt-2 max-w-lg mx-auto">
                        Thank you! We have received the payment proof for <strong>Order #{{ $order->id }}</strong>. Our team will verify it within <strong>1x24 business hours</strong>.
                    </p>

                    {{-- TRANSACTION DETAILS BOX --}}
                    <div class="text-left max-w-md mx-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mt-8">
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Order ID</dt>
                                <dd class="font-semibold">#{{ $order->id }}</dd>
                            </div>
                             <div class="flex justify-between">
                                <dt class="text-gray-600">Submission Date</dt>
                                <dd class="font-semibold">
                                    @if($lastPayment)
                                        {{ $lastPayment->created_at->format('d M Y, H:i') }}
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Payment Method</dt>
                                <dd class="font-semibold">{{ optional($lastPayment)->method ?? 'N/A' }}</dd>
                            </div>
                            <div class="border-t"></div>
                            <div class="flex justify-between font-bold">
                                <dt class="text-gray-800">
                                    Submitted Amount
                                </dt>
                                <dd class="text-gray-800">
                                    $ {{ number_format(optional($lastPayment)->amount ?? 0, 2, '.', ',') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-10">
                        <a href="{{ route('client.orders') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Order History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>