@php
    // Konfigurasi Tema Berdasarkan Kategori Layanan
    $catName = strtoupper($categoryName ?? '');
    
    if ($catName === 'IT SOLUTION') {
        $envBody   = 'from-slate-800 to-slate-950';
        $envFront  = 'bg-slate-800/95';
        $envFlap   = 'bg-slate-700';
        $accentText= 'text-indigo-500';
        $accentBg  = 'bg-indigo-600';
        $btnBg     = 'bg-indigo-600 hover:bg-indigo-500';
        $btnShadow = 'shadow-indigo-500/30';
        $icon      = 'fa-code';
    } elseif ($catName === 'STATISTICAL SOLUTION') {
        $envBody   = 'from-emerald-900 to-emerald-950';
        $envFront  = 'bg-emerald-900/95';
        $envFlap   = 'bg-emerald-800';
        $accentText= 'text-emerald-500';
        $accentBg  = 'bg-emerald-600';
        $btnBg     = 'bg-emerald-600 hover:bg-emerald-500';
        $btnShadow = 'shadow-emerald-500/30';
        $icon      = 'fa-chart-line';
    } else {
        $envBody   = 'from-cyan-900 to-cyan-950';
        $envFront  = 'bg-cyan-900/95';
        $envFlap   = 'bg-cyan-800';
        $accentText= 'text-cyan-500';
        $accentBg  = 'bg-cyan-600';
        $btnBg     = 'bg-cyan-600 hover:bg-cyan-500';
        $btnShadow = 'shadow-cyan-500/30';
        $icon      = 'fa-network-wired';
    }
    
    // 1. Bersihkan fitur menjadi array yang rapi
    $featuresArray = array_values(array_filter(array_map('trim', explode("\n", $service->features ?? ''))));

    // 2. Bungkus semua data ke dalam array PHP agar diekspor bersih menjadi JSON di Alpine
    $cardData = [
        'isOpen' => false,
        'cardId' => $service->id,
        'serviceData' => [
            'id' => $service->id,
            'name' => $service->name,
            'desc' => trim($service->description ?? ''),
            'features' => $featuresArray,
            'type' => $service->project_type ?? 'Enterprise Solution',
            'accentText' => $accentText,
            'accentBg' => $accentBg
        ]
    ];
@endphp

<div class="relative w-full h-[500px] group cursor-pointer [perspective:1200px] mb-8 z-10"
     x-data="{{ json_encode($cardData) }}"
     @click="
         isOpen = !isOpen;
         if(isOpen) {
             $dispatch('open-service-sidebar', serviceData);
         } else {
             $dispatch('close-service-sidebar', { id: cardId });
         }
     "
     @click.window="
         if(isOpen && !$el.contains($event.target) && !$event.target.closest('.dynamic-sidebar')) { 
             isOpen = false; 
             $dispatch('close-service-sidebar', { id: cardId }); 
         }
     "
     @close-all-cards.window="if($event.detail.id != cardId) isOpen = false"
