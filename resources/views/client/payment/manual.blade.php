{{-- Lokasi: resources/views/client/payment/manual.blade.php (FINAL POLISHED EDITION) --}}

<x-app-layout>
    @php
        $currencyMatrix = [
            'IDR' => 15450,
            'SGD' => 1.34,
            'EUR' => 0.92,
            'GBP' => 0.79,
            'JPY' => 148.20,
            'AUD' => 1.52,
            'MYR' => 4.73,
        ];
    @endphp

    <div x-data="{ 
        imagePreview: null, 
        usdAmount: {{ $amountToPay }},
        selectedCurrency: 'USD',
        rates: @js($currencyMatrix),
        convertedAmount: {{ $amountToPay }},
        
        updateConversion() {
            if (this.selectedCurrency === 'USD') {
                this.convertedAmount = this.usdAmount;
            } else {
                this.convertedAmount = this.usdAmount * this.rates[this.selectedCurrency];
            }
        }
    }" class="flex flex-col min-h-screen bg-[#F9FBFF] font-sans antialiased">
        
        <main class="flex-grow pb-24">
            {{-- NAVIGATION: THE PRESTIGE BAR --}}
            <nav class="bg-white/80 backdrop-blur-2xl border-b border-slate-100 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('client.payment.choose', $order->id) }}" class="group flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-xl hover:bg-indigo-600 hover:border-indigo-600 transition-all duration-500 shadow-sm">
                                <i class="fas fa-arrow-left text-xs text-slate-400 group-hover:text-white transition-colors"></i>
                            </a>
                            <div>
                                <span class="block text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] leading-none mb-1">Confirmation Protocol</span>
                                <h2 class="text-xl font-black text-slate-900 tracking-tighter uppercase italic">Verification Detail</h2>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 bg-slate-900 px-4 py-2 rounded-2xl shadow-xl">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">Protocol Active</span>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
                
                <x-payment-steps :step="2" />

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    
                    {{-- SISI KIRI: THE VALUATION ENGINE --}}
                    <div class="lg:col-span-7 space-y-8 animate-in fade-in slide-in-from-bottom-6 duration-1000">
                        
                        <section class="bg-white rounded-[3rem] p-10 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.04)] border border-slate-50 relative overflow-hidden">
                            <div class="absolute -top-24 -right-24 w-80 h-80 bg-indigo-50 rounded-full blur-[120px] opacity-60"></div>
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 relative z-10">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">Transfer Parameters</h3>
                                
                                {{-- MULTI-CURRENCY SELECTOR (FIXED DOUBLE ARROW) --}}
                                <div class="relative inline-block">
                                    <select x-model="selectedCurrency" @change="updateConversion()" 
                                            class="block w-full cursor-pointer bg-slate-50 border-none rounded-2xl px-6 py-3.5 pr-12 text-[10px] font-black tracking-widest text-slate-900 focus:ring-2 focus:ring-indigo-500 transition-all"
                                            style="-webkit-appearance: none; -moz-appearance: none; appearance: none;">
                                        <option value="USD">UNITED STATES (USD)</option>
                                        <option value="IDR">INDONESIA (IDR)</option>
                                        <option value="SGD">SINGAPORE (SGD)</option>
                                        <option value="EUR">EUROPE (EUR)</option>
                                        <option value="GBP">UNITED KINGDOM (GBP)</option>
                                        <option value="JPY">JAPAN (JPY)</option>
                                        <option value="AUD">AUSTRALIA (AUD)</option>
                                        <option value="MYR">MALAYSIA (MYR)</option>
                                    </select>
                                    
                                </div>
                            </div>

                            {{-- VALUATION DISPLAY --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12 relative z-10">
                                <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 shadow-inner">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-3">Base Valuation</span>
                                    <p class="text-4xl font-black text-slate-900 tracking-tighter italic font-mono">$ {{ number_format($amountToPay, 2, '.', ',') }}</p>
                                    <span class="text-[8px] font-bold text-slate-300 uppercase mt-3 block tracking-tighter italic">Standard USD Equivalent</span>
                                </div>

                                <div class="p-8 bg-indigo-600 rounded-[2.5rem] text-white shadow-2xl shadow-indigo-100 relative overflow-hidden group">
                                    <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:rotate-12 transition-transform duration-700">
                                        <i class="fas fa-calculator text-5xl"></i>
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-widest block mb-3 opacity-70" x-text="`Local Projection (${selectedCurrency})`"></span>
                                    <p class="text-4xl font-black tracking-tighter italic font-mono" x-text="(selectedCurrency === 'IDR' ? 'Rp ' : (selectedCurrency === 'USD' ? '$ ' : (selectedCurrency === 'SGD' ? 'S$ ' : (selectedCurrency === 'JPY' ? '¥ ' : '')))) + convertedAmount.toLocaleString('en-US', {minimumFractionDigits: 2})"></p>
                                    <span class="text-[8px] font-bold mt-3 block opacity-50 uppercase tracking-tighter" x-text="`FX Rate: 1 USD = ${rates[selectedCurrency] || 1} ${selectedCurrency}`"></span>
                                </div>
                            </div>

                            {{-- BANK DETAILS --}}
                            <div class="space-y-6 relative z-10">
                                <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Destination Pipeline</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="p-8 bg-white border-2 border-indigo-600 rounded-[2.5rem] shadow-xl shadow-indigo-500/5 relative overflow-hidden">
                                        <div class="absolute top-0 right-0 p-6 opacity-[0.03]">
                                            <i class="fas fa-university text-6xl"></i>
                                        </div>
                                        <p class="text-[9px] font-black text-indigo-600 uppercase mb-5 tracking-widest italic flex items-center">
                                            <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full mr-2 animate-pulse"></span>
                                            Operational Account
                                        </p>
                                        <h4 class="text-2xl font-black text-slate-900 mb-1 tracking-tight">BANK ABC</h4>
                                        <p class="text-xl font-black text-slate-900 tracking-[0.2em] font-mono">1234 5678 90</p>
                                        <p class="text-[9px] font-black text-slate-400 uppercase italic mt-6">TechnoG Solutions Global Ltd.</p>
                                    </div>

                                    <div class="p-8 bg-slate-50 border border-slate-100 rounded-[2.5rem] flex flex-col justify-center">
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-5 italic">Audit Window</span>
                                        <div class="space-y-5">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-bolt text-indigo-500 text-xs"></i>
                                                </div>
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter leading-none">Instant AI Receipt Validation</span>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                                    <i class="fas fa-clock text-indigo-500 text-xs"></i>
                                                </div>
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter leading-none">1-24h Confirmation Window</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- SISI KANAN: UPLOAD TERMINAL --}}
                    <div class="lg:col-span-5 space-y-8 animate-in fade-in slide-in-from-right-10 duration-1000">
                        <div class="bg-white rounded-[3.5rem] p-10 shadow-[0_60px_100px_-30px_rgba(0,0,0,0.06)] border border-slate-50">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-12">Authorization Terminal</h3>

                            <form action="{{ route('client.payment.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $amountToPay }}">

                                <div class="space-y-10">
                                    {{-- UPLOAD INTERFACE --}}
                                    <label for="payment_proof" class="relative group block cursor-pointer">
                                        <div :class="imagePreview ? 'border-indigo-600 bg-white ring-4 ring-indigo-50' : 'border-slate-100 bg-slate-50/50 hover:border-indigo-300 hover:bg-white'" 
                                             class="w-full h-80 rounded-[3rem] border-2 border-dashed flex flex-col items-center justify-center transition-all duration-700 overflow-hidden relative">
                                            
                                            <template x-if="!imagePreview">
                                                <div class="text-center p-10 group">
                                                    <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl border border-slate-50 group-hover:scale-110 transition-transform duration-700">
                                                        <i class="fas fa-upload text-indigo-500 text-xl group-hover:animate-bounce"></i>
                                                    </div>
                                                    <p class="text-xs font-black text-slate-900 uppercase tracking-widest mb-1">Upload Receipt</p>
                                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter italic">Max Size: 2.0MB / PNG, JPG</p>
                                                </div>
                                            </template>

                                            <template x-if="imagePreview">
                                                <div class="relative w-full h-full group/image">
                                                    <img :src="imagePreview" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 group-hover/image:opacity-100 transition-all duration-500 flex flex-col items-center justify-center">
                                                        <span class="text-[9px] font-black text-white uppercase tracking-[0.2em] border border-white/30 px-6 py-2 rounded-full">Replace Object</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <input @change="imagePreview = URL.createObjectURL($event.target.files[0])" type="file" name="payment_proof" id="payment_proof" class="hidden" required>
                                    </label>

                                    <div class="pt-6 space-y-6">
                                        <div class="p-5 bg-slate-50 rounded-3xl border border-slate-100">
                                            <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight leading-relaxed">
                                                By proceeding, you verify that the transfer has been completed accurately. False submissions may lead to account suspension.
                                            </p>
                                        </div>

                                        {{-- PRESTIGE BUTTON --}}
                                        <button type="submit" class="group relative w-full overflow-hidden py-6 bg-slate-900 rounded-[2rem] transition-all duration-700 hover:bg-indigo-600 shadow-2xl shadow-slate-300 active:scale-95">
                                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/5 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                            <div class="relative flex items-center justify-center space-x-4">
                                                <span class="text-[11px] font-black text-white uppercase tracking-[0.3em] italic">Final Confirmation</span>
                                                <i class="fas fa-check text-[9px] text-emerald-400 group-hover:scale-150 transition-transform"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        @include('layouts.partials.app-footer')
    </div>
</x-app-layout>