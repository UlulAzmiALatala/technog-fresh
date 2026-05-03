{{-- Lokasi: resources/views/admin/pemasukan/services/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Service Catalog</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage products and service offerings</p>
            </div>
            <button @click="window.serviceManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add Service
            </button>
        </div>
    </x-slot>

    <div x-data="servicePageManager({{ isset($categories) ? $categories->toJson() : '[]' }})" class="space-y-8 py-4 font-normal relative">
        
        {{-- STATS CARDS (Hero Glassmorphism) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 text-white p-8 rounded-[2rem] shadow-xl shadow-slate-900/20 border border-slate-700">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-400 font-bold mb-2">Total Active Services</p>
                        <p class="text-5xl font-black tracking-tighter">{{ $totalServices ?? 0 }} <span class="text-lg text-slate-500 font-medium tracking-widest uppercase ml-2">Items</span></p>
                    </div>
                    <div class="h-16 w-16 bg-slate-800 border border-slate-700 rounded-2xl flex items-center justify-center shadow-inner">
                        <i class="fas fa-cube text-2xl text-indigo-400"></i>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 to-slate-800 text-white p-8 rounded-[2rem] shadow-xl shadow-indigo-900/20 border border-indigo-800/50">
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-sky-500/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-sky-400 font-bold mb-2">Service Categories</p>
                        <p class="text-5xl font-black tracking-tighter">{{ $totalCategories ?? 0 }} <span class="text-lg text-indigo-400/50 font-medium tracking-widest uppercase ml-2">Groups</span></p>
                    </div>
                    <div class="h-16 w-16 bg-indigo-900/50 border border-indigo-700/50 rounded-2xl flex items-center justify-center shadow-inner">
                        <i class="fas fa-tags text-2xl text-sky-400"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <form action="{{ route('admin.pemasukan.services.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search service name..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400 dark:text-white outline-none">
                </div>
                <div class="md:w-64">
                    <select name="package_plan" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300 outline-none">
                        <option value="">All Packages</option>
                        <option value="Silver Plan" @selected(request('package_plan') == 'Silver Plan')>Silver Plan</option>
                        <option value="Gold Plan" @selected(request('package_plan') == 'Gold Plan')>Gold Plan</option>
                        <option value="Platinum Sphere" @selected(request('package_plan') == 'Platinum Sphere')>Platinum Sphere</option>
                        <option value="Diamond Class" @selected(request('package_plan') == 'Diamond Class')>Diamond Class</option>
                        <option value="Ultima Partnership" @selected(request('package_plan') == 'Ultima Partnership')>Ultima Partnership</option>
                        <option value="Custom Engagement" @selected(request('package_plan') == 'Custom Engagement')>Custom Engagement</option>
                    </select>
                </div>
                @if(request()->hasAny(['search', 'package_plan']) && (request('search') != '' || request('package_plan') != ''))
                    <a href="{{ route('admin.pemasukan.services.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters"><i class="fas fa-undo"></i></a>
                @endif
            </form>
        </div>

        {{-- SERVICES TABLE (Glassmorphism) --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none relative">
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Service Info</th>
                            <th class="p-6 font-bold">Package & Category</th>
                            <th class="p-6 font-bold text-right">Pricing</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse($services as $service)
                        @php $imageUrl = $service->image ? asset('storage/' . $service->image) : null; @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 dark:border-slate-700/50 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-box-open text-slate-300 dark:text-slate-600 text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-slate-900 dark:text-white font-black text-sm">{{ $service->name }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase mt-1 tracking-widest font-bold"><i class="fas fa-clock mr-1"></i> {{ $service->estimated_duration }} {{ $service->duration_unit }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="px-3 py-1.5 inline-flex text-[9px] uppercase tracking-widest font-black rounded-xl border mb-2
                                    {{ $service->package_plan == 'Silver Plan' ? 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700' : 
                                      ($service->package_plan == 'Gold Plan' ? 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400' : 
                                      ($service->package_plan == 'Platinum Sphere' ? 'bg-sky-50 text-sky-600 border-sky-200 dark:bg-sky-900/30 dark:text-sky-400' : 
                                      ($service->package_plan == 'Diamond Class' ? 'bg-indigo-50 text-indigo-600 border-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-400' : 'bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400'))) }}">
                                    {{ $service->package_plan }}
                                </span>
                                <div class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest flex items-center"><i class="fas fa-tag mr-2 text-indigo-400"></i> {{ $service->category->name ?? 'Uncategorized' }}</div>
                            </td>
                            <td class="p-6 text-right">
                                <div class="text-indigo-600 dark:text-indigo-400 font-black text-lg tracking-tight">$ {{ number_format($service->price, 2, '.', ',') }}</div>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal({{ $service->toJson() }}, '{{ $imageUrl }}')" 
                                            class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ route('admin.pemasukan.services.destroy', $service->id) }}`)" 
                                            class="h-10 w-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-24 text-center">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                    <i class="fas fa-box-open text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">No Services Found</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Start by adding a new service catalog.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($services->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $services->links() }}
            </div>
        @endif

        {{-- PANGGIL SEMUA MODAL DI SINI (GLOBAL LEVEL) --}}
        @include('admin.pemasukan.services.partials.add-modal')
        @include('admin.pemasukan.services.partials.edit-modal')
        @include('admin.pemasukan.services.partials.category-modal')
        @include('admin.pemasukan.services.partials.delete-modal')

    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('servicePageManager', (initialCategories) => ({
                categories: initialCategories,
                
                isAddModalOpen: false, 
                isEditModalOpen: false, 
                isDeleteModalOpen: false, 
                isCategoryModalOpen: false,
                
                activeTarget: 'add',
                newCategoryName: '',
                errorMessage: '',
                deleteUrl: '',
                
                addCategoryId: '{{ old('category_id') }}' || '',
                editData: { id: null, name: '', package_plan: '', price: '', estimated_duration: '', duration_unit: '', category_id: '', features: '', description: '', imageUrl: null },

                init() {
                    window.serviceManager = this;
                    
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'add') {
                        this.isAddModalOpen = true;
                    } else if (modalForm === 'edit') {
                        this.editData = @json(old());
                        this.isEditModalOpen = true;
                    }

                    // PERBAIKAN: Fungsi cerdas untuk mengecek apakah MASIH ADA modal yang terbuka
                    const checkScrollLock = () => {
                        if (this.isAddModalOpen || this.isEditModalOpen || this.isDeleteModalOpen || this.isCategoryModalOpen) {
                            document.body.style.overflow = 'hidden';
                        } else {
                            document.body.style.overflow = '';
                        }
                    };

                    // Pantau semua state modal dan jalankan fungsi cerdas di atas
                    this.$watch('isAddModalOpen', checkScrollLock);
                    this.$watch('isEditModalOpen', checkScrollLock);
                    this.$watch('isDeleteModalOpen', checkScrollLock);
                    this.$watch('isCategoryModalOpen', checkScrollLock);
                },

                openAddModal() { this.isAddModalOpen = true; },
                openEditModal(data, imageUrl) { 
                    this.editData = { ...data, imageUrl: imageUrl || null }; 
                    this.isEditModalOpen = true; 
                },
                openDeleteModal(url) { 
                    this.deleteUrl = url; 
                    this.isDeleteModalOpen = true; 
                },
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
                            this.categories.push(data.category);
                            if (this.activeTarget === 'add') {
                                this.addCategoryId = data.category.id;
                            } else {
                                this.editData.category_id = data.category.id;
                            }
                            this.isCategoryModalOpen = false;
                        }
                    } catch (error) {
                        this.errorMessage = error.errors?.name?.[0] || 'Terjadi kesalahan saat menyimpan.';
                    }
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>