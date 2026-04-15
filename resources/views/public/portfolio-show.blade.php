<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        {{ $caseStudy->title }} - A TechnoG Success Story
    </x-slot>

    {{-- Wrapper Utama dengan animasi load dan overflow hidden --}}
    <div class="relative overflow-x-hidden bg-white" x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)">
        
        {{-- Subtle Background Blobs untuk Header Artikel --}}
        <div class="absolute top-0 inset-x-0 h-[600px] overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-indigo-50/80 blur-[100px]"></div>
            <div class="absolute top-20 -left-20 w-[400px] h-[400px] rounded-full bg-cyan-50/80 blur-[100px]"></div>
        </div>

        <article class="pt-32 pb-24 relative z-10">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- Breadcrumbs & Back Button --}}
                <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     class="mb-12 transition-all duration-700 ease-out">
                    <a href="{{ route('public.portfolio') }}" class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 text-sm font-bold shadow-sm transition-all duration-300">
                        <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Back to Success Stories
                    </a>
                </div>

                {{-- Executive Header --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-8'"
                     class="mb-16 transition-all duration-700 ease-out">
                    
                    {{-- Floating Category Badge --}}
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold uppercase tracking-wider shadow-sm border border-indigo-100 mb-6">
                        <i class="fa-solid fa-layer-group text-indigo-500"></i> {{ $caseStudy->category->name ?? 'Uncategorized' }}
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.15]">
                        {{ $caseStudy->title }}
                    </h1>
                    
                    {{-- Client Meta Data Bar --}}
                    <div class="mt-8 inline-flex flex-wrap items-center gap-6 sm:gap-10 px-8 py-4 bg-gray-50 border border-gray-100 rounded-2xl shadow-sm">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Client</p>
                            <p class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-building text-indigo-500"></i> {{ $caseStudy->client_name }}
                            </p>
                        </div>
                        <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Project Type</p>
                            <p class="text-base font-medium text-gray-700">{{ $caseStudy->category->name ?? 'Enterprise Solution' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Cinematic Main Image Showcase --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-12'"
                     class="mb-20 relative transition-all duration-700 ease-out group">
                    {{-- Glowing shadow --}}
                    <div class="absolute inset-0 bg-indigo-500 rounded-[2.5rem] blur-2xl opacity-10 translate-y-4 group-hover:opacity-20 transition-opacity duration-500"></div>
                    
                    <div class="relative overflow-hidden rounded-[2.5rem] shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-gray-100 bg-white p-2">
                        <img class="w-full h-auto max-h-[550px] object-cover rounded-[2rem] transform group-hover:scale-[1.02] transition-transform duration-700 ease-out"
                             src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/1200x600/e2e8f0/cbd5e0?text=TechnoG' }}"
                             alt="{{ $caseStudy->title }}">
                    </div>
                </div>

                {{-- Structured Case Study Content (Color Psychology Cards) --}}
                <div class="space-y-12">
                    
                    {{-- 1. The Challenge (Rose / Red) --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                         class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden transition-all duration-700 ease-out hover:shadow-lg">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-full blur-3xl -mr-10 -mt-10"></div>
                        <div class="relative z-10 flex flex-col md:flex-row gap-8">
                            <div class="shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shadow-inner">
                                    <i class="fa-solid fa-triangle-exclamation fa-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">The Challenge</h2>
                                <div class="prose prose-lg text-gray-600 leading-relaxed">
                                    {!! nl2br(e($caseStudy->problem)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Our Solution (Indigo / Blue) --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-[400ms]' : 'opacity-0 translate-y-8'"
                         class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden transition-all duration-700 ease-out hover:shadow-lg">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-50 rounded-full blur-3xl -ml-10 -mt-10"></div>
                        <div class="relative z-10 flex flex-col md:flex-row gap-8">
                            <div class="shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shadow-inner">
                                    <i class="fa-solid fa-lightbulb fa-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Our Solution</h2>
                                <div class="prose prose-lg text-gray-600 leading-relaxed">
                                    {!! nl2br(e($caseStudy->solution)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. The Results (Emerald / Green) --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-[500ms]' : 'opacity-0 translate-y-8'"
                         class="bg-emerald-50/50 rounded-[2rem] p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-emerald-100 relative overflow-hidden transition-all duration-700 ease-out hover:shadow-lg">
                        <div class="absolute bottom-0 right-0 w-40 h-40 bg-emerald-200/50 rounded-full blur-3xl -mr-10 -mb-10"></div>
                        <div class="relative z-10 flex flex-col md:flex-row gap-8">
                            <div class="shrink-0">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shadow-[0_10px_20px_rgba(16,185,129,0.3)]">
                                    <i class="fa-solid fa-chart-pie fa-2xl"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-3xl font-extrabold text-emerald-950 mb-4">The Results</h2>
                                <div class="prose prose-lg text-emerald-900/80 leading-relaxed font-medium">
                                    {!! nl2br(e($caseStudy->result)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </article>

        {{-- Beautiful Call To Action Footer --}}
        <section class="py-20 relative overflow-hidden bg-slate-900" x-data x-intersect.once="$el.classList.add('is-in-view')">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-indigo-600/30 rounded-full blur-[120px] pointer-events-none"></div>
            
            <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
                <h2 class="fade-in-item text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-6">
                    Ready to write your own success story?
                </h2>
                <p class="fade-in-item text-lg text-indigo-200 mb-10 max-w-2xl mx-auto">
                    Let's collaborate to solve your most complex challenges with our data-driven technology solutions.
                </p>
                <div class="fade-in-item flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-gray-900 bg-white hover:bg-gray-100 hover:scale-105 shadow-[0_0_20px_rgba(255,255,255,0.3)] transition-all duration-300">
                        Start a Conversation
                    </a>
                    <a href="{{ route('public.services') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white bg-white/10 hover:bg-white/20 border border-white/20 hover:scale-105 backdrop-blur-sm transition-all duration-300">
                        Explore Our Services
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- [WAJIB] CSS untuk Efek Fade In --}}
    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .is-in-view .fade-in-item,
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .is-in-view .fade-in-item:nth-child(3) { transition-delay: 0.3s; }
    </style>

</x-public>