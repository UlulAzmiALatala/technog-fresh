{{-- Lokasi: resources/views/admin/profile/edit.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <div class="max-w-4xl mx-auto w-full flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">My Profile</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage your personal account settings</p>
            </div>
        </div>
    </x-slot>

    {{-- PERBAIKAN: Mengurangi py-8 menjadi py-4 dan space-y-8 menjadi space-y-6 --}}
    <div class="py-4 max-w-4xl mx-auto space-y-6 relative font-normal pb-10">
        
        {{-- Aksen Glow --}}
        <div class="absolute top-0 left-0 -mt-10 -ml-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/3 right-0 w-60 h-60 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Kartu Update Profil --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-8 md:p-12 rounded-[2.5rem] border border-white/40 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none relative overflow-hidden">
            @include('admin.profile.partials.update-profile-information-form')
        </div>

        {{-- Kartu Update Password --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-8 md:p-12 rounded-[2.5rem] border border-white/40 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none relative overflow-hidden">
            @include('admin.profile.partials.update-password-form')
        </div>

        {{-- Kartu Delete Account --}}
        <div class="bg-rose-50/50 dark:bg-rose-900/10 backdrop-blur-xl p-8 md:p-12 rounded-[2.5rem] border border-rose-100 dark:border-rose-800/30 shadow-xl shadow-slate-200/20 dark:shadow-none relative overflow-hidden">
            @include('admin.profile.partials.delete-user-form')
        </div>

    </div>
</x-admin-layout>