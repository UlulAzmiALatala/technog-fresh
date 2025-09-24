<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - TechnoG Solutions</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased font-sans bg-gray-50 text-gray-800">
    <div x-data="{ openMenu: false }">
        @include('layouts.public-navigation')

        <main>
            {{-- Hero Section --}}
            <section class="relative text-white overflow-hidden h-[378px]">
                <div class="absolute inset-0">
                    <img src="{{ asset('images/backgrounds/contact-hero.jpg') }}" alt="Contact Background" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gray-900/40 mix-blend-multiply"></div>
                </div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center text-center">
                    <div x-data="{}" x-init="$nextTick(() => {
                        $refs.heading.classList.remove('opacity-0', 'translate-y-4');
                        setTimeout(() => $refs.paragraph.classList.remove('opacity-0', 'translate-y-4'), 200);
                    })">
                        <h1 x-ref="heading" class="text-4xl sm:text-5xl font-extrabold tracking-tight transition-all duration-700 ease-out opacity-0 translate-y-4">
                            Contact Us
                        </h1>
                        <p x-ref="paragraph" class="mt-4 text-lg text-gray-300 max-w-3xl mx-auto transition-all duration-700 ease-out opacity-0 translate-y-4">
                            Have a question or want to discuss your project? We're here to help.
                        </p>
                    </div>
                </div>
            </section>

            {{-- Main Content: Form & Contact Info --}}
            <section class="py-24">
                <div x-data="{ animate: false }" x-intersect.once="animate = true" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden lg:grid lg:grid-cols-3 lg:gap-8">
                        
                        {{-- Left Column: Contact Form --}}
                        <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                             class="lg:col-span-2 py-10 px-6 sm:px-10 lg:px-12 transition-all duration-700 ease-out">
                            <h2 class="text-2xl font-bold text-gray-900">Send a Message</h2>
                            
                            {{-- Pesan sukses setelah email terkirim --}}
                            @if(session('success'))
                                <div class="mt-4 px-4 py-3 rounded-md bg-green-100 text-green-700 font-medium">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Formulir Kontak --}}
                            <form action="{{ route('public.contact.submit') }}" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                @csrf
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('subject') border-red-500 @enderror">
                                    @error('subject')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                    <textarea id="message" name="message" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        {{-- Right Column: Contact Information --}}
                        <div :class="animate ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-8'"
                             class="bg-gray-50 p-6 sm:p-10 transition-all duration-700 ease-out">
                            <h3 class="text-xl font-semibold text-gray-900">Contact Information</h3>
                            <p class="mt-2 text-base text-gray-500">We're always happy to hear new ideas.</p>
                            <dl class="mt-8 space-y-6">
                                <dd class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                    </div>
                                    <span class="ml-3 text-base text-gray-500">Jakarta, Indonesia</span>
                                </dd>
                                <dd class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                                    </div>
                                    <span class="ml-3 text-base text-gray-500">+62 823-3144-5884</span>
                                </dd>
                                <dd class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                    </div>
                                    <span class="ml-3 text-base text-gray-500">technog_solutions@outlook.co.id</span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('layouts.public-footer')
    </div>
</body>
</html>