<x-auth>
    <x-slot name="title">
        Verifikasi OTP - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <div class="max-w-md mx-auto text-center">
        <h2 class="text-3xl font-bold text-white mb-4 form-gradient-text">Verifikasi Email Anda</h2>
        
        <div class="mb-6 text-sm text-white/80">
            Kami telah mengirimkan 6 digit kode OTP ke email <span class="font-bold text-white">{{ auth()->user()->email }}</span>.
            Silakan masukkan kode tersebut di bawah ini.
        </div>

        <!-- Form OTP menggunakan Alpine.js -->
        <form method="POST" action="{{ route('verification.verify.otp') }}">
            @csrf
            
            <div x-data="otpComponent()" class="flex justify-center gap-2 mb-6">
                <template x-for="(digit, index) in 6" :key="index">
                    <input type="text"
                           :id="'code-'+index"
                           x-ref="'input_' + index"
                           x-model="otp[index]"
                           @input="handleInput(index)"
                           @keydown.backspace="handleBackspace(index, $event)"
                           @paste="handlePaste($event)"
                           class="w-12 h-14 text-center text-2xl font-bold text-white bg-white/10 border border-white/20 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none focus:bg-white/20 transition-all backdrop-blur-md shadow-sm"
                           maxlength="1"
                           autocomplete="off">
                </template>
                <!-- Hidden input untuk disubmit ke backend -->
                <input type="hidden" name="otp_code" :value="otp.join('')">
            </div>

            <x-input-error :messages="$errors->get('otp_code')" class="mb-4" />

            <div class="mt-6 flex flex-col gap-3 items-center justify-between">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Verifikasi Akun') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 flex items-center justify-between border-t border-white/20 pt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-sm text-indigo-400 hover:text-indigo-300 underline focus:outline-none">
                    Kirim Ulang OTP
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-white/70 hover:text-white underline focus:outline-none">
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Alpine JS Logic untuk OTP -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('otpComponent', () => ({
                otp: ['', '', '', '', '', ''],
                
                init() {
                    // Auto focus kotak pertama saat halaman dimuat
                    setTimeout(() => { this.$refs.input_0.focus(); }, 100);
                },

                handleInput(index) {
                    // Hanya izinkan angka
                    this.otp[index] = this.otp[index].replace(/[^0-9]/g, '');
                    
                    // Pindah ke kotak selanjutnya jika sudah diisi
                    if (this.otp[index] !== '' && index < 5) {
                        this.$refs['input_' + (index + 1)].focus();
                    }
                },

                handleBackspace(index, event) {
                    // Mundur ke kotak sebelumnya jika kotak saat ini kosong dan menekan backspace
                    if (this.otp[index] === '' && index > 0) {
                        this.$refs['input_' + (index - 1)].focus();
                    }
                },

                handlePaste(event) {
                    const paste = (event.clipboardData || window.clipboardData).getData('text');
                    const cleanPaste = paste.replace(/[^0-9]/g, '').slice(0, 6);
                    
                    if (cleanPaste) {
                        this.otp = cleanPaste.split('').concat(Array(6 - cleanPaste.length).fill(''));
                        // Fokus ke kotak kosong terakhir atau kotak paling akhir
                        const focusIndex = Math.min(cleanPaste.length, 5);
                        this.$refs['input_' + focusIndex].focus();
                    }
                    event.preventDefault();
                }
            }));
        });
    </script>
</x-auth>