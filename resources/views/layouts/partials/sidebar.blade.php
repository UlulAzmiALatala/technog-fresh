{{-- 
File ini SEKARANG bergantung pada variabel 'isLoaded' 
yang didefinisikan di 'admin-layout.blade.php' 
--}}
<div :style="`width: ${sidebarWidth}px`" 
     class="fixed inset-y-0 left-0 bg-slate-800 text-white flex flex-col z-30 transform"
     :class="{ 
         '-translate-x-full': !sidebarOpen, 
         'transition-all duration-300 ease-in-out': isLoaded 
     }">
    
    <div class="flex-grow flex flex-col overflow-hidden">
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-700 relative flex-shrink-0">
            <a href="{{ route('admin.pemasukan.orders.index') }}" 
               class="transition-opacity duration-300 whitespace-nowrap flex justify-center w-full">
                <img src="{{ asset('images/Logo-Icon-Color.png') }}" 
                     alt="TechnoG Solutions" 
                     x-cloak
                     class="transition-all duration-300"
                     :class="sidebarWidth > 200 ? 'h-14 w-auto' : 'h-12 w-auto'">
            </a>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">

            {{-- === MENU DIRAPIKAN DAN DIKELOMPOKKAN (VERSI BAHASA INGGRIS) === --}}

            @role('Founder')
                {{-- 1. DROPDOWN OPERATIONAL --}}
                <div x-data="{ open: {{ request()->routeIs(['admin.pemasukan.orders.*', 'admin.founder.reports.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarOpen ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-briefcase fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Operational</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.pemasukan.orders.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.orders.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-receipt fa-fw w-5 mr-3 text-center"></i>
                            <span>Orders</span>
                        </a>
                        <a href="{{ route('admin.founder.reports.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.reports.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-chart-pie fa-fw w-5 mr-3 text-center"></i>
                            <span>Reports</span>
                        </a>
                    </div>
                </div>
            @endrole

            @role('Pemasukan dan Pengeluaran')
                {{-- Jika rolenya HANYA Pemasukan, tampilkan Orders sbg link utama --}}
                <a href="{{ route('admin.pemasukan.orders.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.pemasukan.orders.*') ? 'bg-slate-700 text-white' : 'hover:bg-slate-700/50 hover:text-white' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                    <i class="fa-solid fa-receipt fa-fw w-6 text-center relative z-10"></i>
                    <span class="ml-4 font-medium transition-all duration-300 whitespace-nowrap relative z-10" x-show="sidebarOpen">Orders</span>
                </a>
            @endrole
            
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                {{-- 2. DROPDOWN KEUANGAN (BARU) --}}
                <div x-data="{ open: {{ request()->routeIs(['admin.pemasukan.*', 'admin.pengeluaran.*', 'admin.founder.management-fee.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarOpen ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-coins fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Finance</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        <a href="{{ route('admin.pemasukan.services.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.services.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-layer-group fa-fw w-5 mr-3 text-center"></i>
                            <span>Services (Income)</span>
                        </a>
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-percent fa-fw w-5 mr-3 text-center"></i>
                            <span>Discounts (Income)</span>
                        </a>
                        <a href="{{ route('admin.pengeluaran.expenses.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-arrow-right-from-bracket fa-fw w-5 mr-3 text-center"></i>
                            <span>Expenses</span>
                        </a>
                        @role('Founder')
                        <a href="{{ route('admin.founder.management-fee.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.management-fee.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-shield-halved fa-fw w-5 mr-3 text-center"></i>
                            <span>Management Fee</span>
                        </a>
                        @endrole
                    </div>
                </div>
            @endhasanyrole
            
            <!-- === PERBAIKAN LOGIKA ROLE DIMULAI DI SINI === -->
            @hasanyrole('Founder|Konten|Pemasukan dan Pengeluaran')
                {{-- 3. DROPDOWN KONTEN (BARU) --}}
                <!-- Logika open diperbarui untuk menyertakan rute 'admin.testimonials.*' -->
                <div x-data="{ open: {{ request()->routeIs(['admin.founder.posts.*', 'admin.founder.case-studies.*', 'admin.testimonials.*']) ? 'true' : 'false' }} }">
                    <button @click="open = !open" :class="sidebarOpen ? 'justify-between' : 'justify-center'" class="flex items-center w-full px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-pen-to-square fa-fw w-6 text-center"></i>
                            <span class="ml-4 font-medium transition-opacity duration-200 whitespace-nowrap" x-show="sidebarOpen">Content</span>
                        </div>
                        <i class="fa-solid fa-chevron-down h-5 w-5 transform transition-transform duration-200" :class="{'rotate-180': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-2 pl-8">
                        
                        <!-- Blog & Portfolio hanya untuk Founder & Konten -->
                        @hasanyrole('Founder|Konten')
                            <a href="{{ route('admin.founder.posts.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.posts.*') ? 'text-white bg-slate-700' : '' }}">
                                <i class="fa-solid fa-pen-ruler fa-fw w-5 mr-3 text-center"></i>
                                <span>Blog</span>
                            </a>
                            <a href="{{ route('admin.founder.case-studies.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.founder.case-studies.*') ? 'text-white bg-slate-700' : '' }}">
                                <i class="fa-solid fa-image-portrait fa-fw w-5 mr-3 text-center"></i>
                                <span>Portfolio</span>
                            </a>
                        @endhasanyrole

                        <!-- Testimonials untuk Founder, Konten, DAN Pemasukan -->
                        <!-- === PERBAIKAN NAMA RUTE DI SINI === -->
                        <a href="{{ route('admin.testimonials.index') }}" @click.stop class="flex items-center px-4 py-2 text-sm rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white {{ request()->routeIs('admin.testimonials.*') ? 'text-white bg-slate-700' : '' }}">
                            <i class="fa-solid fa-comment-dots fa-fw w-5 mr-3 text-center"></i>
                            <span>Testimonials</span>
                        </a>
                    </div>
                </div>
            @endhasanyrole
            <!-- === PERBAIKAN LOGIKA ROLE SELESAI === -->

            @role('Founder')
                {{-- 4. LINK ADMIN (SENDIRI) --}}
                <a href="{{ route('admin.founder.users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-slate-300 {{ request()->routeIs('admin.founder.users.*') ? 'bg-slate-700 text-white' : 'hover:bg-slate-700/50 hover:text-white' }}" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
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
