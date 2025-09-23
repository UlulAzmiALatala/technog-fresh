{{-- Lokasi: resources/views/pengeluaran/edit.blade.php --}}
<x-admin-layout>
    {{-- Script "otak" dari fitur ini, diletakkan di atas --}}
    <script>
        function categoryFormManager(initialCategories, currentCategoryId) {
            return {
                // Data
                categories: initialCategories,
                openModal: false,
                newCategoryName: '',
                errorMessage: '',
                selectedCategoryId: currentCategoryId || '',

                // Methods
                init() {
                    // Jika kategori yang ada tidak ditemukan di daftar, reset
                    if (this.selectedCategoryId && !this.categories.find(c => c.id == this.selectedCategoryId)) {
                        this.selectedCategoryId = '';
                    }
                },
                get selectedCategoryText() {
                    if (!this.selectedCategoryId) return 'Pilih Kategori';
                    const found = this.categories.find(c => c.id == this.selectedCategoryId);
                    return found ? found.name : 'Pilih Kategori';
                },
                openAddModal() {
                    this.openModal = true;
                    this.newCategoryName = '';
                    this.errorMessage = '';
                },
                async handleStore() {
                    this.errorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.pengeluaran.expense-categories.storeAjax') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw data;
                        }

                        if (data.success) {
                            this.categories.push(data.category);
                            this.selectedCategoryId = data.category.id; // Otomatis pilih kategori baru
                            this.openModal = false;
                        }
                    } catch (error) {
                        if (error.errors && error.errors.name) {
                            this.errorMessage = error.errors.name[0];
                        } else {
                            this.errorMessage = 'Terjadi kesalahan saat menyimpan.';
                            console.error('Error:', error);
                        }
                    }
                }
            }
        }
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengeluaran') }}
        </h2>
    </x-slot>

    {{-- PERBAIKAN: x-data ditambahkan untuk menginisialisasi Alpine.js --}}
    <div class="mt-4" x-data="categoryFormManager({{ $categories->toJson() }}, {{ old('category_id', $expense->category_id) }})" x-init="init()">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900">

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pengeluaran.expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- PERBAIKAN: Input hidden untuk menyimpan ID kategori yang dipilih --}}
                    <input type="hidden" name="category_id" x-model="selectedCategoryId">

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Tanggal Pengeluaran --}}
                            <div>
                                <label for="expense_date" class="block font-medium text-sm text-gray-700">Tanggal Pengeluaran</label>
                                <input type="date" name="expense_date" id="expense_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('expense_date', $expense->expense_date) }}" required>
                            </div>

                            {{-- Jumlah (Amount) --}}
                            <div>
                                <label for="amount" class="block font-medium text-sm text-gray-700">Jumlah (Rp)</label>
                                <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('amount', $expense->amount) }}" required>
                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category_id_select" class="block font-medium text-sm text-gray-700">Kategori</label>
                            {{-- PERBAIKAN: Menggunakan struktur dropdown + tombol --}}
                            <div class="flex items-center space-x-2 mt-1">
                                <select id="category_id_select" x-model="selectedCategoryId" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kategori</option>
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openAddModal()" class="flex-shrink-0 px-4 py-3 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 whitespace-nowrap">
                                    + Kategori Baru
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="type" class="block font-medium text-sm text-gray-700">Tipe Pembayaran</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="Full" @selected($expense->type == 'Full')>Full</option>
                                <option value="DP" @selected($expense->type == 'DP')>DP</option>
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $expense->description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.pengeluaran.expenses.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal untuk Tambah Kategori --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="openModal = false" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div x-show="openModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="handleStore()">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Kategori Pengeluaran Baru</h3>
                            <div class="mt-4">
                                <label for="new_category_name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <input type="text" x-model="newCategoryName" id="new_category_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-red-600 mt-2"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                            <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

