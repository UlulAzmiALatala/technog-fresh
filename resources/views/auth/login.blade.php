<x-guest-layout>
    {{-- PERBAIKAN: Seluruh konten form dibungkus dalam div ini untuk membatasi lebarnya --}}
    <div class="max-w-md mx-auto">
        {{-- PERBAIKAN: Judul disesuaikan dengan tema --}}
        <h2 class="text-3xl font-bold text-center text-white mb-6 form-gradient-text">Login</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                {{-- PERBAIKAN: Label diberi warna yang sesuai tema --}}
                <x-input-label for="email" value="Email" class="text-white/80" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" value="Password" class="text-white/80" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Lupa Password -->
            <div class="block mt-4 flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span class="ms-2 text-sm text-white/80">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-white/80 hover:text-white hover:underline" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full justify-center text-base py-3">
                    {{ __('Log In') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-white/70">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-bold text-white hover:underline">Daftar di sini</a>
        </p>
    </div>
</x-guest-layout>

