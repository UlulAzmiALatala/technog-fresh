{{-- Lokasi: resources/views/admin/founder/workers/partials/delete-modal.blade.php --}}
<div x-show="isDeleteModalOpen" x-cloak 
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-[20px]"
     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
    
    <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10" @click.away="isDeleteModalOpen = false">
        <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl">
            <i class="fas fa-user-times"></i>
        </div>
        <h3 class="text-2xl text-slate-900 dark:text-white font-normal tracking-tighter">Remove Worker?</h3>
        <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-normal leading-relaxed">
            Removing this talent will not delete their previous payout history, but they will no longer appear in future project assignments.
        </p>

        <form :action="deleteUrl" method="POST" class="mt-10 flex space-x-4">
            @csrf
            @method('DELETE')
            <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-4 bg-slate-100 text-slate-500 rounded-xl font-normal transition-none">Cancel</button>
            <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-xl font-normal transition-none shadow-lg shadow-red-900/20">Delete Talent</button>
        </form>
    </div>
</div>