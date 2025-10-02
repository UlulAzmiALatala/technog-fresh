<x-admin-layout>
    {{-- "Brain" script for this feature --}}
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
                        const response = await fetch("{{ route('admin.pemasukan.services.categories.storeAjax') }}", {
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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="mt-4" x-data="categoryFormManager({{ $categories->toJson() }}, {{ old('category_id', $service->category_id) ?? 'null' }})">
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 dark:border-slate-700">
            <div class="p-6 md:p-8 text-gray-900 dark:text-slate-200">
                
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.pemasukan.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" x-model="selectedCategoryId">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Left Column: Form Inputs --}}
                        <div class="lg:col-span-2 space-y-6">
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Service Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" value="{{ old('name', $service->name) }}" required>
                            </div>

                            <div>
                                <label for="package_plan" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Service Package</label>
                                <select name="package_plan" id="package_plan" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" required>
                                    <option value="">Select Package</option>
                                    <option value="Silver Plan" @selected(old('package_plan', $service->package_plan) == 'Silver Plan')>Silver Plan</option>
                                    <option value="Gold Plan" @selected(old('package_plan', $service->package_plan) == 'Gold Plan')>Gold Plan</option>
                                    <option value="Platinum Sphere" @selected(old('package_plan', $service->package_plan) == 'Platinum Sphere')>Platinum Sphere</option>
                                    <option value="Diamond Class" @selected(old('package_plan', $service->package_plan) == 'Diamond Class')>Diamond Class</option>
                                    <option value="Ultima Partnership" @selected(old('package_plan', $service->package_plan) == 'Ultima Partnership')>Ultima Partnership</option>
                                    <option value="Custom Engagement" @selected(old('package_plan', $service->package_plan) == 'Custom Engagement')>Custom Engagement</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Price ($)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" value="{{ old('price', $service->price) }}" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="estimated_duration" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Estimate</label>
                                        <input type="number" name="estimated_duration" id="estimated_duration" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" value="{{ old('estimated_duration', $service->estimated_duration) }}" required>
                                    </div>
                                    <div>
                                        <label for="duration_unit" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Unit</label>
                                        <select name="duration_unit" id="duration_unit" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" required>
                                            <option value="Hari" @selected(old('duration_unit', $service->duration_unit) == 'Hari')>Days</option>
                                            <option value="Minggu" @selected(old('duration_unit', $service->duration_unit) == 'Minggu')>Weeks</option>
                                            <option value="Bulan" @selected(old('duration_unit', $service->duration_unit) == 'Bulan')>Months</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="features" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Key Features</label>
                                <textarea name="features" id="features" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" placeholder="Write each feature on a new line...">{{ old('features', $service->features) }}</textarea>
                            </div>

                            <div>
                                <label for="description" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Full Description</label>
                                <textarea name="description" id="description" rows="6" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Right Column: Image Upload & Category --}}
                        <div class="space-y-6" x-data="{ imagePreview: {{ json_encode($service->image ? asset('storage/' . $service->image) : null) }} }">
                             <div>
                                <label for="category_id_select" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Main Category</label>
                                <div class="flex items-center space-x-2 mt-1">
                                    <select id="category_id_select" x-model="selectedCategoryId" class="block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 shadow-sm" required>
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
                            <div class="space-y-2">
                                <label for="image" class="block font-medium text-sm text-gray-700 dark:text-slate-300">Service Image</label>
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="w-full h-48 object-cover rounded-md border dark:border-slate-600">
                                </template>
                                <div x-show="!imagePreview" class="w-full h-48 bg-gray-100 dark:bg-slate-700 rounded-md flex items-center justify-center border-2 border-dashed dark:border-slate-600">
                                    <span class="text-gray-400 dark:text-slate-500">Image Preview</span>
                                </div>
                                <input type="file" name="image" id="image" class="mt-2 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900" @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                                <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Format: JPG, PNG. Max: 2MB. Leave blank if you don't want to change the image.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
                        <a href="{{ route('admin.pemasukan.services.index') }}" class="text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white mr-6">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-green-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Modal for Adding Category --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="openModal = false" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div x-show="openModal" x-transition class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="handleStore()">
                        <div class="bg-white dark:bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-slate-200">Add New Service Category</h3>
                            <div class="mt-4">
                                <label for="new_category_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Category Name</label>
                                <input type="text" x-model="newCategoryName" id="new_category_name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700" required>
                                <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-red-600 mt-2"></p>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto">Save</button>
                            <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border sm:mt-0 sm:w-auto px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-600">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>