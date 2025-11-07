<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Favicons --}}
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        
        {{-- Fonts & Icons --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- INI KUNCINYA --}}
        @livewireStyles

        {{-- Scripts --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- CSS untuk Preloader --}}
        <style>
            #preloader {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(249, 250, 251, 0.8); /* bg-gray-50 dengan 80% opacity */
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px); /* Untuk support browser Safari */
                z-index: 9999; display: flex;
                justify-content: center; align-items: center; flex-direction: column;
                gap: 1.5rem; opacity: 1; transition: opacity 0.75s ease, visibility 0.75s ease;
            }
            #preloader.hidden { opacity: 0; visibility: hidden; }
            @media (prefers-color-scheme: dark) {
                #preloader {
                    background-color: rgba(17, 24, 39, 0.8); /* bg-gray-900 dengan 80% opacity */
                }
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

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Widget Live Chat Kustom --}}
        <div x-data="{ open: false }"
             @open-chat.window="open = true"
             class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50">

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform translate-y-4"
                 @click.outside="open = false"
                 class="w-80 bg-white dark:bg-gray-800 rounded-lg shadow-2xl flex flex-col"
                 style="height: min(65vh, 26rem); display: none;">

                <div class="bg-indigo-600 text-white p-4 rounded-t-lg flex justify-between items-center flex-shrink-0">
                    <h3 class="font-semibold">Butuh Bantuan?</h3>
                    <button @click="open = false" class="text-indigo-200 hover:text-white text-2xl leading-none">&times;</button>
                </div>

                <div class="flex-1 min-h-0">
                    <livewire:chat-widget />
                </div>
            </div>

            <button @click="open = true" x-show="!open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-75"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="bg-indigo-600 text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center hover:bg-indigo-700 transition">
                <i class="fa-solid fa-headset fa-2xl"></i>
            </button>
        </div>

        @stack('scripts')

        {{-- --- PERBAIKAN TOTAL PRELOADER SCRIPT --- --}}
        <script>
            // 1. Definisikan fungsi untuk menyembunyikan preloader
            function hidePreloader() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('hidden');
                    // Kita tunggu transisi CSS (0.75s) selesai sebelum menghapusnya
                    setTimeout(() => { preloader.style.display = 'none'; }, 800);
                }
            }

            // 2. Panggil fungsi saat 'load' (untuk refresh manual)
            window.addEventListener('load', hidePreloader);

            // 3. Panggil fungsi saat 'livewire:navigated' (untuk redirect SPA)
            // Ini akan memperbaiki bug "loading nyangkut"
            document.addEventListener('livewire:navigated', hidePreloader);
        </script>
        {{-- --- AKHIR PERBAIKAN --- --}}

        {{-- INI KUNCINYA --}}
        @livewireScripts
    </body>
</html>