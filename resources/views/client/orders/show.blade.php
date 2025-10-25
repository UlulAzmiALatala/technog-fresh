<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('client.orders') }}" class="text-gray-400 hover:text-gray-700 transition-colors duration-200 mr-2 p-1 rounded-full hover:bg-gray-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order Details #{{ $order->id }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Menampilkan pesan sukses atau error dari session --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
                {{-- Left Column: Details & Documents --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Order Details Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Order Summary</h3>
                        </div>
                        <div class="p-6 text-gray-900">
                            <dl class="space-y-4 text-sm">
                                @foreach ($order->detailOrders as $detail)
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-600">{{ $detail->service->name }} (x{{ $detail->quantity }})</dt>
                                        <dd class="font-semibold">$ {{ number_format($detail->price, 0, ',', '.') }}</dd>
                                    </div>
                                @endforeach
                                <div class="border-t border-gray-200 !my-6"></div>
                                <div class="flex justify-between text-base">
                                    <dt class="text-gray-800 font-bold">Total Payment</dt>
                                    <dd class="font-bold text-indigo-600">$ {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- =================================================================== --}}
                    {{-- BAGIAN BARU: Form Testimoni atau Tampilan Testimoni yang Sudah Ada --}}
                    {{-- =================================================================== --}}
                    @if ($order->status == 'Selesai')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900">Project Review</h3>
                            </div>
                            <div class="p-6 text-gray-900">
                                @if ($order->testimonial)
                                    {{-- Tampilan jika testimoni sudah ada --}}
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Thank you for your feedback!</p>
                                        <div class="flex items-center mb-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $order->testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        <blockquote class="border-l-4 border-gray-200 pl-4 italic text-gray-700">
                                            "{{ $order->testimonial->content }}"
                                        </blockquote>
                                    </div>
                                @else
                                    {{-- Tampilan form jika testimoni belum ada --}}
                                    <form action="{{ route('client.orders.testimonial.store', $order->id) }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block font-medium text-sm text-gray-700 mb-1">Your Rating</label>
                                                <div class="flex items-center space-x-1">
                                                    <template x-for="star in 5" :key="star">
                                                        <button type="button" @click="rating = star" @mouseenter="hoverRating = star" @mouseleave="hoverRating = 0"
                                                                class="text-2xl transition-colors"
                                                                :class="(hoverRating >= star || rating >= star) ? 'text-yellow-400' : 'text-gray-300'">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </template>
                                                </div>
                                                <input type="hidden" name="rating" x-model="rating">
                                                @error('rating') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="content" class="block font-medium text-sm text-gray-700">Your Review</label>
                                                <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                                          placeholder="Tell us about your experience with our service..." required>{{ old('content') }}</textarea>
                                                @error('content') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="flex justify-end">
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                                    Submit Review
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Right Column: Status & Info (tidak berubah) --}}
                <div class="lg:col-span-1 space-y-8">
                    {{-- Payment Info Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Payment Information</h3>
                        </div>
                        <div class="p-6">
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Method</dt>
                                    <dd class="font-semibold">{{ optional($order->invoice)->payment_method ?? 'Not Selected' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Status</dt>
                                    <dd>
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ optional($order->invoice)->status == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}
                                        ">
                                            {{ optional($order->invoice)->status == 'Lunas' ? 'Paid' : 'Unpaid' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Order Progress Card (Dynamic Timeline) --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900">Order Progress</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $statuses = ['Menunggu Pembayaran', 'Diproses', 'Selesai'];
                                $currentStatusIndex = array_search($order->status, $statuses);
                            @endphp
                            <ol class="relative border-l border-gray-200">                  
                                @foreach ($statuses as $index => $status)
                                    <li class="mb-10 ml-6">            
                                        <span @class([
                                            'absolute flex items-center justify-center w-6 h-6 rounded-full -left-3 ring-8 ring-white',
                                            'bg-green-200' => $index < $currentStatusIndex || $order->status == 'Selesai',
                                            'bg-indigo-200' => $index == $currentStatusIndex && $order->status != 'Selesai',
                                            'bg-gray-200' => $index > $currentStatusIndex,
                                        ])>
                                            @if ($index < $currentStatusIndex || $order->status == 'Selesai')
                                                <i class="fas fa-check text-green-600 text-xs"></i>
                                            @elseif ($index == $currentStatusIndex)
                                                <i class="fas fa-spinner fa-spin text-indigo-600 text-xs"></i>
                                            @else
                                                <i class="fas fa-clock text-gray-500 text-xs"></i>
                                            @endif
                                        </span>
                                        <h4 @class([
                                            'mb-1 text-base font-semibold',
                                            'text-gray-900' => $index <= $currentStatusIndex,
                                            'text-gray-400' => $index > $currentStatusIndex,
                                        ])>
                                            @switch($status)
                                                @case('Menunggu Pembayaran') Waiting for Payment @break
                                                @case('Diproses') In Progress @break
                                                @case('Selesai') Completed @break
                                                @default {{ $status }}
                                            @endswitch
                                        </h4>
                                        @if ($index == 0 && $order->status == 'Menunggu Pembayaran')
                                            <p class="text-sm text-gray-500">Awaiting your payment.</p>
                                        @elseif($index == 1 && $order->status == 'Diproses')
                                            <p class="text-sm text-gray-500">Our team is working on your order.</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
