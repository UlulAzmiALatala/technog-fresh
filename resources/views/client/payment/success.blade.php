{{-- Lokasi: resources/views/client/payment/success.blade.php (REFINED SOVEREIGN SUCCESS) --}}

@php
    $lastPayment = $order->payments()->latest()->first();
@endphp

<x-app-layout>
    <style>
        {{-- Animasi Centang --}}
        .payment-success-icon {
            width: 4rem; height: 4rem;
            transform: scale(0.8); opacity: 0;
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

        .icon-wrapper-glow {
            animation: pulse-glow 2s ease-out 1.6s;
        }
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0px rgba(16, 185, 129, 0.0); }
            30% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0.15); }
            100% { box-shadow: 0 0 0 30px rgba(16, 185, 129, 0.0); }
        }
    </style>

    <div class="flex flex-col min-h-screen bg-[#FDFDFF] font-sans antialiased text-slate-900 w-full overflow-x-hidden">
        
        <main class="flex-grow w-full">
            {{-- HEADER: FIXED & SOLID (Mencegah Nimbun) --}}
            <nav class="bg-white border-b border-slate-100 sticky top-0 z-[60] w-full shadow-sm">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center shadow-md">
                            <i class="fas fa-check-double text-white text-[10px]"></i>
                        </div>
                        <div>
                            <span class="block text-[8px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-0.5">Payment Finalization</span>
                            <h2 class="text-xs font-black text-slate-900 tracking-tight uppercase">Settlement Verified</h2>
                        </div>
                    </div>
                    <div class="bg-slate-900 px-4 py-1.5 rounded-xl shadow-sm">
                        <span class="text-[9px] font-black text-white uppercase tracking-widest">Protocol Closed</span>
                    </div>
                </div>
            </nav>

            <x-payment-steps :step="4" />

            <div class="max-w-4xl mx-auto px-6 lg:px-8 mb-20 text-center"
                 x-data="{ loaded: false }" 
                 x-init="setTimeout(() => loaded = true, 100)">
                
                {{-- 1. SUCCESS VISUAL NODE (Ramping) --}}
                <div class="relative inline-block mb-10 animate-in fade-in zoom-in duration-1000" x-show="loaded">
                    <div class="absolute inset-0 bg-emerald-500/5 rounded-full blur-[60px] scale-125 animate-pulse"></div>
                    
                    <div class="relative w-32 h-32 bg-white rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(16,185,129,0.1)] border border-emerald-50 flex items-center justify-center icon-wrapper-glow">
                        <svg class="payment-success-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="svg-circle-bg" cx="26" cy="26" r="25"/>
                            <circle class="svg-circle" cx="26" cy="26" r="25"/>
                            <polyline class="svg-check" points="14,27 22,35 38,18"/>
                        </svg>
                    </div>
                </div>

                {{-- 2. TYPOGRAPHY: RESIZED & UPRIGHT (NO ITALICS) --}}
                <div class="space-y-4 animate-in fade-in slide-in-from-bottom-6 duration-1000 delay-200" x-show="loaded">
                    <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-tight">
                        Payment <span class="text-emerald-500">Confirmed</span>
                    </h1>
                    <p class="text-xs md:text-sm text-slate-400 font-medium leading-relaxed max-w-md mx-auto">
                        Transaction for order <span class="text-slate-900 font-black">#{{ $order->id }}</span> verified. We are now initiating project resources for TechnoG Solutions.
                    </p>
                </div>

                {{-- 3. THE SOVEREIGN RECEIPT (RESIZED & DYNAMIC) --}}
                <div class="mt-12 bg-white rounded-[2.5rem] p-1 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.03)] border border-slate-100 overflow-hidden max-w-lg mx-auto animate-in fade-in slide-in-from-bottom-8 duration-1000 delay-400" x-show="loaded">
                    <div class="bg-slate-50/40 rounded-[2.3rem] p-8 md:p-10 space-y-8">
                        <div class="flex justify-between items-center pb-6 border-b border-white">
                            <div class="text-left">
                                <span class="text-[8px] font-black text-slate-300 uppercase tracking-[0.4em] block mb-2">Audit Token</span>
                                <p class="text-[10px] font-mono font-black text-emerald-600 bg-white px-3 py-1.5 rounded-lg border border-slate-100 shadow-sm uppercase tracking-wider">
                                    TXN-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr(md5(optional($lastPayment)->id ?? 'paid'), 0, 6)) }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-[8px] font-black text-slate-300 uppercase tracking-[0.4em] block mb-2">Timestamp</span>
                                <p class="text-[10px] font-black text-slate-900 uppercase">
                                    {{ $lastPayment && $lastPayment->payment_date ? \Carbon\Carbon::parse($lastPayment->payment_date)->format('d M Y / H:i') : ($lastPayment ? $lastPayment->created_at->format('d M Y / H:i') : '-') }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8 text-left">
                            <div>
                                <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1.5">Entity Reference</p>
                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight">#{{ $order->id }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mb-1.5">Payment Method</p>
                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight">{{ optional($lastPayment)->method ?? 'SECURE_AUTH' }}</p>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-white flex justify-between items-center">
                            <div class="text-left">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2">Settlement Value</p>
                                <p class="text-3xl font-black text-slate-900 tracking-tighter">
                                    $ {{ number_format(optional($lastPayment)->amount ?? 0, 2) }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg transform rotate-2">
                                <i class="fas fa-file-invoice text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. ACTIONS: ADDED DOWNLOAD BUTTON --}}
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4 animate-in fade-in duration-1000 delay-500" x-show="loaded">
                    {{-- Download Invoice Button --}}
                    <a href="{{ route('client.payment.invoice_pdf', $order->id) }}" class="w-full sm:w-auto flex items-center justify-center space-x-3 px-8 py-4 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <i class="fas fa-download text-[10px] text-indigo-600"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-600">Download Invoice</span>
                    </a>

                    <a href="{{ route('client.orders.show', $order->id) }}" class="w-full sm:w-auto group relative px-10 py-4 bg-slate-900 rounded-2xl overflow-hidden transition-all duration-700 hover:bg-indigo-600 shadow-xl active:scale-95 text-center">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <i class="fas fa-eye text-[9px] text-white/50"></i>
                            <span class="text-[10px] font-black text-white uppercase tracking-[0.3em]">Project Terminal</span>
                        </div>
                    </a>
                </div>

                <div class="mt-8 animate-in fade-in duration-1000 delay-700" x-show="loaded">
                    <a href="{{ route('client.orders.index') }}" class="text-[9px] font-black uppercase tracking-[0.4em] text-slate-300 hover:text-indigo-600 transition-colors">
                        Return to Archive
                    </a>
                </div>
            </div>
        </main>

        @include('layouts.partials.app-footer')
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                confetti({
                    particleCount: 80,
                    spread: 60,
                    origin: { y: 0.6 },
                    colors: ['#10B981', '#4F46E5']
                });
            }, 1600);
        });
    </script>
    @endpush
</x-app-layout>