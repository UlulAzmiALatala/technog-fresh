{{-- Lokasi: resources/views/admin/pengeluaran/operational/partials/category-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isCategoryModalOpen" x-cloak 
         class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop Khusus Kategori --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[10px]"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isCategoryModalOpen = false"></div>
        
        {{-- Konten Modal Kategori --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl border border-white/10 z-10"
             x-transition:enter="transition ease-out duration-300 delay-75" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-plus text-xl"></i>
                </div>
                <h3 class="text-2xl text-slate-900 dark:text-white tracking-tighter uppercase font-bold">New Category</h3>
                <p class="text-slate-400 text-[10px] uppercase tracking-widest mt-2 font-normal">Add a custom expense category</p>
            </div>

            <form @submit.prevent="submitCategory()">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-[0.2em] text-slate-400 mb-2 font-bold text-center">Category Name</label>
                        <input type="text" x-model="newCategoryName" @keydown.enter.prevent="submitCategory()" 
                               placeholder="e.g. Server Maintenance" 
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-4 px-4 font-bold outline-none focus:ring-indigo-500 text-center">
                        <p x-show="categoryError" x-text="categoryError" class="text-[10px] font-bold text-red-500 mt-3 uppercase text-center"></p>
                    </div>

                    <div class="flex space-x-3 pt-4">
                        <button type="button" @click="isCategoryModalOpen = false" 
                                class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold transition-colors">Cancel</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-colors shadow-lg shadow-indigo-900/20">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>