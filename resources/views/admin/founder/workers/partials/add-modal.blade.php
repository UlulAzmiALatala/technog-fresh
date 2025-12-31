{{-- Lokasi: resources/views/admin/founder/workers/partials/add-modal.blade.php --}}
<div x-show="isAddModalOpen" x-cloak 
     class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/60 backdrop-blur-[30px]"
     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0">
    
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl rounded-[2rem] shadow-2xl border border-white/20 overflow-hidden my-8" @click.away="isAddModalOpen = false">
            <div class="p-8 border-b border-slate-100 dark:border-slate-700 font-normal">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-normal">Register New Worker</h3>
            </div>

            <form action="{{ route('admin.founder.workers.store') }}" method="POST" class="p-8 space-y-6 font-normal">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-normal">Full Name</label>
                        <input type="text" name="name" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal">
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-normal">Email Address</label>
                        <input type="email" name="email" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal">
                    </div>
                </div>

                <div class="p-6 bg-slate-50 dark:bg-slate-900/50 rounded-[1.5rem] border border-slate-100 dark:border-slate-800 space-y-6">
                    <p class="text-[10px] text-indigo-500 uppercase tracking-widest font-normal">Banking Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-normal">Bank Name</label>
                            <input type="text" name="bank_name" required placeholder="e.g. BCA, PayPal" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal">
                        </div>
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-normal">Account Number</label>
                            <input type="text" name="bank_account_number" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-normal">Account Holder Name</label>
                        <input type="text" name="bank_account_name" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 font-normal">
                    </div>
                </div>

                <div class="flex space-x-4 pt-4">
                    <button type="button" @click="isAddModalOpen = false" class="flex-1 py-3 bg-slate-100 text-slate-500 rounded-xl font-normal transition-none">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl shadow-lg font-normal transition-none">Save Personnel</button>
                </div>
            </form>
        </div>
    </div>
</div>