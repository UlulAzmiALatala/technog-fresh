<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Our Services') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Title and Description --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                    Find the Right Package for You
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Select a service category, then explore the packages we've designed specifically for your needs.
                </p>
            </div>

            {{-- AlpineJS Component --}}
            <div x-data="{ 
                selectedCategory: '{{ $selectedCategory->id ?? $serviceCategories->first()->id ?? '' }}',
                updateUrl(slug) {
                    const url = new URL(window.location);
                    url.searchParams.set('category', slug);
                    window.history.pushState({}, '', url);
                }
            }">

                {{-- Tab System for Categories --}}
                <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-10" aria-label="Tabs">
                    @foreach ($serviceCategories as $category)
                        @php
                            $categoryStyle = '';
                            switch ($category->name) {
                                case 'IT SOLUTION':
                                    $categoryStyle = 'background-color:#333F4F; color:#FFFFFF;';
                                    break;
                                case 'STATISTICAL SOLUTION':
                                    $categoryStyle = 'background-color:#375623; color:#FFFFFF;';
                                    break;
                                case 'HYBRID PATHWAY':
                                    $categoryStyle = 'background-color:#00FFFF; color:#083344;';
                                    break;
                            }
                        @endphp

                        <button
                            @click="selectedCategory='{{ $category->id }}'; selectedPackage=''; updateUrl('{{ $category->slug }}')"
                            :class="selectedCategory === '{{ $category->id }}' ? 'opacity-100 scale-105 shadow-lg ring-2 ring-black/10' : 'opacity-85 hover:opacity-100 hover:scale-[1.02]'"
                            class="w-48 px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-300"
                            style="{{ $categoryStyle }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                {{-- Content for Each Category --}}
                <div class="mt-8">
                    @foreach ($serviceCategories as $category)
                        <div x-show="selectedCategory === '{{ $category->id }}'" style="display:none;"
                             x-data="{ selectedPackage: '' }">

                            @php
                                $order = ['Silver Plan', 'Gold Plan', 'Platinum Sphere', 'Diamond Class', 'Ultima Partnership', 'Custom Engagement'];
                                $servicesOrdered = collect($servicesByCategory[$category->id] ?? [])->sortBy(function($value, $key) use ($order) {
                                    return array_search($key, $order);
                                });
                            @endphp

                            {{-- Package List View --}}
                            <div x-show="!selectedPackage" x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @forelse ($servicesOrdered as $packageName => $servicesInPackage)
                                    <div @click="selectedPackage='{{ $packageName }}'"
                                         class="rounded-2xl shadow-lg overflow-hidden flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 cursor-pointer">
                                        
                                        {{-- ====================================================== --}}
                                        {{-- PERUBAHAN UTAMA: Style gradasi premium untuk paket    --}}
                                        {{-- ====================================================== --}}
                                        <div class="p-6 flex-grow flex flex-col"
                                             style="@switch($packageName)
                                                        @case('Silver Plan')
                                                            color:#1f2937; background: radial-gradient(circle at 50% 0%, #e5e7eb, #9ca3af); border: 1px solid rgba(255, 255, 255, 0.2);
                                                            @break
                                                        @case('Gold Plan')
                                                            color:#fff; background: radial-gradient(circle at 50% 0%, #facc15, #b45309); border: 1px solid rgba(255, 255, 255, 0.2);
                                                            @break
                                                        @case('Platinum Sphere')
                                                            color:#fff; background: radial-gradient(circle at 50% 0%, #d1d5db, #4b5563); border: 1px solid rgba(255, 255, 255, 0.1);
                                                            @break
                                                        @case('Diamond Class')
                                                            color:#fff; background: radial-gradient(circle at 50% 0%, #3b82f6, #1e3a8a); border: 1px solid rgba(255, 255, 255, 0.1);
                                                            @break
                                                        @case('Ultima Partnership')
                                                            color:#fff; background: radial-gradient(circle at 50% 0%, #4b5563, #111827); border: 1px solid rgba(255, 255, 255, 0.1);
                                                            @break
                                                        @case('Custom Engagement')
                                                            color:#DDA94B; background-color:#1E4174; border: 1px solid rgba(255, 255, 255, 0.1);
                                                            @break
                                                    @endswitch">
                                            
                                            <h3 class="text-2xl font-bold">{{ $packageName }}</h3>
                                            <p class="mt-2 text-sm opacity-80 min-h-[40px]">
                                                @switch($packageName)
                                                    @case('Diamond Class') Premium solutions for the most complex needs. @break
                                                    @case('Platinum Sphere') The perfect balance between features and price. @break
                                                    @case('Gold Plan') A popular package with all essential features. @break
                                                    @case('Silver Plan') The right choice to start on a budget. @break
                                                    @case('Ultima Partnership') A strategic partnership for long-term growth. @break
                                                    @case('Custom Engagement') Design your own service to fit your needs. @break
                                                @endswitch
                                            </p>
                                        
                                            <div class="mt-auto pt-6">
                                                <p class="text-sm opacity-80">Starting from</p>
                                                <p class="text-3xl font-extrabold">
                                                    Rp {{ number_format($servicesInPackage->min('price'), 0, ',', '.') }}
                                                </p>
                                                <div class="mt-6 w-full py-3 px-8 text-center font-semibold rounded-lg bg-white/90 @if(in_array($packageName, ['Silver Plan'])) text-gray-800 @else text-blue-900 @endif backdrop-blur-sm">
                                                    View Services
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="col-span-3 text-center text-gray-500 py-12">
                                        There are no service packages in this category yet.
                                    </p>
                                @endforelse
                            </div>

                            {{-- Service List View --}}
                            <div x-show="selectedPackage" x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 style="display:none;">

                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-800">
                                        Services in <span class="text-indigo-600" x-text="selectedPackage"></span>
                                    </h2>
                                    <button @click="selectedPackage=''"
                                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">
                                        &larr; Back to Packages
                                    </button>
                                </div>

                                <div class="bg-white rounded-xl shadow-lg p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach ($servicesOrdered as $packageName => $servicesInPackage)
                                            <template x-if="selectedPackage === '{{ $packageName }}'">
                                                <div class="contents">
                                                    @foreach ($servicesInPackage as $service)
                                                        @include('client.services.partials.card', ['service' => $service])
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
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>