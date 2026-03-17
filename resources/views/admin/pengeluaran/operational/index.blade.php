{{-- Lokasi: resources/views/admin/pengeluaran/operational/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Project Financial Ledger</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage & track operational expenses</p>
            </div>
            <button @click="window.opManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add Expense
            </button>
        </div>
    </x-slot>

    {{-- PEMBUNGKUS UTAMA ALPINE --}}
    <div x-data="expenseManager(@js($categories))" class="space-y-8 py-4 font-normal relative">
        
        {{-- CONTROL PANEL (Search & Filters) - Futuristik Glassmorphism --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
            {{-- Aksen Glow --}}
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
            
            <form action="{{ route('admin.pengeluaran.expenses.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                
                {{-- Search Box --}}
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description..." 
                           class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                {{-- Filter Category --}}
                <div class="md:w-56">
                    <select name="category_id" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Type --}}
                <div class="md:w-48">
                    <select name="type" onchange="this.form.submit()" 
                            class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                        <option value="">All Types</option>
                        <option value="Full" @selected(request('type') == 'Full')>Full Payment</option>
                        <option value="DP" @selected(request('type') == 'DP')>Down Payment (DP)</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request()->hasAny(['search', 'category_id', 'type']) && (request('search') != '' || request('category_id') != '' || request('type') != ''))
                    <a href="{{ route('admin.pengeluaran.expenses.index') }}" 
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
                            <th class="p-6 font-bold">Date</th>
                            <th class="p-6 font-bold">Description</th>
                            <th class="p-6 font-bold text-center">Category</th>
                            <th class="p-6 font-bold text-center">Type</th>
                            <th class="p-6 text-right font-bold">Amount</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($expenses as $expense)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                            <td class="p-6 text-slate-500 dark:text-slate-400 text-xs font-medium">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                            </td>
                            <td class="p-6">
                                <div class="text-slate-900 dark:text-white font-bold text-sm">{{ $expense->description }}</div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                    {{ $expense->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            
                            {{-- KOLOM BARU: TYPE BADGE --}}
                            <td class="p-6 text-center">
                                @if($expense->type == 'Full')
                                    <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                        <i class="fas fa-check-circle mr-1.5"></i> Full
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-amber-200/50 dark:border-amber-800/50 flex items-center justify-center w-max mx-auto">
                                        <i class="fas fa-hourglass-half mr-1.5"></i> DP
                                    </span>
                                @endif
                            </td>

                            <td class="p-6 text-right font-black text-slate-900 dark:text-white text-lg tracking-tight">
                                $ {{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEditModal(@js($expense))" 
                                            class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ route('admin.pengeluaran.expenses.destroy', $expense->id) }}`)" 
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
                                    <i class="fas fa-file-invoice-dollar text-3xl text-slate-300 dark:text-slate-600"></i>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No expense records found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION STYLING --}}
        @if ($expenses->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $expenses->links() }}
            </div>
        @endif

        {{-- MODALS --}}
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
                editData: { id: null, type: 'Full' }, // Pastikan ada default property
                newCategoryName: '', categoryError: '', deleteUrl: '',
                
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