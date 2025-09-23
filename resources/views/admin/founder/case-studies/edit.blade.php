<x-admin-layout>
    <script>
        function categoryFormManager(initialCategories, currentCategoryId) {
            return {
                categories: initialCategories,
                openModal: false,
                newCategoryName: '',
                errorMessage: '',
                selectedCategoryId: currentCategoryId || '',

                openAddModal() {
                    this.openModal = true;
                    this.newCategoryName = '';
                    this.errorMessage = '';
                },
                async handleStore() {
                    this.errorMessage = '';
                    try {
                        const response = await fetch("{{ route('admin.founder.case-studies.categories.storeAjax') }}", {
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
            {{ __('Edit Case Study') }}
        </h2>
    </x-slot>

    {{-- Wrapper for all content + modal within a single x-data scope --}}
    <div class="mt-4"
         x-data="categoryFormManager({{ $categories->toJson() }}, {{ old('category_id', $caseStudy->category_id) ?? 'null' }})">

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

                <form action="{{ route('admin.founder.case-studies.update', $caseStudy->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="category_id" x-model="selectedCategoryId">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">Project Title</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                       value="{{ old('title', $caseStudy->title) }}" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="client_name" class="block font-medium text-sm text-gray-700">Client Name</label>
                                    <input type="text" name="client_name" id="client_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                           value="{{ old('client_name', $caseStudy->client_name) }}" required>
                                </div>

                                <div>
                                    <label for="category_id_select" class="block font-medium text-sm text-gray-700">Industry Category</label>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <select id="category_id_select" x-model="selectedCategoryId" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                            <option value="">Select Category</option>
                                            <template x-for="category in categories" :key="category.id">
                                                <option :value="category.id" x-text="category.name"></option>
                                            </template>
                                        </select>
                                        <button type="button" @click="openAddModal()" class="flex-shrink-0 px-4 py-2 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 whitespace-nowrap">
                                            + New Category
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="problem" class="block font-medium text-sm text-gray-700">Client's Problem</label>
                                <textarea name="problem" id="problem" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('problem', $caseStudy->problem) }}</textarea>
                            </div>

                            <div>
                                <label for="solution" class="block font-medium text-sm text-gray-700">Provided Solution</label>
                                <textarea name="solution" id="solution" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('solution', $caseStudy->solution) }}</textarea>
                            </div>

                            <div>
                                <label for="result" class="block font-medium text-sm text-gray-700">Achieved Results</label>
                                <textarea name="result" id="result" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('result', $caseStudy->result) }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-2"
                             x-data="{ imagePreview: {{ json_encode($caseStudy->image ? asset('storage/' . $caseStudy->image) : null) }} }">
                            <label for="image" class="block font-medium text-sm text-gray-700">Project Image</label>
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-48 object-cover rounded-md border border-gray-200">
                            </template>
                            <div x-show="!imagePreview" class="w-full h-48 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300">
                                <span class="text-gray-400">No image yet</span>
                            </div>
                            <input type="file" name="image" id="image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                            <p class="text-xs text-gray-500 mt-1">Leave blank if you don't want to change the image.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.founder.case-studies.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal moved into the x-data scope --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="openModal = false" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" x-transition.opacity
                     class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div x-show="openModal" x-transition
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="handleStore()">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Add Case Study Category</h3>
                            <div class="mt-4">
                                <label for="new_category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" x-model="newCategoryName" id="new_category_name" class="mt-1 block w-full rounded-md" required>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-red-600 mt-2"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto">
                                Save
                            </button>
                            <button type="button" @click="openModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border sm:mt-0 sm:w-auto px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
