<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop Super Blur --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isAddModalOpen = false"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl max-h-[95vh] overflow-y-auto rounded-[2.5rem] shadow-2xl border border-white/10 z-10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md z-20">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Add New Discount</h3>
                <button @click="isAddModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.pemasukan.discounts.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Discount Code</label>
                        <input type="text" name="code" value="{{ old('code') }}" required 
                               x-on:input="$el.value = $el.value.toUpperCase()" placeholder="e.g. PROMO2026"
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-black tracking-widest focus:ring-indigo-500">
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Amount ($)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400">$</span>
                            <input type="number" name="amount" step="0.01" value="{{ old('amount') }}" required placeholder="0.00"
                                   class="w-full pl-8 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Max Uses (Stock)</label>
                        <input type="number" name="max_uses" value="{{ old('max_uses') }}" placeholder="Leave empty for unlimited"
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        <x-input-error :messages="$errors->get('max_uses')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Expires At</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at') }}" 
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="add_is_active" value="1" checked 
                           class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-800">
                    <label for="add_is_active" class="ml-3 block text-sm font-bold text-slate-900 dark:text-white">Activate this discount code immediately</label>
                </div>

                <div class="flex space-x-4 pt-4 border-t border-slate-100 dark:border-slate-700 mt-6">
                    <button type="button" @click="isAddModalOpen = false" 
                            class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-2xl font-bold transition-colors">Cancel</button>
                    <button type="submit" 
                            class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-lg shadow-indigo-900/20 font-bold transition-colors">Save Discount</button>
                </div>
            </form>
        </div>
    </div>
</template>