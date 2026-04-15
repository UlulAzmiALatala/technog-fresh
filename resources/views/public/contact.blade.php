<x-public>

    <x-slot name="scripts">
        <script src="https://kit.fontawesome.com/c151b27f34.js" crossorigin="anonymous"></script>
    </x-slot>

    <x-slot name="title">
        Contact Us - TechnoG Solutions
    </x-slot>

    {{-- Hero Section (DIKEMBALIKAN KE TINGGI NORMAL, TANPA MIN-H) --}}
    <x-slot name="hero">
        <section class="relative text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('images/backgrounds/contact-hero.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1600&q=80'" alt="Contact Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
            </div>
            
            {{-- Padding disamakan: pt-56 pb-20 --}}
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-48 pb-24 text-center z-10">
                <div x-data="{}" x-init="$nextTick(() => { $el.querySelectorAll('.fade-in-item').forEach((item, index) => setTimeout(() => item.classList.add('in-view'), index * 200)) })">
                    
                    {{-- Judul diubah agar lebih profesional dan pas untuk 2 baris --}}
                    <h1 class="fade-in-item text-4xl sm:text-5xl lg:text-7xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-indigo-300 pb-2 leading-tight">
                        Get in Touch <br class="hidden sm:block"> With Our Experts
                    </h1>
                    
                    <p class="fade-in-item mt-6 text-lg md:text-xl text-indigo-100 max-w-3xl mx-auto font-light">
                        Have a question, an idea, or want to discuss a potential partnership? Our team is ready to listen and help you build the future.
                    </p>
                </div>
            </div>
        </section>
    </x-slot>

    {{-- Konten Utama Halaman Contact --}}
    <section class="py-24 bg-gray-50 relative overflow-hidden">
        {{-- Aesthetic Background Elements --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-100/50 rounded-full blur-[100px] pointer-events-none -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-100/50 rounded-full blur-[100px] pointer-events-none translate-y-1/4 -translate-x-1/4"></div>

        <div x-data="{ animate: false }" x-intersect.once="animate = true" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden lg:grid lg:grid-cols-3">
                
                {{-- Left Column: Contact Form --}}
                <div :class="animate ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     class="lg:col-span-2 py-12 px-6 sm:px-12 lg:px-16 transition-all duration-700 ease-out flex flex-col justify-center">
                    
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Send Us a Message</h2>
                        <p class="mt-3 text-lg text-gray-500">Fill out the form below and we'll get back to you as soon as possible.</p>
                    </div>
                    
                    @if(session('success'))
                        <div class="mt-6 px-6 py-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-4 text-emerald-800 font-medium shadow-sm animate-pulse">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('public.contact.submit') }}" method="POST" class="mt-10 grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-8">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                   placeholder="e.g. John Doe"
                                   class="block w-full px-5 py-3.5 bg-gray-50 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('name') border-red-500 focus:ring-red-500/20 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                                   placeholder="john@example.com"
                                   class="block w-full px-5 py-3.5 bg-gray-50 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('email') border-red-500 focus:ring-red-500/20 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required 
                                   placeholder="How can we help you?"
                                   class="block w-full px-5 py-3.5 bg-gray-50 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('subject') border-red-500 focus:ring-red-500/20 @enderror">
                            @error('subject')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required 
                                      placeholder="Tell us more about your project, needs, or questions..."
                                      class="block w-full px-5 py-3.5 bg-gray-50 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 resize-y @error('message') border-red-500 focus:ring-red-500/20 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="sm:col-span-2 mt-2">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 shadow-lg shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1">
                                Send Message <i class="fa-solid fa-paper-plane ml-3"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                {{-- Right Column: Contact Information (DENGAN SVG ASLI AGAR PASTI MUNCUL) --}}
                <div :class="animate ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'"
                     class="relative bg-gray-900 px-6 py-12 sm:px-12 xl:px-16 transition-all duration-700 ease-out delay-300 flex flex-col justify-between overflow-hidden">
                    
                    {{-- Decorative Abstract Shapes --}}
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-indigo-500 rounded-full blur-3xl opacity-30 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-cyan-400 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5 pointer-events-none"></div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-white tracking-tight">Contact Information</h3>
                        <p class="mt-3 text-base text-indigo-200">Our door is always open. Reach out to us through any of these channels.</p>
                        
                        <dl class="mt-12 space-y-10">
                            {{-- 1. ALAMAT --}}
                            <div class="group flex items-start gap-5">
                                <div class="flex-shrink-0 h-12 w-12 bg-white/10 text-cyan-400 rounded-xl flex items-center justify-center border border-white/10 backdrop-blur-md group-hover:bg-cyan-400 group-hover:text-gray-900 transition-all duration-300 shadow-lg">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="text-sm font-bold text-indigo-300 uppercase tracking-wider mb-1">Our Office</dt>
                                    <dd class="text-base font-medium text-white leading-relaxed">
                                        {{ $settings->address ?? 'Yogyakarta, Indonesia' }}
                                    </dd>
                                </div>
                            </div>

                            {{-- 2. TELEPON --}}
                            <div class="group flex items-start gap-5">
                                <div class="flex-shrink-0 h-12 w-12 bg-white/10 text-cyan-400 rounded-xl flex items-center justify-center border border-white/10 backdrop-blur-md group-hover:bg-cyan-400 group-hover:text-gray-900 transition-all duration-300 shadow-lg">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="text-sm font-bold text-indigo-300 uppercase tracking-wider mb-1">Phone</dt>
                                    <dd class="text-base font-medium text-white leading-relaxed">
                                        <a href="tel:{{ str_replace([' ', '-', '+'], '', $settings->phone ?? '6282331445884') }}" class="hover:text-cyan-300 transition-colors">
                                            {{ $settings->phone ?? '+62 823-3144-5884' }}
                                        </a>
                                    </dd>
                                </div>
                            </div>

                            {{-- 3. EMAIL --}}
                            <div class="group flex items-start gap-5">
                                <div class="flex-shrink-0 h-12 w-12 bg-white/10 text-cyan-400 rounded-xl flex items-center justify-center border border-white/10 backdrop-blur-md group-hover:bg-cyan-400 group-hover:text-gray-900 transition-all duration-300 shadow-lg">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="text-sm font-bold text-indigo-300 uppercase tracking-wider mb-1">Email</dt>
                                    <dd class="text-base font-medium text-white leading-relaxed break-all">
                                        <a href="mailto:{{ $settings->email ?? 'technog_solutions@outlook.co.id' }}" class="hover:text-cyan-300 transition-colors">
                                            {{ $settings->email ?? 'technog_solutions@outlook.co.id' }}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>

                    {{-- Social Media Mini Links (MENGGUNAKAN PURE SVG AGAR PASTI MUNCUL) --}}
                    <div class="relative z-10 mt-16 pt-8 border-t border-white/10">
                        <p class="text-sm font-bold text-indigo-300 uppercase tracking-wider mb-4">Connect With Us</p>
                        <div class="flex space-x-4">
                            {{-- LinkedIn --}}
                            <a href="#" class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-gray-300 hover:bg-[#0A66C2] hover:text-white transition-all duration-300 border border-white/10 hover:border-transparent">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            {{-- Instagram --}}
                            <a href="#" class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-gray-300 hover:bg-gradient-to-tr hover:from-pink-500 hover:to-orange-400 hover:text-white transition-all duration-300 border border-white/10 hover:border-transparent">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            </a>
                            {{-- Twitter / X --}}
                            <a href="#" class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-gray-300 hover:bg-black hover:text-white transition-all duration-300 border border-white/10 hover:border-transparent">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- [WAJIB] CSS untuk Efek Fade In --}}
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
    </style>

</x-public>