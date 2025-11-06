{{-- 
    File ini sekarang otomatis menerima $footerLogo dan $socialLinks 
    dari PublicLayoutComposer.
--}}
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            {{-- Kolom Kiri: Logo & Info --}}
            <div class="space-y-8 xl:col-span-1">
                <a href="{{ route('home') }}">
                    {{-- --- PERUBAHAN 1: LOGO DINAMIS --- --}}
                    @if ($footerLogo)
                        <img src="{{ asset('storage/' . $footerLogo->path) }}" alt="TechnoG Solutions Logo" class="h-16 w-auto">
                    @else
                        {{-- Fallback jika logo 'Footer Light' tidak ditemukan --}}
                        <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-16 w-auto">
                    @endif
                    {{-- --- AKHIR PERUBAHAN 1 --- --}}
                </a>
                <p class="text-gray-400 text-base">
                    Turn your digital ideas into precision technology solutions, powered by data.
                </p>
                {{-- --- PERUBAHAN 2: IKON SOSMED DINAMIS --- --}}
                <div class="flex space-x-6">
                    @forelse ($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white">
                            <span class="sr-only">{{ $link->name }}</span>
                            {{-- Panggil komponen ikon kita yang baru --}}
                            <x-social-icon :name="$link->name" />
                        </a>
                    @empty
                        {{-- Tidak menampilkan apa-apa jika tidak ada link --}}
                    @endforelse
                </div>
                {{-- --- AKHIR PERUBAHAN 2 --- --}}
            </div>
            
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="{{ route('public.about') }}" class="text-base text-gray-400 hover:text-white">About Us</a></li>
                            <li><a href="{{ route('public.why-choose-us') }}" class="text-base text-gray-400 hover:text-white">Why Choose Us</a></li>
                            <li><a href="{{ route('public.portfolio') }}" class="text-base text-gray-400 hover:text-white">Our Works</a></li>
                            <li><a href="{{ route('public.blog') }}" class="text-base text-gray-400 hover:text-white">Blog</a></li>
                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Services</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="{{ route('public.services') }}" class="text-base text-gray-400 hover:text-white">IT Solution</a></li>
                            <li><a href="{{ route('public.services') }}" class="text-base text-gray-400 hover:text-white">Statistical Solution</a></li>
                            <li><a href="{{ route('public.services') }}" class="text-base text-gray-400 hover:text-white">Hybrid Pathway</a></li>
                        </ul>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-1 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Get the Latest Insights</h3>
                        <p class="mt-4 text-base text-gray-400">Subscribe to get our latest articles and offers.</p>
                        
                        {{-- --- PERUBAHAN 3: FORM SUBSCRIBE FUNGSIONAL --- --}}
                        <form class="mt-4 sm:flex sm:max-w-md" action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <label for="email-address" class="sr-only">Email address</label>
                            <input type="email" name="email" id="email-address" autocomplete="email" required 
                                   value="{{ old('email') }}"
                                   class="appearance-none min-w-0 w-full bg-gray-800 border @error('email') border-red-500 @else border-gray-600 @enderror rounded-md py-2 px-4 text-base text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                   placeholder="Enter your email">
                            <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                                <button type="submit" class="w-full bg-indigo-600 flex items-center justify-center border border-transparent rounded-md py-2 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                        
                        {{-- Tampilkan pesan Error atau Sukses --}}
                        @if (session('subscribe_success'))
                            <p class="mt-2 text-sm text-green-400">{{ session('subscribe_success') }}</p>
                        @endif
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        {{-- --- AKHIR PERUBAHAN 3 --- --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700 pt-8">
            <p class="text-base text-gray-400 xl:text-center">&copy; {{ date('Y') }} TechnoG Solutions. All rights reserved.</p>
        </div>
    </div>
</footer>