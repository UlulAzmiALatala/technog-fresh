<x-modal name="add-post-modal" :show="$errors->any() && session('modal_form') === 'add'" maxWidth="2xl" focusable>
    <form action="{{ route('admin.founder.posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <input type="hidden" name="modal_form" value="add">

        <h2 class="text-lg font-medium text-gray-900">
            Write New Article
        </h2>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <x-input-label for="add_title" value="Article Title" />
                    <x-text-input type="text" name="title" id="add_title" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="add_body" value="Content Body" />
                    <textarea name="body" id="add_body" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="add_category_id_select" value="Article Category" />
                    <div class="flex items-center space-x-2 mt-1">
                        <select id="add_category_id_select" name="category_id" x-model="addModalCategoryId" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Select Category</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.id" x-text="category.name"></option>
                            </template>
                        </select>
                        <button type="button" @click="openAddCategoryForm()" class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm font-semibold">+</button>
                    </div>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>
                
                <div>
                    <x-input-label for="add_status" value="Status" />
                    <select name="status" id="add_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="DRAFT" @selected(old('status') == 'DRAFT')>Draft</option>
                        <option value="PUBLISHED" @selected(old('status') == 'PUBLISHED')>Published</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="space-y-2" x-data="{ imagePreview: null }">
                    <x-input-label for="add_image" value="Featured Image" />
                    <template x-if="imagePreview">
                        <img :src="imagePreview" class="w-full h-32 object-cover rounded-md border border-gray-200">
                    </template>
                    <div x-show="!imagePreview" class="w-full h-32 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300">
                        <span class="text-gray-400">Image Preview</span>
                    </div>
                    <input type="file" name="image" id="add_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                           @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button type="submit" class="ml-3">
                Save Article
            </x-primary-button>
        </div>
    </form>
</x-modal>

