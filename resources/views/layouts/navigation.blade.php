{{-- Lokasi: resources/views/layouts/navigation.blade.php --}}

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-lg border-b border-gray-100">
    <nav x-data="{ open: false }" class="bg-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-16 w-auto">
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        @role('Client')
                            <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                                <i class="fas fa-home mr-2"></i>{{ __('Dashboard') }}
                            </x-nav-link>

                            {{-- FIX: Ganti 'client.orders' menjadi 'client.orders.index' --}}
                            <x-nav-link :href="route('client.orders.index')" :active="request()->routeIs('client.orders*')">
                                <i class="fas fa-history mr-2"></i>{{ __('Order History') }}
                            </x-nav-link>

                             <x-nav-link :href="route('client.services.index')" :active="request()->routeIs('client.services.index')">
                                <i class="fas fa-shopping-basket mr-2"></i>{{ __('Order Service') }}
                            </x-nav-link>
                        @endrole
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <livewire:client-notification-bell />

                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center transition ease-in-out duration-150">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-600 hover:text-gray-800">{{ Auth::user()->name }}</span>
                                        <div class="ms-2 h-9 w-9 rounded-full overflow-hidden bg-gray-100 border-2 border-transparent hover:border-indigo-300 transition">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    <p class="mt-2 text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md inline-block">{{ Auth::user()->getRoleNames()->first() }}</p>
                                </div>
                                <x-dropdown-link :href="route('client.profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                @role('Client')
                    <x-responsive-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    {{-- FIX: Ganti 'client.orders' menjadi 'client.orders.index' --}}
                    <x-responsive-nav-link :href="route('client.orders.index')" :active="request()->routeIs('client.orders*')">
                        {{ __('Order History') }}
                    </x-responsive-nav-link>

                     <x-responsive-nav-link :href="route('client.services.index')" :active="request()->routeIs('client.services.index')">
                        {{ __('Order Service') }}
                    </x-responsive-nav-link>
                @endrole
            </div>

            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('client.profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>