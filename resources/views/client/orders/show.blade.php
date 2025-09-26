{{-- Location: resources/views/client/orders/show.blade.php --}}

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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- Left Column: Details & Documents --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Order Details Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Order Summary</h3>
                    </div>
                    <div class="p-6 text-gray-900">
                        {{-- Using Definition List for neatness --}}
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

                {{-- Documents & Deliverables Card --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">Documents & Deliverables</h3>
                    </div>
                    <div class="p-6 text-gray-900">
                        {{-- Replace with dynamic data --}}
                        @if(false) 
                            <ul class="space-y-3">
                                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 fa-lg w-6 text-center mr-3"></i>
                                        <span class="text-sm font-medium text-gray-700">Project-Brief-Document.pdf</span>
                                    </div>
                                    <a href="#" class="inline-flex items-center px-3 py-1 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Download</a>
                                </li>
                            </ul>
                        @else
                            <div class="text-center py-10">
                                <i class="fas fa-folder-open fa-3x text-gray-300"></i>
                                <p class="mt-4 text-sm text-gray-500">No documents have been uploaded for this order yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Status & Info --}}
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
                                <dd class="font-semibold">{{ optional($order->payment)->method ?? 'Not Selected' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Status</dt>
                                <dd>
                                    {{-- [PERBAIKAN] Gunakan optional() untuk mengecek status invoice dengan aman --}}
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
                                        'bg-green-200' => $index < $currentStatusIndex,
                                        'bg-indigo-200' => $index == $currentStatusIndex && $order->status != 'Selesai',
                                        'bg-green-200' => $order->status == 'Selesai',
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
</x-app-layout>