<template x-teleport="body">
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px]"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isDeleteModalOpen = false"></div>
        
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10 z-10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            
            <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl">
                <i class="fas fa-trash-alt"></i>
            </div>

            <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase">Delete Discount?</h3>
            <p class="text-slate-500 mt-4 text-sm font-normal">Are you sure you want to delete this code? This action cannot be undone.</p>

            <form :action="deleteUrl" method="POST" class="mt-10 flex space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="isDeleteModalOpen = false" 
                        class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold transition-colors">Cancel</button>
                <button type="submit" 
                        class="flex-1 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold transition-colors shadow-lg shadow-red-900/20">Delete Now</button>
            </form>
        </div>
    </div>
</template>