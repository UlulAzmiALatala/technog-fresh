<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studi Kasus - Kisah Sukses Klien | TechnoG Solutions</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80" alt="Professional Case Studies" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/40 mix-blend-multiply"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)" 
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" 
                         class="transition-all duration-1000 ease-out">
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Studi Kasus Kami</h1>
                        <p class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto">Lihat bagaimana kami menerapkan pendekatan berbasis data untuk menyelesaikan masalah nyata dan memberikan hasil yang terukur bagi klien kami.</p>
                    </div>
                </div>
            </section>

            {{-- Case Studies Gallery --}}
            <section class="py-24">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{-- Breadcrumb untuk navigasi balik --}}
                    <div class="mb-12 text-sm">
                        <a href="{{ route('public.why-choose-us') }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                            &larr; Kembali ke Mengapa Memilih Kami
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        
                        {{-- Di sini kita menggunakan perulangan dengan variabel $caseStudies (jamak) --}}
                        @forelse ($caseStudies as $caseStudy)
                            <div class="group bg-white rounded-lg shadow-xl overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                                <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}">
                                    <div class="h-64 overflow-hidden">
                                        <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/6366f1/FFFFFF?text=TechnoG' }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                                    </div>
                                    <div class="p-6">
                                        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600">{{ $caseStudy->category->name ?? 'Uncategorized' }}</p>
                                        <h3 class="mt-2 text-2xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $caseStudy->title }}</h3>
                                        <p class="mt-3 text-base text-gray-500">{{ Str::limit($caseStudy->solution, 150) }}</p>
                                        <span class="mt-4 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">Baca studi kasus &rarr;</span>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="md:col-span-2 bg-white rounded-lg shadow-xl p-12 text-center">
                                <p class="text-gray-500">Belum ada studi kasus yang dipublikasikan.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </section>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>

