<script>
    function postPageManager(initialCategories) {
        return {
            categories: initialCategories,
            openAddCategoryModal: false,
            newCategoryName: '',
            categoryErrorMessage: '',
            addModalCategoryId: @json(old('category_id')) || '', 
            
            editItem: { 
                id: null, 
                title: '', 
                body: '',
                status: '',
                category_id: '',
                image_url: null 
            },
            editImagePreview: null,
            
            deleteAction: '',

            openAddArticleModal() {
                this.addModalCategoryId = @json(old('category_id')) || '';
                this.$dispatch('open-modal', 'add-post-modal');
            },

            openEditArticleModal(item, imageUrl) {
                if (!item) return;
                this.editItem.id = item.id;
                this.editItem.title = item.title;
                this.editItem.body = item.body;
                this.editItem.status = item.status;
                this.editItem.category_id = item.category_id;
                this.editItem.image_url = imageUrl;
                this.editImagePreview = null;
                this.$dispatch('open-modal', 'edit-post-modal');
            },

            openDeleteArticleModal(actionUrl) {
                this.deleteAction = actionUrl;
                this.$dispatch('open-modal', 'delete-post-modal');
            },

            openAddCategoryForm() {
                this.openAddCategoryModal = true;
                this.newCategoryName = '';
                this.categoryErrorMessage = '';
                this.$dispatch('open-modal', 'add-post-category-modal');
            },
            
            async handleStoreCategory() {
                this.categoryErrorMessage = '';
                try {
                    const response = await fetch("{{ route('admin.founder.posts.categories.storeAjax') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ name: this.newCategoryName })
                    });
                    const data = await response.json();
                    if (!response.ok) throw data;

                    if (data.success) {
                        this.categories.push(data.category);
                        this.addModalCategoryId = data.category.id;
                        this.editItem.category_id = data.category.id; 
                        this.$dispatch('close-modal', 'add-post-category-modal');
                    }
                } catch (error) {
                    this.categoryErrorMessage = error.errors?.name?.[0] || 'An error occurred.';
                }
            },
            
            init() {
                const hasAddErrors = @json($errors->any() && session('modal_form') === 'add');
                const hasEditErrors = @json($errors->any() && session('modal_form') === 'edit');
                const hasAddCategoryErrors = @json($errors->any() && session('modal_form') === 'add_category');

                if (hasAddErrors) {
                    this.$dispatch('open-modal', 'add-post-modal');
                }

                if (hasEditErrors) {
                    this.editItem.id = @json(old('id'));
                    this.editItem.title = @json(old('title'));
                    this.editItem.body = @json(old('body'));
                    this.editItem.status = @json(old('status'));
                    this.editItem.category_id = @json(old('category_id'));
                    this.$dispatch('open-modal', 'edit-post-modal');
                }

                if (hasAddCategoryErrors) {
                    this.$dispatch('open-modal', 'add-post-category-modal');
                }
            }
        }
    }
</script>

<div x-data='postPageManager(@json($categories))' x-init="init()">
    <x-admin-layout>

        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Blog Management') }}
                </h2>
                <button @click="openAddArticleModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    + Write New Article
                </button>
            </div>
        </x-slot>

        <div class="mt-4">

            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('admin.founder.posts.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                </div>
                                <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search by article title..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div>
                            <label for="status" class="sr-only">Filter by status</label>
                            <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="PUBLISHED" @selected(request('status') == 'PUBLISHED')>Published</option>
                                <option value="DRAFT" @selected(request('status') == 'DRAFT')>Draft</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($posts as $post)
                                    @php
                                        $imageUrl = $post->image ? asset('storage/' . $post->image) : null;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ $imageUrl ?? 'https://placehold.co/100x100/e2e8f0/cbd5e0?text=No%20Image' }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status == 'PUBLISHED' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $post->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="openEditArticleModal({{ $post->toJson() }}, '{{ $imageUrl }}')" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            
                                            <form class="inline-block ml-2" action="{{ route('admin.founder.posts.destroy', $post->id) }}" method="POST"
                                                  @submit.prevent="openDeleteArticleModal('{{ route('admin.founder.posts.destroy', $post->id) }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No articles have been written yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
            
            @include('admin.founder.posts.partials.add-modal')

            @include('admin.founder.posts.partials.edit-modal')
            
            @include('admin.founder.posts.partials.delete-modal')

            <x-modal name="add-post-category-modal" :show="$errors->any() && session('modal_form') === 'add_category'" focusable>
                <form @submit.prevent="handleStoreCategory()" class="p-6">
                    @csrf
                    <h2 class="text-lg font-medium text-gray-900">Add New Post Category</h2>
                    <div class="mt-4">
                        <x-input-label for="new_category_name_post" value="Category Name" />
                        <x-text-input type="text" x-model="newCategoryName" id="new_category_name_post" class="mt-1 block w-full" required />
                        <p x-show="categoryErrorMessage" x-text="categoryErrorMessage" class="text-sm text-red-600 mt-2"></p>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button type="submit" class="ml-3">
                            {{ __('Save Category') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>
        
    </x-admin-layout>
</div>

