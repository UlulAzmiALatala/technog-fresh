<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-28">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" title="TechnoG Home">
                    <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-28 w-auto">
                </a>
            </div>
            
            <nav class="hidden sm:flex sm:space-x-8">
                <a href="{{ route('home') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('home') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Home</a>
                <a href="{{ route('public.services') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('public.services') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Services</a>
                
                {{-- [PERUBAHAN] Link "Our Works" dan "Our Process" digabung menjadi satu --}}
                <a href="{{ route('public.why-choose-us') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('public.why-choose-us') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Why Choose Us</a>
                
                <a href="{{ route('public.about') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('public.about') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">About Us</a>
                <a href="{{ route('public.blog') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('public.blog*') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Blog</a>
                <a href="{{ route('public.contact') }}" class="relative py-2 text-sm font-medium transition-colors duration-200 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-indigo-600 after:origin-left after:transition-transform after:duration-300 {{ request()->routeIs('public.contact') ? 'text-indigo-600 after:scale-x-100' : 'text-gray-500 hover:text-indigo-600 after:scale-x-0 hover:after:scale-x-100' }}">Contact</a>
            </nav>

            <div class="flex items-center">
                @if (Route::has('login'))
                    <div class="hidden sm:flex items-center space-x-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-indigo-600 transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition-colors">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <div class="sm:hidden ml-4">
                    <button @click="openMenu = !openMenu" class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': openMenu, 'inline-flex': ! openMenu }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': ! openMenu, 'inline-flex': openMenu }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div x-show="openMenu" x-transition class="sm:hidden bg-white shadow-lg border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Home</a>
            <a href="{{ route('public.services') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.services') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Services</a>
            
            {{-- [PERUBAHAN] Link "Our Works" dan "Our Process" digabung menjadi satu --}}
            <a href="{{ route('public.why-choose-us') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.why-choose-us') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Why Choose Us</a>
            
            <a href="{{ route('public.about') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.about') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">About Us</a>
            <a href="{{ route('public.blog') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.blog*') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Blog</a>
            <a href="{{ route('public.contact') }}" @click="openMenu = false" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('public.contact') ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }}">Contact</a>
            <div class="border-t border-gray-200 pt-4 mt-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</header>

