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

            {{-- Tab System for Categories --}}
            <div x-data="{ selectedCategory: '{{ $serviceCategories->first()->id ?? '' }}' }">
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
                            @click="selectedCategory='{{ $category->id }}'; selectedPackage=''"
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

                            {{-- Sort packages --}}
                            @php
                                $order = ['Silver Plan', 'Gold Plan', 'Platinum Sphere', 'Diamond Class', 'Ultima Partnership', 'Custom Engagement'];
                                $servicesOrdered = collect($groupedServices[$category->id] ?? [])->sortBy(function($value, $key) use ($order) {
                                    return array_search($key, $order);
                                });
                            @endphp

                            {{-- Package List View --}}
                            <div x-show="!selectedPackage" x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @forelse ($servicesOrdered as $packageName => $servicesInPackage)
                                    <div @click="selectedPackage='{{ $packageName }}'"
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
                                                    @case('Diamond Class')
                                                        Premium solutions for the most complex needs.
                                                        @break
                                                    @case('Platinum Sphere')
                                                        The perfect balance between features and price.
                                                        @break
                                                    @case('Gold Plan')
                                                        A popular package with all essential features.
                                                        @break
                                                    @case('Silver Plan')
                                                        The right choice to start on a budget.
                                                        @break
                                                    @case('Ultima Partnership')
                                                        A strategic partnership for long-term growth.
                                                        @break
                                                    @case('Custom Engagement')
                                                        Design your own service to fit your needs.
                                                        @break
                                                @endswitch
                                            </p>
                                        </div>
                                        <div class="p-6 mt-auto">
                                            <p class="text-sm opacity-80">Starting from</p>
                                            <p class="text-3xl font-extrabold">
                                                ${{ number_format($servicesInPackage->min('price'), 0) }}
                                            </p>
                                            <div class="mt-6 w-full py-3 px-8 text-center font-semibold rounded-lg"
                                                 style="@if(in_array($packageName, ['Silver Plan', 'Gold Plan']))
                                                            background-color:rgba(0,0,0,0.1);
                                                        @else
                                                            background-color:rgba(255,255,255,0.9);color:#333;
                                                        @endif">
                                                View Services
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
                                                        {{-- Service Card --}}
                                                        <div class="rounded-3xl shadow-md overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200"
                                                             style="@switch($packageName)
                                                                        @case('Silver Plan') background-color:#F2F2F2;color:#000;@break
                                                                        @case('Gold Plan') background-color:#FFD700;color:#000;@break
                                                                        @case('Platinum Sphere') background-color:#808080;color:#FFF;@break
                                                                        @case('Diamond Class') background-color:#305496;color:#FFF;@break
                                                                        @case('Ultima Partnership') background-color:#000;color:#FFF;@break
                                                                        @case('Custom Engagement') background-color:#1E4174;color:#DDA94B;@break
                                                                    @endswitch">

                                                            {{-- Image --}}
                                                            <div class="relative h-52">
                                                                <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://placehold.co/400x300/eee/999?text=Service' }}"
                                                                     alt="{{ $service->name }}"
                                                                     class="w-full h-full object-cover">
                                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                                                                <div class="absolute top-4 right-4">
                                                                    <span class="px-4 py-1 text-sm font-semibold rounded-full shadow"
                                                                          style="@switch($packageName)
                                                                                    @case('Silver Plan') background-color:#F2F2F2;color:#000;@break
                                                                                    @case('Gold Plan') background-color:#FFD700;color:#000;@break
                                                                                    @case('Platinum Sphere') background-color:#808080;color:#FFF;@break
                                                                                    @case('Diamond Class') background-color:#305496;color:#FFF;@break
                                                                                    @case('Ultima Partnership') background-color:#000;color:#FFF;@break
                                                                                    @case('Custom Engagement') background-color:#1E4174;color:#DDA94B;@break
                                                                                @endswitch">
                                                                        ${{ number_format($service->price, 0) }}
                                                                    </span>
                                                                </div>
                                                                <div class="absolute bottom-4 left-4">
                                                                    <h3 class="text-white font-bold text-lg tracking-tight">
                                                                        {{ $service->name }}
                                                                    </h3>
                                                                    <p class="text-gray-200 text-sm">
                                                                        Est. {{ $service->estimated_duration }} {{ $service->duration_unit }}
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            {{-- Content --}}
                                                            <div class="p-6 flex flex-col flex-grow">
                                                                {{-- Main Features --}}
                                                                <ul class="space-y-2 text-sm leading-relaxed flex-grow">
                                                                    @if($service->features)
                                                                        @foreach(explode("\n", $service->features) as $index => $feature)
                                                                            @if(trim($feature) && $index < 4)
                                                                                <li class="flex items-start">
                                                                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500 mt-0.5 mr-2"
                                                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                              d="M5 13l4 4L19 7" />
                                                                                    </svg>
                                                                                    <span>{{ trim(str_replace('-', '', $feature)) }}</span>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <li class="text-gray-400 italic">Feature details not yet available.</li>
                                                                    @endif
                                                                </ul>

                                                                {{-- Buttons --}}
                                                                <div class="mt-6 flex space-x-3">
                                                                    <a href="{{ route('client.services.show', $service->id) }}"
                                                                       class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 text-sm font-medium transition-colors">
                                                                        Details
                                                                    </a>
                                                                    
                                                                    <form action="{{ route('client.services.order', $service->id) }}" method="POST" class="flex-1">
                                                                        @csrf
                                                                        <button type="submit"
                                                                                class="w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-semibold shadow-md transition-all">
                                                                            Order
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
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