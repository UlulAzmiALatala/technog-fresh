<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil, alamat email, dan data pendukung akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('client.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- PERBAIKAN: Input Avatar diberi preview interaktif --}}
        <div x-data="{ avatarPreview: {{ json_encode($user->avatar ? asset('storage/' . $user->avatar) : null) }} }">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            <div class="mt-2 flex items-center gap-x-4">
                 <img x-show="avatarPreview" :src="avatarPreview" alt="Avatar Preview" class="h-16 w-16 rounded-full object-cover border bg-gray-50">
                 <div x-show="!avatarPreview" class="h-16 w-16 rounded-full flex items-center justify-center bg-gray-100 text-gray-400">
                     <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                 </div>
                 <input @change="avatarPreview = URL.createObjectURL($event.target.files[0])" type="file" name="avatar" id="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            {{-- ... (kode verifikasi email Anda tetap di sini) ... --}}
        </div>
        
        {{-- Detail Perusahaan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t">
            <div>
                <x-input-label for="company_name" :value="__('Nama Perusahaan (Opsional)')" />
                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $user->company_name)" autocomplete="organization" />
                <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
            </div>

            <div>
                <x-input-label for="position" :value="__('Jabatan (Opsional)')" />
                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $user->position)" autocomplete="organization-title" />
                <x-input-error class="mt-2" :messages="$errors->get('position')" />
            </div>
        </div>

        {{-- Detail Identitas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div>
                <x-input-label for="id_card_type" :value="__('Tipe Identitas (Opsional)')" />
                <select name="id_card_type" id="id_card_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Pilih Tipe</option>
                    <option value="KTP" @selected(old('id_card_type', $user->id_card_type) == 'KTP')>KTP</option>
                    <option value="Passport" @selected(old('id_card_type', $user->id_card_type) == 'Passport')>Passport</option>
                    <option value="SIM" @selected(old('id_card_type', $user->id_card_type) == 'SIM')>SIM</option>
                </select>
             </div>
             <div>
                <x-input-label for="id_card_number" :value="__('Nomor Identitas (Opsional)')" />
                <x-text-input id="id_card_number" name="id_card_number" type="text" class="mt-1 block w-full" :value="old('id_card_number', $user->id_card_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('id_card_number')" />
            </div>
        </div>

        {{-- Foto Kartu Identitas --}}
        <div x-data="{ imagePreview: {{ json_encode($user->id_card_image ? asset('storage/' . $user->id_card_image) : null) }} }">
            <x-input-label for="id_card_image" :value="__('Foto Kartu Identitas (Opsional)')" />
            <div class="mt-2 flex items-center space-x-4">
                 <img x-show="imagePreview" :src="imagePreview" alt="ID Card Preview" class="h-20 w-32 object-cover rounded-md border bg-gray-50">
                 <div x-show="!imagePreview" class="h-20 w-32 flex items-center justify-center bg-gray-100 rounded-md border text-gray-400 text-xs text-center p-2">
                     Tidak Ada Gambar
                 </div>
                 <input @change="imagePreview = URL.createObjectURL($event.target.files[0])" type="file" name="id_card_image" id="id_card_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
             <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
            <x-input-error class="mt-2" :messages="$errors->get('id_card_image')" />
        </div>


        <div class="flex items-center gap-4 pt-4 border-t">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

