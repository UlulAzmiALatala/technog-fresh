{{-- Lokasi: resources/views/admin/founder/case-studies/partials/edit-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
             x-data="{ imagePreview: null }" @close-modal.window="imagePreview = null">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Case Study</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/founder/case-studies') }}/${editItem.id}`" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                @method('PATCH')
                <input type="hidden" name="modal_form" value="edit">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Project Title</label>
                            <input type="text" name="title" x-model="editItem.title" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Client Name</label>
                            <input type="text" name="client_name" x-model="editItem.client_name" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Industry Category</label>
                            <div class="flex items-center space-x-2">
                                <select name="category_id" x-model="editItem.category_id" required 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name" :selected="category.id == editItem.category_id"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openCategoryModal()" class="h-11 w-11 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-xl transition-none font-bold shrink-0"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Change Image</label>
                            <div class="relative w-full h-28 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-900/50">
                                <template x-if="imagePreview"><img :src="imagePreview" class="w-full h-full object-cover"></template>
                                <template x-if="!imagePreview && editItem.image"><img :src="`{{ asset('storage') }}/${editItem.image}`" class="w-full h-full object-cover"></template>
                                <span x-show="!imagePreview && !editItem.image" class="text-slate-400 text-xs font-bold uppercase tracking-widest">Upload Image</span>
                                <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-5">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Client's Problem</label>
                        <textarea name="problem" x-model="editItem.problem" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Provided Solution</label>
                        <textarea name="solution" x-model="editItem.solution" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Achieved Results</label>
                        <textarea name="result" x-model="editItem.result" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>
                </div>

                <div class="flex space-x-4 pt-6">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none">Update Case Study</button>
                </div>
            </form>
        </div>
    </div>
</template>