<x-public>

    <x-slot name="title">
        {{ $post->title }} - TechnoG Blog
    </x-slot>

    {{-- Wrapper Utama dengan overflow-x-hidden untuk mencegah bug horizontal scroll --}}
    <div class="relative overflow-x-hidden bg-white" x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)">
        
        {{-- Subtle Background Blobs untuk Header Artikel --}}
        <div class="absolute top-0 inset-x-0 h-[500px] overflow-hidden z-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-indigo-50/50 blur-[100px]"></div>
            <div class="absolute top-20 -left-20 w-[400px] h-[400px] rounded-full bg-cyan-50/50 blur-[100px]"></div>
        </div>

        <article class="pt-32 pb-24 relative z-10" x-data="{
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
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                {{-- Breadcrumbs (Sleek Style) --}}
                <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     class="mb-8 flex items-center justify-center space-x-2 text-sm text-gray-500 font-medium transition-all duration-700 ease-out">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                    <a href="{{ route('public.blog') }}" class="hover:text-indigo-600 transition-colors">Blog</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                    <span class="text-indigo-600 truncate max-w-[200px] sm:max-w-xs">{{ $post->title }}</span>
                </div>

                {{-- Article Header --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-8'"
                     class="text-center mb-12 transition-all duration-700 ease-out">
                    
                    {{-- Floating Category Badge --}}
                    <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold uppercase tracking-wider shadow-sm border border-indigo-100 mb-6">
                        {{ $post->category->name ?? 'Article' }}
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-[1.15] max-w-3xl mx-auto">
                        {{ $post->title }}
                    </h1>
                    
                    <div class="mt-8 flex items-center justify-center space-x-6 text-sm text-gray-500 font-medium">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-400 p-[2px] shadow-md">
                                <img class="h-full w-full rounded-full object-cover border-2 border-white" 
                                     src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://placehold.co/40x40/e2e8f0/64748b?text=' . substr($post->user->name, 0, 1) }}" 
                                     alt="{{ $post->user->name }}">
                            </div>
                            <span class="text-gray-900">{{ $post->user->name }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Main Image Showcase --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-12'"
                     class="mb-16 relative transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-indigo-500 rounded-[2.5rem] blur-2xl opacity-10 translate-y-4"></div>
                    <div class="relative overflow-hidden rounded-[2.5rem] shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-gray-100 bg-white p-2">
                        <img class="w-full h-auto max-h-[600px] object-cover rounded-[2rem]"
                             src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/1200x600/e2e8f0/cbd5e0?text=TechnoG' }}"
                             alt="{{ $post->title }}">
                    </div>
                </div>

                {{-- Content Body (Dioptimalkan agar sangat rapi dan enak dibaca) --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                     class="prose prose-lg md:prose-xl max-w-none prose-indigo prose-headings:font-bold prose-headings:text-gray-900 prose-p:text-gray-600 prose-p:leading-relaxed prose-a:text-indigo-600 prose-a:font-semibold hover:prose-a:text-indigo-500 prose-img:rounded-[1.5rem] prose-img:shadow-lg prose-blockquote:border-l-indigo-500 prose-blockquote:bg-gray-50 prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:rounded-r-2xl prose-blockquote:not-italic prose-blockquote:text-gray-700 transition-all duration-700 ease-out">
                    {!! $post->body !!}
                </div>

                {{-- Author Box & Share (Premium Card Design) --}}
                <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'"
                     class="mt-20 p-8 sm:p-10 bg-gray-50 rounded-[2.5rem] border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col md:flex-row items-center justify-between gap-8 transition-all duration-700 ease-out">
                    
                    {{-- Author Bio --}}
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0 relative">
                            <div class="absolute inset-0 bg-indigo-400 rounded-full blur-md opacity-40"></div>
                            <img class="relative h-20 w-20 rounded-full object-cover border-4 border-white shadow-md" 
                                 src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://placehold.co/80x80/e2e8f0/64748b?text=' . substr($post->user->name, 0, 1) }}" 
                                 alt="{{ $post->user->name }}">
                        </div>
                        <div>
                            <p class="text-sm font-bold tracking-widest text-indigo-500 uppercase mb-1">Written By</p>
                            <h4 class="text-2xl font-extrabold text-gray-900">{{ $post->user->name }}</h4>
                            <p class="text-gray-500 mt-1 font-medium">Writer at TechnoG Solutions</p>
                        </div>
                    </div>

                    {{-- Vertical Divider (Desktop only) --}}
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>

                    {{-- Share Buttons --}}
                    <div class="text-center md:text-left">
                        <p class="text-sm font-bold tracking-widest text-gray-400 uppercase mb-4">Share Article</p>
                        <div class="flex items-center gap-3">
                            {{-- Facebook --}}
                            <button @click.prevent="share('facebook')" class="h-12 w-12 rounded-full bg-white border border-gray-200 text-gray-400 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                <span class="sr-only">Facebook</span>
                                <i class="fa-brands fa-facebook-f fa-lg"></i>
                            </button>
                            {{-- Twitter / X --}}
                            <button @click.prevent="share('twitter')" class="h-12 w-12 rounded-full bg-white border border-gray-200 text-gray-400 hover:bg-black hover:text-white hover:border-black shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                <span class="sr-only">Twitter</span>
                                <i class="fa-brands fa-x-twitter fa-lg"></i>
                            </button>
                            {{-- LinkedIn --}}
                            <button @click.prevent="share('linkedin')" class="h-12 w-12 rounded-full bg-white border border-gray-200 text-gray-400 hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center">
                                <span class="sr-only">LinkedIn</span>
                                <i class="fa-brands fa-linkedin-in fa-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </article>

        {{-- Related Posts Section --}}
        <aside class="py-24 bg-slate-900 relative overflow-hidden" x-data="{ animateRelated: false }" x-intersect.once="animateRelated = true">
            {{-- Dark Futuristic BG Elements --}}
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-indigo-600/20 blur-[150px] -translate-y-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 :class="animateRelated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="text-sm font-bold tracking-widest text-cyan-400 uppercase tracking-[0.2em] transition-all duration-700 ease-out">
                        Keep Exploring
                    </h2>
                    <h3 :class="animateRelated ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-8'"
                        class="mt-2 text-3xl md:text-4xl font-extrabold text-white tracking-tight transition-all duration-700 ease-out">
                        Read Other Articles
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($relatedPosts as $index => $relatedPost)
                        {{-- Card Desain Konsisten dengan Index Blog --}}
                        <div :class="animateRelated ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                             class="group bg-white/5 backdrop-blur-xl rounded-[2rem] p-4 sm:p-6 shadow-[0_8px_32px_rgba(0,0,0,0.3)] border border-white/10 transition-all duration-500 ease-out hover:-translate-y-2 hover:bg-white/10 hover:border-white/20"
                             style="transition-delay: {{ ($index + 2) * 150 }}ms;">
                            
                            <a href="{{ route('public.blog.show', $relatedPost->slug) }}" class="block relative overflow-hidden rounded-[1.5rem]">
                                {{-- Floating Category Badge --}}
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-indigo-700 text-[10px] font-bold uppercase tracking-wider shadow-lg">
                                        {{ $relatedPost->category->name ?? 'Article' }}
                                    </span>
                                </div>
                                
                                {{-- Image with Zoom Effect --}}
                                <div class="relative h-48 w-full bg-gray-800 overflow-hidden">
                                    <div class="absolute inset-0 bg-gray-900/20 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out" 
                                         src="{{ $relatedPost->image ? asset('storage/' . $relatedPost->image) : 'https://placehold.co/600x400/1e293b/cbd5e0?text=TechnoG' }}" 
                                         alt="{{ $relatedPost->title }}">
                                </div>
                            </a>
                            
                            <div class="mt-6 px-2">
                                <a href="{{ route('public.blog.show', $relatedPost->slug) }}">
                                    <h3 class="text-xl font-bold text-white group-hover:text-cyan-400 transition-colors leading-snug line-clamp-2">
                                        {{ $relatedPost->title }}
                                    </h3>
                                </a>
                                <div class="mt-4 flex items-center justify-between text-xs text-gray-400 font-medium border-t border-white/10 pt-4">
                                    <span>{{ $relatedPost->user->name ?? 'TechnoG Team' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($relatedPost->published_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>

</x-public>