<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        About Us - TechnoG Solutions
    </x-slot>

    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80" alt="The TechnoG Solutions Team" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/60"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight">
                        Intelligent Technology, Powered by Data
                    </h1>
                    <p class="fade-in-item mt-4 text-lg text-gray-200 max-w-3xl mx-auto">
                        We are a data-driven technology and innovation company dedicated to helping transform ideas into real-world solutions.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- About Us Content Section --}}
    <section class="py-24 bg-white" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="fade-in-item text-3xl font-extrabold text-gray-900">About TechnoG Solutions</h2>
            <p class="fade-in-item mt-4 text-lg text-gray-600 leading-relaxed">
                Guided by the belief that intelligent technology must always serve people, we provide end-to-end services ranging from IT development and data analysis to advanced AI-powered solutions. With our multidisciplinary approach, we bring clarity from complexity, ensuring every client moves confidently into the future.
            </p>
        </div>
    </section>

    {{-- Vision & Mission Section --}}
    <section class="py-24 bg-gray-50" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="fade-in-item">
                <img class="rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" alt="TechnoG team collaborating">
            </div>
            <div class="mt-10 md:mt-0">
                <h2 class="fade-in-item text-3xl font-extrabold text-gray-900">Our Vision</h2>
                <p class="fade-in-item mt-4 text-lg text-gray-600 italic leading-relaxed">"Leading the world into the future while realizing dreams through intelligent technology powered by data."</p>
                
                <h2 class="fade-in-item mt-10 text-3xl font-extrabold text-gray-900">Our Mission</h2>
                <ul class="mt-6 text-lg text-gray-600 space-y-5">
                    <li class="fade-in-item flex items-start group"><i class="fa-solid fa-bullseye text-indigo-500 fa-fw mt-1 mr-4"></i><span>Provide customized technology and data solutions to support clients in making smarter, timely decisions.</span></li>
                    <li class="fade-in-item flex items-start group"><i class="fa-solid fa-bridge text-indigo-500 fa-fw mt-1 mr-4"></i><span>Bridge ideas into real-world applications by combining innovation, research, and effective execution.</span></li>
                    <li class="fade-in-item flex items-start group"><i class="fa-solid fa-users-gear text-indigo-500 fa-fw mt-1 mr-4"></i><span>Design intelligent systems tailored to each client’s unique needs, ensuring flexibility and long-term value.</span></li>
                    <li class="fade-in-item flex items-start group"><i class="fa-solid fa-handshake-angle text-indigo-500 fa-fw mt-1 mr-4"></i><span>Build trust through collaboration, transparency, and measurable results to create strong partnerships.</span></li>
                    <li class="fade-in-item flex items-start group"><i class="fa-solid fa-infinity text-indigo-500 fa-fw mt-1 mr-4"></i><span>Continuously innovate at the intersection of data, technology, and human insight.</span></li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Our Approach Section --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Where Data Meets Code</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Our unique process transforms raw information into powerful digital solutions.</p>
            </div>
            <div class="mt-20 relative">
                <div aria-hidden="true" class="absolute inset-x-0 top-1/2 -translate-y-1/2 hidden lg:block">
                    <div :class="animate ? 'w-full' : 'w-0'" class="h-0.5 bg-gray-200 transition-all duration-1000 ease-out mx-auto" style="max-width: 60%;"></div>
                </div>
                <div class="relative grid grid-cols-1 lg:grid-cols-3 gap-8" style="perspective: 1000px;">
                    {{-- Card 1 --}}
                    <div :class="animate ? 'opacity-100' : 'opacity-0'" class="card-3d rounded-2xl p-8 bg-white shadow-xl transition-all duration-700 ease-out" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare"></div>
                        <div class="card-3d-content text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600"><i class="fa-solid fa-magnifying-glass-chart fa-2xl"></i></div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900">Data Analysis</h3>
                            <p class="mt-2 text-base text-gray-600">We start by diving deep into your data, using statistical methods to uncover hidden patterns and valuable insights.</p>
                        </div>
                    </div>
                    {{-- Card 2 --}}
                    <div :class="animate ? 'opacity-100 delay-200' : 'opacity-0'" class="card-3d rounded-2xl p-8 bg-white shadow-xl transition-all duration-700 ease-out" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare"></div>
                        <div class="card-3d-content text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-cyan-100 text-cyan-600"><i class="fa-solid fa-sitemap fa-2xl"></i></div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900">Strategy & Modeling</h3>
                            <p class="mt-2 text-base text-gray-600">Insights are transformed into a strategic plan and predictive models that form the foundation of the solution.</p>
                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div :class="animate ? 'opacity-100 delay-[400ms]' : 'opacity-0'" class="card-3d rounded-2xl p-8 bg-white shadow-xl transition-all duration-700 ease-out" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare"></div>
                        <div class="card-3d-content text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600"><i class="fa-solid fa-code fa-2xl"></i></div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900">Tech Implementation</h3>
                            <p class="mt-2 text-base text-gray-600">Our developers build robust, scalable, and intuitive applications based on the data-driven strategy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values Section --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Our Core Values</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">The principles that guide our work and define who we are.</p>
            </div>
            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-3" style="perspective: 1000px;">
                {{-- Value 1: Innovation --}}
                <div class="card-3d bg-white rounded-2xl p-8 shadow-xl" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                    <div class="card-3d-glare"></div>
                    <div class="card-3d-content text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600"><i class="fa-solid fa-lightbulb fa-2xl"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Innovation</h3>
                        <p class="mt-2 text-base text-gray-600">We continuously push boundaries to create smarter, data-driven solutions that bring real impact.</p>
                    </div>
                </div>
                {{-- Value 2: Integrity --}}
                <div class="card-3d bg-white rounded-2xl p-8 shadow-xl" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                    <div class="card-3d-glare"></div>
                    <div class="card-3d-content text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-cyan-100 text-cyan-600"><i class="fa-solid fa-shield-halved fa-2xl"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Integrity</h3>
                        <p class="mt-2 text-base text-gray-600">We uphold transparency, responsibility, and honesty in every collaboration.</p>
                    </div>
                </div>
                {{-- Value 3: Customization --}}
                <div class="card-3d bg-white rounded-2xl p-8 shadow-xl" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                    <div class="card-3d-glare"></div>
                    <div class="card-3d-content text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600"><i class="fa-solid fa-sliders fa-2xl"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Customization</h3>
                        <p class="mt-2 text-base text-gray-600">We believe every client is unique, so we design tailored solutions that truly match their goals and needs.</p>
                    </div>
                </div>
                {{-- Value 4: Collaboration --}}
                <div class="card-3d bg-white rounded-2xl p-8 shadow-xl" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                    <div class="card-3d-glare"></div>
                    <div class="card-3d-content text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-amber-100 text-amber-600"><i class="fa-solid fa-users fa-2xl"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Collaboration</h3>
                        <p class="mt-2 text-base text-gray-600">We grow together with our clients and partners through teamwork and shared success.</p>
                    </div>
                </div>
                {{-- Value 5: Excellence --}}
                <div class="card-3d bg-white rounded-2xl p-8 shadow-xl" x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" @mousemove=" const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; const { width, height } = rect; rotateY = (x / width - 0.5) * -20; rotateX = (y / height - 0.5) * 20; glareX = (x / width) * 100; glareY = (y / height) * 100; " @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                    <div class="card-3d-glare"></div>
                    <div class="card-3d-content text-center">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-rose-100 text-rose-600"><i class="fa-solid fa-award fa-2xl"></i></div>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">Excellence</h3>
                        <p class="mt-2 text-base text-gray-600">We are committed to delivering high-quality results, turning complex challenges into clear, actionable solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Meet Our Founders Section --}}
    <section class="py-24 bg-gray-50" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="fade-in-item text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Meet Our Founders</h2>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-gray-600">Our strength lies in the unique synergy of our expertise.</p>
            </div>
            <div class="mt-16 grid gap-12 sm:grid-cols-1 lg:grid-cols-2">
                <div class="fade-in-item bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="relative w-40 h-40 mx-auto group">
                        <img class="mx-auto h-full w-full rounded-full object-cover shadow-lg" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Andri Rizki Photo">
                        <div class="absolute inset-0 bg-indigo-600/70 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="#" class="text-white mx-2 hover:text-gray-200"><i class="fa-brands fa-linkedin fa-2x"></i></a>
                            <a href="#" class="text-white mx-2 hover:text-gray-200"><i class="fa-brands fa-github fa-2x"></i></a>
                        </div>
                    </div>
                    <h3 class="mt-6 text-2xl font-medium text-gray-900">Andri Rizki</h3>
                    <p class="text-indigo-600 font-semibold">Founder & Statistical Analyst</p>
                    <p class="mt-2 max-w-md mx-auto text-gray-500">The brain behind every data analysis and statistical model, ensuring our solutions are accurate and reliable.</p>
                </div>
                <div class="fade-in-item bg-white rounded-xl shadow-lg p-8 text-center">
                    <div class="relative w-40 h-40 mx-auto group">
                        <img class="mx-auto h-full w-full rounded-full object-cover shadow-lg" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Ulul Azmi A. Latala Photo">
                        <div class="absolute inset-0 bg-indigo-600/70 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="#" class="text-white mx-2 hover:text-gray-200"><i class="fa-brands fa-linkedin fa-2x"></i></a>
                            <a href="#" class="text-white mx-2 hover:text-gray-200"><i class="fa-brands fa-github fa-2x"></i></a>
                        </div>
                    </div>
                    <h3 class="mt-6 text-2xl font-medium text-gray-900">Ulul Azmi A. Latala</h3>
                    <p class="text-indigo-600 font-semibold">Co-Founder & Lead Developer</p>
                    <p class="mt-2 max-w-md mx-auto text-gray-500">The technology architect who translates data insights into robust and intuitive applications and systems.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- [WAJIB] CSS untuk Efek 3D dan Efek Fade In --}}
    <style>
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.1s linear;
        }
        .card-3d-content {
            transform: translateZ(40px);
        }
        .card-3d-glare {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background-image: radial-gradient(circle at var(--glare-x) var(--glare-y), rgba(255, 255, 255, 0.4), transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .card-3d:hover .card-3d-glare {
            opacity: 1;
        }

        .fade-in-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .is-in-view .fade-in-item,
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        /* Staggered Delay */
        .is-in-view .fade-in-item:nth-child(2) { transition-delay: 0.15s; }
        .is-in-view .fade-in-item:nth-child(3) { transition-delay: 0.3s; }
        .is-in-view .fade-in-item:nth-child(4) { transition-delay: 0.45s; }
        .is-in-view h2 + p.fade-in-item { transition-delay: 0.15s; }
        .is-in-view p + h2.fade-in-item { transition-delay: 0.2s; }
        .is-in-view h2 + ul { transition-delay: 0.3s; }
        .is-in-view ul > li.fade-in-item:nth-child(1) { transition-delay: 0.4s; }
        .is-in-view ul > li.fade-in-item:nth-child(2) { transition-delay: 0.5s; }
        .is-in-view ul > li.fade-in-item:nth-child(3) { transition-delay: 0.6s; }
        .is-in-view ul > li.fade-in-item:nth-child(4) { transition-delay: 0.7s; }
        .is-in-view ul > li.fade-in-item:nth-child(5) { transition-delay: 0.8s; }
        .is-in-view .grid > .fade-in-item:nth-child(2) { transition-delay: 0.3s; }
    </style>

</x-public>

