<x-public>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Studi Kasus - Kisah Sukses Klien | TechnoG Solutions
    </x-slot>

    {{-- KANTONG HERO DIISI DENGAN HERO GAMBAR STATIS --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80" alt="Professional Case Studies" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                <div x-data="{}" x-init="$nextTick(() => {
                    $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                    setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                })">
                    <h1 x-ref="heading" class="text-4xl sm:text-5xl font-extrabold tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">Studi Kasus Kami</h1>
                    <p x-ref="paragraph" class="mt-4 text-lg text-gray-200 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">Lihat bagaimana kami menerapkan pendekatan berbasis data untuk menyelesaikan masalah nyata dan memberikan hasil yang terukur bagi klien kami.</p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Konten utama halaman Portofolio --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb untuk navigasi balik (opsional, bisa disesuaikan) --}}
            <div class="mb-12 text-sm">
                <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-indigo-600 transition-colors">
                    &larr; Kembali ke halaman sebelumnya
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @forelse ($caseStudies as $caseStudy)
                    <div x-data="{}" x-intersect:enter.once="$el.classList.add('animate-fade-in-up')"
                         class="opacity-0 group bg-white rounded-lg shadow-xl overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
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
            
            {{-- Pagination Links --}}
            <div class="mt-16">
                {{ $caseStudies->links() }}
            </div>
        </div>
    </section>

</x-public>