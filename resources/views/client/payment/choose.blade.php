{{-- Lokasi: resources/views/client/payment/choose.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Pesanan #{{ $order->order_id }}
        </h2>
    </x-slot>

    @php
        // Data ini akan disuntikkan ke dalam Alpine component di bawah
        $alpineData = [
            'basePrice' => $order->detailOrders->sum(fn($detail) => $detail->price * $detail->quantity),
            'durationOptions' => $durationOptions,
            'old' => [
                'duration' => old('duration', 'standard'),
                'payment_type' => old('payment_type', 'full'),
                'payment_method' => old('payment_method'),
                'dp_amount' => old('dp_amount', $order->detailOrders->sum(fn($detail) => $detail->price * $detail->quantity) * 0.5),
            ]
        ];
    @endphp

    {{-- Hanya memanggil nama komponen. Logika didefinisikan di <script> di bawah --}}
    <div x-data="paymentPage">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <x-payment-steps :step="1" />

                <form action="{{ route('client.payment.save_notes_and_proceed', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                        <div class="lg:col-span-3 space-y-6">
                            
                            {{-- Bagian Pilihan Durasi Pengerjaan --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">1. Pilih Durasi Pengerjaan</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <template x-if="!durationOptions || Object.keys(durationOptions).length === 0">
                                        <div class="p-4 text-center text-sm text-red-700 bg-red-100 rounded-lg">
                                            Konfigurasi durasi untuk layanan ini tidak ditemukan. Silakan hubungi admin.
                                        </div>
                                    </template>
                                    
                                    <template x-for="(option, key) in durationOptions" :key="key">
                                        <div @click="selectedDuration = key" :class="selectedDuration === key ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200">
                                            <div class="flex items-center">
                                                <input type="radio" name="duration" :value="key" x-model="selectedDuration" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <div class="ml-3 flex-grow">
                                                    <label class="block text-sm font-medium text-gray-900" x-text="`${option.label} (${option.days} Hari)`"></label>
                                                    <p class="text-xs text-gray-500" x-text="key === 'standard' ? 'Durasi pengerjaan normal' : 'Pengerjaan dipercepat dengan biaya tambahan'"></p>
                                                </div>
                                                <div class="text-sm font-semibold text-gray-800 text-right">
                                                    <span x-show="key !== 'standard'" class="text-green-600" x-text="`+ Rp ${(basePrice * option.multiplier - basePrice).toLocaleString('id-ID')}`"></span>
                                                    <span x-show="key === 'standard'" class="text-gray-600" x-text="`Rp ${basePrice.toLocaleString('id-ID')}`"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- Bagian Tipe Pembayaran --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">2. Tentukan Tipe Pembayaran</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div @click="paymentType = 'full'" :class="paymentType === 'full' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center">
                                        <input type="radio" name="payment_type" value="full" x-model="paymentType" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <label class="block text-sm font-medium text-gray-900">Bayar Lunas (Full Payment)</label>
                                            <p class="text-xs text-gray-500">Selesaikan seluruh tagihan sekarang.</p>
                                        </div>
                                    </div>
                                    <div @click="paymentType = 'dp'" :class="paymentType === 'dp' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200">
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_type" value="dp" x-model="paymentType" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <div class="ml-3">
                                                <label class="block text-sm font-medium text-gray-900">Uang Muka (Down Payment)</label>
                                                <p class="text-xs text-gray-500">Bayar sebagian dulu (minimal 50%).</p>
                                            </div>
                                        </div>
                                        
                                        {{-- UI untuk input DP dengan slider dan tombol --}}
                                        <div x-show="paymentType === 'dp'" x-transition class="mt-4 pt-4 border-t border-gray-200 space-y-4">
                                            <div>
                                                <label for="dp_amount" class="block text-sm font-medium text-gray-700">Jumlah DP</label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                                                    {{-- (DIPERBAIKI) Mengganti .debounce dengan .lazy untuk UX yang lebih baik --}}
                                                    <input type="number" id="dp_amount" name="dp_amount" x-model.lazy.number="dpAmount" class="block w-full rounded-none border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="10000">
                                                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-800 text-sm font-semibold" x-text="`${dpPercentage.toFixed(0)}%`"></span>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="range" x-model.number="dpPercentage" min="50" max="100" step="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="setDpPercentage(50)" :class="dpPercentage === 50 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">50%</button>
                                                <button type="button" @click="setDpPercentage(75)" :class="dpPercentage === 75 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">75%</button>
                                                <button type="button" @click="setDpPercentage(100)" :class="dpPercentage === 100 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">Lunas</button>
                                            </div>
                                            <x-input-error :messages="$errors->get('dp_amount')" class="mt-2" />
                                        </div>

                                    </div>
                                    <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- Bagian Informasi Tambahan --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">3. Informasi Tambahan</h3>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Pesanan (Opsional)</label>
                                        <p class="text-xs text-gray-500 mb-2">Jika ada instruksi khusus, kredensial, dll.</p>
                                        <textarea id="notes" name="notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Tolong gunakan skema warna biru untuk desain...">{{ old('notes', $order->notes) }}</textarea>
                                    </div>
                                    @if (!auth()->user()->id_card_image)
                                        <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 rounded-r-lg">
                                            <label for="id_card_image" class="block text-sm font-medium text-gray-900">Verifikasi Identitas <span class="text-red-500">*</span></label>
                                            <p class="text-xs text-gray-600 mb-2">Unggah KTP/Passport/NPWP. Diperlukan untuk melanjutkan.</p>
                                            <input type="file" name="id_card_image" id="id_card_image" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                            <x-input-error :messages="$errors->get('id_card_image')" class="mt-2" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Ringkasan Pembayaran --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 sticky top-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>
                                
                                <div class="space-y-3 text-sm border-b border-gray-200 pb-4 mb-4">
                                    @foreach ($order->detailOrders as $detail)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 w-3/4">{{ $detail->service->name }} (x{{ $detail->quantity }})</span>
                                        <span class="font-medium text-right">$ {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</span>
                                    </div>
                                    @endforeach

                                    <div x-show="additionalFee > 0" x-transition class="flex justify-between items-center text-green-600">
                                        <span x-text="`Biaya Pengerjaan ${durationOptions[selectedDuration]?.label}`"></span>
                                        <span class="font-medium" x-text="`+ Rp ${additionalFee.toLocaleString('id-ID')}`"></span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center font-bold text-lg">
                                    <span>Total Harga</span>
                                    <span x-text="`Rp ${finalPrice.toLocaleString('id-ID')}`"></span>
                                </div>

                                <div class="flex justify-between items-center font-bold text-indigo-600 text-xl pt-4 mt-4 border-t border-gray-200">
                                    <span>Total Tagihan</span>
                                    <span x-text="`Rp ${totalToPay.toLocaleString('id-ID')}`"></span>
                                </div>

                                <div class="mt-8">
                                    <h4 class="font-semibold text-gray-800 mb-3">4. Pilih Metode Pembayaran</h4>
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
                                </div>

                                <button type="submit" 
                                    class="mt-8 w-full py-3 px-4 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest transition shadow-lg"
                                    :disabled="!paymentMethod"
                                    :class="{ 'bg-indigo-600 hover:bg-indigo-700 hover:shadow-indigo-500/50 cursor-pointer': paymentMethod, 'bg-gray-400 cursor-not-allowed': !paymentMethod }">
                                    Lanjutkan Pembayaran
                                </button>
                                <p x-show="!paymentMethod" class="text-xs text-center text-gray-500 mt-2">
                                    Silakan pilih metode pembayaran untuk melanjutkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentPage', () => {
                const data = @json($alpineData);

                return {
                    // Data dari Controller
                    basePrice: data.basePrice || 0,
                    durationOptions: data.durationOptions || {},

                    // State UI
                    selectedDuration: data.old?.duration || 'standard',
                    paymentType: data.old?.payment_type || 'full',
                    paymentMethod: data.old?.payment_method || null,
                    dpAmount: data.old?.dp_amount || 0,
                    
                    // State untuk slider persentase
                    dpPercentage: 50,

                    init() {
                        this.syncDpAmountToPercentage(); // Sinkronisasi awal
                        
                        // Watcher untuk sinkronisasi dua arah
                        this.$watch('dpPercentage', (newPercentage) => {
                            const newAmount = Math.round((this.finalPrice * newPercentage) / 100);
                            if (this.dpAmount !== newAmount) {
                                this.dpAmount = newAmount;
                            }
                        });

                        this.$watch('dpAmount', (newAmount) => {
                            this.clampDpAmount();
                            if (this.finalPrice > 0) {
                                const newPercentage = (this.dpAmount / this.finalPrice) * 100;
                                // Hanya update jika perbedaannya signifikan untuk menghindari getaran
                                if (Math.abs(this.dpPercentage - newPercentage) > 0.1) {
                                    this.dpPercentage = newPercentage;
                                }
                            }
                        });

                        this.$watch('finalPrice', () => this.syncDpAmountToPercentage());
                    },
                    
                    // Method untuk tombol cepat
                    setDpPercentage(percent) {
                        this.dpPercentage = percent;
                    },

                    // Sinkronisasi amount ke percentage
                    syncDpAmountToPercentage() {
                        if (this.finalPrice > 0) {
                            const percent = (this.dpAmount / this.finalPrice) * 100;
                            this.dpPercentage = Math.max(50, Math.min(100, percent));
                        }
                    },

                    clampDpAmount() {
                        if (this.paymentType === 'dp') {
                            const minDp = Math.round(this.finalPrice * 0.5);
                            let currentDp = parseFloat(this.dpAmount) || 0;

                            if (currentDp > this.finalPrice) {
                                this.dpAmount = this.finalPrice;
                            } else if (currentDp < minDp) {
                                this.dpAmount = minDp;
                            }
                        }
                    },

                    // Computed Properties (Getter)
                    get currentMultiplier() {
                        if (!this.durationOptions || !this.durationOptions[this.selectedDuration]) {
                            return 1.0;
                        }
                        return this.durationOptions[this.selectedDuration].multiplier;
                    },
                    get finalPrice() {
                        return this.basePrice * this.currentMultiplier;
                    },
                    get additionalFee() {
                        return this.finalPrice - this.basePrice;
                    },
                    get totalToPay() {
                        if (this.paymentType === 'dp') {
                            return this.dpAmount;
                        }
                        return this.finalPrice;
                    }
                }
            });
        });
    </script>
</x-app-layout>

