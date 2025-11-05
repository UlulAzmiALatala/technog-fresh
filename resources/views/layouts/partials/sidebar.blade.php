{{-- Lokasi: resources/views/layouts/partials/sidebar.blade.php (FINAL DENGAN SETTINGS) --}}

<div :style="`width: ${sidebarWidth}px`" 
     class="fixed inset-y-0 left-0 bg-slate-800 text-white flex flex-col z-30 transform"
     :class="{ 
         '-translate-x-full': !sidebarOpen, 
         'transition-all duration-300 ease-in-out': isLoaded 
     }">
    
    <div class="flex-grow flex flex-col overflow-hidden">
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-700 relative flex-shrink-0">
            <a href="{{ route('admin.pemasukan.orders.index') }}" 
               class="transition-opacity duration-300 whitespace-nowrap flex justify-center w-full"
               :title="sidebarOpen ? 'TechnoG Solutions Dashboard' : 'Dashboard'">
                <img src="{{ asset('images/Logo-Icon-Color.png') }}" 
                     alt="TechnoG" 
                     x-cloak
                     class="transition-all duration-300"
                     :class="{
                         'h-14 w-auto': sidebarOpen && sidebarWidth > 200,
                         'h-12 w-auto': sidebarOpen && sidebarWidth <= 200,
                         'h-10 w-auto': !sidebarOpen
                     }">
            </a>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">

            {{-- === MENU REFACTOR BERDASARKAN INSTRUKSI BARU === --}}

            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                {{-- 1. LINK UTAMA: Orders --}}
                <a href="{{ route('admin.pemasukan.orders.index') }}" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.pemasukan.orders.*') ? 'bg-slate-700 text-white' : 'hover:bg-slate-700/50 hover:text-white' }}" 
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   :title="!sidebarOpen ? 'Orders' : ''">
                    <i class="fa-solid fa-receipt fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Orders</span>
                </a>
            @endhasanyrole

            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                {{-- 2. LINK UTAMA: Expenses --}}
                <a href="{{ route('admin.pengeluaran.expenses.index') }}" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'bg-slate-700 text-white' : 'hover:bg-slate-700/50 hover:text-white' }}" 
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   :title="!sidebarOpen ? 'Expenses' : ''">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Expenses</span>
                </a>
            @endhasanyrole

            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                {{-- 3. DROPDOWN: Catalog (Services & Discounts) --}}
                @php $catalogActive = request()->routeIs(['admin.pemasukan.services.*', 'admin.pemasukan.discounts.*']); @endphp
                <div x-data="{ open: {{ $catalogActive ? 'true' : 'false' }}, active: {{ $catalogActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            :class="[
                                sidebarOpen ? 'justify-between' : 'justify-center',
                                active ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'
                            ]"
                            class="flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200"
                            :title="!sidebarOpen ? 'Catalog' : ''">
                        <div class="flex items-center">
                            <i class="fa-solid fa-tags fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Catalog</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.pemasukan.services.index') }}" @click.stop :title="!sidebarOpen ? 'Services' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.services.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-layer-group fa-fw w-5 mr-3 text-center"></i>
                            <span>Services</span>
                        </a>
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" @click.stop :title="!sidebarOpen ? 'Discounts' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-percent fa-fw w-5 mr-3 text-center"></i>
                            <span>Discounts</span>
                        </a>
                    </div>
                </div>
            @endhasanyrole
            
            @hasanyrole('Founder|Konten|Pemasukan dan Pengeluaran')
                {{-- 4. DROPDOWN KONTEN (SAMA) --}}
                @php $contentActive = request()->routeIs(['admin.founder.posts.*', 'admin.founder.case-studies.*', 'admin.testimonials.*']); @endphp
                <div x-data="{ open: {{ $contentActive ? 'true' : 'false' }}, active: {{ $contentActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            :class="[
                                sidebarOpen ? 'justify-between' : 'justify-center',
                                active ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'
                            ]"
                            class="flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200"
                            :title="!sidebarOpen ? 'Content' : ''">
                        <div class="flex items-center">
                            <i class="fa-solid fa-pen-to-square fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Content</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        
                        @hasanyrole('Founder|Konten')
                            <a href="{{ route('admin.founder.posts.index') }}" @click.stop :title="!sidebarOpen ? 'Blog' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.posts.*') ? 'text-white bg-slate-700' : '' }}">
                                <i class="fa-solid fa-pen-ruler fa-fw w-5 mr-3 text-center"></i>
                                <span>Blog</span>
                            </a>
                            <a href="{{ route('admin.founder.case-studies.index') }}" @click.stop :title="!sidebarOpen ? 'Portfolio' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.case-studies.*') ? 'text-white bg-slate-700' : '' }}">
                                <i class="fa-solid fa-image-portrait fa-fw w-5 mr-3 text-center"></i>
                                <span>Portfolio</span>
                            </a>
                        @endhasanyrole

                        <a href="{{ route('admin.testimonials.index') }}" @click.stop :title="!sidebarOpen ? 'Testimonials' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.testimonials.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-comment-dots fa-fw w-5 mr-3 text-center"></i>
                            <span>Testimonials</span>
                        </a>
                    </div>
                </div>
            @endhasanyrole
            
            @role('Founder')
                {{-- 5. DROPDOWN: Site Settings (Founder Only) --}}
                @php $settingsActive = request()->routeIs('admin.founder.settings.*'); @endphp
                <div x-data="{ open: {{ $settingsActive ? 'true' : 'false' }}, active: {{ $settingsActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            :class="[
                                sidebarOpen ? 'justify-between' : 'justify-center',
                                active ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'
                            ]"
                            class="flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200"
                            :title="!sidebarOpen ? 'Site Settings' : ''">
                        <div class="flex items-center">
                            <i class="fa-solid fa-cogs fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Site Settings</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.founder.settings.contact.index') }}" @click.stop :title="!sidebarOpen ? 'Contact Info' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.settings.contact.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-address-book fa-fw w-5 mr-3 text-center"></i>
                            <span>Contact Info</span>
                        </a>
                        <a href="{{ route('admin.founder.settings.social-links.index') }}" @click.stop :title="!sidebarOpen ? 'Social Links' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.settings.social-links.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-share-nodes fa-fw w-5 mr-3 text-center"></i>
                            <span>Social Links</span>
                        </a>
                        <a href="{{ route('admin.founder.settings.logos.index') }}" @click.stop :title="!sidebarOpen ? 'Logos' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.settings.logos.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-image fa-fw w-5 mr-3 text-center"></i>
                            <span>Logos</span>
                        </a>
                    </div>
                </div>

                {{-- 6. DROPDOWN: Administration (Founder Only) --}}
                @php $adminActive = request()->routeIs(['admin.founder.reports.*', 'admin.founder.management-fee.*']); @endphp
                <div x-data="{ open: {{ $adminActive ? 'true' : 'false' }}, active: {{ $adminActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            :class="[
                                sidebarOpen ? 'justify-between' : 'justify-center',
                                active ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'
                            ]"
                            class="flex items-center w-full px-4 py-2.5 rounded-lg transition-colors duration-200"
                            :title="!sidebarOpen ? 'Administration' : ''">
                        <div class="flex items-center">
                            {{-- Mengganti ikon ke 'shield' sbg ikon utama --}}
                            <i class="fa-solid fa-shield-halved fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Administration</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.founder.reports.index') }}" @click.stop :title="!sidebarOpen ? 'Reports' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.reports.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-chart-pie fa-fw w-5 mr-3 text-center"></i>
                            <span>Reports</span>
                        </a>
                        <a href="{{ route('admin.founder.management-fee.index') }}" @click.stop :title="!sidebarOpen ? 'Management Fee' : ''" class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.management-fee.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-file-invoice-dollar fa-fw w-5 mr-3 text-center"></i>
                            <span>Management Fee</span>
                        </a>
                    </div>
                </div>
                
                {{-- 7. LINK UTAMA: Users (Founder Only) --}}
                <a href="{{ route('admin.founder.users.index') }}" 
                   class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.users.*') ? 'bg-slate-700 text-white' : 'hover:bg-slate-700/50 hover:text-white' }}" 
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   :title="!sidebarOpen ? 'Users' : ''">
                    <i class="fa-solid fa-users fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Users</span>
                </a>
            @endrole

        </nav>
    </div>

    {{-- Resize Handle --}}
    <div @mousedown="isResizing = true" 
         class="absolute top-0 right-0 w-2 h-full cursor-col-resize"
         x-show="sidebarOpen">
    </div>
</div>

