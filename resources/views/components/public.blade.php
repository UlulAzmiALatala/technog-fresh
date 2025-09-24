<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'TechnoG Solutions - Data-Driven Technology' }}</title>

    {{-- Favicon Links --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Slot untuk library tambahan (misal: particles.js) --}}
    {{ $scripts ?? '' }}
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-900">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')
        
        <main>
            {{ $hero ?? '' }}
            {{ $slot }}
        </main>

        @include('layouts.public-footer')

        {{-- Tombol Back to Top --}}
        <div x-data="{ showButton: false }" 
             x-init="window.addEventListener('scroll', () => { showButton = window.scrollY > 400 })" 
             class="fixed bottom-5 right-5 z-50">
            <template x-if="showButton">
                <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="p-3 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300"
                        aria-label="Kembali ke atas">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
    
    {{-- Slot untuk skrip spesifik halaman --}}
    {{ $pageScripts ?? '' }}
</body>
</html>