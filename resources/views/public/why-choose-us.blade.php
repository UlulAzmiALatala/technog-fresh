<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Why Choose Us - TechnoG Solutions</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Menggunakan defer agar script tidak memblokir rendering halaman --}}
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-white text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- 1. Hero Section --}}
            <section class="relative text-white overflow-hidden">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80" alt="Tim Kolaboratif" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/50 to-transparent"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)" 
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" 
                         class="transition-all duration-1000 ease-out">
                        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight">Mengapa Memilih TechnoG Solutions?</h1>
                        <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-3xl mx-auto">
                            Kami bukan sekadar agensi digital. Kami adalah mitra strategis Anda dalam membangun solusi teknologi yang andal, terukur, dan memberikan hasil nyata.
                        </p>
                    </div>
                </div>
            </section>

            {{-- 2. Pembeda Utama (Key Differentiators) dengan Efek Spotlight --}}
            <section class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Fondasi Keunggulan Kami</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Tiga pilar utama yang menjadikan kami mitra tepercaya untuk transformasi digital Anda.</p>
                    </div>
                    
                    <div x-data="{ active: 0 }" @mouseleave="active = 0" class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        {{-- Kartu 1 --}}
                        <div @mouseenter="active = 1" :class="active === 1 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                            <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">Pendekatan Terstruktur</h3>
                            <p class="text-gray-600">Setiap proyek kami jalankan dengan metodologi yang jelas dan teruji, memastikan hasil yang optimal dan tepat waktu.</p>
                        </div>
                        
                        {{-- Kartu 2 --}}
                        <div @mouseenter="active = 2" :class="active === 2 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                            <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">Hasil yang Terbukti</h3>
                            <p class="text-gray-600">Portofolio kami adalah bukti nyata kemampuan kami dalam memberikan solusi yang berhasil dan memuaskan klien.</p>
                        </div>
                        
                        {{-- Kartu 3 --}}
                        <div @mouseenter="active = 3" :class="active === 3 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                            <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-900">Tim Ahli & Kolaboratif</h3>
                            <p class="text-gray-600">Kami adalah tim profesional yang siap berkolaborasi erat dengan Anda untuk mewujudkan visi Anda menjadi kenyataan.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 3. Proses Kami yang Interaktif (Our Process) --}}
            <section class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Alur Kerja Kami yang Transparan</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Setiap proyek melewati empat tahap kunci untuk memastikan hasil yang optimal dan kolaborasi yang efektif.</p>
                    </div>

                    <div x-data="{ activeTab: 1 }" class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                        
                        <div class="lg:sticky lg:top-28">
                            <div class="relative h-96 w-full rounded-2xl shadow-xl overflow-hidden">
                                <div x-show="activeTab === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                    <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Discovery & Strategy">
                                </div>
                                <div x-show="activeTab === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                    <img src="https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Design & Prototyping">
                                </div>
                                <div x-show="activeTab === 3" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Development & Testing">
                                </div>
                                <div x-show="activeTab === 4" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Deployment & Support">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div @click="activeTab = 1" :class="activeTab === 1 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                                <h3 class="text-xl font-bold text-gray-900">1. Discovery & Strategy</h3>
                                <p :class="activeTab === 1 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                                    Setiap proyek sukses dimulai dengan pemahaman mendalam. Kami melakukan wawancara, analisis data, dan riset pasar untuk mendefinisikan tantangan inti dan menyusun peta jalan strategis menuju kesuksesan.
                                </p>
                            </div>
                            <div @click="activeTab = 2" :class="activeTab === 2 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                                <h3 class="text-xl font-bold text-gray-900">2. Design & Prototyping</h3>
                                <p :class="activeTab === 2 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                                    Tim kami merancang antarmuka yang intuitif dan menarik. Kami membuat prototipe fungsional yang memungkinkan Anda melihat dan merasakan solusi potensial sejak dini untuk validasi konsep yang cepat.
                                </p>
                            </div>
                            <div @click="activeTab = 3" :class="activeTab === 3 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                                <h3 class="text-xl font-bold text-gray-900">3. Development & Testing</h3>
                                <p :class="activeTab === 3 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                                    Tim developer kami mengimplementasikan desain menjadi solusi perangkat lunak yang tangguh dan skalabel, diikuti dengan pengujian menyeluruh untuk memastikan kualitas, keamanan, dan performa tertinggi.
                                </p>
                            </div>
                            <div @click="activeTab = 4" :class="activeTab === 4 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                                <h3 class="text-xl font-bold text-gray-900">4. Deployment & Support</h3>
                                <p :class="activeTab === 4 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                                    Pekerjaan kami tidak berhenti saat peluncuran. Kami terus memantau kinerja, mengukur dampak di dunia nyata, dan memberikan dukungan berkelanjutan untuk memastikan solusi Anda terus optimal dan berkembang.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 4. Buktikan dengan Karya (Our Works) --}}
            <section class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Lihat Karya Terbaik Kami</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Kami bangga dengan solusi yang telah kami bangun bersama klien-klien kami.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($caseStudies as $caseStudy)
                            <div class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 hover:shadow-2xl">
                                <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}">
                                    <div class="h-64 overflow-hidden">
                                        <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/6366f1/FFFFFF?text=TechnoG' }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                                    </div>
                                    <div class="p-6">
                                        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600">{{ $caseStudy->category->name ?? 'Uncategorized' }}</p>
                                        <h3 class="mt-2 text-xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $caseStudy->title }}</h3>
                                        <p class="mt-3 text-base text-gray-500">{{ Str::limit($caseStudy->solution, 120) }}</p>
                                        <span class="mt-4 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">Lihat studi kasus &rarr;</span>
                                    </div>
                                a>
                            </div>
                        @empty
                            <p class="md:col-span-3 text-center text-gray-500 py-10">Portofolio akan segera ditambahkan.</p>
                        @endforelse
                    </div>
                    <div class="text-center mt-16">
                        <a href="{{ route('public.portfolio') }}" class="inline-block bg-indigo-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-indigo-700 transition-colors transform hover:scale-105">
                            Lihat Semua Portofolio
                        </a>
                    </div>
                </div>
            </section>
            
            {{-- Testimoni Klien --}}
            <section class="py-24 bg-white">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Apa Kata Klien Kami</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Kepercayaan dan kepuasan klien adalah prioritas utama kami.</p>
                    </div>
                    <div class="relative bg-gray-50 p-8 md:p-12 rounded-2xl shadow-xl border border-gray-200">
                        <svg class="absolute top-8 left-8 h-12 w-12 text-indigo-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                        </svg>
                        <p class="relative text-2xl font-medium text-gray-800 italic">"Bekerja sama dengan TechnoG adalah pengalaman yang luar biasa. Mereka benar-benar memahami visi kami dan mewujudkannya menjadi solusi yang melebihi ekspektasi."</p>
                        <footer class="mt-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Foto Klien">
                                </div>
                                <div class="ml-4">
                                    <div class="text-base font-medium text-gray-900">Sarah L.</div>
                                    <div class="text-base text-gray-500">CEO, Maju Startup</div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </section>

        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>