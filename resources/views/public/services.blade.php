<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Enterprise Solutions - TechnoG Solutions
    </x-slot>

    {{-- HERO SECTION --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden bg-slate-950">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1600&q=80" alt="Enterprise Solutions" class="w-full h-full object-cover opacity-40 mix-blend-luminosity">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900/90 to-slate-900/50"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-48 pb-32 z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })" class="max-w-4xl">
                    <div class="fade-in-item inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 mb-6">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        <span class="text-xs font-bold tracking-widest uppercase text-slate-300">Enterprise Solutions</span>
                    </div>
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight text-white pb-2 leading-tight">
                        Precision Engineering. <br class="hidden sm:block"> 
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-indigo-400">Data-Driven Mastery.</span>
                    </h1>
                    <p class="fade-in-item mt-6 text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                        Mendorong efisiensi korporat melalui arsitektur perangkat lunak skala tinggi dan pemodelan analitik statistik presisi. Kami membangun fondasi digital untuk masa depan bisnis Anda.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    @php
        $reqCatName = request('category');
        $activeCatId = $serviceCategories->first()?->id ?? '';
        
        if ($reqCatName) {
            $matchedCat = $serviceCategories->firstWhere('name', strtoupper(urldecode($reqCatName)));
            if ($matchedCat) {
                $activeCatId = $matchedCat->id;
            }
        }
    @endphp

    {{-- WRAPPER UTAMA CORE ENGINE SERVICES --}}
    <section x-data="servicesEngine()" 
             x-intersect.once="animate = true" 
             class="bg-white relative overflow-hidden min-h-screen">
        
        {{-- DEKORASI BACKGROUND --}}
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-indigo-50/40 rounded-full blur-[120px] pointer-events-none -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-cyan-50/40 rounded-full blur-[120px] pointer-events-none translate-y-1/3 -translate-x-1/3"></div>

        {{-- TRUSTED BY / SOCIAL PROOF SECTION --}}
        <div class="border-b border-slate-100 bg-white relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <p class="text-center text-xs font-bold tracking-widest uppercase text-slate-400 mb-8">Trusted by Forward-Thinking Enterprises</p>
                <div class="flex flex-wrap justify-center items-center gap-10 sm:gap-20 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                    <i class="fa-brands fa-aws text-4xl text-slate-700 hover:text-[#FF9900] transition-colors"></i>
                    <i class="fa-brands fa-digital-ocean text-4xl text-slate-700 hover:text-[#0080FF] transition-colors"></i>
                    <i class="fa-brands fa-stripe text-4xl text-slate-700 hover:text-[#008CDD] transition-colors"></i>
                    <i class="fa-brands fa-cloudflare text-4xl text-slate-700 hover:text-[#F38020] transition-colors"></i>
                    <i class="fa-brands fa-github text-4xl text-slate-700 hover:text-[#181717] transition-colors"></i>
                </div>
            </div>
        </div>

        {{-- THE DUAL-ENGINE ADVANTAGE (IKON SVG MURNI) --}}
        <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase">Core Competency</h2>
                <h3 class="fade-in-item mt-3 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">The Dual-Engine Advantage</h3>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-slate-600">TechnoG beroperasi pada sinergi mutlak antara rekayasa perangkat lunak dan keakuratan analisis data strategis.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <div class="fade-in-item bg-slate-50 rounded-[2rem] p-10 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-600 rounded-xl flex items-center justify-center mb-8 shadow-lg shadow-indigo-600/30 group-hover:scale-110 transition-transform text-white">
                        {{-- SVG IT Engineering --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-4">Enterprise IT Engineering</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">Dikepalai oleh arsitek IT spesialis, kami merancang infrastruktur monolith maupun decoupled menggunakan ekosistem teruji seperti Laravel dan React. Fokus pada keamanan, stabilitas (*stable pattern*), dan kecepatan respon sistem.</p>
                </div>
                <div class="fade-in-item bg-slate-50 rounded-[2rem] p-10 border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 bg-emerald-600 rounded-xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-600/30 group-hover:scale-110 transition-transform text-white">
                        {{-- SVG Statistical Data --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-black text-slate-900 mb-4">Statistical & Data Science</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">Dikendalikan oleh statistisi profesional, kami tidak sekadar mengelola database. Kami mengekstraksi raw data menjadi model prediktif dan laporan wawasan presisi yang menavigasi strategi bisnis Anda.</p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-16">
            
            {{-- TABS KATEGORI PRESENTASI --}}
            <div class="text-center mb-20">
                <h2 class="text-sm font-bold tracking-widest text-cyan-600 uppercase mb-8">Our Capabilities</h2>
                <div class="w-full overflow-x-auto hide-scrollbar pb-4">
                    <div class="flex flex-nowrap md:flex-wrap md:justify-center items-center gap-3 md:gap-4 p-2 bg-slate-50/80 backdrop-blur-xl border border-slate-200/60 rounded-3xl md:rounded-full shadow-inner w-max min-w-full md:min-w-0 mx-auto snap-x">
                        @foreach ($serviceCategories as $category)
                            @php
                                $categoryStyle = '';
                                $hoverShadow = '';
                                $catNameUpper = strtoupper($category->name ?? '');

                                switch ($catNameUpper) {
                                    case 'IT SOLUTION': 
                                        $categoryStyle = 'background: linear-gradient(135deg, #1e293b, #0f172a); color:#FFFFFF;'; 
                                        $hoverShadow = 'rgba(15, 23, 42, 0.3)'; break;
                                    case 'STATISTICAL SOLUTION': 
                                        $categoryStyle = 'background: linear-gradient(135deg, #059669, #064e3b); color:#FFFFFF;'; 
                                        $hoverShadow = 'rgba(5, 150, 105, 0.3)'; break;
                                    case 'HYBRID PATHWAY': 
                                        $categoryStyle = 'background: linear-gradient(135deg, #0ea5e9, #0284c7); color:#FFFFFF;'; 
                                        $hoverShadow = 'rgba(14, 165, 233, 0.3)'; break;
                                }
                            @endphp
                            <button
                                @click="switchCategory('{{ $category->id }}')"
                                :class="activeCatId === '{{ $category->id }}' ? 'scale-105 shadow-xl ring-2 ring-white' : 'opacity-70 hover:opacity-100 text-slate-700 bg-white border border-slate-200'"
                                class="shrink-0 snap-center px-6 md:px-8 py-3.5 rounded-full font-bold text-xs tracking-widest uppercase transition-all duration-300 whitespace-nowrap"
                                :style="activeCatId === '{{ $category->id }}' ? '{{ $categoryStyle }} box-shadow: 0 10px 25px -5px {{ $hoverShadow }}' : ''">
                                <span>{{ $category->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- LOOPING DINAMIS PRESENTASI KATEGORI --}}
            <div class="space-y-40">
                @foreach ($serviceCategories as $category)
                    @php 
                        $catName = strtoupper($category->name ?? ''); 
                        $ovTitle = '';
                        $ovDesc = '';
                        if($catName == 'IT SOLUTION') {
                            $ovTitle = 'Enterprise Software Architecture';
                            $ovDesc = 'Membangun ekosistem digital yang tangguh, modular, dan aman. Dari integrasi API kompleks hingga antarmuka pengguna interaktif.';
                        } elseif($catName == 'STATISTICAL SOLUTION') {
                            $ovTitle = 'Deep Analytics & Predictive Engine';
                            $ovDesc = 'Mengubah tumpukan data menjadi peta kompas strategi. Algoritma tingkat lanjut kami memproyeksikan keputusan masa depan secara akurat.';
                        } else {
                            $ovTitle = 'The Synergy of Code & Science';
                            $ovDesc = 'Solusi eksklusif yang menggabungkan antarmuka aplikasi berkinerja tinggi dengan mesin analitik data real-time di latar belakang.';
                        }

                        // Menggunakan path SVG MURNI untuk Pillars
                        $pillars = [];
                        if($catName === 'IT SOLUTION') {
                            $pillars = [
                                ['title' => 'Stable Pattern Architecture', 'desc' => 'Kami menggunakan arsitektur Laravel monolith modern yang sangat efisien, mengkombinasikan kecepatan rendering Blade dengan reaktivitas state Alpine.js.', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 17.25v-.228a4.5 4.5 0 0 0-.12-1.03l-2.268-9.64a3.375 3.375 0 0 0-3.285-2.602H7.923a3.375 3.375 0 0 0-3.285 2.602l-2.268 9.64a4.5 4.5 0 0 0-.12 1.03v.228m19.5 0a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3m19.5 0a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3m16.5 0h.008v.008h-.008v-.008Zm-3 0h.008v.008h-.008v-.008Z" />', 'color' => 'indigo'],
                                ['title' => 'Secure & Scalable Framework', 'desc' => 'Perlindungan data aset B2B adalah prioritas. Arsitektur backend dirancang berlapis untuk menangkal ancaman sekaligus siap diekspansi secara horizontal.', 'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />', 'color' => 'slate']
                            ];
                        } elseif($catName === 'STATISTICAL SOLUTION') {
                            $pillars = [
                                ['title' => 'Data-Driven Corporate Strategy', 'desc' => 'Singkirkan keputusan spekulatif. Setiap pergerakan korporat didasarkan pada visualisasi matriks risiko, uji hipotesis, dan data validasi ril.', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />', 'color' => 'emerald'],
                                ['title' => 'Complex Metrical Modeling', 'desc' => 'Tim kami menangani pembersihan data, regresi logistik, hingga analisis deret waktu untuk efisiensi rantai pasok dan pemetaan pasar.', 'img' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />', 'color' => 'teal']
                            ];
                        } else {
                            $pillars = [
                                ['title' => 'Seamless Hybrid Integration', 'desc' => 'Kami mengintegrasikan model analitik langsung ke dalam web dashboard (WMS, ERP) sehingga eksekutif dapat memantau kalkulasi secara real-time.', 'img' => 'https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />', 'color' => 'cyan'],
                                ['title' => 'Automated Pipeline Efficiency', 'desc' => 'Alur kerja otomasi yang mempercepat ritme operasional perusahaan B2B tanpa mengorbankan ketelitian data masuk.', 'img' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1600&q=80', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />', 'color' => 'sky']
                            ];
                        }
                    @endphp

                    <div x-show="activeCatId === '{{ $category->id }}'" 
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-12"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;">
                         
                        {{-- OVERVIEW BANNER KATEGORI --}}
                        <div class="mb-24 bg-white/60 backdrop-blur-3xl rounded-[2.5rem] p-8 sm:p-12 border border-slate-200/60 shadow-xl relative overflow-hidden">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10 items-center">
                                <div class="lg:col-span-6 space-y-5">
                                    <h3 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">{{ $ovTitle }}</h3>
                                    <p class="text-slate-500 text-lg leading-relaxed font-medium">{{ $ovDesc }}</p>
                                </div>
                                <div class="lg:col-span-6 lg:pl-10">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col gap-3 transition-colors">
                                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100 mb-2">
                                                <i class="fa-solid fa-check-double text-slate-600"></i>
                                            </div>
                                            <h4 class="font-black text-slate-800 text-sm">Enterprise Quality</h4>
                                            <p class="text-xs text-slate-500 font-medium leading-relaxed">Standar kode & metodologi tinggi untuk hasil sempurna.</p>
                                        </div>
                                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col gap-3 transition-colors">
                                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100 mb-2">
                                                <i class="fa-solid fa-clock-rotate-left text-slate-600"></i>
                                            </div>
                                            <h4 class="font-black text-slate-800 text-sm">Agile Delivery</h4>
                                            <p class="text-xs text-slate-500 font-medium leading-relaxed">Manajemen waktu iteratif yang efisien dan transparan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRESENTASI SECTION SELANG-SELING --}}
                        <div class="space-y-24 sm:space-y-32">
                            @foreach($pillars as $pIndex => $pillar)
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                                    <div class="fade-in-item {{ $pIndex % 2 === 0 ? 'lg:order-1' : 'lg:order-2' }}">
                                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl bg-{{ $pillar['color'] }}-50 border border-{{ $pillar['color'] }}-100 text-{{ $pillar['color'] }}-600 mb-6 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                                                {!! $pillar['icon'] !!}
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $pillar['title'] }}</h3>
                                        <p class="mt-5 text-lg text-slate-600 leading-relaxed font-medium">{{ $pillar['desc'] }}</p>
                                    </div>

                                    <div class="fade-in-item {{ $pIndex % 2 === 0 ? 'lg:order-2' : 'lg:order-1' }}">
                                        <div class="relative rounded-3xl p-2 bg-slate-50 border border-slate-200 shadow-xl overflow-hidden group">
                                            <div class="absolute inset-0 bg-gradient-to-tr from-{{ $pillar['color'] }}-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                            <img src="{{ $pillar['img'] }}" alt="{{ $pillar['title'] }}" class="w-full h-72 sm:h-96 object-cover rounded-[1.5rem] transform group-hover:scale-105 transition-transform duration-700 ease-out filter contrast-125">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SECTION 1: MEASURABLE IMPACT (DENGAN ANIMASI ANGKA) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mt-32">
            <div x-data="{ shown: false }" x-intersect.once="shown = true" class="bg-indigo-600 rounded-[2.5rem] p-10 sm:p-16 relative overflow-hidden shadow-2xl shadow-indigo-600/20">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-indigo-400/40">
                    
                    {{-- Animasi 99.9% --}}
                    <div class="fade-in-item pt-8 md:pt-0" :class="shown ? 'in-view' : ''">
                        <div class="text-5xl sm:text-6xl font-black text-white mb-2 flex items-center justify-center"
                             x-data="{ current: 0, target: 99.9, time: 2000 }"
                             x-init="$watch('shown', val => { 
                                if(val) { 
                                    let start = null;
                                    const step = (timestamp) => {
                                        if (!start) start = timestamp;
                                        const progress = Math.min((timestamp - start) / time, 1);
                                        const easeOut = 1 - Math.pow(1 - progress, 4);
                                        current = (easeOut * target).toFixed(1);
                                        if (progress < 1) window.requestAnimationFrame(step);
                                        else current = target.toFixed(1);
                                    };
                                    window.requestAnimationFrame(step);
                                }
                             })">
                            <span x-text="current">0</span><span>%</span>
                        </div>
                        <div class="text-indigo-200 font-bold tracking-[0.2em] uppercase text-xs">System Uptime</div>
                    </div>

                    {{-- Animasi 100% --}}
                    <div class="fade-in-item pt-8 md:pt-0" :class="shown ? 'in-view' : ''">
                        <div class="text-5xl sm:text-6xl font-black text-white mb-2 flex items-center justify-center"
                             x-data="{ current: 0, target: 100, time: 2000 }"
                             x-init="$watch('shown', val => { 
                                if(val) { 
                                    let start = null;
                                    const step = (timestamp) => {
                                        if (!start) start = timestamp;
                                        const progress = Math.min((timestamp - start) / time, 1);
                                        const easeOut = 1 - Math.pow(1 - progress, 4);
                                        current = Math.floor(easeOut * target);
                                        if (progress < 1) window.requestAnimationFrame(step);
                                        else current = target;
                                    };
                                    window.requestAnimationFrame(step);
                                }
                             })">
                            <span x-text="current">0</span><span>%</span>
                        </div>
                        <div class="text-indigo-200 font-bold tracking-[0.2em] uppercase text-xs">Data Confidentiality</div>
                    </div>

                    {{-- Animasi 24/7 --}}
                    <div class="fade-in-item pt-8 md:pt-0" :class="shown ? 'in-view' : ''">
                        <div class="text-5xl sm:text-6xl font-black text-white mb-2 flex items-center justify-center"
                             x-data="{ current: 0, target: 24, time: 2000 }"
                             x-init="$watch('shown', val => { 
                                if(val) { 
                                    let start = null;
                                    const step = (timestamp) => {
                                        if (!start) start = timestamp;
                                        const progress = Math.min((timestamp - start) / time, 1);
                                        const easeOut = 1 - Math.pow(1 - progress, 4);
                                        current = Math.floor(easeOut * target);
                                        if (progress < 1) window.requestAnimationFrame(step);
                                        else current = target;
                                    };
                                    window.requestAnimationFrame(step);
                                }
                             })">
                            <span x-text="current">0</span><span>/7</span>
                        </div>
                        <div class="text-indigo-200 font-bold tracking-[0.2em] uppercase text-xs">Priority SLA Support</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: THE DEVELOPMENT LIFECYCLE (SVG ICONS) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mt-32">
            <div class="text-center mb-16" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase tracking-[0.2em]">Our Methodology</h2>
                <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">The Enterprise Lifecycle</h3>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-slate-600">Protokol pengerjaan ketat kami memastikan serah terima proyek berjalan sesuai SLA dan spesifikasi bisnis.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <div class="hidden md:block absolute top-1/2 left-0 right-0 h-0.5 bg-slate-200 -translate-y-1/2 z-0"></div>
                @php
                    $lifecycles = [
                        ['step' => '01', 'title' => 'Consultation', 'desc' => 'Pemetaan objektif IT & metrik statistik.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />'],
                        ['step' => '02', 'title' => 'Architecture', 'desc' => 'Perancangan UI/UX & relasi database.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />'],
                        ['step' => '03', 'title' => 'Agile Build', 'desc' => 'Pengembangan iteratif dengan UAT ketat.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75 16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />'],
                        ['step' => '04', 'title' => 'Deployment', 'desc' => 'Peluncuran ke production & serah terima IP.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.45m.04-8.13a10.97 10.97 0 0 1 10.45 10.45M5.55 5.55l12.9 12.9M5.55 18.45l12.9-12.9" />'],
                    ];
                @endphp
                @foreach($lifecycles as $index => $cycle)
                    <div class="fade-in-item relative z-10 bg-white p-8 rounded-2xl shadow-lg border border-slate-100 text-center group">
                        <div class="w-14 h-14 mx-auto bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-slate-400 group-hover:text-white transition-colors">
                                {!! $cycle['icon'] !!}
                            </svg>
                        </div>
                        <div class="text-[10px] font-black text-indigo-500 mb-2">PHASE {{ $cycle['step'] }}</div>
                        <h4 class="text-lg font-bold text-slate-800 mb-2">{{ $cycle['title'] }}</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">{{ $cycle['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- SECTION 3: ENGAGEMENT MODELS --}}
        <div class="bg-slate-50 mt-32 py-24 border-y border-slate-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                    <h2 class="fade-in-item text-sm font-bold tracking-widest text-cyan-600 uppercase tracking-[0.2em]">Flexibility</h2>
                    <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">Engagement Models</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                    <div class="fade-in-item bg-white rounded-3xl p-10 shadow-lg border border-slate-200 hover:border-indigo-300 transition-colors">
                        <i class="fa-solid fa-box-open text-3xl text-indigo-500 mb-6"></i>
                        <h4 class="text-2xl font-black text-slate-800 mb-3">Turnkey Project</h4>
                        <p class="text-slate-600 font-medium mb-8 leading-relaxed">Cocok untuk inisiasi sistem baru. Kami mendeliver dari nol hingga siap pakai dengan scope dan timeline yang terukur jelas.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-sm font-bold text-slate-700"><i class="fa-solid fa-check text-indigo-500 mr-3"></i> Fixed Budget & Timeline</li>
                            <li class="flex items-center text-sm font-bold text-slate-700"><i class="fa-solid fa-check text-indigo-500 mr-3"></i> Full IP Handover</li>
                        </ul>
                        <button @click="$dispatch('open-meeting-modal')" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Discuss Project</button>
                    </div>

                    <div class="fade-in-item bg-slate-900 rounded-3xl p-10 shadow-xl border border-slate-800">
                        <i class="fa-solid fa-handshake text-3xl text-cyan-400 mb-6"></i>
                        <h4 class="text-2xl font-black text-white mb-3">Dedicated Retainer</h4>
                        <p class="text-slate-400 font-medium mb-8 leading-relaxed">Solusi untuk pengembangan berkelanjutan. Tim IT & Statistik kami bertindak sebagai ekstensi divisi teknologi perusahaan Anda.</p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-sm font-bold text-slate-200"><i class="fa-solid fa-check text-cyan-400 mr-3"></i> Flexible Iterations</li>
                            <li class="flex items-center text-sm font-bold text-slate-200"><i class="fa-solid fa-check text-cyan-400 mr-3"></i> Priority Maintenance SLA</li>
                        </ul>
                        <button @click="$dispatch('open-meeting-modal')" class="w-full py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Partner With Us</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: ENTERPRISE FAQ --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 mt-24 mb-24">
            <div class="text-center mb-16" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <h3 class="fade-in-item text-3xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h3>
            </div>
            <div class="space-y-4" x-data="{ activeAccordion: null }" x-intersect:enter.once="$el.classList.add('is-in-view')">
                @php
                    $faqs = [
                        ['q' => 'Apakah source code dan database sepenuhnya menjadi milik klien?', 'a' => 'Ya, untuk skema End-to-End Project, setelah serah terima akhir, seluruh hak kepemilikan intelectual property (IP), source code, dan kredensial database diserahkan penuh kepada perusahaan Anda.'],
                        ['q' => 'Bagaimana TechnoG menangani keamanan data perusahaan kami?', 'a' => 'Kami menggunakan enkripsi data standar industri, otentikasi multi-faktor, serta arsitektur backend tertutup. Tim kami juga menandatangani Non-Disclosure Agreement (NDA) ketat sebelum proyek dimulai.'],
                        ['q' => 'Apakah melayani integrasi dengan sistem legacy yang sudah ada?', 'a' => 'Sangat bisa. Kami merancang arsitektur RESTful API kustom untuk menjembatani solusi baru kami dengan sistem lama (legacy) maupun aplikasi pihak ketiga lainnya tanpa mengganggu operasional.'],
                        ['q' => 'Berapa lama estimasi penyelesaian sebuah project?', 'a' => 'Timeline sangat bergantung pada kompleksitas modul IT dan analisis statistik yang dibutuhkan. Rata-rata pengembangan memakan waktu 4 hingga 12 minggu. Estimasi presisi akan diberikan pasca-meeting konsultasi.']
                    ];
                @endphp
                @foreach($faqs as $index => $faq)
                    <div class="fade-in-item bg-white border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300">
                        <button @click="activeAccordion = activeAccordion === {{ $index }} ? null : {{ $index }}" 
                                class="w-full px-6 py-5 flex items-center justify-between focus:outline-none bg-slate-50 hover:bg-slate-100">
                            <span class="font-bold text-slate-800 text-left pr-4">{{ $faq['q'] }}</span>
                            <span class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-white border border-slate-200 text-slate-400">
                                <i class="fa-solid fa-chevron-down transition-transform duration-300" :class="activeAccordion === {{ $index }} ? 'rotate-180' : ''"></i>
                            </span>
                        </button>
                        <div x-show="activeAccordion === {{ $index }}" x-collapse class="px-6 py-4 border-t border-slate-100">
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- DOCK SIDEBAR (IKON AMPLOP 3D MODERN B2B)                          --}}
        {{-- ================================================================= --}}
        <div class="fixed right-2 md:right-6 top-1/2 -translate-y-1/2 z-[90] flex items-center justify-end"
             x-data="{ dockOpen: false }"
             @mouseenter="dockOpen = true"
             @mouseleave="dockOpen = false">

             {{-- Wrapper Utama --}}
             <button @click="openCategories()" class="relative w-[80px] h-[80px] group focus:outline-none transition-transform duration-300 hover:scale-105 animate-mail-float flex items-center justify-center">

                 {{-- Dot Ungu --}}
                 <span class="absolute top-1 right-1 w-4 h-4 bg-[#a855f7] rounded-full border-2 border-white z-50 shadow-sm animate-pulse"></span>

                 {{-- 3D Envelope Container --}}
                 <div class="relative w-[72px] h-[48px] -rotate-90 flex items-center justify-center transition-all duration-300" style="perspective: 800px;">

                     {{-- 1. Back Panel Amplop --}}
                     <div class="absolute inset-0 bg-slate-900 rounded-[4px] shadow-inner border border-slate-700"></div>

                     {{-- 2. Kertas Cyan (Tengah) --}}
                     <div class="absolute z-10 w-[56px] h-[42px] bg-[#dbf4ff] rounded-t-md left-[8px] top-[2px] transition-all duration-500 ease-out border border-[#bae6fd]"
                          :class="dockOpen ? '-translate-y-10 shadow-lg' : 'translate-y-0'">
                         <div class="w-8 h-1 bg-[#7dd3fc] rounded-full absolute top-3 left-3"></div>
                         <div class="w-5 h-1 bg-[#7dd3fc] rounded-full absolute top-5 left-3"></div>
                     </div>

                     {{-- 3. Kertas Putih (Depan) --}}
                     <div class="absolute z-20 w-[56px] h-[44px] bg-white rounded-t-md left-[8px] top-[2px] transition-all duration-500 ease-out delay-75 border border-slate-200"
                          :class="dockOpen ? '-translate-y-14 shadow-xl' : 'translate-y-0'">
                         <div class="w-8 h-1 bg-slate-200 rounded-full absolute top-3 left-3"></div>
                         <div class="w-10 h-1 bg-slate-200 rounded-full absolute top-5 left-3"></div>
                         <div class="w-6 h-1 bg-slate-200 rounded-full absolute top-7 left-3"></div>
                     </div>

                     {{-- 4. Front Flaps Amplop (Kiri, Kanan, Bawah) --}}
                     <svg class="absolute inset-0 z-30 w-full h-full pointer-events-none drop-shadow-md rounded-[4px]" viewBox="0 0 72 48">
                         <polygon points="0,0 36,24 0,48" fill="#334155" stroke="#1e293b" stroke-width="0.5" stroke-linejoin="round"/>
                         <polygon points="72,0 36,24 72,48" fill="#475569" stroke="#1e293b" stroke-width="0.5" stroke-linejoin="round"/>
                         <polygon points="0,48 36,24 72,48" fill="#1e293b" stroke="#0f172a" stroke-width="0.5" stroke-linejoin="round"/>
                     </svg>

                     {{-- 5. Top Flap Amplop --}}
                     <div class="absolute top-0 left-0 w-full h-[24px] origin-top transition-all duration-500 ease-in-out pointer-events-none"
                          :class="dockOpen ? 'z-0 [transform:rotateX(180deg)]' : 'z-40 [transform:rotateX(0deg)]'">
                         <svg class="w-full h-full drop-shadow-md" viewBox="0 0 72 24">
                             <polygon points="0,0 72,0 36,24" fill="#1e293b" stroke="#0f172a" stroke-width="0.5" stroke-linejoin="round"/>
                         </svg>
                     </div>
                 </div>
             </button>
        </div>

        {{-- ================================================================= --}}
        {{-- MULTI-STEP B2B MODAL (CATEGORIES -> SERVICES -> DETAIL)           --}}
        {{-- ================================================================= --}}
        <div x-show="modalState > 0" 
             class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" 
             style="display: none;">
             
             {{-- Backdrop Blur --}}
             <div @click="closeModal()" 
                  x-show="modalState > 0"
                  x-transition.opacity.duration.300ms
                  class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

             {{-- Modal Container (Diperbesar) --}}
             <div x-show="modalState > 0"
                  x-transition:enter="ease-out duration-400"
                  x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                  x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                  x-transition:leave="ease-in duration-300"
                  x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                  x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                  class="relative w-full max-w-5xl bg-white rounded-3xl shadow-2xl border border-slate-100 flex flex-col max-h-[90vh] z-10 overflow-hidden">
                  
                  {{-- Dynamic Modal Header --}}
                  <div class="px-6 py-5 border-b border-slate-100 bg-white flex items-center justify-between shrink-0">
                      <div class="flex items-center gap-4">
                          {{-- Tombol Back --}}
                          <button x-show="modalState > 1" @click="goBack()" title="Kembali" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-500 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-colors shrink-0 focus:outline-none shadow-sm group">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                              </svg>
                          </button>
                          <div>
                              <div x-show="modalState === 3" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-indigo-50 border border-indigo-100 mb-1.5">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                  </svg>
                                  <span class="text-[9px] font-black uppercase tracking-widest text-indigo-700" x-text="selectedService.type"></span>
                              </div>
                              <h3 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight" 
                                  x-text="modalState === 1 ? 'Pilih Kategori Solusi' : (modalState === 2 ? 'Pilih Modul Layanan' : selectedService.name)">
                              </h3>
                          </div>
                      </div>
                      {{-- Tombol Tutup --}}
                      <button @click="closeModal()" title="Tutup" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-400 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600 transition-colors focus:outline-none shrink-0 shadow-sm group">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                      </button>
                  </div>

                  {{-- Modal Body (Scrollable) --}}
                  <div class="p-8 overflow-y-auto hide-scrollbar flex-grow bg-slate-50 relative min-h-[300px]">
                      
                      {{-- STEP 1: PILIH KATEGORI --}}
                      <div x-show="modalState === 1" 
                           x-transition:enter="transition ease-out duration-300 delay-100" 
                           x-transition:enter-start="opacity-0 translate-x-4" 
                           x-transition:enter-end="opacity-100 translate-x-0" 
                           class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                          @foreach ($serviceCategories as $category)
                              @php
                                  $catNameUpper = strtoupper($category->name ?? '');
                                  $catTheme = [
                                      'blob' => 'bg-slate-200',
                                      'iconBg' => 'bg-slate-100 group-hover:bg-slate-200 text-slate-500 group-hover:text-slate-700',
                                      'title' => 'text-slate-800 group-hover:text-slate-900',
                                      'border' => 'border-slate-200 hover:border-slate-300'
                                  ];
                                  if ($catNameUpper === 'IT SOLUTION') {
                                      $catTheme = ['blob' => 'bg-indigo-300/40', 'iconBg' => 'bg-indigo-50 border-indigo-100 text-indigo-500 group-hover:bg-indigo-100 group-hover:text-indigo-600', 'title' => 'text-slate-800 group-hover:text-indigo-700', 'border' => 'border-slate-200 hover:border-indigo-300'];
                                  } elseif ($catNameUpper === 'STATISTICAL SOLUTION') {
                                      $catTheme = ['blob' => 'bg-emerald-300/40', 'iconBg' => 'bg-emerald-50 border-emerald-100 text-emerald-500 group-hover:bg-emerald-100 group-hover:text-emerald-600', 'title' => 'text-slate-800 group-hover:text-emerald-700', 'border' => 'border-slate-200 hover:border-emerald-300'];
                                  } elseif ($catNameUpper === 'HYBRID PATHWAY') {
                                      $catTheme = ['blob' => 'bg-cyan-300/40', 'iconBg' => 'bg-cyan-50 border-cyan-100 text-cyan-500 group-hover:bg-cyan-100 group-hover:text-cyan-600', 'title' => 'text-slate-800 group-hover:text-cyan-700', 'border' => 'border-slate-200 hover:border-cyan-300'];
                                  }
                              @endphp

                              <button @click="selectCategoryInModal('{{ $category->id }}')" class="relative p-6 rounded-[1.5rem] bg-white border {{ $catTheme['border'] }} text-left transition-all duration-300 group focus:outline-none hover:shadow-xl hover:-translate-y-1 overflow-hidden">
                                  <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full blur-2xl opacity-60 transition-transform duration-500 group-hover:scale-150 {{ $catTheme['blob'] }}"></div>
                                  <div class="relative z-10">
                                      <div class="w-14 h-14 rounded-2xl border flex items-center justify-center mb-5 transition-colors shadow-sm {{ $catTheme['iconBg'] }}">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                          </svg>
                                      </div>
                                      <h4 class="font-black text-xl mb-2 transition-colors {{ $catTheme['title'] }}">{{ $category->name }}</h4>
                                      <p class="text-xs text-slate-500 leading-relaxed font-medium">Eksplorasi modul sistem dan analitik di dalam domain ini.</p>
                                  </div>
                              </button>
                          @endforeach
                      </div>

                      {{-- STEP 2: PILIH LAYANAN/MODUL --}}
                      <div x-show="modalState === 2" 
                           x-transition:enter="transition ease-out duration-300 delay-100" 
                           x-transition:enter-start="opacity-0 translate-x-4" 
                           x-transition:enter-end="opacity-100 translate-x-0">
                          @foreach ($serviceCategories as $category)
                              <div x-show="activeCatId === '{{ $category->id }}'" style="display: none;" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                  @foreach ($category->services as $sService)
                                      @php
                                          $cName = strtoupper($category->name ?? '');
                                          $mTitleHover = 'group-hover:text-slate-800';
                                          $mBtnArrow = 'group-hover:bg-slate-100 group-hover:text-slate-600';

                                          if($cName === 'IT SOLUTION') {
                                              $mTitleHover = 'group-hover:text-indigo-600';
                                              $mBtnArrow = 'group-hover:bg-indigo-50 group-hover:text-indigo-600 group-hover:border-indigo-100';
                                          } elseif($cName === 'STATISTICAL SOLUTION') {
                                              $mTitleHover = 'group-hover:text-emerald-600';
                                              $mBtnArrow = 'group-hover:bg-emerald-50 group-hover:text-emerald-600 group-hover:border-emerald-100';
                                          } elseif($cName === 'HYBRID PATHWAY') {
                                              $mTitleHover = 'group-hover:text-cyan-600';
                                              $mBtnArrow = 'group-hover:bg-cyan-50 group-hover:text-cyan-600 group-hover:border-cyan-100';
                                          }

                                          // LOGIKA PINTAR UNTUK FEATURES (JSON ATAU TEKS ENTER)
                                          $rawFeatures = $sService->features;
                                          $featuresArray = [];
                                          if (is_array($rawFeatures)) {
                                              $featuresArray = $rawFeatures;
                                          } else {
                                              $decoded = json_decode($rawFeatures, true);
                                              if (is_array($decoded)) {
                                                  $featuresArray = $decoded;
                                              } else {
                                                  $featuresArray = explode("\n", $rawFeatures ?? '');
                                              }
                                          }

                                          // LOGIKA UNTUK WORKFLOW (ARRAY ATAU TEKS ENTER)
                                          $rawWorkflow = $sService->workflow;
                                          $workflowArray = [];
                                          if (is_array($rawWorkflow)) {
                                              $workflowArray = $rawWorkflow;
                                          } else {
                                              $decodedWf = json_decode($rawWorkflow, true);
                                              if(is_array($decodedWf)) {
                                                  $workflowArray = $decodedWf;
                                              } else {
                                                  $workflowArray = $rawWorkflow ? explode("\n", $rawWorkflow) : [
                                                      'Requirement & Metrical Analysis',
                                                      'Architecture & Model Design',
                                                      'Agile Development & QA',
                                                      'Deployment & Handover'
                                                  ];
                                              }
                                          }

                                          // SUSUN PAYLOAD DATA
                                          $mailData = [
                                              'name' => $sService->name,
                                              'type' => $sService->project_type ?? 'Enterprise Solution',
                                              'overview' => trim($sService->description ?? '') ?: 'Deskripsi arsitektur level atas akan dipaparkan lebih lanjut.',
                                              
                                              'outputs'  => array_values(array_filter(array_map('trim', $featuresArray), 'strlen')),
                                              'workflow' => array_values(array_filter(array_map('trim', $workflowArray), 'strlen')),
                                              
                                              'use_case' => trim($sService->use_case ?? '') ?: 'Layanan ' . $sService->name . ' ini dirancang untuk memberikan efisiensi alur kerja dan akurasi tinggi bagi enterprise Anda.',
                                          ];
                                      @endphp

                                      <button @click="openMailModal({{ json_encode($mailData) }})" class="w-full p-3 rounded-2xl border border-slate-200 bg-white text-left transition-all duration-300 flex items-center group focus:outline-none shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                          <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center mr-4 shrink-0 overflow-hidden relative">
                                              <img src="{{ asset('storage/' . ($sService->image ?? '')) }}" 
                                                   onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=150&q=80';" 
                                                   alt="{{ $sService->name }}" 
                                                   class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                          </div>
                                          <div class="flex-1">
                                              <h4 class="font-bold text-slate-800 text-sm sm:text-base transition-colors {{ $mTitleHover }}">{{ $sService->name }}</h4>
                                              <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $sService->project_type ?? 'Module' }}</p>
                                          </div>
                                          <div class="w-8 h-8 rounded-full border border-transparent flex items-center justify-center text-slate-400 shrink-0 ml-2 transition-colors {{ $mBtnArrow }}">
                                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                              </svg>
                                          </div>
                                      </button>
                                  @endforeach
                              </div>
                          @endforeach
                      </div>

                      {{-- STEP 3: DETAIL LAYANAN (B2B STRUCTURAL FORMAT - 2 ROWS) --}}
                      <div x-show="modalState === 3" 
                           x-transition:enter="transition ease-out duration-300 delay-100" 
                           x-transition:enter-start="opacity-0 translate-x-4" 
                           x-transition:enter-end="opacity-100 translate-x-0" 
                           class="space-y-8">
                          
                          {{-- ROW 1: Overview, Our Strengths & How it works --}}
                          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                              
                              {{-- KOLOM KIRI: Overview & Our Strengths (Lebar 7/12) --}}
                              <div class="lg:col-span-7 space-y-6 flex flex-col">
                                  {{-- 1. Penjelasan Project --}}
                                  <div class="bg-white p-6 sm:p-7 rounded-[1.5rem] border border-slate-200 shadow-sm relative overflow-hidden group hover:border-indigo-200 transition-colors flex-grow">
                                      <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -z-10 group-hover:scale-110 transition-transform"></div>
                                      <div class="flex items-center gap-3 mb-4">
                                          <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                              </svg>
                                          </div>
                                          <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Project Overview</h4>
                                      </div>
                                      <p class="text-slate-600 text-sm leading-relaxed font-medium text-justify" x-text="selectedService.overview"></p>
                                  </div>

                                  {{-- 2. Our Strengths --}}
                                  <div class="bg-slate-900 p-6 sm:p-7 rounded-[1.5rem] shadow-lg relative overflow-hidden group">
                                      <div class="absolute -right-4 -bottom-4 opacity-10">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                          </svg>
                                      </div>
                                      <div class="relative z-10">
                                          <div class="flex items-center gap-3 mb-3">
                                              <span class="flex h-3 w-3 relative">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
                                              </span>
                                              <h4 class="text-xs font-bold text-cyan-400 uppercase tracking-widest">Our Strengths</h4>
                                          </div>
                                          <p class="text-slate-300 text-sm leading-relaxed font-medium" x-text="selectedService.use_case"></p>
                                      </div>
                                  </div>
                              </div>

                              {{-- KOLOM KANAN: How it works --}}
                              <div class="lg:col-span-5">
                                  <div class="bg-slate-50 p-6 sm:p-7 rounded-[1.5rem] border border-slate-200 h-full">
                                      <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center gap-2">
                                          <i class="fa-solid fa-timeline text-slate-400"></i> How It Works
                                      </h4>
                                      {{-- UI Stepper Timeline --}}
                                      <div class="space-y-0 relative">
                                          <template x-for="(step, index) in selectedService.workflow" :key="index">
                                              <div class="relative flex items-start group">
                                                  <div class="absolute left-[13px] top-7 bottom-[-10px] w-[2px] bg-slate-200 group-last:hidden"></div>
                                                  <div class="flex flex-col items-center mr-4 relative z-10">
                                                      <div class="w-7 h-7 rounded-full bg-white border-2 border-slate-300 flex items-center justify-center shrink-0 text-[10px] font-bold text-slate-500 shadow-sm transition-colors group-hover:border-indigo-300 group-hover:text-indigo-600" x-text="index + 1"></div>
                                                  </div>
                                                  <div class="pb-6 pt-1">
                                                      <p class="text-xs font-bold text-slate-700 leading-snug group-hover:text-indigo-700 transition-colors" x-text="step"></p>
                                                  </div>
                                              </div>
                                          </template>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          {{-- ROW 2: Your Advantages (Full Width - Grid 3 Kolom) --}}
                          <div class="pt-2">
                              <div class="flex items-center gap-3 mb-5 ml-1">
                                  <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                      <i class="fa-solid fa-award text-sm"></i>
                                  </div>
                                  <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest">Your Advantages</h4>
                              </div>
                              
                              <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                  <template x-if="selectedService.outputs && selectedService.outputs.length > 0">
                                      <template x-for="output in selectedService.outputs" :key="output">
                                          <li class="flex items-start p-3.5 rounded-xl bg-white border border-slate-200 shadow-sm hover:border-emerald-200 hover:shadow-md transition-all group">
                                              <div class="w-5 h-5 rounded-md bg-emerald-50 flex items-center justify-center shrink-0 mr-3 mt-0.5 group-hover:bg-emerald-500 group-hover:text-white transition-colors text-emerald-500">
                                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                  </svg>
                                              </div>
                                              <span x-text="output" class="text-slate-700 font-semibold text-xs leading-relaxed"></span>
                                          </li>
                                      </template>
                                  </template>
                                  <template x-if="!selectedService.outputs || selectedService.outputs.length === 0">
                                      <li class="col-span-full italic text-slate-400 text-xs p-5 bg-white rounded-xl border border-slate-200 text-center">Spesifikasi keunggulan sedang dikonfigurasi.</li>
                                  </template>
                              </ul>
                          </div>
                      </div>
                  </div>

                  {{-- Modal Footer --}}
                  <div x-show="modalState === 3" class="p-6 border-t border-slate-100 bg-white shrink-0" style="display: none;">
                      <button @click.stop="$dispatch('open-meeting-modal'); closeModal()" 
                              class="w-full py-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm uppercase tracking-widest transition-colors shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2 group focus:outline-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                          </svg>
                          Let's Talk 
                      </button>
                  </div>
             </div>
        </div>

    </section>

    <x-slot name="pageScripts">
        <script>
            document.addEventListener('alpine:initializing', () => {
                Alpine.data('servicesEngine', () => ({
                    activeCatId: '{{ $activeCatId }}',
                    animate: false,
                    modalState: 0, 
                    
                    selectedService: { name: '', type: '', overview: '', use_case: '', workflow: [], outputs: [] },

                    switchCategory(catId) {
                        this.activeCatId = catId;
                        this.modalState = 0;
                    },

                    openCategories() {
                        this.modalState = 1;
                    },

                    selectCategoryInModal(catId) {
                        this.activeCatId = catId;
                        this.modalState = 2;
                    },

                    openMailModal(serviceData) {
                        this.selectedService = serviceData;
                        this.modalState = 3;
                    },

                    closeModal() {
                        this.modalState = 0;
                    },

                    goBack() {
                        if (this.modalState > 1) {
                            this.modalState--;
                        }
                    }
                }));
            });
        </script>
    </x-slot>

    <style>
        .fade-in-item { opacity: 0; transform: translateY(30px); transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
        .is-in-view .fade-in-item, .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes mail-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .animate-mail-float {
            animation: mail-float 3.5s ease-in-out infinite;
        }
    </style>
</x-public>