<template x-teleport="body">
    <div x-show="isEditModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isEditModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Change User Role</h3>
                <button type="button" @click="isEditModalOpen = false" class="text-slate-400 transition-none hover:text-rose-500"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form :action="`{{ url('admin/founder/users') }}/${editingUser.id}`" method="POST" class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                @csrf
                @method('PUT')
                <input type="hidden" name="modal_form" value="edit">
                <input type="hidden" name="id" x-model="editingUser.id">

                <div class="space-y-6">
                    {{-- Info User Read-only --}}
                    <div class="flex items-center gap-4 p-4 bg-indigo-50/50 dark:bg-indigo-900/20 border border-indigo-100/50 dark:border-indigo-800/50 rounded-2xl">
                        <template x-if="editingUser.avatarUrl">
                            <img class="h-14 w-14 rounded-xl object-cover shadow-sm" :src="editingUser.avatarUrl" alt="Avatar">
                        </template>
                        <template x-if="!editingUser.avatarUrl">
                            <div class="h-14 w-14 rounded-xl bg-indigo-100 dark:bg-indigo-800/50 flex items-center justify-center shadow-sm">
                                <span class="text-xl font-black text-indigo-600 dark:text-indigo-300" x-text="editingUser.name ? editingUser.name.charAt(0) : 'U'"></span>
                            </div>
                        </template>
                        <div>
                            <span class="text-sm text-indigo-900 dark:text-indigo-100 font-bold block" x-text="editingUser.name"></span>
                            <span class="text-[10px] text-indigo-500 dark:text-indigo-300 font-bold uppercase tracking-widest block mt-1" x-text="editingUser.email"></span>
                        </div>
                    </div>

                    {{-- Edit Role --}}
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Assign New Role</label>
                        <select name="role" x-model="editingUser.roleName" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-3 font-bold uppercase tracking-widest leading-relaxed">Warning: Changing a role grants or revokes global system access permissions immediately.</p>
                        @error('role') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex space-x-4 pt-8">
                    <button type="button" @click="isEditModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none uppercase tracking-widest">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold transition-none uppercase tracking-widest">Update Role</button>
                </div>
            </form>
        </div>
    </div>
</template>