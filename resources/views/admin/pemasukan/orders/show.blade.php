{{-- Location: resources/views/admin/pemasukan/orders/show.blade.php --}}

<x-admin-layout x-data="pageManager()">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Order Details #') }}{{ $order->id }}
            </h2>
            <a href="{{ route('admin.pemasukan.orders.index') }}" class="text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-white flex items-center transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Order List
            </a>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- 1. Header Ringkasan Status --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Order Status</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-1">
                        @switch($order->status)
                            @case('Completed') Completed @break
                            @case('Processing') Processing @break
                            @case('Awaiting Confirmation') Awaiting Confirmation @break
                            @case('Pending Payment') Pending Payment @break
                            @case('Cancelled') Cancelled @break
                            @default {{ $order->status }}
                        @endswitch
                    </p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center rounded-full text-xl
                    @switch($order->status)
                        @case('Completed') bg-green-100 text-green-600 @break
                        @case('Processing') bg-yellow-100 text-yellow-600 @break
                        @case('Awaiting Confirmation') bg-orange-100 text-orange-600 @break
                        @case('Pending Payment') bg-blue-100 text-blue-600 @break
                        @case('Cancelled') bg-red-100 text-red-600 @break
                        @default bg-gray-100 text-gray-600
                    @endswitch">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Payment Status</p>
                    <p class="text-xl font-bold mt-1 {{ optional($order->invoice)->status == 'Paid' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ optional($order->invoice)->status == 'Paid' ? 'Paid' : 'Unpaid' }}
                    </p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center rounded-full text-xl {{ optional($order->invoice)->status == 'Paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700">
                <div class="flex justify-between text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                    <span>Work Progress</span>
                    <span class="text-indigo-600 dark:text-indigo-400">{{ $order->progress ?? 0 }}%</span>
                </div>
                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500" style="width: {{ $order->progress ?? 0 }}%"></div>
                </div>
            </div>
        </div>

        {{-- 2. PROFIT ANALYTICS CARD (Injeksi Baru) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-emerald-500 to-teal-700 p-8 rounded-2xl shadow-xl text-white relative overflow-hidden">
                <i class="fas fa-chart-line absolute right-6 bottom-6 text-6xl opacity-10"></i>
                <p class="text-sm font-bold uppercase tracking-widest opacity-80">Estimated Net Profit</p>
                <p class="text-4xl font-black mt-2">
                    $ {{ number_format($order->total_price - $order->expenses->sum('amount'), 2) }}
                </p>
                <div class="mt-4 flex items-center text-xs opacity-90">
                    <i class="fas fa-info-circle mr-2"></i>
                    Calculation: Revenue - All Worker Payouts
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col justify-center">
                <p class="text-sm font-bold uppercase tracking-widest text-slate-500">Total Project Expenses</p>
                <p class="text-4xl font-black mt-2 text-slate-900 dark:text-white">
                    $ {{ number_format($order->expenses->sum('amount'), 2) }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- KOLOM KIRI: Informasi Detail & Worker Resources --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Payment History & Verification --}}
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-slate-200 flex items-center">
                            <i class="fas fa-history mr-3 text-indigo-500"></i>
                            Payment History & Verification
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($order->invoice && $order->invoice->payments->isNotEmpty())
                            @foreach ($order->invoice->payments->sortByDesc('created_at') as $payment)
                                <div class="flex items-start justify-between p-5 rounded-xl {{ !$payment->payment_date ? 'bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800' : 'bg-slate-50 dark:bg-slate-700/30 border border-transparent' }}">
                                    <div class="flex items-start">
                                        <img @click="openImageViewer('{{ asset('storage/' . $payment->payment_proof) }}')" 
                                             src="{{ asset('storage/' . $payment->payment_proof) }}" 
                                             class="w-16 h-16 object-cover rounded-lg border-2 border-white dark:border-slate-600 shadow-sm mr-4 cursor-pointer hover:scale-105 transition-transform">
                                        <div>
                                            <p class="text-xl font-black text-slate-800 dark:text-white">$ {{ number_format($payment->amount, 2) }}</p>
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mt-1">Submitted: {{ $payment->created_at->format('d M Y, H:i') }}</p>
                                            @if($payment->payment_date)
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 mt-0.5">Verified: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if(!$payment->payment_date)
                                        <div class="flex items-center space-x-2">
                                            <form x-ref="approveForm{{$payment->id}}" action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="button" @click="openConfirmModal('Approve Payment', 'Are you sure you want to APPROVE this payment?', 'approve', $refs.approveForm{{$payment->id}})" 
                                                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-xs font-bold transition">
                                                    Approve
                                                </button>
                                            </form>
                                            <form x-ref="rejectForm{{$payment->id}}" action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="button" @click="openConfirmModal('Reject Payment', 'Are you sure you want to REJECT this payment?', 'danger', $refs.rejectForm{{$payment->id}})" 
                                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs font-bold transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-receipt text-slate-200 text-4xl mb-3"></i>
                                <p class="text-sm text-slate-400">No payment records found.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 3. PROJECT RESOURCES (Worker Payout Table) - INJEKSI BARU --}}
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-slate-200 flex items-center">
                            <i class="fas fa-users-cog mr-3 text-indigo-500"></i>
                            Project Resources & Costs
                        </h3>
                        <button @click="showPayoutModal = true" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 dark:shadow-none">
                            <i class="fas fa-plus mr-1"></i> Add Worker Payout
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="text-slate-400 border-b border-slate-100 dark:border-slate-700">
                                        <th class="pb-4 font-bold uppercase tracking-wider text-[10px]">Worker Name</th>
                                        <th class="pb-4 font-bold uppercase tracking-wider text-[10px]">Description</th>
                                        <th class="pb-4 text-right font-bold uppercase tracking-wider text-[10px]">Fee Amount</th>
                                        <th class="pb-4 text-center font-bold uppercase tracking-wider text-[10px]">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                                    @forelse($order->expenses as $exp)
                                    <tr>
                                        <td class="py-4 font-bold text-slate-800 dark:text-slate-200">{{ $exp->worker->name }}</td>
                                        <td class="py-4 text-slate-500 dark:text-slate-400 italic text-xs">{{ $exp->description }}</td>
                                        <td class="py-4 text-right font-black text-slate-900 dark:text-white">$ {{ number_format($exp->amount, 2) }}</td>
                                        <td class="py-4 text-center">
                                            <span class="px-2 py-1 text-[9px] font-black uppercase tracking-widest rounded-md {{ $exp->status == 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $exp->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-10 text-center text-slate-400 italic">No workers assigned to this project yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Negotiated Pricing Section --}}
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <h3 class="text-lg font-bold flex items-center text-slate-900 dark:text-slate-200">
                            <i class="fas fa-handshake mr-3 text-indigo-500"></i>
                            Negotiated Pricing Plans
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.pemasukan.orders.updateNegotiatedPrice', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Fast Delivery Fee</label>
                                    <div class="relative flex rounded-xl shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-900 font-bold">$</span>
                                        <input type="number" name="negotiated_price_fast" value="{{ old('negotiated_price_fast', $order->negotiated_price_fast) }}" class="flex-1 block w-full rounded-none rounded-r-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white font-bold text-sm focus:ring-indigo-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Express Delivery Fee</label>
                                    <div class="relative flex rounded-xl shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-900 font-bold">$</span>
                                        <input type="number" name="negotiated_price_express" value="{{ old('negotiated_price_express', $order->negotiated_price_express) }}" class="flex-1 block w-full rounded-none rounded-r-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white font-bold text-sm focus:ring-indigo-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Custom Day Fee</label>
                                    <div class="relative flex rounded-xl shadow-sm">
                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-900 font-bold">$</span>
                                        <input type="number" name="negotiated_price_custom" value="{{ old('negotiated_price_custom', $order->negotiated_price_custom) }}" class="flex-1 block w-full rounded-none rounded-r-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white font-bold text-sm focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-slate-900 dark:bg-indigo-600 text-white rounded-xl text-sm font-bold hover:scale-105 transition shadow-lg">Update Pricing</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Client Info & Delivery Plan Row --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                        <h4 class="text-sm font-black uppercase tracking-widest text-indigo-600 mb-6 flex items-center">
                            <i class="fas fa-id-card mr-2"></i> Client Info
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Client Name</p>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email Address</p>
                                <p class="font-bold text-slate-900 dark:text-white">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-sm border border-slate-200 dark:border-slate-700">
                        <h4 class="text-sm font-black uppercase tracking-widest text-indigo-600 mb-6 flex items-center">
                            <i class="fas fa-shipping-fast mr-2"></i> Delivery Plan
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Delivery Type</p>
                                <p class="font-black text-slate-900 dark:text-white uppercase">{{ $order->delivery_option ?? 'Standard' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Final Deadline</p>
                                <p class="font-bold text-slate-900 dark:text-white">
                                    {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('d F Y') : 'Waiting Payment' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Management Panels --}}
            <div class="lg:col-span-1 space-y-8">
                
                {{-- Status Management --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-800 dark:text-slate-200 flex items-center">
                            <i class="fas fa-sliders-h mr-3 text-indigo-500"></i> Manage Status
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.pemasukan.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-200 font-bold text-sm focus:ring-indigo-500">
                                <option value="Pending Payment" @selected($order->status == 'Pending Payment')>Pending Payment</option>
                                <option value="Awaiting Confirmation" @selected($order->status == 'Awaiting Confirmation')>Awaiting Confirmation</option>
                                <option value="Processing" @selected($order->status == 'Processing')>Processing</option>
                                <option value="Completed" @selected($order->status == 'Completed')>Completed</option>
                                <option value="Cancelled" @selected($order->status == 'Cancelled')>Cancelled</option>
                            </select>
                            <button type="submit" class="w-full mt-4 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 dark:shadow-none">Update Order Status</button>
                        </form>
                    </div>
                </div>

                {{-- Progress Control --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-800 dark:text-slate-200 flex items-center">
                            <i class="fas fa-spinner mr-3 text-indigo-500"></i> Update Progress
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.pemasukan.orders.updateProgress', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-400">Current Work Progress</span>
                                <span class="text-lg font-black text-indigo-600" x-text="`${progressValue}%` text-indigo-600"></span>
                            </div>
                            <input type="range" name="progress" x-model="progressValue" min="0" max="100" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer dark:bg-slate-700">
                            <button type="submit" class="w-full mt-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-black transition">Set Progress</button>
                        </form>
                    </div>
                </div>

                {{-- Financial Ledger --}}
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-800 dark:text-slate-200 flex items-center">
                            <i class="fas fa-vault mr-3 text-indigo-500"></i> Project Balance
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-slate-400 uppercase tracking-widest">Total Invoice</span>
                            <span class="font-black text-slate-900 dark:text-white">$ {{ number_format($order->total_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-emerald-600">
                            <span class="font-bold uppercase tracking-widest text-emerald-600/70">Verified Revenue</span>
                            <span class="font-black">$ {{ number_format($amountPaid, 2) }}</span>
                        </div>
                        <div class="border-t border-slate-50 dark:border-slate-700 pt-4 flex justify-between items-center">
                            <span class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider">Remaining Bill</span>
                            <span class="text-sm font-black {{ $remainingAmount > 0 ? 'text-red-600' : 'text-slate-900 dark:text-white' }}">
                                $ {{ number_format($remainingAmount, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS SECTION --}}

    {{-- 4. WORKER PAYOUT MODAL (Injeksi Baru) --}}
    <div x-show="showPayoutModal" x-cloak 
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        
        <div class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden" @click.away="showPayoutModal = false">
            <div class="p-8 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white italic-none">Record Worker Fee</h3>
                <button @click="showPayoutModal = false" class="text-slate-400 hover:text-slate-900 transition">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <form action="{{ route('admin.pemasukan.orders.storeWorkerPayout', $order->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Worker / Freelancer Name</label>
                    <input type="text" name="worker_name" required placeholder="Full Name" 
                           class="w-full rounded-2xl border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-bold p-4 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Payout Amount ($)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400">$</span>
                        <input type="number" name="amount" required step="0.01" placeholder="0.00" 
                               class="w-full pl-8 rounded-2xl border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-bold p-4 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-3">Project Task Description</label>
                    <textarea name="description" rows="3" placeholder="Describe what the worker did..." 
                              class="w-full rounded-2xl border-slate-200 bg-slate-50 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-bold p-4 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex space-x-4 pt-4">
                    <button type="button" @click="showPayoutModal = false" class="flex-1 py-4 text-sm font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-2xl transition">Cancel</button>
                    <button type="submit" class="flex-1 py-4 text-sm font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none transition">Confirm Payout</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Universal Image Viewer --}}
    <div x-show="showImageViewer" x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/90 p-4">
        <button @click="closeImageViewer()" class="absolute top-8 right-8 text-white hover:text-indigo-400 transition transform hover:rotate-90">
            <i class="fas fa-times fa-2x"></i>
        </button>
        <img :src="imageUrl" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl transition-transform duration-300" :style="`transform: scale(${scale})`" @mousedown="startPan($event)">
    </div>

    {{-- Confirmation Modal --}}
    <div x-show="isConfirmModalOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 w-full max-w-md rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-black text-slate-900 dark:text-white" x-text="confirmModalTitle"></h3>
            <p class="mt-4 text-sm font-medium text-slate-500" x-text="confirmModalText"></p>
            <form class="mt-8 flex space-x-3" :action="confirmActionUrl" method="POST">
                @csrf
                <div x-html="confirmHiddenInputs"></div>
                <button type="button" @click="isConfirmModalOpen = false" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
                <button type="submit" class="flex-1 py-3 text-white rounded-xl font-bold" :class="confirmModalType === 'danger' ? 'bg-red-600' : 'bg-indigo-600'">Confirm</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function pageManager() {
            return {
                showPayoutModal: false, // Untuk Modal Worker Payout Baru
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