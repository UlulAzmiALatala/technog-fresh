<x-public>

    <x-slot name="title">
        Why Choose Us - TechnoG Solutions
    </x-slot>

    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1600&q=80" alt="Collaborative Team" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/50 to-transparent"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                <div x-data="{}" x-init="$nextTick(() => {
                    $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                    setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                })">
                    <h1 x-ref="heading" class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">
                        Your Strategic Technology Partner
                    </h1>
                    <p x-ref="paragraph" class="mt-4 text-lg md:text-xl text-gray-200 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">
                        More than just developers, we are partners dedicated to leveraging our expertise in technology and data analysis for your business success.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- 2. Key Differentiators --}}
    <section class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Why Choose TechnoG Solutions?</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Our commitment to excellence is built on five key pillars that ensure your success.</p>
            </div>

            <div class="space-y-24">
                @php
                    $features = [
                        [
                            'name' => 'Data-Driven Excellence',
                            'description' => 'Every solution we build is powered by data and intelligent technology, ensuring precision and measurable results. We turn complex data into your most valuable asset.',
                            'icon' => 'fa-solid fa-chart-line',
                            'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1600&q=80'
                        ],
                        [
                            'name' => 'Customized Approach',
                            'description' => 'We design solutions tailored to each client’s unique goals, challenges, and business direction. Your business isn\'t generic, and your technology shouldn\'t be either.',
                            'icon' => 'fa-solid fa-sliders',
                            'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=1600&q=80'
                        ],
                        [
                            'name' => 'End-to-End Services',
                            'description' => 'From initial idea to full implementation and support, we provide complete solutions that cover every step of your digital transformation journey.',
                            'icon' => 'fa-solid fa-infinity',
                            'image' => 'https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80'
                        ],
                        [
                            'name' => 'Multidisciplinary Expertise',
                            'description' => 'Our team combines deep knowledge in IT, data science, AI, and business strategy to deliver holistic solutions that address challenges from every angle.',
                            'icon' => 'fa-solid fa-brain',
                            'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1600&q=80'
                        ],
                        [
                            'name' => 'Future-Oriented Innovation',
                            'description' => 'We don’t just solve today’s problems — we build scalable and forward-thinking solutions that prepare your business to stay ahead of tomorrow’s challenges.',
                            'icon' => 'fa-solid fa-rocket',
                            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80' // Gambar diperbaiki
                        ]
                    ];
                @endphp

                @foreach($features as $feature)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
                    <div class="fade-in-item {{ $loop->odd ? 'lg:order-1' : 'lg:order-2' }}">
                        <div class="inline-flex items-center justify-center h-14 w-14 rounded-lg bg-indigo-100 text-indigo-600 mb-6">
                            <i class="{{ $feature['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $feature['name'] }}</h3>
                        <p class="mt-4 text-lg text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                    <div class="fade-in-item {{ $loop->odd ? 'lg:order-2' : 'lg:order-1' }}">
                        <div class="rounded-2xl shadow-xl overflow-hidden group">
                            <img src="{{ $feature['image'] }}" alt="{{ $feature['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. Our Process --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Our Transparent Workflow</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Every project goes through four key stages to ensure optimal results and effective collaboration.</p>
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 x-data="{ activeTab: 1 }"
                 class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start transition-all duration-700 ease-out">

                <div class="lg:sticky lg:top-28">
                    <div class="relative h-96 w-full rounded-2xl shadow-xl overflow-hidden">
                        <div x-show="activeTab === 1" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <img src="https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Discovery & Strategy">
                        </div>
                        <div x-show="activeTab === 2" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <img src="https://images.unsplash.com/photo-1587440871875-191322ee64b0?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Design & Prototyping">
                        </div>
                        <div x-show="activeTab === 3" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Development & Testing">
                        </div>
                        <div x-show="activeTab === 4" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Deployment & Support">
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div @click="activeTab = 1" :class="activeTab === 1 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900">1. Discovery & Strategy</h3>
                        <p :class="activeTab === 1 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                            Every successful project begins with a deep understanding. We conduct interviews, data analysis, and market research to define the core challenge and create a strategic roadmap. The output is a clear strategy document, ensuring we're all on the same page before a single line of code is written.
                        </p>
                    </div>
                    <div @click="activeTab = 2" :class="activeTab === 2 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900">2. Design & Prototyping</h3>
                        <p :class="activeTab === 2 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                            Our team designs intuitive and engaging interfaces. You'll receive an interactive prototype (not just static images) that you can click through and test, allowing for precise feedback and rapid concept validation.
                        </p>
                    </div>
                    <div @click="activeTab = 3" :class="activeTab === 3 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900">3. Development & Testing</h3>
                        <p :class="activeTab === 3 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                            Our developers implement the design into a robust and scalable solution. We use modern development practices and automated testing to ensure clean, secure, and future-proof code.
                        </p>
                    </div>
                    <div @click="activeTab = 4" :class="activeTab === 4 ? 'bg-white shadow-xl border-l-4 border-indigo-500' : 'bg-gray-50 hover:bg-white border-l-4 border-transparent'" class="p-6 rounded-lg cursor-pointer transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900">4. Deployment & Support</h3>
                        <p :class="activeTab === 4 ? 'max-h-96 mt-2' : 'max-h-0'" class="text-base text-gray-600 overflow-hidden transition-all duration-500 ease-in-out">
                            Our relationship doesn't end at launch. We provide post-launch warranties and support package options to ensure your digital solution remains optimal, secure, and grows with your business.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. Our Works --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">See Our Best Work</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">We are proud of the solutions we have built together with our clients.</p>
            </div>
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 transition-all duration-700 ease-out">
                @forelse($caseStudies as $caseStudy)
                    <div class="group bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 hover:shadow-2xl">
                        <a href="{{ route('public.portfolio.show', $caseStudy->slug) }}">
                            <div class="h-64 overflow-hidden">
                                <img alt="{{ $caseStudy->title }}" src="{{ $caseStudy->image ? asset('storage/' . $caseStudy->image) : 'https://placehold.co/800x600/6366f1/FFFFFF?text=TechnoG' }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                            </div>
                            <div class="p-6">
                                <p class="text-sm font-semibold uppercase tracking-widest text-indigo-600">{{ $caseStudy->category->name ?? 'Uncategorized' }}</p>
                                <h3 class="mt-2 text-xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $caseStudy->title }}</h3>
                                <p class="mt-3 text-base text-gray-500">{{ Str::limit($caseStudy->solution, 120) }}</p>
                                <span class="mt-4 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">Read the full story &rarr;</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="md:col-span-3 text-center text-gray-500 py-10">Portfolio will be added soon.</p>
                @endforelse
            </div>
            <div :class="animate ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-8'"
                 class="text-center mt-16 transition-all duration-700 ease-out">
                <a href="{{ route('public.portfolio') }}" class="inline-block bg-indigo-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-indigo-700 transition-colors transform hover:scale-105">
                    View All Portfolios
                </a>
            </div>
        </div>
    </section>

    {{-- Client Testimonials --}}
    @if($testimonials->isNotEmpty())
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">What Our Clients Say</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Client trust and satisfaction are our top priorities.</p>
            </div>

            <div class="relative" 
                 x-data="{
                    slider: null,
                    init() {
                        this.slider = this.$refs.slider;
                    },
                    next() {
                        let scrollAmount = this.slider.offsetWidth;
                        // For larger screens, scroll by one card width instead of the whole container
                        if (window.innerWidth >= 768) {
                            scrollAmount = this.slider.firstElementChild.offsetWidth + parseInt(window.getComputedStyle(this.slider).gap);
                        }
                        this.slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    },
                    prev() {
                         let scrollAmount = this.slider.offsetWidth;
                        if (window.innerWidth >= 768) {
                            scrollAmount = this.slider.firstElementChild.offsetWidth + parseInt(window.getComputedStyle(this.slider).gap);
                        }
                        this.slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    }
                 }">
                
                {{-- Carousel Container --}}
                <div x-ref="slider" class="flex snap-x snap-mandatory overflow-x-auto scrollbar-hide space-x-8 pb-6 -mx-4 px-4">
                    @foreach($testimonials as $testimonial)
                        <div class="snap-center flex-shrink-0 w-[90%] md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-1.333rem)]">
                            <div class="h-full bg-gray-50 p-8 rounded-2xl shadow-lg border border-gray-200 flex flex-col">
                                <svg class="h-10 w-10 text-indigo-100 mb-4" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                                </svg>
                                
                                {{-- PERBAIKAN 1: Memastikan Rating Bintang Tampil --}}
                                <div class="flex items-center mb-4">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xl {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>

                                <p class="relative text-lg font-medium text-gray-700 italic flex-grow">"{{ $testimonial->content }}"</p>
                                
                                <footer class="mt-8 pt-6 border-t border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img class="h-12 w-12 rounded-full" 
                                                 src="{{ $testimonial->user->avatar ? asset('storage/' . $testimonial->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($testimonial->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                                 alt="Foto {{ $testimonial->user->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-base font-medium text-gray-900">{{ $testimonial->user->name }}</div>
                                            @if($testimonial->user->professional_title)
                                                <div class="text-base text-gray-500">{{ $testimonial->user->professional_title }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PERBAIKAN 2 & 3: Tombol Navigasi Diperkecil & Didesain Ulang --}}
                <div class="hidden md:flex justify-center mt-8 space-x-4">
                    <button @click="prev()"
                            class="bg-white rounded-full h-12 w-12 flex items-center justify-center shadow-lg border border-gray-200 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Previous</span>
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button @click="next()"
                            class="bg-white rounded-full h-12 w-12 flex items-center justify-center shadow-lg border border-gray-200 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Next</span>
                        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>

            </div>
        </div>
    </section>
    @endif

    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .is-in-view .fade-in-item {
            opacity: 1;
            transform: translateY(0);
        }
        .is-in-view .fade-in-item:nth-child(2) {
            transition-delay: 0.2s;
        }
    </style>

</x-public>