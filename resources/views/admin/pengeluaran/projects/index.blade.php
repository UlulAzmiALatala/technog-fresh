{{-- Lokasi: resources/views/admin/pengeluaran/projects/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Worker Payouts</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage & track project expenses</p>
            </div>
            <button @click="window.projectManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add Worker Payout
            </button>
        </div>
    </x-slot>

    <div x-data="projectExpenseManager(@js($workers))" class="space-y-8 py-4 font-normal relative">
        
        {{-- CONTROL PANEL --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
            
            <form action="{{ route('admin.pengeluaran.project-expenses.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                <button type="submit" class="px-8 py-3 bg-slate-800 text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all hover:bg-slate-700">Search</button>

                @if(request()->has('search') && request('search') != '')
                    <a href="{{ route('admin.pengeluaran.project-expenses.index') }}" 
                       class="px-6 py-3 bg-slate-100 dark:bg-slate-700/50 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-500 dark:text-slate-300 rounded-2xl font-bold flex items-center justify-center transition-all" title="Clear Filters">
                        <i class="fas fa-undo"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Project ID</th>
                            <th class="p-6 font-bold">Worker Personnel</th>
                            <th class="p-6 font-bold">Details</th>
                            <th class="p-6 text-right font-bold">Fee</th>
                            <th class="p-6 text-center font-bold">Settlement</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse($ordersWithExpenses as $order)
                        @php $payouts = $order->expenses; @endphp
                        <tr x-data="{ 
                                selectedWorkerId: {{ $payouts->first()->id }},
                                payouts_list: @js($payouts),
                                get current() { return this.payouts_list.find(p => p.id == this.selectedWorkerId) }
                            }" class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                            
                            <td class="p-6">
                                <span class="px-4 py-1.5 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-indigo-200/50 dark:border-indigo-800/50">
                                    #{{ $order->id }}
                                </span>
                            </td>

                            <td class="p-6 w-48">
                                <select x-model="selectedWorkerId" class="w-full rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-xs py-2 font-medium focus:ring-2 focus:ring-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                                    @foreach($payouts as $p)
                                        <option value="{{ $p->id }}">{{ $p->worker->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="p-6">
                                <div class="text-[10px] uppercase text-slate-400 tracking-widest font-bold">Description</div>
                                <div class="text-slate-900 dark:text-white font-bold text-sm mt-1 line-clamp-1" x-text="current.description"></div>
                            </td>

                            <td class="p-6 text-right">
                                <div class="text-slate-900 dark:text-white font-black text-lg tracking-tight" x-text="'$ ' + parseFloat(current.amount).toLocaleString(undefined, {minimumFractionDigits: 2})"></div>
                                <span x-text="current.status" :class="current.status == 'Paid' ? 'text-emerald-500' : 'text-amber-500'" class="text-[9px] uppercase tracking-widest font-bold mt-1 block"></span>
                            </td>

                            <td class="p-6 text-center">
                                <button @click="openUploadModal(current)" class="transition-colors h-10 w-10 flex items-center justify-center mx-auto rounded-xl shadow-sm border border-slate-200 dark:border-slate-700" 
                                        :class="current.transfer_proof ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 border-indigo-200 dark:border-indigo-800' : 'bg-white dark:bg-slate-800 text-slate-400 hover:text-indigo-500'">
                                    <i :class="current.transfer_proof ? 'fas fa-check-circle' : 'fas fa-file-upload'"></i>
                                </button>
                            </td>

                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal(current)" 
                                            class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ url('admin/pengeluaran/project-expenses') }}/${current.id}`)" 
                                            class="h-10 w-10 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-24 text-center">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                    <i class="fas fa-wallet text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No project records found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($ordersWithExpenses->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $ordersWithExpenses->links() }}
            </div>
        @endif

        @include('admin.pengeluaran.projects.partials.add-modal', ['orders' => $allOrders])
        @include('admin.pengeluaran.projects.partials.edit-modal', ['orders' => $allOrders])
        @include('admin.pengeluaran.projects.partials.delete-modal')
        @include('admin.pengeluaran.projects.partials.upload-proof-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('projectExpenseManager', (workerData) => ({
                workers: workerData,
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, isUploadModalOpen: false,
                formData: { order_id: '', worker_id: '', amount: '', description: '', status: 'Pending', bank_display: '' },
                editData: { bank_display: '' }, uploadTarget: { worker: {} }, deleteUrl: '',
                init() { window.projectManager = this; },
                openAddModal() { this.formData = { order_id: '', worker_id: '', amount: '', description: '', status: 'Pending', bank_display: '' }; this.isAddModalOpen = true; },
                openEditModal(data) { 
                    const workerInfo = this.workers.find(w => w.id == data.worker_id);
                    this.editData = { ...data, bank_display: workerInfo ? `${workerInfo.bank_name} - ${workerInfo.bank_account_number} (a/n ${workerInfo.bank_account_name})` : '' }; 
                    this.isEditModalOpen = true; 
                },
                openDeleteModal(url) { this.deleteUrl = url; this.isDeleteModalOpen = true; },
                openUploadModal(data) { 
                    const workerInfo = this.workers.find(w => w.id == data.worker_id);
                    this.uploadTarget = { ...data, bank_display: workerInfo ? `${workerInfo.bank_name} - ${workerInfo.bank_account_number} (a/n ${workerInfo.bank_account_name})` : '' }; 
                    this.isUploadModalOpen = true; 
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>