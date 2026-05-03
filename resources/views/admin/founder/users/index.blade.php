{{-- Lokasi: resources/views/admin/founder/users/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">
            {{ __('User Management') }}
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage roles and client information</p>
    </x-slot>

    <div x-data="userManager()" class="space-y-8 py-4 font-normal relative">

        {{-- STATS CARDS (Glassmorphism) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-white/40 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Total Users</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl"><i class="fas fa-users text-lg"></i></div>
            </div>
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-white/40 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">New This Month</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight mt-1">{{ $newUsersThisMonth }}</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-2xl"><i class="fas fa-user-plus text-lg"></i></div>
            </div>
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-white/40 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Total Clients</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight mt-1">{{ $totalClients }}</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-2xl"><i class="fas fa-user-tie text-lg"></i></div>
            </div>
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm border border-white/40 dark:border-slate-700/50 flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Total Admins</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white tracking-tight mt-1">{{ $totalAdmins }}</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 rounded-2xl"><i class="fas fa-user-shield text-lg"></i></div>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
            <form action="{{ route('admin.founder.users.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>
                <div class="md:w-56">
                    <select name="role" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected(request('role') == $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if(request()->hasAny(['search', 'role']) && (request('search') != '' || request('role') != ''))
                    <a href="{{ route('admin.founder.users.index') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters"><i class="fas fa-undo"></i></a>
                @endif
            </form>
        </div>

        {{-- USER GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($users as $user)
                @php 
                    $roleName = $user->roles->pluck('name')->first() ?? 'N/A';
                    $avatarUrl = $user->avatar ? asset('storage/' . $user->avatar) : null;
                    $idCardUrl = $user->id_card_image ? asset('storage/' . $user->id_card_image) : null;
                    $formattedDate = $user->created_at->format('d M Y');
                @endphp
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                    <div class="p-8 flex-grow">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if ($avatarUrl)
                                    <img class="h-16 w-16 rounded-2xl object-cover shadow-sm border border-slate-100 dark:border-slate-700" src="{{ $avatarUrl }}" alt="{{ $user->name }}">
                                @else
                                    <div class="h-16 w-16 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/50 flex items-center justify-center shadow-sm">
                                        <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-black text-slate-900 dark:text-white truncate">{{ $user->name }}</h3>
                                <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 truncate mt-1">{{ $user->email }}</p>
                                <span class="mt-3 inline-flex px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-widest border
                                    {{ $roleName == 'Founder' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 
                                      ($roleName == 'Client' ? 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600' : 'bg-sky-50 text-sky-600 border-sky-200') }}">
                                    {{ $roleName }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Card Footer Actions --}}
                    <div class="border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/30 p-4 flex justify-between items-center">
                        <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 ml-4">Joined {{ $formattedDate }}</span>
                        <div class="flex space-x-2">
                            {{-- Action: Show Detail --}}
                            <button @click="openShowModal({{ $user->toJson() }}, '{{ $roleName }}', '{{ $avatarUrl }}', '{{ $idCardUrl }}', '{{ $formattedDate }}')" 
                                    class="h-9 w-9 flex items-center justify-center bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:text-indigo-600 hover:border-indigo-300 rounded-xl transition-colors shadow-sm" title="View Details">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                            {{-- Action: Edit Role --}}
                            <button @click="openEditModal({{ $user->toJson() }}, '{{ $roleName }}', '{{ $avatarUrl }}')" 
                                    class="h-9 w-9 flex items-center justify-center bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:text-indigo-600 hover:border-indigo-300 rounded-xl transition-colors shadow-sm" title="Edit Role">
                                <i class="fas fa-user-shield text-xs"></i>
                            </button>
                            {{-- Action: Delete --}}
                            <button @click.prevent="openDeleteModal(`{{ route('admin.founder.users.destroy', $user->id) }}`)" 
                                    class="h-9 w-9 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 border border-red-100 dark:border-red-800/50 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm" title="Delete User">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl rounded-[2.5rem] border border-white/40 dark:border-slate-700/50 shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                        <i class="fas fa-users-slash text-3xl text-slate-300 dark:text-slate-600"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">No Users Found</h3>
                    <p class="mt-1 text-xs font-bold text-slate-400 uppercase tracking-widest">No users match your criteria.</p>
                </div>
            @endforelse
        </div>

        @if ($users->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $users->links() }}
            </div>
        @endif

        {{-- Modals --}}
        @include('admin.founder.users.partials.show-modal')
        @include('admin.founder.users.partials.edit-modal')
        @include('admin.founder.users.partials.delete-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('userManager', () => ({
                isShowModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, deleteUrl: '',
                
                selectedUser: { name: '', email: '', roleName: '', avatarUrl: null, idCardUrl: null, formattedDate: '', company_name: '', position: '', id_card_type: '', id_card_number: '' },
                editingUser: { id: null, name: '', email: '', roleName: '', avatarUrl: null },

                init() {
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'edit') {
                        // Jika validasi gagal, tangkap old data untuk edit
                        this.editingUser = { 
                            id: '{{ old('id') }}', name: 'User', email: '', roleName: '{{ old('role') }}', avatarUrl: null 
                        };
                        this.isEditModalOpen = true;
                    }

                    // BODY SCROLL LOCK
                    this.$watch('isShowModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                
                openShowModal(user, roleName, avatarUrl, idCardUrl, formattedDate) {
                    this.selectedUser = { ...user, roleName, avatarUrl, idCardUrl, formattedDate };
                    this.isShowModalOpen = true;
                },
                
                openEditModal(user, roleName, avatarUrl) {
                    this.editingUser = { ...user, roleName, avatarUrl };
                    this.isEditModalOpen = true;
                },
                
                openDeleteModal(url) {
                    this.deleteUrl = url;
                    this.isDeleteModalOpen = true;
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>