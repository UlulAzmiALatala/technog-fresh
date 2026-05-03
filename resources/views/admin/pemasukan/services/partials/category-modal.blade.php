{{-- Lokasi: resources/views/admin/pemasukan/services/partials/category-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isCategoryModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
        
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-[10px]" @click="isCategoryModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-10 text-center shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shrink-0">
                <i class="fas fa-tags"></i>
            </div>

            <h3 class="text-2xl text-slate-900 dark:text-white font-black tracking-tighter uppercase mb-6">New Category</h3>

            <form @submit.prevent="handleStoreCategory()" class="text-left">
                <div class="mb-8">
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category Name</label>
                    <input type="text" x-model="newCategoryName" required placeholder="e.g. Web Development"
                           class="w-full py-4 px-4 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white outline-none">
                    <p x-show="errorMessage" x-text="errorMessage" class="text-xs font-bold text-red-500 mt-2"></p>
                </div>

                <div class="flex space-x-4">
                    <button type="button" @click="isCategoryModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold uppercase tracking-widest transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl font-bold uppercase tracking-widest transition-none shadow-lg shadow-indigo-500/30">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>