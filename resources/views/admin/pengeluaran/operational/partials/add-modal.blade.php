{{-- Lokasi: resources/views/admin/pengeluaran/operational/partials/add-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isAddModalOpen" 
         x-cloak 
         class="fixed inset-0 z-[9999] w-screen h-screen bg-slate-900/60 backdrop-blur-[30px] overflow-y-auto"
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-white/10 my-8" 
                 @click.away="isAddModalOpen = false">
                
                <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Add New Operational Expense</h3>
                    <button @click="isAddModalOpen = false" class="text-slate-400 transition-none">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>

                <form action="{{ route('admin.pengeluaran.expenses.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Expense Date</label>
                            <input type="date" name="expense_date" x-model="formData.expense_date" required 
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Amount ($)</label>
                            <input type="number" name="amount" step="0.01" x-model="formData.amount" required 
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category</label>
                        <div class="flex gap-2">
                            <select name="category_id" x-model="formData.category_id" required 
                                    class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                                <option value="">Select Category</option>
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                            <button type="button" @click="isCategoryModalOpen = true" 
                                    class="px-5 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-xl transition-none">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Description</label>
                        <textarea name="description" x-model="formData.description" rows="3" 
                                  class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button type="button" @click="isAddModalOpen = false" 
                                class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl shadow-lg font-bold transition-none">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>