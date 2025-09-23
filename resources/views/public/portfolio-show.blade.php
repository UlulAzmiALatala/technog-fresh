<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $caseStudy->title }} - TechnoG Case Study</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-white text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            <div x-data="{ animate: false }" x-intersect.once="animate = true" 
                 :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" 
                 class="transition-all duration-1000 ease-out">
                <article class="py-24">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{-- [PENAMBAHAN] Breadcrumb Navigation --}}
                        <div class="mb-8 text-sm text-gray-500">
                            <a href="{{ route('public.why-choose-us') }}" class="hover:text-indigo-600">Mengapa Memilih Kami</a>
                            <span class="mx-2">&rsaquo;</span>
                            <a href="{{ route('public.portfolio') }}" class="hover:text-indigo-600">Portofolio</a>
                        </div>

                        {{-- Article Header --}}
                        <div class="text-center mb-12">
                            <p class="text-base font-semibold text-indigo-600">{{ $caseStudy->category->name ?? 'Uncategorized' }}</p>
                            <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight">{{ $caseStudy->title }}</h1>
                            <p class="mt-4 text-lg text-gray-500">Klien: <span class="font-medium text-gray-900">{{ $caseStudy->client_name }}</span></p>
                        </div>

                        {{-- Main Image with Hover Effect --}}
                        <div class="mb-12 group">
                            <div class="overflow-hidden rounded-lg">
                                <img class="w-full h-auto max-h-[500px] object-cover rounded-lg shadow-xl transition-all duration-500 ease-in-out group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-black/40" 
                                     src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/1200x600/e2e8f0/cbd5e0?text=TechnoG' }}" 
                                     alt="{{ $caseStudy->title }}">
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-12">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Tantangan</h3>
                                <p class="mt-4">{!! nl2br(e($caseStudy->problem)) !!}</p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Solusi Kami</h3>
                                <p class="mt-4">{!! nl2br(e($caseStudy->solution)) !!}</p>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Hasil Akhir</h3>
                                <p class="mt-4">{!! nl2br(e($caseStudy->result)) !!}</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>
