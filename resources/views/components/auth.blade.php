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
        body { min-height: 100vh; background: #0B132B; }
        #sky, #stars, #celestial-body, #mountains, #lake, .cloud, .bird, .wave, .shooting-star { pointer-events: none; }
        .glass-card, .glass-card * { pointer-events: auto; }
        #scene, #scene * { transition: all 1.5s ease-in-out; }
        .day #sky { background: linear-gradient(to bottom, #6EC3F4, #E0F6FF); }
        .day #celestial-body { background-color: #FFD93D; box-shadow: 0 0 50px 15px rgba(255, 217, 61, 0.7); top: 15%; left: 75%; }
        .day #stars { opacity: 0; }
        .day .cloud { opacity: 0.8; }
        .day .bird { opacity: 1; }
        .night #sky { background: linear-gradient(to bottom, #0B132B, #1C2541); }
        .night #celestial-body { background-color: #EAEAEA; box-shadow: 0 0 35px 12px rgba(234, 234, 234, 0.4); top: 15%; left: 25%; }
        .night #stars { opacity: 1; }
        .night .cloud { opacity: 0; }
        .night .bird { opacity: 0; }
        #mountains { background: linear-gradient(to top, #2c3e50, transparent); clip-path: polygon(0% 100%, 15% 70%, 35% 85%, 55% 60%, 75% 80%, 100% 55%, 100% 100%); }
        #lake { position: absolute; bottom: 0; width: 100%; height: 35%; background: linear-gradient(to bottom, rgba(74,144,226,0.7), #001f3f); overflow: hidden; }
        #lake::after { content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.2) 1%, transparent 2%); background-size: 40px 40px; animation: ripple 8s linear infinite; }
        @keyframes ripple { from { transform: translateY(0); } to { transform: translateY(40px); } }
        .wave { position: absolute; bottom: 0; width: 200%; height: 100px; background: rgba(255, 255, 255, 0.25); border-radius: 100%; animation: waveMove 8s linear infinite; }
        .wave1 { bottom: 10px; left: -50%; animation-duration: 10s; opacity: 0.6; }
        .wave2 { bottom: 20px; left: -60%; animation-duration: 12s; opacity: 0.4; }
        .wave3 { bottom: 30px; left: -70%; animation-duration: 15s; opacity: 0.3; }
        @keyframes waveMove { 0% { transform: translateX(0); } 100% { transform: translateX(50%); } }
        .cloud { position: absolute; background: white; border-radius: 50%; box-shadow: -30px 10px 0 10px white, 30px 10px 0 15px white, 60px 0 0 20px white; width: 80px; height: 50px; opacity: 0.8; animation: cloudMove 60s linear infinite; }
        .cloud1 { top: 15%; left: -20%; animation-duration: 80s; }
        .cloud2 { top: 25%; left: -40%; animation-duration: 100s; }
        @keyframes cloudMove { 0% { transform: translateX(0); } 100% { transform: translateX(150vw); } }
        @keyframes twinkle { 0% { opacity: 0.5; } 100% { opacity: 1; } }
        .shooting-star { position: absolute; width: 2px; height: 100px; background: linear-gradient(white, transparent); opacity: 0; transform: rotate(45deg); animation: shoot 3s linear forwards; z-index: 30; }
        @keyframes shoot { 0% { opacity: 1; transform: translate(-50px, -50px) rotate(45deg); } 100% { opacity: 0; transform: translate(300px, 300px) rotate(45deg); } }
        .bird { position: absolute; top: 20%; left: -10%; width: 40px; height: 40px; background: url('https://upload.wikimedia.org/wikipedia/commons/3/32/Flying_bird_icon.png') no-repeat center/contain; animation: fly 25s linear infinite; opacity: 0; z-index: 25; }
        @keyframes fly { 0% { transform: translateX(0) scale(0.8); } 100% { transform: translateX(120vw) scale(1.1); } }
        .glass-card { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); backdrop-filter: blur(16px); border-radius: 1.5rem; padding: 2.5rem; }
        .form-gradient-text { background: linear-gradient(to right, #dbeafe, #ffffff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .night .glass-card { box-shadow: 0 0 35px rgba(0, 153, 255, 0.6); }

        /* ========================================================== */
        /* == PERUBAHAN: Gaya input diubah menjadi standar (putih) == */
        /* ========================================================== */
        .glass-card input, .glass-card select, .glass-card textarea {
            background-color: #ffffff;
            border: 1px solid #d1d5db; /* gray-300 */
            color: #111827; /* gray-900 */
            outline: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 0.5rem;
            margin-bottom: 0; /* Dihapus dari sini agar konsisten dengan komponen Laravel */
            transition: all 0.3s ease;
        }

        .glass-card input:focus, .glass-card select:focus, .glass-card textarea:focus {
            border-color: #4f46e5; /* indigo-600 */
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        
        /* Mengatur warna placeholder agar terlihat */
        .glass-card input::placeholder, .glass-card textarea::placeholder {
            color: #6b7280; /* gray-500 */
        }
        
        .glass-card input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            accent-color: #4f46e5; /* indigo-600 */
            cursor: pointer;
        }

        .glass-card button { width: 100%; background: linear-gradient(135deg, #1d8cf8, #3358f4); border: none; color: #fff; padding: 0.75rem; border-radius: 0.5rem; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0, 115, 255, 0.3); }
        .glass-card button:hover { background: linear-gradient(135deg, #3358f4, #1d8cf8); transform: scale(1.03); box-shadow: 0 6px 20px rgba(0, 115, 255, 0.5); }
        
        /* Agar opsi di dropdown terbaca */
        .glass-card select option {
            color: #1f2937;
            background-color: #ffffff;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div id="scene" class="relative min-h-screen w-full overflow-hidden">
        <div id="sky" class="absolute inset-0 z-0"></div>
        <div id="stars" class="absolute inset-0 z-10"></div>
        <div id="celestial-body" class="absolute w-24 h-24 md:w-32 md:h-32 rounded-full z-20 transform -translate-x-1/2"></div>
        <div id="mountains" class="absolute bottom-1/3 w-full h-1/3 z-20"></div>
        <div class="cloud cloud1 z-20"></div>
        <div class="cloud cloud2 z-20"></div>
        <div class="bird"></div>
        <div id="lake" class="z-30">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
        </div>

        <div class="relative z-40 flex min-h-screen flex-col items-center justify-center p-4">
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center">
                    <x-application-logo class="w-20 h-20 text-white drop-shadow-lg" />
                    <span class="mt-3 text-white font-bold text-xl tracking-wide">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            
            <div class="glass-card w-full sm:max-w-5xl" 
                 x-data @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; const rotateY = (x / width - 0.5) * -15; const rotateX = (y / height - 0.5) * 15; $el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`; " @mouseleave="$el.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)'">
                {{ $slot }}
            </div>

            <div class="mt-6 text-white/80 text-sm">
                &copy; {{ date('Y') }} <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        function updateScene() { const scene = document.getElementById('scene'); const now = new Date(); const hour = now.getHours(); if (hour >= 5 && hour < 18) { scene.className = 'day'; } else { scene.className = 'night'; } } function createStars() { const starsContainer = document.getElementById('stars'); if (!starsContainer) return; const starCount = 120; for (let i = 0; i < starCount; i++) { const star = document.createElement('div'); star.className = 'absolute rounded-full bg-white'; const size = Math.random() * 2 + 1; star.style.width = `${size}px`; star.style.height = `${size}px`; star.style.top = `${Math.random() * 100}%`; star.style.left = `${Math.random() * 100}%`; star.style.animation = `twinkle ${Math.random() * 4 + 2}s infinite alternate`; starsContainer.appendChild(star); } } function createShootingStar() { const star = document.createElement('div'); star.className = 'shooting-star'; star.style.top = Math.random() * 40 + '%'; star.style.left = Math.random() * 80 + '%'; document.getElementById('scene').appendChild(star); setTimeout(() => star.remove(), 3000); } setInterval(() => { if (document.getElementById('scene').classList.contains('night')) { createShootingStar(); } }, 8000); document.addEventListener('DOMContentLoaded', () => { createStars(); updateScene(); setInterval(updateScene, 60000); });
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