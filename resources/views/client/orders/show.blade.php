{{-- Location: resources/views/client/orders/show.blade.php (SOVEREIGN EDITION) --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('client.orders.index') }}" class="text-gray-400 hover:text-indigo-600 transition-colors duration-200 mr-4 p-2 rounded-xl hover:bg-indigo-50">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <span class="block text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] leading-none mb-1">Administrative Registry</span>
                <h2 class="font-black text-xl text-gray-900 leading-tight uppercase tracking-tight">
                    Order Details #{{ $order->id }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#FDFDFF] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-3"></i>
                    <p class="text-[11px] font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-8 bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <p class="text-[11px] font-black uppercase tracking-widest">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
                {{-- Left Column: Summary & Review --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- Order Summary Card --}}
                    <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 rounded-[2.5rem]">
                        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Order Summary</h3>
                        </div>
                        <div class="p-10 text-gray-900">
                            <dl class="space-y-6">
                                @foreach ($order->detailOrders as $detail)
                                    <div class="flex justify-between items-center group">
                                        <div>
                                            <dt class="text-sm font-black text-gray-800 uppercase tracking-tight">
                                                {{ $detail->service->name }}
                                            </dt>
                                            <dd class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Quantity: {{ $detail->quantity }} Units</dd>
                                        </div>
                                        <dd class="text-sm font-black text-gray-900">
                                            $ {{ number_format($detail->price, 2) }}
                                        </dd>
                                    </div>
                                @endforeach

                                <div class="pt-8 border-t border-slate-50">
                                    @if($order->discount_amount > 0)
                                        <div class="flex justify-between items-center mb-4">
                                            <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Promotional Credit</dt>
                                            <dd class="text-sm font-black text-red-500">- $ {{ number_format($order->discount_amount, 2) }}</dd>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <dt class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Valuation</dt>
                                            <dd class="text-3xl font-black text-indigo-600 tracking-tighter">
                                                $ {{ number_format($order->total_price, 2) }}
                                            </dd>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest 
                                                @if($order->status == 'Selesai') bg-emerald-50 text-emerald-600 border border-emerald-100 
                                                @else bg-indigo-50 text-indigo-600 border border-indigo-100 @endif">
                                                {{-- Status Mapping --}}
                                                @switch($order->status)
                                                    @case('Menunggu Pembayaran') Pending Payment @break
                                                    @case('Awaiting Confirmation') Awaiting Confirmation @break
                                                    @case('Diproses') Processing @break
                                                    @case('Selesai') Completed @break
                                                    @case('Dibatalkan') Cancelled @break
                                                    @default {{ $order->status }}
                                                @endswitch
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Review Section (Only for Completed Orders) --}}
                    @if ($order->status == 'Selesai')
                        <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 rounded-[2.5rem]">
                            <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Rate Our Service</h3>
                            </div>
                            <div class="p-10">
                                @if ($order->testimonial)
                                    <div class="bg-slate-50/50 p-8 rounded-[2rem] border border-slate-100">
                                        <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4">Review Submitted</p>
                                        <div class="flex items-center mb-6 space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs {{ $i <= $order->testimonial->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                        <blockquote class="text-sm font-bold text-slate-600 leading-relaxed uppercase tracking-tight">
                                            "{{ $order->testimonial->content }}"
                                        </blockquote>
                                    </div>
                                @else
                                    <form action="{{ route('client.orders.testimonial.store', $order->id) }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                                        @csrf
                                        <div class="space-y-8">
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Select Rating</label>
                                                <div class="flex items-center space-x-2">
                                                    <template x-for="star in 5" :key="star">
                                                        <button type="button" @click="rating = star" @mouseenter="hoverRating = star" @mouseleave="hoverRating = 0"
                                                                class="text-3xl transition-all duration-300 transform focus:outline-none"
                                                                :class="(hoverRating >= star || rating >= star) ? 'text-amber-400 scale-110' : 'text-slate-200 scale-100'">
                                                            <i class="fas fa-star"></i>
                                                        </button>
                                                    </template>
                                                </div>
                                                <input type="hidden" name="rating" x-model="rating">
                                                @error('rating') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 block">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="content" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Your Feedback</label>
                                                <textarea name="content" id="content" rows="4" class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 text-sm font-bold placeholder-slate-300 focus:border-indigo-500 focus:ring-0 transition-all" 
                                                          placeholder="SHARE YOUR EXPERIENCE..." required>{{ old('content') }}</textarea>
                                                @error('content') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 block">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="flex justify-end">
                                                <button type="submit" class="px-8 py-4 bg-slate-900 text-white text-[10px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-indigo-600 transition-all active:scale-95 shadow-xl shadow-slate-200">
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

                {{-- Right Column: Status & Info --}}
                <div class="lg:col-span-1 space-y-10">
                    
                    {{-- Payment Info Card --}}
                    <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 rounded-[2.5rem]">
                        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Payment Information</h3>
                        </div>
                        <div class="p-8">
                            <dl class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Method</dt>
                                    <dd class="text-[10px] font-black text-gray-900 uppercase">{{ optional($order->invoice)->payment_method ?? 'Not Selected' }}</dd>
                                </div>
                                <div class="flex justify-between items-center">
                                    <dt class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</dt>
                                    <dd>
                                        <span class="px-3 py-1 text-[9px] font-black uppercase rounded-lg border {{ optional($order->invoice)->status == 'Lunas' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                            {{ optional($order->invoice)->status == 'Lunas' ? 'Paid' : 'Unpaid' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>

                            {{-- CORRECT ROUTE DOWNLOAD --}}
                            @if (optional($order->invoice)->status == 'Lunas')
                                <div class="mt-8">
                                    <a href="{{ route('client.payment.invoice_pdf', $order->id) }}" 
                                       target="_blank" 
                                       class="w-full inline-flex items-center justify-center px-6 py-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-[0.15em] rounded-2xl hover:bg-slate-900 shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                        <i class="fas fa-file-download mr-2"></i>
                                        Download Invoice (PDF)
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Order Status Timeline --}}
                    <div class="bg-white overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-100 rounded-[2.5rem]">
                        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Order Status</h3>
                        </div>
                        <div class="p-8">
                            @php
                                $statuses = ['Menunggu Pembayaran', 'Diproses', 'Selesai'];
                                $currentStatusIndex = array_search($order->status, $statuses);
                            @endphp
                            <ol class="relative border-l-2 border-slate-100 ml-4">                  
                                @foreach ($statuses as $index => $status)
                                    <li class="mb-10 ml-8">            
                                        <span @class([
                                            'absolute flex items-center justify-center w-6 h-6 rounded-lg -left-[13px] ring-4 ring-white shadow-sm',
                                            'bg-emerald-500 text-white' => $index < $currentStatusIndex || $order->status == 'Selesai',
                                            'bg-indigo-600 text-white animate-pulse' => $index == $currentStatusIndex && $order->status != 'Selesai',
                                            'bg-slate-100 text-slate-300' => $index > $currentStatusIndex,
                                        ])>
                                            @if ($index < $currentStatusIndex || $order->status == 'Selesai')
                                                <i class="fas fa-check text-[10px]"></i>
                                            @elseif ($index == $currentStatusIndex)
                                                <i class="fas fa-sync-alt fa-spin text-[10px]"></i>
                                            @else
                                                <i class="fas fa-clock text-[10px]"></i>
                                            @endif
                                        </span>
                                        <h4 @class([
                                            'text-[11px] font-black uppercase tracking-widest',
                                            'text-gray-900' => $index <= $currentStatusIndex,
                                            'text-slate-300' => $index > $currentStatusIndex,
                                        ])>
                                            @switch($status)
                                                @case('Menunggu Pembayaran') Pending Payment @break
                                                @case('Diproses') In Progress @break
                                                @case('Selesai') Completed @break
                                                @default {{ $status }}
                                            @endswitch
                                        </h4>
                                        @if ($index == 0 && ($order->status == 'Menunggu Pembayaran' || $order->status == 'Awaiting Confirmation'))
                                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">Awaiting settlement confirmation.</p>
                                        @elseif($index == 1 && $order->status == 'Diproses')
                                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">Our team is working on your project.</p>
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