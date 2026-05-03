<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-lg max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Social Link</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/founder/settings/social-links') }}/${editingLink.id}`" method="POST" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                @method('PATCH')
                <input type="hidden" name="modal_form" value="edit">

                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Platform Name</label>
                        <select name="name" x-model="editingLink.name" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            <option value="">Select Platform</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Twitter">Twitter</option>
                            <option value="Instagram">Instagram</option>
                            <option value="LinkedIn">LinkedIn</option>
                            <option value="YouTube">YouTube</option>
                            <option value="GitHub">GitHub</option>
                            <option value="TikTok">TikTok</option>
                            <option value="Website">Website (Others)</option>
                        </select>
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Full URL</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i :class="getIconClass(editingLink.name)" class="text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                            </div>
                            <input type="url" name="url" x-model="editingLink.url" required placeholder="https://"
                                   class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-normal focus:ring-indigo-500 text-slate-900 dark:text-white outline-none">
                        </div>
                        @error('url') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Sort Order (Optional)</label>
                        <input type="number" name="sort_order" x-model="editingLink.sort_order" placeholder="0"
                               class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        @error('sort_order') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex space-x-4 pt-8">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none">Update Link</button>
                </div>
            </form>
        </div>
    </div>
</template>