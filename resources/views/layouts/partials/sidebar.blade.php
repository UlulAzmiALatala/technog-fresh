{{-- Lokasi: resources/views/layouts/partials/sidebar.blade.php --}}
<div :style="`width: ${sidebarWidth}px`" 
     class="fixed inset-y-0 left-0 bg-slate-900 text-white flex flex-col z-30 shadow-2xl transition-all"
     :class="{ '-translate-x-full': !sidebarOpen, 'transition-all duration-300 ease-in-out': isLoaded }">
    
    <div class="flex-grow flex flex-col overflow-hidden">
        {{-- AREA LOGO (DIPERTAHANKAN SESUAI INSTRUKSI) --}}
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-800 relative flex-shrink-0 bg-slate-900 sticky top-0 z-10">
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

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-hide pb-20">

            {{-- SECTION: REVENUE --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-6 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Main Revenue
                </div>
                {{-- Orders --}}
                <a href="{{ route('admin.pemasukan.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                   {{ request()->routeIs('admin.pemasukan.orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   title="Orders">
                    <i class="fa-solid fa-receipt fa-fw w-5 text-center"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Orders</span>
                </a>
            @endhasanyrole

            {{-- SECTION: FINANCE (Operational & Project Expenses) --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-8 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Finance & Costs
                </div>
                {{-- Operational Expenses --}}
                <a href="{{ route('admin.pengeluaran.expenses.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                   {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   title="Expenses">
                    <i class="fa-solid fa-wallet fa-fw w-5 text-center"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Expenses</span>
                </a>

                {{-- Project Expenses (MENU BARU) --}}
                <a href="{{ route('admin.pengeluaran.project-expenses.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                   {{ request()->routeIs('admin.pengeluaran.project-expenses.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   title="Project Expenses">
                    <i class="fa-solid fa-diagram-project fa-fw w-5 text-center"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Project Expenses</span>
                </a>
            @endhasanyrole

            {{-- SECTION: CATALOG --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-8 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Service Catalog
                </div>
                @php $catalogActive = request()->routeIs(['admin.pemasukan.services.*', 'admin.pemasukan.discounts.*']); @endphp
                <div x-data="{ open: {{ $catalogActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                            {{ $catalogActive ? 'text-white bg-slate-800' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-tags fa-fw w-5 text-center {{ $catalogActive ? 'text-indigo-400' : '' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Catalog</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-200" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" class="mt-1 space-y-1">
                        <a href="{{ route('admin.pemasukan.services.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.pemasukan.services.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">
                            Services
                        </a>
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">
                            Discounts
                        </a>
                    </div>
                </div>
            @endhasanyrole

            {{-- SECTION: CONTENT --}}
            @hasanyrole('Founder|Konten|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-8 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Digital Assets
                </div>
                @php $contentActive = request()->routeIs(['admin.founder.posts.*', 'admin.founder.case-studies.*', 'admin.testimonials.*']); @endphp
                <div x-data="{ open: {{ $contentActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                            {{ $contentActive ? 'text-white bg-slate-800' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-pen-to-square fa-fw w-5 text-center {{ $contentActive ? 'text-indigo-400' : '' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Content</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-200" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-1 space-y-1">
                        @hasanyrole('Founder|Konten')
                        <a href="{{ route('admin.founder.posts.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.posts.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Blog</a>
                        <a href="{{ route('admin.founder.case-studies.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.case-studies.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Portfolio</a>
                        @endhasanyrole
                        <a href="{{ route('admin.testimonials.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.testimonials.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Testimonials</a>
                    </div>
                </div>
            @endhasanyrole

            {{-- SECTION: SETTINGS (FOUNDER ONLY) --}}
            @role('Founder')
                <div class="px-4 mt-8 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Configurations
                </div>
                {{-- Dropdown Settings --}}
                @php $settingsActive = request()->routeIs('admin.founder.settings.*'); @endphp
                <div x-data="{ open: {{ $settingsActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                            {{ $settingsActive ? 'text-white bg-slate-800' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-sliders fa-fw w-5 text-center {{ $settingsActive ? 'text-indigo-400' : '' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Settings</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-200" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-1 space-y-1">
                        <a href="{{ route('admin.founder.settings.contact.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.settings.contact.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Contact Info</a>
                        <a href="{{ route('admin.founder.settings.social-links.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.settings.social-links.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Social Links</a>
                        <a href="{{ route('admin.founder.settings.logos.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.settings.logos.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Logos</a>
                    </div>
                </div>

                {{-- SECTION: ADMINISTRATION --}}
                <div class="px-4 mt-8 mb-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]" x-show="sidebarOpen">
                    Administration
                </div>
                @php $adminActive = request()->routeIs(['admin.founder.reports.*', 'admin.founder.management-fee.*']); @endphp
                <div x-data="{ open: {{ $adminActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                            {{ $adminActive ? 'text-white bg-slate-800' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-shield-halved fa-fw w-5 text-center {{ $adminActive ? 'text-indigo-400' : '' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Backoffice</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-200" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-1 space-y-1">
                        <a href="{{ route('admin.founder.reports.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.reports.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Reports</a>
                        <a href="{{ route('admin.founder.management-fee.index') }}" class="flex items-center pl-12 py-2 text-xs font-bold rounded-lg {{ request()->routeIs('admin.founder.management-fee.*') ? 'text-indigo-400' : 'text-slate-500 hover:text-white hover:bg-slate-800' }}">Management Fee</a>
                    </div>
                </div>

                {{-- Users --}}
                <a href="{{ route('admin.founder.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                   {{ request()->routeIs('admin.founder.users.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                   title="Users">
                    <i class="fa-solid fa-users-gear fa-fw w-5 text-center"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">User Data</span>
                </a>

                <a href="{{ route('admin.founder.workers.index') }}" 
                    class="flex items-center gap-3 px-4 py-2.5 mx-1 rounded-xl text-sm font-bold transition-all duration-200 
                    {{ request()->routeIs('admin.founder.workers.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <i class="fa-solid fa-user-tie fa-fw w-5 text-center"></i>
                    <span x-show="sidebarOpen">Worker Database</span>
                </a>
            @endrole

        </nav>
    </div>

    {{-- BOTTOM AREA: LOGOUT (Meniru gaya React Sidebar) --}}
    <div class="p-4 border-t border-slate-800 bg-slate-900 sticky bottom-0 z-20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-400 hover:bg-red-500/10 hover:text-red-500 transition-all duration-200 font-bold group"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                <i class="fa-solid fa-right-from-bracket w-5 text-center group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-sm" x-show="sidebarOpen">Sign Out</span>
            </button>
        </form>
    </div>

    {{-- Resize Handle --}}
    <div @mousedown="isResizing = true" 
         class="absolute top-0 right-0 w-1.5 h-full cursor-col-resize hover:bg-indigo-500/50 transition-colors"
         x-show="sidebarOpen">
    </div>
</div>