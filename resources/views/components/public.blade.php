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
<body class="antialiased font-sans bg-gray-50 text-gray-900">

    <div id="preloader">
        <div class="node-network">
            <div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div><div class="node"></div>
        </div>
        <p class="preloader-text">Processing Data...</p>
    </div>

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
    
    {{-- Slot untuk skrip spesifik halaman --}}
    {{ $pageScripts ?? '' }}
</body>
</html>