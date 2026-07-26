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

    {{-- 2. FEATURED SERVICES (MODERN B2B ENTERPRISE CARD) --}}
    <section id="featured-services" class="bg-[#fafcff] py-32 overflow-hidden relative" x-data="{ animate: false }" x-intersect.once="animate = true">
        <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:24px_24px] opacity-80 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-16 transition-all duration-700 ease-out">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white border border-indigo-100 shadow-[0_4px_20px_rgba(79,70,229,0.1)] mb-6">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-500 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-600"></span>
                    </span>
                    <h2 class="text-xs font-black tracking-[0.25em] text-indigo-600 uppercase">Featured Services</h2>
                </div>
                <h3 class="mt-2 text-4xl font-black text-slate-900 tracking-tight sm:text-5xl">The Right Solutions for Your Needs</h3>
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 transition-all duration-700 ease-out">
                @forelse ($services as $index => $service)
                    <a href="{{ route('public.services') }}" 
                       class="group relative block bg-slate-900 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.08)] hover:shadow-[0_30px_60px_rgba(79,70,229,0.2)] overflow-hidden h-[28rem] transition-all duration-500 hover:-translate-y-3 border border-slate-200/50"
                       style="transition-delay: {{ $index * 150 }}ms;">
                        
                        <img alt="{{ $service->name }}" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x800/1e293b/FFFFFF?text=TechnoG' }}" 
                             class="absolute inset-0 h-full w-full object-cover opacity-50 transition-transform duration-700 ease-out group-hover:scale-110 group-hover:opacity-30" />
                        
                        <div class="absolute top-6 left-6 z-20 flex flex-col gap-2">
                            <span class="bg-indigo-600/90 text-white text-[10px] font-black px-4 py-1.5 rounded-full backdrop-blur-md shadow-sm uppercase tracking-widest border border-indigo-500/50 w-max shadow-[0_4px_10px_rgba(0,0,0,0.3)]">
                                {{ $service->category->name ?? 'Enterprise' }}
                            </span>
                            <span class="bg-white/95 text-slate-900 text-[10px] font-black px-4 py-1.5 rounded-full backdrop-blur-md shadow-sm uppercase tracking-widest w-max shadow-[0_4px_10px_rgba(0,0,0,0.3)]">
                                {{ $service->project_type ?? 'Digital Solution' }}
                            </span>
                        </div>

                        <div class="absolute top-6 right-6 z-20 bg-white/20 backdrop-blur-md text-white w-12 h-12 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0 border border-white/30 shadow-lg">
                            <i class="fa-solid fa-arrow-right -rotate-45 text-lg"></i>
                        </div>

                        <div class="absolute inset-0 p-8 flex flex-col justify-end bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent">
                            <div class="relative z-20 transform transition-transform duration-500 group-hover:-translate-y-2">
                                <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight mb-2 drop-shadow-lg [text-shadow:_0_2px_15px_rgb(0_0_0_/_100%)]">
                                    {{ $service->name }}
                                </h3>
                                
                                {{-- REVISI: Harga dihapus, diganti cuplikan deskripsi & Link CTA B2B --}}
                                <p class="text-sm text-slate-300 line-clamp-2 mt-3 font-medium leading-relaxed">
                                    {{ Str::limit(strip_tags($service->description ?? 'Solusi enterprise strategis untuk menunjang operasional perusahaan Anda.'), 100) }}
                                </p>
                                <div class="flex items-center gap-2 mt-6 text-cyan-400 text-xs font-black uppercase tracking-widest group-hover:text-cyan-300 transition-colors">
                                    View Enterprise Specs <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-3 text-center text-slate-500 bg-white p-12 rounded-[2rem] border border-dashed border-slate-300 font-medium">Featured services will be displayed soon.</p>
                @endforelse
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'" class="mt-16 text-center transition-all duration-700 ease-out">
                <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-8 py-4 text-sm font-black tracking-widest uppercase rounded-2xl text-indigo-600 bg-white border border-indigo-100 shadow-[0_8px_30px_rgba(79,70,229,0.1)] hover:bg-indigo-50 hover:shadow-[0_15px_40px_rgba(79,70,229,0.2)] transition-all transform hover:-translate-y-1 group">
                    <span>View All Catalog</span>
                    <i class="fa-solid fa-arrow-right ml-3 transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 3. SUCCESS STORIES SHOWCASE --}}
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
                
                // Animasi Text Hero
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

            });
        </script>
    </x-slot>

    {{-- [WAJIB] CSS --}}
    <style>
        [x-cloak] { display: none !important; }
        .fade-in-item { opacity: 0; transform: translateY(30px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .is-in-view .fade-in-item, .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .is-in-view .fade-in-item:nth-child(3) { transition-delay: 0.3s; }
    </style>

</x-public>