<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - TechnoG Solutions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
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
                    <img src="images/backgrounds/about-hero.jpg" alt="TechnoG Team" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/40 mix-blend-multiply"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 200)" 
                         :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" 
                         class="transition-all duration-1000 ease-out">
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">The Power Behind Precision</h1>
                        <p class="mt-4 text-lg text-gray-200 max-w-3xl mx-auto">We are the synergy of statisticians and IT developers, dedicated to creating intelligent, evidence-based technology solutions.</p>
                    </div>
                </div>
            </section>

            {{-- Vision & Mission Section --}}
            <section class="py-24 bg-white">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900">Our Vision</h2>
                        <p class="mt-4 text-lg text-gray-600 leading-relaxed">To be a pioneer in the technology industry by integrating data analysis and statistics as the core of every innovation, creating solutions with an unparalleled level of precision and reliability.</p>
                        <h2 class="text-3xl font-extrabold text-gray-900 mt-10">Our Mission</h2>
                        <ul class="mt-4 text-lg text-gray-600 space-y-4">
                            <li class="flex items-start"><span class="text-indigo-500 font-bold mr-3">&rarr;</span> Building software that is intelligent, not just functional.</li>
                            <li class="flex items-start"><span class="text-indigo-500 font-bold mr-3">&rarr;</span> Using data to solve complex business challenges.</li>
                            <li class="flex items-start"><span class="text-indigo-500 font-bold mr-3">&rarr;</span> Empowering clients with data-driven tools for better decision-making.</li>
                            <li class="flex items-start"><span class="text-indigo-500 font-bold mr-3">&rarr;</span> Upholding integrity and accuracy as the main pillars in every project.</li>
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <img class="rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1600&q=80" alt="TechnoG team collaborating">
                    </div>
                </div>
            </section>

            {{-- Core Values Section --}}
            <section class="py-24 bg-gray-50">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Our Core Values</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">The principles that guide our work and define who we are.</p>
                    </div>
                    <div class="mt-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto">
                                <i class="fa-solid fa-brain fa-2xl"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-bold">Data-Driven</h3>
                            <p class="mt-2 text-base text-gray-600">We believe that the best decisions are backed by data. Every solution we build is rooted in rigorous statistical analysis.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto">
                               <i class="fa-solid fa-lightbulb fa-2xl"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-bold">Innovation</h3>
                            <p class="mt-2 text-base text-gray-600">We constantly explore new technologies and methods to deliver cutting-edge solutions that provide a competitive advantage.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto">
                                <i class="fa-solid fa-handshake-angle fa-2xl"></i>
                            </div>
                            <h3 class="mt-6 text-xl font-bold">Partnership</h3>
                            <p class="mt-2 text-base text-gray-600">We work collaboratively with our clients, treating their challenges as our own to achieve shared success.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Team Section --}}
            <section class="py-24 bg-white">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-1000 ease-out max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Meet Our Founders</h2>
                        <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Our strength lies in the unique synergy of our expertise.</p>
                    </div>
                    <div class="mt-16 grid gap-16 sm:grid-cols-1 lg:grid-cols-2">
                        <div class="text-center">
                            <img class="mx-auto h-40 w-40 rounded-full object-cover shadow-lg" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Founder Photo">
                            <h3 class="mt-6 text-2xl font-medium text-gray-900">Andri Rizki</h3>
                            <p class="text-indigo-600 font-semibold">Founder & Statistical Analyst</p>
                            <p class="mt-2 max-w-md mx-auto text-gray-500">The brain behind every data analysis and statistical model, ensuring our solutions are accurate and reliable.</p>
                        </div>
                        <div class="text-center">
                            <img class="mx-auto h-40 w-40 rounded-full object-cover shadow-lg" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Co-Founder Photo">
                            <h3 class="mt-6 text-2xl font-medium text-gray-900">Ulul Azmi A. Latala</h3>
                            <p class="text-indigo-600 font-semibold">Co-Founder & Lead Developer</p>
                            <p class="mt-2 max-w-md mx-auto text-gray-500">The technology architect who translates data insights into robust and intuitive applications and systems.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>
