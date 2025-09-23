{{-- Lokasi: resources/views/founder/users/edit.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Peran Pengguna') }}
            </h2>
            <a href="{{ route('admin.founder.users.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Daftar Pengguna
            </a>
        </div>
    </x-slot>

    <div class="mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Profil Pengguna --}}
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="h-24 w-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold mx-auto">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Edit Peran --}}
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Ubah Peran</h3>
                        <form action="{{ route('admin.founder.users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="max-w-md">
                                <label for="role" class="block font-medium text-sm text-gray-700">Peran (Role)</label>
                                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-xs text-gray-500">Mengubah peran akan mengubah hak akses pengguna di seluruh sistem.</p>
                            </div>

                            <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.founder.users.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 mr-6">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
