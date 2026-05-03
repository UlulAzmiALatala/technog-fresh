{{-- Lokasi: resources/views/admin/founder/case-studies/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Portfolio Management</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage & track your case studies</p>
            </div>
            <button @click="window.caseStudyManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add Case Study
            </button>
        </div>
    </x-slot>

    <div x-data="pageManager(@js($categories))" class="space-y-8 py-4 font-normal relative">
        
        {{-- CONTROL PANEL (Search & Filters) --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
            
            <form action="{{ route('admin.founder.case-studies.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or client name..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                <div class="md:w-56">
                    <select name="category_id" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">All Industries</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if(request()->hasAny(['search', 'category_id']) && (request('search') != '' || request('category_id') != ''))
                    <a href="{{ route('admin.founder.case-studies.index') }}" 
                       class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Project Details</th>
                            <th class="p-6 font-bold text-center">Category</th>
                            <th class="p-6 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($caseStudies as $caseStudy)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                
                                <td class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-24">
                                            <img class="h-16 w-24 rounded-xl object-cover shadow-sm border border-slate-200 dark:border-slate-700" 
                                                 src="{{ $caseStudy->image ? asset('storage/'. $caseStudy->image) : 'https://placehold.co/300x200/e2e8f0/cbd5e0?text=No%20Image' }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-slate-900 dark:text-white font-bold text-base line-clamp-1">{{ $caseStudy->title }}</div>
                                            <div class="text-[10px] text-slate-500 uppercase tracking-widest mt-1 font-bold">
                                                <i class="fas fa-building mr-1"></i> Client: <span class="text-indigo-500">{{ $caseStudy->client_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-6 text-center">
                                    <span class="px-4 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                        {{ $caseStudy->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="p-6 text-center">
                                    <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal({{ $caseStudy->toJson() }})" 
                                                class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button type="button" @click.prevent="openDeleteModal(`{{ route('admin.founder.case-studies.destroy', $caseStudy->id) }}`)" 
                                                class="h-10 w-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-24 text-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                        <i class="fas fa-briefcase text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No case studies found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($caseStudies->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $caseStudies->links() }}
            </div>
        @endif

        {{-- Include Modals --}}
        @include('admin.founder.case-studies.partials.add-modal')
        @include('admin.founder.case-studies.partials.edit-modal')
        @include('admin.founder.case-studies.partials.delete-modal')
        @include('admin.founder.case-studies.partials.category-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pageManager', (initialCategories) => ({
                categories: initialCategories,
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, isCategoryModalOpen: false,
                newCategoryName: '', categoryErrorMessage: '', deleteUrl: '',
                addModalCategoryId: '', 
                editItem: { id: null, title: '', client_name: '', problem: '', solution: '', result: '', category_id: '', image: null },
                
                init() {
                    window.caseStudyManager = this;
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'add') this.isAddModalOpen = true;
                    if (modalForm === 'edit') this.isEditModalOpen = true;

                    // FITUR KUNCI BODY SCROLL
                    // Mencegah scrollbar browser bocor di sebelah kanan saat modal terbuka
                    this.$watch('isAddModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isCategoryModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                openAddModal() { this.addModalCategoryId = ''; this.isAddModalOpen = true; },
                openEditModal(item) { this.editItem = { ...item }; this.isEditModalOpen = true; },
                openDeleteModal(url) { this.deleteUrl = url; this.isDeleteModalOpen = true; },
                openCategoryModal() { this.newCategoryName = ''; this.categoryErrorMessage = ''; this.isCategoryModalOpen = true; },
                
                async handleStoreCategory() {
                    this.categoryErrorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.founder.case-studies.categories.storeAjax') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });
                        const data = await response.json();
                        if (!response.ok) throw data;

                        if (data.success) {
                            this.categories.push(data.category);
                            this.addModalCategoryId = data.category.id;
                            this.editItem.category_id = data.category.id; 
                            this.isCategoryModalOpen = false;
                        }
                    } catch (error) {
                        this.categoryErrorMessage = error.errors?.name?.[0] || 'Gagal menyimpan kategori.';
                    }
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>