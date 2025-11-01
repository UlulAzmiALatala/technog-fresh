{{-- [REFACTOR] Menggunakan komponen x-modal standar --}}
{{-- 
    Modal ini dikontrol oleh 'deleteAction' dari 'caseStudyPageManager'.
    x-bind:action="deleteAction"
--}}
<x-modal name="delete-case-study-modal" max-width="lg" focusable>
    <form 
        method="POST" 
        x-bind:action="deleteAction" 
        class="p-6"
    >
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this case study?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Once this case study is deleted, all of its data will be permanently removed. This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end space-x-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            
            <x-danger-button type="submit">
                {{ __('Delete Case Study') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>

