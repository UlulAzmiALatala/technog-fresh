{{-- Location: resources/views/client/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Welcome Banner with SVG Background --}}
            <div class="relative bg-gradient-to-r from-indigo-800 to-sky-500 rounded-lg shadow-lg overflow-hidden">
                <div class="absolute inset-0">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                        <path fill="#ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,186.7C384,192,480,224,576,245.3C672,267,768,277,864,256C960,235,1056,181,1152,154.7C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>
                <div class="relative p-8">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 text-indigo-200">All your project progress is right here.</p>
                        </div>
                        <a href="{{ route('client.services.list') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>
                            Order New Service
                        </a>
                    </div>
                </div>
            </div>

            {{-- Performance Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center gap-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-gray-900">{{ $completedProjectsCount }}</p>
                        <p class="text-sm font-medium text-gray-500">Completed Projects</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center gap-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                        <i class="fas fa-tasks text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-gray-900">{{ $activeProjectsCount }}</p>
                        <p class="text-sm font-medium text-gray-500">Active Projects</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center gap-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="relative w-20 h-20">
                        <svg class="w-full h-full" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb" stroke-width="4" />
                            <path class="text-green-500 transition-all duration-1000" stroke="currentColor" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="4" stroke-dasharray="{{ $onTimeCompletionRate }}, 100" stroke-linecap="round" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xl font-bold text-gray-900">{{ $onTimeCompletionRate }}<small>%</small></span>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <p class="text-base font-semibold text-gray-800">On-Time</p>
                        <p class="text-sm text-gray-500">Success Rate</p>
                    </div>
                </div>
            </div>
            
            @if($pendingApprovalCount > 0)
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><i class="fas fa-exclamation-triangle text-orange-500 mr-4 text-2xl"></i></div>
                    <div>
                        <p class="font-bold">Awaiting Your Response</p>
                        <p class="text-sm">There are <strong>{{ $pendingApprovalCount }} project(s)</strong> that require your approval to proceed.</p>
                    </div>
                    <div class="ml-auto">
                        <a href="#" class="inline-block bg-orange-500 text-white font-bold py-2 px-4 rounded hover:bg-orange-600 transition">View Details</a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Main Layout: Order History & Active Project --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Order History --}}
                <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Project Activity</h3>
                        <a href="{{ route('client.orders') }}" class="font-medium text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                        <a href="{{ route('client.orders.show', $order->id) }}">{{ $order->order_id }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ Str::limit($order->detailOrders->first()->service->name ?? 'Custom Service', 25) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($order->status)
                                                @case('Selesai') bg-green-100 text-green-800 @break
                                                @case('Diproses') bg-yellow-100 text-yellow-800 @break
                                                @case('Dibatalkan') bg-red-100 text-red-800 @break
                                                @case('Menunggu Pembayaran') bg-blue-100 text-blue-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch
                                        ">{{ $order->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-800">${{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                        <i class="fas fa-box-open fa-3x text-gray-300 mb-4"></i><br>
                                        You have no order history yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Right Column: Top Active Project & Quick Access --}}
                <div class="space-y-8">
                    <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Active Project</h3>
                        @if($activeProject)
                            <div class="space-y-5">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ $activeProject->order_id }}</p>
                                    <p class="text-base font-semibold text-gray-800 mt-1">{{ $activeProject->detailOrders->first()->service->name ?? 'Custom Service' }}</p>
                                    @if($activeProject->due_date)
                                    <p class="text-xs text-gray-500 mt-2"><i class="far fa-calendar-alt mr-1.5"></i> Estimated Completion: {{ $activeProject->due_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                                        <span>Progress</span>
                                        <span class="font-semibold text-indigo-600">{{ $activeProject->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-gradient-to-r from-sky-500 to-indigo-600 h-2.5 rounded-full" style="width: {{ $activeProject->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <a href="{{ route('client.orders.show', $activeProject->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition">View Project Details</a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 border-2 border-dashed rounded-lg">
                               <i class="far fa-folder-open fa-3x text-gray-400"></i>
                                <h3 class="mt-4 text-sm font-medium text-gray-900">No active projects</h3>
                                <p class="mt-1 text-sm text-gray-500">Start a new project to begin.</p>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Quick Access Card --}}
                    <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Access</h3>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center p-3 -m-3 text-base font-medium text-gray-600 rounded-lg hover:bg-gray-100 transition ease-in-out duration-150">
                               <i class="fas fa-file-invoice-dollar w-6 h-6 text-indigo-500 mr-4"></i>
                                <span>View Invoices & Payments</span>
                            </a>
                            <a href="#" class="flex items-center p-3 -m-3 text-base font-medium text-gray-600 rounded-lg hover:bg-gray-100 transition ease-in-out duration-150">
                                <i class="fas fa-headset w-6 h-6 text-indigo-500 mr-4"></i>
                                <span>Contact Support Center</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>