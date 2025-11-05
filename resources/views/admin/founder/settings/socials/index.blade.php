{{-- VERSI FINAL: resources/views/admin/founder/settings/socials/index.blade.php --}}

<x-admin-layout x-data="socialLinkManager">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Social Media Links') }}
            </h2>
            <button @click="openAddModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Link
            </button>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Order</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($socialLinks as $link)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i :class="getIconClass('{{ $link->name }}')" class="fa-fw text-lg mr-3 text-gray-700 dark:text-slate-300"></i>
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $link->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 truncate max-w-xs">
                                <a href="{{ $link->url }}" target="_blank" class="hover:underline">{{ $link->url }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">{{ $link->sort_order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click='openEditModal(@json($link))' class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-4 font-medium">Edit</button>
                                <button @click="openDeleteModal('{{ route('admin.founder.settings.social-links.destroy', $link->id) }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 whitespace-nowrap text-center text-sm text-gray-500 dark:text-slate-400">
                                <i class="fas fa-share-nodes fa-3x text-gray-300 dark:text-slate-600 mb-3"></i>
                                <p>No social media links found. Click "Add New Link" to get started.</p>
                            </td>
                        </tr>
                    @endforelse {{-- <-- TYPO @endForetlse SUDAH DIPERBAIKI --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modals --}}
    @include('admin.founder.settings.socials.partials.add-modal')
    @include('admin.founder.settings.socials.partials.edit-modal')
    @include('admin.founder.settings.socials.partials.delete-modal')

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('socialLinkManager', () => ({
                isAddModalOpen: false,
                isEditModalOpen: false,
                isDeleteModalOpen: false,
                deleteUrl: '',
                
                newLink: { 
                    name: '',
                    url: '',
                    sort_order: 0
                },
                editingLink: {}, 

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
                        default: return 'fas fa-link';
                    }
                },

                openAddModal() {
                    this.newLink = { 
                        name: '',
                        url: '',
                        sort_order: 0
                    };
                    this.isAddModalOpen = true;
                },

                openEditModal(link) {
                    this.editingLink = link;
                    this.isEditModalOpen = true;
                },

                openDeleteModal(url) {
                    this.deleteUrl = url;
                    this.isDeleteModalOpen = true;
                },

                // Logika Inisialisasi Cerdas (VERSI FINAL SUDAH DIPERBAIKI)
                init() {
                    @if ($openEditModalId > 0 && $errors->any())
                        // Ambil data 'old()'
                        this.editingLink = @json(old());
                        this.editingLink.id = {{ $openEditModalId }};
                        this.isEditModalOpen = true;
                    
                    @elseif ($openAddModal && $errors->any())
                        // Isi 'newLink' dengan data 'old()'
                        this.newLink = @json(old());
                        this.isAddModalOpen = true;
                    @endif
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>