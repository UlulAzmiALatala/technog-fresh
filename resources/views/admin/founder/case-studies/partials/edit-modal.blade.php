@php
// Logika untuk menampilkan modal ini jika terjadi error validasi
$showEdit = $errors->any() && session('modal_form') === 'edit';
@endphp

{{-- [REFACTOR] Menggunakan komponen x-modal standar --}}
{{-- 
    Kita BUNGKUS modal dengan 'x-data' agar 'imagePreview'
    bisa di-reset setiap kali modal ditutup.
--}}
<div x-data="{ imagePreview: null }" @close-modal.window="imagePreview = null">

    <x-modal name="edit-case-study-modal" :show="$showEdit" max-width="2xl" focusable>
        {{-- 
            Form ini dikontrol oleh 'editItem' dari 'caseStudyPageManager'.
            x-model="editItem.title"
        --}}
        <form 
            method="POST" 
            {{-- Action URL di-bind secara dinamis dari 'editItem' --}}
            x-bind:action="`{{ url('admin/founder/case-studies') }}/${editItem.id}`" 
            class="p-6" 
            enctype="multipart/form-data"
        >
            @csrf
            @method('PATCH')

            {{-- Input tersembunyi untuk memberi tahu controller modal mana yang dibuka --}}
            <input type="hidden" name="modal_form" value="edit">
            
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Case Study') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Update the details for this case study.
            </p>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri --}}
                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <x-input-label for="edit_title" :value="__('Project Title')" />
                        <x-text-input id="edit_title" name="title" type="text" class="mt-1 block w-full" x-model="editItem.title" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_client_name" :value="__('Client Name')" />
                        <x-text-input id="edit_client_name" name="client_name" type="text" class="mt-1 block w-full" x-model="editItem.client_name" required />
                        <x-input-error :messages="$errors->get('client_name')" class="mt-2" />
                    </div>

                    {{-- Kategori Dinamis --}}
                    <div>
                        <x-input-label for="edit_category_id_select" :value="__('Industry Category')" />
                        <div class="flex items-center space-x-2 mt-1">
                            <select id="edit_category_id_select" name="category_id" x-model="editItem.category_id" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select Category</option>
                                <template x-for="category in categories" :key="category.id">
                                    <option :value="category.id" x-text="category.name"></option>
                                </template>
                            </select>
                            <button type="button" @click.prevent="openCategoryModal()" class="flex-shrink-0 px-3 py-2 bg-indigo-600 border rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 whitespace-nowrap">
                                + New
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                </div>

                {{-- Kolom Kanan (Image) --}}
                <div class="space-y-2">
                    <x-input-label for="edit_image" :value="__('Project Image')" />
                    
                    {{-- Preview Gambar Baru --}}
                    <template x-if="imagePreview">
                        <img :src="imagePreview" class="w-full h-32 object-cover rounded-md border border-gray-200 my-2">
                    </template>
                    
                    {{-- Preview Gambar Lama (jika ada & gambar baru belum dipilih) --}}
                    <template x-if="!imagePreview && editItem.image">
                         <img :src="`{{ asset('storage') }}/${editItem.image}`" class="w-full h-32 object-cover rounded-md border border-gray-200 my-2">
                    </template>

                    {{-- Placeholder (jika tidak ada gambar lama & baru) --}}
                    <div x-show="!imagePreview && !editItem.image" class="w-full h-32 bg-gray-100 rounded-md flex items-center justify-center border-2 border-dashed border-gray-300 my-2">
                        <span class="text-gray-400 text-sm">Image Preview</span>
                    </div>
                    
                    <input type="file" name="image" id="edit_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                           @change="imagePreview = URL.createObjectURL($event.target.files[0])">
                    <p class="text-xs text-gray-500">Leave blank to keep the current image.</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
            </div>

            {{-- Textareas --}}
            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label for="edit_problem" :value="__('Client\'s Problem')" />
                    <textarea id="edit_problem" name="problem" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" x-model="editItem.problem" required></textarea>
                    <x-input-error :messages="$errors->get('problem')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="edit_solution" :value="__('Provided Solution')" />
                    <textarea id="edit_solution" name="solution" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" x-model="editItem.solution" required></textarea>
                    <x-input-error :messages="$errors->get('solution')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="edit_result" :value="__('Achieved Results')" />
                    <textarea id="edit_result" name="result" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" x-model="editItem.result" required></textarea>
                    <x-input-error :messages="$errors->get('result')" class="mt-2" />
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end space-x-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Update Case Study') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>

