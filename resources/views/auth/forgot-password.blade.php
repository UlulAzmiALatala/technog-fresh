<x-auth>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Forgot Password - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <div class="max-w-md mx-auto">
        <h2 class="text-3xl font-bold text-center text-white mb-4 form-gradient-text">Lupa Password</h2>
        <p class="mb-6 text-sm text-center text-white/70">
            Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm bg-green-500/20 text-green-300 border border-green-500/30 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div>
                <x-input-label for="email" value="Email" class="text-white/80"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full justify-center text-base py-3">
                    {{ __('Kirim Link Reset') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-white/70">
            Ingat password Anda?
            <a href="{{ route('login') }}" class="font-bold text-white hover:underline">
                Kembali ke Login
            </a>
        </p>
    </div>
</x-auth>