<x-public>

    {{-- Slot untuk menambahkan library JS spesifik ke <head> --}}
    <x-slot name="scripts">
        <script defer src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    {{-- 1. HERO SECTION (Cybernetic Particles & Text Scramble) --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden bg-slate-900 min-h-screen flex items-center justify-center">
            
            {{-- Lapisan 0: Glowing Neon Orbs di latar belakang gelap --}}
            <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-indigo-600/30 rounded-full blur-[150px] -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-cyan-600/30 rounded-full blur-[150px] -translate-y-1/2 pointer-events-none"></div>
            
            {{-- Lapisan 1: Latar Belakang Partikel --}}
            <div id="particles-js" class="absolute inset-0 z-10 opacity-60"></div>

            {{-- Lapisan 2: Gradien dasar penghalus --}}
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-900/50 to-slate-900 z-20"></div>
            
            {{-- Lapisan 3: Konten Utama dengan Mouse Parallax --}}
            <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-30 pt-32 sm:pt-40 pb-16">
                
                <div x-data="{ x: 0, y: 0, animate: false }"
                     x-init="setTimeout(() => animate = true, 100)"
                     @mousemove.window="x = $event.clientX; y = $event.clientY"
                     :style="`transform: translate(${ (window.innerWidth / 2 - x) * 0.015 }px, ${ (window.innerHeight / 2 - y) * 0.015 }px)`"
                     class="text-center max-w-4xl mx-auto transition-all duration-300 ease-out">

                    {{-- Text Scramble Title --}}
                    <h1 class="text-4xl sm:text-6xl lg:text-[5rem] font-extrabold tracking-tight transition-all duration-1000 ease-out leading-[1.1]"
                        :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        <span x-data="textScramble('Intelligent Technology,')" x-html="displayText" class="block text-white"></span>
                        <span x-data="textScramble('Powered by Data')" x-html="displayText" class="mt-2 block bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 via-indigo-400 to-indigo-500 pb-4"></span>
                    </h1>
                    
                    {{-- Subtitle --}}
                    <p class="mt-8 max-w-2xl mx-auto text-lg sm:text-xl text-indigo-100/80 transition-all duration-1000 ease-out delay-200 font-light leading-relaxed"
                       :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        We build advanced technology solutions on a strong foundation of statistical analysis, ensuring every decision and product delivers maximum accuracy and impact.
                    </p>

                    {{-- Modern CTA Buttons --}}
                    <div class="mt-12 flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6 transition-all duration-1000 ease-out delay-300"
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        
                        <a href="{{ route('public.services') }}" class="group w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-indigo-600 font-bold rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.4)] text-white hover:bg-indigo-500 hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] transition-all duration-300 transform hover:-translate-y-1 border border-indigo-500">
                            Explore Services <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        
                        <a href="{{ route('public.why-choose-us') }}" class="group w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-white/5 border border-white/20 font-bold rounded-xl text-white hover:bg-white/10 hover:border-white/40 transition-all duration-300 backdrop-blur-md transform hover:-translate-y-1">
                            Why Choose Us?
                        </a>
                    </div>
                </div>

            </div>

            {{-- Scroll Indicator Down --}}
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-30 animate-bounce">
                <i class="fa-solid fa-chevron-down text-white/50 fa-lg"></i>
            </div>
        </section>
    </x-slot>

    {{-- 2. FEATURED SERVICES (Dark Cinematic Cards) --}}
    <section id="featured-services" class="bg-gray-50 py-32 overflow-hidden relative" x-data="{ animate: false }" x-intersect.once="animate = true">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-sm font-bold text-indigo-600 tracking-[0.2em] uppercase">Featured Services</h2>
                <h3 class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">The Right Solutions for Your Needs</h3>
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 transition-all duration-700 ease-out">
                @forelse ($services as $index => $service)
                    <a href="{{ route('public.services') }}" 
                       class="group relative block bg-gray-900 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:shadow-[0_20px_40px_rgba(99,102,241,0.2)] overflow-hidden h-[26rem] transition-all duration-500 hover:-translate-y-2 border border-gray-200/50"
                       style="transition-delay: {{ $index * 150 }}ms;">
                        
                        <img alt="{{ $service->name }}" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x800/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover opacity-60 transition-transform duration-700 ease-out group-hover:scale-110 group-hover:opacity-40" />
                        
                        @if($service->package_plan)
                            <div class="absolute top-5 left-5 z-20">
                                <span class="bg-white/90 text-indigo-700 text-xs font-extrabold px-4 py-1.5 rounded-full backdrop-blur-md shadow-sm uppercase tracking-wider">
                                    {{ $service->package_plan }}
                                </span>
                            </div>
                        @endif

                        <div class="absolute top-5 right-5 z-20 bg-white/20 backdrop-blur-md text-white w-10 h-10 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 border border-white/30">
                            <i class="fa-solid fa-arrow-right -rotate-45"></i>
                        </div>

                        <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-end bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent">
                            <div class="relative z-20 transform transition-transform duration-500 group-hover:-translate-y-2">
                                <h3 class="text-2xl font-bold text-white leading-tight mb-2">{{ $service->name }}</h3>
                                <div class="flex items-center gap-1 mt-4 border-t border-white/20 pt-4">
                                    <span class="text-indigo-400 font-bold text-sm">$</span>
                                    <span class="text-2xl font-extrabold text-white tracking-tight">{{ number_format($service->price, 0, '.', ',') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-3 text-center text-gray-500 bg-white p-12 rounded-[2rem] border border-dashed border-gray-300">Featured services will be displayed soon.</p>
                @endforelse
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'" class="mt-16 text-center transition-all duration-700 ease-out">
                <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold rounded-xl text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors group">
                    <span>View all services</span>
                    <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 3. SUCCESS STORIES SHOWCASE (Portfolio) --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-32 bg-white relative overflow-hidden border-t border-gray-100">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-50/80 rounded-full blur-[100px] pointer-events-none -translate-y-1/2 translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-sm font-bold text-indigo-600 tracking-[0.2em] uppercase">Success Stories</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Our Featured Portfolio</p>
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="grid gap-10 lg:grid-cols-2 transition-all duration-700 ease-out">
                @forelse ($caseStudies as $index => $caseStudy)
                    <div class="group bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] border border-gray-100 overflow-hidden transform hover:-translate-y-2 transition-all duration-500 p-4 flex flex-col"
                         style="transition-delay: {{ $index * 150 }}ms;">
                        <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}" class="block flex-grow flex flex-col">
                            <div class="relative h-72 sm:h-80 overflow-hidden rounded-[2rem] shrink-0">
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                <div class="absolute top-5 left-5 z-20">
                                    <span class="px-4 py-2 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-extrabold uppercase tracking-wider text-indigo-700 shadow-sm border border-white/50">
                                        {{ $caseStudy->category->name ?? 'Case Study' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6 mt-2 flex flex-col flex-grow">
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight line-clamp-2">
                                    {{ $caseStudy->title }}
                                </h3>
                                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center text-sm font-bold text-indigo-600 uppercase tracking-wide shrink-0">
                                    Read Full Story <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="lg:col-span-2 text-center text-gray-500 bg-gray-50 p-12 rounded-[2.5rem] border border-dashed border-gray-300">Featured case studies will be displayed soon.</p>
                @endforelse
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'" class="mt-16 text-center transition-all duration-700 ease-out">
                <a href="{{ route('public.portfolio') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold rounded-xl text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors group">
                    <span>Explore full portfolio</span>
                    <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 4. LATEST BLOG POSTS --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-32 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-sm font-bold text-indigo-600 tracking-[0.2em] uppercase">Blog</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Insights & Latest News</p>
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 transition-all duration-700 ease-out">
                @forelse ($posts as $index => $post)
                    <article class="group bg-white rounded-[2rem] p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 ease-out hover:shadow-[0_20px_40px_rgba(99,102,241,0.1)] hover:-translate-y-2 border border-gray-100 flex flex-col h-full"
                             style="transition-delay: {{ $index * 150 }}ms;">
                        
                        <a href="{{ route('public.blog.show', $post->slug) }}" class="block relative overflow-hidden rounded-[1.5rem] shrink-0">
                            <div class="absolute top-4 left-4 z-20">
                                <span class="px-4 py-1.5 rounded-full bg-white/90 backdrop-blur-md text-indigo-700 text-xs font-bold uppercase tracking-wider shadow-sm border border-white/50">
                                    {{ $post->category->name ?? 'Article' }}
                                </span>
                            </div>
                            <div class="relative h-56 w-full bg-gray-200 overflow-hidden">
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out" 
                                     src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/800x600/e2e8f0/cbd5e0?text=TechnoG' }}" 
                                     alt="{{ $post->title }}">
                            </div>
                        </a>
                        
                        <div class="mt-6 px-4 flex flex-col flex-grow">
                            <a href="{{ route('public.blog.show', $post->slug) }}" class="block">
                                <h2 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight line-clamp-2">
                                    {{ $post->title }}
                                </h2>
                            </a>
                            <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500 font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar-days text-indigo-400"></i>
                                    <span>{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-3 text-center text-gray-500 bg-white p-12 rounded-[2rem] border border-dashed border-gray-300">The latest articles will be displayed soon.</p>
                @endforelse
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'" class="mt-16 text-center transition-all duration-700 ease-out">
                <a href="{{ route('public.blog') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold rounded-xl text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors group">
                    <span>Read all articles</span>
                    <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 5. FINAL CTA (Dark Space Theme) --}}
    <section class="py-24 relative overflow-hidden bg-slate-900" x-data x-intersect.once="$el.classList.add('is-in-view')">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-indigo-600/30 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
            <h2 class="fade-in-item text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                <span class="block">Have a Project in Mind?</span>
                <span class="block bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-indigo-400 mt-2">Let's Build It Together.</span>
            </h2>
            <p class="fade-in-item text-lg text-indigo-200 mb-12 max-w-2xl mx-auto font-light">
                Unlock the true potential of your business with our customized, data-driven IT solutions.
            </p>
            <div class="fade-in-item flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-10 py-4 text-base font-bold rounded-xl text-gray-900 bg-white hover:bg-gray-100 hover:scale-105 shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-300">
                    Contact Us Today <i class="fa-solid fa-paper-plane ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 6. SMART WELCOME POP-UP (Let's Meet & Form) --}}
    <div x-data="welcomePopup()" x-init="initPopup()" class="relative z-[100]">
        
        <!-- FLOATING BUTTON -->
        <button @click="openManual()" 
                x-show="!isOpen"
                x-transition:enter="ease-out duration-500 delay-500" 
                x-transition:enter-start="opacity-0 translate-y-8" 
                x-transition:enter-end="opacity-100 translate-y-0"
                class="fixed bottom-8 right-8 z-50 group flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-600 text-white rounded-full shadow-[0_8px_30px_rgba(79,70,229,0.5)] hover:shadow-[0_10px_40px_rgba(79,70,229,0.8)] transition-all duration-300 hover:-translate-y-1 focus:outline-none overflow-hidden border border-indigo-400/50">
            
            <div class="absolute inset-0 w-full h-full bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 ease-out skew-x-[30deg]"></div>

            <span class="relative flex h-3 w-3 z-10">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-white shadow-[0_0_10px_#fff]"></span>
            </span>
            <span class="font-extrabold text-sm tracking-wide relative z-10 drop-shadow-md">Let's Meet</span>
            
            {{-- SVG Ikon Kalender --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:rotate-12 group-hover:scale-110 transition-all duration-300 relative z-10 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </button>

        <!-- Backdrop Blur -->
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-500" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-950/80 backdrop-blur-md"
             style="display: none;">
        </div>

        <!-- Modal Content -->
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-500" 
             x-transition:enter-start="opacity-0 translate-y-8 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 scale-95" 
             class="fixed inset-0 flex items-center justify-center p-4"
             style="display: none;">
            
            <!-- Glassmorphism Card -->
            <div @click.away="closePopup()" class="relative w-full max-w-lg bg-white/5 border border-white/10 rounded-[2.5rem] shadow-2xl p-8 sm:p-10 backdrop-blur-2xl overflow-hidden transition-all duration-300 ease-in-out">
                
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-cyan-500/20 rounded-full blur-3xl"></div>

                {{-- TOMBOL CLOSE (X) DENGAN SVG --}}
                <button @click="closePopup()" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-white/20 text-white/50 hover:text-white border border-white/10 rounded-full transition-all duration-300 z-50 focus:outline-none group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- KONTEN 1: Sambutan -->
                <div x-show="!showForm" 
                     x-transition:enter="ease-out duration-500 delay-100" 
                     x-transition:enter-start="opacity-0 -translate-x-8" 
                     x-transition:enter-end="opacity-100 translate-x-0" 
                     class="relative z-10 text-center">
                    
                    {{-- IKON DISKUSI (REPLACE HANDSHAKE) DENGAN SVG --}}
                    <div class="w-20 h-20 bg-indigo-600/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Let's Meet!</h2>
                    <p class="text-indigo-100/70 mb-8 text-base leading-relaxed">
                        Punya ide project brilian? Mari jadwalkan sesi diskusi (Online / Tatap Muka) bersama tim expert <strong>TechnoG Solutions</strong>.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="button" @click="showForm = true" class="flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/25 focus:outline-none">
                            Jadwalkan Meeting 
                            {{-- SVG Ikon Panah Kanan --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- KONTEN 2: Form Input -->
                <div x-show="showForm" 
                     x-transition:enter="ease-out duration-500 delay-100" 
                     x-transition:enter-start="opacity-0 translate-x-8" 
                     x-transition:enter-end="opacity-100 translate-x-0" 
                     class="relative z-10" 
                     style="display: none;">
                    
                    <div class="flex items-center mb-6">
                        {{-- TOMBOL BACK (KEMBALI) DENGAN SVG --}}
                        <button type="button" @click="showForm = false" class="w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-white/20 text-white/50 hover:text-white border border-white/10 rounded-full transition-all duration-300 mr-4 focus:outline-none group">
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
                            {{-- SVG Ikon Kirim/Paper Plane --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform -rotate-45 relative bottom-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Initialization --}}
    <x-slot name="pageScripts">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (document.getElementById('particles-js')) {
                    particlesJS("particles-js", {
                        "particles": { "number": { "value": 100, "density": { "enable": true, "value_area": 800 } }, "color": { "value": "#ffffff" }, "shape": { "type": "circle" }, "opacity": { "value": 0.5, "random": true }, "size": { "value": 3, "random": true }, "line_linked": { "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1 }, "move": { "enable": true, "speed": 3, "direction": "none", "random": true, "straight": false, "out_mode": "out" } },
                        "interactivity": { "detect_on": "canvas", "events": { "onhover": { "enable": true, "mode": "repulse" }, "onclick": { "enable": true, "mode": "push" }, "resize": true }, "modes": { "repulse": { "distance": 100, "duration": 0.4 }, "push": { "particles_nb": 4 } } },
                        "retina_detect": true
                    });
                }
            });
        </script>
        <script>
            document.addEventListener('alpine:initializing', () => {
                Alpine.data('textScramble', (originalText) => ({
                    originalText: originalText, displayText: '', alphabet: '!<>-_\\/[]{}—=+*^?#________', intervalId: null,
                    init() {
                        let frame = 0; let queue = [];
                        for (let i = 0; i < this.originalText.length; i++) {
                            const from = this.originalText[i]; const to = this.originalText[i]; const start = Math.floor(Math.random() * 40); const end = start + Math.floor(Math.random() * 40);
                            queue.push({ from, to, start, end });
                        }
                        this.intervalId = setInterval(() => {
                            let output = '';
                            for (let i = 0; i < queue.length; i++) {
                                let { from, to, start, end, char } = queue[i];
                                if (frame >= end) { output += to; } 
                                else if (frame >= start) {
                                    if (!char || Math.random() < 0.28) { char = this.alphabet[Math.floor(Math.random() * this.alphabet.length)]; queue[i].char = char; }
                                    output += `<span class="opacity-50 text-cyan-400">${char}</span>`;
                                } else { output += ''; }
                            }
                            this.displayText = output;
                            if (frame >= Math.max(...queue.length > 0 ? queue.map(q => q.end) : [0])) { clearInterval(this.intervalId); }
                            frame++;
                        }, 40);
                    }
                }));

                // Smart Welcome Popup Logic
                Alpine.data('welcomePopup', () => ({
                    isOpen: false,
                    showForm: false, // Menambahkan state form
                    
                    initPopup() {
                        // Ambil waktu terakhir pengunjung melihat pop-up
                        const lastSeen = localStorage.getItem('technog_popup_time');
                        const now = new Date().getTime();
                        
                        // Set masa tunggu (cooldown): 1 jam dalam milidetik
                        // (1 jam * 60 menit * 60 detik * 1000 ms)
                        const cooldownPeriod = 1 * 60 * 60 * 1000; 

                        // Munculkan otomatis jika belum pernah lihat, ATAU jika sudah lewat 1 jam
                        if (!lastSeen || (now - lastSeen > cooldownPeriod)) {
                            setTimeout(() => {
                                this.isOpen = true;
                            }, 3500); 
                        }
                    },
                    
                    // Fungsi baru untuk buka lewat tombol floating
                    openManual() {
                        this.isOpen = true;
                    },

                    closePopup() {
                        this.isOpen = false;
                        // Kembalikan form ke layar utama setelah pop-up tertutup
                        setTimeout(() => { this.showForm = false; }, 500); 
                        
                        // Simpan waktu saat ini (jam/tanggal dia menutup pop-up)
                        localStorage.setItem('technog_popup_time', new Date().getTime());
                    }
                }));
            });
        </script>
    </x-slot>

    {{-- [WAJIB] CSS untuk Efek Fade In --}}
    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .is-in-view .fade-in-item,
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .is-in-view .fade-in-item:nth-child(3) { transition-delay: 0.3s; }
    </style>

</x-public>