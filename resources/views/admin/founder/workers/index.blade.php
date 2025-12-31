{{-- Lokasi: resources/views/admin/founder/workers/index.blade.php --}}
<x-admin-layout x-data="workerManager">
    <x-slot name="header">
        <div class="flex justify-between items-center font-normal">
            <h2 class="text-2xl text-slate-800 dark:text-slate-200 tracking-tight font-normal">
                Worker Database
            </h2>
            <button @click="openAddModal()" 
                    class="px-6 py-3 bg-indigo-600 rounded-2xl text-xs text-white uppercase tracking-widest font-normal transition-none">
                <i class="fas fa-user-plus mr-2"></i> Register New Worker
            </button>
        </div>
    </x-slot>

    <div class="space-y-8 py-4 font-normal">
        {{-- Stats Card Flat --}}
        <div class="bg-slate-900 rounded-[2rem] p-10 text-white border border-slate-800 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-400 font-normal">Total Registered Personnel</p>
                <p class="text-5xl mt-4 tracking-tighter font-normal text-indigo-400">{{ count($workers) }} <span class="text-xl text-slate-500 tracking-normal ml-2">Talents</span></p>
            </div>
        </div>

        {{-- Worker Table --}}
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-2xl rounded-[2.5rem] border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-widest text-[10px] border-b border-slate-100 dark:border-slate-700">
                            <th class="p-6 font-normal">Worker Name</th>
                            <th class="p-6 font-normal">Contact Info</th>
                            <th class="p-6 font-normal">Bank Details</th>
                            <th class="p-6 text-center font-normal">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($workers as $worker)
                        <tr class="transition-none">
                            <td class="p-6">
                                <div class="text-base text-slate-800 dark:text-white font-normal">{{ $worker->name }}</div>
                                <div class="text-[10px] text-slate-400 uppercase mt-1 tracking-widest font-normal">ID: W-{{ str_pad($worker->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="p-6">
                                <div class="text-slate-600 dark:text-slate-300 font-normal">{{ $worker->email ?? 'No Email' }}</div>
                            </td>
                            <td class="p-6">
                                <div class="text-indigo-600 dark:text-indigo-400 font-normal">{{ $worker->bank_name }}</div>
                                <div class="text-slate-500 text-xs mt-1 font-normal tracking-wide">{{ $worker->bank_account_number }} (a/n {{ $worker->bank_account_name }})</div>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center space-x-2">
                                    <button @click="openEditModal(@js($worker))" 
                                            class="h-9 w-9 flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl transition-none">
                                        <i class="fas fa-user-edit text-xs"></i>
                                    </button>
                                    <button @click="openDeleteModal(`{{ route('admin.founder.workers.destroy', $worker->id) }}`)" 
                                            class="h-9 w-9 flex items-center justify-center bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl transition-none">
                                        <i class="fas fa-user-minus text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    @include('admin.founder.workers.partials.add-modal')
    @include('admin.founder.workers.partials.edit-modal')
    @include('admin.founder.workers.partials.delete-modal')

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('workerManager', () => ({
                isAddModalOpen: false,
                isEditModalOpen: false,
                isDeleteModalOpen: false,
                
                editData: {},
                deleteUrl: '',

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