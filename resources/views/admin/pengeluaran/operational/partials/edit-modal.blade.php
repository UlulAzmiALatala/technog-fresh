{{-- Lokasi: resources/views/admin/pengeluaran/operational/partials/edit-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak 
         class="fixed inset-0 z-[999] overflow-y-auto bg-slate-900/60 backdrop-blur-[30px]"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-white/10 my-8" 
                 @click.away="isEditModalOpen = false">
                
                <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Update Expense Record</h3>
                    <button @click="isEditModalOpen = false" class="text-slate-400 transition-none">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>

                <form :action="`{{ route('admin.pengeluaran.expenses.index') }}/${editData.id}`" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Expense Date</label>
                            <input type="date" name="expense_date" x-model="editData.expense_date" required 
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Amount ($)</label>
                            <input type="number" name="amount" step="0.01" x-model="editData.amount" required 
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Category</label>
                        <div class="flex gap-2">
                            <select name="category_id" x-model="editData.category_id" required 
                                    class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500">
                                <template x-for="cat in categories" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name" :selected="cat.id == editData.category_id"></option>
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
                        <textarea name="description" x-model="editData.description" rows="3" 
                                  class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button type="button" @click="isEditModalOpen = false" 
                                class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none font-bold transition-none">Update Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>