{{-- Lokasi: resources/views/layouts/partials/sidebar.blade.php --}}
<div :style="`width: ${sidebarWidth}px`" 
     class="fixed inset-y-0 left-0 bg-[#0B1120] border-r border-slate-800/80 text-slate-400 flex flex-col z-30 shadow-[4px_0_24px_rgba(0,0,0,0.4)] transition-all"
     :class="{ '-translate-x-full': !sidebarOpen, 'transition-all duration-300 ease-in-out': isLoaded }">
    
    <div class="flex-grow flex flex-col overflow-hidden relative">
        
        {{-- Efek Glow Halus di Background Atas --}}
        <div class="absolute top-0 left-0 w-full h-40 bg-indigo-600/5 blur-[50px] pointer-events-none"></div>

        {{-- AREA LOGO --}}
        <div class="flex items-center justify-center h-20 px-4 border-b border-slate-800/60 relative flex-shrink-0 bg-[#0B1120]/80 backdrop-blur-md z-20">
            <a href="{{ url('/') }}" target="_blank"
               class="transition-transform duration-300 hover:scale-105 whitespace-nowrap flex justify-center w-full group relative"
               :title="sidebarOpen ? 'Go to Public Homepage' : 'Homepage'">
                
                <img src="{{ asset('images/Logo-Icon-Color.png') }}" 
                     alt="TechnoG" 
                     x-cloak
                     class="transition-all duration-300 relative z-10"
                     :class="{
                         'h-14 w-auto': sidebarOpen && sidebarWidth > 200,
                         'h-12 w-auto': sidebarOpen && sidebarWidth <= 200,
                         'h-10 w-auto': !sidebarOpen
                     }">
            </a>
        </div>

        {{-- AREA NAVIGASI --}}
        <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto custom-scrollbar pb-6 relative z-10">

            {{-- 1. ANALYTICS & DASHBOARD --}}
            @role('Founder')
                <div class="px-4 mt-2 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Analytics
                </div>
                <a href="{{ route('admin.founder.reports.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group
                   {{ request()->routeIs('admin.founder.reports.*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 shadow-[inset_0_0_20px_rgba(99,102,241,0.05)]' : 'border border-transparent hover:bg-slate-800/50 hover:text-slate-200' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Dashboard & Reports">
                    <i class="fa-solid fa-chart-pie fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ request()->routeIs('admin.founder.reports.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Dashboard & Reports</span>
                </a>
            @endrole

            {{-- 2. SALES & CLIENTS --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Sales & Clients
                </div>
                
                <a href="{{ route('admin.pemasukan.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group
                   {{ request()->routeIs('admin.pemasukan.orders.*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 shadow-[inset_0_0_20px_rgba(99,102,241,0.05)]' : 'border border-transparent hover:bg-slate-800/50 hover:text-slate-200' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Orders">
                    <i class="fa-solid fa-receipt fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ request()->routeIs('admin.pemasukan.orders.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Orders</span>
                </a>

                {{-- MENU BARU: MEETINGS --}}
                <a href="{{ route('admin.pemasukan.meetings.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 mx-1 mt-1 rounded-2xl text-xs font-bold transition-all duration-300 group
                   {{ request()->routeIs('admin.pemasukan.meetings.*') ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 shadow-[inset_0_0_20px_rgba(99,102,241,0.05)]' : 'border border-transparent hover:bg-slate-800/50 hover:text-slate-200' }}"
                   :class="sidebarOpen ? 'justify-start' : 'justify-center'" title="Meetings">
                    <i class="fa-solid fa-calendar-check fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ request()->routeIs('admin.pemasukan.meetings.*') ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                    <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Meetings</span>
                </a>
            @endhasanyrole

            {{-- 3. CATALOG --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Catalog
                </div>
                @php $catalogActive = request()->routeIs(['admin.pemasukan.services.*', 'admin.pemasukan.discounts.*']); @endphp
                <div x-data="{ open: {{ $catalogActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group border border-transparent
                            {{ $catalogActive ? 'text-indigo-400 bg-slate-800/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-tags fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ $catalogActive ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Service Catalog</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse.duration.300ms class="mt-2 space-y-1">
                        <a href="{{ route('admin.pemasukan.services.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.pemasukan.services.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.pemasukan.services.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Services
                        </a>
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.pemasukan.discounts.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Discounts
                        </a>
                    </div>
                </div>
            @endhasanyrole

            {{-- 4. FINANCE & ACCOUNTING (DIJADIKAN DROPDOWN AGAR RAPI) --}}
            @hasanyrole('Founder|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Finance & Accounting
                </div>
                @php $financeActive = request()->routeIs(['admin.pengeluaran.*', 'admin.founder.management-fee.*']); @endphp
                <div x-data="{ open: {{ $financeActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group border border-transparent
                            {{ $financeActive ? 'text-indigo-400 bg-slate-800/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-wallet fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ $financeActive ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Financials</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse.duration.300ms class="mt-2 space-y-1">
                        <a href="{{ route('admin.pengeluaran.expenses.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.pengeluaran.expenses.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Operational Expenses
                        </a>
                        <a href="{{ route('admin.pengeluaran.project-expenses.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.pengeluaran.project-expenses.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.pengeluaran.project-expenses.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Project Expenses
                        </a>
                        @role('Founder')
                        <a href="{{ route('admin.founder.management-fee.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.management-fee.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.management-fee.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Management Fee
                        </a>
                        @endrole
                    </div>
                </div>
            @endhasanyrole

            {{-- 5. DIGITAL ASSETS --}}
            @hasanyrole('Founder|Konten|Pemasukan dan Pengeluaran')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Digital Assets
                </div>
                @php $contentActive = request()->routeIs(['admin.founder.posts.*', 'admin.founder.case-studies.*', 'admin.testimonials.*']); @endphp
                <div x-data="{ open: {{ $contentActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group border border-transparent
                            {{ $contentActive ? 'text-indigo-400 bg-slate-800/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-pen-to-square fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ $contentActive ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Content</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse.duration.300ms class="mt-2 space-y-1">
                        @hasanyrole('Founder|Konten')
                        <a href="{{ route('admin.founder.posts.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.posts.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.posts.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Blog
                        </a>
                        <a href="{{ route('admin.founder.case-studies.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.case-studies.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.case-studies.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Portfolio
                        </a>
                        @endhasanyrole
                        <a href="{{ route('admin.testimonials.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.testimonials.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.testimonials.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Testimonials
                        </a>
                    </div>
                </div>
            @endhasanyrole

            {{-- 6. TEAM MANAGEMENT (DIJADIKAN DROPDOWN AGAR RAPI) --}}
            @role('Founder')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    Human Resources
                </div>
                @php $teamActive = request()->routeIs(['admin.founder.users.*', 'admin.founder.workers.*']); @endphp
                <div x-data="{ open: {{ $teamActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group border border-transparent
                            {{ $teamActive ? 'text-indigo-400 bg-slate-800/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-users-gear fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ $teamActive ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Team Management</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse.duration.300ms class="mt-2 space-y-1">
                        <a href="{{ route('admin.founder.users.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.users.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.users.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> User Data
                        </a>
                        <a href="{{ route('admin.founder.workers.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.workers.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.workers.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Worker Database
                        </a>
                    </div>
                </div>
            @endrole

            {{-- 7. SYSTEM SETTINGS --}}
            @role('Founder')
                <div class="px-4 mt-6 mb-3 text-[9px] font-black text-slate-600 uppercase tracking-[0.25em]" x-show="sidebarOpen">
                    System Settings
                </div>
                @php $settingsActive = request()->routeIs('admin.founder.settings.*'); @endphp
                <div x-data="{ open: {{ $settingsActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="flex items-center w-full px-4 py-3 mx-1 rounded-2xl text-xs font-bold transition-all duration-300 group border border-transparent
                            {{ $settingsActive ? 'text-indigo-400 bg-slate-800/40' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}"
                            :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-sliders fa-fw w-5 text-center text-lg transition-transform group-hover:scale-110 {{ $settingsActive ? 'text-indigo-400' : 'text-slate-500' }}"></i>
                            <span class="transition-opacity duration-200 whitespace-nowrap tracking-wide" x-show="sidebarOpen">Configurations</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transform transition-transform duration-300" :class="{'rotate-90': open}" x-show="sidebarOpen"></i>
                    </button>
                    <div x-show="open && sidebarOpen" x-collapse.duration.300ms class="mt-2 space-y-1">
                        <a href="{{ route('admin.founder.settings.contact.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.settings.contact.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.settings.contact.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Contact Info
                        </a>
                        <a href="{{ route('admin.founder.settings.social-links.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.settings.social-links.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.settings.social-links.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Social Links
                        </a>
                        <a href="{{ route('admin.founder.settings.logos.index') }}" class="flex items-center pl-14 py-2.5 text-xs font-bold rounded-xl transition-all duration-200 hover:translate-x-1 {{ request()->routeIs('admin.founder.settings.logos.*') ? 'text-indigo-400 bg-indigo-500/5' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-3 {{ request()->routeIs('admin.founder.settings.logos.*') ? 'bg-indigo-400' : 'bg-slate-600' }}"></span> Logos
                        </a>
                    </div>
                </div>
            @endrole

        </nav>
    </div>

    {{-- BOTTOM AREA: LOGOUT --}}
    <div class="p-4 border-t border-slate-800/60 bg-[#0B1120]/90 backdrop-blur-md sticky bottom-0 z-20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-2xl text-slate-400 hover:bg-rose-500/10 hover:text-rose-500 hover:border-rose-500/20 border border-transparent transition-all duration-300 font-bold group"
                    :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                <i class="fa-solid fa-right-from-bracket w-5 text-center text-lg group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-xs tracking-wide" x-show="sidebarOpen">Sign Out</span>
            </button>
        </form>
    </div>

    {{-- Resize Handle --}}
    <div @mousedown="isResizing = true" 
         class="absolute top-0 right-0 w-1.5 h-full cursor-col-resize hover:bg-indigo-500/50 transition-colors z-50"
         x-show="sidebarOpen">
    </div>

    {{-- Custom Scrollbar Style specifically for Sidebar --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(99, 102, 241, 0.2); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background-color: rgba(99, 102, 241, 0.5); }
    </style>
</div>