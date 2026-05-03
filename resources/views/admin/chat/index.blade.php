{{-- Lokasi: resources/views/admin/chat/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Live Support Chat</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Real-time client communication</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-xl">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">System Online</span>
            </div>
        </div>
    </x-slot>

    {{-- Perubahan: Hapus fixed height, biarkan konten bernapas --}}
    <div class="w-full pb-10"> 
        <livewire:admin-chat />
    </div>
</x-admin-layout>