<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
        
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background-color: transparent; }
            ::-webkit-scrollbar-thumb { background-color: theme(colors.slate.300); border-radius: 10px; border: 2px solid theme(colors.slate.50); }
            ::-webkit-scrollbar-thumb:hover { background-color: theme(colors.slate.400); }
        </style>

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
        </style>
        
    </head>
    <body class="font-sans antialiased">

        <div id="preloader">
            <div class="node-network">
                <div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div>
            </div>
            <p class="preloader-text">Processing Data...</p>
        </div>

        <div x-data="{ 
                         sidebarOpen: true,
                         sidebarWidth: parseInt(localStorage.getItem('sidebarWidth')) || 288, 
                         isResizing: false 
                     }" 
             x-init="$watch('sidebarOpen', value => {
                 if (!value) {
                     sidebarWidth = 80;
                 } else {
                     sidebarWidth = parseInt(localStorage.getItem('sidebarWidth')) || 288;
                 }
             })"
             @mousemove.window="if (isResizing) { sidebarWidth = Math.max(240, Math.min(400, $event.clientX)); }"
             @mouseup.window="isResizing = false; if(sidebarOpen) { localStorage.setItem('sidebarWidth', sidebarWidth); }"
             class="relative min-h-screen bg-slate-50" 
             style="background-image: radial-gradient(theme(colors.slate.200) 1px, transparent 1px); background-size: 16px 16px;">
            
            @include('layouts.partials.sidebar')

            <div class="transition-all duration-300 ease-in-out" :style="`margin-left: ${sidebarWidth}px`">
                
                <header class="sticky top-0 z-20 flex justify-between items-center py-3 px-6 bg-white/80 backdrop-blur-lg border-b border-slate-200 shadow-sm h-20">
                    <div>
                        <p class="text-md font-semibold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-sky-400 hidden md:block">
                            "Clear View, Smart Moves"
                        </p>
                    </div>

                    {{-- Tombol untuk Buka/Tutup Sidebar --}}
                    <div>
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors">
                            <i class="fas" :class="sidebarOpen ? 'fa-align-left' : 'fa-align-right'"></i>
                        </button>
                    </div>

                    {{-- Ikon di sisi kanan --}}
                    <div class="flex items-center gap-x-2 sm:gap-x-4">
                        <a href="{{ route('admin.chat.index') }}" title="Live Chat" class="relative z-10 block rounded-full p-2 hover:bg-slate-100 focus:outline-none transition-colors duration-200">
                             <svg class="h-6 w-6 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                        </a>
                        
                        {{-- DROPDOWN NOTIFIKASI --}}
                        @auth
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = !dropdownOpen" title="Notifikasi" class="relative z-10 block rounded-full p-2 hover:bg-slate-100 focus:outline-none transition-colors duration-200">
                                    <svg class="h-6 w-6 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-0 right-0 inline-flex items-center justify-center h-5 w-5 text-xs font-bold text-red-100 bg-red-600 rounded-full">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    @endif
                                </button>
                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20 border border-slate-200" style="display: none;">
                                    <div class="py-2 px-4 text-sm font-semibold text-gray-700 border-b border-slate-200">Notifikasi ({{ Auth::user()->unreadNotifications->count() }})</div>
                                    <div class="max-h-64 overflow-y-auto">
                                        @forelse (Auth::user()->unreadNotifications as $notification)
                                            <a href="{{ route('admin.pemasukan.orders.show', $notification->data['order_id']) }}" class="flex items-center px-4 py-3 border-b border-slate-100 hover:bg-slate-50">
                                                <div class="mx-3">
                                                    <p class="text-gray-600 text-sm">{{ $notification->data['message'] }}</p>
                                                    <p class="text-blue-500 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </a>
                                        @empty
                                            <p class="text-center text-gray-500 py-4">Tidak ada notifikasi baru.</p>
                                        @endforelse
                                    </div>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="block bg-slate-700 text-white text-center font-bold w-full py-2 hover:bg-slate-800 transition-colors">Tandai semua sudah dibaca</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endauth
                        
                        {{-- DROPDOWN PROFIL PENGGUNA --}}
                        <div class="relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center transition ease-in-out duration-150">
                                        <div class="flex items-center">
                                            <span class="hidden sm:inline text-sm font-medium text-gray-600 hover:text-gray-800">{{ Auth::user()->name }}</span>
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
                                    <x-dropdown-link :href="route('admin.profile.edit')">{{ __('Profile') }}</x-dropdown-link>
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
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto" 
                      x-data="{ loaded: false }" x-init="requestAnimationFrame(() => loaded = true)"
                      :class="loaded ? 'opacity-100' : 'opacity-0'"
                      class="transition-opacity duration-500">
                    <div class="container mx-auto px-6 py-8">
                        @if (isset($header))
                            <div class="mb-6">
                                {{ $header }}
                            </div>
                        @endif
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <script>
            // Preloader script
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('hidden');
                setTimeout(() => { preloader.style.display = 'none'; }, 800);
            }
        });
        </script>

        @livewireScripts
    </body>
</html>