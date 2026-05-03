{{-- Lokasi: resources/views/admin/profile/partials/update-profile-information-form.blade.php --}}
<section>
    <header class="mb-8 border-b border-slate-200/50 dark:border-slate-700/50 pb-6">
        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
            Profile Information
        </h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 font-medium">
            Update your account's profile information and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-8 relative z-10" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Avatar Upload --}}
        <div>
            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-4 font-bold">Profile Photo</label>
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-2xl bg-indigo-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center overflow-hidden shadow-sm">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-black text-indigo-500 dark:text-indigo-400">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-camera text-white text-xl"></i>
                        </div>
                    </div>
                    <input id="avatar" name="avatar" type="file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Change Avatar</p>
                    <p class="text-xs text-slate-400 mt-1">Recommended: Square image, max 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2 text-xs" :messages="$errors->get('avatar')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Name Input --}}
            <div>
                <label for="name" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Full Name</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                           class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white">
                </div>
                <x-input-error class="mt-2 text-xs" :messages="$errors->get('name')" />
            </div>

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white">
                </div>
                <x-input-error class="mt-2 text-xs" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 rounded-lg">
                        <p class="text-xs text-amber-800 dark:text-amber-400 font-medium">
                            Your email address is unverified.
                            <button form="send-verification" class="underline font-bold hover:text-amber-900 dark:hover:text-amber-300 focus:outline-none">
                                Click here to re-send the verification email.
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-bold text-xs text-emerald-600 dark:text-emerald-400">
                                <i class="fas fa-check-circle mr-1"></i> A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-200/50 dark:border-slate-700/50">
            <button type="submit" class="px-8 py-3 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-2xl shadow-lg shadow-indigo-500/30 text-xs font-bold uppercase tracking-widest transition-all">
                <i class="fas fa-save mr-2"></i> Save Profile
            </button>

            @if (session('success') === 'Profile updated successfully.')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-500">
                    <i class="fas fa-check mr-1"></i> Saved.
                </p>
            @endif
        </div>
    </form>
</section>