@php
    // Ambil data pembayaran terakhir untuk pesanan ini
    $lastPayment = $order->payments()->latest()->first();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Berhasil Dikonfirmasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-payment-steps :step="4" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 md:p-12 text-center">
                    
                    <div class="mb-6">
                        <i class="fas fa-check-circle fa-5x text-green-500"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">
                        @if($order->payment_type == 'dp' && optional($order->invoice)->status == 'Belum Lunas')
                            Uang Muka Diterima!
                        @else
                            Pembayaran Lunas Diterima!
                        @endif
                    </h3>
                    <p class="text-gray-600 mt-2 max-w-lg mx-auto">
                        Terima kasih! Pembayaran untuk <strong>Pesanan #{{ $order->id }}</strong> telah kami konfirmasi. Kami akan segera memproses pesanan Anda.
                    </p>
                    
                    {{-- KOTAK RINCIAN TRANSAKSI --}}
                    <div class="text-left max-w-md mx-auto bg-gray-50 border border-gray-200 rounded-lg p-4 mt-8">
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">ID Pesanan</dt>
                                <dd class="font-semibold">#{{ $order->id }}</dd>
                            </div>
                             <div class="flex justify-between">
                                <dt class="text-gray-600">Tanggal Transaksi</dt>
                                <dd class="font-semibold">
                                    {{-- [PERBAIKAN] Mengonversi string tanggal ke objek Carbon sebelum diformat --}}
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
                                <dt class="text-gray-600">Metode Bayar</dt>
                                <dd class="font-semibold">{{ optional($lastPayment)->method ?? 'N/A' }}</dd>
                            </div>
                            <div class="border-t"></div>
                            <div class="flex justify-between font-bold">
                                <dt class="text-gray-800">
                                    Jumlah Dibayar
                                </dt>
                                <dd class="text-gray-800">
                                    $ {{ number_format(optional($lastPayment)->amount ?? 0, 0, ',', '.') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="mt-10">
                        <a href="{{ route('client.orders') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Riwayat Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>

