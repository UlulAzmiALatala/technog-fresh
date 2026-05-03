{{-- Lokasi: resources/views/admin/profile/partials/update-password-form.blade.php --}}
<section>
    <header class="mb-8 border-b border-slate-200/50 dark:border-slate-700/50 pb-6">
        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
            Update Password
        </h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 relative z-10">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Current Password</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                       class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="update_password_password" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">New Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-key text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                           class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs" />
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Confirm Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-check-double text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-200/50 dark:border-slate-700/50">
            <button type="submit" class="px-8 py-3 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-2xl shadow-lg shadow-indigo-500/30 text-xs font-bold uppercase tracking-widest transition-all">
                <i class="fas fa-key mr-2"></i> Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-500">
                    <i class="fas fa-check mr-1"></i> Saved.
                </p>
            @endif
        </div>
    </form>
</section>