<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'TechnoG Solutions - Data-Driven Technology' }}</title>

    {{-- Favicon Links --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Slot untuk library tambahan (misal: particles.js) --}}
    {{ $scripts ?? '' }}

    {{-- CSS untuk Preloader --}}
    <style>
        #preloader {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #f9fafb; z-index: 9999; display: flex;
            justify-content: center; align-items: center; flex-direction: column;
            gap: 1.5rem; opacity: 1; transition: opacity 0.75s ease, visibility 0.75s ease;
        }
        #preloader.hidden { opacity: 0; visibility: hidden; }
        @media (prefers-color-scheme: dark) {
            #preloader { background-color: #111827; }
            #preloader .preloader-text { color: #9ca3af; }
        }
        .node-network { position: relative; width: 120px; height: 120px; }
        .node {
            width: 12px; height: 12px; background-color: #4f46e5;
            border-radius: 50%; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: move-and-connect 4s ease-in-out infinite; opacity: 0;
        }
        .node:nth-child(1) { animation-delay: 0s; } .node:nth-child(2) { animation-delay: -0.8s; }
        .node:nth-child(3) { animation-delay: -1.6s; } .node:nth-child(4) { animation-delay: -2.4s; }
        .node:nth-child(5) { animation-delay: -3.2s; }
        .preloader-text { font-size: 0.875rem; color: #6b7280; font-family: 'Figtree', sans-serif; letter-spacing: 0.05em; text-transform: uppercase; }
        @keyframes move-and-connect {
            0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
            25% { transform: translate(-100%, -100%) scale(1.2); opacity: 1; }
            50% { transform: translate(0, 50%) scale(0.7); opacity: 1; }
            75% { transform: translate(100%, -100%) scale(1); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
        }
        @keyframes gradient-x { 
            0%, 100% { background-position: 0% 50%; } 
            50% { background-position: 100% 50%; } 
        }
    </style>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-900 overflow-x-hidden">

    <div id="preloader">
        <div class="node-network">
            <div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div>
        </div>
        <p class="preloader-text">Processing Data...</p>
    </div>

    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')
        
        <main>
            {{ $hero ?? '' }}
            {{ $slot }}
        </main>

        @include('layouts.public-footer')
    </div>

    {{-- ================================================================= --}}
    {{-- WAPPER UTAMA ALPINE JS (AGAR STATE SALING TERHUBUNG)              --}}
    {{-- ================================================================= --}}
    <div x-data="globalWidget()" x-init="initWidget()"
         @scroll.window="scrolled = (window.pageYOffset > 300)"
         @open-meeting-modal.window="openPopup()">
        
        {{-- ================================================================= --}}
        {{-- CONTAINER 1: TOMBOL MENGAMBANG (Z-INDEX NORMAL)                   --}}
        {{-- ================================================================= --}}
        <div class="fixed bottom-8 right-6 sm:right-8 z-50 flex items-center justify-end pointer-events-none">
            
            <div class="relative flex items-center p-1.5 bg-[#0f172a]/80 backdrop-blur-2xl border border-white/10 rounded-full shadow-[0_10px_40px_rgba(0,0,0,0.4)] transition-all duration-500 ease-out hover:border-indigo-500/40 hover:shadow-[0_15px_50px_rgba(79,70,229,0.3)] hover:-translate-y-1 pointer-events-auto">
                
                {{-- Cahaya berpendar (Outer Glow) di belakang widget --}}
                <div class="absolute inset-0 bg-indigo-500/20 rounded-full blur-xl pointer-events-none transition-all duration-700 ease-out" 
                     :class="scrolled ? 'scale-125 opacity-100' : 'scale-100 opacity-60'"></div>

                {{-- TOMBOL LET'S MEET (HANYA MUNCUL JIKA DI HALAMAN HOME & SAAT SCROLL) --}}
                <button x-show="isHome && scrolled" 
                        style="display: none;"
                        @click="openPopup()" 
                        class="group relative flex items-center gap-2.5 sm:gap-3 px-5 sm:px-6 py-3 sm:py-3.5 bg-[linear-gradient(110deg,#4f46e5,45%,#6366f1,55%,#4f46e5)] bg-[length:200%_100%] hover:animate-[gradient-x_2s_linear_infinite] text-white rounded-full overflow-hidden transition-all duration-300 shadow-inner focus:outline-none">
                    
                    {{-- Efek radar hijau/cyan yang futuristik --}}
                    <span class="relative flex h-2.5 w-2.5 z-10 shrink-0">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-300 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-400 shadow-[0_0_8px_#22d3ee]"></span>
                    </span>
                    
                    <span class="font-extrabold text-sm tracking-widest uppercase relative z-10 drop-shadow-md whitespace-nowrap">Let's Meet</span>
                    
                    {{-- SVG Ikon Kalender --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 relative z-10 group-hover:rotate-12 group-hover:scale-110 transition-transform drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </button>

                {{-- SECTION TOMBOL BACK TO TOP (MUNCUL DENGAN ANIMASI LEBAR) --}}
                <div x-show="scrolled"
                     x-transition:enter="transition-all ease-out duration-500"
                     x-transition:enter-start="opacity-0 w-0 -translate-x-4 scale-95"
                     x-transition:enter-end="opacity-100 w-[52px] sm:w-[60px] translate-x-0 scale-100"
                     x-transition:leave="transition-all ease-in duration-300"
                     x-transition:leave-start="opacity-100 w-[52px] sm:w-[60px] translate-x-0 scale-100"
                     x-transition:leave-end="opacity-0 w-0 -translate-x-4 scale-95"
                     class="flex items-center justify-end overflow-hidden shrink-0 origin-left"
                     style="display: none;">
                    
                    {{-- Garis Pembatas (Hanya muncul jika tombol Let's Meet juga muncul) --}}
                    <div x-show="isHome" class="w-px h-6 bg-white/20 mx-1 sm:mx-2 shrink-0"></div>
                    
                    {{-- Tombol Up --}}
                    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                            class="w-10 h-10 sm:w-11 sm:h-11 flex shrink-0 items-center justify-center bg-white/5 hover:bg-white/15 text-slate-300 hover:text-white rounded-full transition-all duration-300 group focus:outline-none"
                            title="Back to Top">
                        {{-- SVG Ikon Panah Atas Asli (Anti-Bug) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-5 sm:w-5 group-hover:-translate-y-1 transition-transform duration-300 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- CONTAINER 2: MODAL POP-UP (Z-INDEX SANGAT TINGGI AGAR MENUTUPI HEADER) --}}
        {{-- ================================================================= --}}

        {{-- Backdrop Blur dengan Z-Index 9998 --}}
        <div x-show="isModalOpen" 
             x-transition:enter="ease-out duration-500" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 w-full h-full bg-slate-950/70 backdrop-blur-2xl z-[9998]"
             style="display: none;">
        </div>

        {{-- Konten Modal dengan Z-Index 9999 --}}
        <div x-show="isModalOpen" 
             x-transition:enter="ease-out duration-500" 
             x-transition:enter-start="opacity-0 translate-y-8 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 scale-95" 
             class="fixed inset-0 flex items-center justify-center p-4 z-[9999]"
             style="display: none;">
            
            <div @click.away="closePopup()" class="relative w-full max-w-lg bg-white/5 border border-white/10 rounded-[2.5rem] shadow-2xl p-8 sm:p-10 backdrop-blur-2xl overflow-hidden transition-all duration-300 ease-in-out">
                
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <button @click="closePopup()" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-white/20 text-white/50 hover:text-white border border-white/10 rounded-full transition-all duration-300 z-50 focus:outline-none group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div x-show="step === 1" 
                     x-transition:enter="ease-out duration-500 delay-100" 
                     x-transition:enter-start="opacity-0 -translate-x-8" 
                     x-transition:enter-end="opacity-100 translate-x-0" 
                     class="relative z-10 text-center"
                     style="display: none;">
                    
                    <div class="w-20 h-20 bg-[linear-gradient(135deg,#0ea5e9,#0284c7)] rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-cyan-500/30 border border-cyan-400/50">
                        <i class="fa-solid fa-rocket text-4xl text-white drop-shadow-md"></i>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Welcome to TechnoG</h2>
                    <p class="text-indigo-100/80 mb-8 text-base leading-relaxed">
                        Mitra teknologi terpercaya untuk <strong>Enterprise & Digital Business</strong> Anda. Temukan solusi berbasis data yang akan meroketkan efisiensi perusahaan Anda.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="button" @click="step = 2" class="flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-100 text-gray-900 text-sm font-black tracking-widest uppercase rounded-xl transition-all shadow-[0_0_20px_rgba(255,255,255,0.2)] focus:outline-none">
                            Eksplorasi Solusi
                            <i class="fa-solid fa-arrow-right ml-3"></i>
                        </button>
                    </div>
                </div>

                <div x-show="step === 2" 
                     x-transition:enter="ease-out duration-500 delay-100" 
                     x-transition:enter-start="opacity-0 translate-x-8" 
                     x-transition:enter-end="opacity-100 translate-x-0" 
                     class="relative z-10 text-center"
                     style="display: none;">
                    
                    <div class="w-20 h-20 bg-indigo-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Talking with Us!</h2>
                    <p class="text-indigo-100/70 mb-8 text-base leading-relaxed">
                        Punya ide project brilian? Mari jadwalkan sesi diskusi (Online / Tatap Muka) bersama tim expert <strong>TechnoG Solutions</strong>.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="button" @click="step = 3" class="flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 focus:outline-none">
                            Jadwalkan Meeting 
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="step === 3" 
                     x-transition:enter="ease-out duration-500 delay-100" 
                     x-transition:enter-start="opacity-0 translate-x-8" 
                     x-transition:enter-end="opacity-100 translate-x-0" 
                     class="relative z-10" 
                     style="display: none;">
                    
                    <div class="flex items-center mb-6">
                        <button type="button" @click="step = 2" class="w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-white/20 text-white/50 hover:text-white border border-white/10 rounded-full transition-all duration-300 mr-4 focus:outline-none group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>
                        <h3 class="text-xl font-bold text-white">Detail Meeting</h3>
                    </div>

                    <form action="{{ route('public.meeting.request') }}" method="POST" class="space-y-4 text-left">
                        @csrf
                        <div>
                            <label class="block text-xs text-white/70 mb-1 ml-1">Nama / Perusahaan</label>
                            <input type="text" name="name" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Misal: PT. Agung Perkasa">
                        </div>
                        <div>
                            <label class="block text-xs text-white/70 mb-1 ml-1">WhatsApp / Email</label>
                            <input type="text" name="contact" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="0812xxxx / email@domain.com">
                        </div>
                        <div>
                            <label class="block text-xs text-white/70 mb-1 ml-1">Preferensi Meeting</label>
                            <select name="meeting_type" required class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-indigo-500 focus:ring-indigo-500 transition-colors appearance-none">
                                <option value="Online (Zoom / GMeet)" class="text-gray-900">Online (Zoom / Google Meet)</option>
                                <option value="Offline (Tatap Muka)" class="text-gray-900">Offline (Tatap Muka - Yogyakarta)</option>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-white/70 mb-1 ml-1">Tanggal</label>
                                <input type="date" name="meeting_date" required style="color-scheme: dark;" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:ring-indigo-500 transition-colors appearance-none">
                            </div>
                            <div>
                                <label class="block text-xs text-white/70 mb-1 ml-1">Jam</label>
                                <input type="time" name="meeting_time" required style="color-scheme: dark;" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:ring-indigo-500 transition-colors appearance-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs text-white/70 mb-1 ml-1">Topik Singkat</label>
                            <textarea name="topic" rows="2" class="w-full bg-black/20 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Misal: Pembuatan web logistics..."></textarea>
                        </div>
                        
                        <button type="submit" class="w-full flex items-center justify-center py-4 mt-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25">
                            Kirim Permintaan 
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform -rotate-45 relative bottom-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div> {{-- End Wrapper Utama Alpine JS --}}

    {{-- Notifikasi Sukses Global (Di luar Wrapper Modal agar tidak terpengaruh z-index) --}}
    @if(session('success_meeting'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-10"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-10"
             class="fixed top-10 sm:top-24 right-4 sm:right-10 z-[200] max-w-sm w-full bg-white/90 backdrop-blur-xl border border-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[1.5rem] p-4 flex items-start gap-4">
            <div class="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center border border-emerald-100 shrink-0 mt-0.5">
                <i class="fa-solid fa-check text-emerald-500 text-lg"></i>
            </div>
            <div class="flex-1 pt-1">
                <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-widest mb-1">Berhasil!</h4>
                <p class="text-sm text-slate-600 font-medium">{{ session('success_meeting') }}</p>
            </div>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600 pt-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
    @endif

    <script>
        // Preloader script
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('hidden');
                setTimeout(() => { preloader.style.display = 'none'; }, 800);
            }
        });

        // Global Widget Logic Alpine.js (Scroll & Modal)
        document.addEventListener('alpine:initializing', () => {
            Alpine.data('globalWidget', () => ({
                scrolled: false,
                isModalOpen: false,
                step: 1, // 1: Welcome Pop-up, 2: Let's Meet Greeting, 3: Form
                
                // Deteksi otomatis apakah user sedang berada di halaman Home ("/")
                isHome: {{ request()->is('/') ? 'true' : 'false' }},
                
                initWidget() {
                    // Auto Pop-up HANYA berjalan jika user ada di halaman utama (Home)
                    if (this.isHome && !window.location.search.includes('error')) {
                        const lastSeen = localStorage.getItem('technog_popup_time');
                        const now = new Date().getTime();
                        const cooldownPeriod = 1 * 60 * 60 * 1000; 

                        if (!lastSeen || (now - lastSeen > cooldownPeriod)) {
                            setTimeout(() => { 
                                this.step = 1; // Mulai dari pop-up tambahan
                                this.isModalOpen = true; 
                            }, 3500); 
                        }
                    }
                },
                
                openPopup() {
                    // Jika user klik manual dari tombol, langsung buka Step 2 (Greeting Meeting)
                    this.step = 2; 
                    this.isModalOpen = true;
                },

                closePopup() {
                    this.isModalOpen = false;
                    setTimeout(() => { this.step = 1; }, 500); 
                    localStorage.setItem('technog_popup_time', new Date().getTime());
                }
            }));
        });
    </script>
    
    {{-- Slot untuk skrip spesifik halaman --}}
    {{ $pageScripts ?? '' }}
</body>
</html>