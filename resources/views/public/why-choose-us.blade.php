<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Why Choose Us - TechnoG Solutions
    </x-slot>

    {{-- 1. Hero Section --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1600&q=80" alt="Collaborative Team" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300 pb-2">
                        Your Strategic Technology Partner
                    </h1>
                    <p class="fade-in-item mt-6 text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        More than just developers, we are partners dedicated to leveraging our expertise in technology and data analysis for your business success.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- 2. Key Differentiators --}}
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-50/60 rounded-full blur-[100px] pointer-events-none -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-50/60 rounded-full blur-[100px] pointer-events-none translate-y-1/4 -translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-24" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase tracking-[0.2em]">The Advantages</h2>
                <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">Why Choose TechnoG Solutions?</h3>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-gray-600">Our commitment to excellence is built on five key pillars that ensure your success.</p>
            </div>

            <div class="space-y-32">
                @php
                    $features = [
                        ['name' => 'Data-Driven Excellence', 'description' => 'Every solution we build is powered by data and intelligent technology, ensuring precision and measurable results. We turn complex data into your most valuable asset.', 'icon' => 'fa-solid fa-chart-line', 'color' => 'indigo', 'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80'],
                        ['name' => 'Customized Approach', 'description' => 'We design solutions tailored to each client’s unique goals, challenges, and business direction. Your business isn\'t generic, and your technology shouldn\'t be either.', 'icon' => 'fa-solid fa-sliders', 'color' => 'cyan', 'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1600&q=80'],
                        ['name' => 'End-to-End Services', 'description' => 'From initial idea to full implementation and support, we provide complete solutions that cover every step of your digital transformation journey.', 'icon' => 'fa-solid fa-infinity', 'color' => 'emerald', 'image' => 'https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80'],
                        ['name' => 'Multidisciplinary Expertise', 'description' => 'Our team combines deep knowledge in IT, data science, AI, and business strategy to deliver holistic solutions that address challenges from every angle.', 'icon' => 'fa-solid fa-brain', 'color' => 'amber', 'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1600&q=80'],
                        ['name' => 'Future-Oriented Innovation', 'description' => 'We don’t just solve today’s problems — we build scalable and forward-thinking solutions that prepare your business to stay ahead of tomorrow’s challenges.', 'icon' => 'fa-solid fa-rocket', 'color' => 'rose', 'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80']
                    ];
                @endphp

                @foreach($features as $index => $feature)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                    <div class="fade-in-item {{ $loop->odd ? 'lg:order-1 lg:pr-12' : 'lg:order-2 lg:pl-12' }}">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-{{ $feature['color'] }}-100 text-{{ $feature['color'] }}-600 mb-8 shadow-sm">
                            <i class="{{ $feature['icon'] }} fa-2xl"></i>
                        </div>
                        <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $feature['name'] }}</h3>
                        <p class="mt-6 text-lg text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>

                    <div class="fade-in-item {{ $loop->odd ? 'lg:order-2' : 'lg:order-1' }}">
                        <div class="card-3d relative rounded-[2.5rem] p-2 bg-gray-50 border border-gray-100 shadow-[0_20px_50px_rgba(0,0,0,0.05)]"
                             x-data="{ rotateX: 0, rotateY: 0 }" 
                             @mousemove="const rect = $el.getBoundingClientRect(); rotateY = ((event.clientX - rect.left) / rect.width - 0.5) * -15; rotateX = ((event.clientY - rect.top) / rect.height - 0.5) * 15;" 
                             @mouseleave="rotateX = 0; rotateY = 0" 
                             :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)` }">
                            <div class="relative overflow-hidden rounded-[2rem]">
                                <img src="{{ $feature['image'] }}" alt="{{ $feature['name'] }}" class="w-full h-80 lg:h-96 object-cover transform hover:scale-105 transition-transform duration-700 ease-out">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. Our Process (UPGRADED: Cybernetic Timeline & Floating Dashboard) --}}
    <section x-data="{ animate: false, activeTab: 1 }" x-intersect.once="animate = true" class="py-32 bg-slate-900 overflow-x-hidden border-t border-indigo-500/20 relative">
        {{-- Futuristic Dark Background --}}
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20"></div>
        <div class="absolute top-1/2 left-0 w-96 h-96 bg-indigo-600/30 rounded-full blur-[150px] -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute top-1/2 right-0 w-96 h-96 bg-cyan-600/30 rounded-full blur-[150px] -translate-y-1/2 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            {{-- Header --}}
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-24 transition-all duration-700 ease-out">
                <h2 class="text-sm font-bold tracking-widest text-cyan-400 uppercase tracking-[0.2em]">The Methodology</h2>
                <h3 class="mt-2 text-3xl font-extrabold text-white tracking-tight sm:text-5xl">Our Transparent Workflow</h3>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-indigo-200">Every project passes through our proprietary framework to ensure precision, security, and world-class execution.</p>
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start transition-all duration-700 ease-out">

                {{-- Left: Floating Dashboard Interface --}}
                <div class="lg:sticky lg:top-32 order-last lg:order-first mt-16 lg:mt-0 animate-float">
                    <div class="relative w-full rounded-[2rem] shadow-[0_30px_60px_rgba(0,0,0,0.5)] overflow-hidden bg-gray-800 border border-white/10 p-1 backdrop-blur-md">
                        
                        {{-- macOS Style Window Header --}}
                        <div class="bg-gray-900/80 px-4 py-3 flex items-center gap-2 rounded-t-[1.8rem] border-b border-white/5">
                            <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <div class="ml-4 text-xs font-mono text-gray-400 tracking-wider">technog_system_v2.0</div>
                        </div>

                        {{-- Image Display Area --}}
                        <div class="relative h-[350px] lg:h-[450px] w-full rounded-b-[1.7rem] overflow-hidden bg-gray-900">
                            {{-- Overlay glow dalam --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent z-10 pointer-events-none"></div>
                            
                            {{-- Crossfading Images --}}
                            <div x-show="activeTab === 1" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-110 blur-sm" x-transition:enter-end="opacity-100 scale-100 blur-0" class="absolute inset-0">
                                <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-80 mix-blend-luminosity" alt="Discovery & Strategy">
                            </div>
                            <div x-show="activeTab === 2" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-110 blur-sm" x-transition:enter-end="opacity-100 scale-100 blur-0" class="absolute inset-0" style="display: none;">
                                <img src="https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-80 mix-blend-luminosity" alt="Design & Prototyping">
                            </div>
                            <div x-show="activeTab === 3" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-110 blur-sm" x-transition:enter-end="opacity-100 scale-100 blur-0" class="absolute inset-0" style="display: none;">
                                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-80 mix-blend-luminosity" alt="Development & Testing">
                            </div>
                            <div x-show="activeTab === 4" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-110 blur-sm" x-transition:enter-end="opacity-100 scale-100 blur-0" class="absolute inset-0" style="display: none;">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" class="w-full h-full object-cover opacity-80 mix-blend-luminosity" alt="Deployment & Support">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Interactive Cybernetic Tabs --}}
                <div class="relative py-4">
                    {{-- Base Track Line (Background) --}}
                    <div class="absolute left-8 top-12 bottom-12 w-1 bg-white/10 rounded-full hidden sm:block z-0"></div>
                    
                    {{-- Animated Active Track Line (Foreground) --}}
                    <div class="absolute left-8 top-12 w-1 bg-gradient-to-b from-cyan-400 to-indigo-500 rounded-full hidden sm:block z-0 transition-all duration-700 ease-in-out shadow-[0_0_15px_rgba(34,211,238,0.6)]"
                         :style="'height: ' + ((activeTab - 1) * 33.33) + '%'"></div>

                    @php
                        $steps = [
                            1 => ['title' => 'Discovery & Strategy', 'icon' => 'fa-magnifying-glass', 'desc' => "We dissect the core challenge through interviews, data analysis, and market research. The output is a clear, actionable strategic blueprint."],
                            2 => ['title' => 'Design & Prototyping', 'icon' => 'fa-pen-ruler', 'desc' => "We sculpt intuitive, engaging user experiences. You'll receive high-fidelity, interactive prototypes to validate concepts before engineering begins."],
                            3 => ['title' => 'Development & Testing', 'icon' => 'fa-code', 'desc' => "Our engineers forge the solution using scalable architecture and rigorous automated testing protocols, ensuring enterprise-grade security and performance."],
                            4 => ['title' => 'Deployment & Support', 'icon' => 'fa-server', 'desc' => "The launch is just the beginning. We provide seamless deployment pipelines, proactive monitoring, and dedicated post-launch support to guarantee optimal uptime."]
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($steps as $num => $step)
                        <div @click="activeTab = {{ $num }}" 
                             class="relative z-10 cursor-pointer sm:pl-24 transition-all duration-500 group outline-none">
                            
                            {{-- Cybernetic Node (Titik Indikator) --}}
                            <div class="absolute left-[1.15rem] top-1/2 -translate-y-1/2 hidden sm:flex w-10 h-10 rounded-full border-4 transition-all duration-500 items-center justify-center bg-slate-900"
                                 :class="activeTab === {{ $num }} ? 'border-cyan-400 shadow-[0_0_20px_rgba(34,211,238,0.5)] scale-110' : (activeTab > {{ $num }} ? 'border-indigo-500' : 'border-white/20')">
                                <div class="w-3 h-3 rounded-full transition-all duration-300" 
                                     :class="activeTab === {{ $num }} ? 'bg-cyan-400 animate-pulse' : (activeTab > {{ $num }} ? 'bg-indigo-500' : 'bg-transparent')"></div>
                            </div>

                            {{-- Card Content --}}
                            <div :class="activeTab === {{ $num }} ? 'bg-white/10 border-white/20 shadow-2xl shadow-indigo-500/20 backdrop-blur-xl sm:-translate-x-2' : 'bg-transparent border-transparent hover:bg-white/5 opacity-60 hover:opacity-100'"
                                 class="p-6 sm:p-8 rounded-[2rem] border transition-all duration-500 flex flex-col sm:flex-row gap-6">
                                
                                {{-- Icon --}}
                                <div :class="activeTab === {{ $num }} ? 'bg-gradient-to-br from-cyan-400 to-indigo-500 text-white shadow-lg' : 'bg-white/10 text-gray-400'"
                                     class="shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500">
                                    <i class="fa-solid {{ $step['icon'] }} fa-lg"></i>
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <span class="sm:hidden font-mono text-cyan-400 font-bold">0{{ $num }}</span>
                                        <h3 :class="activeTab === {{ $num }} ? 'text-white' : 'text-gray-300'" class="text-2xl font-bold transition-colors duration-300">{{ $step['title'] }}</h3>
                                    </div>
                                    
                                    {{-- Expanding Text Container --}}
                                    <div x-show="activeTab === {{ $num }}" x-collapse>
                                        <p class="mt-4 text-indigo-100/70 leading-relaxed text-lg">
                                            {{ $step['desc'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- 4. Our Works --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">See Our Best Work</h2>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600">We are proud of the solutions we have built together with our clients.</p>
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 transition-all duration-700 ease-out">
                @forelse($caseStudies as $caseStudy)
                    <div class="group bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(99,102,241,0.1)] border border-gray-100 overflow-hidden transform hover:-translate-y-2 transition-all duration-500 p-4">
                        <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}" class="block">
                            <div class="relative h-64 overflow-hidden rounded-[1.5rem]">
                                <div class="absolute inset-0 bg-gray-900/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                                <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/6366f1/FFFFFF?text=TechnoG' }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-wider text-indigo-600 shadow-sm">
                                        {{ $caseStudy->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 mt-2">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $caseStudy->title }}</h3>
                                <p class="mt-2 text-gray-500 line-clamp-2">{{ Str::limit(strip_tags($caseStudy->solution), 100) }}</p>
                                <div class="mt-6 flex items-center text-sm font-bold text-indigo-600 group-hover:text-indigo-800 transition-colors">
                                    Read Case Study <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-gray-50 border border-dashed border-gray-300 rounded-[2rem] p-12 text-center">
                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm mb-4">
                            <i class="fa-solid fa-briefcase text-gray-400 fa-xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Portfolio Coming Soon</h3>
                        <p class="text-gray-500">We are currently curating our best case studies for you.</p>
                    </div>
                @endforelse
            </div>
            
            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'"
                 class="text-center mt-16 transition-all duration-700 ease-out">
                <a href="{{ route('public.portfolio') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1">
                    View All Portfolios <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- 5. Client Testimonials --}}
    @if($testimonials->isNotEmpty())
    <section class="py-32 bg-indigo-50/50 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-100 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase">Testimonials</h2>
                <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">What Our Clients Say</h3>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-gray-600">Client trust and satisfaction are the ultimate measure of our success.</p>
            </div>

            <div class="relative" 
                 x-data="{
                    slider: null,
                    init() {
                        this.slider = this.$refs.slider;
                    },
                    next() {
                        let scrollAmount = this.slider.offsetWidth;
                        if (window.innerWidth >= 768) {
                            scrollAmount = this.slider.firstElementChild.offsetWidth + 32;
                        }
                        this.slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    },
                    prev() {
                         let scrollAmount = this.slider.offsetWidth;
                        if (window.innerWidth >= 768) {
                            scrollAmount = this.slider.firstElementChild.offsetWidth + 32;
                        }
                        this.slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    }
                 }">
                
                <div x-ref="slider" class="flex snap-x snap-mandatory overflow-x-auto scrollbar-hide space-x-8 pb-10 -mx-4 px-4 sm:px-8 pt-4">
                    @foreach($testimonials as $testimonial)
                        <div class="snap-center flex-shrink-0 w-[90%] md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.333rem)] group">
                            <div class="h-full bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.05)] border border-white hover:border-indigo-100 hover:shadow-[0_20px_50px_rgba(99,102,241,0.1)] transition-all duration-500 flex flex-col relative transform hover:-translate-y-2">
                                
                                <div class="absolute top-0 right-10 -translate-y-1/2 bg-gradient-to-br from-indigo-500 to-cyan-400 w-12 h-12 rounded-full flex items-center justify-center shadow-lg text-white">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>

                                <div class="flex items-center mb-6 gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star text-sm {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>

                                <p class="text-lg font-medium text-gray-700 leading-relaxed flex-grow">"{{ $testimonial->content }}"</p>
                                
                                <footer class="mt-8 pt-6 border-t border-gray-100 flex items-center">
                                    <div class="flex-shrink-0 relative">
                                        <img class="h-14 w-14 rounded-full object-cover shadow-md border-2 border-white" 
                                             src="{{ $testimonial->user->avatar ? asset('storage/' . $testimonial->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                             alt="{{ $testimonial->user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-base font-bold text-gray-900">{{ $testimonial->user->name }}</div>
                                        @if($testimonial->user->professional_title)
                                            <div class="text-sm text-indigo-600 font-medium">{{ $testimonial->user->professional_title }}</div>
                                        @endif
                                    </div>
                                </footer>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden md:flex justify-center mt-4 space-x-6">
                    <button @click="prev()"
                            class="group bg-white rounded-full h-14 w-14 flex items-center justify-center shadow-md hover:shadow-xl border border-gray-100 hover:border-indigo-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fa-solid fa-arrow-left text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                    </button>
                    <button @click="next()"
                            class="group bg-white rounded-full h-14 w-14 flex items-center justify-center shadow-md hover:shadow-xl border border-gray-100 hover:border-indigo-200 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                    </button>
                </div>

            </div>
        </div>
    </section>
    @endif

    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .is-in-view .fade-in-item,
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .is-in-view .fade-in-item:nth-child(3) { transition-delay: 0.3s; }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.1s linear;
        }

        /* Float Animation untuk UI Image Mockup */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>

</x-public>