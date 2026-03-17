{{-- Lokasi: resources/views/admin/pemasukan/orders/partials/confirmation-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isConfirmModalOpen" x-cloak 
         class="fixed inset-0 z-[999] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop Super Blur --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isConfirmModalOpen = false"></div>
        
        {{-- Konten Modal --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10 z-10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            
            {{-- Icon Animasi Dinamis --}}
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner transition-colors duration-300"
                 :class="confirmModalType === 'danger' ? 'bg-red-50 dark:bg-red-900/30 text-red-600' : 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500'">
                <i class="fas" :class="confirmModalType === 'danger' ? 'fa-exclamation-triangle' : 'fa-check-circle'"></i>
            </div>

            {{-- Teks --}}
            <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase" x-text="confirmModalTitle"></h3>
            <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-medium leading-relaxed" x-text="confirmModalText"></p>

            {{-- Form Aksi --}}
            <form :action="confirmActionUrl" method="POST" class="mt-10 flex space-x-4">
                @csrf
                <div x-html="confirmHiddenInputs"></div>
                
                {{-- Tombol Batal --}}
                <button type="button" @click="isConfirmModalOpen = false" 
                        class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-2xl font-bold transition-colors">
                    Cancel
                </button>
                
                {{-- Tombol Konfirmasi (Warna Otomatis) --}}
                <button type="submit" 
                        class="flex-1 py-4 text-white rounded-2xl font-bold transition-all shadow-lg"
                        :class="confirmModalType === 'danger' ? 'bg-red-600 hover:bg-red-700 shadow-red-900/20' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-900/20'">
                    Confirm
                </button>
            </form>
        </div>
    </div>
</template>