>
     
     {{-- 1. LAYER BAWAH: AMPLOP BELAKANG --}}
     <div class="absolute inset-0 rounded-[2.5rem] bg-gradient-to-br {{ $envBody }} shadow-[0_20px_40px_rgba(0,0,0,0.15)] border border-white/10 overflow-hidden flex flex-col justify-end transition-transform duration-500 group-hover:-translate-y-2">
     </div>

     {{-- 2. LAYER TENGAH: KERTAS SURAT SANGAT MINIMALIS --}}
     <div class="absolute inset-x-4 top-4 bottom-4 bg-white/95 backdrop-blur-2xl rounded-[2rem] p-6 sm:p-8 z-10 flex flex-col items-center justify-center text-center shadow-[0_-5px_30px_rgba(0,0,0,0.25)] transition-all duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)] border border-white"
          :class="isOpen ? 'translate-y-0 opacity-100' : 'translate-y-[60%] opacity-0 scale-90 pointer-events-none'">
          
          <div class="w-16 h-16 rounded-full {{ $accentBg }}/10 flex items-center justify-center mb-6">
              <i class="fa-solid {{ $icon }} text-2xl {{ $accentText }}"></i>
          </div>

          <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $accentText }} mb-2">
              {{ $service->project_type ?? 'Enterprise Solution' }}
          </span>
          
          <h3 class="text-2xl font-black text-slate-800 leading-tight mb-8">{{ $service->name }}</h3>
          
          <div class="w-full flex flex-col gap-3 mt-auto">
              <button @click.stop="$dispatch('open-meeting-modal')" 
                      class="w-full py-4 rounded-xl text-white font-black text-sm uppercase tracking-widest transition-all duration-300 shadow-lg {{ $btnBg }} {{ $btnShadow }} hover:-translate-y-1 flex items-center justify-center gap-2 group/btn">
                  Let's Meet Up 
                  <i class="fa-regular fa-calendar-check text-lg group-hover/btn:rotate-12 transition-transform"></i>
              </button>
              
              <a href="{{ route('public.services.show', $service->id ?? 1) }}" 
                 @click.stop 
                 class="w-full py-3 text-center rounded-xl text-slate-400 font-bold text-[10px] uppercase tracking-widest border border-slate-200 hover:bg-slate-50 hover:text-slate-700 transition-colors">
                  View Full Details
              </a>
          </div>
     </div>

     {{-- 3A. LAYER DEPAN: AMPLOP BAWAH --}}
     <div class="absolute bottom-0 inset-x-0 h-[60%] {{ $envFront }} backdrop-blur-md z-20 rounded-b-[2.5rem] border-t border-white/10 flex flex-col items-center justify-center transition-transform duration-700 pointer-events-none group-hover:-translate-y-2"
          style="clip-path: polygon(0 20%, 50% 0, 100% 20%, 100% 100%, 0% 100%);"
          :class="isOpen ? 'translate-y-6 opacity-0' : 'translate-y-0 opacity-100'">
     </div>

     {{-- 3B. LAYER DEPAN: AMPLOP FLAP (PENUTUP ATAS / COV) --}}
     <div class="absolute top-0 inset-x-0 h-[45%] {{ $envFlap }} z-30 origin-top border-b border-white/10 flex flex-col items-center justify-center shadow-lg transition-all duration-700 pointer-events-none group-hover:-translate-y-2"
          style="clip-path: polygon(0 0, 100% 0, 50% 100%);"
          :class="isOpen ? '![transform:rotateX(180deg)] opacity-0' : '![transform:rotateX(0deg)] opacity-100'">
          <div class="absolute top-8 w-16 h-16 rounded-full bg-white/10 backdrop-blur-xl flex items-center justify-center border border-white/20 shadow-inner">
              <i class="fa-solid {{ $icon }} text-white text-2xl drop-shadow-md"></i>
          </div>
     </div>

     {{-- 4. TAMPILAN TEXT UTAMA SAAT AMPLOP MASIH TERTUTUP --}}
     <div class="absolute inset-0 z-40 flex flex-col items-center justify-center pointer-events-none transition-all duration-500 group-hover:-translate-y-2"
          :class="isOpen ? 'opacity-0 scale-95' : 'opacity-100 scale-100'">
          
          <div class="mt-20 px-6 text-center">
              <h3 class="text-white font-black text-2xl drop-shadow-lg leading-tight mb-3 tracking-tight">{{ $service->name }}</h3>
              <span class="inline-block px-4 py-1.5 rounded-full bg-black/30 backdrop-blur-md border border-white/10 text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-inner">
                  {{ $service->project_type ?? 'Enterprise' }}
              </span>
          </div>
          
          <div class="absolute bottom-10 text-center w-full">
              <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-bold uppercase tracking-widest animate-pulse">
                  <i class="fa-solid fa-envelope-open-text"></i> Tap to Open Mail
              </div>
          </div>
     </div>
     
     {{-- BACKGROUND OUTER GLOW --}}
     <div class="absolute -inset-4 bg-gradient-to-r {{ $envBody }} rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-30 transition-opacity duration-700 -z-10"
          :class="isOpen ? 'opacity-40' : ''"></div>
</div>