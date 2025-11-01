@php
// Logika untuk menampilkan modal ini jika terjadi error validasi
$showAdd = $errors->any() && session('modal_form') === 'add';
@endphp

{{-- [REFACTOR] Menggunakan komponen x-modal standar --}}
<x-modal name="add-case-study-modal" :show="$showAdd" max-width="2xl" focusable>
    
    {{-- 
        [PENTING] Kita BUNGKUS form di luar slot modal agar 'x-data'
        untuk preview gambar bisa hidup
    --}}
    <form 
        method="POST" 
        action="{{ route('admin.founder.case-studies.store') }}" 
        class="p-6" 
        enctype="multipart/form-data"
        x-data="{ imagePreview: null }"
    >
        @csrf

        {{-- Input tersembunyi untuk memberi tahu controller modal mana yang dibuka --}}
        <input type="hidden" name="modal_form" value="add">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add New Case Study') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Fill in the details for the new case study.
        </p>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri --}}
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <x-input-label for="add_title" :value="__('Project Title')" />
                    <x-text-input id="add_title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="add_client_name" :value="__('Client Name')" />
                    <x-text-input id="add_client_name" name="client_name" type="text" class="mt-1 block w-full" :value="old('client_name')" required />
                    <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                </div>

                {{-- Kategori Dinamis --}}
                <div>
                    <x-input-label for="add_category_id_select" :value="__('Industry Category')" />
                    <div class="flex items-center space-x-2 mt-1">
                        {{-- 
                            Dropdown ini dikontrol oleh 'addModalCategoryId' 
                            dari 'caseStudyPageManager' di index.blade.php
                        --}}
                        <select id="add_category_id_select" name="category_id" x-model="addModalCategoryId" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Select Category</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.id" x-text="category.name"></option>
                            </template>
                        </select>
                        {{-- Tombol ini memanggil 'openCategoryModal' dari 'caseStudyPageManager' --}}
                        <button type="button" @click.prevent="openCategoryModal()" class="flex-shrink-0 px-3 py-2 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 whitespace-nowrap">
                            + New
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>
            </div>

            {{-- Kolom Kanan (Image) --}}
            <div class="space-y-2">
                <x-input-label for="add_image" :value="__('Project Image')" />
                
                {{-- Preview --}}
                <template x-if="imagePreview">
                    <img :src="imagePreview" class="w-full h-32 object-cover rounded-md border border-gray-200 my-2">
                </template>
                
                {{-- Placeholder --}}
                <div x-show="!imagePreview" class="w-full h-32 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300 my-2">
                    <span class="text-gray-400 text-sm">Image Preview</span>
                </div>
                
                <input type="file" name="image" id="add_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                       @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
        </div>

        {{-- Textareas --}}
        <div class="mt-6 space-y-4">
            <div>
                <x-input-label for="add_problem" :value="__('Client\'s Problem')" />
                <textarea id="add_problem" name="problem" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required>{{ old('problem') }}</textarea>
                <x-input-error :messages="$errors->get('problem')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="add_solution" :value="__('Provided Solution')" />
                <textarea id="add_solution" name="solution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required>{{ old('solution') }}</textarea>
                <x-input-error :messages="$errors->get('solution')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="add_result" :value="__('Achieved Results')" />
                <textarea id="add_result" name="result" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required>{{ old('result') }}</textarea>
                <x-input-error :messages="$errors->get('result')" class="mt-2" />
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex justify-end space-x-4">
            {{-- Tombol $dispatch('close') ini standar dari x-modal --}}
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-primary-button type="submit">
                {{ __('Save Case Study') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

