{{-- Lokasi: resources/views/livewire/client-payment-pending.blade.php (REFINED PRECISION EDITION - NO ITALICS) --}}

<div class="flex flex-col min-h-screen bg-[#FDFDFF] font-sans antialiased text-slate-900 w-full overflow-x-hidden">
    
    <main class="flex-grow w-full" wire:poll.5s>
        
        {{-- HEADER: REFINED MINIMALIST --}}
        <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-50 w-full">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                        <i class="fas fa-fingerprint text-white text-[10px]"></i>
                    </div>
                    <div>
                        <span class="block text-[8px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-0.5">Security Audit</span>
                        <h2 class="text-xs font-black text-slate-900 tracking-tight uppercase">Verification Protocol</h2>
                    </div>
                </div>
                <div class="flex items-center space-x-2 bg-slate-900 px-4 py-1.5 rounded-xl shadow-lg">
                    <div class="w-1 h-1 bg-emerald-400 rounded-full animate-pulse"></div>
                    <span class="text-[8px] font-black text-white uppercase tracking-widest">Active Sync</span>
                </div>
            </div>
        </nav>

        <x-payment-steps :step="3" />

        {{-- CORE LAYOUT --}}
        <div class="max-w-6xl mx-auto px-6 lg:px-8 mb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- LEFT: THE SYNC STATUS (RESIZED & UPRIGHT) --}}
                <div class="lg:col-span-5 flex flex-col items-center lg:items-start space-y-8 animate-in fade-in zoom-in duration-1000">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-indigo-500/5 rounded-full blur-[80px] animate-pulse"></div>
                        
                        <div class="relative w-60 h-60 md:w-80 md:h-80 bg-white rounded-[3.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.04)] border border-slate-50 flex items-center justify-center overflow-hidden">
                            {{-- Rotating Tech Elements --}}
                            <div class="absolute inset-8 border border-dashed border-slate-100 rounded-[3rem] animate-spin" style="animation-duration: 20s;"></div>
                            
                            <div class="relative z-10 text-center">
                                <div class="w-24 h-24 md:w-32 md:h-32 bg-indigo-50/50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-indigo-100 shadow-inner group-hover:scale-105 transition-transform duration-1000">
                                    <i class="fas fa-hourglass-half text-4xl text-indigo-600 animate-spin-slow"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.5em] ml-1">Reconciling</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center lg:text-left space-y-4">
                        {{-- RESIZED TITLE: text-4xl & text-5xl --}}
                        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[1]">
                            Vault <br><span class="text-indigo-600 underline decoration-indigo-50 underline-offset-8">Pending</span>
                        </h1>
                        <p class="text-sm text-slate-400 font-medium leading-relaxed max-w-xs">
                            System is reconciling your asset transmission for order <span class="text-slate-900 font-black">#{{ $order->id }}</span> against institutional ledgers.
                        </p>
                    </div>
                </div>

                {{-- RIGHT: THE DIGITAL RECEIPT (RESIZED) --}}
                <div class="lg:col-span-7 animate-in fade-in slide-in-from-right-8 duration-1000">
                    <div class="bg-white rounded-[2.5rem] p-1 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.03)] border border-slate-50 overflow-hidden group">
                        <div class="bg-slate-50/40 rounded-[2.3rem] p-10 space-y-10 transition-colors group-hover:bg-slate-50/60">
                            
                            <div class="flex justify-between items-start pb-6 border-b border-white">
                                <div>
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] block mb-2">Audit Signature</span>
                                    {{-- DINAMIS: TXN Code --}}
                                    <p class="text-[10px] font-mono font-black text-indigo-600 bg-white px-4 py-1.5 rounded-lg border border-slate-100 shadow-sm uppercase tracking-wider">
                                        TXN-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr(md5(optional($lastPayment)->id ?? 'sec'), 0, 6)) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] block mb-2">Timestamp</span>
                                    <p class="text-[10px] font-black text-slate-900 uppercase">
                                        {{ $lastPayment ? $lastPayment->created_at->format('d M Y / H:i') : 'IN_QUEUE' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-10">
                                <div>
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1.5">Protocol Engine</p>
                                    <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ optional($lastPayment)->method ?? 'MANUAL_AUTH' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1.5">Audit Window</p>
                                    <p class="text-xs font-black text-emerald-600 uppercase tracking-tight">1 - 24 Business Hours</p>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-white flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Authorized Valuation</p>
                                    {{-- RESIZED PRICE: text-3xl --}}
                                    <p class="text-3xl font-black text-slate-900 tracking-tighter">
                                        $ {{ number_format(optional($lastPayment)->amount ?? 0, 2) }}
                                    </p>
                                </div>
                                
                                {{-- REFIXED SECURITY SEAL ICON --}}
                                <div class="flex flex-col items-center space-y-2">
                                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-100 transform rotate-2 group-hover:rotate-0 transition-all duration-700">
                                        <i class="fas fa-check-circle text-lg"></i> {{-- Ganti ke check-circle agar pasti muncul --}}
                                    </div>
                                    <span class="text-[8px] font-black text-indigo-600 uppercase tracking-widest">Secured</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTIONS: REFINED SIZE --}}
                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-8">
                        <a href="{{ route('client.orders.index') }}" class="group relative px-10 py-4 bg-slate-900 rounded-2xl overflow-hidden transition-all duration-700 hover:bg-indigo-600 shadow-xl active:scale-95 w-full sm:w-auto text-center">
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <span class="relative text-[10px] font-black text-white uppercase tracking-[0.4em]">Return to Terminal</span>
                        </a>
                        <div class="flex items-center space-x-2.5 opacity-30">
                            <i class="fas fa-lock text-[10px]"></i>
                            <p class="text-[8px] font-bold text-slate-500 uppercase tracking-[0.2em]">End-to-End Encrypted</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.partials.app-footer')

    <style>
        .animate-spin-slow {
            animation: spin 15s linear infinite;
        }
    </style>
</div>