{{-- Lokasi: resources/views/client/payment/midtrans.blade.php --}}

@push('scripts')
    {{-- Script untuk Midtrans Snap --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- [PERBAIKAN 1] Menggunakan komponen progress bar standar --}}
            <x-payment-steps :step="2" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-gray-900 text-center">
                    <h3 class="text-xl font-bold">Langkah 2: Selesaikan Pembayaran</h3>
                    <p class="text-gray-600 text-sm mt-2">Jendela pembayaran Midtrans akan segera terbuka. Jika tidak, silakan klik tombol di bawah ini.</p>
                    
                    <div class="my-8">
                        <svg class="mx-auto h-16 w-16 text-indigo-400 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <p class="text-gray-600 text-sm">Menunggu Anda menyelesaikan pembayaran...</p>

                    <button id="pay-button" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Buka Jendela Pembayaran
                    </button>
                </div>

                <div class="p-6 bg-gray-50 flex items-center justify-start">
                    {{-- [PERBAIKAN 2] Link kembali disesuaikan berdasarkan alur pembayaran --}}
                    @if ($order->status == 'Diproses' && $order->payment_type == 'dp')
                        {{-- Jika ini alur pelunasan, kembali ke halaman settlement --}}
                        <a href="{{ route('client.payment.settlement', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Pilih Metode Lain
                        </a>
                    @else
                        {{-- Jika ini alur pembayaran awal, kembali ke halaman choose --}}
                         <a href="{{ route('client.payment.choose', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            &larr; Pilih Metode Lain
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Fungsi untuk membuka popup Snap
        function openSnap() {
            // [PERBAIKAN 3] Cek dulu apakah snap_token ada
            const snapToken = '{{ $order->snap_token }}';
            if (!snapToken) {
                console.error('Snap Token tidak ditemukan!');
                alert('Terjadi kesalahan. Snap Token tidak tersedia.');
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    window.location.href = "{{ route('client.payment.success', $order->id) }}";
                },
                onPending: function(result){
                    console.log("Payment Pending:", result);
                },
                onError: function(result){
                    console.error("Payment Error:", result);
                    alert('Pembayaran Gagal!');
                },
                onClose: function(){
                    console.log('Popup pembayaran ditutup.');
                }
            });
        }

        // Panggil fungsi Snap saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            openSnap();
        });

        // Beri event listener juga untuk tombol, sebagai fallback
        document.getElementById('pay-button').addEventListener('click', function() {
            openSnap();
        });
    </script>
    @endpush
</x-app-layout>