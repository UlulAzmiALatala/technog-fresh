<x-admin-layout x-data="imageViewer()">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details #') }}{{ $order->id }}
            </h2>
            <a href="{{ route('admin.pemasukan.orders.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Order List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left Column: Information & Verification --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Payment History & Verification Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-history mr-3 text-gray-500"></i>
                                Payment History & Verification
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @if($order->invoice && $order->invoice->payments->isNotEmpty())
                                @foreach ($order->invoice->payments->sortByDesc('created_at') as $payment)
                                    <div class="flex items-start justify-between p-4 rounded-lg {{ !$payment->payment_date ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50' }}">
                                        <div class="flex items-start">
                                            <img @click="open('{{ asset('storage/' . $payment->payment_proof) }}')" src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment Proof" class="w-20 h-20 object-cover rounded-md border mr-4 cursor-pointer hover:opacity-80 transition-opacity">
                                            <div>
                                                <p class="font-bold text-gray-800">$ {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500">Submitted on: {{ $payment->created_at->format('d M Y, H:i') }}</p>
                                                @if($payment->payment_date)
                                                    <p class="text-xs text-green-600 font-medium">Verified on: {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if(!$payment->payment_date)
                                            <div class="flex items-center space-x-2 flex-shrink-0">
                                                <form action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to APPROVE this payment?');">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <input type="hidden" name="action" value="accept">
                                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-xs font-medium flex items-center">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pemasukan.orders.verifyPayment', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to REJECT this payment?');">
                                                    @csrf
                                                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                    <input type="hidden" name="action" value="reject">
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-medium flex items-center">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">No payment history for this order.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Client Information Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-user-circle mr-3 text-gray-500"></i>
                                Client Information
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                            <div>
                                <p class="text-gray-500">Name</p>
                                <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            </div>
                             <div>
                                <p class="text-gray-500">Email</p>
                                <p class="font-medium text-gray-900">{{ $order->user->email }}</p>
                            </div>
                             <div>
                                <p class="text-gray-500">Order Date</p>
                                <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Column: Status & Service Details --}}
                <div class="space-y-6">
                    {{-- Financial Summary Card --}}
                     <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center"><i class="fas fa-dollar-sign mr-3 text-gray-500"></i>Financial Summary</h3>
                        </div>
                        <div class="p-6 text-sm">
                           <dl class="space-y-4">
                               <div class="flex justify-between items-center">
                                   <dt class="text-gray-500">Payment Type</dt>
                                   <dd class="font-medium text-gray-900">
                                       @if($order->payment_type == 'dp')
                                           <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Down Payment (DP)</span>
                                       @elseif($order->payment_type == 'full')
                                           <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-100 text-cyan-800">Full Payment</span>
                                       @else
                                           <span class="text-gray-500">Not Selected</span>
                                       @endif
                                   </dd>
                               </div>
                               <div class="flex justify-between items-center">
                                   <dt class="text-gray-500">Total Invoice</dt>
                                   <dd class="font-semibold text-gray-900">$ {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                               </div>
                               <div class="flex justify-between items-center">
                                   <dt class="text-gray-500">Verified Amount</dt>
                                   <dd class="font-semibold text-green-600">$ {{ number_format($amountPaid, 0, ',', '.') }}</dd>
                               </div>
                               <div class="border-t my-2"></div>
                               <div class="flex justify-between items-center text-base">
                                   <dt class="font-bold text-gray-800">Remaining Bill</dt>
                                   <dd class="font-bold {{ $remainingAmount > 0 ? 'text-red-600' : 'text-gray-800' }}">
                                       $ {{ number_format($remainingAmount, 0, ',', '.') }}
                                   </dd>
                               </div>
                           </dl>
                        </div>
                    </div>
                    
                    {{-- Update Status Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-tasks mr-3 text-gray-500"></i>Order Status</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.pemasukan.orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label for="status" class="block text-sm font-medium text-gray-700">Manual Status Update</label>
                                <div class="mt-1 flex items-center">
                                    <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="Menunggu Pembayaran" @selected($order->status == 'Menunggu Pembayaran')>Waiting for Payment</option>
                                        <option value="Menunggu Konfirmasi" @selected($order->status == 'Menunggu Konfirmasi')>Waiting for Confirmation</option>
                                        <option value="Diproses" @selected($order->status == 'Diproses')>In Progress</option>
                                        <option value="Selesai" @selected($order->status == 'Selesai')>Completed</option>
                                        <option value="Dibatalkan" @selected($order->status == 'Dibatalkan')>Cancelled</option>
                                    </select>
                                    <button type="submit" class="ml-3 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Ordered Services Card --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-concierge-bell mr-3 text-gray-500"></i>Ordered Services</h3>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                @forelse ($order->detailOrders as $detail)
                                    <li class="text-sm text-gray-700 flex justify-between items-center">
                                        <span>{{ $detail->service->name }} (x{{$detail->quantity}})</span>
                                        <span class="font-medium">$ {{ number_format($detail->price, 0, ',', '.') }}</span>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-500">No service details.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Viewer Modal --}}
    <div x-show="show" x-cloak
         @keydown.escape.window="close()"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
        
        <div @click.away="close()" 
             class="relative w-full h-full flex items-center justify-center">

            {{-- Toolbar --}}
            <div class="absolute top-4 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-2 bg-gray-800 bg-opacity-75 text-white p-2 rounded-lg">
                <button @click="zoomIn()" title="Zoom In" class="w-10 h-10 hover:bg-gray-700 rounded-md"><i class="fas fa-search-plus"></i></button>
                <button @click="zoomOut()" title="Zoom Out" class="w-10 h-10 hover:bg-gray-700 rounded-md"><i class="fas fa-search-minus"></i></button>
                <button @click="reset()" title="Reset Zoom" class="w-10 h-10 hover:bg-gray-700 rounded-md"><i class="fas fa-expand"></i></button>
            </div>
            
            {{-- Close Button --}}
            <button @click="close()" class="absolute top-4 right-4 z-20 w-10 h-10 bg-gray-800 bg-opacity-75 text-white rounded-full flex items-center justify-center hover:bg-gray-700">
                <i class="fas fa-times"></i>
            </button>
            
            {{-- Image Container --}}
            <div class="w-full h-full overflow-hidden" 
                 @wheel.prevent="handleWheel($event)">
                <img :src="imageUrl" 
                     class="absolute top-1/2 left-1/2 transition-transform duration-200 cursor-grab" 
                     :style="`transform: translate(-50%, -50%) scale(${scale}) translateX(${translateX}px) translateY(${translateY}px);`"
                     @mousedown="startPan($event)">
            </div>
        </div>
    </div>

    {{-- JavaScript for Image Viewer --}}
    <script>
        function imageViewer() {
            return {
                show: false,
                imageUrl: '',
                scale: 1,
                translateX: 0,
                translateY: 0,
                isPanning: false,
                panStartX: 0,
                panStartY: 0,

                open(url) {
                    this.imageUrl = url;
                    this.show = true;
                    this.reset();
                },
                close() {
                    this.show = false;
                },
                zoomIn() {
                    this.scale = Math.min(3, this.scale + 0.2); // Batasi maks zoom 3x
                },
                zoomOut() {
                    this.scale = Math.max(0.2, this.scale - 0.2); // Batasi min zoom 0.2x
                },
                reset() {
                    this.scale = 1;
                    this.translateX = 0;
                    this.translateY = 0;
                },
                handleWheel(event) {
                    if (event.deltaY < 0) {
                        this.zoomIn();
                    } else {
                        this.zoomOut();
                    }
                },
                startPan(event) {
                    event.preventDefault();
                    this.isPanning = true;
                    this.panStartX = event.clientX - this.translateX;
                    this.panStartY = event.clientY - this.translateY;
                    
                    const handleMouseMove = (e) => {
                        if (!this.isPanning) return;
                        this.translateX = e.clientX - this.panStartX;
                        this.translateY = e.clientY - this.panStartY;
                    };

                    const handleMouseUp = () => {
                        this.isPanning = false;
                        window.removeEventListener('mousemove', handleMouseMove);
                        window.removeEventListener('mouseup', handleMouseUp);
                    };

                    window.addEventListener('mousemove', handleMouseMove);
                    window.addEventListener('mouseup', handleMouseUp);
                }
            }
        }
    </script>
</x-admin-layout>