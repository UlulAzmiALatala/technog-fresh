{{-- Lokasi: resources/views/admin/founder/settings/socials/partials/delete-modal.blade.php (FILE BARU) --}}
<div x-show="isDeleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        {{-- Latar belakang --}}
        <div x-show="isDeleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isDeleteModalOpen = false" aria-hidden="true"></div>

        {{-- Konten Modal --}}
        <div x-show="isDeleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block w-full max-w-md p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl">
            
            <div class="flex items-center justify-between space-x-4">
                <h1 class="text-xl font-medium text-gray-800 dark:text-white">Delete Social Link</h1>
                <button @click="isDeleteModalOpen = false" class="text-gray-600 dark:text-gray-400 focus:outline-none hover:text-gray-700 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </button>
            </div>
            
            <p class="mt-4 text-sm text-gray-600 dark:text-slate-400">
                Are you sure you want to delete this social media link? This action cannot be undone.
            </p>
            
            <form class="mt-5" :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="isDeleteModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-md hover:bg-gray-50 dark:hover:bg-slate-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
