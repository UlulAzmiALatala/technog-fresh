<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Our Services - TechnoG Solutions
    </x-slot>

    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="Professional Services" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300 pb-2">
                        Data-Driven Technology Solutions
                    </h1>
                    <p class="fade-in-item mt-6 text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        Explore how we integrate deep statistical analysis with software engineering to create precise and impactful services.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-indigo-50/50 rounded-full blur-[100px] pointer-events-none -translate-y-1/2 -translate-x-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-cyan-50/50 rounded-full blur-[100px] pointer-events-none translate-y-1/4 translate-x-1/4"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-16 transition-all duration-700 ease-out">
                <h2 class="text-sm font-bold tracking-widest text-indigo-600 uppercase tracking-[0.2em]">Our Expertise</h2>
                <h3 class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                    Find the Right Package for You
                </h3>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Select a service category, then explore the packages we've meticulously designed to fit your specific needs and scale.
                </p>
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" 
                 x-data="{ selectedCategory: '{{ $serviceCategories->first()->id ?? '' }}' }" 
                 class="transition-all duration-700 ease-out">
                
                <div class="flex flex-wrap justify-center gap-3 md:gap-6 mb-16 relative z-20" aria-label="Tabs">
                    @foreach ($serviceCategories as $category)
                        @php
                            $categoryStyle = '';
                            $hoverShadow = '';
                            switch ($category->name) {
                                case 'IT SOLUTION': 
                                    $categoryStyle = 'background-color:#333F4F; color:#FFFFFF;'; 
                                    $hoverShadow = 'rgba(51, 63, 79, 0.4)';
                                    break;
                                case 'STATISTICAL SOLUTION': 
                                    $categoryStyle = 'background-color:#375623; color:#FFFFFF;'; 
                                    $hoverShadow = 'rgba(55, 86, 35, 0.4)';
                                    break;
                                case 'HYBRID PATHWAY': 
                                    $categoryStyle = 'background-color:#00FFFF; color:#083344;'; 
                                    $hoverShadow = 'rgba(0, 255, 255, 0.4)';
                                    break;
                            }
                        @endphp
                        <button
                            @click="selectedCategory = '{{ $category->id }}'; selectedPackage = ''"
                            :class="selectedCategory === '{{ $category->id }}' ? 'scale-105 shadow-xl ring-2 ring-offset-2 ring-indigo-100' : 'opacity-70 hover:opacity-100 hover:scale-[1.02]'"
                            class="px-6 py-3 rounded-full font-bold text-sm tracking-wide transition-all duration-300 border border-black/5"
                            :style="selectedCategory === '{{ $category->id }}' ? '{{ $categoryStyle }} box-shadow: 0 10px 20px {{ $hoverShadow }}' : '{{ $categoryStyle }}'">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-8">
                    @foreach ($serviceCategories as $category)
                        <div x-show="selectedCategory === '{{ $category->id }}'" style="display:none;" 
                             x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="opacity-0 translate-y-4" 
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-data="{ selectedPackage: '' }">
                            
                            @php
                                $order = ['Silver Plan', 'Gold Plan', 'Platinum Sphere', 'Diamond Class', 'Ultima Partnership', 'Custom Engagement'];
                                $servicesOrdered = collect($groupedServices[$category->id] ?? [])->sortBy(function($value, $key) use ($order) {
                                    return array_search($key, $order);
                                });
                            @endphp

                            <div x-show="!selectedPackage" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @forelse ($servicesOrdered as $packageName => $servicesInPackage)
                                    <div @click="selectedPackage = '{{ $packageName }}'"
                                         class="card-3d relative rounded-[2rem] p-1 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 ease-out hover:shadow-[0_20px_40px_rgba(99,102,241,0.15)] hover:-translate-y-2 cursor-pointer group"
                                         x-data="{ rotateX: 0, rotateY: 0 }" 
                                         @mousemove="const rect = $el.getBoundingClientRect(); rotateY = ((event.clientX - rect.left) / rect.width - 0.5) * -10; rotateX = ((event.clientY - rect.top) / rect.height - 0.5) * 10;" 
                                         @mouseleave="rotateX = 0; rotateY = 0" 
                                         :style="{ transform: `rotateX(${rotateX}deg) rotateY(${rotateY}deg)` }">
                                        
                                        <div class="h-full rounded-[1.8rem] p-8 flex flex-col relative overflow-hidden"
                                             style="@switch($packageName)
                                                        @case('Silver Plan') background: linear-gradient(135deg, #f3f4f6, #d1d5db); color: #1f2937; @break
                                                        @case('Gold Plan') background: linear-gradient(135deg, #fdf08a, #d97706); color: #78350f; @break
                                                        @case('Platinum Sphere') background: linear-gradient(135deg, #e5e7eb, #6b7280); color: #111827; @break
                                                        @case('Diamond Class') background: linear-gradient(135deg, #60a5fa, #1e3a8a); color: #ffffff; @break
                                                        @case('Ultima Partnership') background: linear-gradient(135deg, #374151, #030712); color: #ffffff; @break
                                                        @case('Custom Engagement') background: linear-gradient(135deg, #1E4174, #0b1a30); color: #FCD34D; @break
                                                    @endswitch">
                                            
                                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                                            
                                            <div class="relative z-10 flex flex-col h-full">
                                                <div class="flex justify-between items-start mb-6">
                                                    <h3 class="text-2xl font-extrabold tracking-tight">{{ $packageName }}</h3>
                                                    <div class="w-10 h-10 rounded-full bg-black/10 flex items-center justify-center backdrop-blur-sm">
                                                        @switch($packageName)
                                                            @case('Silver Plan') <i class="fa-solid fa-paper-plane"></i> @break
                                                            @case('Gold Plan') <i class="fa-solid fa-star"></i> @break
                                                            @case('Platinum Sphere') <i class="fa-solid fa-gem"></i> @break
                                                            @case('Diamond Class') <i class="fa-solid fa-crown"></i> @break
                                                            @case('Ultima Partnership') <i class="fa-solid fa-handshake"></i> @break
                                                            @case('Custom Engagement') <i class="fa-solid fa-wand-magic-sparkles"></i> @break
                                                        @endswitch
                                                    </div>
                                                </div>

                                                <p class="text-sm opacity-90 min-h-[48px] font-medium leading-relaxed">
                                                    @switch($packageName)
                                                        @case('Diamond Class') Premium solutions reserved for the most complex needs. @break
                                                        @case('Platinum Sphere') The perfect balance of advanced features and scalability. @break
                                                        @case('Gold Plan') Our most popular package with all the essential features. @break
                                                        @case('Silver Plan') The right choice to start building on an affordable budget. @break
                                                        @case('Ultima Partnership') A strategic, dedicated partnership for long-term growth. @break
                                                        @case('Custom Engagement') Design a unique service tailored precisely to your vision. @break
                                                    @endswitch
                                                </p>
                                            
                                                <div class="mt-auto pt-8">
                                                    <p class="text-xs font-bold uppercase tracking-wider opacity-70 mb-1">Starting from</p>
                                                    <div class="flex items-baseline gap-1">
                                                        {{-- DIUBAH KE DOLLAR ($) DENGAN FORMAT US --}}
                                                        <span class="text-xl font-bold opacity-80">$</span>
                                                        <span class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ number_format($servicesInPackage->min('price'), 0, '.', ',') }}</span>
                                                    </div>
                                                    
                                                    <div class="mt-8 w-full py-3.5 px-6 text-center font-bold text-sm uppercase tracking-wide rounded-xl bg-white/90 backdrop-blur-md shadow-lg transform group-hover:scale-[1.02] transition-all duration-300
                                                                @if(in_array($packageName, ['Silver Plan', 'Platinum Sphere'])) text-gray-900 
                                                                @elseif($packageName == 'Gold Plan') text-amber-900
                                                                @else text-indigo-900 @endif">
                                                        Explore Services <i class="fa-solid fa-arrow-right ml-2 opacity-50 group-hover:translate-x-1 group-hover:opacity-100 transition-all"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-gray-50 border border-dashed border-gray-300 rounded-[2rem] p-12 text-center">
                                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-sm mb-4">
                                            <i class="fa-solid fa-box-open text-gray-400 fa-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Packages Coming Soon</h3>
                                        <p class="text-gray-500">We are currently curating the best packages for this category.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div x-show="selectedPackage" 
                                 x-transition:enter="transition ease-out duration-500 delay-200" 
                                 x-transition:enter-start="opacity-0 translate-y-8" 
                                 x-transition:enter-end="opacity-100 translate-y-0" 
                                 style="display:none;" 
                                 class="bg-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
                                
                                <div class="bg-gray-50 border-b border-gray-100 px-6 sm:px-10 py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div>
                                        <p class="text-xs font-bold tracking-widest text-indigo-600 uppercase mb-1">Available Services</p>
                                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                                            <span x-text="selectedPackage"></span>
                                        </h2>
                                    </div>
                                    <button @click="selectedPackage = ''" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 text-sm font-bold shadow-sm transition-all duration-300">
                                        <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Back to Packages
                                    </button>
                                </div>
                                
                                <div class="p-6 sm:p-10 bg-gray-50/50">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                        @foreach ($servicesOrdered as $packageName => $servicesInPackage)
                                            <template x-if="selectedPackage === '{{ $packageName }}'">
                                                <div class="contents">
                                                    @foreach ($servicesInPackage as $service)
                                                        @include('public.partials.service-card', ['service' => $service])
                                                    @endforeach
                                                </div>
                                            </template>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <style>
        .fade-in-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-item.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        .card-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
    </style>

</x-public>