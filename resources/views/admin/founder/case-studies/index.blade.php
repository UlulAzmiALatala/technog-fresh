{{-- Script "brain" for this feature --}}
<script>
    function caseStudyPageManager(initialCategories) {
        return {
            // === State untuk Kategori (dari create.blade.php) ===
            categories: initialCategories,
            openAddCategoryModal: false,
            newCategoryName: '',
            errorMessage: '',
            
            // === State untuk Modal Add Case Study ===
            // Kita pisahkan ID untuk modal Add dan Edit
            addModalCategoryId: '{{ old('category_id') }}' || '',

            // === State untuk Modal Edit/Delete (dari proposal lama) ===
            editItem: {},
            deleteAction: '',
            
            // === Fungsi untuk Modal Add Category (dari create.blade.php) ===
            openCategoryModal() {
                this.openAddCategoryModal = true;
                this.newCategoryName = '';
                this.errorMessage = '';
            },
            async handleStoreCategory() {
                this.errorMessage = '';
                try {
                    const response = await fetch("{{ route('admin.founder.case-studies.categories.storeAjax') }}", {
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
                        // Otomatis pilih kategori yang baru dibuat
                        this.addModalCategoryId = data.category.id; 
                        // Jika modal edit terbuka, update juga di sana
                        if (this.editItem.id) {
                            this.editItem.category_id = data.category.id;
                        }
                        this.openAddCategoryModal = false;
                    }
                } catch (error) {
                    this.errorMessage = error.errors?.name?.[0] || 'An error occurred while saving.';
                }
            },

            // === Fungsi untuk Modal Add Case Study ===
            openAddModal() {
                // Reset/set default
                this.addModalCategoryId = '{{ old('category_id') }}' || '';
                this.$dispatch('open-modal', 'add-case-study-modal');
            },

            // === Fungsi untuk Modal Edit Case Study ===
            openEditModal(item) {
                // Saat tombol edit diklik, kita copy item ke editItem
                // Kita gunakan JSON parse/stringify untuk membuat salinan,
                // agar jika user cancel, data di tabel tidak berubah.
                this.editItem = JSON.parse(JSON.stringify(item));
                this.$dispatch('open-modal', 'edit-case-study-modal');
            },

            // === Fungsi untuk Modal Delete Case Study ===
            openDeleteModal(actionUrl) {
                this.deleteAction = actionUrl;
                this.$dispatch('open-modal', 'delete-case-study-modal');
            }
        }
    }
</script>

{{-- 
    [REFACTOR] Inisialisasi Alpine "Brain" di level tertinggi.
    Kita inject $categories sebagai JSON.
--}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Case Study Management') }}
            </h2>
            
            {{-- [REFACTOR] Tombol "Add" sekarang memicu fungsi Alpine --}}
            <button
                type="button"
                x-data="{}" {{-- x-data kosong agar bisa panggil fungsi parent --}}
                x-on:click.prevent="$dispatch('open-add-modal')"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
            >
                + Add Case Study
            </button>
        </div>
    </x-slot>

    {{-- 
        [PERBAIKAN] Menggunakan kutip tunggal (') untuk x-data
        agar JSON (@json) yang menggunakan kutip ganda (") tidak bentrok.
    --}}
    <div 
        class="mt-4"
        x-data='caseStudyPageManager(@json($categories))'
        @open-add-modal.window="openAddModal"
    >

        {{-- Search & Filter Features (Tidak berubah) --}}
        <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
            <form action="{{ route('admin.founder.case-studies.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                            <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by title or client name..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div>
                        <label for="category_id_filter" class="sr-only">Filter by category</label>
                        <select id="category_id_filter" name="category_id" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            {{-- Dropdown filter ini tetap pakai @foreach standar --}}
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- Session Error Message (Penting untuk validasi modal) --}}
        @if (session('error') || $errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded-md">
                <span class="font-bold">{{ session('error') ?? 'Validation errors occurred!' }}</span>
                @if($errors->any())
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        @endif

        {{-- Tabel Utama --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Project Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($caseStudies as $caseStudy)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $caseStudy->image ? asset('storage/'. $caseStudy->image) : 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No%20Image' }}" alt="{{ $caseStudy->title }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $caseStudy->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $caseStudy->client_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $caseStudy->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        
                                        {{-- [REFACTOR] Tombol Edit memanggil fungsi Alpine --}}
                                        <button
                                            type="button"
                                            x-on:click.prevent="openEditModal({{ json_encode($caseStudy) }})"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Edit
                                        </button>

                                        {{-- [REFACTOR] Tombol Delete memanggil fungsi Alpine --}}
                                        <button
                                            type="button"
                                            x-on:click.prevent="openDeleteModal('{{ route('admin.founder.case-studies.destroy', $caseStudy->id) }}')"
                                            class="text-red-600 hover:text-red-900 ml-2"
                                        >
                                            Delete
                                        </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No case studies found.
                                    </td>
                                </tr>
                            {{-- [PERBAIKAN] Mengganti @endforeach menjadi @endforelse --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div class="mt-6">
                    {{ $caseStudies->links() }}
                </div>
            </div>
        </div>

        {{-- 
            [REFACTOR] Memanggil 3 file partial modal kita.
            Kita TIDAK perlu passing $categories lagi, karena mereka sudah ada di Alpine 'brain'.
        --}}
        @include('admin.founder.case-studies.partials.add-modal')
        @include('admin.founder.case-studies.partials.edit-modal')
        @include('admin.founder.case-studies.partials.delete-modal')


        {{-- [REFACTOR] Modal "Add Category" (dari create.blade.php) --}}
        {{-- Modal ini dikontrol oleh 'openAddCategoryModal' dari Alpine 'brain' --}}
        <div x-show="openAddCategoryModal" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="openAddCategoryModal = false" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openAddCategoryModal" @click="openAddCategoryModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div x-show="openAddCategoryModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="handleStoreCategory()">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Add Case Study Category</h3>
                            <div class="mt-4">
                                <label for="new_category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" x-model="newCategoryName" id="new_category_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-red-600 mt-2"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto">Save</button>
                            <button type="button" @click="openAddCategoryModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border sm:mt-0 sm:w-auto px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> {{-- End of x-data wrapper --}}
</x-admin-layout>

