{{-- 
    File ini otomatis menerima $footerLogo dan $socialLinks 
    dari PublicLayoutComposer.
--}}
<footer class="relative bg-slate-900 pt-20 pb-10 overflow-hidden border-t border-white/5">
    
    {{-- Aesthetic Background Elements --}}
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 pointer-events-none"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] pointer-events-none -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-cyan-600/20 rounded-full blur-[120px] pointer-events-none translate-y-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
            
            {{-- Kolom 1: Logo, Bio & Socials --}}
            <div class="lg:col-span-4 space-y-8">
                <a href="{{ route('home') }}" class="block transform transition-transform hover:scale-105 origin-left inline-block">
                    {{-- --- LOGO DINAMIS --- --}}
                    @if ($footerLogo)
                        <img src="{{ asset('storage/' . $footerLogo->path) }}" alt="TechnoG Solutions Logo" class="h-14 w-auto drop-shadow-lg">
                    @else
                        {{-- Fallback jika logo 'Footer Light' tidak ditemukan --}}
                        <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-14 w-auto drop-shadow-lg">
                    @endif
                </a>
                
                <p class="text-indigo-100/70 text-base leading-relaxed max-w-sm">
                    Turn your digital ideas into precision technology solutions, powered by data. We build the future of your business today.
                </p>
                
                {{-- --- IKON SOSMED DINAMIS --- --}}
                <div class="flex flex-wrap gap-4 mt-8">
                    @forelse ($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" 
                           class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 border border-white/10 hover:border-transparent hover:shadow-[0_0_15px_rgba(99,102,241,0.5)] transform hover:-translate-y-1">
                            <span class="sr-only">{{ $link->name }}</span>
                            {{-- Panggil komponen ikon kita yang baru --}}
                            <x-social-icon :name="$link->name" />
                        </a>
                    @empty
                        {{-- Fallback Kosong --}}
                    @endforelse
                </div>
            </div>
            
            {{-- Kolom 2: Company Links --}}
            <div class="lg:col-span-2 lg:col-start-6">
                <h3 class="text-sm font-bold text-white tracking-widest uppercase mb-6">Company</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('public.about') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.why-choose-us') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> Why Choose Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.portfolio') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> Our Works
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.blog') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> Blog
                        </a>
                    </li>
                </ul>
            </div>
            
            {{-- Kolom 3: Services Links --}}
            <div class="lg:col-span-2">
                <h3 class="text-sm font-bold text-white tracking-widest uppercase mb-6">Services</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('public.services') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> IT Solution
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.services') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> Statistical Solution
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.services') }}" class="group flex items-center gap-3 text-base text-gray-400 hover:text-cyan-400 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-700 group-hover:bg-cyan-400 transition-colors"></span> Hybrid Pathway
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 4: Newsletter Form --}}
            <div class="lg:col-span-3">
                <h3 class="text-sm font-bold text-white tracking-widest uppercase mb-6">Get the Latest Insights</h3>
                <p class="text-base text-gray-400 mb-6">Subscribe to get our latest articles, updates, and special offers delivered to your inbox.</p>
                
                {{-- --- FORM SUBSCRIBE FUNGSIONAL --- --}}
                <form action="{{ route('subscribe') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    <div class="relative">
                        <label for="email-address" class="sr-only">Email address</label>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-500"></i>
                        </div>
                        <input type="email" name="email" id="email-address" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="block w-full pl-11 pr-4 py-3.5 bg-white/5 border @error('email') border-red-500/50 @else border-white/10 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-white/10 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-all duration-300" 
                               placeholder="Enter your email">
                    </div>
                    
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 border border-transparent rounded-xl py-3.5 px-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <span>Subscribe Now</span>
                        <i class="fa-solid fa-paper-plane text-indigo-200"></i>
                    </button>
                </form>
                
                {{-- Notifikasi Sukses / Error --}}
                @if (session('subscribe_success'))
                    <div class="mt-4 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 mt-0.5"></i>
                        <p class="text-sm text-emerald-200">{{ session('subscribe_success') }}</p>
                    </div>
                @endif
                @error('email')
                    <div class="mt-4 px-4 py-3 bg-rose-500/10 border border-rose-500/20 rounded-lg flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-rose-400 mt-0.5"></i>
                        <p class="text-sm text-rose-200">{{ $message }}</p>
                    </div>
                @enderror
            </div>
            
        </div>

        {{-- Copyright & Bottom Bar --}}
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} TechnoG Solutions. All rights reserved.
            </p>
            <div class="flex items-center gap-6 text-sm text-gray-500 font-medium">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>