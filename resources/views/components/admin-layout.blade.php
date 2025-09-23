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

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- (BARU) Menambahkan style untuk Livewire --}}
        @livewireStyles
        
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background-color: transparent; }
            ::-webkit-scrollbar-thumb { background-color: theme(colors.slate.300); border-radius: 10px; border: 2px solid theme(colors.slate.50); }
            ::-webkit-scrollbar-thumb:hover { background-color: theme(colors.slate.400); }
        </style>
        
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ 
                         sidebarWidth: parseInt(localStorage.getItem('sidebarWidth')) || 256, 
                         isResizing: false 
                     }" 
             @mousemove.window="if (isResizing) { sidebarWidth = Math.max(80, Math.min(400, $event.clientX)); }"
             @mouseup.window="isResizing = false; localStorage.setItem('sidebarWidth', sidebarWidth);"
             class="relative min-h-screen bg-slate-50" 
             style="background-image: radial-gradient(theme(colors.slate.200) 1px, transparent 1px); background-size: 16px 16px;">
            
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main content -->
            <div class="transition-all duration-100" :style="`margin-left: ${sidebarWidth}px`">
                <!-- Top bar -->
                <header class="sticky top-0 z-20 flex justify-between items-center py-4 px-6 bg-white/80 backdrop-blur-lg border-b border-slate-200 shadow-sm">
                    {{-- Slogan di sisi kiri --}}
                    <div>
                        <p class="text-md font-semibold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-sky-400 hidden md:block">
                            "Clear View, Smart Moves"
                        </p>
                    </div>

                    {{-- Ikon di sisi kanan --}}
                    <div class="flex items-center gap-x-4">
                        {{-- (BARU) Tombol Live Chat --}}
                        <a href="{{ route('admin.chat.index') }}" class="relative z-10 block rounded-full p-2 hover:bg-slate-100 focus:outline-none transition-colors duration-200">
                             <svg class="h-6 w-6 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                             {{-- Bisa ditambahkan notifikasi jumlah chat yang belum dibaca di sini nanti --}}
                        </a>
                        
                        {{-- DROPDOWN NOTIFIKASI --}}
                        @auth
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-full p-2 hover:bg-slate-100 focus:outline-none transition-colors duration-200">
                                    <svg class="h-6 w-6 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ Auth::user()->unreadNotifications->count() }}</span>
                                    @endif
                                </button>
                                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20 border border-slate-200" style="display: none;">
                                    <div class="py-2 px-4 text-sm font-semibold text-gray-700 border-b border-slate-200">Notifikasi ({{ Auth::user()->unreadNotifications->count() }})</div>
                                    <div class="max-h-64 overflow-y-auto">
                                        @forelse (Auth::user()->unreadNotifications as $notification)
                                            <a href="{{ route('admin.pemasukan.orders.show', $notification->data['order_id']) }}" class="flex items-center px-4 py-3 border-b border-slate-100 hover:bg-slate-50 -mx-2">
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
                    </div>
                </header>

                <!-- Page Content -->
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

        {{-- (BARU) Menambahkan script untuk Livewire --}}
        @livewireScripts
    </body>
</html>
    

