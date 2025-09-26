<x-public>

    {{-- Memberi judul spesifik untuk halaman ini --}}
    <x-slot name="title">
        Our Services - TechnoG Solutions
    </x-slot>

    {{-- KANTONG HERO DIISI DENGAN HERO GAMBAR STATIS --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1600&q=80" alt="Professional Services" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
                <div x-data="{}" x-init="$nextTick(() => {
                    $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                    setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                })">
                    <h1 x-ref="heading" class="text-4xl sm:text-5xl font-extrabold tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">Data-Driven Technology Solutions</h1>
                    <p x-ref="paragraph" class="mt-4 text-lg text-gray-200 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">Explore how we integrate deep statistical analysis with software engineering to create precise and impactful services.</p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Konten utama halaman Services (sistem pemilihan paket) --}}
    <section x-data="{ animate: false }" x-intersect.once="animate = true" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="text-center mb-12 transition-all duration-700 ease-out">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                    Find the Right Package for You
                </h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Select a service category, then explore the packages we've designed specifically for your needs.
                </p>
            </div>

            <div :class="animate ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-8'" x-data="{ selectedCategory: '{{ $serviceCategories->first()->id ?? '' }}' }" class="transition-all duration-700 ease-out">
                <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-10" aria-label="Tabs">
                    @foreach ($serviceCategories as $category)
                        @php
                            $categoryStyle = '';
                            switch ($category->name) {
                                case 'IT SOLUTION': $categoryStyle = 'background-color:#333F4F; color:#FFFFFF;'; break;
                                case 'STATISTICAL SOLUTION': $categoryStyle = 'background-color:#375623; color:#FFFFFF;'; break;
                                case 'HYBRID PATHWAY': $categoryStyle = 'background-color:#00FFFF; color:#083344;'; break;
                            }
                        @endphp
                        <button
                            @click="selectedCategory = '{{ $category->id }}'; selectedPackage = ''"
                            :class="selectedCategory === '{{ $category->id }}' ? 'opacity-100 scale-105 shadow-lg ring-2 ring-black/10' : 'opacity-85 hover:opacity-100 hover:scale-[1.02]'"
                            class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-300"
                            style="{{ $categoryStyle }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-8">
                    @foreach ($serviceCategories as $category)
                        <div x-show="selectedCategory === '{{ $category->id }}'" style="display:none;" x-transition x-data="{ selectedPackage: '' }">
                            @php
                                $order = ['Silver Plan', 'Gold Plan', 'Platinum Sphere', 'Diamond Class', 'Ultima Partnership', 'Custom Engagement'];
                                $servicesOrdered = collect($groupedServices[$category->id] ?? [])->sortBy(function($value, $key) use ($order) {
                                    return array_search($key, $order);
                                });
                            @endphp

                            {{-- Package List View --}}
                            <div x-show="!selectedPackage" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @forelse ($servicesOrdered as $packageName => $servicesInPackage)
                                    <div @click="selectedPackage = '{{ $packageName }}'"
                                         class="rounded-2xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 cursor-pointer"
                                         style="@switch($packageName)
                                                    @case('Silver Plan') background-color:#F2F2F2;color:#000;@break
                                                    @case('Gold Plan') background-color:#FFD700;color:#000;@break
                                                    @case('Platinum Sphere') background-color:#808080;color:#FFF;@break
                                                    @case('Diamond Class') background-color:#305496;color:#FFF;@break
                                                    @case('Ultima Partnership') background-color:#000;color:#FFF;@break
                                                    @case('Custom Engagement') background-color:#1E4174;color:#DDA94B;@break
                                                @endswitch">
                                        <div class="p-6">
                                            <h3 class="text-2xl font-bold">{{ $packageName }}</h3>
                                            <p class="mt-2 text-sm opacity-80 min-h-[40px]">
                                                @switch($packageName)
                                                    @case('Diamond Class') Premium solutions for the most complex needs. @break
                                                    @case('Platinum Sphere') The perfect balance of features and price. @break
                                                    @case('Gold Plan') Our popular package with all essential features. @break
                                                    @case('Silver Plan') The right choice to start on an affordable budget. @break
                                                    @case('Ultima Partnership') A strategic partnership for long-term growth. @break
                                                    @case('Custom Engagement') Design a service tailored to your specific needs. @break
                                                @endswitch
                                            </p>
                                        </div>
                                        <div class="p-6 mt-auto">
                                            <p class="text-sm opacity-80">Starting from</p>
                                            <p class="text-3xl font-bold">$ {{ number_format($servicesInPackage->min('price'), 0, ',', '.') }}</p>
                                            <div class="mt-6 w-full py-3 px-8 text-center font-semibold rounded-lg"
                                                 style="@if(in_array($packageName, ['Silver Plan', 'Gold Plan'])) background-color:rgba(0,0,0,0.1); @else background-color:rgba(255,255,255,0.9);color:#333; @endif">
                                                View Services
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="col-span-3 text-center text-gray-500 py-12">There are no service packages in this category yet.</p>
                                @endforelse
                            </div>

                            {{-- Service List View --}}
                            <div x-show="selectedPackage" x-transition style="display:none;">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-800">Services in <span class="text-indigo-600" x-text="selectedPackage"></span></h2>
                                    <button @click="selectedPackage = ''" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">&larr; Back to Packages</button>
                                </div>
                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

</x-public>