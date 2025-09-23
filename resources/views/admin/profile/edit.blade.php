{{-- Lokasi: resources/views/profile/edit.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        {{ __('Profil Pengguna') }}
    </x-slot>

    <div class="mt-4 space-y-6">
        {{-- Kartu untuk Update Informasi Profil --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Kartu untuk Update Password --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-password-form')
            </div>
        </div>

        {{-- Kartu untuk Hapus Akun --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('admin.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-admin-layout>
