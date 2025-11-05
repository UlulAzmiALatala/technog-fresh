{{-- Lokasi: resources/views/admin/founder/settings/logos/partials/add-modal.blade.php --}}

<div x-show="isAddModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        {{-- Latar belakang modal --}}
        <div x-show="isAddModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isAddModalOpen = false" aria-hidden="true">
        </div>

        {{-- Konten Modal --}}
        <div x-show="isAddModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-lg p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl 2xl:max-w-2xl">
            
            <div class="flex items-center justify-between space-x-4">
                <h1 class="text-xl font-medium text-gray-800 dark:text-white">Upload New Logo</h1>
                <button @click="isAddModalOpen = false" class="text-gray-600 dark:text-gray-400 focus:outline-none hover:text-gray-700 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </button>
            </div>
            
            {{-- Form, perhatikan 'enctype' untuk file upload --}}
            <form class="mt-5" action="{{ route('admin.founder.settings.logos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- HAPUS: Input hidden 'open_add_modal' tidak lagi diperlukan oleh controller V2 --}}

                <div class="space-y-6">
                    <div>
                        <label for="add_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Logo Name</label>
                        {{-- --- PERBAIKAN: x-model ke 'newLogo' --- --}}
                        <input type="text" name="name" id="add_name" x-model="newLogo.name" required
                               placeholder="e.g. Header Light, Favicon"
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="add_logo_file" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Logo File</label>
                        {{-- --- PERBAIKAN: @change memanggil 'handleFileChange' --- --}}
                        <input type="file" name="logo_file" id="add_logo_file" @change="handleFileChange($event, 'add')" required 
                               accept="image/png, image/jpeg, image/svg+xml"
                               class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400">
                        <x-input-error :messages="$errors->get('logo_file')" class="mt-2" />
                    </div>

                    {{-- Preview --}}
                    {{-- --- PERBAIKAN: x-if ke 'newLogo' --- --}}
                    <template x-if="newLogo.previewUrl">
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Preview:</label>
                            {{-- --- PERBAIKAN: :src ke 'newLogo' --- --}}
                            <img :src="newLogo.previewUrl" class="mt-2 h-12 w-auto max-w-xs rounded-md bg-gray-200 dark:bg-slate-700 p-2">
                        </div>
                    </template>

                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        {{-- --- PERBAIKAN: x-model ke 'newLogo' --- --}}
                        <input type="checkbox" name="is_active" id="add_is_active" value="1" x-model="newLogo.is_active" 
                               class="h-4 w-4 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-700">
                        <label for="add_is_active" class="ml-2 block text-sm text-gray-900 dark:text-slate-300">Set as active logo</label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="isAddModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-md hover:bg-gray-50 dark:hover:bg-slate-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                        Upload Logo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>