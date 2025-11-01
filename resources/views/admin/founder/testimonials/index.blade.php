<script>
    function testimonialPageManager(users, orders) {
        return {
            users: users,
            orders: orders,
            
            editItem: { 
                id: null, 
                user: { name: '' }, 
                order: { id: null, detail_orders: [] }, 
                rating: 5, 
                content: '', 
                is_featured: false 
            },
            
            deleteAction: '',

            getFirstServiceName(order) {
                if (order && order.detail_orders && order.detail_orders.length > 0 && order.detail_orders[0].service) {
                    return order.detail_orders[0].service.name;
                }
                return 'N/A';
            },

            openAddTestimonialModal() {
                this.$dispatch('open-modal', 'add-testimonial-modal');
            },

            openEditTestimonialModal(item) {
                if (!item) return;
                this.editItem.id = item.id;
                this.editItem.user = item.user || { name: 'N/A' };
                this.editItem.order = item.order || { id: null, detail_orders: [] };
                this.editItem.rating = item.rating;
                this.editItem.content = item.content;
                this.editItem.is_featured = item.is_featured;
                this.$dispatch('open-modal', 'edit-testimonial-modal');
            },

            openDeleteTestimonialModal(actionUrl) {
                this.deleteAction = actionUrl;
                this.$dispatch('open-modal', 'delete-testimonial-modal');
            },
            
            init() {
                const hasAddErrors = @json($errors->any() && session('modal_form') === 'add');
                const hasEditErrors = @json($errors->any() && session('modal_form') === 'edit');

                if (hasAddErrors) {
                    this.$dispatch('open-modal', 'add-testimonial-modal');
                }

                if (hasEditErrors) {
                    this.editItem.id = @json(old('id'));
                    this.editItem.rating = @json(old('rating'));
                    this.editItem.content = @json(old('content'));
                    this.editItem.is_featured = @json(old('is_featured') == '1');
                    this.editItem.user = { name: 'N/A (Repopulate)' };
                    this.editItem.order = { id: null, detail_orders: [] };
                    this.$dispatch('open-modal', 'edit-testimonial-modal');
                }
            }
        }
    }
</script>

<div x-data='testimonialPageManager(@json($users), @json($orders))' x-init="init()">
    <x-admin-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Testimonial Management') }}
                </h2>
                <button @click="openAddTestimonialModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    + Add Testimonial
                </button>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order (First Service)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Review</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Featured</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($testimonials as $testimonial)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $testimonial->user->name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $testimonial->user->email ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">{{ $testimonial->order->detailOrders->first()->service->name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $testimonial->order->id ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-700 max-w-md">{{ Str::limit($testimonial->content, 100) }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($testimonial->is_featured)
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Featured
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                                        Standard
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button @click="openEditTestimonialModal({{ $testimonial->toJson() }})" class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </button>
                                                
                                                <form class="inline-block ml-2" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                                                      @submit.prevent="openDeleteTestimonialModal('{{ route('admin.testimonials.destroy', $testimonial->id) }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                                No client testimonials found yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $testimonials->links() }}
                        </div>
                    </div>
                </div>

                @include('admin.founder.testimonials.partials.add-modal')
                @include('admin.founder.testimonials.partials.edit-modal')
                @include('admin.founder.testimonials.partials.delete-modal')

            </div>
        </div>
    </x-admin-layout>
</div>

