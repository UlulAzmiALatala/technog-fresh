{{-- Lokasi: resources/views/layouts/navigation.blade.php --}}

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg shadow-sm">

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-24">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-28 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- MODIFIKASI: Gabungkan peran --}}
                    @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                        <x-nav-link :href="route('pemasukan.services.index')" :active="request()->routeIs('pemasukan.services.*')">
                            {{ __('Layanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pemasukan.orders.index')" :active="request()->routeIs('pemasukan.orders.*')">
                            {{ __('Pesanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pengeluaran.expenses.index')" :active="request()->routeIs('pengeluaran.expenses.*')">
                            {{ __('Pengeluaran') }}
                        </x-nav-link>
                    @endhasanyrole
                    
                    @role('Founder')
                        <x-nav-link :href="route('founder.users.index')" :active="request()->routeIs('founder.users.*')">
                            {{ __('Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('founder.reports.index')" :active="request()->routeIs('founder.reports.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                    @endrole

                    {{-- MODIFIKASI: Tautan Blog untuk Founder & Konten --}}
                    @hasanyrole('Founder|Konten')
                        <x-nav-link :href="route('founder.posts.index')" :active="request()->routeIs('founder.posts.*')">
                            {{ __('Blog') }}
                        </x-nav-link>
                    @endhasanyrole

                    {{-- MENU UNTUK CLIENT --}}
                    @role('Client')
                        <x-nav-link :href="route('client.orders')" :active="request()->routeIs('client.orders*')">
                            {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                         <x-nav-link :href="route('client.services.list')" :active="request()->routeIs('client.services.list')">
                            {{ __('Pesan Layanan') }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- Ikon Notifikasi --}}
                <button class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                </button>

                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-600 hover:text-gray-800">{{ Auth::user()->name }}</span>
                                    <div class="ms-2 h-8 w-8 rounded-full overflow-hidden bg-gray-100">
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
                            @role('Client')
                                <x-dropdown-link :href="route('client.profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @endrole

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
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

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            {{-- MENU RESPONSIVE UNTUK FOUNDER & ADMIN --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <x-responsive-nav-link :href="route('pemasukan.services.index')" :active="request()->routeIs('pemasukan.services.*')">
                    {{ __('Layanan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pemasukan.orders.index')" :active="request()->routeIs('pemasukan.orders.*')">
                    {{ __('Pesanan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pengeluaran.expenses.index')" :active="request()->routeIs('pengeluaran.expenses.*')">
                    {{ __('Pengeluaran') }}
                </x-responsive-nav-link>
            @endhasanyrole
            
            @role('Founder')
                <x-responsive-nav-link :href="route('founder.users.index')" :active="request()->routeIs('founder.users.*')">
                    {{ __('Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('founder.reports.index')" :active="request()->routeIs('founder.reports.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            @endrole

            @hasanyrole('Founder|Konten')
                <x-responsive-nav-link :href="route('founder.posts.index')" :active="request()->routeIs('founder.posts.*')">
                    {{ __('Blog') }}
                </x-responsive-nav-link>
            @endhasanyrole

            {{-- MENU RESPONSIVE UNTUK CLIENT --}}
            @role('Client')
                <x-responsive-nav-link :href="route('client.orders')" :active="request()->routeIs('client.orders*')">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
                 <x-responsive-nav-link :href="route('client.services.list')" :active="request()->routeIs('client.services.list')">
                    {{ __('Pesan Layanan') }}
                </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @role('Client')
                    <x-responsive-nav-link :href="route('client.profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endrole

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


</header>