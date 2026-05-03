{{-- Lokasi: resources/views/admin/founder/case-studies/partials/add-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isAddModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Add New Case Study</h3>
                <button type="button" @click="isAddModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form action="{{ route('admin.founder.case-studies.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="modal_form" value="add">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Project Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required autofocus
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            @error('title') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Client Name</label>
                            <input type="text" name="client_name" value="{{ old('client_name') }}" required
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            @error('client_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Industry Category</label>
                            <div class="flex items-center space-x-2">
                                <select name="category_id" x-model="addModalCategoryId" required 
                                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                    <option value="">Select Category</option>
                                    <template x-for="category in categories" :key="category.id">
                                        <option :value="category.id" x-text="category.name"></option>
                                    </template>
                                </select>
                                <button type="button" @click="openCategoryModal()" class="h-11 w-11 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-xl transition-none font-bold shrink-0"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div x-data="{ imagePreview: null }">
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Project Image</label>
                            <div class="relative w-full h-28 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-900/50">
                                <template x-if="imagePreview"><img :src="imagePreview" class="w-full h-full object-cover"></template>
                                <span x-show="!imagePreview" class="text-slate-400 text-xs font-bold uppercase tracking-widest">Upload Image</span>
                                <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-5">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Client's Problem</label>
                        <textarea name="problem" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ old('problem') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Provided Solution</label>
                        <textarea name="solution" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ old('solution') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Achieved Results</label>
                        <textarea name="result" rows="3" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ old('result') }}</textarea>
                    </div>
                </div>

                <div class="flex space-x-4 pt-6">
                    <button type="button" @click="isAddModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none">Save Case Study</button>
                </div>
            </form>
        </div>
    </div>
</template>