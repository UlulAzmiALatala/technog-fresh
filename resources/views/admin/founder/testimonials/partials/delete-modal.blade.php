<x-modal name="delete-testimonial-modal" focusable>
    <form method="POST" x-bind:action="deleteAction" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this testimonial?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once this testimonial is deleted, all of its data will be permanently removed. This action cannot be undone.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3">
                {{ __('Delete Testimonial') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>

