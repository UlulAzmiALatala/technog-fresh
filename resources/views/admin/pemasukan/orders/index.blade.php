<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Order Management</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Track & Manage Client Projects</p>
            </div>
        </div>
    </x-slot>

    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8 py-4 relative">

        {{-- KARTU STATISTIK (Didesain ulang ala dashboard modern) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Orders --}}
            <div class="fade-in-item bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden transition-all duration-300" :class="animate ? 'in-view' : ''">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Total Orders</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalOrders }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl shadow-inner">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                </div>
            </div>
            
            {{-- Needs Confirmation --}}
            <div class="fade-in-item bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.1s;">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Needs Confirm</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $pendingConfirmationCount }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-2xl shadow-inner">
                        <i class="fas fa-hourglass-half text-xl"></i>
                    </div>
                </div>
            </div>
            
            {{-- In Progress --}}
            <div class="fade-in-item bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.2s;">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">In Progress</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $inProgressCount }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 rounded-2xl shadow-inner">
                        <i class="fas fa-spinner fa-spin text-xl"></i>
                    </div>
                </div>
            </div>
            
            {{-- Total Revenue --}}
            <div class="fade-in-item bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.3s;">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Total Revenue</p>
                        <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">${{ number_format($totalRevenue, 0) }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl shadow-inner">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTROL PANEL (Search & Filters) --}}
        <div class="fade-in-item bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden transition-all duration-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.4s;">
            <form action="{{ route('admin.pemasukan.orders.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                
                {{-- Search Box --}}
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID or Client Name..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400 dark:text-white outline-none">
                </div>

                {{-- Filter Status --}}
                <div class="md:w-64">
                    <select name="status" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300 outline-none">
                        <option value="">All Statuses</option>
                        <option value="Menunggu Pembayaran" @selected(request('status') == 'Menunggu Pembayaran')>Waiting for Payment</option>
                        <option value="Menunggu Konfirmasi" @selected(request('status') == 'Menunggu Konfirmasi')>Waiting for Confirmation</option>
                        <option value="Diproses" @selected(request('status') == 'Diproses')>In Progress</option>
                        <option value="Selesai" @selected(request('status') == 'Selesai')>Completed</option>
                        <option value="Dibatalkan" @selected(request('status') == 'Dibatalkan')>Cancelled</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request()->hasAny(['search', 'status']) && (request('search') != '' || request('status') != ''))
                    <a href="{{ route('admin.pemasukan.orders.index') }}" 
                       class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </form>
        </div>
        
        {{-- TABLE SECTION --}}
        <div class="fade-in-item bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none transition-all duration-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.5s;">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Order ID</th>
                            <th class="p-6 font-bold">Client Info</th>
                            <th class="p-6 font-bold">Contact & Needs</th> {{-- Kolom Baru --}}
                            <th class="p-6 font-bold text-right">Total Price</th>
                            <th class="p-6 font-bold text-center">Payment</th>
                            <th class="p-6 font-bold text-center">Status</th>
                            <th class="p-6 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                <td class="p-6 whitespace-nowrap text-sm font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                                    #{{ $order->id }}
                                    <div class="text-[10px] text-slate-400 font-bold mt-1">{{ $order->created_at->format('d M Y') }}</div>
                                </td>
                                
                                <td class="p-6 whitespace-nowrap">
                                    <div class="text-sm text-slate-900 dark:text-white font-bold">{{ $order->user->name }}</div>
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium mt-1"><i class="fas fa-envelope mr-1"></i> {{ $order->user->email }}</div>
                                </td>
                                
                                {{-- EKSTRAKSI NOTES UNTUK NOMOR WA & MESSAGE --}}
                                <td class="p-6">
                                    @php
                                        preg_match('/WhatsApp:\s*([^\n]+)/', $order->notes ?? '', $waMatch);
                                        $waNumber = $waMatch[1] ?? '-';
                                        
                                        // Ambil Requirement (baris setelah "Project Requirements:")
                                        $reqText = '-';
                                        if (str_contains($order->notes ?? '', 'Project Requirements:')) {
                                            $parts = explode('Project Requirements:', $order->notes);
                                            $reqText = trim($parts[1] ?? '-');
                                        }
                                    @endphp
                                    
                                    @if($waNumber !== '-')
                                        <div class="flex items-center text-xs text-emerald-600 dark:text-emerald-400 font-bold mb-1">
                                            <i class="fab fa-whatsapp mr-1.5 text-sm"></i> {{ $waNumber }}
                                        </div>
                                    @endif
                                    
                                    <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium line-clamp-2 max-w-[200px]" title="{{ $reqText }}">
                                        {{ $reqText }}
                                    </div>
                                </td>

                                <td class="p-6 whitespace-nowrap text-right font-black text-slate-900 dark:text-white text-lg tracking-tight">
                                    $ {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                
                                {{-- PAYMENT BADGE --}}
                                <td class="p-6 whitespace-nowrap text-center">
                                    @if(optional($order->invoice)->status == 'Paid')
                                        <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-check-circle mr-1.5"></i> Paid
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-200/50 dark:border-amber-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-clock mr-1.5"></i> Unpaid
                                        </span>
                                    @endif
                                </td>

                                {{-- STATUS BADGE --}}
                                <td class="p-6 whitespace-nowrap text-center">
                                    <span @class([
                                        'px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border flex items-center justify-center w-max mx-auto',
                                        'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-800/50' => $order->status == 'Selesai' || $order->status == 'Completed',
                                        'bg-blue-50 text-blue-600 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-800/50' => $order->status == 'Diproses' || $order->status == 'Processing',
                                        'bg-orange-50 text-orange-600 border-orange-200 dark:bg-orange-500/10 dark:text-orange-400 dark:border-orange-800/50' => $order->status == 'Menunggu Konfirmasi' || $order->status == 'Awaiting Confirmation',
                                        'bg-slate-100 text-slate-600 border-slate-300 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-600' => $order->status == 'Menunggu Pembayaran' || $order->status == 'Pending Payment',
                                        'bg-red-50 text-red-600 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-800/50' => $order->status == 'Dibatalkan' || $order->status == 'Cancelled',
                                    ])>
                                        @switch($order->status)
                                            @case('Selesai') 
                                            @case('Completed') <i class="fas fa-check-double mr-1.5"></i> Completed @break
                                            @case('Diproses') 
                                            @case('Processing') <i class="fas fa-cogs mr-1.5"></i> In Progress @break
                                            @case('Menunggu Konfirmasi') 
                                            @case('Awaiting Confirmation') <i class="fas fa-search-dollar mr-1.5"></i> Reviewing @break
                                            @case('Menunggu Pembayaran') 
                                            @case('Pending Payment') <i class="fas fa-wallet mr-1.5"></i> Pending @break
                                            @case('Dibatalkan') 
                                            @case('Cancelled') <i class="fas fa-ban mr-1.5"></i> Cancelled @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </span>
                                </td>
                                
                                {{-- ACTION BUTTON --}}
                                <td class="p-6 text-center">
                                    <div class="flex justify-center opacity-70 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.pemasukan.orders.show', $order->id) }}" 
                                           class="h-10 px-4 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 font-bold text-xs uppercase tracking-widest rounded-xl transition-colors shadow-sm">
                                            Details <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-24 text-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                        <i class="fas fa-box-open text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No orders found or matching the criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- PAGINATION STYLING --}}
        @if ($orders->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
    
    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>