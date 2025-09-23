{{-- Lokasi: resources/views/client/orders.blade.php --}}

@push('scripts')
    {{-- Script untuk Midtrans Snap --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            {{-- Notifikasi Error/Info --}}
            @if (session('error') || session('info'))
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') ?? session('info') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 md:p-8 border-b border-gray-200">
                    <div class="flex justify-between items-center flex-wrap gap-4 mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Kelola Pesanan Anda</h3>
                            <p class="text-sm text-gray-600 mt-1">Lacak, bayar, dan lihat detail semua transaksi Anda di sini.</p>
                        </div>
                        <a href="{{ route('client.services.list') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i> Pesan Layanan Baru
                        </a>
                    </div>

                    <form action="{{ route('client.orders') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan ID Pesanan atau nama layanan..." class="block w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            </div>
                            <div>
                                <select name="status" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" onchange="this.form.submit()">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu Pembayaran" @selected(request('status') == 'Menunggu Pembayaran')>Menunggu Pembayaran</option>
                                    <option value="Diproses" @selected(request('status') == 'Diproses')>Diproses</option>
                                    <option value="Selesai" @selected(request('status') == 'Selesai')>Selesai</option>
                                    <option value="Dibatalkan" @selected(request('status') == 'Dibatalkan')>Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Pesanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">Pesanan #{{ $order->id }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($order->detailOrders->first()->service->name ?? 'Layanan Kustom', 30) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span @class([
                                            'px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            'bg-green-100 text-green-800' => $order->status == 'Selesai',
                                            'bg-yellow-100 text-yellow-800' => $order->status == 'Diproses',
                                            'bg-red-100 text-red-800' => $order->status == 'Dibatalkan',
                                            'bg-blue-100 text-blue-800' => $order->status == 'Menunggu Pembayaran',
                                            'bg-gray-100 text-gray-800' => !in_array($order->status, ['Selesai', 'Diproses', 'Dibatalkan', 'Menunggu Pembayaran']),
                                        ])>
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        @if ($order->status == 'Menunggu Pembayaran')
                                            @if ($order->snap_token)
                                                <button class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 pay-button" data-token="{{ $order->snap_token }}" data-order-id="{{ $order->id }}">
                                                    Lanjutkan
                                                </button>
                                            @else
                                                <a href="{{ route('client.payment.choose', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                                    Bayar
                                                </a>
                                            @endif
                                        @elseif ($order->status == 'Diproses' && $order->payment_type == 'dp' && optional($order->invoice)->status == 'Belum Lunas')
                                            <a href="{{ route('client.payment.settlement', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                                Lunasi
                                            </a>
                                        @else
                                            <a href="{{ route('client.orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                                Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center py-20 px-6">
                                            <i class="fas fa-file-invoice-dollar fa-5x text-gray-300 mb-4"></i>
                                            <h3 class="text-lg font-medium text-gray-900">Belum Ada Riwayat Pesanan</h3>
                                            <p class="mt-1 text-sm text-gray-500">Sepertinya Anda belum memesan layanan apa pun.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($orders->hasPages())
                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script untuk tombol pembayaran Midtrans --}}
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
                  },
                  onPending: function(result){
                    console.log("Payment Pending:", result);
                  },
                  onError: function(result){
                    console.error("Payment Error:", result);
                  },
                  onClose: function(){
                    console.log('Popup pembayaran ditutup.');
                  }
                })
              });
            });
          });
        </script>
        @endpush
    @endif
</x-app-layout>