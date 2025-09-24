<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechnoG Solutions - Data-Driven Technology</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-900">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')
        <main>
            {{-- Hero Section --}}
            <section class="relative text-white overflow-hidden">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80" alt="Data Analytics Dashboard" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/80"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex items-center justify-center">
                    <div x-data="{}" x-init="$nextTick(() => {
                        $refs.line1.classList.remove('opacity-0', 'translate-y-4');
                        setTimeout(() => $refs.line2.classList.remove('opacity-0', 'translate-y-4'), 200);
                        setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 400);
                        setTimeout(() => $refs.buttons.classList.remove('opacity-0', 'translate-y-4'), 600);
                    })" class="text-center max-w-4xl">
                        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight">
                            <span x-ref="line1" class="block transition-all duration-700 ease-out opacity-0 translate-y-4">Precision Technology,</span>
                            <span x-ref="line2" class="block bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-indigo-500 transition-all duration-700 ease-out opacity-0 translate-y-4">Powered by Data</span>
                        </h1>
                        <p x-ref="paragraph" class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-gray-300 transition-all duration-700 ease-out opacity-0 translate-y-4">
                            We build advanced technology solutions on a strong foundation of statistical analysis, ensuring every decision and product delivers maximum accuracy and impact.
                        </p>
                        <div x-ref="buttons" class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4 transition-all duration-700 ease-out opacity-0 translate-y-4">
                            <a href="{{ route('public.services') }}" class="inline-block px-8 py-3 bg-indigo-600 font-semibold rounded-lg shadow-lg text-white hover:bg-indigo-500 transition-all duration-300 transform hover:scale-105">
                                Explore Services
                            </a>
                            <a href="{{ route('public.why-choose-us') }}" class="inline-block px-8 py-3 bg-white/10 border border-white/20 font-semibold rounded-lg text-white hover:bg-white/20 transition-all duration-300 backdrop-blur-sm">
                                Why Choose Us?
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Featured Services Section --}}
            <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center transition-all duration-700 ease-out">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Featured Services</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">The Right Solutions for Your Needs</p>
                    </div>
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 transition-all duration-700 ease-out">
                        @forelse ($services as $service)
                            <a href="{{ route('public.services') }}" class="group relative block bg-black rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden h-96 transition-all duration-300 hover:-translate-y-2">
                                <img alt="{{ $service->name }}" src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/600x800/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover opacity-80 transition-all duration-500 group-hover:opacity-60 group-hover:scale-110" />
                                <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-sm text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </div>
                                <div class="relative p-6 flex flex-col justify-between h-full bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                    <div>
                                        @if($service->package_plan)
                                            <span class="bg-black/50 text-white text-xs font-semibold px-3 py-1.5 rounded-full backdrop-blur-sm">{{ $service->package_plan }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">{{ $service->name }}</h3>
                                        <div class="mt-2 flex justify-between items-center">
                                            <p class="text-lg font-semibold text-white">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">Featured services will be displayed soon.</p>
                        @endforelse
                    </div>
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'" class="mt-16 text-center transition-all duration-700 ease-out">
                        <a href="{{ route('public.services') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold group inline-flex items-center gap-2">
                            <span>View all services</span>
                            <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </section>

            {{-- Case Studies Showcase --}}
            <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center transition-all duration-700 ease-out">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Success Stories</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Our Featured Portfolio</p>
                    </div>
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="mt-16 grid gap-8 lg:grid-cols-2 transition-all duration-700 ease-out">
                        @forelse ($caseStudies as $caseStudy)
                            <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}" class="group relative block bg-black rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2">
                                <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/374151/FFFFFF?text=TechnoG' }}" class="absolute inset-0 h-full w-full object-cover opacity-80 transition-all duration-500 group-hover:opacity-60 group-hover:scale-110" />
                                <div class="relative p-8 flex flex-col justify-end h-80 bg-gradient-to-t from-black/80 to-transparent">
                                    <span class="text-sm font-medium uppercase tracking-widest text-indigo-400">{{ $caseStudy->category->name ?? 'Case Study' }}</span>
                                    <h3 class="text-2xl font-bold text-white mt-2">{{ $caseStudy->title }}</h3>
                                    <div class="mt-4 flex items-center gap-2 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform -translate-y-2 group-hover:translate-y-0">
                                        <span>View Case Study</span>
                                        <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="lg:col-span-2 text-center text-gray-500">Featured case studies will be displayed soon.</p>
                        @endforelse
                    </div>
                </div>
            </section>
            
            {{-- Latest Blog Posts --}}
            <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center transition-all duration-700 ease-out">
                        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Blog</h2>
                        <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Insights & Latest News</p>
                    </div>
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3 transition-all duration-700 ease-out">
                        @forelse ($posts as $post)
                            <div class="flex flex-col rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 bg-white">
                                <div class="flex-shrink-0">
                                    <a href="{{ route('public.blog.show', $post->slug) }}">
                                        <img class="h-48 w-full object-cover" src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/800x600/e2e8f0/cbd5e0?text=TechnoG' }}" alt="{{ $post->title }}">
                                    </a>
                                </div>
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-indigo-600">{{ $post->category->name ?? 'Article' }}</p>
                                        <a href="{{ route('public.blog.show', $post->slug) }}" class="block mt-2">
                                            <p class="text-xl font-semibold text-gray-900 hover:text-indigo-700 transition-colors">{{ $post->title }}</p>
                                        </a>
                                    </div>
                                    <div class="mt-6 flex items-center">
                                        <div class="text-sm text-gray-500">
                                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">The latest articles will be displayed soon.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- Final CTA --}}
            <section class="bg-gradient-to-r from-gray-900 via-indigo-900 to-gray-900">
                <div class="max-w-3xl mx-auto text-center py-20 px-4 sm:py-24 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block">Have a Project in Mind?</span>
                        <span class="block text-indigo-400 mt-2">Let's Build It Together.</span>
                    </h2>
                    <a href="{{ route('public.contact') }}" class="mt-10 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 sm:w-auto transition-transform hover:scale-105 shadow-lg">
                        Contact Us
                    </a>
                </div>
            </section>
        </main>
        @include('layouts.public-footer')
    </div>
</body>
</html>