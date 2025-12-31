<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl text-slate-800 dark:text-slate-200 tracking-tight font-bold">Project Financial Ledger</h2>
            {{-- FIX: Panggil via window agar tidak error --}}
            <button @click="window.projectManager.openAddModal()" 
                    class="px-6 py-3 bg-indigo-600 rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-none">
                <i class="fas fa-plus mr-2"></i> Add Worker Payout
            </button>
        </div>
    </x-slot>

    <div x-data="projectExpenseManager(@js($workers))" class="space-y-6 py-4 font-normal">
        
        {{-- Search Bar --}}
        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-700">
            <form action="{{ route('admin.pengeluaran.project-expenses.index') }}" method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Order ID..." 
                       class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-normal focus:ring-indigo-500">
                <button type="submit" class="px-8 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-none">Search</button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                            <th class="p-6 font-bold">Project ID</th>
                            <th class="p-6 font-bold">Worker Personnel</th>
                            <th class="p-6 font-bold">Details</th>
                            <th class="p-6 text-right font-bold">Fee</th>
                            <th class="p-6 text-center font-bold">Settlement</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($ordersWithExpenses as $order)
                        @php $payouts = $order->expenses; @endphp
                        <tr x-data="{ 
                                selectedWorkerId: {{ $payouts->first()->id }},
                                payouts_list: @js($payouts),
                                get current() { return this.payouts_list.find(p => p.id == this.selectedWorkerId) }
                            }" class="transition-none">
                            <td class="p-6 text-indigo-600 font-normal">#{{ $order->id }}</td>
                            <td class="p-6">
                                <select x-model="selectedWorkerId" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs py-2 font-normal focus:ring-indigo-500">
                                    @foreach($payouts as $p)
                                        <option value="{{ $p->id }}">{{ $p->worker->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-6 font-normal">
                                <div class="text-[10px] uppercase text-slate-400 tracking-widest font-bold">Description</div>
                                <div class="text-slate-600 dark:text-slate-300 mt-1 line-clamp-1 text-xs" x-text="current.description"></div>
                            </td>
                            <td class="p-6 text-right font-normal">
                                <div class="text-base text-slate-900 dark:text-white" x-text="'$ ' + parseFloat(current.amount).toLocaleString()"></div>
                                <span x-text="current.status" :class="current.status == 'Paid' ? 'text-emerald-500' : 'text-amber-500'" class="text-[9px] uppercase tracking-widest font-bold"></span>
                            </td>
                            <td class="p-6 text-center">
                                <button @click="openUploadModal(current)" class="transition-none" :class="current.transfer_proof ? 'text-indigo-500' : 'text-slate-300 hover:text-indigo-500'">
                                    <i class="fa-lg" :class="current.transfer_proof ? 'fas fa-check-circle' : 'fas fa-file-upload'"></i>
                                </button>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center space-x-2">
                                    <button @click="openEditModal(current)" class="h-9 w-9 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl transition-none"><i class="fas fa-edit text-xs"></i></button>
                                    <button @click="openDeleteModal(`{{ url('admin/pengeluaran/project-expenses') }}/${current.id}`)" class="h-9 w-9 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl transition-none"><i class="fas fa-trash text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-20 text-center text-slate-400 font-normal">No project records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginasi --}}
        <div class="mt-6 font-normal">{{ $ordersWithExpenses->links() }}</div>

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