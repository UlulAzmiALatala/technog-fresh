<header x-data="{ openMenu: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-24">
            
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" title="TechnoG Home">
                    <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-24 w-auto">
                </a>
            </div>
            
            {{-- Navigasi Desktop --}}
            <nav class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ route('home') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('home') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Home</a>
                <a href="{{ route('public.services') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('public.services') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Services</a>
                <a href="{{ route('public.why-choose-us') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('public.why-choose-us') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Why Choose Us</a>
                <a href="{{ route('public.blog') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('public.blog*') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Blog</a>
                <a href="{{ route('public.about') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('public.about') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">About Us</a>
                <a href="{{ route('public.contact') }}" class="relative py-2 text-sm font-medium transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-indigo-600 after:origin-center after:transition-transform after:duration-300 {{ request()->routeIs('public.contact') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Contact</a>
            </nav>

            {{-- Tombol Auth & Hamburger --}}
            <div class="flex items-center">
                
                {{-- Tombol Auth Desktop --}}
                <div class="hidden lg:flex items-center space-x-2 ml-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-gray-700 bg-transparent border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-indigo-600 transition-all duration-300">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="flex items-center space-x-2 px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5">
                                <span>Register</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </a>
                        @endif
                    @endauth
                </div>
                
                {{-- Hamburger Button --}}
                <div class="lg:hidden ml-4">
                    <button @click="openMenu = !openMenu" class="p-2 rounded-md text-gray-500 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" :aria-expanded="openMenu.toString()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': openMenu, 'inline-flex': !openMenu }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !openMenu, 'inline-flex': openMenu }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div x-show="openMenu" id="mobile-menu" @click.away="openMenu = false" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="lg:hidden bg-white shadow-lg border-t border-gray-200" style="display: none;">
        
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('home') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Home</a>
            <a href="{{ route('public.services') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('public.services') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Services</a>
            <a href="{{ route('public.why-choose-us') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('public.why-choose-us') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Why Choose Us</a>
            <a href="{{ route('public.blog') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('public.blog*') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Blog</a>
            <a href="{{ route('public.about') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('public.about') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">About Us</a>
            <a href="{{ route('public.contact') }}" @click="openMenu = false" class="block pl-3 pr-4 py-3 text-base font-medium {{ request()->routeIs('public.contact') ? 'border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Contact</a>
        </div>
        
        <div class="border-t border-gray-200 pt-4 pb-3">
            @auth
                <div class="px-4">
                    <a href="{{ url('/dashboard') }}" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 rounded-md hover:bg-gray-100">Dashboard</a>
                </div>
            @else
                <div class="px-4 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 text-base font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 text-base font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Register</a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</header>