<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Kami - TechnoG Solutions</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- Hero Section (Tetap Ada) --}}
            <section class="relative text-white overflow-hidden">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="Layanan Profesional" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/40 mix-blend-multiply"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Solusi Teknologi Berbasis Data</h1>
                    <p class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto">Jelajahi bagaimana kami mengintegrasikan analisis statistik mendalam dengan rekayasa perangkat lunak untuk menciptakan layanan yang presisi dan berdampak.</p>
                </div>
            </section>

            {{-- [KONTEN BARU] Sistem Layanan Dinamis --}}
            <div class="py-12 bg-gray-50">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                            Temukan Paket yang Tepat untuk Anda
                        </h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                            Pilih kategori layanan, lalu jelajahi paket-paket yang kami rancang khusus untuk kebutuhan Anda.
                        </p>
                    </div>

                    <div x-data="{ selectedCategory: '{{ $serviceCategories->first()->id ?? '' }}' }">
                        <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-10" aria-label="Tabs">
                            @foreach ($serviceCategories as $category)
                                @php
                                    $categoryStyle = '';
                                    switch ($category->name) {
                                        case 'IT Solution': $categoryStyle = 'background-color:#333F4F; color:#FFFFFF;'; break;
                                        case 'Statistical Solution': $categoryStyle = 'background-color:#375623; color:#FFFFFF;'; break;
                                        case 'Hybrid Pathway': $categoryStyle = 'background-color:#00FFFF; color:#083344;'; break;
                                    }
                                @endphp
                                <button
                                    @click="selectedCategory = '{{ $category->id }}'; selectedPackage = ''"
                                    :class="selectedCategory === '{{ $category->id }}' ? 'opacity-100 scale-105 shadow-lg ring-2 ring-black/10' : 'opacity-85 hover:opacity-100 hover:scale-[1.02]'"
                                    class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-300"
                                    style="{{ $categoryStyle }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            @foreach ($serviceCategories as $category)
                                <div x-show="selectedCategory === '{{ $category->id }}'" style="display:none;" x-data="{ selectedPackage: '' }">
                                    @php
                                        $order = ['Silver Plan', 'Gold Plan', 'Platinum Sphere', 'Diamond Class', 'Ultima Partnership', 'Custom Engagement'];
                                        $servicesOrdered = collect($groupedServices[$category->id] ?? [])->sortBy(function($value, $key) use ($order) {
                                            return array_search($key, $order);
                                        });
                                    @endphp

                                    {{-- Tampilan Daftar Paket --}}
                                    <div x-show="!selectedPackage" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                        @forelse ($servicesOrdered as $packageName => $servicesInPackage)
                                            <div @click="selectedPackage = '{{ $packageName }}'"
                                                 class="rounded-2xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 cursor-pointer"
                                                 style="@switch($packageName)
                                                            @case('Silver Plan') background-color:#F2F2F2;color:#000;@break
                                                            @case('Gold Plan') background-color:#FFD700;color:#000;@break
                                                            @case('Platinum Sphere') background-color:#808080;color:#FFF;@break
                                                            @case('Diamond Class') background-color:#305496;color:#FFF;@break
                                                            @case('Ultima Partnership') background-color:#000;color:#FFF;@break
                                                            @case('Custom Engagement') background-color:#1E4174;color:#DDA94B;@break
                                                        @endswitch">
                                                <div class="p-6">
                                                    <h3 class="text-2xl font-bold">{{ $packageName }}</h3>
                                                    <p class="mt-2 text-sm opacity-80 min-h-[40px]">
                                                        @switch($packageName)
                                                            @case('Diamond Class') Solusi premium untuk kebutuhan paling kompleks. @break
                                                            @case('Platinum Sphere') Keseimbangan sempurna antara fitur dan harga. @break
                                                            @case('Gold Plan') Paket populer dengan semua fitur esensial. @break
                                                            @case('Silver Plan') Pilihan tepat untuk memulai dengan budget terjangkau. @break
                                                            @case('Ultima Partnership') Kemitraan strategis untuk pertumbuhan jangka panjang. @break
                                                            @case('Custom Engagement') Rancang sendiri layanan yang sesuai kebutuhan Anda. @break
                                                        @endswitch
                                                    </p>
                                                </div>
                                                <div class="p-6 mt-auto">
                                                    <p class="text-sm opacity-80">Mulai dari</p>
                                                    {{-- [PENYESUAIAN] Mengganti font-extrabold menjadi font-bold --}}
                                                    <p class="text-3xl font-bold">Rp {{ number_format($servicesInPackage->min('price'), 0, ',', '.') }}</p>
                                                    <div class="mt-6 w-full py-3 px-8 text-center font-semibold rounded-lg"
                                                         style="@if(in_array($packageName, ['Silver Plan', 'Gold Plan'])) background-color:rgba(0,0,0,0.1); @else background-color:rgba(255,255,255,0.9);color:#333; @endif">
                                                        Lihat Layanan
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="col-span-3 text-center text-gray-500 py-12">Belum ada paket layanan di kategori ini.</p>
                                        @endforelse
                                    </div>

                                    {{-- Tampilan Daftar Layanan --}}
                                    <div x-show="selectedPackage" x-transition style="display:none;">
                                        <div class="flex justify-between items-center mb-6">
                                            <h2 class="text-2xl font-bold text-gray-800">Layanan di <span class="text-indigo-600" x-text="selectedPackage"></span></h2>
                                            <button @click="selectedPackage = ''" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">&larr; Kembali ke Paket</button>
                                        </div>
                                        <div class="bg-white rounded-xl shadow-lg p-6">
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                                @foreach ($servicesOrdered as $packageName => $servicesInPackage)
                                                    <template x-if="selectedPackage === '{{ $packageName }}'">
                                                        <div class="contents">
                                                            @foreach ($servicesInPackage as $service)
                                                                @include('public.partials.service-card', ['service' => $service])
                                                            @endforeach
                                                        </div>
                                                    </template>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>

