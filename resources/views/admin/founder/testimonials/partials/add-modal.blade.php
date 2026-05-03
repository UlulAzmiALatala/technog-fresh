<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isAddModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Add New Testimonial</h3>
                <button type="button" @click="isAddModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form action="{{ route('admin.testimonials.store') }}" method="POST" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="modal_form" value="add">

                <div class="grid grid-cols-1 gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Client (User)</label>
                            <select name="user_id" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="">Select a client</option>
                                <template x-for="user in users" :key="user.id">
                                    <option :value="user.id" x-text="user.name" :selected="user.id == '{{ old('user_id') }}'"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Associated Order</label>
                            <select name="order_id" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="">Select an order</option>
                                <template x-for="order in orders" :key="order.id">
                                    <option :value="order.id" x-text="`Order #${order.id} (${getFirstServiceName(order)})`" :selected="order.id == '{{ old('order_id') }}'"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Rating</label>
                        <select name="rating" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            <option value="5" @selected(old('rating', 5) == 5)>⭐⭐⭐⭐⭐ 5 Stars</option>
                            <option value="4" @selected(old('rating') == 4)>⭐⭐⭐⭐ 4 Stars</option>
                            <option value="3" @selected(old('rating') == 3)>⭐⭐⭐ 3 Stars</option>
                            <option value="2" @selected(old('rating') == 2)>⭐⭐ 2 Stars</option>
                            <option value="1" @selected(old('rating') == 1)>⭐ 1 Star</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Review Content</label>
                        <textarea name="content" rows="4" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">{{ old('content') }}</textarea>
                    </div>

                    <label class="flex items-center space-x-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/50 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured') == '1') class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">Feature on Homepage</span>
                    </label>
                </div>

                <div class="flex space-x-4 pt-6">
                    <button type="button" @click="isAddModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-200 font-bold transition-none">Save Testimonial</button>
                </div>
            </form>
        </div>
    </div>
</template>