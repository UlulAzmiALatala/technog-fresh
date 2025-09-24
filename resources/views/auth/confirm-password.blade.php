<x-auth>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Confirm Password - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <div class="max-w-md mx-auto">
        <h2 class="text-3xl font-bold text-center text-white mb-4 form-gradient-text">Konfirmasi Password</h2>
        <p class="mb-6 text-sm text-center text-white/70">
            Ini adalah area aman aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-input-label for="password" value="Password" class="text-white/80"/>
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full justify-center text-base py-3">
                    {{ __('Konfirmasi') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-auth>