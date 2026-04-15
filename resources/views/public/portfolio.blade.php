<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Success Stories - Client Achievements | TechnoG Solutions
    </x-slot>

    {{-- Hero Section (Standar Emas) --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80" alt="Professional Case Studies" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-48 pb-24 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    
                    {{-- Judul diperpanjang agar proporsional dan elegan saat dibagi 2 baris --}}
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300 pb-2 leading-tight">
                        Transformative Results & <br class="hidden sm:block"> Client Success Stories
                    </h1>
                    
                    <p class="fade-in-item mt-6 text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        See how we apply a data-driven approach to solve real-world problems and deliver measurable results for our clients.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Konten Utama Portfolio --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50 relative overflow-hidden">
        {{-- Aesthetic Background Elements --}}
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-indigo-50/80 rounded-full blur-[100px] pointer-events-none -translate-y-1/4 -translate-x-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-cyan-50/80 rounded-full blur-[100px] pointer-events-none translate-y-1/4 translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- Navigation / Back Button (Modern Pill) --}}
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="mb-12 transition-all duration-700 ease-out">
                <a href="{{ url()->previous() }}" class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 text-sm font-bold shadow-sm transition-all duration-300">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Back to previous
                </a>
            </div>
            
            {{-- Header Text --}}
            <div :class="animate ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-8'" class="mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Featured Case Studies
                </h2>
                <div class="w-20 h-1.5 bg-indigo-500 rounded-full mt-6"></div>
            </div>

            {{-- Portfolio Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($caseStudies as $index => $caseStudy)
                    {{-- Portfolio Card (SaaS Style) --}}
                    <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         class="group bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(99,102,241,0.12)] border border-gray-100 overflow-hidden transform hover:-translate-y-2 transition-all duration-500 p-4 flex flex-col h-full"
                         style="transition-delay: {{ ($index + 2) * 100 }}ms;">
                        
                        <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}" class="block flex-grow flex flex-col">
                            {{-- Image Container --}}
                            <div class="relative h-64 overflow-hidden rounded-[1.5rem] shrink-0">
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                <img alt="{{ $caseStudy->title }}" 
                                     src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/6366f1/FFFFFF?text=TechnoG' }}" 
                                     class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                
                                {{-- Floating Category Badge --}}
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-extrabold uppercase tracking-wider text-indigo-700 shadow-lg border border-white/50">
                                        {{ $caseStudy->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Content Text --}}
                            <div class="p-4 mt-2 flex flex-col flex-grow">
                                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight line-clamp-2">
                                    {{ $caseStudy->title }}
                                </h3>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3 leading-relaxed flex-grow">
                                    {{ Str::limit(strip_tags($caseStudy->solution), 150) }}
                                </p>
                                
                                {{-- Action Link --}}
                                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center text-sm font-bold text-indigo-600 group-hover:text-indigo-800 transition-colors uppercase tracking-wide shrink-0">
                                    Read Full Story <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    {{-- Empty State Premium --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-12'" class="md:col-span-2 lg:col-span-3 bg-white border border-dashed border-gray-300 rounded-[2.5rem] p-16 text-center transition-all duration-700 ease-out shadow-sm">
                        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-indigo-50 shadow-inner mb-6 text-indigo-400">
                            <i class="fa-solid fa-briefcase fa-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Success Stories Coming Soon</h3>
                        <p class="mt-3 text-lg text-gray-500 max-w-lg mx-auto">We are currently curating and documenting our best client collaborations to showcase here.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Custom Pagination --}}
            <div class="mt-16 pt-8">
                {{ $caseStudies->links() }}
            </div>
        </div>
    </section>

    {{-- [WAJIB] CSS untuk Efek Fade In --}}
    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

</x-public>