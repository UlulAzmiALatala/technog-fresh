<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Insights & Latest News from TechnoG</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-white text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- Hero Section --}}
            <section class="relative text-white overflow-hidden">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1600&q=80" alt="Professional Blog" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/40 mix-blend-multiply"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                    {{-- [PENAMBAHAN] Wrapper untuk animasi fade-in --}}
                    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)" 
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" 
                         class="transition-all duration-1000 ease-out">
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">Insights & Analysis</h1>
                        <p class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto">Explore in-depth articles from our experts at the intersection of technology, data, and business strategy.</p>
                    </div>
                </div>
            </section>

            {{-- Main Blog Content --}}
            <section class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        {{-- Blog Posts (Left Column) --}}
                        <div class="lg:col-span-2 space-y-12">
                            @forelse ($posts as $post)
                                <article class="group bg-white p-6 rounded-2xl shadow-lg transition-shadow duration-300 hover:shadow-xl">
                                    <a href="{{ route('public.blog.show', $post->slug) }}">
                                        <img class="w-full h-80 object-cover rounded-lg" src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/1600x800/e2e8f0/cbd5e0?text=TechnoG' }}" alt="{{ $post->title }}">
                                    </a>
                                    <div class="mt-6">
                                        <p class="text-sm font-medium text-indigo-600">{{ $post->category->name ?? 'Uncategorized' }}</p>
                                        <a href="{{ route('public.blog.show', $post->slug) }}">
                                            <h2 class="mt-2 text-2xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $post->title }}</h2>
                                        </a>
                                        <p class="mt-3 text-base text-gray-500 line-clamp-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->body), 200) }}</p>
                                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                            <span>By {{ $post->user->name ?? 'Admin' }}</span>
                                            <span>{{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="bg-white p-12 rounded-lg shadow-md text-center">
                                    <p class="text-gray-500">No articles have been published yet.</p>
                                </div>
                            @endforelse

                            {{-- Pagination --}}
                            <div class="mt-12">
                                {{ $posts->links() }}
                            </div>
                        </div>

                        {{-- Sidebar (Right Column) --}}
                        <aside class="lg:sticky lg:top-28 self-start space-y-8">
                            <div class="bg-white p-6 rounded-2xl shadow-lg">
                                <h3 class="font-bold text-gray-900 mb-4 text-lg">Categories</h3>
                                <ul class="space-y-2 text-gray-600">
                                    @forelse ($categories as $category)
                                        <li><a href="#" class="hover:text-indigo-600 transition-colors">{{ $category->name }}</a></li>
                                    @empty
                                        <li>No categories yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-lg">
                                <h3 class="font-bold text-gray-900 mb-4 text-lg">Recent Posts</h3>
                                <ul class="space-y-4">
                                    @foreach ($posts->take(3) as $recentPost)
                                        <li><a href="{{ route('public.blog.show', $recentPost->slug) }}" class="font-medium text-gray-800 hover:text-indigo-600 transition-colors">{{ $recentPost->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            </section>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>
