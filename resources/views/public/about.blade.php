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
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300">
                        Intelligent Technology,<br>Powered by Data
                    </h1>
                    <p class="fade-in-item mt-6 text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        We are a data-driven technology and innovation company dedicated to helping transform ideas into real-world solutions.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- KEMBALI & DIPERBAIKI (Added overflow-x-hidden to prevent mobile layout break) --}}
    <section class="py-24 bg-white relative overflow-x-hidden" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-indigo-50 blur-3xl opacity-50"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase">Who We Are</h2>
            <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">About TechnoG Solutions</h3>
            <p class="fade-in-item mt-6 text-lg text-gray-600 leading-relaxed">
                Guided by the belief that intelligent technology must always serve people, we provide end-to-end services ranging from IT development and data analysis to advanced AI-powered solutions. With our multidisciplinary approach, we bring clarity from complexity, ensuring every client moves confidently into the future.
            </p>
        </div>
    </section>

    {{-- Vision & Mission Section (Added overflow-x-hidden) --}}
    <section class="py-24 bg-gray-50/50 overflow-x-hidden" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="fade-in-item relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-cyan-400 rounded-[2.5rem] transform translate-x-4 translate-y-4 opacity-20"></div>
                <img class="relative rounded-[2.5rem] shadow-2xl border-4 border-white z-10" src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" alt="TechnoG team collaborating">
                {{-- Floating Badge --}}
                <div class="absolute -bottom-6 -left-6 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-gray-100 z-20 flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-rocket fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Driving Future</p>
                        <p class="text-lg font-bold text-gray-900">Innovations</p>
                    </div>
                </div>
            </div>
            <div class="mt-10 lg:mt-0">
                <h2 class="fade-in-item text-3xl font-extrabold text-gray-900">Our Vision</h2>
                <p class="fade-in-item mt-4 text-xl text-indigo-600 font-medium italic leading-relaxed border-l-4 border-indigo-500 pl-4">"Leading the world into the future while realizing dreams through intelligent technology powered by data."</p>
                
                <h2 class="fade-in-item mt-12 text-3xl font-extrabold text-gray-900">Our Mission</h2>
                <ul class="mt-6 text-lg text-gray-600 space-y-6">
                    <li class="fade-in-item flex items-start group">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mt-1 mr-4 shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-bullseye fa-sm"></i>
                        </div>
                        <span>Provide customized technology and data solutions to support clients in making smarter, timely decisions.</span>
                    </li>
                    <li class="fade-in-item flex items-start group">
                        <div class="h-8 w-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center mt-1 mr-4 shrink-0 group-hover:bg-cyan-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-bridge fa-sm"></i>
                        </div>
                        <span>Bridge ideas into real-world applications by combining innovation, research, and effective execution.</span>
                    </li>
                    <li class="fade-in-item flex items-start group">
                        <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mt-1 mr-4 shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-users-gear fa-sm"></i>
                        </div>
                        <span>Design intelligent systems tailored to each client’s unique needs, ensuring flexibility and long-term value.</span>
                    </li>
                    <li class="fade-in-item flex items-start group">
                        <div class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mt-1 mr-4 shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-handshake-angle fa-sm"></i>
                        </div>
                        <span>Build trust through collaboration, transparency, and measurable results to create strong partnerships.</span>
                    </li>
                    <li class="fade-in-item flex items-start group">
                        <div class="h-8 w-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center mt-1 mr-4 shrink-0 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-infinity fa-sm"></i>
                        </div>
                        <span>Continuously innovate at the intersection of data, technology, and human insight.</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Our Approach Section (3D Tilt + Dark Glassmorphism) --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-32 relative overflow-hidden bg-slate-900">
        {{-- Futuristic Background Glow --}}
        <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-indigo-600/30 rounded-full blur-[120px] -translate-y-1/2"></div>
        <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-cyan-600/30 rounded-full blur-[120px] -translate-y-1/2"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h2 class="text-sm font-bold tracking-widest text-cyan-400 uppercase tracking-[0.2em]">The Workflow</h2>
                <h2 class="mt-2 text-4xl font-extrabold text-white tracking-tight sm:text-5xl">Where Data Meets Code</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-indigo-200">Our unique process transforms raw information into powerful digital solutions.</p>
            </div>
            
            <div class="mt-24 relative">
                {{-- Animated Connecting Line (Glowing) --}}
                <div aria-hidden="true" class="absolute inset-x-0 top-1/2 -translate-y-1/2 hidden lg:block z-0">
                    <div :class="animate ? 'w-full opacity-100' : 'w-0 opacity-0'" class="h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent transition-all duration-1000 ease-out mx-auto shadow-[0_0_15px_rgba(34,211,238,0.5)]" style="max-width: 65%;"></div>
                </div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-12" style="perspective: 1500px;">
                    {{-- Card 1 --}}
                    <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'" class="card-3d rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 p-10 shadow-[0_8px_32px_rgba(0,0,0,0.3)] transition-all duration-700 ease-out" 
                         x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" 
                         @mousemove="const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; rotateY = (x / rect.width - 0.5) * -20; rotateX = (y / rect.height - 0.5) * 20; glareX = (x / rect.width) * 100; glareY = (y / rect.height) * 100;" 
                         @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" 
                         :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare rounded-[2.5rem]"></div>
                        <div class="card-3d-content text-center">
                            <div class="mx-auto inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/50 shadow-[0_0_30px_rgba(99,102,241,0.4)]"><i class="fa-solid fa-magnifying-glass-chart fa-2xl"></i></div>
                            <h3 class="mt-8 text-2xl font-bold text-white">Data Analysis</h3>
                            <p class="mt-4 text-base text-gray-400 leading-relaxed">We start by diving deep into your data, using statistical methods to uncover hidden patterns and valuable insights.</p>
                        </div>
                    </div>
                    
                    {{-- Card 2 --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-10'" class="card-3d rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 p-10 shadow-[0_8px_32px_rgba(0,0,0,0.3)] transition-all duration-700 ease-out" 
                         x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" 
                         @mousemove="const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; rotateY = (x / rect.width - 0.5) * -20; rotateX = (y / rect.height - 0.5) * 20; glareX = (x / rect.width) * 100; glareY = (y / rect.height) * 100;" 
                         @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" 
                         :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare rounded-[2.5rem]"></div>
                        <div class="card-3d-content text-center">
                            <div class="mx-auto inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-cyan-500/20 text-cyan-400 border border-cyan-500/50 shadow-[0_0_30px_rgba(6,182,212,0.4)]"><i class="fa-solid fa-sitemap fa-2xl"></i></div>
                            <h3 class="mt-8 text-2xl font-bold text-white">Strategy & Modeling</h3>
                            <p class="mt-4 text-base text-gray-400 leading-relaxed">Insights are transformed into a strategic plan and predictive models that form the foundation of the solution.</p>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div :class="animate ? 'opacity-100 translate-y-0 delay-[400ms]' : 'opacity-0 translate-y-10'" class="card-3d rounded-[2.5rem] bg-white/5 backdrop-blur-xl border border-white/10 p-10 shadow-[0_8px_32px_rgba(0,0,0,0.3)] transition-all duration-700 ease-out" 
                         x-data="{ rotateX: 0, rotateY: 0, glareX: -100, glareY: -100 }" 
                         @mousemove="const rect = $el.getBoundingClientRect(); const x = event.clientX - rect.left; const y = event.clientY - rect.top; rotateY = (x / rect.width - 0.5) * -20; rotateX = (y / rect.height - 0.5) * 20; glareX = (x / rect.width) * 100; glareY = (y / rect.height) * 100;" 
                         @mouseleave="rotateX = 0; rotateY = 0; glareX = -100; glareY = -100" 
                         :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`, '--glare-x': `${glareX}%`, '--glare-y': `${glareY}%` }">
                        <div class="card-3d-glare rounded-[2.5rem]"></div>
                        <div class="card-3d-content text-center">
                            <div class="mx-auto inline-flex items-center justify-center h-20 w-20 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 shadow-[0_0_30px_rgba(16,185,129,0.4)]"><i class="fa-solid fa-code fa-2xl"></i></div>
                            <h3 class="mt-8 text-2xl font-bold text-white">Tech Implementation</h3>
                            <p class="mt-4 text-base text-gray-400 leading-relaxed">Our developers build robust, scalable, and intuitive applications based on the data-driven strategy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Core Values Section --}}
    <section class="py-24 bg-white overflow-hidden" x-data x-intersect:enter.once="$el.classList.add('is-in-view')">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="fade-in-item text-sm font-bold tracking-widest text-indigo-600 uppercase">The Principles</h2>
                <h3 class="fade-in-item mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Our Core Values</h3>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-gray-600">The 5 pillars that define how we deliver excellence to our partners.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
                
                {{-- Value 1 --}}
                <div class="fade-in-item lg:col-span-2 group relative bg-white rounded-[2rem] p-8 hover:-translate-y-3 transition-all duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] border border-gray-100 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-indigo-100 text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-lightbulb fa-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Innovation</h3>
                        <p class="mt-3 text-gray-500 leading-relaxed">We continuously push boundaries to create smarter, data-driven solutions that bring real impact.</p>
                    </div>
                </div>

                {{-- Value 2 --}}
                <div class="fade-in-item lg:col-span-2 group relative bg-white rounded-[2rem] p-8 hover:-translate-y-3 transition-all duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(6,182,212,0.15)] border border-gray-100 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-cyan-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-cyan-100 text-cyan-600 mb-6 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-shield-halved fa-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Integrity</h3>
                        <p class="mt-3 text-gray-500 leading-relaxed">We uphold transparency, responsibility, and honesty in every collaboration.</p>
                    </div>
                </div>

                {{-- Value 3 --}}
                <div class="fade-in-item lg:col-span-2 group relative bg-white rounded-[2rem] p-8 hover:-translate-y-3 transition-all duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(16,185,129,0.15)] border border-gray-100 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-emerald-100 text-emerald-600 mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-sliders fa-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Customization</h3>
                        <p class="mt-3 text-gray-500 leading-relaxed">We believe every client is unique, designing tailored solutions matching specific goals.</p>
                    </div>
                </div>

                {{-- Value 4 --}}
                <div class="fade-in-item lg:col-start-2 lg:col-span-2 group relative bg-white rounded-[2rem] p-8 hover:-translate-y-3 transition-all duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(245,158,11,0.15)] border border-gray-100 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-amber-100 text-amber-600 mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-users fa-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Collaboration</h3>
                        <p class="mt-3 text-gray-500 leading-relaxed">We grow together with our clients and partners through teamwork and shared success.</p>
                    </div>
                </div>

                {{-- Value 5 --}}
                <div class="fade-in-item lg:col-start-4 lg:col-span-2 group relative bg-white rounded-[2rem] p-8 hover:-translate-y-3 transition-all duration-500 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(225,29,72,0.15)] border border-gray-100 overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-rose-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-rose-100 text-rose-600 mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                            <i class="fa-solid fa-award fa-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Excellence</h3>
                        <p class="mt-3 text-gray-500 leading-relaxed">Committed to delivering high-quality results, turning complex challenges into clear solutions.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Meet Our Founders Section --}}
    <section class="py-24 bg-gray-50 relative overflow-hidden" 
             x-data="founderManager()" 
             x-intersect:enter.once="$el.classList.add('is-in-view')">
             
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="fade-in-item text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Meet The Architects</h2>
                <p class="fade-in-item mt-4 max-w-2xl mx-auto text-lg text-gray-600">The synergy of Data Science and Software Engineering.</p>
            </div>
            
            <div class="grid gap-12 sm:grid-cols-1 md:grid-cols-2 max-w-4xl mx-auto">
                <template x-for="founder in founders" :key="founder.id">
                    <div class="fade-in-item group relative bg-white rounded-[2.5rem] p-8 text-center transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/20 border border-gray-100">
                        
                        <div class="relative w-48 h-48 mx-auto cursor-pointer" @click="openModal(founder)">
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-cyan-400 rounded-full animate-pulse opacity-0 group-hover:opacity-30 blur-xl transition-opacity"></div>
                            <img class="relative z-10 mx-auto h-full w-full rounded-full object-cover shadow-lg border-4 border-white group-hover:scale-105 transition-transform duration-500" 
                                 :src="founder.image" :alt="founder.name">
                            
                            <div class="absolute inset-0 z-20 rounded-full bg-gray-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 border-4 border-transparent">
                                <i class="fa-solid fa-magnifying-glass-plus text-white fa-2x"></i>
                            </div>
                        </div>

                        <h3 class="mt-8 text-2xl font-bold text-gray-900" x-text="founder.name"></h3>
                        <p class="inline-block mt-2 px-4 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold tracking-wide" x-text="founder.role"></p>
                        <p class="mt-4 text-gray-500 text-sm leading-relaxed px-4" x-text="founder.shortBio"></p>
                        
                        <div class="mt-6 flex justify-center space-x-4">
                            <a :href="founder.socials.linkedin" target="_blank" class="text-gray-400 hover:text-indigo-600 transition-colors"><i class="fa-brands fa-linkedin fa-lg"></i></a>
                            <a :href="founder.socials.github" target="_blank" class="text-gray-400 hover:text-gray-900 transition-colors"><i class="fa-brands fa-github fa-lg"></i></a>
                            <a :href="founder.socials.instagram" target="_blank" class="text-gray-400 hover:text-pink-600 transition-colors"><i class="fa-brands fa-instagram fa-lg"></i></a>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Teleport Modal Zoom Standard --}}
        <template x-teleport="body">
            <div x-show="isModalOpen" 
                 class="fixed inset-0 z-[1000] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-0"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;">
                
                <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity" @click="closeModal()"></div>

                <div class="relative bg-white rounded-[2.5rem] shadow-2xl overflow-hidden max-w-2xl w-full transform transition-all"
                     x-show="isModalOpen"
                     x-transition:enter="ease-out duration-300 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                    
                    <button @click="closeModal()" class="absolute top-4 right-4 z-50 h-10 w-10 bg-white/50 hover:bg-white backdrop-blur-sm rounded-full flex items-center justify-center text-gray-900 shadow-sm transition-all">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <div class="grid grid-cols-1 sm:grid-cols-2" x-if="activeFounder">
                        <div class="relative h-64 sm:h-full bg-gray-100">
                            <img :src="activeFounder?.image" :alt="activeFounder?.name" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent sm:hidden"></div>
                        </div>
                        
                        <div class="p-8 sm:p-10 flex flex-col justify-center">
                            <h3 class="text-3xl font-extrabold text-gray-900" x-text="activeFounder?.name"></h3>
                            <p class="mt-2 font-semibold text-indigo-600" x-text="activeFounder?.role"></p>
                            
                            <div class="w-12 h-1 bg-indigo-500 rounded mt-4 mb-4"></div>
                            
                            <p class="text-gray-600 leading-relaxed" x-text="activeFounder?.fullBio"></p>
                            
                            <div class="mt-8 flex space-x-3">
                                <a :href="activeFounder?.socials?.linkedin" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-4 bg-[#0A66C2] text-white rounded-xl hover:bg-[#084e96] transition-colors font-medium text-sm shadow-md shadow-blue-500/30">
                                    <i class="fa-brands fa-linkedin"></i> LinkedIn
                                </a>
                                <a :href="activeFounder?.socials?.github" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-4 bg-gray-900 text-white rounded-xl hover:bg-black transition-colors font-medium text-sm shadow-md shadow-gray-900/30">
                                    <i class="fa-brands fa-github"></i> GitHub
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </section>

    <script>
        function founderManager() {
            return {
                isModalOpen: false,
                activeFounder: null,
                founders: [
                    {
                        id: 1,
                        name: 'Andri Rizki',
                        role: 'Founder & Statistical Analyst',
                        image: "{{ asset('images/founders/fp-adnan.jpeg') }}",
                        shortBio: "The brain behind every data analysis and statistical model.",
                        fullBio: "Andri ensures that every solution we build is grounded in solid statistical models and accurate data analysis. With a deep passion for unlocking patterns, he forms the strategic foundation of TechnoG Solutions.",
                        socials: {
                            linkedin: "https://www.linkedin.com/in/muhamad-andri-rizki-s-stat-a7a394296",
                            github: "#",
                            instagram: "https://www.instagram.com/andririzki11?igsh=YzBlemI4OHZ2cnZm"
                        }
                    },
                    {
                        id: 2,
                        name: 'Ulul Azmi A. Latala',
                        role: 'Co-Founder & Lead Developer',
                        image: "{{ asset('images/founders/fp-ulul.jpeg') }}",
                        shortBio: "The technology architect who translates data insights into robust systems.",
                        fullBio: "Ulul is the technical powerhouse responsible for turning complex data strategies into seamless, scalable, and modern applications. He masters the art of bridging frontend aesthetics with backend performance.",
                        socials: {
                            linkedin: "www.linkedin.com/in/ulul-azmi-a-latala-b2a15a269",
                            github: "https://github.com/UlulAzmiALatala",
                            instagram: "#"
                        }
                    }
                ],
                openModal(founder) {
                    this.activeFounder = founder;
                    this.isModalOpen = true;
                    document.body.style.overflow = 'hidden'; 
                },
                closeModal() {
                    this.isModalOpen = false;
                    document.body.style.overflow = '';
                    setTimeout(() => {
                        this.activeFounder = null;
                    }, 300);
                }
            }
        }
    </script>

    <style>
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.1s linear;
        }
        .card-3d-content {
            transform: translateZ(50px);
        }
        .card-3d-glare {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at var(--glare-x) var(--glare-y), rgba(255, 255, 255, 0.2), transparent 40%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
        }
        .card-3d:hover .card-3d-glare {
            opacity: 1;
        }

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
        .is-in-view .fade-in-item:nth-child(4) { transition-delay: 0.45s; }
        .is-in-view ul > li:nth-child(1) { transition-delay: 0.2s; }
        .is-in-view ul > li:nth-child(2) { transition-delay: 0.3s; }
        .is-in-view ul > li:nth-child(3) { transition-delay: 0.4s; }
        .is-in-view ul > li:nth-child(4) { transition-delay: 0.5s; }
        .is-in-view ul > li:nth-child(5) { transition-delay: 0.6s; }
        .is-in-view .grid > div:nth-child(1) { transition-delay: 0.1s; }
        .is-in-view .grid > div:nth-child(2) { transition-delay: 0.25s; }
        .is-in-view .grid > div:nth-child(3) { transition-delay: 0.4s; }
        .is-in-view .grid > div:nth-child(4) { transition-delay: 0.55s; }
        .is-in-view .grid > div:nth-child(5) { transition-delay: 0.7s; }
    </style>

</x-public>