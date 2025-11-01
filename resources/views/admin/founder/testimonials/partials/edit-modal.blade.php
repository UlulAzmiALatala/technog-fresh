<x-modal name="edit-testimonial-modal" :show="$errors->any() && session('modal_form') === 'edit'" focusable>
    
    <form method="POST" :action="`{{ url('admin/testimonials') }}/${editItem.id}`" class="p-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="modal_form" value="edit">
        <input type="hidden" name="id" x-model="editItem.id">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Testimonial') }}
        </h2>

        <div class="mt-6 grid grid-cols-1 gap-y-6">
            <div>
                <x-input-label :value="__('Client (User)')" />
                <p class="mt-1 text-sm text-gray-700 font-medium" x-text="editItem.user.name"></p>
                <p class="mt-1 text-xs text-gray-500">Client and Order cannot be changed after submission.</p>
            </div>

            <div>
                <x-input-label :value="__('Associated Order (Project)')" />
                
                <p class="mt-1 text-sm text-gray-700 font-medium" x-text="`Order #${editItem.order.id} (${getFirstServiceName(editItem.order)})`"></p>
            </div>

            <div>
                <x-input-label for="edit_rating" :value="__('Rating (1-5)')" />
                <select id="edit_rating" name="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" x-model="editItem.rating" required>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('rating')" />
            </div>

            <div>
                <x-input-label for="edit_content" :value="__('Review Content')" />
                <textarea id="edit_content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" x-model="editItem.content" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('content')" />
            </div>

            <div class="block">
                <label for="edit_is_featured" class="inline-flex items-center">
                    <input id="edit_is_featured" type="checkbox" name="is_featured" value="1" x-model="editItem.is_featured" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Feature this testimonial on homepage?') }}</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Update Testimonial') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

