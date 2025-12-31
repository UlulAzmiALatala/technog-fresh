{{-- Lokasi: resources/views/admin/pengeluaran/operational/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl text-slate-800 dark:text-slate-200 tracking-tight font-bold">Project Financial Ledger</h2>
            <button @click="window.opManager.openAddModal()" 
                    class="px-6 py-3 bg-indigo-600 rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-none">
                <i class="fas fa-plus mr-2"></i> Add New Expense
            </button>
        </div>
    </x-slot>

    {{-- PEMBUNGKUS UTAMA: Pastikan categories dikirim ke function --}}
    <div x-data="expenseManager(@js($categories))" class="space-y-6 py-4 font-normal">
        
        {{-- Search Bar --}}
        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-[2rem] border border-slate-200 dark:border-slate-700">
            <form action="{{ route('admin.pengeluaran.expenses.index') }}" method="GET" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by description..." 
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
                            <th class="p-6 font-bold">Date</th>
                            <th class="p-6 font-bold">Description</th>
                            <th class="p-6 font-bold text-center">Category</th>
                            <th class="p-6 text-right font-bold">Amount</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($expenses as $expense)
                        <tr class="transition-none">
                            <td class="p-6 text-slate-400 text-xs font-normal">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                            </td>
                            <td class="p-6">
                                <div class="text-slate-800 dark:text-white font-normal text-base">{{ $expense->description }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-widest font-normal mt-1">{{ $expense->type }} Payment</div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-500 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="p-6 text-right font-normal text-slate-900 dark:text-white text-lg tracking-tighter">
                                $ {{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button @click="openEditModal(@js($expense))" 
                                            class="h-9 w-9 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl transition-none">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ route('admin.pengeluaran.expenses.destroy', $expense->id) }}`)" 
                                            class="h-9 w-9 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl transition-none">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center text-slate-400 font-normal">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginasi --}}
        <div class="mt-6 font-normal">{{ $expenses->links() }}</div>

        {{-- MODALS: HARUS DI DALAM X-DATA AGAR TELEPORT JALAN --}}
        @include('admin.pengeluaran.operational.partials.add-modal')
        @include('admin.pengeluaran.operational.partials.edit-modal')
        @include('admin.pengeluaran.operational.partials.delete-modal')
        @include('admin.pengeluaran.operational.partials.category-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('expenseManager', (categoryData) => ({
                categories: categoryData,
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false, isCategoryModalOpen: false,
                formData: { expense_date: '', amount: '', category_id: '', type: 'Full', description: '' },
                editData: { id: null }, newCategoryName: '', categoryError: '', deleteUrl: '',
                
                init() { window.opManager = this; },
                
                openAddModal() { 
                    this.formData = { expense_date: new Date().toISOString().split('T')[0], amount: '', category_id: '', type: 'Full', description: '' }; 
                    this.isAddModalOpen = true; 
                },
                openEditModal(expense) { 
                    this.editData = { ...expense, amount: parseFloat(expense.amount).toFixed(2) }; 
                    this.isEditModalOpen = true; 
                },
                openDeleteModal(url) { this.deleteUrl = url; this.isDeleteModalOpen = true; },
                
                async submitCategory() {
                    this.categoryError = '';
                    if (!this.newCategoryName.trim()) return this.categoryError = 'Name required';

                    try {
                        const res = await fetch("{{ route('admin.pengeluaran.expense-categories.storeAjax') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ name: this.newCategoryName })
                        });
                        const data = await res.json();
                        if (data.success) {
                            this.categories.push(data.category);
                            if(this.isAddModalOpen) this.formData.category_id = data.category.id;
                            if(this.isEditModalOpen) this.editData.category_id = data.category.id;
                            this.isCategoryModalOpen = false;
                            this.newCategoryName = '';
                        } else {
                            this.categoryError = data.errors?.name[0] || 'Error';
                        }
                    } catch (e) { this.categoryError = 'Server error'; }
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>