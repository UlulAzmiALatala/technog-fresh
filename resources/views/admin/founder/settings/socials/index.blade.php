{{-- Lokasi: resources/views/admin/founder/settings/socials/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Social Media Links</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage your external platform links</p>
            </div>
            <button @click="window.socialManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add New Link
            </button>
        </div>
    </x-slot>

    <div x-data="socialLinkManager()" class="space-y-8 py-4 font-normal relative">
        
        {{-- TABLE SECTION (Glassmorphism Level 2) --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none relative">
            
            {{-- Aksen Glow Halus di Table Kanan Atas --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Platform</th>
                            <th class="p-6 font-bold">URL</th>
                            <th class="p-6 font-bold text-center">Sort Order</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($socialLinks as $link)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xl shadow-sm transition-transform group-hover:scale-110">
                                            <i :class="getIconClass('{{ $link->name }}')"></i>
                                        </div>
                                        <div class="text-slate-900 dark:text-white font-black text-sm tracking-wide">{{ $link->name }}</div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <a href="{{ $link->url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-xl text-xs font-medium border border-slate-200 dark:border-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-300 transition-colors max-w-xs truncate">
                                        <i class="fas fa-external-link-alt mr-2 opacity-50"></i> {{ $link->url }}
                                    </a>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-3 py-1.5 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50">
                                        Position: {{ $link->sort_order }}
                                    </span>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal({{ $link->toJson() }})" 
                                                class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button type="button" @click.prevent="openDeleteModal(`{{ route('admin.founder.settings.social-links.destroy', $link->id) }}`)" 
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
                                        <i class="fas fa-share-nodes text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No social media links found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modals --}}
        @include('admin.founder.settings.socials.partials.add-modal')
        @include('admin.founder.settings.socials.partials.edit-modal')
        @include('admin.founder.settings.socials.partials.delete-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('socialLinkManager', () => ({
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, deleteUrl: '',
                newLink: { name: '', url: '', sort_order: 0 },
                editingLink: { id: null, name: '', url: '', sort_order: 0 },

                getIconClass(name) {
                    if (!name) return 'fas fa-link';
                    switch (String(name).toLowerCase()) {
                        case 'facebook': return 'fab fa-facebook';
                        case 'twitter': return 'fab fa-twitter';
                        case 'instagram': return 'fab fa-instagram';
                        case 'linkedin': return 'fab fa-linkedin';
                        case 'youtube': return 'fab fa-youtube';
                        case 'github': return 'fab fa-github';
                        case 'tiktok': return 'fab fa-tiktok';
                        default: return 'fas fa-globe';
                    }
                },

                init() {
                    window.socialManager = this;
                    
                    // Unified Validation Error Handling
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'add') {
                        this.newLink = @json(old());
                        this.isAddModalOpen = true;
                    }
                    if (modalForm === 'edit') {
                        this.editingLink = @json(old());
                        this.isEditModalOpen = true;
                    }

                    // BODY SCROLL LOCK (Anti-Bocor)
                    this.$watch('isAddModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                openAddModal() { 
                    this.newLink = { name: '', url: '', sort_order: 0 }; 
                    this.isAddModalOpen = true; 
                },
                openEditModal(link) { 
                    this.editingLink = { ...link }; 
                    this.isEditModalOpen = true; 
                },
                openDeleteModal(url) { 
                    this.deleteUrl = url; 
                    this.isDeleteModalOpen = true; 
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>