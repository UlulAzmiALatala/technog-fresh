@php
    $packageName = $service->package_plan ?? '';
    $contentBlockStyle = '';
    $featureListClass = '';
    $priceTagBgClass = 'bg-black/80'; // Default background harga

    // ======================================================================
    // PERBAIKAN FINAL: Menambahkan variabel dinamis untuk background harga
    // ======================================================================
    switch ($packageName) {
        case 'Silver Plan':
            $contentBlockStyle = 'background: radial-gradient(circle at 50% 0%, #e5e7eb, #9ca3af); border-top: 1px solid rgba(255, 255, 255, 0.2);';
            $featureListClass = 'text-gray-800';
            $priceTagBgClass = 'bg-slate-800/80';
            break;
        case 'Gold Plan':
            $contentBlockStyle = 'background: radial-gradient(circle at 50% 0%, #facc15, #b45309); border-top: 1px solid rgba(255, 255, 255, 0.2);';
            $featureListClass = 'text-white';
            $priceTagBgClass = 'bg-amber-900/80';
            break;
        case 'Platinum Sphere':
            $contentBlockStyle = 'background: radial-gradient(circle at 50% 0%, #d1d5db, #4b5563); border-top: 1px solid rgba(255, 255, 255, 0.1);';
            $featureListClass = 'text-white';
            $priceTagBgClass = 'bg-slate-800/80';
            break;
        case 'Diamond Class':
            $contentBlockStyle = 'background: radial-gradient(circle at 50% -20%, #3b82f6, #1e3a8a); border-top: 1px solid rgba(255, 255, 255, 0.1);';
            $featureListClass = 'text-white';
            $priceTagBgClass = 'bg-blue-900/80';
            break;
        case 'Ultima Partnership':
            $contentBlockStyle = 'background: radial-gradient(circle at 50% 0%, #4b5563, #111827); border-top: 1px solid rgba(255, 255, 255, 0.1);';
            $featureListClass = 'text-white';
            $priceTagBgClass = 'bg-gray-900/80';
            break;
        case 'Custom Engagement':
            $contentBlockStyle = 'background-color:#1E4174; border-top: 1px solid rgba(255, 255, 255, 0.1);';
            $featureListClass = 'text-yellow-300';
            $priceTagBgClass = 'bg-cyan-900/80';
            break;
        default:
            $contentBlockStyle = 'background-color:#111827;';
            $featureListClass = 'text-white';
            break;
    }
@endphp

<div class="bg-white rounded-2xl shadow-lg flex flex-col group transition-all duration-300 ease-in-out hover:shadow-2xl overflow-hidden">
    
    <div class="relative">
        <a href="{{ route('client.services.show', $service->id) }}" class="block aspect-w-16 aspect-h-9 overflow-hidden"> 
            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x400/CCD3D8/334155?text=TechnoG' }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
        </a>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
        
        <div class="absolute top-3 right-3">
            {{-- Menggunakan variabel $priceTagBgClass untuk background dinamis --}}
            <span class="{{ $priceTagBgClass }} text-white text-sm font-bold px-3 py-1.5 rounded-lg backdrop-blur-sm">
                Rp {{ number_format($service->price, 0, ',', '.') }}
            </span>
        </div>

        <div class="absolute bottom-3 left-4">
            <h3 class="text-white font-bold text-lg [filter:drop-shadow(0_1px_1px_rgb(0,0,0))_drop-shadow(0_1px_2px_rgb(0,0,0))]">
                <a href="{{ route('client.services.show', $service->id) }}" class="text-white hover:text-gray-200">{{ $service->name }}</a>
            </h3>
            <p class="text-gray-200 text-xs [filter:drop-shadow(0_1px_1px_rgb(0,0,0))]">
                Estimasi {{ $service->estimated_duration }} {{ $service->duration_unit }}
            </p>
        </div>
    </div>
    
    <div style="{{ $contentBlockStyle }}" class="p-6 flex-grow flex flex-col">
        <ul class="space-y-2 text-sm leading-relaxed flex-grow mb-6 {{ $featureListClass }}">
            @if($service->features)
                @foreach(explode("\n", $service->features) as $index => $feature)
                    @if(trim($feature) && $index < 4)
                        <li class="flex items-start opacity-90">
                            <svg class="flex-shrink-0 h-5 w-5 @if($packageName === 'Gold Plan') text-yellow-300 @else text-green-400 @endif mt-0.5 mr-2" 
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
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
            <a href="{{ route('client.services.show', $service->id) }}" 
               class="w-full text-center px-4 py-2.5 rounded-lg text-sm font-semibold transition border hover:bg-white/10 @if(in_array($packageName, ['Silver Plan'])) text-current border-gray-500/50 @else text-white border-white/50 @endif">
                Detail
            </a>
            
            <form x-data="{ loading: false }" action="{{ route('client.services.order', $service->id) }}" method="POST" class="w-full" @submit="loading = true">
                @csrf
                <button type="submit" :disabled="loading" :class="{'opacity-60 cursor-not-allowed': loading}" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-semibold transition bg-blue-500 text-white hover:bg-blue-400">
                    <span x-show="!loading">Pesan</span>
                    <span x-show="loading" class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>...</span>
                </button>
            </form>
        </div>
    </div>
</div>