{{-- Lokasi: resources/views/pemasukan/edit.blade.php --}}

<x-admin-layout>
    <script>
        function categoryFormManager(initialCategories, currentCategoryId) {
            return {
                categories: initialCategories,
                openModal: false,
                newCategoryName: '',
                errorMessage: '',
                selectedCategoryId: currentCategoryId || '',
                
                openAddModal() {
                    this.openModal = true;
                    this.newCategoryName = '';
                    this.errorMessage = '';
                },
                async handleStore() {
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
                            this.selectedCategoryId = data.category.id;
                            this.openModal = false;
                        }
                    } catch (error) {
                        this.errorMessage = error.errors?.name?.[0] || 'Terjadi kesalahan saat menyimpan.';
                    }
                }
            }
        }
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Layanan') }}
        </h2>
    </x-slot>

    <div class="mt-4" x-data="categoryFormManager({{ $categories->toJson() }}, {{ old('category_id', $service->category_id) ?? 'null' }})">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.pemasukan.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" x-model="selectedCategoryId">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Kolom Kiri: Form Input --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Layanan</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md" value="{{ old('name', $service->name) }}" required>
                            </div>

                            <div>
                                <label for="package_plan" class="block font-medium text-sm text-gray-700">Paket Layanan</label>
                                <select name="package_plan" id="package_plan" class="mt-1 block w-full rounded-md" required>
                                    <option value="">Pilih Paket</option>
                                    <option value="Silver Plan" @selected(old('package_plan', $service->package_plan) == 'Silver Plan')>Silver Plan</option>
                                    <option value="Gold Plan" @selected(old('package_plan', $service->package_plan) == 'Gold Plan')>Gold Plan</option>
                                    <option value="Platinum Sphere" @selected(old('package_plan', $service->package_plan) == 'Platinum Sphere')>Platinum Sphere</option>
                                    <option value="Diamond Class" @selected(old('package_plan', $service->package_plan) == 'Diamond Class')>Diamond Class</option>
                                    <option value="Ultima Partnership" @selected(old('package_plan', $service->package_plan) == 'Ultima Partnership')>Ultima Partnership</option>
                                    <option value="Custom Engagement" @selected(old('package_plan', $service->package_plan) == 'Custom Engagement')>Custom Engagement</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block font-medium text-sm text-gray-700">Harga ($)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full rounded-md" value="{{ old('price', $service->price) }}" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="estimated_duration" class="block font-medium text-sm text-gray-700">Estimasi</label>
                                        <input type="number" name="estimated_duration" id="estimated_duration" class="mt-1 block w-full rounded-md" value="{{ old('estimated_duration', $service->estimated_duration) }}" required>
                                    </div>
                                    <div>
                                        <label for="duration_unit" class="block font-medium text-sm text-gray-700">Satuan</label>
                                        <select name="duration_unit" id="duration_unit" class="mt-1 block w-full rounded-md" required>
                                            <option value="Hari" @selected(old('duration_unit', $service->duration_unit) == 'Hari')>Hari</option>
                                            <option value="Minggu" @selected(old('duration_unit', $service->duration_unit) == 'Minggu')>Minggu</option>
                                            <option value="Bulan" @selected(old('duration_unit', $service->duration_unit) == 'Bulan')>Bulan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="features" class="block font-medium text-sm text-gray-700">Fitur Unggulan</label>
                                <textarea name="features" id="features" rows="4" class="mt-1 block w-full rounded-md" placeholder="Tulis setiap fitur di baris baru. Contoh:&#10;- Analisis Data Mendalam&#10;- Website Responsif">{{ old('features', $service->features) }}</textarea>
                            </div>

                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi Lengkap</label>
                                <textarea name="description" id="description" rows="6" class="mt-1 block w-full rounded-md">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Upload Gambar & Kategori --}}
                        <div class="space-y-6" x-data="{ imagePreview: {{ json_encode($service->image ? asset('storage/' . $service->image) : null) }} }">
                             <div>
                                <label for="category_id_select" class="block font-medium text-sm text-gray-700">Kategori Utama</label>
                                <div class="flex items-center space-x-2 mt-1">
                                    <select id="category_id_select" x-model="selectedCategoryId" class="block w-full rounded-md" required>
                                        <option value="">Pilih Kategori</option>
                                        <template x-for="category in categories" :key="category.id">
                                            <option :value="category.id" x-text="category.name"></option>
                                        </template>
                                    </select>
                                    <button type="button" @click="openAddModal()" class="flex-shrink-0 px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 whitespace-nowrap">
                                        + Kategori Baru
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="image" class="block font-medium text-sm text-gray-700">Gambar Layanan</label>
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="w-full h-48 object-cover rounded-md border">
                                </template>
                                <div x-show="!imagePreview" class="w-full h-48 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed">
                                    <span class="text-gray-400">Preview Gambar</span>
                                </div>
                                <input type="file" name="image" id="image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengganti gambar.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t">
                        <a href="{{ route('admin.pemasukan.services.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-green-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Modal untuk Tambah Kategori --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="openModal = false" style="display: none;">
            {{-- ... Kode modal sama persis seperti di halaman create ... --}}
        </div>

    </div>
</x-admin-layout>

