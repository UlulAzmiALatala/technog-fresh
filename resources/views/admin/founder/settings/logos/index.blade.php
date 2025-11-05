{{-- VERSI FINAL v2: resources/views/admin/founder/settings/logos/index.blade.php --}}

<x-admin-layout x-data="logoManager">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Logo Management') }}
            </h2>
            <button @click="openAddModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Logo
            </button>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Preview</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Name / Location</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($logos as $logo)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ asset('storage/' . $logo->path) }}" alt="{{ $logo->name }}" class="h-10 w-auto max-w-xs rounded-md bg-gray-200 dark:bg-slate-700 p-1">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $logo->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-slate-400">storage/{{ $logo->path }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                @if ($logo->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click='openEditModal(@json($logo))' class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-4 font-medium">Edit</button>
                                <button @click="openDeleteModal('{{ route('admin.founder.settings.logos.destroy', $logo->id) }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 whitespace-nowrap text-center text-sm text-gray-500 dark:text-slate-400">
                                <i class="fas fa-image fa-3x text-gray-300 dark:text-slate-600 mb-3"></i>
                                <p>No logos found. Click "Add New Logo" to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($logos->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                {{ $logos->links() }}
            </div>
        @endif
    </div>

    {{-- Modals --}}
    @include('admin.founder.settings.logos.partials.add-modal')
    @include('admin.founder.settings.logos.partials.edit-modal')
    @include('admin.founder.settings.logos.partials.delete-modal')

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('logoManager', () => ({
                isAddModalOpen: false,
                isEditModalOpen: false,
                isDeleteModalOpen: false,
                deleteUrl: '',

                // State untuk form 'Add'
                newLogo: { 
                    name: '',
                    is_active: true,
                    previewUrl: null
                },

                // State untuk form 'Edit'
                editingLogo: {}, 

                // Handle preview file
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

                // Open Add Modal
                openAddModal() {
                    this.newLogo = { 
                        name: '',
                        is_active: true,
                        previewUrl: null
                    };
                    document.getElementById('add_logo_file')?.form.reset();
                    this.isAddModalOpen = true;
                },

                // Open Edit Modal
                openEditModal(logo) {
                    this.editingLogo = {
                        ...logo,
                        existingImageUrl: `/storage/${logo.path}`,
                        previewUrl: null
                    };
                    document.getElementById('edit_logo_file')?.form.reset();
                    this.isEditModalOpen = true;
                },

                // Open Delete Modal
                openDeleteModal(url) {
                    this.deleteUrl = url;
                    this.isDeleteModalOpen = true;
                },

                // Smart Init Fix
                init() {
                    @if ($openEditModalId > 0 && $errors->any())
                        this.editingLogo = @json(old());
                        this.editingLogo.id = {{ $openEditModalId }};
                        
                        const existingPath = @json($logos->find($openEditModalId)->path ?? '');
                        this.editingLogo.existingImageUrl = `/storage/${existingPath}`;
                        this.editingLogo.previewUrl = null;

                        this.isEditModalOpen = true;

                    @elseif ($openAddModal && $errors->any())
                        this.newLogo = @json(old());
                        this.isAddModalOpen = true;
                    @endif
                }
            }));
        });
    </script>
    @endpush

</x-admin-layout>