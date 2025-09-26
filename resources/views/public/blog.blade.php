<x-public>

    {{-- Sets the specific title for this page --}}
    <x-slot name="title">
        Blog - Insights & Latest News from TechnoG
    </x-slot>

    {{-- HERO SLOT FILLED WITH A STATIC IMAGE HERO --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?auto=format&fit=crop&w=1600&q=80" alt="Professional Blog" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => {
                    $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                    setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                })">
                    <h1 x-ref="heading" class="text-4xl sm:text-5xl font-extrabold tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">
                        Insights & Analysis
                    </h1>
                    <p x-ref="paragraph" class="mt-4 text-lg text-gray-200 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">
                        Explore in-depth articles from our experts at the intersection of technology, data, and business strategy.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Main Blog Content --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                {{-- Blog Posts (Left Column) --}}
                <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     class="lg:col-span-2 space-y-12 transition-all duration-700 ease-out">
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
                <aside :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                       class="lg:sticky lg:top-28 self-start space-y-8 transition-all duration-700 ease-out">
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

</x-public>