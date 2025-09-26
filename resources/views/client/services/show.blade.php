<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                 {{-- [PERBAIKAN] Tombol kembali dibuat lebih jelas --}}
                 <a href="{{ route('client.services.list') }}" class="p-2 rounded-full text-gray-500 hover:bg-gray-200 hover:text-gray-800 transition-colors duration-200">
                     <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                 </a>
                <h2 class="ml-2 font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Layanan') }}</h2>
            </div>
        </div>
    </x-slot>

    <main class="bg-white pt-10 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">

                {{-- Kolom Kiri: Galeri Gambar --}}
                <aside class="lg:col-span-5 lg:sticky lg:top-8 self-start">
                    @php
                        $galleryImages = collect($service->gallery ?? [])->filter()->prepend($service->image)->unique()->map(function($path) {
                            return asset('storage/' . $path);
                        })->toArray();
                        $mainImage = $galleryImages[0] ?? 'https://placehold.co/800x600/CCD3D8/334155?text=TechnoG';
                    @endphp
                    <div x-data="{ mainImage: '{{ $mainImage }}' }" class="flex flex-col">
                        <div class="relative w-full overflow-hidden rounded-2xl shadow-xl mb-4 group" style="padding-top: 100%;">
                            <img :src="mainImage" alt="{{ $service->name }}" class="absolute inset-0 w-full h-full object-cover transition-all duration-300 ease-in-out group-hover:scale-105">
                        </div>
                        @if(count($galleryImages) > 1)
                            <div class="grid grid-cols-5 gap-3">
                                @foreach($galleryImages as $imageUrl)
                                    <div @click="mainImage = '{{ $imageUrl }}'" class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden cursor-pointer ring-2 ring-transparent hover:ring-indigo-500 transition-all duration-200" :class="{ 'ring-indigo-500 shadow-md scale-105': mainImage === '{{ $imageUrl }}' }">
                                        <img src="{{ $imageUrl }}" alt="Thumbnail" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </aside>

                {{-- Kolom Kanan: Detail Layanan --}}
                <div class="lg:col-span-7 mt-12 lg:mt-0">
                    {{-- Judul dan Deskripsi --}}
                    <div class="mb-10">
                        @if ($service->category)
                            <span class="inline-block bg-gray-100 text-gray-700 text-sm font-semibold px-4 py-2 rounded-full tracking-wide">{{ $service->category->name }}</span>
                        @endif
                        <h1 class="mt-4 text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">{{ $service->name }}</h1>
                        <div class="mt-3 flex items-center gap-x-3 text-sm">
                             @if(isset($service->orders_count) && $service->orders_count > 10)
                                 <span class="inline-flex items-center gap-x-1.5 rounded-full bg-yellow-100 px-3 py-1 font-medium text-yellow-800"><svg class="h-2 w-2 fill-yellow-500" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" /></svg>Best Seller</span>
                             @elseif($service->created_at->gt(now()->subDays(7)))
                                 <span class="inline-flex items-center gap-x-1.5 rounded-full bg-indigo-100 px-3 py-1 font-medium text-indigo-800"><svg class="h-2 w-2 fill-indigo-500" viewBox="0 0 6 6"><circle cx="3" cy="3" r="3" /></svg>Baru</span>
                             @endif
                        </div>
                        <p class="mt-6 text-lg text-gray-600 leading-relaxed">{{ $service->description }}</p>
                    </div>

                    {{-- Bagian Fitur --}}
                    <div class="mb-10 py-8 border-t border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Apa yang Anda Dapatkan</h2>
                        
                        {{-- (DIPERBAIKI) Logika untuk membaca fitur dari format JSON atau teks biasa --}}
                        @php
                            $featuresList = [];
                            if (!empty($service->features)) {
                                // Coba decode sebagai JSON
                                $decodedFeatures = json_decode($service->features, true);
                                
                                // Cek apakah decoding berhasil dan hasilnya adalah array
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedFeatures)) {
                                    $featuresList = $decodedFeatures;
                                } else {
                                    // Fallback ke metode lama (explode by newline) jika bukan JSON valid
                                    $featuresList = explode("\n", $service->features);
                                }
                            }
                        @endphp

                        @if(!empty($featuresList))
                            <ul class="space-y-4">
                                @foreach($featuresList as $feature)
                                    @if(trim($feature))
                                        <li class="flex items-start">
                                            <div class="flex-shrink-0 pt-1"><i class="fa-solid fa-check-circle text-green-500"></i></div>
                                            <p class="ml-3 text-base text-gray-700">{{ trim(str_replace(['-', '"'], '', $feature)) }}</p>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="italic text-gray-500">Fitur detail untuk layanan ini belum tersedia.</p>
                        @endif
                    </div>
                    
                    {{-- Kotak Pemesanan --}}
                    <div x-ref="orderSection" class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Mulai dari</span>
                                <p class="text-4xl font-extrabold text-indigo-600">$ {{ number_format($service->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-left md:text-right">
                                <span class="text-sm font-medium text-gray-600">Estimasi Pengerjaan</span>
                                <p class="text-lg font-bold text-gray-900">{{ $service->estimated_duration }} {{ $service->duration_unit }}</p>
                            </div>
                        </div>
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <form x-data="{ loading: false }" action="{{ route('client.services.order', $service->id) }}" method="POST" @submit="loading = true" class="w-full">
                                @csrf
                                <button type="submit" :disabled="loading" :class="{'opacity-60 cursor-not-allowed': loading}" class="w-full h-full inline-flex items-center justify-center px-6 py-4 bg-indigo-600 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-indigo-500/50">
                                    <span x-show="!loading" class="inline-flex items-center"><i class="fa-solid fa-cart-shopping mr-3"></i>Pesan Sekarang</span>
                                    <span x-show="loading" class="inline-flex items-center"><i class="fa-solid fa-spinner fa-spin -ml-1 mr-3 h-5 w-5"></i>Memproses...</span>
                                </button>
                            </form>
                            <div class="mt-4 flex items-stretch justify-center gap-3">
                                <div x-data="{ open: false }" @click.outside="open = false" class="relative w-full flex-grow">
                                    <button @click="open = !open" class="w-full h-full inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-800 hover:bg-gray-100 transition-all duration-200">
                                        <i class="fa-regular fa-comment-dots fa-lg text-gray-600 mr-2"></i>
                                        <span>Hubungi Kami</span>
                                        <i class="fa-solid fa-chevron-down ml-2 -mr-1 h-4 w-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                                    </button>
                                    <div x-show="open" x-transition class="absolute bottom-full mb-2 w-56 origin-bottom-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10" style="display: none;">
                                        <div class="py-1">
                                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20layanan%20'{{ urlencode($service->name) }}'" target="_blank" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fa-brands fa-whatsapp fa-lg mr-3 text-green-500"></i>
                                                Chat via WA
                                            </a>
                                            <a href="javascript:void(0)" onclick="openChatWidget()" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fa-solid fa-headset fa-lg mr-3 text-indigo-500"></i>
                                                Live Chat Website
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="// Logika Share di sini" class="flex-shrink-0 inline-flex items-center justify-center p-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200">
                                    <i class="fa-solid fa-share-nodes fa-lg text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-24 pt-16 border-t border-gray-200">
             @if(($service->testimonials ?? collect())->isNotEmpty())
                 <div class="mb-20">
                     <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">Apa Kata Klien Kami</h2>
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                         @foreach($service->testimonials as $testimonial)
                             <figure class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                                 <blockquote class="text-gray-700 italic leading-relaxed">“{{ $testimonial->quote }}”</blockquote>
                                 <figcaption class="mt-4 pt-4 border-t border-gray-200">
                                     <div class="font-semibold text-gray-900">{{ $testimonial->author }}</div>
                                     <div class="text-sm text-gray-600">{{ $testimonial->position }}</div>
                                 </figcaption>
                             </figure>
                         @endforeach
                     </div>
                 </div>
             @endif
            
             @if($relatedServices->count() > 0)
                 <div>
                     <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-12">Anda Mungkin Juga Tertarik</h2>
                     <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                         @foreach($relatedServices as $relatedService)
                             @include('client.partials.service-card', ['service' => $relatedService])
                         @endforeach
                     </div>
                 </div>
             @endif
        </div>
    </main>

    @include('layouts.partials.app-footer')
</x-app-layout>

