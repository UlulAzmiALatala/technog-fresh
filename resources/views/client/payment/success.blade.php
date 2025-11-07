@php
    // Get the last payment record for this order
    $lastPayment = $order->payments()->latest()->first();
@endphp

{{-- 
    --- PENYEMPURNAAN CSS ---
--}}
<style>
    /* ... (CSS Animasi Centang Anda dari file sebelumnya) ... */
    .payment-success-icon {
        width: 5rem; /* 80px */
        height: 5rem; /* 80px */
        transform: scale(0.8);
        opacity: 0;
        animation: scale-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.1s forwards;
    }
    .svg-circle-bg { stroke: #D1FAE5; fill: none; stroke-width: 4; }
    .svg-circle {
        stroke: #10B981; fill: none; stroke-width: 4; stroke-linecap: round;
        stroke-dasharray: 157; stroke-dashoffset: 157;
        transform-origin: 50% 50%;
        animation: draw-circle 0.7s ease-out 0.5s forwards;
    }
    .svg-check {
        stroke: #10B981; fill: none; stroke-width: 5; stroke-linecap: round;
        stroke-dasharray: 36; stroke-dashoffset: 36;
        animation: draw-check 0.4s ease-out 1.2s forwards;
    }
    @keyframes scale-in { to { transform: scale(1); opacity: 1; } }
    @keyframes draw-circle { to { stroke-dashoffset: 0; } }
    @keyframes draw-check { to { stroke-dashoffset: 0; } }

    /* --- TAMBAHAN BARU: Animasi "Glow" --- */
    /* Ini akan kita terapkan pada div pembungkus ikon */
    .icon-wrapper-glow {
        /* Memicu animasi pulse-glow 1.6 detik setelah dimuat (setelah centang selesai) */
        animation: pulse-glow 2s ease-out 1.6s;
    }

    @keyframes pulse-glow {
        0% {
            /* green-500 dengan 0 opacity */
            box-shadow: 0 0 0 0px rgba(16, 185, 129, 0.0);
        }
        30% {
            /* Efek "glow" membesar */
            box-shadow: 0 0 0 25px rgba(16, 185, 129, 0.3);
        }
        100% {
            /* Efek "glow" menghilang */
            box-shadow: 0 0 0 40px rgba(16, 185, 129, 0.0);
        }
    }
</style>
{{-- --- AKHIR PENYEMPURNAAN CSS --- --}}


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Confirmed
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-payment-steps :step="4" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl" 
                 x-data="{ loaded: false }" 
                 x-init="setTimeout(() => loaded = true, 100)">
                <div class="p-8 md:p-12 text-center">
                    
                    {{-- 1. Animasi Ikon (TAMBAHKAN class 'icon-wrapper-glow' & 'rounded-full') --}}
                    <div class="mb-6 h-20 w-20 mx-auto flex items-center justify-center rounded-full icon-wrapper-glow"
                         x-show="loaded"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100">
                        <svg class="payment-success-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="svg-circle-bg" cx="26" cy="26" r="25"/>
                            <circle class="svg-circle" cx="26" cy="26" r="25"/>
                            <polyline class="svg-check" points="14,27 22,35 38,18"/>
                        </svg>
                    </div>
                    
                    {{-- 2. Animasi Judul (Lebih bertenaga: durasi 700ms dan translate-y-4) --}}
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900"
                        x-show="loaded"
                        x-transition:enter="transition ease-out duration-700 delay-200ms"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        @if($order->payment_type == 'dp' && optional($order->invoice)->status == 'Belum Lunas')
                            Down Payment Received!
                        @else
                            Payment Received!
                        @endif
                    </h3>
                    
                    {{-- 3. Animasi Sub-judul (Lebih bertenaga) --}}
                    <p class="text-gray-600 text-lg mt-3 max-w-lg mx-auto"
                       x-show="loaded"
                       x-transition:enter="transition ease-out duration-700 delay-300ms"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0">
                        Thank you! Your payment for <strong>Order #{{ $order->id }}</strong> has been confirmed. We will now begin processing your order.
                    </p>
                    
                    {{-- 4. Animasi Kotak Detail (Lebih bertenaga) --}}
                    <div class="text-left max-w-md mx-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mt-8"
                         x-show="loaded"
                         x-transition:enter="transition ease-out duration-700 delay-400ms"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Order ID</dt>
                                <dd class="font-semibold">#{{ $order->id }}</dd>
                            </div>
                             <div class="flex justify-between">
                                <dt class="text-gray-600">Transaction Date</dt>
                                <dd class="font-semibold">
                                    @if($lastPayment && $lastPayment->payment_date)
                                        {{ \Carbon\Carbon::parse($lastPayment->payment_date)->format('d M Y, H:i') }}
                                    @elseif($lastPayment)
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
                                    Amount Paid
                                </dt>
                                <dd class="text-gray-800">
                                    $ {{ number_format(optional($lastPayment)->amount ?? 0, 2, '.', ',') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    {{-- 5. Animasi Tombol CTA (Lebih bertenaga) --}}
                    <div class="mt-10 space-y-4 sm:space-y-0 sm:flex sm:flex-row-reverse sm:items-center sm:justify-center sm:space-x-4 sm:space-x-reverse"
                         x-show="loaded"
                         x-transition:enter="transition ease-out duration-700 delay-500ms"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        {{-- Tombol CTA Primer (Sudah ada) --}}
                        <a href="{{ route('client.orders.show', $order->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-eye mr-2"></i>
                            View Your Order
                        </a>

                        {{-- Tombol Sekunder (Sudah ada) --}}
                        <a href="{{ route('client.orders') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-transparent text-sm font-semibold text-gray-600 hover:text-gray-900">
                            Back to Order History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>

{{-- --- SCRIPT UNTUK KONFETI (Tidak Berubah) --- --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Tembakkan konfeti setelah animasi checkmark selesai
        setTimeout(() => {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }, 1600); // 1.6 detik
    });
</script>
@endpush