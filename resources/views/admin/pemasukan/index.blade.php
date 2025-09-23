{{-- Lokasi: resources/views/pemasukan/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Layanan') }}
            </h2>
            <a href="{{ route('admin.pemasukan.services.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Tambah Layanan Baru
            </a>
        </div>
    </x-slot>

    <div class="mt-4">
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
            <form action="{{ route('admin.pemasukan.services.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="search" class="sr-only">Cari</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </div>
                            <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Cari berdasarkan nama layanan..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div>
                        <label for="package_plan" class="sr-only">Filter Paket</label>
                        <select id="package_plan" name="package_plan" class="block w-full rounded-md border-gray-300" onchange="this.form.submit()">
                            <option value="">Semua Paket</option>
                            <option value="Silver Plan" @selected(request('package_plan') == 'Silver Plan')>Silver Plan</option>
                            <option value="Gold Plan" @selected(request('package_plan') == 'Gold Plan')>Gold Plan</option>
                            <option value="Platinum Sphere" @selected(request('package_plan') == 'Platinum Sphere')>Platinum Sphere</option>
                            <option value="Diamond Class" @selected(request('package_plan') == 'Diamond Class')>Diamond Class</option>
                            <option value="Ultima Partnership" @selected(request('package_plan') == 'Ultima Partnership')>Ultima Partnership</option>
                            <option value="Custom Engagement" @selected(request('package_plan') == 'Custom Engagement')>Custom Engagement</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Layanan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paket
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($services as $service)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No%20Image' }}" alt="{{ $service->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $service->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @switch($service->package_plan)
                                                @case('Diamond Class') bg-blue-100 text-blue-800 @break
                                                @case('Platinum Sphere') bg-slate-200 text-slate-800 @break
                                                @case('Gold Plan') bg-yellow-100 text-yellow-800 @break
                                                @case('Silver Plan') bg-gray-200 text-gray-800 @break
                                                @case('Ultima Partnership') bg-red-100 text-red-800 @break
                                                @case('Custom Engagement') bg-teal-100 text-teal-800 @break
                                                @default bg-gray-100 text-gray-800 @break
                                            @endswitch
                                        ">
                                            {{ $service->package_plan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm text-gray-900">$ {{ number_format($service->price, 2, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.pemasukan.services.edit', $service->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        {{-- PERBAIKAN: Menambahkan tombol hapus --}}
                                        <form class="inline-block ml-2" action="{{ route('admin.pemasukan.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Tidak ada layanan yang cocok dengan filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                 <div class="mt-6">
                    {{ $services->links() }}
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>

