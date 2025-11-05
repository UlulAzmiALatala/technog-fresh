{{-- Lokasi: resources/views/admin/founder/settings/logos/partials/delete-modal.blade.php --}}

<div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center md:items-center sm:block sm:p-0">
        {{-- Latar belakang modal --}}
        <div x-show="isDeleteModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isDeleteModalOpen = false" aria-hidden="true">
        </div>

        {{-- Konten Modal --}}
        <div x-show="isDeleteModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-lg p-8 my-20 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl 2xl:max-w-2xl">
            
            <div class="flex flex-col items-center">
                {{-- Ikon Tong Sampah Besar --}}
                <div class="flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/50">
                    <i class="fas fa-trash-alt fa-2x text-red-600 dark:text-red-400"></i>
                </div>

                <div class="mt-4 text-center">
                    <h1 class="text-xl font-medium text-gray-800 dark:text-white" id="modal-title">
                        Delete Logo
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-slate-400">
                        Are you sure you want to delete this logo? The image file will be permanently removed. This action cannot be undone.
                    </p>
                </div>
            </div>
            
            {{-- Form Delete --}}
            <form class="mt-8" :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                
                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row-reverse sm:gap-x-4 gap-y-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" @click="isDeleteModalOpen = false" class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-700 text-base font-medium text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-600 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>