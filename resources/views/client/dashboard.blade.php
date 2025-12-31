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
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ffffff" fill-opacity="0.1" d="M0,224L48,213.3C96,203,192,181,288,186.7C384,192,480,224,576,245.3C672,267,768,277,864,256C960,235,1056,181,1152,154.7C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
                </div>
                <div class="relative p-8">
                    <div class="flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 text-indigo-200">All your project progress is right here.</p>
                        </div>
                        <a href="{{ route('client.services.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-transform transform hover:scale-105 whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>
                            Order New Service
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kartu Statistik Performa (Desain Terang & Modern) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
                {{-- Card 1: Active Projects --}}
                <div class="p-6 rounded-lg bg-white border border-gray-200 shadow-sm flex items-center gap-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                        <i class="fas fa-tasks text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-gray-900">{{ $activeProjectsCount }}</p>
                        <p class="text-sm font-medium text-gray-500">Active Projects</p>
                    </div>
                </div>

                {{-- Card 2: Completed Projects --}}
                <div class="p-6 rounded-lg bg-white border border-gray-200 shadow-sm flex items-center gap-6 transform hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-gray-900">{{ $completedProjectsCount }}</p>
                        <p class="text-sm font-medium text-gray-500">Completed Projects</p>
                    </div>
                </div>

                {{-- Card 3: Call-to-Action --}}
                <a href="{{ route('client.services.index') }}" class="group block p-6 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between h-full">
                        <div class="flex-grow">
                            <p class="text-lg font-bold text-white">Ready for your next project?</p>
                            <p class="text-sm text-purple-200 mt-1">Explore our services and let's create something great.</p>
                        </div>
                        <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center bg-white/20 text-white rounded-full group-hover:bg-white/30 transition-colors">
                            <i class="fas fa-arrow-right text-2xl transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>

            </div>
            
            {{-- Alert untuk Persetujuan Klien --}}
            @if($pendingApprovalCount > 0)
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><i class="fas fa-exclamation-triangle text-orange-500 mr-4 text-2xl"></i></div>
                    <div>
                        <p class="font-bold">Awaiting Your Response</p>
                        <p class="text-sm">There are <strong>{{ $pendingApprovalCount }} project(s)</strong> that require your approval to proceed.</p>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('client.orders') }}" class="inline-block bg-orange-500 text-white font-bold py-2 px-4 rounded hover:bg-orange-600 transition">View Details</a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Komponen Interaktif "Your Projects" (Desain Terang) --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm" 
                 x-data="{ selectedProjectId: {{ $activeProjects->first()?->id ?? 'null' }} }">
                
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-semibold text-gray-900">Your Active Projects</h3>
                </div>

                @if($activeProjects->isNotEmpty())
                    <div>
                        {{-- Tampilan Tab (Gaya Garis Bawah) --}}
                        <div class="px-6 md:px-8 border-b border-gray-200">
                            <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                                @foreach($activeProjects as $project)
                                    {{-- PERBAIKAN DI SINI: Menambahkan nullsafe operator '?->' --}}
                                    @php
                                        $serviceName = $project->detailOrders->first()?->service?->name ?? 'Custom Service';
                                    @endphp
                                    <button @click="selectedProjectId = {{ $project->id }}"
                                            :class="selectedProjectId === {{ $project->id }} ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                        {{ Str::limit($serviceName, 20) }}
                                    </button>
                                @endforeach
                            </nav>
                        </div>

                        {{-- Konten Detail Proyek --}}
                        <div class="p-6 md:p-8">
                            @foreach($activeProjects as $project)
                                <div x-show="selectedProjectId === {{ $project->id }}" x-transition.opacity style="display: none;">
                                    
                                    {{-- PERBAIKAN DI SINI: Menambahkan nullsafe operator '?->' --}}
                                    @php
                                        $firstDetail = $project->detailOrders->first();
                                        $service = $firstDetail?->service;
                                        $serviceName = $service?->name ?? 'Custom Service';
                                        $serviceImage = $service?->image 
                                            ? asset('storage/' . $service->image) 
                                            : 'https://placehold.co/600x400/e2e8f0/94a3b8?text=TechnoG';
                                    @endphp
                                    
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                                        
                                        <div class="lg:col-span-1">
                                            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ $serviceImage }}" 
                                                     alt="{{ $serviceName }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>

                                        <div class="lg:col-span-2 space-y-5">
                                            <div class="flex justify-between items-start flex-wrap gap-2">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-500">{{ $project->order_id }}</p>
                                                    <h4 class="text-xl font-bold text-gray-900 mt-1">{{ $serviceName }}</h4>
                                                </div>
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $project->status }}
                                                </span>
                                            </div>

                                            @if($project->due_date)
                                            <p class="text-sm text-gray-500"><i class="far fa-calendar-alt mr-1.5"></i> Estimated Completion: {{ $project->due_date->format('d M Y') }}</p>
                                            @endif
                                            
                                            <div>
                                                <div class="flex justify-between text-sm text-gray-500 mb-1">
                                                    <span>Progress</span>
                                                    <span class="font-semibold text-indigo-600">{{ $project->progress ?? 0 }}%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="bg-gradient-to-r from-sky-500 to-indigo-500 h-2.5 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="pt-2">
                                                <a href="{{ route('client.orders.show', $project->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition">View Project Details</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Tampilan jika tidak ada proyek aktif --}}
                    <div class="text-center py-12 px-6">
                        <i class="far fa-folder-open fa-3x text-gray-400"></i>
                        <h3 class="mt-4 text-sm font-medium text-gray-900">No active projects</h3>
                        <p class="mt-1 text-sm text-gray-500">Start a new project to see its progress here.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>