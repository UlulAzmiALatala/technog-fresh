<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Management') }}
            </h2>
            <a href="{{ route('admin.pemasukan.services.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Service
            </a>
        </div>
    </x-slot>

    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8">

        {{-- [BARU] Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalOrders }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Needs Confirmation</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingConfirmationCount }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 rounded-full">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.2s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">In Progress</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $inProgressCount }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-400 rounded-full">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.3s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Revenue</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($totalRevenue, 0) }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-full">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="fade-in-item bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl transition-all duration-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.4s;">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <form action="{{ route('admin.pemasukan.orders.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md leading-5 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by Order ID or Client Name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div>
                            <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="Menunggu Pembayaran" @selected(request('status') == 'Menunggu Pembayaran')>Waiting for Payment</option>
                                <option value="Menunggu Konfirmasi" @selected(request('status') == 'Menunggu Konfirmasi')>Waiting for Confirmation</option>
                                <option value="Diproses" @selected(request('status') == 'Diproses')>In Progress</option>
                                <option value="Selesai" @selected(request('status') == 'Selesai')>Completed</option>
                                <option value="Dibatalkan" @selected(request('status') == 'Dibatalkan')>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Total Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 dark:text-indigo-400">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900 dark:text-white font-semibold">$ {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    @if(optional($order->invoice)->status == 'Lunas')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Paid</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Unpaid</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <span @class([
                                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                'bg-green-100 text-green-800' => $order->status == 'Selesai',
                                                'bg-yellow-100 text-yellow-800' => $order->status == 'Diproses',
                                                'bg-orange-100 text-orange-800' => $order->status == 'Menunggu Konfirmasi',
                                                'bg-blue-100 text-blue-800' => $order->status == 'Menunggu Pembayaran',
                                                'bg-red-100 text-red-800' => $order->status == 'Dibatalkan',
                                            ])>
                                                @switch($order->status)
                                                    @case('Selesai') Completed @break
                                                    @case('Diproses') In Progress @break
                                                    @case('Menunggu Konfirmasi') Awaiting Confirmation @break
                                                    @case('Menunggu Pembayaran') Awaiting Payment @break
                                                    @case('Dibatalkan') Cancelled @break
                                                    @default {{ $order->status }}
                                                @endswitch
                                            </span>
                                        </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.pemasukan.orders.show', $order->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-20 whitespace-nowrap text-center text-sm text-gray-500 dark:text-slate-400">
                                    <i class="fas fa-box-open fa-3x text-gray-300 dark:text-slate-600 mb-3"></i>
                                    <p>No orders found or matching the criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($orders->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
    
    {{-- CSS untuk animasi fade-in --}}
    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>