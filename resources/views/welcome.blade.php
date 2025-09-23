<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechnoG Solutions - Data-Driven Technology</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- [CATATAN] Menggunakan 'defer' agar script tidak memblokir rendering halaman --}}
    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- Hero Section --}}
            <section class="relative text-white overflow-hidden">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80" alt="Data Analytics Dashboard" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/75"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex items-center">
                    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)"
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                         class="transition-all duration-1000 ease-out text-center w-full">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight">
                            <span class="block">Precision Technology,</span>
                            <span class="block bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-indigo-500">Powered by Data</span>
                        </h1>
                        <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-300">Kami membangun solusi teknologi canggih di atas fondasi analisis statistik yang kuat, memastikan setiap keputusan dan produk memiliki akurasi dan dampak yang maksimal.</p>
                        <div class="mt-8 flex flex-col sm:flex-row justify-center items-center gap-4">
                            <a href="{{ route('public.services') }}" class="inline-block px-8 py-3 bg-indigo-600 font-semibold rounded-lg shadow-lg text-white hover:bg-indigo-700 transition-transform transform hover:-translate-y-1">Jelajahi Layanan</a>
                            <a href="{{ route('public.why-choose-us') }}" class="inline-block px-8 py-3 bg-white/10 border border-white/20 font-semibold rounded-lg text-white hover:bg-white/20 transition-all backdrop-blur-sm">Mengapa Memilih Kami?</a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Featured Services Section --}}
            <section class="py-24 bg-white">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Layanan Unggulan</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Solusi Tepat untuk Kebutuhan Anda</p>
                    </div>
                    <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($services as $service)
                             <a href="{{ route('public.services') }}" class="group relative block bg-black rounded-2xl shadow-xl overflow-hidden h-96">
                                 <img alt="{{ $service->name }}" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x800/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover opacity-80 transition-all duration-300 group-hover:opacity-60 group-hover:scale-105" />
                                 <div class="relative p-6 flex flex-col justify-between h-full bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                     <div>
                                         @if($service->package_plan)
                                             <span class="bg-black/50 text-white text-xs font-semibold px-3 py-1.5 rounded-full backdrop-blur-sm">{{ $service->package_plan }}</span>
                                         @endif
                                     </div>
                                     <div>
                                         <h3 class="text-2xl font-bold text-white">{{ $service->name }}</h3>
                                         <div class="mt-2 flex justify-between items-center">
                                             <p class="text-lg font-semibold text-white">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                             <div class="transition-all transform opacity-0 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-4 text-white">
                                                 <span>Lihat Detail &rarr;</span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </a>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">Layanan unggulan akan segera ditampilkan.</p>
                        @endforelse
                    </div>
                    <div class="mt-12 text-center">
                        <a href="{{ route('public.services') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">Lihat semua layanan &rarr;</a>
                    </div>
                </div>
            </section>

            {{-- [PENYEMPURNAAN] Why Choose Us Summary --}}
             <section class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
                        <div class="lg:col-span-5">
                            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Keunggulan Kami</h2>
                            <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Mitra Teknologi yang Bisa Anda Andalkan</p>
                            <p class="mt-4 text-lg text-gray-600">Kami percaya pada proses yang transparan, hasil yang terukur, dan kemitraan yang kolaboratif untuk mencapai tujuan bisnis Anda.</p>
                             <a href="{{ route('public.why-choose-us') }}" class="mt-8 inline-block px-8 py-3 bg-indigo-600 font-semibold rounded-lg shadow-lg text-white hover:bg-indigo-700 transition-transform transform hover:-translate-y-1">Pelajari Lebih Lanjut</a>
                        </div>
                        <div class="mt-10 lg:mt-0 lg:col-span-7">
                            <dl class="space-y-10">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                            {{-- [IKON BARU] Menggunakan Lucide Icon SVG --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2v0Z"/><path d="M12 12a5 5 0 1 0 5 5 5 5 0 0 0-5-5v0Z"/><path d="M22 12a10 10 0 0 0-10-10v10Z"/></svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-lg leading-6 font-medium text-gray-900">Proses Terstruktur</dt>
                                        <dd class="mt-2 text-base text-gray-500">Dari strategi hingga peluncuran, setiap langkah direncanakan dengan matang untuk hasil yang presisi.</dd>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                            {{-- [IKON BARU] Menggunakan Lucide Icon SVG --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M9 4h6"/><path d="M12 4v10.66"/></svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-lg leading-6 font-medium text-gray-900">Hasil Terbukti</dt>
                                        <dd class="mt-2 text-base text-gray-500">Portofolio kami menunjukkan rekam jejak kesuksesan dalam berbagai industri.</dd>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                            {{-- [IKON BARU] Menggunakan Lucide Icon SVG --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <dt class="text-lg leading-6 font-medium text-gray-900">Tim Kolaboratif</dt>
                                        <dd class="mt-2 text-base text-gray-500">Kami bekerja bersama Anda, bukan hanya untuk Anda, untuk memastikan visi Anda terwujud.</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Case Studies Showcase --}}
            <section class="py-24 bg-white">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Kisah Sukses</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Portofolio Pilihan Kami</p>
                    </div>
                    <div class="mt-12 grid gap-8 lg:grid-cols-2">
                        @forelse ($caseStudies as $caseStudy)
                             <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}" class="group relative block bg-black rounded-2xl shadow-xl overflow-hidden">
                                 <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover opacity-80 transition-all duration-300 group-hover:opacity-60 group-hover:scale-105" />
                                 <div class="relative p-8 flex flex-col justify-end h-80 bg-gradient-to-t from-black/80 to-transparent">
                                     <p class="text-sm font-medium uppercase tracking-widest text-indigo-400">{{ $caseStudy->category->name ?? 'Case Study' }}</p>
                                     <p class="text-2xl font-bold text-white mt-2">{{ $caseStudy->title }}</p>
                                     <div class="mt-4 transition-all transform opacity-0 group-hover:opacity-100 h-0 group-hover:h-auto">
                                         <p class="text-sm text-white/80">{{ Str::limit($caseStudy->solution, 100) }}</p>
                                     </div>
                                 </div>
                             </a>
                        @empty
                            <p class="lg:col-span-2 text-center text-gray-500">Studi kasus unggulan akan segera ditampilkan.</p>
                        @endforelse
                    </div>
                </div>
            </section>
            
            {{-- Latest Blog Posts --}}
            <section class="py-24 bg-gray-50">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Blog</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Wawasan & Berita Terbaru</p>
                    </div>
                    <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($posts as $post)
                            <div class="flex flex-col rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 bg-white">
                                <div class="flex-shrink-0">
                                    <a href="{{ route('public.blog.show', $post->slug) }}">
                                        <img class="h-48 w-full object-cover" src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/800x600/e2e8f0/cbd5e0?text=TechnoG' }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-indigo-600">{{ $post->category->name ?? 'Artikel' }}</p>
                                        <a href="{{ route('public.blog.show', $post->slug) }}" class="block mt-2">
                                            <p class="text-xl font-semibold text-gray-900">{{ $post->title }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">Artikel terbaru akan segera ditampilkan.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- Final CTA --}}
            {{-- [PENYEMPURNAAN] Menggunakan gradient background --}}
            <section class="bg-gradient-to-r from-indigo-700 to-indigo-900">
                <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block">Punya Proyek di Pikiran Anda?</span>
                        <span class="block">Mari Wujudkan Bersama.</span>
                    </h2>
                    <a href="{{ route('public.contact') }}" class="mt-8 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto transition-transform hover:scale-105">Hubungi Kami</a>
                </div>
            </section>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>

