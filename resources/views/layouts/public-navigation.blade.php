{{-- Smart Header dengan pendeteksi Scroll --}}
<header x-data="{ openMenu: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'py-2 bg-white/95 shadow-[0_4px_30px_rgba(0,0,0,0.05)]' : 'py-4 bg-white/80'"
        class="fixed top-0 inset-x-0 z-[100] backdrop-blur-xl border-b border-gray-100 transition-all duration-500 ease-out">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between transition-all duration-500" :class="scrolled ? 'h-16' : 'h-20'">
            
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="block transform transition-transform hover:scale-105" title="TechnoG Solutions Logo">
                    <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" 
                         class="w-auto transition-all duration-500"
                         :class="scrolled ? 'h-10' : 'h-14'">
                </a>
            </div>
            
            {{-- Navigasi Desktop (SaaS Pill Style + Mega Menu) --}}
            <nav class="hidden lg:flex lg:items-center lg:space-x-1 relative">
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   Home
                </a>
                
                <a href="{{ route('public.about') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.about') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   About
                </a>
                
                {{-- MEGA MENU SERVICES --}}
                <div x-data="{ openServices: false }" 
                     @mouseenter="openServices = true" 
                     @mouseleave="openServices = false" 
                     class="relative py-2"> 
                    
                    <a href="{{ route('public.services') }}" 
                       class="flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.services') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                        Services
                        <i class="fa-solid fa-chevron-down text-[10px] opacity-70 transition-transform duration-300" :class="openServices ? 'rotate-180' : ''"></i>
                    </a>

                    {{-- Mega Menu Panel --}}
                    <div x-show="openServices"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                         class="absolute top-full left-1/2 transform -translate-x-1/2 mt-1 w-[750px] bg-white/95 backdrop-blur-3xl shadow-[0_40px_100px_rgba(0,0,0,0.12)] border border-gray-100 rounded-[2.5rem] overflow-hidden z-50 flex"
                         style="display: none;">
                         
                        {{-- Left Side: Highlight/Banner --}}
                        <div class="w-1/3 bg-gradient-to-br from-indigo-900 to-slate-900 p-8 text-white relative overflow-hidden flex flex-col justify-between">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)]"></div>
                            <div class="relative z-10">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 mb-4">
                                    <i class="fa-solid fa-bolt text-cyan-300"></i>
                                </div>
                                <h4 class="text-xl font-black tracking-tight mb-2">Enterprise Services</h4>
                                <p class="text-xs text-indigo-200 leading-relaxed font-medium opacity-90">
                                    Pioneering data-driven architectures and tailored digital ecosystems for absolute scalability.
                                </p>
                            </div>
                            <a href="{{ route('public.services') }}" class="relative z-10 mt-6 inline-flex items-center gap-2 text-xs font-bold text-cyan-300 hover:text-white transition-colors group">
                                View Full Catalog <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                        {{-- Right Side: Categories Grid (LINK TERINTEGRASI) --}}
                        <div class="w-2/3 p-6 bg-slate-50/50">
                            <div class="flex flex-col gap-2">
                                
                                {{-- Item 1: IT Solutions --}}
                                <a href="{{ route('public.services', ['category' => 'IT SOLUTION']) }}" class="group relative flex items-start gap-4 p-4 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.06)] border border-transparent hover:border-gray-100">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300 shadow-inner">
                                        <i class="fa-solid fa-network-wired text-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-extrabold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">IT Solutions</h5>
                                        <p class="text-xs text-gray-500 font-medium leading-relaxed">Robust software development, cloud infrastructure, and enterprise system integration.</p>
                                    </div>
                                </a>

                                {{-- Item 2: Statistical Solutions --}}
                                <a href="{{ route('public.services', ['category' => 'STATISTICAL SOLUTION']) }}" class="group relative flex items-start gap-4 p-4 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.06)] border border-transparent hover:border-gray-100">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                                        <i class="fa-solid fa-chart-pie text-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-extrabold text-gray-900 mb-1 group-hover:text-emerald-600 transition-colors">Statistical Solutions</h5>
                                        <p class="text-xs text-gray-500 font-medium leading-relaxed">Deep data analysis, predictive modeling, and absolute quantitative strategies.</p>
                                    </div>
                                </a>

                                {{-- Item 3: Hybrid Pathway --}}
                                <a href="{{ route('public.services', ['category' => 'HYBRID PATHWAY']) }}" class="group relative flex items-start gap-4 p-4 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.06)] border border-transparent hover:border-gray-100">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                                        <i class="fa-solid fa-infinity text-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-extrabold text-gray-900 mb-1 group-hover:text-cyan-600 transition-colors">Hybrid Pathway</h5>
                                        <p class="text-xs text-gray-500 font-medium leading-relaxed">The ultimate synergy of software engineering intelligence and statistical precision.</p>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('public.portfolio') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.portfolio*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   Case Studies
                </a>
                <a href="{{ route('public.why-choose-us') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.why-choose-us') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   Why Choose Us
                </a>
                <a href="{{ route('public.blog') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.blog*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   Blog
                </a>
                <a href="{{ route('public.contact') }}" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ request()->routeIs('public.contact') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-indigo-600' }}">
                   Contact
                </a>
            </nav>

            {{-- Tombol Auth & Hamburger --}}
            <div class="flex items-center">
                
                {{-- Tombol Auth Desktop --}}
                <div class="hidden lg:flex items-center gap-4 ml-2 pl-6 border-l border-gray-200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-gray-700 bg-gray-50 border border-gray-200 rounded-xl hover:bg-white hover:text-indigo-600 hover:border-indigo-200 hover:shadow-md transition-all duration-300">
                            <i class="fa-solid fa-layer-group text-gray-400 group-hover:text-indigo-500 transition-colors"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors duration-300 px-2">
                            Sign In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgba(99,102,241,0.25)] transition-all duration-300 hover:-translate-y-0.5">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative z-10">Get Started</span>
                                <i class="fa-solid fa-arrow-right relative z-10 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @endif
                    @endauth
                </div>
                
                {{-- Hamburger Button (Mobile) --}}
                <div class="lg:hidden ml-4 flex items-center">
                    <button @click="openMenu = !openMenu" 
                            class="relative w-11 h-11 bg-white shadow-sm rounded-xl border border-gray-200 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 focus:outline-none transition-all duration-300 flex items-center justify-center" 
                            aria-controls="mobile-menu" 
                            :aria-expanded="openMenu.toString()">
                        <span class="sr-only">Toggle menu</span>
                        <div class="w-5 h-5 flex flex-col justify-center items-center gap-1.5">
                            <span class="w-full h-0.5 bg-current rounded-full transform transition-all duration-300" :class="openMenu ? 'rotate-45 translate-y-2' : ''"></span>
                            <span class="w-full h-0.5 bg-current rounded-full transition-all duration-300" :class="openMenu ? 'opacity-0 translate-x-3' : ''"></span>
                            <span class="w-full h-0.5 bg-current rounded-full transform transition-all duration-300" :class="openMenu ? '-rotate-45 -translate-y-2' : ''"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Mobile (Floating Card Design) --}}
    <div x-show="openMenu" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95" 
         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95" 
         @click.away="openMenu = false"
         class="lg:hidden absolute top-full left-4 right-4 mt-2 bg-white/95 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 rounded-[2rem] overflow-y-auto max-h-[85vh]" 
         style="display: none;">
        
        <div class="p-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Home</a>
            <a href="{{ route('public.about') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('public.about') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">About Us</a>
            
            {{-- Mobile Accordion untuk Services --}}
            <div x-data="{ openSub: false }" class="rounded-xl overflow-hidden {{ request()->routeIs('public.services') ? 'bg-indigo-50' : 'hover:bg-gray-50' }}">
                <button @click="openSub = !openSub" class="w-full flex items-center justify-between px-5 py-3.5 text-base font-bold {{ request()->routeIs('public.services') ? 'text-indigo-600' : 'text-gray-600 hover:text-gray-900' }}">
                    <span>Services</span>
                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300" :class="openSub ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openSub" 
                     x-collapse 
                     class="px-5 pb-3 space-y-2">
                    <a href="{{ route('public.services', ['category' => 'IT SOLUTION']) }}" class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm hover:border-indigo-200 hover:text-indigo-600 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-network-wired text-xs"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-600">IT Solutions</span>
                    </a>
                    <a href="{{ route('public.services', ['category' => 'STATISTICAL SOLUTION']) }}" class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm hover:border-emerald-200 hover:text-emerald-600 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-chart-pie text-xs text-emerald-600 group-hover:text-white"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-emerald-600">Statistical Solutions</span>
                    </a>
                    <a href="{{ route('public.services', ['category' => 'HYBRID PATHWAY']) }}" class="flex items-center gap-3 p-3 rounded-lg bg-white border border-gray-100 shadow-sm hover:border-cyan-200 hover:text-cyan-600 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-cyan-50 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-infinity text-xs text-cyan-600 group-hover:text-white"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-700 group-hover:text-cyan-600">Hybrid Pathway</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('public.portfolio') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('public.portfolio*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Case Studies</a>
            <a href="{{ route('public.why-choose-us') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('public.why-choose-us') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Why Choose Us</a>
            <a href="{{ route('public.blog') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('public.blog*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Blog</a>
            <a href="{{ route('public.contact') }}" class="block px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('public.contact') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Contact</a>
        </div>
        
        <div class="p-5 bg-gray-50/80 border-t border-gray-100">
            @auth
                <a href="{{ url('/dashboard') }}" class="flex justify-center items-center w-full px-4 py-3.5 text-base font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-500/20 transition-all">
                    Go to Dashboard <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            @else
                <div class="flex flex-col gap-3">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex justify-center items-center w-full px-4 py-3.5 text-sm font-bold text-white bg-gray-900 rounded-xl shadow-[0_8px_20px_rgba(0,0,0,0.1)] hover:bg-indigo-600 transition-colors">
                            Get Started Free
                        </a>
                    @endif
                    <a href="{{ route('login') }}" class="flex justify-center items-center w-full px-4 py-3.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 shadow-sm transition-colors">
                        Sign In to Account
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>