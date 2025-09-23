<x-guest-layout>
    {{-- PERBAIKAN: Seluruh konten form dibungkus dalam div ini untuk membatasi lebarnya --}}
    <div class="max-w-md mx-auto">
        {{-- PERBAIKAN: Judul dan teks disesuaikan dengan tema --}}
        <h2 class="text-3xl font-bold text-center text-white mb-6 form-gradient-text">Atur Ulang Password</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email" class="text-white/80" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" value="Password Baru" class="text-white/80" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" class="text-white/80" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full justify-center text-base py-3">
                    {{ __('Simpan Password Baru') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
