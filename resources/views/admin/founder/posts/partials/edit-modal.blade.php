{{-- Lokasi: resources/views/admin/founder/posts/partials/edit-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Artikel</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/founder/posts') }}/${editItem.id}`" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <input type="hidden" name="modal_form" value="edit">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Judul Artikel</label>
                            <input type="text" name="title" x-model="editItem.title" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Isi Konten</label>
                            <textarea name="body" x-model="editItem.body" rows="6" required
                                      class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Kategori</label>
                            <div class="flex items-center space-x-2">
                                <select name="category_id" x-model="editItem.category_id" required 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name" :selected="category.id == editItem.category_id"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openAddCategoryForm()" class="h-11 w-11 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-xl transition-none font-bold shrink-0"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Status</label>
                            <select name="status" x-model="editItem.status" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="DRAFT">Draft</option>
                                <option value="PUBLISHED">Published</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Ganti Gambar (Opsional)</label>
                            <div class="relative w-full h-28 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-900/50">
                                <template x-if="editImagePreview">
                                    <img :src="editImagePreview" class="w-full h-full object-cover">
                                </template>
                                <span x-show="!editImagePreview" class="text-slate-400 text-xs font-bold uppercase tracking-widest">Upload Baru</span>
                                <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       @change="editImagePreview = URL.createObjectURL($event.target.files[0])">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-6">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Batal</button>
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none font-bold transition-none">Update Artikel</button>
                </div>
            </form>
        </div>
    </div>
</template>