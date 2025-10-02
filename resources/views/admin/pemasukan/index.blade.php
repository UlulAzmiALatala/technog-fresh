<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Service Management') }}
            </h2>
            <a href="{{ route('admin.pemasukan.services.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Service
            </a>
        </div>
    </x-slot>

    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8">

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Services</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalServices }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full">
                        <i class="fas fa-cube"></i>
                    </div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''" style="transition-delay: 0.1s;">
                 <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Categories</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalCategories }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content: Table and Filters --}}
        <div class="fade-in-item bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all duration-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.2s;">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <form action="{{ route('admin.pemasukan.services.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                                <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by service name..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div>
                            <select id="package_plan" name="package_plan" class="block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Packages</option>
                                <option value="Silver Plan" @selected(request('package_plan') == 'Silver Plan')>Silver Plan</option>
                                <option value="Gold Plan" @selected(request('package_plan') == 'Gold Plan')>Gold Plan</option>
                                <option value="Platinum Sphere" @selected(request('package_plan') == 'Platinum Sphere')>Platinum Sphere</option>
                                <option value="Diamond Class" @selected(request('package_plan') == 'Diamond Class')>Diamond Class</option>
                                <option value="Ultima Partnership" @selected(request('package_plan') == 'Ultima Partnership')>Ultima Partnership</option>
                                <option value="Custom Engagement" @selected(request('package_plan') == 'Custom Engagement')>Custom Engagement</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Service Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Package</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Price</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse ($services as $service)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No%20Image' }}" alt="{{ $service->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $service->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">{{ $service->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @switch($service->package_plan)
                                            @case('Diamond Class') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 @break
                                            @case('Platinum Sphere') bg-slate-200 text-slate-800 dark:bg-slate-600 dark:text-slate-200 @break
                                            @case('Gold Plan') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 @break
                                            @case('Silver Plan') bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200 @break
                                            @case('Ultima Partnership') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @break
                                            @case('Custom Engagement') bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300 @break
                                            @default bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @break
                                        @endswitch
                                    ">
                                        {{ $service->package_plan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900 dark:text-white">$ {{ number_format($service->price, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.pemasukan.services.edit', $service->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                    <form class="inline-block ml-2" action="{{ route('admin.pemasukan.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-sm text-gray-500 dark:text-slate-400">
                                    <i class="fas fa-box-open fa-3x text-gray-300 dark:text-slate-600 mb-3"></i>
                                    <p>No services match the filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($services->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>