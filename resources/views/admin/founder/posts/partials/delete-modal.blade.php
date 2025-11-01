{{-- 
=======================================================================================
MODAL HAPUS ARTIKEL (Partial)
=======================================================================================
- Ini adalah komponen <x-modal> standar.
- Dikontrol oleh Alpine.js dari index.blade.php.
- Nama modal: "delete-post-modal"
- Form action-nya dinamis: x-bind:action="deleteAction"
=======================================================================================
--}}
<x-modal name="delete-post-modal" :show="$errors->any() && session('modal_form') === 'delete'" focusable>
    <form method="POST" x-bind:action="deleteAction" class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this article?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once this article is deleted, all of its data will be permanently lost. This action cannot be undone.') }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button type="submit" class="ml-3">
                {{ __('Delete Article') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>

