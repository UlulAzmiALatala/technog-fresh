<template x-teleport="body">
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isDeleteModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl shrink-0">
                <i class="fas fa-trash-alt"></i>
            </div>

            <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase">Delete Logo?</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-normal leading-relaxed">
                This action is permanent. The logo asset will be deleted from the server storage.
            </p>

            <form :action="deleteUrl" method="POST" class="mt-10 flex space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold transition-none shadow-lg shadow-red-900/20">Delete</button>
            </form>
        </div>
    </div>
</template>