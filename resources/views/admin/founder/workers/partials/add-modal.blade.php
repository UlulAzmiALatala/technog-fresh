{{-- Lokasi: resources/views/admin/founder/workers/partials/add-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isAddModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl max-h-[90vh] rounded-[2.5rem] shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Register New Worker</h3>
                <button type="button" @click="isAddModalOpen = false" class="text-slate-400 transition-none hover:text-rose-500"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <form action="{{ route('admin.founder.workers.store') }}" method="POST" class="p-6 overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" name="modal_form" value="add">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-6 bg-slate-50/50 dark:bg-slate-900/30 rounded-[1.5rem] border border-slate-100 dark:border-slate-800 space-y-6">
                    <p class="text-[10px] text-indigo-500 uppercase tracking-widest font-black flex items-center"><i class="fas fa-university mr-2"></i> Banking Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" required placeholder="e.g. BCA, Mandiri" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                            @error('bank_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Account Number</label>
                            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                            @error('bank_account_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Account Holder Name</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal outline-none focus:ring-indigo-500">
                        @error('bank_account_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex space-x-4 pt-8">
                    <button type="button" @click="isAddModalOpen = false" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold uppercase tracking-widest transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-4 bg-[#5046e5] text-white rounded-2xl shadow-lg shadow-indigo-500/30 font-bold uppercase tracking-widest transition-none">Save Personnel</button>
                </div>
            </form>
        </div>
    </div>
</template>