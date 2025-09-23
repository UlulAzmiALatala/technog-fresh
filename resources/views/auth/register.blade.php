<x-guest-layout>
    {{-- 
      Membuat form menjadi satu halaman dengan layout 2 kolom di layar medium ke atas.
      Menambahkan Alpine.js untuk validasi nomor identitas secara real-time.
    --}}
    <div x-data="{
        id_card_type: '{{ old('id_card_type', '') }}',
        id_card_number: '{{ old('id_card_number', '') }}',
        id_error: '',
        validateIdNumber() {
            this.id_card_number = this.id_card_number.replace(/\D/g, ''); // Hanya izinkan angka
            if (this.id_card_type === 'KTP') {
                if (this.id_card_number.length > 16) {
                    this.id_card_number = this.id_card_number.slice(0, 16); // Batasi 16 digit
                }
                if (this.id_card_number.length > 0 && this.id_card_number.length < 16) {
                    this.id_error = 'Nomor KTP harus 16 digit.';
                } else {
                    this.id_error = '';
                }
            } else if (this.id_card_type === 'NPWP') {
                 if (this.id_card_number.length > 16) {
                    this.id_card_number = this.id_card_number.slice(0, 16); // Batasi 16 digit
                }
                if (this.id_card_number.length > 0 && this.id_card_number.length < 15) {
                    this.id_error = 'Nomor NPWP minimal 15 digit.';
                } else {
                    this.id_error = '';
                }
            } else {
                this.id_error = '';
            }
        }
    }" x-init="validateIdNumber()">

        <h2 class="text-2xl font-bold text-center text-white mb-6">Daftar Akun Baru</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Kolom Kiri: Informasi Akun --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-white/20 pb-2">1. Informasi Akun</h3>
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="text-white/80"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="Email" class="text-white/80"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" class="text-white/80"/>
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-white/80"/>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                {{-- Kolom Kanan: Informasi Tambahan --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-white/20 pb-2">2. Informasi Tambahan (Opsional)</h3>

                    <!-- Company Name -->
                    <div>
                        <x-input-label for="company_name" value="Nama Perusahaan" class="text-white/80"/>
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                    </div>

                    <!-- Position -->
                    <div>
                        <x-input-label for="position" value="Jabatan" class="text-white/80"/>
                        <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" />
                    </div>
                    
                    <!-- ID Card Type -->
                    <div>
                        <x-input-label for="id_card_type" value="Tipe Identitas" class="text-white/80"/>
                        <select name="id_card_type" id="id_card_type" class="block mt-1 w-full glass-card" 
                                @change="id_card_type = $event.target.value; validateIdNumber()">
                            <option value="" @selected(old('id_card_type') == '')>Pilih Tipe</option>
                            <option value="KTP" @selected(old('id_card_type') == 'KTP')>KTP</option>
                            <option value="Passport" @selected(old('id_card_type') == 'Passport')>Passport</option>
                            <option value="NPWP" @selected(old('id_card_type') == 'NPWP')>NPWP</option>
                        </select>
                    </div>

                    <!-- ID Card Number -->
                    <div>
                        <x-input-label for="id_card_number" value="Nomor Identitas" class="text-white/80"/>
                        <x-text-input x-model="id_card_number" @input="validateIdNumber()" id="id_card_number" class="block mt-1 w-full" type="text" name="id_card_number" />
                        <div x-show="id_error" class="text-red-400 text-sm mt-2" x-text="id_error"></div>
                    </div>

                    <p class="text-center text-xs text-white/60 pt-4">Anda dapat melengkapi atau mengubah informasi ini nanti di halaman profil Anda.</p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-8">
                <x-primary-button class="w-full justify-center text-base py-3">
                    {{ __('Daftar Sekarang') }}
                </x-primary-button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-white/70">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-white hover:underline">
                Login
            </a>
        </p>
    </div>
</x-guest-layout>
