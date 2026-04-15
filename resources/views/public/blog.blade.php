<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Blog - Insights & Latest News from TechnoG
    </x-slot>

    {{-- Hero Section: Sama Persis dengan Referensi About Us --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&w=1600&q=80" alt="Professional Blog" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            
            {{-- Padding disamakan: pt-56 pb-20 --}}
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-48 pb-24 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    
                    {{-- Judul diperpanjang agar proporsional saat dibagi 2 baris --}}
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300 pb-2 leading-tight">
                        Expert Insights & <br class="hidden sm:block"> Strategic Analysis
                    </h1>
                    
                    <p class="fade-in-item mt-6 text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        Explore in-depth articles from our experts at the intersection of technology, data, and business strategy.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Main Blog Content dengan State sidebarOpen untuk versi Mobile --}}
    <section x-data="{ animate: false, sidebarOpen: false }" x-intersect.once="animate = true" class="py-20 bg-gray-50 overflow-x-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- Blog Posts (Left Column - 8 cols span) --}}
                <div class="lg:col-span-8 space-y-12">
                    @forelse ($posts as $index => $post)
                        <article :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                                 class="group bg-white rounded-[2rem] p-4 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 ease-out hover:shadow-[0_20px_40px_rgba(99,102,241,0.1)] hover:-translate-y-2 border border-gray-100"
                                 style="transition-delay: {{ $index * 150 }}ms;">
                            
                            <a href="{{ route('public.blog.show', $post->slug) }}" class="block relative overflow-hidden rounded-[1.5rem]">
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="px-4 py-1.5 rounded-full bg-white/90 backdrop-blur-md text-indigo-700 text-xs font-bold uppercase tracking-wider shadow-lg border border-white/50">
                                        {{ $post->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                                
                                <div class="relative h-64 sm:h-80 w-full bg-gray-200 overflow-hidden">
                                    <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out" 
                                         src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/1600x800/e2e8f0/cbd5e0?text=TechnoG' }}" 
                                         alt="{{ $post->title }}">
                                </div>
                            </a>
                            
                            <div class="mt-8 px-2 sm:px-4">
                                <a href="{{ route('public.blog.show', $post->slug) }}" class="block">
                                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight">
                                        {{ $post->title }}
                                    </h2>
                                </a>
                                <p class="mt-4 text-base sm:text-lg text-gray-500 line-clamp-3 leading-relaxed">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 200) }}
                                </p>
                                
                                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500 font-medium">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center">
                                            <i class="fa-solid fa-user-astronaut"></i>
                                        </div>
                                        <span>{{ $post->user->name ?? 'TechnoG Team' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-calendar-days text-gray-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'" class="bg-white p-12 rounded-[2rem] shadow-lg border border-dashed border-gray-300 text-center transition-all duration-700 ease-out">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 text-gray-400 mb-4">
                                <i class="fa-solid fa-pen-nib fa-2x"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">No Articles Yet</h3>
                            <p class="mt-2 text-gray-500">Our experts are currently brewing some brilliant insights. Check back soon!</p>
                        </div>
                    @endforelse

                    <div class="mt-16 pt-8">
                        {{ $posts->links() }}
                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- MOBILE POP-UP (BOTTOM SHEET) & DESKTOP LOGIC --}}
                {{-- ========================================== --}}

                {{-- Tombol Floating Action Button (Berubah jadi Pill di Tengah Bawah) --}}
                <div class="lg:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-[90]">
                    <button @click="sidebarOpen = true" 
                            class="bg-gray-900 text-white px-6 py-3.5 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.4)] flex items-center justify-center gap-3 hover:bg-gray-800 hover:scale-105 transition-all duration-300 border border-white/10 backdrop-blur-md">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="font-bold tracking-wide">Explore Topics</span>
                    </button>
                </div>

                {{-- Physical Backdrop untuk Mobile Slide-up --}}
                <div x-show="sidebarOpen" 
                     x-transition.opacity.duration.400ms 
                     @click="sidebarOpen = false" 
                     class="fixed inset-0 bg-gray-900/60 z-[100] lg:hidden backdrop-blur-sm" style="display: none;"></div>

                {{-- Area Sidebar (Desktop: Kanan / Mobile: Muncul dari Bawah) --}}
                <aside :class="sidebarOpen ? 'translate-y-0' : 'translate-y-full lg:translate-y-0'"
                       class="fixed inset-x-0 bottom-0 z-[110] max-h-[85vh] bg-white rounded-t-[2.5rem] p-6 sm:p-8 overflow-y-auto transition-transform duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] lg:static lg:w-auto lg:h-auto lg:max-h-none lg:rounded-none lg:bg-transparent lg:p-0 lg:col-span-4 lg:sticky lg:top-28 space-y-8 shadow-[0_-10px_40px_rgba(0,0,0,0.1)] lg:shadow-none order-first lg:order-last">
                    
                    {{-- Header Mobile Sidebar dengan Indikator Drag --}}
                    <div class="lg:hidden mb-6 flex flex-col items-center">
                        <div class="w-12 h-1.5 bg-gray-300 rounded-full mb-6"></div>
                        <div class="w-full flex items-center justify-between">
                            <h2 class="text-2xl font-extrabold text-gray-900">Explore Topics</h2>
                            <button @click="sidebarOpen = false" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark fa-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Widget: Categories --}}
                    <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform group-hover:scale-150 duration-700"></div>
                        <h3 class="font-bold text-gray-900 mb-6 text-xl relative z-10 flex items-center gap-3">
                            <i class="fa-solid fa-layer-group text-indigo-500"></i> Categories
                        </h3>
                        <ul class="space-y-3 relative z-10">
                            @forelse ($categories as $category)
                                <li>
                                    <a href="#" class="group/link flex items-center justify-between p-3 rounded-xl hover:bg-indigo-50 text-gray-600 hover:text-indigo-700 transition-all duration-300">
                                        <span class="font-medium transform group-hover/link:translate-x-2 transition-transform duration-300">{{ $category->name }}</span>
                                        <i class="fa-solid fa-chevron-right text-xs opacity-0 group-hover/link:opacity-100 transform -translate-x-4 group-hover/link:translate-x-0 transition-all duration-300"></i>
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-400 italic px-3">No categories available.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Widget: Recent Posts --}}
                    <div class="bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50 rounded-full blur-3xl -mr-10 -mt-10 transition-transform group-hover:scale-150 duration-700"></div>
                        <h3 class="font-bold text-gray-900 mb-6 text-xl relative z-10 flex items-center gap-3">
                            <i class="fa-solid fa-fire text-cyan-500"></i> Recent Posts
                        </h3>
                        <ul class="space-y-5 relative z-10">
                            @foreach ($posts->take(3) as $recentPost)
                                <li>
                                    <a href="{{ route('public.blog.show', $recentPost->slug) }}" class="group/post flex gap-4 items-start">
                                        <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 shadow-sm">
                                            <img class="w-full h-full object-cover transform group-hover/post:scale-110 transition-transform duration-500" 
                                                 src="{{ $recentPost->image ? asset('storage/' . $recentPost->image) : 'https://placehold.co/150x150/e2e8f0/cbd5e0?text=News' }}" 
                                                 alt="{{ $recentPost->title }}">
                                        </div>
                                        <div class="flex flex-col justify-center h-full pt-1">
                                            <h4 class="font-semibold text-gray-800 leading-tight group-hover/post:text-cyan-600 transition-colors line-clamp-2">
                                                {{ $recentPost->title }}
                                            </h4>
                                            <span class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                                <i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($recentPost->published_at)->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

            </div>
        </div>
    </section>

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