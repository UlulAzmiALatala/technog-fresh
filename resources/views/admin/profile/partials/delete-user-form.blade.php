{{-- Lokasi: resources/views/admin/profile/partials/delete-user-form.blade.php --}}
{{-- PERBAIKAN: Menambahkan x-init dengan watch untuk mengunci body scroll (Anti-Bocor) --}}
<section class="space-y-6 relative z-10" 
         x-data="{ confirmingUserDeletion: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }"
         x-init="$watch('confirmingUserDeletion', val => document.body.style.overflow = val ? 'hidden' : '')">
         
    <header>
        <h2 class="text-xl font-black text-rose-600 dark:text-rose-400 uppercase tracking-tight flex items-center">
            <i class="fas fa-exclamation-triangle mr-3"></i> Delete Account
        </h2>
        <p class="mt-2 text-sm text-slate-700 dark:text-slate-300 font-medium">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <button @click="confirmingUserDeletion = true" class="px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl shadow-lg shadow-rose-500/30 text-xs font-bold uppercase tracking-widest transition-all">
        Delete Account
    </button>

    {{-- MODAL HAPUS AKUN (Murni Alpine, Anti Bocor) --}}
    <template x-teleport="body">
        <div x-show="confirmingUserDeletion" x-cloak class="fixed inset-0 z-[1000] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-[10px]" @click="confirmingUserDeletion = false"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

            <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-10 text-center shadow-2xl border border-white/10"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                 
                <div class="w-20 h-20 bg-rose-50 dark:bg-rose-900/30 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shrink-0">
                    <i class="fas fa-user-times"></i>
                </div>

                <h3 class="text-2xl text-slate-900 dark:text-white font-black tracking-tighter uppercase">Are you sure?</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-3 text-sm font-medium leading-relaxed">
                    Once your account is deleted, all data will be permanently removed. Please enter your password to confirm.
                </p>

                <form method="post" action="{{ route('admin.profile.destroy') }}" class="mt-8 text-left">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="password" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Password</label>
                        <input id="password" name="password" type="password" required placeholder="Enter your password"
                               class="w-full py-3 px-4 rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-sm font-medium focus:ring-rose-500 focus:border-rose-500 transition-all text-slate-900 dark:text-white">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs text-rose-500" />
                    </div>

                    <div class="mt-8 flex space-x-4">
                        <button type="button" @click="confirmingUserDeletion = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold uppercase tracking-widest transition-none">Cancel</button>
                        <button type="submit" class="flex-1 py-4 bg-rose-600 text-white rounded-2xl font-bold uppercase tracking-widest transition-none shadow-lg shadow-rose-500/30">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</section>