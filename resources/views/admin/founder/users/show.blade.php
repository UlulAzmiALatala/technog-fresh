{{-- Lokasi: resources/views/founder/users/show.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pengguna: <span class="font-bold">{{ $user->name }}</span>
            </h2>
            <a href="{{ route('admin.founder.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        {{-- Kolom Kiri: Info Profil Utama --}}
                        <div class="md:col-span-1 flex flex-col items-center text-center">
                            @if ($user->avatar)
                                <img class="h-32 w-32 rounded-full object-cover mb-4" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                    <span class="text-5xl font-bold text-gray-600">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-md text-gray-500">{{ $user->email }}</p>
                            <span class="mt-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                {{ $user->roles->pluck('name')->first() ?? 'N/A' }}
                            </span>
                             <p class="text-sm text-gray-400 mt-4">Bergabung pada {{ $user->created_at->format('d F Y') }}</p>
                        </div>

                        {{-- Kolom Kanan: Info Detail --}}
                        <div class="md:col-span-2 space-y-6">
                            {{-- Informasi Perusahaan --}}
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Informasi Perusahaan</h4>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Nama Perusahaan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->company_name ?? '-' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->position ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            {{-- Informasi Identitas --}}
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Informasi Identitas</h4>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Tipe Identitas</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->id_card_type ?? '-' }}</dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">Nomor Identitas</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->id_card_number ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>

                             {{-- Foto Kartu Identitas --}}
                             <div>
                                <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">Foto Kartu Identitas</h4>
                                @if ($user->id_card_image)
                                    <a href="{{ asset('storage/' . $user->id_card_image) }}" target="_blank" rel="noopener noreferrer" class="block">
                                        <img src="{{ asset('storage/' . $user->id_card_image) }}" alt="Foto Identitas" class="mt-2 rounded-lg border max-h-60 hover:opacity-80 transition-opacity">
                                    </a>
                                     <p class="text-xs text-gray-500 mt-2">Klik gambar untuk melihat ukuran penuh.</p>
                                @else
                                    <div class="mt-2 p-4 text-center border-2 border-dashed rounded-lg">
                                        <p class="text-sm text-gray-500">Pengguna belum mengunggah foto identitas.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
