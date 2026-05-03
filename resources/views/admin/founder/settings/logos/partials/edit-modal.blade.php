<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-lg max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Edit Logo</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form id="edit_logo_form" :action="`{{ url('admin/founder/settings/logos') }}/${editingLogo.id}`" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                @method('PATCH')
                <input type="hidden" name="modal_form" value="edit">
                <input type="hidden" name="id" x-model="editingLogo.id">

                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Logo Type / Placement</label>
                        <select name="name" x-model="editingLogo.name" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            <option value="">Select Placement</option>
                            <option value="Header Light">Header Light (public header)</option>
                            <option value="Footer Light">Footer Light (public footer)</option>
                            <option value="Favicon">Favicon (browser tab)</option>
                        </select>
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Replace File (Optional)</label>
                        <div class="relative w-full h-32 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-900/50">
                            <template x-if="editingLogo.previewUrl"><img :src="editingLogo.previewUrl" class="w-full h-full object-contain p-2"></template>
                            <template x-if="!editingLogo.previewUrl && editingLogo.existingImageUrl"><img :src="editingLogo.existingImageUrl" class="w-full h-full object-contain p-2 opacity-50"></template>
                            <span x-show="!editingLogo.previewUrl" class="absolute text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-widest bg-white/80 dark:bg-slate-800/80 px-4 py-2 rounded-lg backdrop-blur-sm shadow-sm pointer-events-none">Upload New</span>
                            <input type="file" name="logo_file" accept="image/png, image/jpeg, image/svg+xml" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   @change="handleFileChange($event, 'edit')">
                        </div>
                        @error('logo_file') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <label class="flex items-center space-x-3 p-4 border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/50 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" x-model="editingLogo.is_active" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-slate-900">
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest">Set as Active Logo</span>
                    </label>
                </div>

                <div class="flex space-x-4 pt-8">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none">Update Logo</button>
                </div>
            </form>
        </div>
    </div>
</template>