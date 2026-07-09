{{-- Location: resources/views/admin/pemasukan/orders/show.blade.php --}}

<x-admin-layout>
    <div x-data="pageManager()" class="relative">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">
                        {{ __('Order Details #') }}{{ $order->id }}
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Complete project overview & financials</p>
                </div>
                <a href="{{ route('admin.pemasukan.orders.index') }}" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to List
                </a>
            </div>
        </x-slot>

        <div class="space-y-8 py-4">

            {{-- 1. HEADER RINGKASAN STATUS (Glassmorphism Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Order Status --}}
                <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden flex justify-between items-center">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full blur-2xl 
                        @switch($order->status)
                            @case('Completed') bg-green-500/10 @break
                            @case('Processing') bg-yellow-500/10 @break
                            @case('Awaiting Confirmation') bg-orange-500/10 @break
                            @case('Pending Payment') bg-blue-500/10 @break
                            @case('Cancelled') bg-red-500/10 @break
                            @default bg-slate-500/10
                        @endswitch">
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Order Status</p>
                        <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 tracking-tight">
                            @switch($order->status)
                                @case('Completed') Completed @break
                                @case('Processing') Processing @break
                                @case('Awaiting Confirmation') Reviewing @break
                                @case('Pending Payment') Pending @break
                                @case('Cancelled') Cancelled @break
                                @default {{ $order->status }}
                            @endswitch
                        </p>
                    </div>
                    <div class="relative z-10 h-14 w-14 flex items-center justify-center rounded-2xl text-2xl shadow-inner
                        @switch($order->status)
                            @case('Completed') bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 @break
                            @case('Processing') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 @break
                            @case('Awaiting Confirmation') bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 @break
                            @case('Pending Payment') bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 @break
                            @case('Cancelled') bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 @break
                            @default bg-slate-100 dark:bg-slate-900/30 text-slate-600 dark:text-slate-400
                        @endswitch">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>

                {{-- Payment Status --}}
                <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden flex justify-between items-center">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full blur-2xl {{ optional($order->invoice)->status == 'Paid' ? 'bg-emerald-500/10' : 'bg-amber-500/10' }}"></div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Payment Status</p>
                        <p class="text-2xl font-black mt-1 tracking-tight {{ optional($order->invoice)->status == 'Paid' ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">
                            {{ optional($order->invoice)->status == 'Paid' ? 'Paid' : 'Unpaid' }}
                        </p>
                    </div>
                    <div class="relative z-10 h-14 w-14 flex items-center justify-center rounded-2xl text-2xl shadow-inner {{ optional($order->invoice)->status == 'Paid' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>

                {{-- Work Progress --}}
                <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm flex flex-col justify-center">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-3">
                        <span>Work Progress</span>
                        <span class="text-indigo-600 dark:text-indigo-400 text-xs">{{ $order->progress ?? 0 }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700/50 rounded-full h-3 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-full rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $order->progress ?? 0 }}%">
                            <div class="absolute inset-0 bg-white/20 w-full h-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. PROFIT ANALYTICS CARD (Mewah) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 rounded-[2rem] shadow-xl shadow-emerald-500/20 text-white relative overflow-hidden flex flex-col justify-center border border-white/20">
                    <i class="fas fa-chart-line absolute right-8 top-1/2 -translate-y-1/2 text-7xl opacity-20"></i>
                    <div class="relative z-10">
                        <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">Estimated Net Profit</p>
                        <p class="text-5xl font-black mt-2 tracking-tighter">
                            $ {{ number_format($order->total_price - $order->expenses->sum('amount'), 2) }}
                        </p>
                        <div class="mt-4 flex items-center text-[10px] font-bold tracking-widest uppercase text-emerald-100 bg-black/10 w-max px-3 py-1.5 rounded-lg">
                            <i class="fas fa-info-circle mr-2"></i> Revenue - Worker Payouts
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl p-8 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col justify-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Total Project Expenses</p>
                    <p class="text-5xl font-black mt-2 text-slate-900 dark:text-white tracking-tighter">
                        $ {{ number_format($order->expenses->sum('amount'), 2) }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- KOLOM KIRI: Informasi Detail & Worker Resources --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Client Info & Delivery Plan Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-id-card mr-3 text-indigo-500"></i> Client Info
                            </h4>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Client Name</p>
                                    <p class="font-bold text-slate-900 dark:text-white text-lg">{{ $order->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Email Address</p>
                                    <p class="font-medium text-slate-600 dark:text-slate-300">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                            <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 dark:text-white mb-6 flex items-center">
                                <i class="fas fa-shipping-fast mr-3 text-indigo-500"></i> Delivery Plan
                            </h4>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Delivery Type</p>
                                    <p class="font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest text-sm">{{ $order->delivery_option ?? 'Standard' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Final Deadline</p>
                                    <p class="font-bold text-slate-900 dark:text-white text-lg">
                                        {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('d F Y') : 'Waiting Payment' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================================= --}}
                    {{-- NEW COMPONENT: PROJECT REQUIREMENTS & WHATSAPP FOLLOW UP  --}}
                    {{-- ========================================================= --}}
                    @if($order->notes)
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-8 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30 flex justify-between items-center">
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-comment-dots mr-3 text-indigo-500"></i> Project Notes & Requirements
                            </h3>
                            
                            @php
                                // Ekstrak nomor WhatsApp dari text notes menggunakan Regex
                                preg_match('/WhatsApp:\s*([^\n]+)/', $order->notes, $waMatch);
                                $waNumber = $waMatch[1] ?? null;
                                // Bersihkan nomor WA (Hapus spasi, +, -, dll) untuk Link URL
                                $cleanWaNumber = $waNumber ? preg_replace('/[^0-9]/', '', $waNumber) : null;
                                
                                // Format nomor Indonesia: Ubah 08 menjadi 628
                                if(str_starts_with($cleanWaNumber, '08')) {
                                    $cleanWaNumber = '62' . substr($cleanWaNumber, 1);
                                }
                            @endphp

                            @if($cleanWaNumber)
                            <a href="https://wa.me/{{ $cleanWaNumber }}" target="_blank" class="px-5 py-2.5 bg-[#25D366] hover:bg-[#128C7E] text-white text-[10px] uppercase tracking-widest font-black rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center group">
                                <i class="fab fa-whatsapp text-lg mr-2 group-hover:scale-110 transition-transform"></i> Chat Client
                            </a>
                            @endif
                        </div>
                        <div class="p-8">
                            <div class="prose prose-sm dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                                {!! nl2br(e($order->notes)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- ========================================================= --}}


                    {{-- Payment History & Verification --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl overflow-hidden shadow-sm rounded-[2rem] border border-slate-200 dark:border-slate-700">
                        <div class="p-8 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-history mr-3 text-indigo-500"></i> Payment History
                            </h3>
                        </div>
                        <div class="p-8 space-y-4">
                            @if($order->invoice && $order->invoice->payments->isNotEmpty())
                                @foreach ($order->invoice->payments->sortByDesc('created_at') as $payment)
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 rounded-2xl border transition-all 
                                        {{ !$payment->payment_date ? 'bg-indigo-50/50 dark:bg-indigo-900/10 border-indigo-100 dark:border-indigo-800/50' : 'bg-slate-50/50 dark:bg-slate-900/20 border-slate-200 dark:border-slate-700' }}">
                                        
                                        <div class="flex items-center mb-4 sm:mb-0">
                                            <div class="relative group cursor-pointer" @click="openImageViewer('{{ asset('storage/' . $payment->payment_proof) }}')">
                                                <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                                                     class="w-20 h-20 object-cover rounded-xl border-2 border-white dark:border-slate-700 shadow-md transition-transform group-hover:scale-105">
                                                <div class="absolute inset-0 bg-black/40 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <i class="fas fa-search-plus text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-6">
                                                <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter">$ {{ number_format($payment->amount, 2) }}</p>
                                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-1">Sub: {{ $payment->created_at->format('d M Y, H:i') }}</p>
                                                @if($payment->payment_date)
                                                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mt-0.5">Ver: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if(!$payment->payment_date)
                                            <div class="flex items-center space-x-2 w-full sm:w-auto">
                                                <form x-ref="approveForm{{$payment->id}}" action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST" class="flex-1 sm:flex-none">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <input type="hidden" name="action" value="accept">
                                                    <button type="button" @click="openConfirmModal('Approve Payment', 'Are you sure you want to APPROVE this payment?', 'approve', $refs.approveForm{{$payment->id}})" 
                                                            class="w-full px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-colors shadow-lg shadow-emerald-500/30">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form x-ref="rejectForm{{$payment->id}}" action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST" class="flex-1 sm:flex-none">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="button" @click="openConfirmModal('Reject Payment', 'Are you sure you want to REJECT this payment?', 'danger', $refs.rejectForm{{$payment->id}})" 
                                                            class="w-full px-5 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-colors shadow-lg shadow-red-500/30">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                                Verified
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                        <i class="fas fa-receipt text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">No payment records found.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PROJECT RESOURCES (Worker Payout Table) --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl overflow-hidden shadow-sm rounded-[2rem] border border-slate-200 dark:border-slate-700">
                        <div class="p-8 border-b border-slate-100 dark:border-slate-700/50 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-users-cog mr-3 text-indigo-500"></i> Project Costs
                            </h3>
                            <button @click="showPayoutModal = true" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] uppercase tracking-widest font-bold rounded-xl transition-colors shadow-lg shadow-indigo-500/30">
                                <i class="fas fa-plus mr-1.5"></i> Add Payout
                            </button>
                        </div>
                        <div class="p-8">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700">
                                            <th class="pb-4 font-bold">Worker Name</th>
                                            <th class="pb-4 font-bold">Task</th>
                                            <th class="pb-4 text-right font-bold">Fee Amount</th>
                                            <th class="pb-4 text-center font-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50 text-sm">
                                        @forelse($order->expenses as $exp)
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                            <td class="py-5 font-bold text-slate-900 dark:text-white">{{ $exp->worker->name }}</td>
                                            <td class="py-5 text-slate-500 dark:text-slate-400 font-medium">{{ $exp->description }}</td>
                                            <td class="py-5 text-right font-black text-slate-900 dark:text-white text-lg tracking-tight">$ {{ number_format($exp->amount, 2) }}</td>
                                            <td class="py-5 text-center">
                                                <span class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-lg border 
                                                    {{ $exp->status == 'Paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50' }}">
                                                    {{ $exp->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">No workers assigned yet.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Negotiated Pricing Section --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl overflow-hidden shadow-sm rounded-[2rem] border border-slate-200 dark:border-slate-700">
                        <div class="p-8 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-handshake mr-3 text-indigo-500"></i> Negotiated Pricing
                            </h3>
                        </div>
                        <div class="p-8">
                            <form action="{{ route('admin.pemasukan.orders.updateNegotiatedPrice', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2">Fast Delivery Fee</label>
                                        <div class="relative flex rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-700">
                                            <span class="inline-flex items-center px-4 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-black border-r border-slate-200 dark:border-slate-700">$</span>
                                            <input type="number" name="negotiated_price_fast" value="{{ old('negotiated_price_fast', $order->negotiated_price_fast) }}" class="flex-1 block w-full bg-white dark:bg-slate-900 dark:text-white font-bold text-sm outline-none px-3 py-3 border-none focus:ring-0">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2">Express Delivery Fee</label>
                                        <div class="relative flex rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-700">
                                            <span class="inline-flex items-center px-4 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-black border-r border-slate-200 dark:border-slate-700">$</span>
                                            <input type="number" name="negotiated_price_express" value="{{ old('negotiated_price_express', $order->negotiated_price_express) }}" class="flex-1 block w-full bg-white dark:bg-slate-900 dark:text-white font-bold text-sm outline-none px-3 py-3 border-none focus:ring-0">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400 mb-2">Custom Day Fee</label>
                                        <div class="relative flex rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-700">
                                            <span class="inline-flex items-center px-4 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 font-black border-r border-slate-200 dark:border-slate-700">$</span>
                                            <input type="number" name="negotiated_price_custom" value="{{ old('negotiated_price_custom', $order->negotiated_price_custom) }}" class="flex-1 block w-full bg-white dark:bg-slate-900 dark:text-white font-bold text-sm outline-none px-3 py-3 border-none focus:ring-0">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end">
                                    <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-black dark:bg-indigo-600 dark:hover:bg-indigo-700 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-colors shadow-lg">Update Pricing</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: Management Panels --}}
                <div class="lg:col-span-1 space-y-8">
                    
                    {{-- Status Management --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-sliders-h mr-3 text-indigo-500"></i> Manage Status
                            </h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.pemasukan.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white font-bold text-sm focus:ring-indigo-500 px-4 py-3 outline-none">
                                    <option value="Pending Payment" @selected($order->status == 'Pending Payment')>Pending Payment</option>
                                    <option value="Awaiting Confirmation" @selected($order->status == 'Awaiting Confirmation')>Awaiting Confirmation</option>
                                    <option value="Processing" @selected($order->status == 'Processing')>Processing</option>
                                    <option value="Completed" @selected($order->status == 'Completed')>Completed</option>
                                    <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                                </select>
                                <button type="submit" class="w-full mt-4 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] uppercase tracking-widest font-black rounded-xl transition-colors shadow-lg shadow-indigo-500/30">Update Status</button>
                            </form>
                        </div>
                    </div>

                    {{-- Progress Control --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-spinner mr-3 text-indigo-500"></i> Update Progress
                            </h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.pemasukan.orders.updateProgress', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center justify-between mb-5">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Current Progress</span>
                                    <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400 tracking-tighter" x-text="`${progressValue}%`"></span>
                                </div>
                                <input type="range" name="progress" x-model="progressValue" min="0" max="100" class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <button type="submit" class="w-full mt-6 py-3.5 bg-slate-900 hover:bg-black dark:bg-slate-700 dark:hover:bg-slate-600 text-white text-[10px] uppercase tracking-widest font-black rounded-xl transition-colors">Set Progress</button>
                            </form>
                        </div>
                    </div>

                    {{-- Financial Ledger --}}
                    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30">
                            <h3 class="text-sm font-black uppercase tracking-widest text-slate-900 dark:text-white flex items-center">
                                <i class="fas fa-vault mr-3 text-indigo-500"></i> Project Balance
                            </h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Invoice</span>
                                <span class="text-lg font-black text-slate-900 dark:text-white tracking-tight">$ {{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-emerald-600 dark:text-emerald-400">
                                <span class="text-[10px] font-bold uppercase tracking-widest">Verified Revenue</span>
                                <span class="text-lg font-black tracking-tight">$ {{ number_format($amountPaid, 2) }}</span>
                            </div>
                            <div class="border-t border-slate-100 dark:border-slate-700/50 pt-5 flex justify-between items-center">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest">Remaining Bill</span>
                                <span class="text-xl font-black tracking-tighter {{ $remainingAmount > 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-900 dark:text-white' }}">
                                    $ {{ number_format($remainingAmount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALS SECTION --}}

        {{-- 4. WORKER PAYOUT MODAL --}}
        <template x-teleport="body">
            <div x-show="showPayoutModal" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" @click="showPayoutModal = false"></div>
                
                <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-white/10 z-10" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Record Worker Fee</h3>
                        <button @click="showPayoutModal = false" class="text-slate-400 hover:text-slate-600 transition-colors"><i class="fas fa-times fa-lg"></i></button>
                    </div>
                    <form action="{{ route('admin.pemasukan.orders.storeWorkerPayout', $order->id) }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Worker / Freelancer Name</label>
                            <input type="text" name="worker_name" required placeholder="Full Name" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-bold focus:ring-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Payout Amount ($)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400">$</span>
                                <input type="number" name="amount" required step="0.01" placeholder="0.00" class="w-full pl-8 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-bold focus:ring-indigo-500 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Project Task Description</label>
                            <textarea name="description" rows="3" placeholder="Describe what the worker did..." class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-medium focus:ring-indigo-500 outline-none"></textarea>
                        </div>
                        <div class="flex space-x-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <button type="button" @click="showPayoutModal = false" class="flex-1 py-4 text-sm font-bold text-slate-500 bg-slate-100 dark:bg-slate-700 rounded-2xl transition-colors">Cancel</button>
                            <button type="submit" class="flex-1 py-4 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl shadow-lg shadow-indigo-500/30 transition-colors">Confirm Payout</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- Universal Image Viewer --}}
        <template x-teleport="body">
            <div x-show="showImageViewer" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-[20px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>
                <button @click="closeImageViewer()" class="absolute top-8 right-8 text-white hover:text-indigo-400 transition-colors z-20"><i class="fas fa-times fa-2xl"></i></button>
                <div @click.away="closeImageViewer()" class="relative z-10">
                    <img :src="imageUrl" class="max-w-full max-h-[85vh] rounded-[2rem] shadow-2xl border border-white/10 transition-transform duration-300 cursor-grab active:cursor-grabbing" :style="`transform: scale(${scale})`" @mousedown="startPan($event)">
                </div>
            </div>
        </template>

        {{-- Confirmation Modal --}}
        <template x-teleport="body">
            <div x-show="isConfirmModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" @click="isConfirmModalOpen = false"></div>
                
                <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10 z-10" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner transition-colors duration-300" :class="confirmModalType === 'danger' ? 'bg-red-50 dark:bg-red-900/30 text-red-600' : 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500'">
                        <i class="fas" :class="confirmModalType === 'danger' ? 'fa-exclamation-triangle' : 'fa-check-circle'"></i>
                    </div>
                    <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase" x-text="confirmModalTitle"></h3>
                    <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-medium leading-relaxed" x-text="confirmModalText"></p>
                    <form class="mt-10 flex space-x-4" :action="confirmActionUrl" method="POST">
                        @csrf
                        <div x-html="confirmHiddenInputs"></div>
                        <button type="button" @click="isConfirmModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-2xl font-bold transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 py-4 text-white rounded-2xl font-bold transition-all shadow-lg" :class="confirmModalType === 'danger' ? 'bg-red-600 hover:bg-red-700 shadow-red-900/20' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-900/20'">Confirm</button>
                    </form>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
    <script>
        function pageManager() {
            return {
                showPayoutModal: false, 
                progressValue: {{ $order->progress ?? 0 }},
                showImageViewer: false, 
                imageUrl: '', 
                scale: 1, 
                translateX: 0, 
                translateY: 0,
                
                openImageViewer(url) { 
                    this.imageUrl = url; 
                    this.showImageViewer = true; 
                    this.resetZoom(); 
                },
                closeImageViewer() { this.showImageViewer = false; },
                zoomIn() { this.scale = Math.min(3, this.scale + 0.2); },
                zoomOut() { this.scale = Math.max(0.2, this.scale - 0.2); },
                resetZoom() { this.scale = 1; this.translateX = 0; this.translateY = 0; },
                
                isConfirmModalOpen: false, 
                confirmModalTitle: '', 
                confirmModalText: '', 
                confirmModalType: 'approve', 
                confirmActionUrl: '', 
                confirmHiddenInputs: '',
                
                openConfirmModal(title, text, type, formRef) {
                    this.confirmModalTitle = title; 
                    this.confirmModalText = text; 
                    this.confirmModalType = type;
                    this.confirmActionUrl = formRef.getAttribute('action');
                    let inputsHTML = ''; 
                    formRef.querySelectorAll('input').forEach(input => { inputsHTML += input.outerHTML; });
                    this.confirmHiddenInputs = inputsHTML; 
                    this.isConfirmModalOpen = true;
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>