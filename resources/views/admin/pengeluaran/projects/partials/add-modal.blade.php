{{-- Lokasi: resources/views/admin/pengeluaran/projects/partials/add-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isAddModalOpen" x-cloak 
         class="fixed inset-0 z-[999] overflow-y-auto bg-slate-900/60 backdrop-blur-[30px]"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white/95 dark:bg-slate-800/95 w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-white/10 my-8" 
                 @click.away="isAddModalOpen = false">
                
                {{-- Header Modal: Menggunakan BOLD --}}
                <div class="p-8 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">Tambah Pengeluaran Proyek</h3>
                    <button @click="isAddModalOpen = false" class="text-slate-400 transition-none">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>

                {{-- Form: Isi input menggunakan font-normal --}}
                <form action="{{ route('admin.pemasukan.orders.storeWorkerPayout', 0) }}" method="POST" 
                      @submit.prevent="$el.action = $el.action.replace('/0/', '/' + formData.order_id + '/'); $el.submit()"
                      class="p-8 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pilih Proyek --}}
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Pilih ID Order / Proyek</label>
                            <select name="order_id" x-model="formData.order_id" required 
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="">-- Pilih Proyek --</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">Order #{{ $order->id }} ({{ $order->status }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Worker --}}
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Pilih Worker</label>
                            <select name="worker_id" x-model="formData.worker_id" required 
                                    @change="const w = @js($workers).find(i => i.id == $event.target.value); 
                                             formData.bank_display = w ? `${w.bank_name} - ${w.bank_account_number} (a/n ${w.bank_account_name})` : ''"
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="">-- Pilih Nama Worker --</option>
                                @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tampilan Info Bank Otomatis --}}
                    <div x-show="formData.bank_display" x-transition 
                         class="p-4 bg-indigo-50/50 dark:bg-indigo-900/20 border border-indigo-100/50 dark:border-indigo-800/50 rounded-xl">
                        <p class="text-[10px] text-indigo-400 uppercase tracking-widest font-bold">Tujuan Transfer Worker:</p>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-1 font-normal" x-text="formData.bank_display"></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nominal --}}
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Nominal Fee ($)</label>
                            <input type="number" name="amount" step="0.01" x-model="formData.amount" required placeholder="0.00" 
                                   class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                        </div>
                        {{-- Status --}}
                        <div>
                            <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Status Pembayaran</label>
                            <select name="status" x-model="formData.status" required 
                                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none">
                                <option value="Pending">Pending / Belum Bayar</option>
                                <option value="Paid">Sudah Dibayar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi Tugas --}}
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Deskripsi Pekerjaan</label>
                        <textarea name="description" x-model="formData.description" rows="3" placeholder="Contoh: Pembuatan Landing Page" 
                                  class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white py-3 px-4 focus:ring-indigo-500 font-normal outline-none"></textarea>
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button type="button" @click="isAddModalOpen = false" 
                                class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-500 rounded-2xl font-bold transition-none">
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none font-bold transition-none">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>