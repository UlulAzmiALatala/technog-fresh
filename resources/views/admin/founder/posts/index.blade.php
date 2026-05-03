{{-- Lokasi: resources/views/admin/founder/posts/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Blog Management</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage & track your articles</p>
            </div>
            <button @click="window.postManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Write New Article
            </button>
        </div>
    </x-slot>

    <div x-data="postPageManager(@js($categories))" class="space-y-8 py-4 font-normal relative">
        
        {{-- CONTROL PANEL (Search & Filters) --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
            
            <form action="{{ route('admin.founder.posts.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by article title..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                <div class="md:w-48">
                    <select name="status" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">All Statuses</option>
                        <option value="PUBLISHED" @selected(request('status') == 'PUBLISHED')>Published</option>
                        <option value="DRAFT" @selected(request('status') == 'DRAFT')>Draft</option>
                    </select>
                </div>

                @if(request()->hasAny(['search', 'status']) && (request('search') != '' || request('status') != ''))
                    <a href="{{ route('admin.founder.posts.index') }}" 
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
                            <th class="p-6 font-bold">Article Info</th>
                            <th class="p-6 font-bold text-center">Category</th>
                            <th class="p-6 font-bold text-center">Status</th>
                            <th class="p-6 font-bold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($posts as $post)
                            @php $imageUrl = $post->image ? asset('storage/' . $post->image) : null; @endphp
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                
                                <td class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-xl object-cover shadow-sm" src="{{ $imageUrl ?? 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No%20Image' }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-slate-900 dark:text-white font-bold text-sm line-clamp-1">{{ $post->title }}</div>
                                            <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1 font-bold">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at->format('d M Y') }} &bull; By {{ $post->user->name ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-6 text-center">
                                    <span class="px-4 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                        {{ $post->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="p-6 text-center">
                                    @if($post->status == 'PUBLISHED')
                                        <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-check-circle mr-1.5"></i> PUBLISHED
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-200/50 dark:border-amber-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-pen-nib mr-1.5"></i> DRAFT
                                        </span>
                                    @endif
                                </td>

                                <td class="p-6 text-center">
                                    <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal({{ $post->toJson() }}, '{{ $imageUrl }}')" 
                                                class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button type="button" @click.prevent="openDeleteModal(`{{ route('admin.founder.posts.destroy', $post->id) }}`)" 
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
                                        <i class="fas fa-newspaper text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No articles found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($posts->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $posts->links() }}
            </div>
        @endif

        @include('admin.founder.posts.partials.add-modal')
        @include('admin.founder.posts.partials.edit-modal')
        @include('admin.founder.posts.partials.delete-modal')
        @include('admin.founder.posts.partials.category-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('postPageManager', (initialCategories) => ({
                categories: initialCategories,
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, isCategoryModalOpen: false,
                newCategoryName: '', categoryErrorMessage: '', deleteUrl: '',
                addModalCategoryId: '', editItem: { id: null, title: '', body: '', status: '', category_id: '', image_url: null },
                editImagePreview: null,
                
                init() {
                    window.postManager = this;
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'add') this.isAddModalOpen = true;
                    if (modalForm === 'edit') this.isEditModalOpen = true;
                },
                openAddModal() { this.addModalCategoryId = ''; this.isAddModalOpen = true; },
                openEditModal(item, imageUrl) { this.editItem = { ...item, image_url: imageUrl }; this.editImagePreview = imageUrl; this.isEditModalOpen = true; },
                openDeleteModal(url) { this.deleteUrl = url; this.isDeleteModalOpen = true; },
                openAddCategoryForm() { this.newCategoryName = ''; this.categoryErrorMessage = ''; this.isCategoryModalOpen = true; },
                
                async handleStoreCategory() {
                    this.categoryErrorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.founder.posts.categories.storeAjax') }}", {
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