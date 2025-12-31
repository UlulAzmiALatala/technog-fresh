{{-- Lokasi: resources/views/admin/pengeluaran/operational/partials/delete-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isDeleteModalOpen" 
         x-cloak 
         {{-- w-screen h-screen dan z-[9999] adalah kunci agar blur tidak bocor --}}
         class="fixed inset-0 z-[9999] w-screen h-screen bg-slate-900/60 backdrop-blur-[30px] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0">
        
        <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10" 
             @click.away="isDeleteModalOpen = false">
            
            <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl">
                <i class="fas fa-trash-alt"></i>
            </div>

            <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase">Delete record?</h3>
            <p class="text-slate-500 mt-4 text-sm font-normal">This action cannot be undone.</p>

            <form :action="deleteUrl" method="POST" class="mt-10 flex space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="isDeleteModalOpen = false" 
                        class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                <button type="submit" 
                        class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold transition-none shadow-lg">Delete Now</button>
            </form>
        </div>
    </div>
</template>