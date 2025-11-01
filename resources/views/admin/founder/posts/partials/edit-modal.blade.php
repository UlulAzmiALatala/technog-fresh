<x-modal name="edit-post-modal" :show="$errors->any() && session('modal_form') === 'edit'" maxWidth="2xl" focusable>
    <form method="POST" :action="`{{ url('admin/founder/posts') }}/${editItem.id}`" class="p-6" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="modal_form" value="edit">
        
        <input type="hidden" name="id" x-model="editItem.id">

        <h2 class="text-lg font-medium text-gray-900">
            Edit Article
        </h2>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <x-input-label for="edit_title" value="Article Title" />
                    <x-text-input type="text" name="title" id="edit_title" class="mt-1 block w-full" x-model="editItem.title" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="edit_body" value="Content Body" />
                    <textarea name="body" id="edit_body" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" x-model="editItem.body"></textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="edit_category_id_select" value="Article Category" />
                    <div class="flex items-center space-x-2 mt-1">
                        <select id="edit_category_id_select" name="category_id" x-model="editItem.category_id" class="block w-full rounded-md border-gray-300 shadow-sm" required>
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
                    <x-input-label for="edit_status" value="Status" />
                    <select name="status" id="edit_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" x-model="editItem.status" required>
                        <option value="DRAFT">Draft</option>
                        <option value="PUBLISHED">Published</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="edit_image" value="Featured Image" />
                    <template x-if="editImagePreview">
                        <img :src="editImagePreview" class="w-full h-32 object-cover rounded-md border border-gray-200">
                    </template>
                    <template x-if="!editImagePreview && editItem.image_url">
                         <img :src="editItem.image_url" class="w-full h-32 object-cover rounded-md border border-gray-200">
                    </template>
                    <div x-show="!editImagePreview && !editItem.image_url" class="w-full h-32 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300 my-2">
                        <span class="text-gray-400">Image Preview</span>
                    </div>
                    <input type="file" name="image" id="edit_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                           @change="editImagePreview = URL.createObjectURL($event.target.files[0])">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button type="submit" class="ml-3">
                Update Article
            </x-primary-button>
        </div>
    </form>
</x-modal>

