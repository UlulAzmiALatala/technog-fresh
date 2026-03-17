{{-- Lokasi: resources/views/admin/pemasukan/discounts/index.blade.php --}}

<x-admin-layout>
    {{-- Wrapper utama Alpine.js dipindah ke sini agar bisa menangkap event dari header --}}
    <div x-data="discountManager()" @open-add-modal.window="isAddModalOpen = true" class="relative">
        
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Discount Management</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage promotional codes and vouchers</p>
                </div>
                {{-- Gunakan $dispatch agar aman --}}
                <button @click="$dispatch('open-add-modal')" class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                    <i class="fas fa-plus mr-2"></i> Add Discount
                </button>
            </div>
        </x-slot>

        <div class="space-y-8 py-4 font-normal relative">
            
            {{-- CONTROL PANEL (Search & Filters) --}}
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-6 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <form action="{{ route('admin.pemasukan.discounts.index') }}" method="GET" class="relative z-10 flex flex-col md:flex-row gap-4">
                    
                    {{-- Search Box --}}
                    <div class="flex-1 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search discount code..." 
                               class="w-full pl-11 rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400 uppercase">
                    </div>

                    {{-- Filter Status --}}
                    <div class="md:w-56">
                        <select name="status" onchange="this.form.submit()" 
                                class="w-full rounded-2xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 dark:text-slate-300">
                            <option value="">All Statuses</option>
                            <option value="active" @selected(request('status') == 'active')>Active & Valid</option>
                            <option value="inactive" @selected(request('status') == 'inactive')>Expired / Inactive</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    @if(request()->hasAny(['search', 'status']) && (request('search') != '' || request('status') != ''))
                        <a href="{{ route('admin.pemasukan.discounts.index') }}" 
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
                                <th class="p-6 font-bold">Code</th>
                                <th class="p-6 font-bold text-right">Amount</th>
                                <th class="p-6 font-bold text-center">Status</th>
                                <th class="p-6 font-bold text-center">Stock (Used/Max)</th>
                                <th class="p-6 font-bold">Expires At</th>
                                <th class="p-6 font-bold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                            @forelse ($discounts as $discount)
                                @php
                                    // [PERBAIKAN] Parsing tanggal yang sangat aman menggunakan Carbon
                                    $expiresAt = $discount->expires_at ? \Carbon\Carbon::parse($discount->expires_at) : null;
                                    
                                    $isActive = $discount->is_active && 
                                                (is_null($expiresAt) || $expiresAt->endOfDay()->isFuture()) && 
                                                (is_null($discount->max_uses) || $discount->current_uses < $discount->max_uses);
                                @endphp
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                    <td class="p-6 whitespace-nowrap text-sm font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">{{ $discount->code }}</td>
                                    <td class="p-6 whitespace-nowrap text-right font-black text-slate-900 dark:text-white text-lg tracking-tight">
                                        $ {{ number_format($discount->amount, 2, '.', ',') }}
                                    </td>
                                    <td class="p-6 whitespace-nowrap text-center">
                                        @if ($isActive)
                                            <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                                <i class="fas fa-check-circle mr-1.5"></i> Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-red-200/50 dark:border-red-800/50 flex items-center justify-center w-max mx-auto">
                                                <i class="fas fa-times-circle mr-1.5"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-6 whitespace-nowrap text-center text-sm font-medium">
                                        @if (is_null($discount->max_uses))
                                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-widest">Unlimited</span>
                                        @else
                                            <span class="text-slate-900 dark:text-white font-black">{{ $discount->current_uses }}</span>
                                            <span class="text-slate-400">/ {{ $discount->max_uses }}</span>
                                        @endif
                                    </td>
                                    <td class="p-6 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400 font-medium">
                                        {{ $expiresAt ? $expiresAt->format('d M Y') : 'Never Expires' }}
                                    </td>
                                    <td class="p-6 text-center">
                                        <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                            <button @click="openEditModal(@js($discount))" 
                                                    class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                            <button @click="openDeleteModal('{{ route('admin.pemasukan.discounts.destroy', $discount->id) }}')" 
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
                                            <i class="fas fa-tags text-3xl text-slate-300 dark:text-slate-600"></i>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No discount codes found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- PAGINATION STYLING --}}
            @if ($discounts->hasPages())
                <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                    {{ $discounts->links() }}
                </div>
            @endif
            
            {{-- MODALS --}}
            @include('admin.pemasukan.discounts.partials.add-modal')
            @include('admin.pemasukan.discounts.partials.edit-modal')
            @include('admin.pemasukan.discounts.partials.delete-modal')
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('discountManager', () => ({
                    isAddModalOpen: false,
                    isEditModalOpen: false,
                    isDeleteModalOpen: false,
                    editingDiscount: {},
                    deleteUrl: '',
                    
                    openEditModal(discount) {
                        // Ambil string tanggal (jika ada), potong spasinya kalau formatnya "YYYY-MM-DD HH:MM:SS"
                        let safeDate = null;
                        if (discount.expires_at) {
                            safeDate = discount.expires_at.split('T')[0].split(' ')[0];
                        }
                        
                        this.editingDiscount = { 
                            ...discount,
                            amount: parseFloat(discount.amount).toFixed(2),
                            expires_at: safeDate
                        };
                        this.isEditModalOpen = true;
                    },
                    
                    openDeleteModal(url) { 
                        this.deleteUrl = url; 
                        this.isDeleteModalOpen = true; 
                    },
                    
                    init() {
                        @if ($openEditModalId > 0 && $errors->any())
                            this.editingDiscount = @json(old());
                            this.editingDiscount.id = {{ $openEditModalId }};
                            this.isEditModalOpen = true;
                        @elseif (session('open_add_modal') && $errors->any())
                            this.isAddModalOpen = true;
                        @endif
                    }
                }));
            });
        </script>
    @endpush
</x-admin-layout>