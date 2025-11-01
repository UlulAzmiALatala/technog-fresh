<x-modal name="add-testimonial-modal" :show="$errors->any() && session('modal_form') === 'add'" focusable>
    
    <form method="POST" action="{{ route('admin.testimonials.store') }}" class="p-6">
        @csrf
        <input type="hidden" name="modal_form" value="add">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add New Testimonial') }}
        </h2>

        <div class="mt-6 grid grid-cols-1 gap-y-6">
            <div>
                <x-input-label for="add_user_id" :value="__('Client (User)')" />
                <select id="add_user_id" name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select a client</option>
                    <template x-for="user in users" :key="user.id">
                        <option :value="user.id" x-text="user.name" :selected="user.id == '{{ old('user_id') }}'"></option>
                    </template>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
            </div>

            <div>
                <x-input-label for="add_order_id" :value="__('Associated Order (Project)')" />
                <select id="add_order_id" name="order_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Select an order</option>
                    <template x-for="order in orders" :key="order.id">
                        
                        <option :value="order.id" x-text="`Order #${order.id} (${getFirstServiceName(order)})`" :selected="order.id == '{{ old('order_id') }}'"></option>
                    </template>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('order_id')" />
            </div>

            <div>
                <x-input-label for="add_rating" :value="__('Rating (1-5)')" />
                <select id="add_rating" name="rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="5" @selected(old('rating', 5) == 5)>5 Stars</option>
                    <option value="4" @selected(old('rating') == 4)>4 Stars</option>
                    <option value="3" @selected(old('rating') == 3)>3 Stars</option>
                    <option value="2" @selected(old('rating') == 2)>2 Stars</option>
                    <option value="1" @selected(old('rating') == 1)>1 Star</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('rating')" />
            </div>

            <div>
                <x-input-label for="add_content" :value="__('Review Content')" />
                <textarea id="add_content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('content') }}</textarea>

                <x-input-error class="mt-2" :messages="$errors->get('content')" />
            </div>

            <div class="block">
                <label for="add_is_featured" class="inline-flex items-center">
                    <input id="add_is_featured" type="checkbox" name="is_featured" value="1" @checked(old('is_featured') == '1') class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Feature this testimonial on homepage?') }}</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3">
                {{ __('Save Testimonial') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

