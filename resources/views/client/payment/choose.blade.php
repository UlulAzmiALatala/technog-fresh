{{-- Lokasi: resources/views/client/payment/choose.blade.php (Diperbarui) --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- BAHASA INGGRIS --}}
            Payment for Order #{{ $order->order_id }}
        </h2>
    </x-slot>

    @php
        // Data ini akan disuntikkan ke dalam Alpine component di bawah
        $alpineData = [
            'basePrice' => $order->detailOrders->sum(fn($detail) => $detail->price * $detail->quantity),
            // PERUBAHAN 1.1: Pastikan controller Anda sekarang mengirim 'price' bukan 'multiplier'
            // 'price' bisa bernilai null jika admin belum set harga.
            'durationOptions' => $durationOptions, 
            'orderId' => $order->id, // FITUR 3.1: Mengirim Order ID untuk validasi diskon
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
                    {{-- FITUR 3.2: Menambahkan input tersembunyi untuk data diskon --}}
                    <input type="hidden" name="discount_code" :value="appliedDiscount.code">
                    <input type="hidden" name="discount_amount" :value="appliedDiscount.amount">

                    <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                        <div class="lg:col-span-3 space-y-6">
                            
                            {{-- 1. Bagian Pilihan Durasi Pengerjaan --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                <div class="p-6 border-b border-gray-200">
                                    {{-- BAHASA INGGRIS --}}
                                    <h3 class="text-lg font-bold text-gray-900">1. Select Work Duration</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <template x-if="!durationOptions || Object.keys(durationOptions).length === 0">
                                        <div class="p-4 text-center text-sm text-red-700 bg-red-100 rounded-lg">
                                            {{-- BAHASA INGGRIS --}}
                                            Duration configuration for this service was not found. Please contact admin.
                                        </div>
                                    </template>
                                    
                                    <template x-for="(option, key) in durationOptions" :key="key">
                                        {{-- PERUBAHAN 1.2: Logika UI untuk opsi yang 'terkunci' --}}
                                        <div @click="selectDuration(key, option)"
                                             :class="{
                                                'border-indigo-600 bg-indigo-50': selectedDuration === key,
                                                'border-gray-200': selectedDuration !== key,
                                                'cursor-pointer': option.price !== null,
                                                'cursor-not-allowed opacity-60': option.price === null
                                             }"
                                             class="p-4 border-2 rounded-lg transition-all duration-200">
                                            
                                            <div class="flex items-center">
                                                <input type="radio" name="duration" :value="key" x-model="selectedDuration" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" :disabled="option.price === null">
                                                <div class="ml-3 flex-grow">
                                                    <label class="block text-sm font-medium text-gray-900" x-text="`${option.label} (${option.days} Days)`"></label>
                                                    {{-- BAHASA INGGRIS --}}
                                                    <p class="text-xs text-gray-500" x-text="option.price === null ? 'Price not set. Contact admin for a quote.' : (key === 'standard' ? 'Normal work duration' : 'Expedited work with an additional fee')"></p>
                                                </div>
                                                <div class="text-sm font-semibold text-gray-800 text-right">
                                                    {{-- PERUBAHAN 1.3: Menampilkan harga dari admin atau ikon gembok --}}
                                                    <template x-if="option.price !== null">
                                                        <span class="text-green-600" x-text="`+ $ ${(option.price - basePrice).toLocaleString('en-US')}`"></span>
                                                    </template>
                                                    <template x-if="option.price === null">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                                                        </svg>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- 2. Bagian Tipe Pembayaran --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                {{-- ... (Konten Tipe Pembayaran & Informasi Tambahan sudah diterjemahkan) ... --}}
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">2. Choose Payment Type</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div @click="paymentType = 'full'" :class="paymentType === 'full' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center">
                                        <input type="radio" name="payment_type" value="full" x-model="paymentType" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <label class="block text-sm font-medium text-gray-900">Full Payment</label>
                                            <p class="text-xs text-gray-500">Settle the entire bill now.</p>
                                        </div>
                                    </div>
                                    <div @click="paymentType = 'dp'" :class="paymentType === 'dp' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200">
                                        <div class="flex items-center">
                                            <input type="radio" name="payment_type" value="dp" x-model="paymentType" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            <div class="ml-3">
                                                <label class="block text-sm font-medium text-gray-900">Down Payment</label>
                                                <p class="text-xs text-gray-500">Pay a portion first (min. 50%).</p>
                                            </div>
                                        </div>
                                        
                                        <div x-show="paymentType === 'dp'" x-transition class="mt-4 pt-4 border-t border-gray-200 space-y-4">
                                            <div>
                                                <label for="dp_amount" class="block text-sm font-medium text-gray-700">DP Amount</label>
                                                <div class="mt-1 flex rounded-md shadow-sm">
                                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                                                    <input type="number" id="dp_amount" name="dp_amount" x-model.lazy.number="dpAmount" class="block w-full rounded-none border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="10">
                                                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-800 text-sm font-semibold" x-text="`${dpPercentage.toFixed(0)}%`"></span>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="range" x-model.number="dpPercentage" min="50" max="100" step="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="setDpPercentage(50)" :class="dpPercentage === 50 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">50%</button>
                                                <button type="button" @click="setDpPercentage(75)" :class="dpPercentage === 75 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">75%</button>
                                                <button type="button" @click="setDpPercentage(100)" :class="dpPercentage === 100 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'" class="px-3 py-1 text-xs font-medium rounded-full transition">Full</button>
                                            </div>
                                            <x-input-error :messages="$errors->get('dp_amount')" class="mt-2" />
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
                                </div>
                            </div>
                            
                            {{-- 3. Bagian Informasi Tambahan --}}
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                                <div class="p-6 border-b border-gray-200">
                                    <h3 class="text-lg font-bold text-gray-900">3. Additional Information</h3>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                        <p class="text-xs text-gray-500 mb-2">For special instructions, credentials, etc.</p>
                                        <textarea id="notes" name="notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Please use a blue color scheme for the design...">{{ old('notes', $order->notes) }}</textarea>
                                    </div>
                                    @if (!auth()->user()->id_card_image)
                                        <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 rounded-r-lg">
                                            <label for="id_card_image" class="block text-sm font-medium text-gray-900">Identity Verification <span class="text-red-500">*</span></label>
                                            <p class="text-xs text-gray-600 mb-2">Upload ID Card/Passport. Required to proceed.</p>
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
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Summary</h3>
                                
                                <div class="space-y-3 text-sm border-b border-gray-200 pb-4 mb-4">
                                    @foreach ($order->detailOrders as $detail)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 w-3/4">{{ $detail->service->name }} (x{{ $detail->quantity }})</span>
                                        <span class="font-medium text-right">$ {{ number_format($detail->price * $detail->quantity, 2, '.', ',') }}</span>
                                    </div>
                                    @endforeach

                                    <div x-show="additionalFee > 0" x-transition class="flex justify-between items-center text-green-600">
                                        <span x-text="`Fee for ${durationOptions[selectedDuration]?.label} work`"></span>
                                        <span class="font-medium" x-text="`+ $ ${additionalFee.toLocaleString('en-US')}`"></span>
                                    </div>
                                </div>

                                {{-- FITUR 3.3: Form Input Kode Diskon --}}
                                <div class="space-y-2 border-b border-gray-200 pb-4 mb-4">
                                    <label for="discount_code" class="block text-sm font-medium text-gray-700">Discount Code</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="discountCode" id="discount_code" placeholder="Enter code here" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" :disabled="appliedDiscount.code">
                                        <button type="button" @click="applyDiscount" x-show="!appliedDiscount.code" :disabled="!discountCode || isApplyingDiscount" class="px-4 py-2 text-sm font-semibold rounded-md shadow-sm text-white" :class="isApplyingDiscount ? 'bg-gray-400' : 'bg-indigo-600 hover:bg-indigo-700'">
                                            <span x-show="!isApplyingDiscount">Apply</span>
                                            <span x-show="isApplyingDiscount">...</span>
                                        </button>
                                        <button type="button" @click="removeDiscount" x-show="appliedDiscount.code" class="px-4 py-2 text-sm font-semibold rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                    <p x-show="discountMessage" class="text-xs mt-1" :class="appliedDiscount.code ? 'text-green-600' : 'text-red-600'" x-text="discountMessage"></p>
                                </div>
                                
                                <div x-show="appliedDiscount.amount > 0" x-transition class="flex justify-between items-center text-sm text-red-600">
                                    <span>Discount</span>
                                    <span class="font-medium" x-text="`- $ ${appliedDiscount.amount.toLocaleString('en-US')}`"></span>
                                </div>
                                
                                <div class="flex justify-between items-center font-bold text-lg mt-2">
                                    <span>Total Price</span>
                                    <span x-text="`$ ${finalPrice.toLocaleString('en-US')}`"></span>
                                </div>

                                <div class="flex justify-between items-center font-bold text-indigo-600 text-xl pt-4 mt-4 border-t border-gray-200">
                                    <span>Total to Pay</span>
                                    <span x-text="`$ ${totalToPay.toLocaleString('en-US')}`"></span>
                                </div>

                                <div class="mt-8">
                                    <h4 class="font-semibold text-gray-800 mb-3">4. Select Payment Method</h4>
                                    {{-- ... (Konten Metode Pembayaran sudah diterjemahkan) ... --}}
                                    <div @click="paymentMethod = 'midtrans'" :class="paymentMethod === 'midtrans' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center mb-3">
                                        <input type="radio" name="payment_method" value="midtrans" x-model="paymentMethod" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Automatic Payment</p>
                                            <p class="text-xs text-gray-500">GoPay, QRIS, VA, Credit Card, etc.</p>
                                        </div>
                                    </div>
                                    <div @click="paymentMethod = 'manual'" :class="paymentMethod === 'manual' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'" class="p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 flex items-center">
                                        <input type="radio" name="payment_method" value="manual" x-model="paymentMethod" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Manual Bank Transfer</p>
                                            <p class="text-xs text-gray-500">Manual verification by admin.</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                                </div>

                                <button type="submit" 
                                    class="mt-8 w-full py-3 px-4 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest transition shadow-lg"
                                    :disabled="!paymentMethod"
                                    :class="{ 'bg-indigo-600 hover:bg-indigo-700 hover:shadow-indigo-500/50 cursor-pointer': paymentMethod, 'bg-gray-400 cursor-not-allowed': !paymentMethod }">
                                    Proceed to Payment
                                </button>
                                <p x-show="!paymentMethod" class="text-xs text-center text-gray-500 mt-2">
                                    Please select a payment method to continue.
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
                orderId: data.orderId,

                // State UI
                selectedDuration: 'standard',
                paymentType: data.old?.payment_type || 'full',
                paymentMethod: data.old?.payment_method || null,
                dpAmount: data.old?.dp_amount || 0,
                dpPercentage: 50,
                
                // FITUR 3.4: State untuk fitur diskon
                discountCode: '',
                isApplyingDiscount: false,
                discountMessage: '',
                appliedDiscount: { code: null, amount: 0 },

                init() {
                    // PERUBAHAN 1.4: Inisialisasi berdasarkan opsi durasi yang valid
                    const initialDuration = data.old?.duration || 'standard';
                    if (this.durationOptions[initialDuration] && this.durationOptions[initialDuration].price !== null) {
                        this.selectedDuration = initialDuration;
                    } else {
                        this.selectedDuration = 'standard';
                    }

                    this.syncDpAmountToPercentage();
                    
                    this.$watch('dpPercentage', (newPercentage) => {
                        const newAmount = Math.round((this.finalPrice * newPercentage) / 100);
                        if (this.dpAmount !== newAmount) this.dpAmount = newAmount;
                    });
                    this.$watch('dpAmount', (newAmount) => {
                        this.clampDpAmount();
                        if (this.finalPrice > 0) {
                            const newPercentage = (this.dpAmount / this.finalPrice) * 100;
                            if (Math.abs(this.dpPercentage - newPercentage) > 0.1) {
                                this.dpPercentage = newPercentage;
                            }
                        }
                    });
                    this.$watch('finalPrice', () => this.syncDpAmountToPercentage());
                },
                
                // PERUBAHAN 1.5: Method baru untuk memilih durasi
                selectDuration(key, option) {
                    if (option.price === null) {
                        // Ganti dengan modal atau notifikasi yang lebih canggih jika perlu
                        alert('This option requires a custom quote. Please contact our admin via live chat to get a price and unlock this option.');
                        return;
                    }
                    this.selectedDuration = key;
                },

                setDpPercentage(percent) { this.dpPercentage = percent; },
                syncDpAmountToPercentage() { /* ... (logika sama) ... */ },
                clampDpAmount() { /* ... (logika sama) ... */ },

                // FITUR 3.5: Method untuk validasi dan hapus diskon
                applyDiscount() {
                    if (!this.discountCode) return;
                    this.isApplyingDiscount = true;
                    this.discountMessage = '';

                    // Simulasi API call ke backend
                    fetch('{{ route('client.payment.validate_discount') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({
                            code: this.discountCode,
                            order_id: this.orderId
                        })
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.valid) {
                            this.appliedDiscount = { code: result.code, amount: result.amount };
                            this.discountMessage = 'Discount successfully applied!';
                        } else {
                            this.discountMessage = result.message || 'Invalid or expired discount code.';
                            this.appliedDiscount = { code: null, amount: 0 };
                        }
                    })
                    .catch(() => {
                        this.discountMessage = 'An error occurred. Please try again.';
                    })
                    .finally(() => this.isApplyingDiscount = false);
                },

                removeDiscount() {
                    this.appliedDiscount = { code: null, amount: 0 };
                    this.discountCode = '';
                    this.discountMessage = '';
                },

                // Computed Properties (Getter)
                get currentPrice() {
                    if (!this.durationOptions || !this.durationOptions[this.selectedDuration]) {
                        return this.basePrice;
                    }
                    // PERUBAHAN 1.6: Menggunakan `price` dari admin
                    return this.durationOptions[this.selectedDuration].price;
                },
                get finalPrice() {
                    // FITUR 3.6: Mengurangi harga dengan diskon
                    const priceAfterDiscount = this.currentPrice - this.appliedDiscount.amount;
                    return Math.max(0, priceAfterDiscount); // Harga tidak boleh negatif
                },
                get additionalFee() {
                    return this.currentPrice - this.basePrice;
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

    @include('layouts.partials.app-footer')
</x-app-layout>