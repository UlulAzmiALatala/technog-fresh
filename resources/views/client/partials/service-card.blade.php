{{-- Lokasi: resources/views/client/partials/service-card.blade.php --}}

@php
    $packageName = $service->package_plan ?? '';
    $contentBlockStyle = '';

    // Logika pewarnaan untuk blok konten bawah
    switch ($packageName) {
        case 'Silver Plan':
            $contentBlockStyle = 'background-color:#F2F2F2; color:#000;';
            break;
        case 'Gold Plan':
            $contentBlockStyle = 'background-color:#FFD700; color:#000;';
            break;
        case 'Platinum Sphere':
            $contentBlockStyle = 'background-color:#808080; color:#FFF;';
            break;
        case 'Diamond Class':
            $contentBlockStyle = 'background-color:#305496; color:#FFF;';
            break;
        case 'Ultima Partnership':
            $contentBlockStyle = 'background-color:#000; color:#FFF;';
            break;
        case 'Custom Engagement':
            $contentBlockStyle = 'background-color:#1E4174; color:#DDA94B;';
            break;
        default:
            // Fallback ke background gelap jika tidak ada paket, sesuai screenshot
            $contentBlockStyle = 'background-color:#111827; color:#FFF;'; // bg-gray-900
            break;
    }
@endphp

<div class="bg-white rounded-2xl shadow-lg flex flex-col group transition-all duration-300 ease-in-out hover:shadow-2xl overflow-hidden">
    
    {{-- Bagian Atas: Hanya Gambar & Overlay --}}
    <div class="relative">
        <a href="{{ route('client.services.show', $service->id) }}" class="block aspect-w-16 aspect-h-9">
            {{-- [DIHAPUS] class 'group-hover:scale-105' dihapus dari sini --}}
            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x400/CCD3D8/334155?text=TechnoG' }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-full object-cover transition-transform duration-300">
        </a>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        <div class="absolute top-3 right-3">
            <span class="bg-black/80 text-white text-sm font-bold px-3 py-1.5 rounded-lg backdrop-blur-sm">
                Rp {{ number_format($service->price, 0, ',', '.') }}
            </span>
        </div>

        <div class="absolute bottom-3 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-lg">
                <a href="{{ route('client.services.show', $service->id) }}">{{ $service->name }}</a>
            </h3>
            <p class="text-gray-200 text-xs drop-shadow-md">
                Estimasi {{ $service->estimated_duration }} {{ $service->duration_unit }}
            </p>
        </div>
    </div>
    
    {{-- Bagian Bawah: Blok Konten Berwarna --}}
    <div style="{{ $contentBlockStyle }}" class="p-6 flex-grow flex flex-col">
        <ul class="space-y-2 text-sm leading-relaxed flex-grow mb-6">
            @if($service->features)
                @foreach(explode("\n", $service->features) as $index => $feature)
                    @if(trim($feature) && $index < 4)
                        <li class="flex items-start opacity-90">
                            <svg class="flex-shrink-0 h-5 w-5 text-green-400 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ trim(str_replace('-', '', $feature)) }}</span>
                        </li>
                    @endif
                @endforeach
            @else
                <li class="italic opacity-60">Detail fitur belum tersedia.</li>
            @endif
        </ul>

        {{-- Tombol --}}
        <div class="mt-auto flex items-center space-x-3">
            <a href="{{ route('client.services.show', $service->id) }}" 
               class="w-full text-center px-4 py-2.5 rounded-lg text-sm font-semibold transition border hover:bg-white/10 text-white border-white/50">
                Detail
            </a>
            
            <form x-data="{ loading: false }" action="{{ route('client.services.order', $service->id) }}" method="POST" class="w-full" @submit="loading = true">
                @csrf
                <button type="submit" :disabled="loading" :class="{'opacity-60 cursor-not-allowed': loading}" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-semibold transition bg-indigo-600 text-white hover:bg-indigo-500">
                    <span x-show="!loading">Pesan</span>
                    <span x-show="loading" class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>...</span>
                </button>
            </form>
        </div>
    </div>
</div>