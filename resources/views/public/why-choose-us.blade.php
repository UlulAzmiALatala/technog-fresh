<x-public>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Why Choose Us - TechnoG Solutions
    </x-slot>

    {{-- KANTONG HERO DIISI DENGAN HERO GAMBAR STATIS --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1600&q=80" alt="Collaborative Team" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/50 to-transparent"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                {{-- Animasi on-load untuk hero --}}
                <div x-data="{}" x-init="$nextTick(() => {
                    $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                    setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                })">
                    <h1 x-ref="heading" class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">
                        Your Strategic Technology Partner
                    </h1>
                    <p x-ref="paragraph" class="mt-4 text-lg md:text-xl text-gray-200 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">
                        More than just developers, we are partners dedicated to leveraging our expertise in technology and data analysis for your business success.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Konten utama halaman Why Choose Us --}}

    {{-- 2. Key Differentiators --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">The Foundation of Our Excellence</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Three key pillars that make us a trusted partner for your digital transformation.</p>
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 x-data="{ active: 0 }" @mouseleave="active = 0"
                 class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center transition-all duration-700 ease-out">

                {{-- Card 1 --}}
                <div @mouseenter="active = 1" :class="active === 1 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Structured Approach</h3>
                    <p class="text-gray-600">No more projects off schedule. With our transparent workflow, you'll always know your project's progress at every stage, from idea to launch.</p>
                </div>

                {{-- Card 2 --}}
                <div @mouseenter="active = 2" :class="active === 2 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Proven Results</h3>
                    <p class="text-gray-600">We don't just make promises; we deliver. Check our case studies to see how we've helped businesses like yours improve efficiency, sales, and growth.</p>
                </div>

                {{-- Card 3 --}}
                <div @mouseenter="active = 3" :class="active === 3 || active === 0 ? 'opacity-100' : 'opacity-60'" class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full h-16 w-16 inline-flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Expert & Collaborative Team</h3>
                    <p class="text-gray-600">You're not working with a vendor; you're gaining a partner. Our team of developers and data scientists becomes an extension of your own, collaborating closely to ensure your vision is realized.</p>
                </div>
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
                                <span class="mt-4 inline-block font-semibold text-indigo-600 group-hover:text-indigo-800">View case study &rarr;</span>
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
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">What Our Clients Say</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Client trust and satisfaction are our top priorities.</p>
            </div>
            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'"
                 class="relative bg-gray-50 p-8 md:p-12 rounded-2xl shadow-xl border border-gray-200 transition-all duration-700 ease-out">
                <svg class="absolute top-8 left-8 h-12 w-12 text-indigo-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                </svg>
                <p class="relative text-2xl font-medium text-gray-800 italic">"Working with TechnoG was an incredible experience. They truly understood our vision and turned it into a solution that exceeded our expectations."</p>
                <footer class="mt-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Client Photo">
                        </div>
                        <div class="ml-4">
                            <div class="text-base font-medium text-gray-900">Sarah L.</div>
                            <div class="text-base text-gray-500">CEO, Growth Startup</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </section>

</x-public>