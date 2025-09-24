<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - TechnoG Blog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-white text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- Wrapper Utama untuk Pemicu Animasi --}}
            <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)">
                <article class="py-24" x-data="{
                    share(platform) {
                        const url = encodeURIComponent(window.location.href);
                        const text = encodeURIComponent(document.title);
                        let shareUrl = '';

                        switch (platform) {
                            case 'facebook':
                                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                                break;
                            case 'twitter':
                                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
                                break;
                            case 'linkedin':
                                shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${url}&title=${text}`;
                                break;
                        }

                        if (shareUrl) {
                            window.open(shareUrl, 'share-window', 'height=450,width=550,toolbar=no,menubar=no,scrollbars=no,resizable=no');
                        }
                    }
                }">
                    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{-- Breadcrumbs --}}
                        <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             class="mb-8 text-sm text-gray-500 transition-all duration-700 ease-out">
                            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                            <span class="mx-2">&sol;</span>
                            <a href="{{ route('public.blog') }}" class="hover:text-indigo-600">Blog</a>
                        </div>

                        {{-- Article Header --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-8'"
                             class="text-center mb-12 transition-all duration-700 ease-out">
                            <p class="text-base font-semibold text-indigo-600">Article</p>
                            <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight">{{ $post->title }}</h1>
                            <div class="mt-6 flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://placehold.co/40x40/e2e8f0/64748b?text=' . substr($post->user->name, 0, 1) }}" alt="{{ $post->user->name }}">
                                </div>
                                <div>
                                    <span>By <span class="font-medium text-gray-900">{{ $post->user->name }}</span></span>
                                    <span class="mx-2">&middot;</span>
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Main Image --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-8'"
                             class="mb-12 group transition-all duration-700 ease-out">
                            <div class="overflow-hidden rounded-lg shadow-xl">
                                <img class="w-full h-auto max-h-[500px] object-cover rounded-lg transition-transform duration-300 ease-in-out group-hover:scale-105" 
                                     src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/1200x600/e2e8f0/cbd5e0?text=TechnoG' }}" 
                                     alt="{{ $post->title }}">
                            </div>
                        </div>

                        {{-- Content --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                             class="prose prose-lg max-w-none prose-indigo transition-all duration-700 ease-out">
                            {!! $post->body !!}
                        </div>

                        {{-- Share Buttons --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'"
                             class="mt-12 pt-8 border-t border-gray-200 transition-all duration-700 ease-out">
                            <h4 class="text-lg font-bold text-gray-900">Share This Article</h4>
                            <div class="mt-4 flex space-x-4">
                                <a href="#" @click.prevent="share('facebook')" class="text-gray-400 hover:text-blue-600 transition-colors"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                                <a href="#" @click.prevent="share('twitter')" class="text-gray-400 hover:text-sky-500 transition-colors"><span class="sr-only">Twitter</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg></a>
                                <a href="#" @click.prevent="share('linkedin')" class="text-gray-400 hover:text-blue-700 transition-colors"><span class="sr-only">LinkedIn</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                            </div>
                        </div>

                        {{-- Author Bio --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-[600ms]' : 'opacity-0 translate-y-8'"
                             class="mt-16 pt-8 border-t border-gray-200 flex items-center transition-all duration-700 ease-out">
                            <div class="flex-shrink-0">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://placehold.co/64x64/e2e8f0/64748b?text=' . substr($post->user->name, 0, 1) }}" alt="{{ $post->user->name }}">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-bold text-gray-900">{{ $post->user->name }}</h4>
                                <p class="text-gray-600">Writer at TechnoG Solutions</p>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Related Posts --}}
                <aside x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50 border-t border-gray-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            class="text-2xl font-bold text-gray-900 mb-8 transition-all duration-700 ease-out">
                            Read Other Articles
                        </h2>
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-8'"
                             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-700 ease-out">
                            @foreach ($relatedPosts as $relatedPost)
                                <div class="group">
                                    <a href="{{ route('public.blog.show', $relatedPost->slug) }}">
                                        <div class="overflow-hidden rounded-lg shadow-md">
                                            <img class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105" src="{{ $relatedPost->image ? asset('storage/' . $relatedPost->image) : 'https://placehold.co/600x400/e2e8f0/cbd5e0?text=TechnoG' }}" alt="{{ $relatedPost->title }}">
                                        </div>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $relatedPost->title }}</h3>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>