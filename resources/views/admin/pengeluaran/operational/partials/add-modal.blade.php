{{-- Lokasi: resources/views/admin/pengeluaran/operational/partials/add-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak 
         class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        
        {{-- Layer Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[30px] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
             @click="isAddModalOpen = false"></div>

        {{-- Konten Modal --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-3xl max-h-[95vh] overflow-y-auto rounded-[2.5rem] shadow-2xl border border-white/10 my-8 z-10"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-slate-800/95 backdrop-blur-md z-20">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Add New Operational Expense</h3>
                <button @click="isAddModalOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.pengeluaran.expenses.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                {{-- Grid 3 Kolom untuk Date, Amount, dan Type --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Expense Date</label>
                        <input type="date" name="expense_date" x-model="formData.expense_date" required 
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Amount ($)</label>
                        <input type="number" name="amount" step="0.01" x-model="formData.amount" required 
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Payment Type</label>
                        <select name="type" x-model="formData.type" required 
                                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                            <option value="Full">Full Payment</option>
                            <option value="DP">Down Payment (DP)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category</label>
                    <div class="flex gap-2">
                        <select name="category_id" x-model="formData.category_id" required 
                                class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                            <option value="">Select Category</option>
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name"></option>
                            </template>
                        </select>
                        <button type="button" @click="isCategoryModalOpen = true" 
                                class="px-5 bg-indigo-600 text-white rounded-xl font-bold text-xs shadow-md hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-plus mr-1"></i> Baru
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Description</label>
                    <textarea name="description" x-model="formData.description" rows="3" placeholder="e.g. Monthly Server Hosting"
                              class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex space-x-4 pt-4 border-t border-slate-100 dark:border-slate-700 mt-4">
                    <button type="button" @click="isAddModalOpen = false" 
                            class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-2xl font-bold transition-colors">Cancel</button>
                    <button type="submit" 
                            class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl shadow-lg shadow-indigo-900/20 font-bold transition-colors">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</template>