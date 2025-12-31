{{-- Lokasi: resources/views/admin/pemasukan/discounts/partials/edit-modal.blade.php --}}

<div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
        {{-- Overlay --}}
        <div x-show="isEditModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="isEditModalOpen = false" aria-hidden="true">
        </div>

        <div x-show="isEditModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="inline-block w-full max-w-lg p-8 my-20 overflow-hidden text-left transition-all transform bg-white dark:bg-slate-800 rounded-lg shadow-xl 2xl:max-w-2xl">
            
            <div class="flex items-center justify-between space-x-4">
                <h1 class="text-xl font-medium text-gray-800 dark:text-white">Edit Discount Code</h1>
                <button @click="isEditModalOpen = false" class="text-gray-600 dark:text-gray-400 focus:outline-none hover:text-gray-700 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </button>
            </div>
            
            <form class="mt-5" :action="`/admin/pemasukan/discounts/${editingDiscount.id}`" method="POST">
                @csrf
                @method('PATCH')
                <div class="space-y-6">
                    {{-- Discount Code --}}
                    <div>
                        <label for="edit_code" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Discount Code</label>
                        <input type="text" name="code" id="edit_code" :value="editingDiscount.code" required 
                               x-on:input="$el.value = $el.value.toUpperCase()"
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    {{-- Amount dengan Dukungan Desimal --}}
                    <div>
                        <label for="edit_amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Amount ($)</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="edit_amount" step="0.01" :value="editingDiscount.amount" required 
                                   class="block w-full rounded-md border-gray-300 dark:border-slate-600 pl-7 pr-12 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white" placeholder="0.00">
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    {{-- Expires At --}}
                    <div>
                        <label for="edit_expires_at" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Expires At (Optional)</label>
                        <input type="date" name="expires_at" id="edit_expires_at" 
                               :value="editingDiscount.expires_at ? editingDiscount.expires_at.split('T')[0] : ''" 
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                    </div>

                    {{-- Stock Management --}}
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="edit_max_uses" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Max Uses (Stock)</label>
                            <input type="number" name="max_uses" id="edit_max_uses" :value="editingDiscount.max_uses" class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white" placeholder="Unlimited">
                            <x-input-error :messages="$errors->get('max_uses')" class="mt-2" />
                        </div>
                        <div>
                            <label for="edit_current_uses" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Current Uses</label>
                            <input type="number" name="current_uses" id="edit_current_uses" :value="editingDiscount.current_uses" required 
                                   class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                            <x-input-error :messages="$errors->get('current_uses')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Status Active --}}
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" :checked="editingDiscount.is_active" class="h-4 w-4 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-700">
                        <label for="edit_is_active" class="ml-2 block text-sm text-gray-900 dark:text-slate-300">Activate this code</label>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="isEditModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-md hover:bg-gray-50 dark:hover:bg-slate-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">Update Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>