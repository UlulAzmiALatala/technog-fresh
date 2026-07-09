{{-- Lokasi: resources/views/admin/pemasukan/services/partials/edit-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[90vh] flex flex-col rounded-[2.5rem] shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
            
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Service</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none hover:text-rose-500"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/pemasukan/services') }}/${editData.id}`" method="POST" enctype="multipart/form-data" class="overflow-y-auto custom-scrollbar flex-grow p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="modal_form" value="edit">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Service Name</label>
                            <input type="text" name="name" x-model="editData.name" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                            @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Project Type / Deliverable</label>
                            <input type="text" name="project_type" x-model="editData.project_type" placeholder="e.g. Pembuatan Website, Analisis Data, Infrastructure"
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                            @error('project_type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Package Plan</label>
                            <select name="package_plan" x-model="editData.package_plan" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                                <option value="Silver Plan">Silver Plan</option>
                                <option value="Gold Plan">Gold Plan</option>
                                <option value="Platinum Sphere">Platinum Sphere</option>
                                <option value="Diamond Class">Diamond Class</option>
                                <option value="Ultima Partnership">Ultima Partnership</option>
                                <option value="Custom Engagement">Custom Engagement</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Price ($)</label>
                                <input type="number" name="price" x-model="editData.price" step="0.01" required
                                       class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                            </div>
                            <div class="flex space-x-2">
                                <div class="w-1/2">
                                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Duration</label>
                                    <input type="number" name="estimated_duration" x-model="editData.estimated_duration" required 
                                           class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                                </div>
                                <div class="w-1/2">
                                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Unit</label>
                                    <select name="duration_unit" x-model="editData.duration_unit" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none text-xs">
                                        <option value="Hari">Hari</option>
                                        <option value="Minggu">Minggu</option>
                                        <option value="Bulan">Bulan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category</label>
                            <div class="flex space-x-2">
                                <select name="category_id" x-model="editData.category_id" required 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none">
                                    <template x-for="cat in categories" :key="cat.id">
                                        <option :value="cat.id" x-text="cat.name" :selected="cat.id == editData.category_id"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openAddCatModal('edit')" class="px-4 bg-slate-800 text-white rounded-xl hover:bg-slate-700 font-bold text-xs whitespace-nowrap transition-colors">
                                    + New
                                </button>
                            </div>
                        </div>

                        <div class="p-4 border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl bg-slate-50/50 dark:bg-slate-900/30">
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Service Image</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 overflow-hidden flex items-center justify-center shadow-sm shrink-0">
                                    <template x-if="editData.imageUrl">
                                        <img :src="editData.imageUrl" class="w-full h-full object-cover">
                                    </template>
                                    <i x-show="!editData.imageUrl" class="fas fa-image text-slate-300 text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="image" @change="editData.imageUrl = URL.createObjectURL($event.target.files[0])"
                                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-widest">Leave empty if unchanged. Max 2MB.</p>
                                </div>
                            </div>
                            @error('image') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Full Width Bawah --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Full Description (Overview)</label>
                                <textarea name="description" x-model="editData.description" rows="3" 
                                          class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Ideal Use Case</label>
                                <textarea name="use_case" x-model="editData.use_case" rows="3" 
                                          class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Execution Workflow</label>
                                <textarea name="workflow" x-model="editData.workflow" rows="4" 
                                          class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Key Features (Outputs)</label>
                                <textarea name="features" x-model="editData.features" rows="4"
                                          class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 outline-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex space-x-4 pt-8 mt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold uppercase tracking-widest transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-500/30 font-bold uppercase tracking-widest transition-none">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</template>