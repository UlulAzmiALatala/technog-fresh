<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkModeToggle()" :class="{ 'dark': darkMode }">
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
            .dark ::-webkit-scrollbar-thumb { background-color: theme(colors.slate.600); border-color: theme(colors.slate.800); }
            .dark ::-webkit-scrollbar-thumb:hover { background-color: theme(colors.slate.500); }

            /* Preloader */
            #preloader {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(248, 250, 252, 0.8);
                backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
                z-index: 9999; display: flex; justify-content: center; align-items: center; flex-direction: column;
                gap: 1.5rem; opacity: 1; transition: opacity 0.75s ease, visibility 0.75s ease;
            }
            #preloader.hidden { opacity: 0; visibility: hidden; }
            .dark #preloader { background-color: rgba(15, 23, 42, 0.8); }
            .dark #preloader .preloader-text { color: #9ca3af; }
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
    <body {{ $attributes->merge(['class' => 'font-sans antialiased']) }}>

        <div id="preloader">
            <div class="node-network">
                <div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div>
            </div>
            <p class="preloader-text">Processing Data...</p>
        </div>

        {{-- ========================================================================= --}}
        {{-- === INILAH PERBAIKANNYA: Logika sidebarWidth diperbarui === --}}
        {{-- ========================================================================= --}}
        <div x-data="{ 
                     sidebarOpen: localStorage.getItem('sidebarOpen') === null ? true : localStorage.getItem('sidebarOpen') === 'true',
                     sidebarWidth: (localStorage.getItem('sidebarOpen') === 'false') ? 80 : (parseInt(localStorage.getItem('sidebarWidth')) || 288), 
                     isResizing: false,
                     isLoaded: false
                 }" 
             x-init="setTimeout(() => { isLoaded = true }, 50);
                 $watch('sidebarOpen', value => {
                     localStorage.setItem('sidebarOpen', value);
                     if (!value) {
                         sidebarWidth = 80;
                     } else {
                         sidebarWidth = parseInt(localStorage.getItem('sidebarWidth')) || 288;
                     }
                 })"
             @mousemove.window="if (isResizing) { sidebarWidth = Math.max(240, Math.min(400, $event.clientX)); }"
             @mouseup.window="isResizing = false; if(sidebarOpen) { localStorage.setItem('sidebarWidth', sidebarWidth); }"
             class="relative min-h-screen bg-slate-50 dark:bg-slate-900">
            
            @include('layouts.partials.sidebar')

            <div :class="{ 'transition-all duration-300 ease-in-out': isLoaded }" 
                 {{-- === INI PERBAIKAN BUG "BOLONG" === --}}
                 :style="sidebarOpen ? `margin-left: ${sidebarWidth}px` : 'margin-left: 0px'">
                
                <header class="sticky top-0 z-20 flex justify-between items-center py-3 px-6 bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg border-b border-slate-200 dark:border-slate-700 shadow-sm h-20">
                    <div class="flex items-center gap-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-full text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                            <i class="fas" :class="sidebarOpen ? 'fa-align-left' : 'fa-align-justify'"></i>
                        </button>
                        <p class="hidden md:block text-md font-semibold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-sky-400">
                            "Clear View, Smart Moves"
                        </p>
                    </div>

                    <div class="flex items-center gap-x-2 sm:gap-x-4">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" title="Aktivitas" class="relative z-10 block rounded-full p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <i class="fas fa-bell"></i>
                                @if(Auth::user() && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 h-2 w-2 mt-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-lg shadow-xl overflow-hidden z-20 border border-slate-200 dark:border-slate-700" style="display: none;">
                                <a href="{{ route('admin.chat.index') }}" class="flex items-center justify-between px-4 py-3 border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-comments mr-3 text-sky-500"></i>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Live Chat</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                                </a>
                                <div class="py-2 px-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Notifikasi ({{ Auth::user()->unreadNotifications->count() }})</div>
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse (Auth::user()->unreadNotifications->take(5) as $notification)
                                        <a href="{{ route('admin.pemasukan.orders.show', $notification->data['order_id']) }}" class="flex items-center px-4 py-3 border-t border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700">
                                            <div class="mx-3">
                                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $notification->data['message'] }}</p>
                                                <p class="text-blue-500 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>
                                    @empty
                                        <p class="text-center text-gray-500 dark:text-gray-400 py-4">Tidak ada notifikasi baru.</p>
                                    @endforelse
                                </div>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-center font-bold w-full py-2 hover:bg-slate-100 dark:hover:bg-slate-600 transition-colors text-xs uppercase">Tandai semua sudah dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button class="flex items-center transition ease-in-out duration-150">
                                        <div class="h-9 w-9 rounded-full overflow-hidden bg-gray-100 border-2 border-transparent hover:border-indigo-300 transition">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            @endif
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                                        <p class="mt-2 text-xs font-bold text-indigo-600 bg-indigo-50 dark:text-indigo-300 dark:bg-indigo-900/50 px-2 py-1 rounded-md inline-block">{{ Auth::user()->getRoleNames()->first() }}</p>
                                    </div>
                                    <x-dropdown-link :href="route('admin.profile.edit')">
                                        <i class="fas fa-user-edit w-6 text-gray-400"></i><span>{{ __('Profile') }}</span>
                                    </x-dropdown-link>
                                    <div class="border-t border-gray-200 dark:border-slate-700">
                                        <div class="w-full flex items-center justify-between px-4 py-2 text-sm text-slate-600 dark:text-slate-300">
                                            <div class="flex items-center">
                                                <i class="fas" :class="darkMode ? 'fa-sun text-yellow-500' : 'fa-moon text-indigo-500'"></i>
                                                <span class="ml-3" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                                            </div>
                                            <button @click="toggle()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors" :class="darkMode ? 'bg-indigo-600' : 'bg-gray-200'">
                                                <span :class="darkMode ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 dark:hover:text-red-400">
                                            <i class="fas fa-sign-out-alt w-6 text-red-400"></i><span>{{ __('Log Out') }}</span>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto">
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

        {{-- Toast Notification Container --}}
        <div x-data="toast()" class="fixed top-6 right-6 z-[60] w-full max-w-xs space-y-3">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.visible" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-x-full opacity-0"
                     x-transition:enter-end="transform translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="transform translate-x-0 opacity-100"
                     x-transition:leave-end="transform translate-x-full opacity-0"
                     class="relative w-full rounded-lg shadow-lg flex items-start p-4"
                     :class="{
                         'bg-green-500 text-white': toast.type === 'success',
                         'bg-red-500 text-white': toast.type === 'error',
                         'bg-blue-500 text-white': toast.type === 'info',
                         'bg-yellow-500 text-white': toast.type === 'warning',
                     }">
                    <div class="flex-shrink-0 text-xl mr-3">
                        <i class="fas" :class="{ 'fa-check-circle': toast.type === 'success', 'fa-times-circle': toast.type === 'error', 'fa-info-circle': toast.type === 'info', 'fa-exclamation-triangle': toast.type === 'warning' }"></i>
                    </div>
                    <div class="flex-1 text-sm font-medium" x-text="toast.message"></div>
                    <button @click="remove(toast.id)" class="ml-3 flex-shrink-0 text-white/70 hover:text-white">&times;</button>
                </div>
            </template>
        </div>

        @livewireScripts
        
        <script>
            // Data "daftar tugas" notifikasi dari Laravel
            window.flashMessages = [];
            @if (session('success'))
                window.flashMessages.push({ message: `{!! session('success') !!}`, type: 'success' });
            @endif
            @if (session('error'))
                window.flashMessages.push({ message: `{!! session('error') !!}`, type: 'error' });
            @endif
            @if (session('info'))
                window.flashMessages.push({ message: `{!! session('info') !!}`, type: 'info' });
            @endif
            @if (session('warning'))
                window.flashMessages.push({ message: `{!! session('warning') !!}`, type: 'warning' });
            @endif
        </script>
        
        <script>
            // Logika Preloader
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('hidden');
                    setTimeout(() => { preloader.style.display = 'none'; }, 800);
                }
            });

            // Logika Dark Mode
            function darkModeToggle() {
                return {
                    darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                    init() { this.$watch('darkMode', val => localStorage.setItem('darkMode', val)); },
                    toggle() { this.darkMode = !this.darkMode; }
                }
            }

            // Logika Notifikasi Pop-up (Toast)
            document.addEventListener('alpine:init', () => {
                Alpine.data('toast', () => ({
                    toasts: [],
                    idCounter: 0,
                    init() {
                        window.flashMessages.forEach(toast => { this.add(toast); });
                    },
                    add(toast) {
                        const id = ++this.idCounter;
                        this.toasts.push({ id: id, message: toast.message, type: toast.type || 'info', visible: true });
                        setTimeout(() => this.remove(id), 5000);
                    },
                    remove(id) {
                        const toast = this.toasts.find(t => t.id === id);
                        if (toast) {
                            toast.visible = false;
                            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 400);
                        }
                    }
                }));
            });
        </script>

         @stack('scripts')
    </body>
</html>


