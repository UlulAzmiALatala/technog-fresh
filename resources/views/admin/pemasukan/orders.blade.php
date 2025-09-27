<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Search & Filter Feature --}}
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('admin.pemasukan.orders.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                </div>
                                <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by Order ID or Client Name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div>
                            <label for="status" class="sr-only">Filter by status</label>
                            <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Type</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$ {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($order->payment_type == 'dp')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">DP</span>
                                            @elseif($order->payment_type == 'full')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-100 text-cyan-800">Full</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if(optional($order->invoice)->status == 'Lunas')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                            @elseif(optional($order->invoice)->status == 'Belum Lunas')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Unpaid</span>
                                            @else
                                                <span class="text-gray-400">-</span>
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
                                            <a href="{{ route('admin.pemasukan.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-20 whitespace-nowrap text-center text-sm text-gray-500">
                                            <i class="fas fa-box-open fa-3x text-gray-300 mb-3"></i>
                                            <p>No orders found or matching the criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if ($orders->hasPages())
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>