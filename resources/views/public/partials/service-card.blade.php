{{-- Lokasi: resources/views/public/partials/service-card.blade.php --}}

@php
    $packageName = $service->package_plan ?? '';
    $contentBlockStyle = '';
    $priceBadgeStyle = ''; // Variabel baru untuk style badge harga
    $isDark = false;

    // Logika pewarnaan untuk blok konten bawah DAN badge harga
    switch ($packageName) {
        case 'Silver Plan':
            $contentBlockStyle = 'background-color:#F2F2F2; color:#000;';
            $priceBadgeStyle = 'background-color:#F2F2F2; color:#000;';
            break;
        case 'Gold Plan':
            $contentBlockStyle = 'background-color:#FFD700; color:#000;';
            $priceBadgeStyle = 'background-color:#FFD700; color:#000;';
            break;
        case 'Platinum Sphere':
            $contentBlockStyle = 'background-color:#808080; color:#FFF;';
            $priceBadgeStyle = 'background-color:#808080; color:#FFF;';
            $isDark = true;
            break;
        case 'Diamond Class':
            $contentBlockStyle = 'background-color:#305496; color:#FFF;';
            $priceBadgeStyle = 'background-color:#305496; color:#FFF;';
            $isDark = true;
            break;
        case 'Ultima Partnership':
            $contentBlockStyle = 'background-color:#000; color:#FFF;';
            $priceBadgeStyle = 'background-color:#000; color:#FFF;';
            $isDark = true;
            break;
        case 'Custom Engagement':
            $contentBlockStyle = 'background-color:#1E4174; color:#DDA94B;';
            $priceBadgeStyle = 'background-color:#1E4174; color:#DDA94B;';
            $isDark = true;
            break;
        default:
            // Fallback ke background gelap jika tidak ada paket
            $contentBlockStyle = 'background-color:#111827; color:#FFF;'; // bg-gray-900
            $priceBadgeStyle = 'background-color:rgba(0,0,0,0.8); color:#FFF;'; // Fallback badge hitam transparan
            $isDark = true;
            break;
    }
@endphp

<div class="bg-white rounded-2xl shadow-lg flex flex-col group transition-all duration-300 ease-in-out hover:shadow-2xl overflow-hidden">
    
    {{-- Bagian Atas: Hanya Gambar & Overlay --}}
    <div class="relative">
        <a href="{{ route('login') }}" class="block aspect-w-16 aspect-h-9">
            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x400/CCD3D8/334155?text=TechnoG' }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-full object-cover transition-transform duration-300">
        </a>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        {{-- [PENYESUAIAN] Badge harga sekarang menggunakan style dinamis --}}
        <div class="absolute top-3 right-3">
            <span style="{{ $priceBadgeStyle }}" class="text-sm font-bold px-3 py-1.5 rounded-lg shadow-lg">
                Rp {{ number_format($service->price, 0, ',', '.') }}
            </span>
        </div>

        <div class="absolute bottom-3 left-4">
            <h3 class="text-white font-bold text-lg drop-shadow-lg">
                <a href="{{ route('login') }}">{{ $service->name }}</a>
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

        <div class="mt-auto flex items-center space-x-3">
            <a href="{{ route('login') }}" 
               class="w-full text-center px-4 py-2.5 rounded-lg text-sm font-semibold transition
                      {{ $isDark 
                          ? 'bg-white/10 border border-white/20 text-white hover:bg-white/20' 
                          : 'bg-white border border-gray-300 text-gray-800 hover:bg-gray-50' }}">
                Detail
            </a>
            
            <a href="{{ route('login') }}"
               class="w-full text-center px-4 py-2.5 rounded-lg text-sm font-semibold transition border border-transparent bg-indigo-600 text-white hover:bg-indigo-500">
               Pesan
            </a>
        </div>
    </div>
</div>

