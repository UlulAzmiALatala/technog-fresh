{{-- VERSI FINAL: resources/views/admin/founder/settings/socials/partials/edit-modal.blade.php --}}

<div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        
        {{-- Latar belakang --}}
        <div x-show="isEditModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isEditModalOpen = false" aria-hidden="true">
        </div>

        {{-- Konten Modal --}}
        <div x-show="isEditModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-lg p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl 2xl:max-w-2xl">
            
            <div class="flex items-center justify-between space-x-4">
                <h1 class="text-xl font-medium text-gray-800 dark:text-white">Edit Social Link</h1>
                <button @click="isEditModalOpen = false" class="text-gray-600 dark:text-gray-400 focus:outline-none hover:text-gray-700 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </button>
            </div>
            
            <form class="mt-5" :action="`/admin/founder/settings/social-links/${editingLink.id}`" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-6">
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Platform Name</label>
                        <select name="name" id="edit_name" x-model="editingLink.name" class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                            <option value="">Select Platform</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Instagram">Instagram</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="YouTube">YouTube</option>
                            <option value="GitHub">GitHub</option>
                            <option value="TikTok">TikTok</option>
                            <option value="Website">Website (Lainnya)</option>
                        </select>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="edit_url" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Full URL</label>
                        <input type="url" name="url" id="edit_url" x-model="editingLink.url" required class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>

                    <div>
                        <label for="edit_sort_order" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Sort Order (Optional)</label>
                        <input type="number" name="sort_order" id="edit_sort_order" x-model="editingLink.sort_order" class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="isEditModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-md hover:bg-gray-50 dark:hover:bg-slate-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                        Update Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>