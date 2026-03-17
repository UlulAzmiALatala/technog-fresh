{{-- Lokasi: resources/views/admin/pemasukan/services/partials/category-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isCategoryModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop Khusus Kategori (Klik ini untuk tutup modal) --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isCategoryModalOpen = false"></div>

        {{-- Konten Modal Kategori --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300 delay-75" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            
            <div class="pb-6 mb-6">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-black uppercase text-center">Kategori Baru</h3>
            </div>

            <form @submit.prevent="handleStoreCategory()">
                <div class="mb-8">
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Nama Kategori</label>
                    <input type="text" x-model="newCategoryName" required placeholder="Cth: Web Development"
                           class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-4 px-4 focus:ring-indigo-500 font-medium outline-none text-center">
                    <p x-show="errorMessage" x-text="errorMessage" class="text-xs font-bold text-red-600 mt-3 text-center"></p>
                </div>

                <div class="flex space-x-4">
                    <button type="button" @click="isCategoryModalOpen = false" 
                            class="flex-1 py-4 bg-slate-50 dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-2xl font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 py-4 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-2xl shadow-lg shadow-indigo-900/20 font-bold transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>