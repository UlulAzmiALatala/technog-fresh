@php
    $packageName = $service->package_plan ?? '';
    $contentBlockStyle = '';
    $featureListClass = '';
    $priceTagBgClass = 'bg-black/80'; // Default

    // ======================================================================
    // LOGIKA ASLI DIPERTAHANKAN 100% (Warna, Gradasi, Text Color)
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

<div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] flex flex-col group transition-all duration-500 ease-out hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] overflow-hidden hover:-translate-y-2 border border-gray-100 h-full">
    
    {{-- Header Gambar & Info Ringkas --}}
    <div class="relative h-56 overflow-hidden shrink-0">
        <a href="{{ route('login') }}" class="block w-full h-full"> 
            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x400/CCD3D8/334155?text=TechnoG' }}" 
                 alt="{{ $service->name }}" 
                 class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
        </a>
        
        {{-- Gradient Overlay Halus untuk Teks Bawah --}}
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent pointer-events-none"></div>
        
        {{-- Price Badge (Format Dollar & English) --}}
        <div class="absolute top-4 right-4 z-20">
            <span class="flex items-center gap-1 {{ $priceTagBgClass }} text-white font-bold px-3 py-1.5 rounded-xl backdrop-blur-md border border-white/10 shadow-lg transition-transform duration-300 group-hover:scale-105">
                <span class="text-sm opacity-80">$</span>
                <span class="text-lg tracking-tight">{{ number_format($service->price, 0, '.', ',') }}</span>
            </span>
        </div>

        {{-- Service Name & Duration --}}
        <div class="absolute bottom-4 left-5 right-4 z-20">
            <h3 class="text-white font-extrabold text-xl leading-tight mb-1.5 [filter:drop-shadow(0_2px_4px_rgba(0,0,0,0.5))]">
                <a href="{{ route('login') }}" class="hover:text-indigo-300 transition-colors">{{ $service->name }}</a>
            </h3>
            <div class="flex items-center gap-2 text-gray-200 text-xs font-medium [filter:drop-shadow(0_1px_2px_rgba(0,0,0,0.8))]">
                <i class="fa-regular fa-clock opacity-80"></i>
                <span>Est. {{ $service->estimated_duration }} {{ $service->duration_unit }}</span>
            </div>
        </div>
    </div>
    
    {{-- Content Block (Gradasi Asli) --}}
    <div style="{{ $contentBlockStyle }}" class="p-6 sm:p-8 flex-grow flex flex-col relative z-10">
        
        {{-- Features List --}}
        <ul class="space-y-3 text-sm leading-relaxed flex-grow mb-8 {{ $featureListClass }}">
            @if($service->features)
                @foreach(explode("\n", $service->features) as $index => $feature)
                    @if(trim($feature) && $index < 4)
                        <li class="flex items-start opacity-95 group/item">
                            {{-- Ikon Centang yang bereaksi saat di-hover --}}
                            <svg class="flex-shrink-0 h-5 w-5 @if($packageName === 'Gold Plan' || $packageName === 'Custom Engagement') text-yellow-400 @else text-emerald-400 @endif mt-0.5 mr-3 transform group-hover/item:scale-110 transition-transform" 
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ trim(str_replace('-', '', $feature)) }}</span>
                        </li>
                    @endif
                @endforeach
            @else
                <li class="italic opacity-70 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i> Feature details not available yet.
                </li>
            @endif
        </ul>

        {{-- Action Buttons --}}
        <div class="mt-auto flex flex-col sm:flex-row items-center gap-3">
            <a href="{{ route('login') }}" 
               class="w-full text-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-300 border backdrop-blur-sm 
                      @if(in_array($packageName, ['Silver Plan'])) text-gray-800 border-gray-400/50 hover:bg-gray-100 hover:border-gray-500 
                      @else text-white border-white/30 hover:bg-white/10 hover:border-white/60 @endif">
                View Details
            </a>
            
            <a href="{{ route('login') }}"
               class="w-full text-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-300 border border-transparent bg-indigo-600 text-white hover:bg-indigo-500 hover:shadow-[0_0_20px_rgba(99,102,241,0.5)] transform hover:-translate-y-0.5">
                Order Now
            </a>
        </div>
    </div>
</div>