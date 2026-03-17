<x-admin-layout>
    {{-- "Brain" Script untuk Modal & AJAX Kategori --}}
    <script>
        function serviceManager(initialCategories) {
            return {
                categories: initialCategories,
                isAddModalOpen: false,
                isCategoryModalOpen: false,
                newCategoryName: '',
                errorMessage: '',
                selectedCategoryId: '{{ old('category_id') }}' || '',
                activeTarget: 'add', // Penanda modal mana yang lagi buka kategori
                
                openAddCatModal(target = 'add') {
                    this.activeTarget = target;
                    this.isCategoryModalOpen = true;
                    this.newCategoryName = '';
                    this.errorMessage = '';
                },
                async handleStoreCategory() {
                    this.errorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.pemasukan.services.categories.storeAjax') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });
                        const data = await response.json();
                        if (!response.ok) throw data;

                        if (data.success) {
                            // Tambahkan ke list kategori
                            this.categories.push(data.category);
                            
                            // Auto-select ke modal yang tepat
                            if (this.activeTarget === 'add') {
                                this.selectedCategoryId = data.category.id;
                            } else {
                                window.dispatchEvent(new CustomEvent('category-added', { detail: data.category.id }));
                            }
                            
                            this.isCategoryModalOpen = false; // Tutup modal kategori
                        }
                    } catch (error) {
                        this.errorMessage = error.errors?.name?.[0] || 'Terjadi kesalahan saat menyimpan.';
                    }
                }
            }
        }
    </script>

    <div x-data="serviceManager({{ isset($categories) ? $categories->toJson() : '[]' }})" @open-add-modal.window="isAddModalOpen = true">
        
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Service Management') }}
                </h2>
                <button @click="$dispatch('open-add-modal')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 dark:shadow-none">
                    <i class="fas fa-plus mr-2"></i> Add New Service
                </button>
            </div>
        </x-slot>

        @if ($errors->any())
            <div class="mt-4 mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Oops! </strong>
                <span class="block sm:inline">Ada kesalahan input. Pastikan form diisi dengan benar.</span>
                <ul class="mt-1 ml-4 list-disc list-inside">@foreach ($errors->all() as $error) <li class="text-sm">{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8 mt-4">
            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 transition-all duration-300" :class="animate ? 'in-view' : ''">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Services</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalServices ?? 0 }}</p>
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
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalCategories ?? 0 }}</p>
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
                                    <input type="text" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-900 text-gray-900 dark:text-slate-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search service name..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div>
                                <select name="package_plan" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-gray-900 dark:text-slate-200 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
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
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Service Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Package</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Price</th>
                                <th class="relative px-6 py-4 text-center"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-100 dark:divide-slate-700/50">
                            @forelse ($services as $service)
                                {{-- Tangkap event category-added di baris tabel ini --}}
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors duration-200" 
                                    x-data="{ isEditModalOpen: false, isDeleteModalOpen: false, editCategoryId: '{{ $service->category_id }}', imgPreview: '{{ $service->image ? asset('storage/' . $service->image) : '' }}' }"
                                    @category-added.window="if(isEditModalOpen) editCategoryId = $event.detail">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-xl object-cover border border-slate-200 dark:border-slate-600" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No+Img' }}" alt="{{ $service->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $service->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500 dark:text-slate-400">{{ $service->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-3 py-1 inline-flex text-[10px] uppercase tracking-widest font-bold rounded-md bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                            {{ $service->package_plan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-slate-900 dark:text-white">$ {{ number_format($service->price, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <button @click="isEditModalOpen = true" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 transition mr-3"><i class="fas fa-edit"></i> Edit</button>
                                        <button @click="isDeleteModalOpen = true" class="text-red-600 dark:text-red-400 hover:text-red-900 transition"><i class="fas fa-trash"></i> Delete</button>

                                        {{-- Panggil Edit & Delete Modal per baris (data terisolasi) --}}
                                        @include('admin.pemasukan.services.partials.edit-modal')
                                        @include('admin.pemasukan.services.partials.delete-modal')
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-sm text-slate-500 dark:text-slate-400">
                                        <i class="fas fa-box-open fa-3x text-slate-300 dark:text-slate-600 mb-3"></i>
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

        {{-- Panggil Add & Category Modal (Global level) --}}
        @include('admin.pemasukan.services.partials.add-modal')
        @include('admin.pemasukan.services.partials.category-modal')
    </div>

    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>