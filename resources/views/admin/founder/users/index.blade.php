{{-- Lokasi: resources/views/founder/users/index.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="mt-4">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
         @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Fitur Pencarian & Filter --}}
        <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
            <form action="{{ route('admin.founder.users.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Kolom Pencarian --}}
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Cari</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                            <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari berdasarkan nama atau email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    {{-- Filter Peran --}}
                    <div>
                        <label for="role" class="sr-only">Filter berdasarkan peran</label>
                        <select id="role" name="role" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                            <option value="">Semua Peran</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(request('role') == $role->name)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- Grid Kartu Pengguna --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($users as $user)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col transition-transform duration-300 hover:-translate-y-1">
                    {{-- Bagian Atas Kartu (Profil) --}}
                    <div class="p-6 flex-grow">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if ($user->avatar)
                                    <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-lg font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                        
                        {{-- Info Tambahan --}}
                        <div class="flex justify-between items-center text-xs text-gray-500">
                             <span class="px-3 py-1 inline-flex leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $user->roles->pluck('name')->first() ?? 'N/A' }}
                            </span>
                            <span>Bergabung: {{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    {{-- Bagian Bawah Kartu (Aksi) --}}
                    <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-2">
                        <a href="{{ route('admin.founder.users.show', $user->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                            Lihat Detail
                        </a>

                        <a href="{{ route('admin.founder.users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Edit Peran
                        </a>
                        
                        <form action="{{ route('admin.founder.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-10 text-center">
                        <p class="text-gray-500">Tidak ada pengguna yang cocok dengan kriteria pencarian.</p>
                        <a href="{{ route('admin.founder.users.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-semibold">Reset Filter</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>
