{{-- Lokasi: resources/views/admin/founder/settings/logos/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Logo Management</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage your website's branding assets</p>
            </div>
            <button @click="window.logoManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add New Logo
            </button>
        </div>
    </x-slot>

    <div x-data="logoPageManager()" class="space-y-8 py-4 font-normal relative">
        
        {{-- TABLE SECTION (Glassmorphism Level 2) --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none relative">
            
            {{-- Aksen Glow Halus --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Logo Preview</th>
                            <th class="p-6 font-bold text-center">Type / Placement</th>
                            <th class="p-6 font-bold text-center">Status</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($logos as $logo)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-16 w-24 rounded-2xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center shadow-sm overflow-hidden p-2">
                                            <img src="{{ asset('storage/' . $logo->path) }}" alt="{{ $logo->name }}" class="max-h-full max-w-full object-contain">
                                        </div>
                                        <div class="text-xs text-slate-400 font-medium">
                                            Path: <br><span class="text-indigo-500 font-bold truncate block max-w-[150px]">/storage/{{ $logo->path }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="text-slate-900 dark:text-white font-black text-sm tracking-wide">{{ $logo->name }}</span>
                                </td>
                                <td class="p-6 text-center">
                                    @if ($logo->is_active)
                                        <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-check-circle mr-1.5"></i> Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center w-max mx-auto">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal({{ $logo->toJson() }})" 
                                                class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button type="button" @click.prevent="openDeleteModal(`{{ route('admin.founder.settings.logos.destroy', $logo->id) }}`)" 
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
                                        <i class="fas fa-image text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No logos found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($logos->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $logos->links() }}
            </div>
        @endif

        {{-- Modals --}}
        @include('admin.founder.settings.logos.partials.add-modal')
        @include('admin.founder.settings.logos.partials.edit-modal')
        @include('admin.founder.settings.logos.partials.delete-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('logoPageManager', () => ({
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, deleteUrl: '',
                newLogo: { name: '', is_active: true, previewUrl: null },
                editingLogo: { id: null, name: '', is_active: false, previewUrl: null, existingImageUrl: '' },

                handleFileChange(event, type = 'add') {
                    const file = event.target.files[0];
                    if (!file) {
                        if (type === 'add') this.newLogo.previewUrl = null;
                        else this.editingLogo.previewUrl = null;
                        return;
                    }
                    const previewUrl = URL.createObjectURL(file);
                    if (type === 'add') this.newLogo.previewUrl = previewUrl;
                    else this.editingLogo.previewUrl = previewUrl;
                },

                init() {
                    window.logoManager = this;
                    const modalForm = '{{ old('modal_form') }}';
                    
                    if (modalForm === 'add') {
                        this.newLogo = { ...@json(old()), previewUrl: null };
                        this.isAddModalOpen = true;
                    }
                    if (modalForm === 'edit') {
                        this.editingLogo = { ...@json(old()), previewUrl: null };
                        // Ambil path lama jika error edit
                        const oldId = '{{ old('id') }}';
                        // Biarkan user memilih ulang gambar saat error, atau reset ke placeholder
                        this.isEditModalOpen = true;
                    }

                    // BODY SCROLL LOCK (Anti-Bocor)
                    this.$watch('isAddModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                openAddModal() { 
                    this.newLogo = { name: '', is_active: true, previewUrl: null };
                    document.getElementById('add_logo_form')?.reset();
                    this.isAddModalOpen = true; 
                },
                openEditModal(logo) { 
                    this.editingLogo = { 
                        ...logo, 
                        is_active: logo.is_active == 1,
                        existingImageUrl: `/storage/${logo.path}`, 
                        previewUrl: null 
                    };
                    document.getElementById('edit_logo_form')?.reset();
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