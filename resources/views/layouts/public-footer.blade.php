{{-- Lokasi: resources/views/layouts/public-footer.blade.php --}}
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            {{-- Kolom Kiri: Logo & Info --}}
            <div class="space-y-8 xl:col-span-1">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/Logo-Utama-Color.png') }}" alt="TechnoG Solutions Logo" class="h-28 w-auto">
                </a>
                <p class="text-gray-400 text-base">
                    Turn your digital ideas into precision technology solutions, powered by data.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                    <a href="https://www.instagram.com/technog.solutions/" class="text-gray-400 hover:text-white"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.465c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zM12 7a5 5 0 100 10 5 5 0 000-10zm0-2a7 7 0 110 14 7 7 0 010-14zm6.406-2.186a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4z" clip-rule="evenodd" /></svg></a>
                    <a href="#" class="text-gray-400 hover:text-white"><span class="sr-only">Twitter</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg></a>
                </div>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li><a href="{{ route('public.about') }}" class="text-base text-gray-400 hover:text-white">About Us</a></li>
                            {{-- [PERBAIKAN] Mengganti link Our Process dengan Why Choose Us --}}
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
                        <form class="mt-4 sm:flex sm:max-w-md">
                            <label for="email-address" class="sr-only">Email address</label>
                            <input type="email" name="email-address" id="email-address" autocomplete="email" required class="appearance-none min-w-0 w-full bg-gray-800 border border-gray-600 rounded-md py-2 px-4 text-base text-white placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your email">
                            <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                                <button type="submit" class="w-full bg-indigo-600 flex items-center justify-center border border-transparent rounded-md py-2 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700 pt-8">
            <p class="text-base text-gray-400 xl:text-center">&copy; {{ date('Y') }} TechnoG Solutions. All rights reserved.</p>
        </div>
    </div>
</footer>
