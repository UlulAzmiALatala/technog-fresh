{{-- Lokasi: resources/views/admin/founder/case-studies/partials/category-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isCategoryModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[10px]" @click="isCategoryModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] shadow-2xl border border-white/10 p-8"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <h3 class="text-xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase mb-6 text-center">Add Industry Category</h3>

            <form @submit.prevent="handleStoreCategory()">
                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category Name</label>
                    <input type="text" x-model="newCategoryName" required
                           class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                    <p x-show="categoryErrorMessage" x-text="categoryErrorMessage" class="text-xs text-red-500 mt-2 font-normal"></p>
                </div>

                <div class="flex space-x-4 pt-8">
                    <button type="button" @click="isCategoryModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>