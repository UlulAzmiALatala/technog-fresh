{{-- Lokasi: resources/views/client/payment/settlement.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pelunasan Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div x-data="{ paymentMethod: '{{ old('payment_method') }}' }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Komponen Progress Bar --}}
                <x-payment-steps :step="2" />

                <form action="{{ route('client.payment.process_settlement', $order->id) }}" method="POST">
                    @csrf
                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

                        {{-- Kolom Kiri: Ringkasan --}}
                        <div class="lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900">Ringkasan Pelunasan</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between text-base">
                                    <span class="text-gray-600">Total Harga Pesanan</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-base">
                                    <span class="text-gray-600">Sudah Dibayar (DP)</span>
                                    <span class="font-medium text-green-600">- Rp {{ number_format($amountPaid, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-dashed my-4"></div>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-xl text-red-600">Sisa Tagihan</span>
                                    <span class="font-bold text-3xl text-red-600">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Metode Pembayaran --}}
                        <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6">
                             <h3 class="text-lg font-bold text-gray-900 mb-4">Pilih Metode Pelunasan</h3>
                             
                             <div @click="paymentMethod = 'midtrans'" :class="paymentMethod === 'midtrans' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center mb-3">
                                 <input type="radio" name="payment_method" value="midtrans" x-model="paymentMethod" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                 <div class="ml-3">
                                     <p class="text-sm font-medium text-gray-900">Pembayaran Otomatis</p>
                                     <p class="text-xs text-gray-500">GoPay, QRIS, VA, Kartu Kredit, dll.</p>
                                 </div>
                             </div>
                             
                             <div @click="paymentMethod = 'manual'" :class="paymentMethod === 'manual' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center">
                                 <input type="radio" name="payment_method" value="manual" x-model="paymentMethod" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                 <div class="ml-3">
                                     <p class="text-sm font-medium text-gray-900">Transfer Bank Manual</p>
                                     <p class="text-xs text-gray-500">Verifikasi manual oleh admin.</p>
                                 </div>
                             </div>
                             <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />

                             <button type="submit" 
                                 class="mt-8 w-full py-3 px-4 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest transition shadow-lg"
                                 :disabled="!paymentMethod"
                                 :class="{ 'bg-indigo-600 hover:bg-indigo-700 hover:shadow-indigo-500/50 cursor-pointer': paymentMethod, 'bg-gray-400 cursor-not-allowed': !paymentMethod }">
                                 Lunasi Pembayaran
                             </button>
                             <p x-show="!paymentMethod" class="text-xs text-center text-gray-500 mt-2">
                                 Pilih metode pembayaran untuk melanjutkan.
                             </p>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
