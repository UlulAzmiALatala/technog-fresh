{{-- Location: resources/views/client/orders.blade.php (SOVEREIGN ARCHIVE EDITION) --}}

@push('scripts')
    {{-- Script for Midtrans Snap --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-xl text-gray-900 leading-tight uppercase tracking-tight">
                Order History
            </h2>
            <a href="{{ route('client.services.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
                <i class="fas fa-plus mr-2"></i> Order New Service
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFDFF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Notifications --}}
            @if (session('success'))
                <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-3"></i>
                    <p class="text-[11px] font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif
            
            @if (session('error') || session('info'))
                <div class="mb-8 bg-amber-50 border border-amber-100 text-amber-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" role="alert">
                    <i class="fas fa-info-circle mr-3"></i>
                    <p class="text-[11px] font-black uppercase tracking-widest">{{ session('error') ?? session('info') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 rounded-[2.5rem]">
                <div class="p-8 md:p-10 border-b border-slate-50 bg-slate-50/30">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-2">Filters</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Track and manage all your transactions here.</p>
                        </div>

                        <form action="{{ route('client.orders.index') }}" method="GET" class="flex-grow max-w-2xl">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-slate-300 text-xs"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ORDER ID OR SERVICE NAME..." class="block w-full pl-10 bg-white border-slate-100 focus:border-indigo-500 focus:ring-0 rounded-xl text-[10px] font-black uppercase tracking-widest placeholder-slate-300 transition-all">
                                </div>
                                <div>
                                    <select name="status" class="block w-full bg-white border-slate-100 focus:border-indigo-500 focus:ring-0 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all" onchange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="Menunggu Pembayaran" @selected(request('status') == 'Menunggu Pembayaran')>Pending Payment</option>
                                        <option value="Awaiting Confirmation" @selected(request('status') == 'Awaiting Confirmation')>Awaiting Confirmation</option>
                                        <option value="Diproses" @selected(request('status') == 'Diproses')>Processing</option>
                                        <option value="Selesai" @selected(request('status') == 'Selesai')>Completed</option>
                                        <option value="Dibatalkan" @selected(request('status') == 'Dibatalkan')>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-50">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th scope="col" class="px-8 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Order Info</th>
                                <th scope="col" class="px-8 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Date</th>
                                <th scope="col" class="px-8 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status</th>
                                <th scope="col" class="px-8 py-5 text-right text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Total Amount</th>
                                <th scope="col" class="px-8 py-5 text-center text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-slate-50/80 transition-colors duration-300 group">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-[11px] font-black text-slate-900 uppercase tracking-tighter mb-1 group-hover:text-indigo-600 transition-colors">Order #{{ $order->id }}</div>
                                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ Str::limit($order->detailOrders->first()->service->name ?? 'Custom Service', 35) }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-[10px] font-bold text-slate-500 uppercase tracking-tighter">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span @class([
                                            'px-3 py-1 text-[8px] font-black uppercase tracking-widest rounded-lg border',
                                            'bg-emerald-50 text-emerald-600 border-emerald-100' => $order->status == 'Selesai',
                                            'bg-indigo-50 text-indigo-600 border-indigo-100' => $order->status == 'Diproses' || $order->status == 'Processing',
                                            'bg-rose-50 text-rose-600 border-rose-100' => $order->status == 'Dibatalkan' || $order->status == 'Cancelled',
                                            'bg-amber-50 text-amber-600 border-amber-100' => $order->status == 'Menunggu Pembayaran' || $order->status == 'Awaiting Confirmation' || $order->status == 'Pending Payment',
                                            'bg-slate-50 text-slate-500 border-slate-100' => !in_array($order->status, ['Selesai', 'Diproses', 'Dibatalkan', 'Menunggu Pembayaran', 'Awaiting Confirmation']),
                                        ])>
                                            @switch($order->status)
                                                @case('Selesai') COMPLETED @break
                                                @case('Diproses') PROCESSING @break
                                                @case('Dibatalkan') CANCELLED @break
                                                @case('Menunggu Pembayaran') PENDING PAYMENT @break
                                                @case('Awaiting Confirmation') AWAITING CONFIRMATION @break
                                                @default {{ strtoupper($order->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-black text-slate-900 tracking-tighter">
                                        $ {{ number_format($order->total_price, 2) }}
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-center">
                                        @if ($order->status == 'Menunggu Pembayaran' || $order->status == 'Pending Payment')
                                            @if ($order->snap_token)
                                                <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-900 transition-all pay-button active:scale-95" data-token="{{ $order->snap_token }}" data-order-id="{{ $order->id }}">
                                                    Continue Payment
                                                </button>
                                            @else
                                                <a href="{{ route('client.payment.choose', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-900 transition-all active:scale-95 shadow-md shadow-indigo-100">
                                                    Pay Now
                                                </a>
                                            @endif
                                        @elseif (($order->status == 'Diproses' || $order->status == 'Processing') && $order->payment_type == 'dp' && optional($order->invoice)->status == 'Belum Lunas')
                                            <a href="{{ route('client.payment.settlement', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white text-[9px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-900 transition-all active:scale-95 shadow-md shadow-emerald-100">
                                                Settle Payment
                                            </a>
                                        @else
                                            <a href="{{ route('client.orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-slate-100 text-slate-400 text-[9px] font-black uppercase tracking-widest rounded-xl hover:text-indigo-600 hover:border-indigo-100 transition-all active:scale-95 shadow-sm">
                                                View Details
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center py-24 px-6 bg-slate-50/20">
                                            <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-50">
                                                <i class="fas fa-folder-open text-slate-200 text-3xl"></i>
                                            </div>
                                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] mb-2">No Orders Found</h3>
                                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">You haven't ordered any services yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($orders->hasPages())
                    <div class="p-8 border-t border-slate-50 bg-slate-50/30">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script for Midtrans --}}
    @if(!$orders->isEmpty())
        @push('scripts')
        <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', function () {
            const payButtons = document.querySelectorAll('.pay-button');
            payButtons.forEach(button => {
              button.addEventListener('click', function () {
                const snapToken = this.dataset.token;
                const orderId = this.dataset.orderId;
                if (!snapToken) return;

                window.snap.pay(snapToken, {
                  onSuccess: function(result){
                    let successUrl = "{{ route('client.payment.success', ['order' => ':id']) }}";
                    window.location.href = successUrl.replace(':id', orderId);
                  }
                });
              });
            });
          });
        </script>
        @endpush
    @endif

    @include('layouts.partials.app-footer')
</x-app-layout>