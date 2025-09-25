<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    {{-- Favicon Links --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    <style>
        /* [BACKGROUND BARU] Digital Matrix & Data Grid */
        body {
            background-color: #0a0f1f; /* Warna dasar biru gelap */
            /* overflow: hidden; */ /* <-- [PERBAIKAN] Baris ini dihapus untuk mengaktifkan scroll */
            min-height: 100vh;
        }

        #matrix-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .grid-layer {
            position: absolute;
            inset: -200%;
            background-image:
                linear-gradient(to right, rgba(128, 128, 128, 0.15) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(128, 128, 128, 0.15) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveGrid 30s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50px); }
        }

        /* Hujan digital "0" dan "1" */
        .binary-rain-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-around;
            overflow: hidden; /* Tambahkan ini agar hujan tidak membuat scroll */
        }

        .binary-column {
            font-family: monospace;
            color: rgba(0, 153, 255, 0.4);
            writing-mode: vertical-rl;
            text-orientation: upright;
            white-space: nowrap;
            user-select: none;
            font-size: 1.2rem;
            animation: fall linear infinite;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }

        /* Sisa CSS lainnya tetap sama */
        .glass-card { background: rgba(17, 24, 39, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(16px); border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3); }
        .form-gradient-text { background: linear-gradient(to right, #60a5fa, #ffffff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-card input, .glass-card select, .glass-card textarea { background-color: #ffffff; border: 1px solid #d1d5db; color: #111827; outline: none; padding: 0.75rem; width: 100%; border-radius: 0.5rem; margin-bottom: 0; transition: all 0.3s ease; }
        .glass-card input:focus, .glass-card select:focus, .glass-card textarea:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2); }
        .glass-card input::placeholder, .glass-card textarea::placeholder { color: #6b7280; }
        .glass-card input[type="checkbox"] { width: 1rem; height: 1rem; margin-right: 0.5rem; accent-color: #4f46e5; cursor: pointer; }
        .glass-card button { width: 100%; background: linear-gradient(135deg, #1d8cf8, #3358f4); border: none; color: #fff; padding: 0.75rem; border-radius: 0.5rem; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 115, 255, 0.3); }
        .glass-card button:hover { background: linear-gradient(135deg, #3358f4, #1d8cf8); transform: scale(1.03); box-shadow: 0 6px 20px rgba(0, 115, 255, 0.5); }
        .glass-card select option { color: #1f2937; background-color: #ffffff; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen w-full">
        <div id="matrix-background">
            <div class="grid-layer"></div>
            <div class="binary-rain-container" id="rain-container"></div>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col items-center justify-center p-4">
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center">
                    <x-application-logo class="w-20 h-20 text-white drop-shadow-lg" />
                    <span class="mt-3 text-white font-bold text-xl tracking-wide">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            
            <div class="glass-card w-full sm:max-w-5xl" 
                 x-data @mousemove="
                     const rect = $el.getBoundingClientRect();
                     const x = event.clientX - rect.left;
                     const y = event.clientY - rect.top;
                     const { width, height } = rect;
                     const rotateY = (x / width - 0.5) * -7; /* <-- [PERBAIKAN] Angka diubah dari -15 menjadi -7 */
                     const rotateX = (y / height - 0.5) * 7;  /* <-- [PERBAIKAN] Angka diubah dari 15 menjadi 7 */
                     $el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                 " @mouseleave="$el.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)'">
                {{ $slot }}
            </div>

            <div class="mt-6 text-white/80 text-sm">
                &copy; {{ date('Y') }} <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        // [SCRIPT BARU] Untuk membuat hujan digital
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('rain-container');
            if (!container) return;

            const binary = '01';
            const columns = 50; // Jumlah kolom hujan

            for (let i = 0; i < columns; i++) {
                const column = document.createElement('div');
                column.className = 'binary-column';
                
                let columnContent = '';
                for (let j = 0; j < 50; j++) { // Jumlah karakter per kolom
                    columnContent += binary.charAt(Math.floor(Math.random() * binary.length));
                }
                column.textContent = columnContent;

                // Atur durasi dan delay animasi secara acak
                column.style.animationDuration = `${Math.random() * 10 + 10}s`;
                column.style.animationDelay = `-${Math.random() * 20}s`;
                
                container.appendChild(column);
            }
        });
    </script>

    <script type="text/javascript">
      var onloadCallback = function() {
        if (document.getElementById('recaptcha-container')) {
          grecaptcha.render('recaptcha-container', {
            'sitekey' : '{{ config('app.recaptcha_site_key') }}',
            'theme' : 'dark'
          });
        }
      };
    </script>
</body>
</html>