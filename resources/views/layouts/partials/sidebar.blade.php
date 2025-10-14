<div :style="`width: ${sidebarWidth}px`" 
     class="fixed inset-y-0 left-0 bg-slate-800 text-white flex flex-col z-30 transition-all duration-300 ease-in-out transform"
     :class="{ '-translate-x-full': !sidebarOpen }">
    
    <div class="flex-grow flex flex-col overflow-hidden">
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-700 relative flex-shrink-0">
            <a href="{{ route('admin.pemasukan.orders.index') }}" 
               class="transition-opacity duration-300 whitespace-nowrap flex justify-center w-full">
                <img src="{{ asset('images/Logo-Icon-Color.png') }}" 
                     alt="TechnoG Solutions" 
                     class="transition-all duration-300"
                     :class="sidebarWidth > 200 ? 'h-14 w-auto' : 'h-12 w-auto'">
            </a>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
            
            {{-- LOGIKA BARU: Teks hanya tampil saat sidebarOpen = true --}}

            @role('Founder')
                <div x-data="{ open: {{ request()->routeIs(['admin.founder.dashboard', 'admin.pemasukan.orders.*', 'admin.founder.reports.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarOpen ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-briefcase fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Operational</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.pemasukan.orders.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.orders.*') ? 'text-white bg-slate-700' : '' }}">Orders</a>
                        <a href="{{ route('admin.founder.reports.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.reports.*') ? 'text-white bg-slate-700' : '' }}">Reports</a>
                    </div>
                </div>
            @endrole

            @role('Pemasukan dan Pengeluaran')
                <a href="{{ route('admin.pemasukan.orders.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.pemasukan.orders.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-receipt fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Orders</span>
                </a>
            @endrole
            
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                {{-- New Dropdown for Income --}}
                <div x-data="{ open: {{ request()->routeIs(['admin.pemasukan.services.*', 'admin.pemasukan.discounts.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarOpen ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-arrow-down-a-z fa-fw w-6 text-center"></i>
                            {{-- DIUBAH KE BAHASA INGGRIS --}}
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Income</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        {{-- Services link inside the dropdown --}}
                        <a href="{{ route('admin.pemasukan.services.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.services.*') ? 'text-white bg-slate-700' : '' }}">
                            Services
                        </a>
                        {{-- New Discounts link inside the dropdown --}}
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'text-white bg-slate-700' : '' }}">
                            Discounts
                        </a>
                    </div>
                </div>
                
                {{-- Expenses link remains separate --}}
                <a href="{{ route('admin.pengeluaran.expenses.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-credit-card fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Expenses</span>
                </a>
            @endhasanyrole
            
            @hasanyrole('Founder|Konten')
                <a href="{{ route('admin.founder.posts.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.posts.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-newspaper fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Blog</span>
                </a>
                <a href="{{ route('admin.founder.case-studies.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.case-studies.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-book-open fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Case Studies</span>
                </a>
            @endhasanyrole

            @role('Founder')
                <a href="{{ route('admin.founder.management-fee.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.management-fee.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-percent fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Management Fee</span>
                </a>
                 <a href="{{ route('admin.founder.users.index') }}" class="sidebar-link flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.users.*') ? 'active' : '' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <div class="icon-glow"></div>
                    <i class="fa-solid fa-users fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Users</span>
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