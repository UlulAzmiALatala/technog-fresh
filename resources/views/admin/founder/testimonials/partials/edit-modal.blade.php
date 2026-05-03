<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Testimonial</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/testimonials') }}/${editItem.id}`" method="POST" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                @method('PUT')
                <input type="hidden" name="modal_form" value="edit">

                <div class="grid grid-cols-1 gap-6">
                    <div class="p-4 bg-indigo-50/50 dark:bg-indigo-900/20 border border-indigo-100/50 dark:border-indigo-800/50 rounded-xl space-y-3">
                        <div>
                            <span class="text-[10px] text-indigo-400 uppercase tracking-widest font-bold block">Client Name:</span>
                            <span class="text-sm text-indigo-600 dark:text-indigo-400 mt-1 font-bold block" x-text="editItem.user.name"></span>
                        </div>
                        <div>
                            <span class="text-[10px] text-indigo-400 uppercase tracking-widest font-bold block">Associated Order:</span>
                            <span class="text-sm text-indigo-600 dark:text-indigo-400 mt-1 font-bold block" x-text="`Order #${editItem.order.id} (${getFirstServiceName(editItem.order)})`"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Rating</label>
                        <select name="rating" x-model="editItem.rating" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            <option value="5">⭐⭐⭐⭐⭐ 5 Stars</option>
                            <option value="4">⭐⭐⭐⭐ 4 Stars</option>
                            <option value="3">⭐⭐⭐ 3 Stars</option>
                            <option value="2">⭐⭐ 2 Stars</option>
                            <option value="1">⭐ 1 Star</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Review Content</label>
                        <textarea name="content" x-model="editItem.content" rows="4" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>

                    <label class="flex items-center space-x-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/50 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" x-model="editItem.is_featured" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">Feature on Homepage</span>
                    </label>
                </div>

                <div class="flex space-x-4 pt-6">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-200 font-bold transition-none">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</template>