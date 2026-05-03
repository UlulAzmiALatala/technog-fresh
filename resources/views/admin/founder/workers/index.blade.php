{{-- Lokasi: resources/views/admin/founder/workers/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Worker Database</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage project executors & freelancers</p>
            </div>
            <button @click="window.workerManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-user-plus mr-2"></i> Register Worker
            </button>
        </div>
    </x-slot>

    {{-- KUNCI ALPINE: Semua elemen dan modal harus berada DI DALAM div ini --}}
    <div x-data="workerPageManager()" class="space-y-8 py-4 font-normal relative">

        {{-- STATS CARD (Hero Glassmorphism) --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 text-white p-8 rounded-[2rem] shadow-xl shadow-slate-900/20 border border-slate-700">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10 flex justify-between items-center">
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-indigo-400 font-bold mb-2">Total Registered Personnel</p>
                    <p class="text-5xl font-black tracking-tighter">{{ $totalWorkers }} <span class="text-lg text-slate-500 font-medium tracking-widest uppercase ml-2">Talents</span></p>
                </div>
                <div class="h-16 w-16 bg-slate-800 border border-slate-700 rounded-2xl flex items-center justify-center shadow-inner">
                    <i class="fas fa-users-cog text-2xl text-indigo-400"></i>
                </div>
            </div>
        </div>

        {{-- WORKER TABLE (Glassmorphism Level 2) --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none relative">
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Worker Profile</th>
                            <th class="p-6 font-bold">Contact Info</th>
                            <th class="p-6 font-bold">Bank Details</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse($workers as $worker)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-black text-lg uppercase shadow-sm border border-indigo-100 dark:border-indigo-800/50">
                                        {{ substr($worker->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-slate-900 dark:text-white font-black text-sm">{{ $worker->name }}</div>
                                        <div class="text-[9px] text-slate-400 uppercase mt-1 tracking-widest font-bold">ID: W-{{ str_pad($worker->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="inline-flex items-center px-3 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-lg text-xs font-medium border border-slate-200 dark:border-slate-700">
                                    <i class="fas fa-envelope mr-2 text-slate-400"></i> {{ $worker->email ?? 'No Email Provided' }}
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="text-indigo-600 dark:text-indigo-400 font-black text-sm uppercase tracking-wider"><i class="fas fa-university mr-1"></i> {{ $worker->bank_name }}</div>
                                <div class="text-slate-500 dark:text-slate-400 text-xs mt-1 font-bold">{{ $worker->bank_account_number }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest mt-1">A/N: <span class="text-slate-700 dark:text-slate-300 font-bold">{{ $worker->bank_account_name }}</span></div>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal(@js($worker))" 
                                            class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-user-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ route('admin.founder.workers.destroy', $worker->id) }}`)" 
                                            class="h-10 w-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-user-minus text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-24 text-center">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                    <i class="fas fa-user-slash text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No workers registered yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($workers->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $workers->links() }}
            </div>
        @endif

        {{-- PERBAIKAN: MODALS SEKARANG BERADA DI DALAM DIV ALPINE --}}
        @include('admin.founder.workers.partials.add-modal')
        @include('admin.founder.workers.partials.edit-modal')
        @include('admin.founder.workers.partials.delete-modal')

    </div> {{-- AKHIR DARI DIV X-DATA ALPINE --}}

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workerPageManager', () => ({
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, deleteUrl: '',
                editData: { id: null, name: '', email: '', bank_name: '', bank_account_number: '', bank_account_name: '' },

                init() {
                    window.workerManager = this;
                    const modalForm = '{{ old('modal_form') }}';
                    
                    if (modalForm === 'add') {
                        this.isAddModalOpen = true;
                    }
                    if (modalForm === 'edit') {
                        this.editData = @json(old());
                        this.isEditModalOpen = true;
                    }

                    // BODY SCROLL LOCK
                    this.$watch('isAddModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                openAddModal() { this.isAddModalOpen = true; },
                openEditModal(data) { 
                    this.editData = { ...data }; 
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