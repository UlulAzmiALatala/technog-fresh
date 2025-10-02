<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div x-data="{ animate: false }" x-init="setTimeout(() => animate = true, 100)" class="space-y-8">

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-full"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">New This Month</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $newUsersThisMonth }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-full"><i class="fas fa-user-plus"></i></div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.2s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Clients</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalClients }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-full"><i class="fas fa-user-tie"></i></div>
                </div>
            </div>
            <div class="fade-in-item bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.3s;">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-slate-400">Admins</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalAdmins }}</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center bg-sky-100 dark:bg-sky-900/50 text-sky-600 dark:text-sky-400 rounded-full"><i class="fas fa-user-shield"></i></div>
                </div>
            </div>
        </div>

        {{-- Filter & Tampilan Utama --}}
        <div class="fade-in-item bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 dark:border-slate-700 transition-all duration-700" :class="animate ? 'in-view' : ''" style="transition-delay: 0.4s;">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <form action="{{ route('admin.founder.users.index') }}" method="GET">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-grow">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                                <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by name or email..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                             <select id="role" name="role" class="block w-full md:w-56 rounded-md border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @selected(request('role') == $role->name)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Grid Kartu Pengguna --}}
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($users as $user)
                    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl shadow-md flex flex-col transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <div class="p-6 flex-grow">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if ($user->avatar)
                                            <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center">
                                                <span class="text-2xl font-bold text-gray-600 dark:text-slate-400">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                                
                                {{-- Dropdown Aksi --}}
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-slate-700">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg z-10 border border-slate-200 dark:border-slate-700" style="display:none;">
                                        <a href="{{ route('admin.founder.users.edit', $user->id) }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700">Edit Role</a>
                                        <form action="{{ route('admin.founder.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center text-xs text-gray-500 dark:text-slate-400">
                                @php $role = $user->roles->pluck('name')->first(); @endphp
                                <span @class([
                                    'px-3 py-1 inline-flex leading-5 font-semibold rounded-full text-xs',
                                    'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300' => $role == 'Founder',
                                    'bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300' => $role == 'Konten',
                                    'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' => $role == 'Pemasukan dan Pengeluaran',
                                    'bg-slate-100 text-slate-800 dark:bg-slate-600 dark:text-slate-200' => $role == 'Client',
                                ])>
                                    {{ $role ?? 'N/A' }}
                                </span>
                                <span>Joined: {{ $user->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                        <div class="text-center py-20 px-6">
                            <i class="fas fa-users-slash fa-4x text-gray-300 dark:text-slate-600 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No Users Found</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">No users match your search criteria.</p>
                            <a href="{{ route('admin.founder.users.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-semibold">Reset Filters</a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($users->hasPages())
                <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <style>
        .fade-in-item { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-item.in-view { opacity: 1; transform: translateY(0); }
    </style>
</x-admin-layout>