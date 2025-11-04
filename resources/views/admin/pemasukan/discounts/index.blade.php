{{-- Lokasi: resources/views/admin/pemasukan/discounts/index.blade.php (Perbaikan Final) --}}

{{-- Kita pasang x-data di sini, yang akan 'diwariskan' ke tag <body> oleh layout --}}
<x-admin-layout x-data="discountManager">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Discount Management') }}
            </h2>
            <button @click="openAddModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Discount
            </button>
        </div>
    </x-slot>

    {{-- Kita tidak butuh div pembungkus x-data lagi di sini --}}
    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        
                        {{-- PERUBAHAN: Menambahkan Kolom Stock --}}
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Stock (Used/Max)</th>
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Expires At</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($discounts as $discount)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-200" id="discount-row-{{ $discount->id }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $discount->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">$ {{ number_format($discount->amount, 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                {{-- PERBAIKAN BUG LOGIKA TANGGAL --}}
                                @if ($discount->is_active && (is_null($discount->expires_at) || $discount->expires_at->endOfDay()->isFuture()) && (is_null($discount->max_uses) || $discount->current_uses < $discount->max_uses))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Expired/Inactive</span>
                                @endif
                            </td>
                            
                            {{-- PERUBAHAN: Menampilkan Data Stock --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                @if (is_null($discount->max_uses))
                                    <span class="text-gray-500 dark:text-slate-400 italic">Unlimited</span>
                                @else
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $discount->current_uses }}</span>
                                    <span class="text-gray-500 dark:text-slate-400">/ {{ $discount->max_uses }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                {{ $discount->expires_at ? $discount->expires_at->format('d M Y') : 'Never' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- PERBAIKAN: Mengganti tanda kutip ganda (") menjadi tunggal (') --}}
                                <button @click='openEditModal(@json($discount))' class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-4 font-medium">Edit</button>
                                <button @click="openDeleteModal('{{ route('admin.pemasukan.discounts.destroy', $discount->id) }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 font-medium">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- PERUBAHAN: Update colspan agar pas --}}
                            <td colspan="6" class="px-6 py-20 whitespace-nowrap text-center text-sm text-gray-500 dark:text-slate-400">
                                <i class="fas fa-tags fa-3x text-gray-300 dark:text-slate-600 mb-3"></i>
                                <p>No discount codes found. Click "Add New Discount" to get started.</p>
                            </td>
                        </tr>
                    @endforelse {{-- <-- INI PERBAIKANNYA (sebelumnya @enddforelse) --}}
                </tbody>
            </table>
        </div>
        
        @if ($discounts->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-slate-700">
                {{ $discounts->links() }}
            </div>
        @endif
    </div>

    @include('admin.pemasukan.discounts.partials.add-modal')
    @include('admin.pemasukan.discounts.partials.edit-modal')
    @include('admin.pemasukan.discounts.partials.delete-modal')

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('discountManager', () => ({
                    isAddModalOpen: false,
                    isEditModalOpen: false,
                    isDeleteModalOpen: false,
                    editingDiscount: {}, // <-- Mulai dengan objek kosong
                    deleteUrl: '',
                    
                    openAddModal() { 
                        this.editingDiscount = {}; // Reset state
                        this.isAddModalOpen = true; 
                    },
                    
                    openEditModal(discount) {
                        this.editingDiscount = { 
                            ...discount,
                            expires_at: discount.expires_at ? new Date(discount.expires_at).toISOString().split('T')[0] : null
                        };
                        this.isEditModalOpen = true;
                    },
                    
                    openDeleteModal(url) { 
                        this.deleteUrl = url; 
                        this.isDeleteModalOpen = true; 
                    },
                    
                    // --- PERBAIKAN BESAR: Logika 'init' yang Cerdas ---
                    init() {
                        // Cek jika ada sinyal 'open_edit_modal' dari controller
                        @if ($openEditModalId > 0 && $errors->any())
                            // Ambil data 'old()' yang dikirim Laravel dan GABUNGKAN dengan ID yang benar
                            this.editingDiscount = @json(old());
                            this.editingDiscount.id = {{ $openEditModalId }}; // <-- INI FIX-NYA
                            this.isEditModalOpen = true;
                        
                        // Cek jika ada sinyal 'open_add_modal' dari controller
                        @elseif (session('open_add_modal') && $errors->any())
                            this.isAddModalOpen = true;
                        @endif
                    }
                }));
            });
        </script>
    @endpush
</x-admin-layout>

