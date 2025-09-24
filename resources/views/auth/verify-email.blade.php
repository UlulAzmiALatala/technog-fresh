<x-auth>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Verifikasi Email - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <div class="max-w-md mx-auto text-center">
        <h2 class="text-2xl font-bold text-white mb-4 form-gradient-text">Verifikasi Email Anda</h2>
        
        <div class="mb-4 text-sm text-white/80">
            {{ __('Terima kasih telah mendaftar! Sebelum melanjutkan, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm bg-green-500/20 text-green-300 border border-green-500/30 p-3 rounded-lg">
                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </div>
        @endif

        <div class="mt-6 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-white/70 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-auth>