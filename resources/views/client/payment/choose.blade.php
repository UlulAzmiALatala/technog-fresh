{{-- Lokasi: resources/views/client/payment/choose.blade.php (THE VALUATION EDITION) --}}

<x-app-layout>
    @php
        $alpineData = [
            'basePrice' => (float) $order->detailOrders->sum(fn($detail) => (float) $detail->price * $detail->quantity),
            'durationOptions' => $durationOptions, 
            'orderId' => $order->id,
            'old' => [
                'duration' => old('duration', 'standard'),
                'payment_type' => old('payment_type', 'full'),
                'payment_method' => old('payment_method'),
                'dp_amount' => (float) old('dp_amount', $order->detailOrders->sum(fn($detail) => (float) $detail->price * $detail->quantity) * 0.5),
            ]
        ];
    @endphp

    <div x-data="paymentPage" class="flex flex-col min-h-screen bg-[#F8FAFC] font-sans antialiased">
        
        <main class="flex-grow pb-24">
            {{-- HEADER: THE MINIMALIST --}}
            <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('client.orders.index') }}" class="group flex items-center justify-center w-10 h-10 bg-slate-50 rounded-xl hover:bg-indigo-600 transition-all duration-500 shadow-sm border border-slate-100">
                                <i class="fas fa-chevron-left text-xs text-slate-400 group-hover:text-white"></i>
                            </a>
                            <div>
                                <span class="block text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em] leading-none mb-1">Terminal Checkout</span>
                                <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase">Order #{{ $order->id }}</h2>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 bg-emerald-50 px-4 py-2 rounded-2xl border border-emerald-100">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Active Session</span>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
                
                <x-payment-steps :step="1" />

                <form action="{{ route('client.payment.save_notes_and_proceed', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- KABEL DATA (HIDDEN INPUTS) --}}
                    <input type="hidden" name="duration" :value="selectedDuration">
                    <input type="hidden" name="payment_type" :value="paymentType">
                    <input type="hidden" name="payment_method" :value="paymentMethod">
                    <input type="hidden" name="dp_amount" :value="dpAmount">
                    <input type="hidden" name="discount_code" :value="appliedDiscount.code">
                    <input type="hidden" name="discount_amount" :value="appliedDiscount.amount">

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                        
                        {{-- SISI KIRI: CONFIGURATOR --}}
                        <div class="lg:col-span-8 space-y-12">
                            
                            {{-- 01. EXECUTION STRATEGY --}}
                            <section class="animate-in fade-in slide-in-from-bottom-6 duration-700">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em]">01. Execution Strategy</h3>
                                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100 uppercase tracking-tighter italic">Selection Required</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <template x-for="(option, key) in durationOptions" :key="key">
                                        <div @click="selectDuration(key, option)"
                                             :class="{
                                                'border-indigo-600 bg-white shadow-[0_25px_50px_-12px_rgba(79,70,229,0.15)] ring-1 ring-indigo-600/10 scale-[1.02]': selectedDuration === key,
                                                'border-slate-100 bg-white opacity-40 grayscale blur-[1.2px] scale-95': key !== 'standard' && option.price === null,
                                                'border-slate-100 bg-white hover:border-indigo-200 hover:shadow-lg': selectedDuration !== key && option.price !== null
                                             }"
                                             class="relative p-6 rounded-[2.5rem] border-2 transition-all duration-500 cursor-pointer group">
                                            
                                            <div class="flex flex-col h-full justify-between">
                                                <div class="mb-8">
                                                    <div :class="selectedDuration === key ? 'bg-indigo-600 text-white' : 'bg-slate-50 text-indigo-600'" class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5 shadow-sm transition-all duration-500 group-hover:-rotate-6">
                                                        <i :class="key === 'standard' ? 'fa-bolt' : 'fa-rocket'" class="fas text-sm"></i>
                                                    </div>
                                                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight" x-text="option.label"></h4>
                                                    <p class="text-[11px] font-bold text-slate-400 mt-1" x-text="`${option.days} Work Days`"></p>
                                                </div>
                                                <div class="pt-5 border-t border-slate-50 flex items-center justify-between">
                                                    <span class="text-sm font-black text-slate-900" x-text="option.price === null ? 'LOCKED' : `$ ${parseFloat(option.price).toLocaleString()}`"></span>
                                                    <i x-show="selectedDuration === key" class="fas fa-check-circle text-indigo-600"></i>
                                                </div>
                                            </div>

                                            <template x-if="key !== 'standard' && option.price === null">
                                                <div class="absolute inset-0 z-20 flex flex-col items-center justify-center">
                                                    <i class="fas fa-lock text-slate-400 mb-2"></i>
                                                    <span class="bg-slate-900 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-xl">Quote Needed</span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    {{-- NEGO CARD --}}
                                    <div @click="isLockedModalOpen = true" class="p-6 rounded-[2.5rem] border-2 border-dashed border-slate-200 hover:border-indigo-400 bg-white transition-all duration-500 cursor-pointer group">
                                        <div class="flex flex-col h-full justify-between">
                                            <div>
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-50/50 flex items-center justify-center mb-5 border border-indigo-100 group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-handshake text-indigo-500"></i>
                                                </div>
                                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight">Custom Plan</h4>
                                                <p class="text-[11px] font-bold text-slate-400 mt-1 italic">Negotiate Timeline</p>
                                            </div>
                                            <div class="pt-5 text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center">
                                                START CHAT <span class="ml-2 transition-transform group-hover:translate-x-1">&rarr;</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            {{-- 02. BILLING ARCHITECTURE --}}
                            <section class="animate-in fade-in slide-in-from-bottom-6 duration-700 delay-150">
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">02. Billing Architecture</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div @click="paymentType = 'full'" 
                                         :class="paymentType === 'full' ? 'border-indigo-600 bg-white shadow-xl shadow-indigo-500/5 ring-1 ring-indigo-600/5' : 'border-slate-100 bg-white hover:border-slate-200'"
                                         class="p-7 rounded-[2.5rem] border-2 cursor-pointer transition-all duration-500 flex items-center space-x-6">
                                        <div :class="paymentType === 'full' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'bg-slate-50 text-slate-400'" class="w-14 h-14 rounded-[1.5rem] flex items-center justify-center transition-all">
                                            <i class="fas fa-wallet text-base"></i>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-black text-slate-900 uppercase tracking-tight">Full Payment</span>
                                            <span class="text-[11px] font-bold text-slate-400">Total upfront initiation</span>
                                        </div>
                                    </div>

                                    <div @click="paymentType = 'dp'" 
                                         :class="paymentType === 'dp' ? 'border-indigo-600 bg-white shadow-xl shadow-indigo-500/5 ring-1 ring-indigo-600/5' : 'border-slate-100 bg-white hover:border-slate-200'"
                                         class="p-7 rounded-[2.5rem] border-2 cursor-pointer transition-all duration-500 flex items-center space-x-6">
                                        <div :class="paymentType === 'dp' ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'bg-slate-50 text-slate-400'" class="w-14 h-14 rounded-[1.5rem] flex items-center justify-center transition-all">
                                            <i class="fas fa-percentage text-base"></i>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-black text-slate-900 uppercase tracking-tight">Milestone DP</span>
                                            <span class="text-[11px] font-bold text-slate-400">Start with partial deposit</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- COMPACT LIGHT SLIDER --}}
                                <div x-show="paymentType === 'dp'" x-transition:enter="duration-500" class="mt-8 p-10 bg-white rounded-[3rem] border border-slate-100 shadow-inner">
                                    <div class="flex justify-between items-center mb-10">
                                        <div class="bg-indigo-50 px-4 py-2 rounded-2xl border border-indigo-100">
                                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600 mb-1">Upfront Commitment</h4>
                                            <p class="text-3xl font-black text-slate-900 tracking-tighter" x-text="`$ ${dpAmount.toLocaleString('en-US', {minimumFractionDigits: 2})}`"></p>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-5xl font-black text-slate-100" x-text="`${dpPercentage}%` text-right"></span>
                                        </div>
                                    </div>
                                    <input type="range" x-model.number="dpPercentage" min="50" max="100" class="w-full h-1 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                </div>
                            </section>

                            {{-- 03. BRIEF --}}
                            <section class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm animate-in fade-in slide-in-from-bottom-6 duration-700 delay-300">
                                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8">03. Project Specifications</h3>
                                <div class="space-y-8">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-900 uppercase tracking-widest mb-4">Briefing Notes</label>
                                        <textarea name="notes" rows="4" class="w-full rounded-[2rem] border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-xs p-7" placeholder="Add specific requirements, credentials, or context...">{{ old('notes', $order->notes) }}</textarea>
                                    </div>
                                    
                                    @if (!auth()->user()->id_card_image)
                                    <div class="p-8 bg-indigo-50/20 rounded-[2.5rem] border border-indigo-100 border-dashed group hover:bg-indigo-50/40 transition-all">
                                        <div class="flex items-center space-x-6">
                                            <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm text-indigo-600 border border-indigo-50">
                                                <i class="fas fa-fingerprint text-xl"></i>
                                            </div>
                                            <div class="flex-grow">
                                                <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Identity Confirmation (KYC)</p>
                                                <p class="text-[10px] text-slate-400 mb-4">Required for institutional project security.</p>
                                                <input type="file" name="id_card_image" required class="block w-full text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-slate-900 file:text-white cursor-pointer hover:bg-indigo-600 transition-all">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </section>
                        </div>

                        {{-- SISI KANAN: THE VALUATION MATRIX --}}
                        <div class="lg:col-span-4 animate-in fade-in slide-in-from-right-8 duration-700">
                            <div class="sticky top-28 space-y-8">
                                <div class="bg-white rounded-[3.5rem] p-10 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden">
                                    <div class="absolute -top-16 -right-16 w-40 h-40 bg-indigo-50 rounded-full blur-[80px] opacity-60"></div>
                                    
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-12">Valuation Summary</h3>
                                    
                                    <div class="space-y-5 mb-12">
                                        {{-- BREAKDOWN LIST --}}
                                        @foreach ($order->detailOrders as $detail)
                                        <div class="flex justify-between items-center">
                                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tighter">{{ $detail->service->name }} (x{{ $detail->quantity }})</span>
                                            <span class="text-sm font-black text-slate-900">$ {{ number_format($detail->price * $detail->quantity, 2) }}</span>
                                        </div>
                                        @endforeach

                                        <div x-show="additionalFee > 0" class="flex justify-between items-center text-[11px] font-bold">
                                            <span class="text-slate-400 uppercase tracking-tighter">Expedited Premium</span>
                                            <span class="text-emerald-600 font-black" x-text="`+ $ ${additionalFee.toFixed(2)}` text-right"></span>
                                        </div>

                                        {{-- CALCULATION: POTONGAN HARGA --}}
                                        <div class="pt-6 border-t border-slate-50 space-y-4">
                                            <div class="flex justify-between items-center text-[11px] font-bold">
                                                <span class="text-slate-400 uppercase">Gross Valuation</span>
                                                <span class="text-slate-900 line-through opacity-30" x-show="appliedDiscount.amount > 0" x-text="`$ ${(currentPrice).toLocaleString('en-US', {minimumFractionDigits: 2})}`"></span>
                                                <span class="text-slate-900" x-show="appliedDiscount.amount == 0" x-text="`$ ${(currentPrice).toLocaleString('en-US', {minimumFractionDigits: 2})}`"></span>
                                            </div>

                                            <div x-show="appliedDiscount.amount > 0" class="flex justify-between items-center p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-emerald-700">
                                                <div class="flex items-center space-x-2">
                                                    <i class="fas fa-tags text-[10px]"></i>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">Promotion Applied</span>
                                                </div>
                                                <span class="font-black" x-text="`- $ ${parseFloat(appliedDiscount.amount).toFixed(2)}`"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PROMO INPUT: THE SLEEK V2 --}}
                                    <div class="mb-12">
                                        <div class="bg-slate-50 p-1.5 rounded-[1.8rem] flex items-center border border-slate-100 shadow-inner group-focus-within:border-indigo-300 transition-all">
                                            <input type="text" x-model="discountCode" 
                                                   :disabled="appliedDiscount.code"
                                                   class="bg-transparent border-none focus:ring-0 text-[11px] font-black tracking-[0.2em] px-5 flex-grow placeholder:text-slate-300 transition-all" 
                                                   placeholder="CODE">
                                            <button type="button" @click="applyDiscount" x-show="!appliedDiscount.code" 
                                                    class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-[10px] font-black hover:bg-indigo-600 transition-all shadow-xl active:scale-95">
                                                VERIFY
                                            </button>
                                            <button type="button" @click="removeDiscount" x-show="appliedDiscount.code" 
                                                    class="bg-rose-500 text-white px-4 py-3 rounded-2xl text-[10px] font-black shadow-lg">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <p x-show="discountMessage" class="mt-4 text-[9px] font-black tracking-[0.1em] text-center uppercase" :class="appliedDiscount.code ? 'text-emerald-600' : 'text-rose-500'" x-text="discountMessage"></p>
                                    </div>

                                    <div class="space-y-6 pt-2">
                                        <div class="flex justify-between items-center px-2">
                                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Final Value</span>
                                            <span class="text-xl font-black text-slate-900 tracking-tighter" x-text="`$ ${finalPrice.toLocaleString('en-US', {minimumFractionDigits: 2})}`"></span>
                                        </div>

                                        <div class="bg-indigo-600 rounded-[2.5rem] p-10 text-white text-center shadow-[0_30px_60px_-15px_rgba(79,70,229,0.4)]">
                                            <span class="text-[10px] font-black uppercase tracking-[0.4em] block mb-3 opacity-60">Net Amount Due</span>
                                            <span class="text-5xl font-black tracking-tighter" x-text="`$ ${totalToPay.toLocaleString('en-US', {minimumFractionDigits: 2})}`"></span>
                                        </div>
                                    </div>
                                    
                                    {{-- METHODS --}}
                                    <div class="mt-12 space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <button type="button" @click="paymentMethod = 'midtrans'" :class="paymentMethod === 'midtrans' ? 'border-indigo-600 bg-indigo-50 text-indigo-600 shadow-md' : 'border-slate-100 text-slate-400'" class="p-5 border-2 rounded-[2rem] flex flex-col items-center transition-all duration-500 hover:border-indigo-200">
                                                <i class="fas fa-bolt text-sm mb-2"></i>
                                                <span class="text-[10px] font-black uppercase">Instant</span>
                                            </button>
                                            <button type="button" @click="paymentMethod = 'manual'" :class="paymentMethod === 'manual' ? 'border-indigo-600 bg-indigo-50 text-indigo-600 shadow-md' : 'border-slate-100 text-slate-400'" class="p-5 border-2 rounded-[2rem] flex flex-col items-center transition-all duration-500 hover:border-indigo-200">
                                                <i class="fas fa-university text-sm mb-2"></i>
                                                <span class="text-[10px] font-black uppercase">Manual</span>
                                            </button>
                                        </div>

                                        <button type="submit" :disabled="!paymentMethod" class="w-full mt-8 py-6 bg-slate-900 hover:bg-indigo-600 text-white rounded-[2.5rem] font-black uppercase tracking-[0.3em] text-[11px] shadow-2xl disabled:opacity-10 transition-all duration-700 active:scale-95">
                                            Process Transaction
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        
        @include('layouts.partials.app-footer')

        {{-- CUSTOM MODAL --}}
        <div x-show="isLockedModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md" x-cloak>
            <div @click.away="isLockedModalOpen = false" class="bg-white w-full max-w-sm rounded-[3.5rem] p-12 shadow-2xl text-center border border-white relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-24 h-24 bg-indigo-50 rounded-full blur-2xl"></div>
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-slate-100 shadow-sm text-indigo-600">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter mb-5 leading-tight">Private Architecture</h3>
                <p class="text-xs text-slate-500 font-medium leading-relaxed mb-10 italic px-4">"This configuration requires direct resource management. Please initiate a secure negotiation via live chat."</p>
                <button @click="isLockedModalOpen = false" class="w-full py-5 bg-slate-900 text-white rounded-[1.8rem] font-black uppercase tracking-widest text-[10px] shadow-xl hover:bg-indigo-600 transition-all active:scale-95">Acknowledge</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentPage', () => {
            const data = @js($alpineData);
            return {
                basePrice: parseFloat(data.basePrice) || 0,
                durationOptions: data.durationOptions || {},
                orderId: data.orderId,
                selectedDuration: 'standard',
                paymentType: data.old?.payment_type || 'full',
                paymentMethod: data.old?.payment_method || null,
                dpAmount: parseFloat(data.old?.dp_amount) || 0,
                dpPercentage: 50,
                discountCode: '',
                isApplyingDiscount: false,
                discountMessage: '',
                appliedDiscount: { code: null, amount: 0 },
                isLockedModalOpen: false,

                init() {
                    const initialDuration = data.old?.duration || 'standard';
                    if (this.durationOptions[initialDuration] && this.durationOptions[initialDuration].price !== null) {
                        this.selectedDuration = initialDuration;
                    }
                    this.syncDpAmountToPercentage();
                    this.$watch('dpPercentage', (newP) => { this.dpAmount = parseFloat(((this.finalPrice * newP) / 100).toFixed(2)); });
                    this.$watch('dpAmount', (newA) => {
                        this.clampDpAmount();
                        if (this.finalPrice > 0) { this.dpPercentage = Math.round((newA / this.finalPrice) * 100); }
                    });
                    this.$watch('finalPrice', () => this.syncDpAmountToPercentage());
                },
                applyDiscount() {
                    if (!this.discountCode) return;
                    this.isApplyingDiscount = true;
                    this.discountMessage = 'INITIALIZING SCAN...';
                    fetch('{{ route('client.payment.validate_discount') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ code: this.discountCode, order_id: this.orderId })
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.valid) {
                            this.appliedDiscount = { code: result.code, amount: parseFloat(result.amount) };
                            this.discountMessage = 'UNIT VERIFIED. DISCOUNT ACTIVE.';
                        } else {
                            this.discountMessage = result.message;
                            this.appliedDiscount = { code: null, amount: 0 };
                        }
                    }).finally(() => this.isApplyingDiscount = false);
                },
                removeDiscount() { this.appliedDiscount = { code: null, amount: 0 }; this.discountCode = ''; this.discountMessage = ''; },
                selectDuration(key, option) { if (option.price !== null) { this.selectedDuration = key; } else { this.isLockedModalOpen = true; } },
                syncDpAmountToPercentage() { this.dpAmount = parseFloat(((this.finalPrice * this.dpPercentage) / 100).toFixed(2)); },
                clampDpAmount() {
                    const min = this.finalPrice * 0.5;
                    if (this.dpAmount < min) this.dpAmount = parseFloat(min.toFixed(2));
                    if (this.dpAmount > this.finalPrice) this.dpAmount = parseFloat(this.finalPrice.toFixed(2));
                },
                get currentPrice() { return parseFloat(this.durationOptions[this.selectedDuration]?.price || this.basePrice); },
                get finalPrice() { return Math.max(0, this.currentPrice - this.appliedDiscount.amount); },
                get additionalFee() { return this.currentPrice - this.basePrice; },
                get totalToPay() { return this.paymentType === 'dp' ? this.dpAmount : this.finalPrice; }
            }
        });
    });
    </script>
</x-app-layout>