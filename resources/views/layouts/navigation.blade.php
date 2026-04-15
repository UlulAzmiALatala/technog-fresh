{{-- Smart Header dengan pendeteksi Scroll (Khusus Dashboard) --}}
<header x-data="{ openMenu: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 10)"
        :class="scrolled ? 'bg-white/95 shadow-[0_4px_20px_rgba(0,0,0,0.05)] py-1' : 'bg-white/80 py-3'"
        class="sticky top-0 z-[60] backdrop-blur-xl border-b border-gray-100 transition-all duration-500 ease-out w-full">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center transition-all duration-500" :class="scrolled ? 'h-16' : 'h-20'">
            
            {{-- Left Side: Logo & Desktop Links --}}
            <div class="flex items-center gap-8">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('client.dashboard') }}" class="block transform transition-transform hover:scale-105" title="TechnoG Solutions Dashboard">
                        <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" 
                             class="w-auto transition-all duration-500"
                             :class="scrolled ? 'h-10' : 'h-14'">
                    </a>
                </div>

                {{-- Desktop Nav Links (SaaS Pill Style) --}}
                <nav class="hidden lg:flex lg:items-center lg:space-x-2 border-l border-gray-200 pl-8">
                    @role('Client')
                        <a href="{{ route('client.dashboard') }}" 
                           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 {{ request()->routeIs('client.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100' : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600' }}">
                            <i class="fas fa-home"></i> {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('client.orders.index') }}" 
                           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 {{ request()->routeIs('client.orders*') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100' : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600' }}">
                            <i class="fas fa-history"></i> {{ __('Order History') }}
                        </a>

                         <a href="{{ route('client.services.index') }}" 
                           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 {{ request()->routeIs('client.services.index') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100' : 'text-gray-500 hover:bg-gray-50 hover:text-indigo-600' }}">
                            <i class="fas fa-shopping-basket"></i> {{ __('Order Service') }}
                        </a>
                    @endrole
                </nav>
            </div>

            {{-- Right Side: Notification & Profile --}}
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                
                {{-- Notification Bell (Livewire Component) --}}
                <div class="flex items-center justify-center">
                    <livewire:client-notification-bell />
                </div>

                {{-- Profile Dropdown Widget --}}
                <div class="relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button class="group flex items-center gap-3 pl-4 pr-1.5 py-1.5 bg-white border border-gray-200 rounded-full hover:bg-gray-50 hover:border-indigo-200 hover:shadow-sm transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                <div class="flex flex-col text-right">
                                    <span class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 leading-none transition-colors">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] font-bold tracking-wider text-gray-400 mt-1 uppercase">{{ Auth::user()->getRoleNames()->first() ?? 'Client' }}</span>
                                </div>
                                <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-100 border-2 border-white shadow-sm group-hover:border-indigo-100 transition-colors">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="h-full w-full object-cover">
                                    @else
                                        {{-- Default Avatar Initials --}}
                                        <div class="h-full w-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Dropdown Header --}}
                            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 rounded-t-md">
                                <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 font-medium truncate mt-0.5">{{ Auth::user()->email }}</p>
                            </div>
                            
                            {{-- Dropdown Links --}}
                            <div class="p-2 space-y-1">
                                <x-dropdown-link :href="route('client.profile.edit')" class="rounded-lg hover:bg-indigo-50 hover:text-indigo-600 font-bold text-sm flex items-center gap-3 py-2.5 transition-colors">
                                    <i class="fa-solid fa-user-pen text-gray-400 w-4 text-center"></i> {{ __('Edit Profile') }}
                                </x-dropdown-link>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 font-bold text-sm flex items-center gap-3 py-2.5 transition-colors">
                                        <i class="fa-solid fa-arrow-right-from-bracket opacity-70 w-4 text-center"></i> {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            {{-- Mobile Controls (Bell + Hamburger) --}}
            <div class="flex items-center gap-3 sm:hidden">
                <livewire:client-notification-bell />
                
                <button @click="openMenu = !openMenu" 
                        class="relative w-10 h-10 bg-white shadow-sm rounded-xl border border-gray-200 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 focus:outline-none transition-all duration-300 flex items-center justify-center">
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

    {{-- Mobile Menu (Floating Card Design) --}}
    <div x-show="openMenu" 
         x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="opacity-0 -translate-y-4 scale-95" 
         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
         x-transition:leave="transition ease-in duration-200" 
         x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
         x-transition:leave-end="opacity-0 -translate-y-4 scale-95" 
         @click.away="openMenu = false"
         class="sm:hidden absolute top-full left-4 right-4 mt-2 bg-white/95 backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 rounded-[2rem] overflow-hidden" 
         style="display: none;">
        
        {{-- Mobile Nav Links --}}
        <div class="p-3 space-y-1">
            @role('Client')
                <a href="{{ route('client.dashboard') }}" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('client.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas fa-home w-5 text-center"></i> {{ __('Dashboard') }}
                </a>
                <a href="{{ route('client.orders.index') }}" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('client.orders*') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas fa-history w-5 text-center"></i> {{ __('Order History') }}
                </a>
                <a href="{{ route('client.services.index') }}" class="flex items-center gap-3 px-5 py-3.5 rounded-xl text-base font-bold {{ request()->routeIs('client.services.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas fa-shopping-basket w-5 text-center"></i> {{ __('Order Service') }}
                </a>
            @endrole
        </div>
        
        {{-- Mobile User Profile & Actions --}}
        <div class="p-5 bg-gray-50/80 border-t border-gray-100">
            <div class="flex items-center gap-4 mb-5 px-2">
                <div class="h-12 w-12 rounded-full overflow-hidden border-2 border-white shadow-sm shrink-0">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="truncate">
                    <div class="font-extrabold text-gray-900 text-lg truncate">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('client.profile.edit') }}" class="flex justify-center items-center gap-2 px-4 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 shadow-sm transition-colors">
                    <i class="fa-solid fa-user-pen"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex justify-center items-center w-full gap-2 px-4 py-3 text-sm font-bold text-red-600 bg-red-50 border border-red-100 rounded-xl hover:bg-red-100 shadow-sm transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>