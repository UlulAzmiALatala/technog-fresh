{{-- Lokasi: resources/views/admin/pengeluaran/projects/partials/upload-proof-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isUploadModalOpen" x-cloak 
         class="fixed inset-0 z-[999] overflow-y-auto bg-slate-900/60 backdrop-blur-[30px]"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl border border-white/10 my-8" 
                 @click.away="isUploadModalOpen = false">
                
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <h3 class="text-2xl text-slate-900 dark:text-white tracking-tighter uppercase font-bold">Settlement Proof</h3>
                    <p class="text-slate-400 text-[11px] uppercase tracking-widest mt-2 font-normal" 
                       x-text="`Paying Fee for ${uploadTarget.worker?.name || 'Worker'}`"></p>
                </div>

                <form :action="`{{ route('admin.pengeluaran.project-expenses.index') }}/${uploadTarget.id}/upload-proof`" 
                      method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    {{-- Upload Area --}}
                    <div class="relative group">
                        <input type="file" name="transfer_proof" required 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-6 text-center bg-slate-50/50 dark:bg-slate-900/50 transition-none">
                            <i class="fas fa-image text-slate-300 text-2xl mb-2"></i>
                            <p class="text-[10px] uppercase text-slate-400 tracking-widest font-bold">Select Receipt Image</p>
                            <p class="text-[9px] text-slate-400 mt-1 font-normal">(Max Size: 2MB)</p>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Transfer Note</label>
                        <textarea name="transfer_note" rows="3" placeholder="Sent via BCA to Andi..." 
                                  class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 text-sm focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>

                    {{-- Info Bank Display --}}
                    <div class="p-4 bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100/50 dark:border-indigo-800/50 rounded-xl">
                        <p class="text-[10px] text-indigo-400 uppercase tracking-widest font-bold">Destination Account:</p>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-1 font-normal" 
                           x-text="uploadTarget.bank_display || 'No bank info registered'"></p>
                    </div>

                    <div class="flex space-x-3 pt-2">
                        <button type="button" @click="isUploadModalOpen = false" 
                                class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">Cancel</button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-emerald-600 text-white rounded-2xl shadow-lg shadow-emerald-900/20 font-bold transition-none">Confirm Paid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>