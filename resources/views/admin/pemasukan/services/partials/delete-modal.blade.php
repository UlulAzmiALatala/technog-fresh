{{-- Lokasi: resources/views/admin/pemasukan/services/partials/delete-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isDeleteModalOpen" x-cloak 
         class="fixed inset-0 z-[999] overflow-y-auto bg-slate-900/60 backdrop-blur-[30px]"
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-12 text-center shadow-2xl border border-white/10 my-8" 
                 @click.away="isDeleteModalOpen = false">
                
                <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-8 text-3xl">
                    <i class="fas fa-trash-alt"></i>
                </div>

                <h3 class="text-2xl text-slate-900 dark:text-white font-bold tracking-tighter uppercase">Hapus Layanan?</h3>
                
                <p class="text-slate-500 dark:text-slate-400 mt-4 text-sm font-normal leading-relaxed">
                    Layanan <strong class="text-slate-700 dark:text-slate-300">{{ $service->name }}</strong> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
                </p>

                <form action="{{ route('admin.pemasukan.services.destroy', $service->id) }}" method="POST" class="mt-10 flex space-x-4">
                    @csrf
                    @method('DELETE')
                    
                    <button type="button" @click="isDeleteModalOpen = false" 
                            class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">
                        Cancel
                    </button>
                    
                    <button type="submit" 
                            class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-bold transition-none shadow-lg shadow-red-900/20">
                        Delete Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>