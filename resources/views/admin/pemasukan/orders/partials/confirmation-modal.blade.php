{{-- Lokasi: resources/views/admin/pemasukan/orders/partials/confirmation-modal.blade.php --}}

<div x-show="isConfirmModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        {{-- Latar belakang modal --}}
        <div x-show="isConfirmModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isConfirmModalOpen = false" aria-hidden="true">
        </div>

        {{-- Konten Modal --}}
        <div x-show="isConfirmModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-md p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl">
            
            <div class="flex items-start">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10" :class="confirmModalType === 'danger' ? 'bg-red-100 dark:bg-red-900/50' : 'bg-green-100 dark:bg-green-900/50'">
                    <i class="fas" :class="{
                        'fa-exclamation-triangle text-red-600 dark:text-red-400': confirmModalType === 'danger',
                        'fa-check-circle text-green-600 dark:text-green-400': confirmModalType !== 'danger'
                    }"></i>
                </div>
                <div class="ml-4 text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" x-text="confirmModalTitle"></h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="confirmModalText"></p>
                    </div>
                </div>
            </div>

            {{-- Form akan mengambil action URL dari Alpine.js --}}
            <form class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse" :action="confirmActionUrl" method="POST">
                {{-- Form ini akan berisi input hidden dari form aslinya --}}
                <div x-html="confirmHiddenInputs"></div>

                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white sm:ml-3 sm:w-auto sm:text-sm" :class="confirmModalType === 'danger' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'">
                    Confirm
                </button>
                <button type="button" @click="isConfirmModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-600 sm:mt-0 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>
