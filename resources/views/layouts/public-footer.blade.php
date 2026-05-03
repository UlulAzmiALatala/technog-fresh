{{-- 
    File ini otomatis menerima $footerLogo dan $socialLinks 
    dari PublicLayoutComposer.
--}}
@php
    // Menarik data setting secara mandiri agar aman dipanggil di semua halaman
    $settings = \App\Models\Setting::pluck('value', 'key');
@endphp

<footer class="relative bg-slate-900 pt-20 pb-10 overflow-hidden border-t border-white/5">
    
    {{-- Aesthetic Background Elements --}}
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 pointer-events-none"></div>
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px] pointer-events-none -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-cyan-600/20 rounded-full blur-[120px] pointer-events-none translate-y-1/2"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
            
            {{-- Kolom 1: Logo, Bio, CONTACT INFO & Socials --}}
            <div class="lg:col-span-4 space-y-6">
                <a href="{{ route('home') }}" class="block transform transition-transform hover:scale-105 origin-left inline-block">
                    {{-- --- LOGO DINAMIS --- --}}
                    @if ($footerLogo)
                        <img src="{{ asset('storage/' . $footerLogo->path) }}" alt="TechnoG Solutions Logo" class="h-14 w-auto drop-shadow-lg">
                    @else
                        <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-14 w-auto drop-shadow-lg">
                    @endif
                </a>
                
                <p class="text-indigo-100/70 text-base leading-relaxed max-w-sm">
                    Turn your digital ideas into precision technology solutions, powered by data. We build the future of your business today.
                </p>

                {{-- --- INFO KONTAK DINAMIS (PURE SVG) --- --}}
                <ul class="space-y-4 pt-2">
                    {{-- Alamat --}}
                    <li class="flex items-start gap-3 group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-slate-900 transition-all shadow-sm">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                        </div>
                        <span class="text-sm text-indigo-100/70 pt-1.5 group-hover:text-white transition-colors leading-snug">
                            {{ $settings['contact_address'] ?? 'Yogyakarta, Indonesia' }}
                        </span>
                    </li>
                    
                    {{-- Telepon --}}
                    <li class="flex items-center gap-3 group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-slate-900 transition-all shadow-sm">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                        </div>
                        <a href="tel:{{ str_replace([' ', '-', '+'], '', $settings['contact_phone'] ?? '6282331445884') }}" class="text-sm text-indigo-100/70 pt-1 group-hover:text-white transition-colors">
                            {{ $settings['contact_phone'] ?? '+62 823-3144-5884' }}
                        </a>
                    </li>

                    {{-- Email --}}
                    <li class="flex items-center gap-3 group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500 group-hover:text-slate-900 transition-all shadow-sm">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        </div>
                        <a href="mailto:{{ $settings['contact_email'] ?? 'technog_solutions@outlook.co.id' }}" class="text-sm text-indigo-100/70 pt-1 group-hover:text-white transition-colors break-all">
                            {{ $settings['contact_email'] ?? 'technog_solutions@outlook.co.id' }}
                        </a>
                    </li>
                </ul>
                
                {{-- --- IKON SOSMED DINAMIS --- --}}
                <div class="flex flex-wrap gap-4 pt-2">
                    @forelse ($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" 
                           class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-300 border border-white/10 hover:border-transparent hover:shadow-[0_0_15px_rgba(99,102,241,0.5)] transform hover:-translate-y-1">
                            <span class="sr-only">{{ $link->name }}</span>
                            <x-social-icon :name="$link->name" />
                        </a>
                    @empty
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
                            {{-- Envelope SVG untuk form subscribe --}}
                            <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        </div>
                        <input type="email" name="email" id="email-address" autocomplete="email" required 
                               value="{{ old('email') }}"
                               class="block w-full pl-11 pr-4 py-3.5 bg-white/5 border @error('email') border-red-500/50 @else border-white/10 @enderror rounded-xl text-white placeholder-gray-500 focus:outline-none focus:bg-white/10 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-all duration-300" 
                               placeholder="Enter your email">
                    </div>
                    
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 border border-transparent rounded-xl py-3.5 px-4 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <span>Subscribe Now</span>
                        {{-- Paper Plane SVG --}}
                        <svg class="w-4 h-4 text-indigo-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                    </button>
                </form>
                
                {{-- Notifikasi Sukses / Error --}}
                @if (session('subscribe_success'))
                    <div class="mt-4 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg flex items-start gap-3">
                        <svg class="w-4 h-4 text-emerald-400 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        <p class="text-sm text-emerald-200">{{ session('subscribe_success') }}</p>
                    </div>
                @endif
                @error('email')
                    <div class="mt-4 px-4 py-3 bg-rose-500/10 border border-rose-500/20 rounded-lg flex items-start gap-3">
                        <svg class="w-4 h-4 text-rose-400 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3Z" /></svg>
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