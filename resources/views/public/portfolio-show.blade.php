<x-public>

    {{-- Memberi judul dinamis sesuai studi kasus yang dibuka --}}
    <x-slot name="title">
        {{ $caseStudy->title }} - TechnoG Case Study
    </x-slot>

    {{-- Tidak ada <x-slot name="hero">, semua konten masuk ke slot utama --}}

    <div class="bg-white">
        <article class="py-24 sm:py-32">
            <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)"
                 :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="transition-all duration-1000 ease-out max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- Breadcrumb Navigation --}}
                <div class="mb-8 text-sm text-gray-500">
                    <a href="{{ route('public.portfolio') }}" class="hover:text-indigo-600 transition-colors">
                        &larr; Kembali ke Semua Studi Kasus
                    </a>
                </div>

                {{-- Article Header --}}
                <div class="text-center mb-12">
                    <p class="text-base font-semibold text-indigo-600">{{ $caseStudy->category->name ?? 'Uncategorized' }}</p>
                    <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">{{ $caseStudy->title }}</h1>
                    <p class="mt-4 text-lg text-gray-500">Klien: <span class="font-medium text-gray-900">{{ $caseStudy->client_name }}</span></p>
                </div>

                {{-- Main Image --}}
                <div class="mb-12 group">
                    <div class="overflow-hidden rounded-2xl shadow-xl">
                        <img class="w-full h-auto max-h-[500px] object-cover transition-transform duration-500 ease-in-out group-hover:scale-105"
                             src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/1200x600/e2e8f0/cbd5e0?text=TechnoG' }}"
                             alt="{{ $caseStudy->title }}">
                    </div>
                </div>

                {{-- Article Content --}}
                <div class="prose prose-lg lg:prose-xl max-w-none text-gray-700 leading-relaxed space-y-12">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 border-l-4 border-indigo-500 pl-4">Tantangan</h2>
                        <div class="mt-4">{!! nl2br(e($caseStudy->problem)) !!}</div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 border-l-4 border-indigo-500 pl-4">Solusi Kami</h2>
                        <div class="mt-4">{!! nl2br(e($caseStudy->solution)) !!}</div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 border-l-4 border-indigo-500 pl-4">Hasil Akhir</h2>
                        <div class="mt-4">{!! nl2br(e($caseStudy->result)) !!}</div>
                    </div>
                </div>
            </div>
        </article>
    </div>

</x-public>