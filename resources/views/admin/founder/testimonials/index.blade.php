<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Testimonial Management</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage client reviews & ratings</p>
            </div>
            <button @click="window.testimonialManager.openAddModal()" 
                    class="px-6 py-3 bg-[#5046e5] hover:bg-[#4338ca] rounded-2xl text-xs text-white uppercase tracking-widest font-bold transition-all shadow-lg shadow-indigo-500/30">
                <i class="fas fa-plus mr-2"></i> Add Testimonial
            </button>
        </div>
    </x-slot>

    <div x-data="pageManager(@js($users), @js($orders))" class="space-y-8 py-4 font-normal relative">
        
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-slate-700/50 overflow-hidden shadow-xl shadow-slate-200/20 dark:shadow-none">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="p-6 font-bold">Client Info</th>
                            <th class="p-6 font-bold">Project / Order</th>
                            <th class="p-6 font-bold text-center">Rating</th>
                            <th class="p-6 font-bold">Review</th>
                            <th class="p-6 font-bold text-center">Status</th>
                            <th class="p-6 text-center font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                        @forelse ($testimonials as $testimonial)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-300 group">
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold text-sm uppercase">
                                            {{ substr($testimonial->user->name ?? 'C', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-slate-900 dark:text-white font-bold text-sm">{{ $testimonial->user->name ?? 'N/A' }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">{{ $testimonial->user->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="text-slate-900 dark:text-white font-bold text-sm line-clamp-1">{{ $testimonial->order->detailOrders->first()->service->name ?? 'N/A' }}</div>
                                    <div class="text-[10px] text-slate-500 uppercase tracking-widest mt-1 font-bold">
                                        Order ID: <span class="text-indigo-500">#{{ $testimonial->order->id ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="p-6 text-xs text-slate-600 dark:text-slate-400 font-medium italic line-clamp-2 max-w-xs">
                                    "{{ $testimonial->content }}"
                                </td>
                                <td class="p-6 text-center">
                                    @if($testimonial->is_featured)
                                        <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-200/50 dark:border-emerald-800/50 flex items-center justify-center w-max mx-auto">
                                            <i class="fas fa-gem mr-1.5"></i> Featured
                                        </span>
                                    @else
                                        <span class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700/50 flex items-center justify-center w-max mx-auto">
                                            Standard
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex justify-center space-x-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="openEditModal({{ $testimonial->toJson() }})" 
                                                class="h-10 w-10 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-indigo-100 hover:text-indigo-600 rounded-xl transition-colors shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button type="button" @click.prevent="openDeleteModal(`{{ route('admin.testimonials.destroy', $testimonial->id) }}`)" 
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
                                        <i class="fas fa-comment-dots text-3xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">No client testimonials found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($testimonials->hasPages())
            <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-4 rounded-[2rem] border border-white/40 dark:border-slate-700/50 shadow-sm mt-6">
                {{ $testimonials->links() }}
            </div>
        @endif

        @include('admin.founder.testimonials.partials.add-modal')
        @include('admin.founder.testimonials.partials.edit-modal')
        @include('admin.founder.testimonials.partials.delete-modal')
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pageManager', (usersData, ordersData) => ({
                users: usersData,
                orders: ordersData,
                isAddModalOpen: false, isEditModalOpen: false, isDeleteModalOpen: false,
                deleteUrl: '',
                editItem: { id: null, user: { name: '' }, order: { id: null, detail_orders: [] }, rating: 5, content: '', is_featured: false },
                
                getFirstServiceName(order) {
                    if (order && order.detail_orders && order.detail_orders.length > 0 && order.detail_orders[0].service) {
                        return order.detail_orders[0].service.name;
                    }
                    return 'Unknown Service';
                },

                init() {
                    window.testimonialManager = this;
                    const modalForm = '{{ old('modal_form') }}';
                    if (modalForm === 'add') this.isAddModalOpen = true;
                    if (modalForm === 'edit') this.isEditModalOpen = true;

                    this.$watch('isAddModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isEditModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                    this.$watch('isDeleteModalOpen', val => document.body.style.overflow = val ? 'hidden' : '');
                },
                openAddModal() { this.isAddModalOpen = true; },
                openEditModal(item) { this.editItem = { ...item }; this.isEditModalOpen = true; },
                openDeleteModal(url) { this.deleteUrl = url; this.isDeleteModalOpen = true; }
            }));
        });
    </script>
    @endpush
</x-admin-layout>