<div :style="`width: ${sidebarWidth}px`" class="fixed inset-y-0 left-0 bg-slate-800 text-white flex flex-col z-30 transition-all duration-300">
    
    <div class="flex-grow flex flex-col overflow-hidden">
        <!-- App Logo -->
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-700 relative flex-shrink-0">
            <a href="{{ route('admin.pemasukan.orders.index') }}" 
               class="transition-opacity duration-300 whitespace-nowrap flex justify-center w-full">
                <img src="{{ asset('images/Logo-Icon-Color.png') }}" 
                     alt="TechnoG Solutions" 
                     class="h-16 w-auto transition-transform duration-300 hover:scale-105">
            </a>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
            
            {{-- OPERATIONAL GROUP --}}
            @role('Founder')
                <div x-data="{ open: {{ request()->routeIs(['admin.founder.dashboard', 'admin.pemasukan.orders.*', 'admin.founder.reports.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarWidth > 80 ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-briefcase fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Operational</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open, 'hidden': sidebarWidth <= 80}"></i>
                    </button>
                    <div x-show="open && sidebarWidth > 80" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.pemasukan.orders.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.orders.*') ? 'text-white bg-slate-700' : '' }}">Orders</a>
                        <a href="{{ route('admin.founder.reports.index') }}" @click.stop class="block px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.reports.*') ? 'text-white bg-slate-700' : '' }}">Reports</a>
                    </div>
                </div>
            @endrole

            {{-- ORDERS MENU (FINANCE ONLY) --}}
            @role('Pemasukan dan Pengeluaran')
                 <a href="{{ route('admin.pemasukan.orders.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.pemasukan.orders.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-receipt fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Orders</span>
                </a>
            @endrole
            
            {{-- FINANCIAL MANAGEMENT MENU --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <a href="{{ route('admin.pemasukan.services.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.pemasukan.services.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-cube fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Services</span>
                </a>
                <a href="{{ route('admin.pengeluaran.expenses.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-credit-card fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Expenses</span>
                </a>
            @endhasanyrole
            
            {{-- CONTENT MANAGEMENT MENU --}}
            @hasanyrole('Founder|Konten')
                <a href="{{ route('admin.founder.posts.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.posts.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-newspaper fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Blog</span>
                </a>
                <a href="{{ route('admin.founder.case-studies.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.case-studies.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-book-open fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Reviews</span>
                </a>
            @endhasanyrole

            {{-- GENERAL MANAGEMENT MENU (FOUNDER ONLY) --}}
            @role('Founder')
                <a href="{{ route('admin.founder.management-fee.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.management-fee.*') ? 'bg-blue-600 text-white' : '' }}">
                    <i class="fa-solid fa-percent fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Management Fee</span>
                </a>
                 <a href="{{ route('admin.founder.users.index') }}" :class="sidebarWidth > 80 ? 'justify-start' : 'justify-center'" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.founder.users.*') ? 'bg-blue-600 text-white shadow-lg' : '' }}">
                    <i class="fa-solid fa-users fa-fw w-6 text-center"></i>
                    <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" :class="sidebarWidth > 80 ? 'opacity-100' : 'opacity-0'">Users</span>
                </a>
            @endrole
        </nav>
    </div>

    {{-- Resize Handle --}}
    <div @mousedown="isResizing = true" class="absolute top-0 right-0 w-2 h-full cursor-col-resize"></div>
</div>