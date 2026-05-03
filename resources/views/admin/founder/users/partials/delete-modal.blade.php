<template x-teleport="body">
    <div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isDeleteModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/30 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl shrink-0">
                <i class="fas fa-user-slash"></i>
            </div>

            <h3 class="text-2xl text-slate-900 dark:text-white font-black tracking-tighter uppercase">Delete User?</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-medium leading-relaxed">
                This action is permanent. The user's account and access will be completely removed from the system.
            </p>

            <form :action="deleteUrl" method="POST" class="mt-10 flex space-x-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold uppercase tracking-widest transition-none">Cancel</button>
                <button type="submit" class="flex-1 py-4 bg-rose-500 text-white rounded-2xl font-bold uppercase tracking-widest transition-none shadow-lg shadow-rose-500/30">Delete</button>
            </form>
        </div>
    </div>
</template>