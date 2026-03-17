{{-- Lokasi: resources/views/admin/pemasukan/services/partials/edit-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop Khusus Edit Layanan --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isEditModalOpen = false"></div>

        {{-- Konten Modal Edit --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[95vh] overflow-y-auto rounded-[2.5rem] shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md z-10">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Layanan</h3>
                <button @click="isEditModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.pemasukan.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="p-8 text-left">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Nama Layanan</label>
                            <input type="text" name="name" required value="{{ $service->name }}"
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        </div>
                        
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Paket Layanan</label>
                            <select name="package_plan" required 
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="Silver Plan" @selected($service->package_plan == 'Silver Plan')>Silver Plan</option>
                                <option value="Gold Plan" @selected($service->package_plan == 'Gold Plan')>Gold Plan</option>
                                <option value="Platinum Sphere" @selected($service->package_plan == 'Platinum Sphere')>Platinum Sphere</option>
                                <option value="Diamond Class" @selected($service->package_plan == 'Diamond Class')>Diamond Class</option>
                                <option value="Ultima Partnership" @selected($service->package_plan == 'Ultima Partnership')>Ultima Partnership</option>
                                <option value="Custom Engagement" @selected($service->package_plan == 'Custom Engagement')>Custom Engagement</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Harga ($)</label>
                                <input type="number" name="price" step="0.01" required value="{{ $service->price }}"
                                       class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            </div>
                            <div class="flex space-x-2">
                                <div class="w-1/2">
                                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Durasi</label>
                                    <input type="number" name="estimated_duration" required value="{{ $service->estimated_duration }}"
                                           class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                </div>
                                <div class="w-1/2">
                                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Unit</label>
                                    <select name="duration_unit" required 
                                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none text-xs">
                                        <option value="Hari" @selected($service->duration_unit == 'Hari')>Hari</option>
                                        <option value="Minggu" @selected($service->duration_unit == 'Minggu')>Minggu</option>
                                        <option value="Bulan" @selected($service->duration_unit == 'Bulan')>Bulan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Kategori Utama</label>
                            <div class="flex space-x-2">
                                <select name="category_id" x-model="editCategoryId" required 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                    <template x-for="cat in categories" :key="cat.id">
                                        <option :value="cat.id" x-text="cat.name" :selected="cat.id == editCategoryId"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openAddCatModal('edit')" 
                                        class="px-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-bold text-xs whitespace-nowrap shadow-md">
                                    + Baru
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Gambar Layanan</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-24 h-24 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 overflow-hidden flex items-center justify-center">
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-cover">
                                    </template>
                                    <i x-show="!imgPreview" class="fas fa-image text-slate-300 text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="image" @change="imgPreview = URL.createObjectURL($event.target.files[0])"
                                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <p class="text-[10px] text-slate-400 mt-2">Biarkan kosong jika tak diubah. Maks 2MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Full Width --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Fitur Utama (Key Features)</label>
                            <textarea name="features" rows="3"
                                      class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ $service->features }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Deskripsi Lengkap</label>
                            <textarea name="description" rows="4" 
                                      class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ $service->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-8 border-t border-slate-100 dark:border-slate-700 mt-8">
                    <button type="button" @click="isEditModalOpen = false" 
                            class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl shadow-lg shadow-emerald-900/20 font-bold transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>