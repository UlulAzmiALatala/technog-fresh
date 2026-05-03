<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="darkModeToggle()" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TechnoG Solutions') }} - Admin</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
        
        <style>
            /* Custom Scrollbar Global */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background-color: transparent; }
            ::-webkit-scrollbar-thumb { background-color: theme(colors.slate.300); border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background-color: theme(colors.indigo.400); }
            .dark ::-webkit-scrollbar-thumb { background-color: theme(colors.slate.700); }
            .dark ::-webkit-scrollbar-thumb:hover { background-color: theme(colors.indigo.500); }

            /* Preloader (Glassmorphism) */
            #preloader {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(248, 250, 252, 0.6);
                backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
                z-index: 9999; display: flex; justify-content: center; align-items: center; flex-direction: column;
                gap: 1.5rem; opacity: 1; transition: opacity 0.75s ease, visibility 0.75s ease;
            }
            #preloader.hidden { opacity: 0; visibility: hidden; }
            .dark #preloader { background-color: rgba(11, 17, 32, 0.8); }
            .dark #preloader .preloader-text { color: #94a3b8; }
            .node-network { position: relative; width: 100px; height: 100px; }
            .node {
                width: 12px; height: 12px; background-color: #4f46e5;
                box-shadow: 0 0 15px #4f46e5;
                border-radius: 50%; position: absolute; top: 50%; left: 50%;
                transform: translate(-50%, -50%);
                animation: move-and-connect 3s ease-in-out infinite; opacity: 0;
            }
            .node:nth-child(1) { animation-delay: 0s; } .node:nth-child(2) { animation-delay: -0.6s; }
            .node:nth-child(3) { animation-delay: -1.2s; } .node:nth-child(4) { animation-delay: -1.8s; }
            .node:nth-child(5) { animation-delay: -2.4s; }
            .preloader-text { font-size: 0.75rem; color: #475569; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; }
            @keyframes move-and-connect {
                0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
                25% { transform: translate(-100%, -100%) scale(1.2); opacity: 1; }
                50% { transform: translate(0, 50%) scale(0.7); opacity: 1; }
                75% { transform: translate(100%, -100%) scale(1); opacity: 1; }
                100% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
            }
        </style>
    </head>
    <body {{ $attributes->merge(['class' => 'font-sans antialiased text-slate-600 dark:text-slate-400 selection:bg-indigo-500 selection:text-white']) }}>

        <div id="preloader">
            <div class="node-network">
                <div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div>
            </div>
            <p class="preloader-text">Loading Workspace</p>
        </div>

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
             class="relative min-h-screen bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
            
            @include('layouts.partials.sidebar')

            <div :class="{ 'transition-all duration-300 ease-in-out': isLoaded }" 
                 :style="sidebarOpen ? `margin-left: ${sidebarWidth}px` : 'margin-left: 0px'">
                
                {{-- HEADER GLASSMORPHISM --}}
                <header class="sticky top-0 z-20 flex justify-between items-center py-3 px-6 bg-white/70 dark:bg-[#0B1120]/70 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-800/80 shadow-sm h-20 transition-colors duration-300">
                    <div class="flex items-center gap-x-6">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-400 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-indigo-500 dark:hover:text-indigo-400 transition-all">
                            <i class="fas text-lg" :class="sidebarOpen ? 'fa-align-left' : 'fa-align-justify'"></i>
                        </button>
                        <p class="hidden md:block text-xs font-black tracking-[0.2em] uppercase bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-sky-400">
                            "Clear View, Smart Moves"
                        </p>
                    </div>

                    <div class="flex items-center gap-x-2 sm:gap-x-4">
                        
                        {{-- NOTIFICATION DROPDOWN --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" title="Notifications" class="relative z-10 block rounded-xl p-2.5 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <i class="fas fa-bell"></i>
                                @if(Auth::user() && Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-0 right-0 h-2.5 w-2.5 mt-1.5 mr-1.5 bg-rose-500 border border-white dark:border-slate-800 rounded-full animate-pulse"></span>
                                @endif
                            </button>
                            
                            {{-- Panel Notifikasi --}}
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-3 w-80 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-[1.5rem] shadow-xl overflow-hidden z-30 border border-slate-200/50 dark:border-slate-700/50" style="display: none;">
                                <a href="{{ route('admin.chat.index') }}" class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-sky-50 dark:bg-sky-500/10 flex items-center justify-center mr-3">
                                            <i class="fas fa-comments text-sky-500"></i>
                                        </div>
                                        <span class="text-sm font-bold text-slate-800 dark:text-slate-200">Live Chat</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-xs text-slate-400"></i>
                                </a>
                                <div class="py-3 px-5 text-xs font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 dark:border-slate-700/50">
                                    Notifications ({{ Auth::user()->unreadNotifications->count() }})
                                </div>
                                <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                    @forelse (Auth::user()->unreadNotifications->take(5) as $notification)
                                        <a href="{{ route('admin.pemasukan.orders.show', $notification->data['order_id']) }}" class="flex items-start px-5 py-4 border-b border-slate-50 dark:border-slate-700/30 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                                            <div class="mt-1 flex-shrink-0 w-2 h-2 rounded-full bg-indigo-500 group-hover:scale-125 transition-transform"></div>
                                            <div class="ml-3">
                                                <p class="text-slate-700 dark:text-slate-300 text-sm font-medium leading-snug">{{ $notification->data['message'] }}</p>
                                                <p class="text-indigo-500 dark:text-indigo-400 text-[10px] font-bold uppercase tracking-wider mt-1.5">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="text-center text-slate-400 py-8 flex flex-col items-center">
                                            <i class="fas fa-bell-slash text-2xl mb-2 opacity-50"></i>
                                            <p class="text-xs font-bold uppercase tracking-widest">No new notifications</p>
                                        </div>
                                    @endforelse
                                </div>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-center font-bold w-full py-3 transition-colors text-[10px] uppercase tracking-widest border-t border-slate-200 dark:border-slate-700">
                                            Mark all as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- USER PROFILE DROPDOWN --}}
                        <div class="relative">
                            <x-dropdown align="right" width="64">
                                <x-slot name="trigger">
                                    <button class="flex items-center transition ease-in-out duration-300 hover:scale-105 focus:outline-none">
                                        <div class="h-10 w-10 rounded-xl overflow-hidden bg-indigo-50 border border-indigo-100 dark:border-slate-700 shadow-sm">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-indigo-100 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-black">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    </button>
                                </x-slot>
                                
                                <x-slot name="content">
                                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50">
                                        <p class="text-sm font-black text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] uppercase tracking-widest text-slate-400 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                        <span class="mt-2 text-[9px] font-black text-indigo-600 bg-indigo-100 dark:text-indigo-300 dark:bg-indigo-900/50 border border-indigo-200 dark:border-indigo-800 px-3 py-1 rounded-lg uppercase tracking-widest inline-block">
                                            {{ Auth::user()->getRoleNames()->first() }}
                                        </span>
                                    </div>
                                    
                                    <div class="py-1">
                                        <x-dropdown-link :href="route('admin.profile.edit')" class="py-2.5 flex items-center group">
                                            <i class="fas fa-user-edit w-6 text-slate-400 group-hover:text-indigo-500 transition-colors"></i><span class="font-medium">My Profile</span>
                                        </x-dropdown-link>
                                        
                                        <div class="border-t border-slate-100 dark:border-slate-700/50 my-1"></div>
                                        
                                        {{-- KUNCI ALPINE: .stop pada event click mencegah dropdown tertutup --}}
                                        <div @click.stop="toggle()" class="w-full flex items-center justify-between px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-700/50 cursor-pointer transition-colors group">
                                            <div class="flex items-center">
                                                <i class="fas w-6 text-center transition-colors" :class="darkMode ? 'fa-sun text-amber-500' : 'fa-moon text-indigo-500'"></i>
                                                <span class="font-medium text-sm text-slate-700 dark:text-slate-300" x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                                            </div>
                                            <button type="button" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none" :class="darkMode ? 'bg-indigo-600' : 'bg-slate-300 dark:bg-slate-600'">
                                                <span :class="darkMode ? 'translate-x-5' : 'translate-x-1'" class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform"></span>
                                            </button>
                                        </div>
                                        
                                        <div class="border-t border-slate-100 dark:border-slate-700/50 my-1"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="py-2.5 flex items-center group text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10">
                                                <i class="fas fa-sign-out-alt w-6 text-rose-400 group-hover:text-rose-500 transition-colors"></i><span class="font-bold">Log Out</span>
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto">
                    <div class="container mx-auto px-4 md:px-6 py-8">
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

        {{-- TOAST NOTIFICATIONS (Glassmorphism Level 2) --}}
        <div x-data="toast()" class="fixed top-6 right-6 z-[999] w-full max-w-sm space-y-3 pointer-events-none">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.visible" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="transform translate-x-full opacity-0"
                     x-transition:enter-end="transform translate-x-0 opacity-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="transform translate-x-0 opacity-100"
                     x-transition:leave-end="transform translate-x-full opacity-0"
                     class="relative w-full rounded-2xl shadow-2xl flex items-start p-4 backdrop-blur-xl border pointer-events-auto"
                     :class="{
                         'bg-emerald-500/90 border-emerald-400 shadow-emerald-500/20 text-white': toast.type === 'success',
                         'bg-rose-500/90 border-rose-400 shadow-rose-500/20 text-white': toast.type === 'error',
                         'bg-indigo-500/90 border-indigo-400 shadow-indigo-500/20 text-white': toast.type === 'info',
                         'bg-amber-500/90 border-amber-400 shadow-amber-500/20 text-white': toast.type === 'warning',
                     }">
                    <div class="flex-shrink-0 text-2xl mr-4 shadow-sm">
                        <i class="fas" :class="{ 'fa-check-circle': toast.type === 'success', 'fa-times-circle': toast.type === 'error', 'fa-info-circle': toast.type === 'info', 'fa-exclamation-triangle': toast.type === 'warning' }"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-xs font-black tracking-widest uppercase mb-1 opacity-80" x-text="toast.type"></p>
                        <p class="text-sm font-medium leading-snug" x-html="toast.message"></p>
                    </div>
                    <button @click="remove(toast.id)" class="ml-3 flex-shrink-0 text-white/50 hover:text-white transition-colors focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </template>
        </div>

        @livewireScripts
        
        <script>
            window.flashMessages = [];
            @if (session('success')) window.flashMessages.push({ message: `{!! session('success') !!}`, type: 'success' }); @endif
            @if (session('error')) window.flashMessages.push({ message: `{!! session('error') !!}`, type: 'error' }); @endif
            @if (session('info')) window.flashMessages.push({ message: `{!! session('info') !!}`, type: 'info' }); @endif
            @if (session('warning')) window.flashMessages.push({ message: `{!! session('warning') !!}`, type: 'warning' }); @endif
        </script>
        
        <script>
            window.addEventListener('load', function() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('hidden');
                    setTimeout(() => { preloader.style.display = 'none'; }, 800);
                }
            });

            function darkModeToggle() {
                return {
                    darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                    init() { this.$watch('darkMode', val => localStorage.setItem('darkMode', val)); },
                    toggle() { this.darkMode = !this.darkMode; }
                }
            }

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