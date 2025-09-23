<x-admin-layout>
    {{-- Script "brain" for this feature. Placed at the top to be read first. --}}
    <script>
        function postFormManager(initialCategories) {
            return {
                // Data for categories
                categories: initialCategories,
                openModal: false,
                newCategoryName: '',
                errorMessage: '',
                selectedCategoryId: '{{ old('category_id') }}' || '',
                
                // Data for image preview
                imagePreview: null,

                // Methods for categories
                openAddModal() {
                    this.openModal = true;
                    this.newCategoryName = '';
                    this.errorMessage = '';
                },
                async handleStoreCategory() {
                    this.errorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.founder.posts.categories.storeAjax') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });
                        const data = await response.json();
                        if (!response.ok) throw data;

                        if (data.success) {
                            this.categories.push(data.category);
                            this.selectedCategoryId = data.category.id;
                            this.openModal = false;
                        }
                    } catch (error) {
                        this.errorMessage = error.errors?.name?.[0] || 'An error occurred while saving.';
                    }
                }
            }
        }
    </script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write New Article') }}
        </h2>
    </x-slot>

    {{-- Initialize Alpine.js here to manage the entire form --}}
    <div class="mt-4" x-data="postFormManager({{ $categories->toJson() }})">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.founder.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden input for category --}}
                    <input type="hidden" name="category_id" x-model="selectedCategoryId">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Left Column: Main Form --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">Article Title</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title') }}" required>
                            </div>
                            <div>
                                <label for="body" class="block font-medium text-sm text-gray-700">Content Body</label>
                                <textarea name="body" id="body" rows="15" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('body') }}</textarea>
                            </div>
                        </div>

                        {{-- Right Column: Additional Settings --}}
                        <div class="space-y-6">
                            {{-- Dynamic Category Dropdown --}}
                            <div>
                                <label for="category_id_select" class="block font-medium text-sm text-gray-700">Article Category</label>
                                <div class="flex items-center space-x-2 mt-1">
                                    <select id="category_id_select" x-model="selectedCategoryId" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">Select Category</option>
                                        <template x-for="category in categories" :key="category.id">
                                            <option :value="category.id" x-text="category.name"></option>
                                        </template>
                                    </select>
                                    <button type="button" @click="openAddModal()" class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm font-semibold">+</button>
                                </div>
                            </div>
                            
                            {{-- Status --}}
                            <div>
                                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="DRAFT" @selected(old('status') == 'DRAFT')>Draft</option>
                                    <option value="PUBLISHED" @selected(old('status') == 'PUBLISHED')>Published</option>
                                </select>
                            </div>

                            {{-- Featured Image & Preview --}}
                            <div class="space-y-2">
                                <label for="image" class="block font-medium text-sm text-gray-700">Featured Image</label>
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="w-full h-48 object-cover rounded-md border border-gray-200">
                                </template>
                                <div x-show="!imagePreview" class="w-full h-48 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300">
                                    <span class="text-gray-400">Image Preview</span>
                                </div>
                                <input type="file" name="image" id="image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                       @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.founder.posts.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">Save Article</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal for Adding Category --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="openModal = false" style="display: none;">
           <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div x-show="openModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="handleStoreCategory()">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Post Category</h3>
                            <div class="mt-4">
                                <label for="new_category_name_post" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" x-model="newCategoryName" id="new_category_name_post" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-red-600 mt-2"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                            <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
