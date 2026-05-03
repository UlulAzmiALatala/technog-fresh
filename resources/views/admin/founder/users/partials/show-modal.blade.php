{{-- Lokasi: resources/views/admin/founder/users/partials/show-modal.blade.php --}}
<template x-teleport="body">
    <div x-show="isShowModalOpen" x-cloak class="fixed inset-0 z-[990] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[30px]" @click="isShowModalOpen = false"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"></div>

        {{-- PERBAIKAN: Menambahkan 'overflow-hidden' di class bawah ini agar background footer tidak bocor --}}
        <div class="relative bg-white/95 dark:bg-slate-800/95 w-full max-w-4xl max-h-[90vh] rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10 flex flex-col"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
             
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center shrink-0">
                <h3 class="text-xl text-slate-900 dark:text-white tracking-tight font-bold uppercase">User Details</h3>
                <button type="button" @click="isShowModalOpen = false" class="text-slate-400 transition-none hover:text-rose-500"><i class="fas fa-times fa-lg"></i></button>
            </div>

            <div class="p-6 overflow-y-auto custom-scrollbar flex-grow">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- Kolom Kiri: Profil Utama --}}
                    <div class="md:col-span-1 flex flex-col items-center text-center">
                        <template x-if="selectedUser.avatarUrl">
                            <img class="h-32 w-32 rounded-3xl object-cover mb-4 shadow-md border border-slate-200 dark:border-slate-700" :src="selectedUser.avatarUrl" alt="Avatar">
                        </template>
                        <template x-if="!selectedUser.avatarUrl">
                            <div class="h-32 w-32 rounded-3xl bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800/50 flex items-center justify-center mb-4 shadow-md">
                                <span class="text-5xl font-black text-indigo-600 dark:text-indigo-400" x-text="selectedUser.name.charAt(0)"></span>
                            </div>
                        </template>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight" x-text="selectedUser.name"></h3>
                        <p class="text-sm font-bold text-slate-400 mt-1" x-text="selectedUser.email"></p>
                        <span class="mt-4 px-4 py-1.5 inline-flex text-[10px] leading-5 font-black uppercase tracking-widest rounded-xl bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800" x-text="selectedUser.roleName"></span>
                        <p class="text-[10px] uppercase font-bold text-slate-400 mt-6 tracking-widest">Joined: <span x-text="selectedUser.formattedDate"></span></p>
                    </div>

                    {{-- Kolom Kanan: Info Detail --}}
                    <div class="md:col-span-2 space-y-6">
                        
                        {{-- Info Perusahaan --}}
                        <div class="bg-slate-50/50 dark:bg-slate-900/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest mb-4 flex items-center"><i class="fas fa-building text-indigo-500 mr-2"></i> Company Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Company Name</span>
                                    <span class="block text-sm font-medium text-slate-800 dark:text-slate-200 mt-1" x-text="selectedUser.company_name || '-'"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Position</span>
                                    <span class="block text-sm font-medium text-slate-800 dark:text-slate-200 mt-1" x-text="selectedUser.position || '-'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Info Identitas --}}
                        <div class="bg-slate-50/50 dark:bg-slate-900/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest mb-4 flex items-center"><i class="fas fa-id-card text-emerald-500 mr-2"></i> Identity Information</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Identity Type</span>
                                    <span class="block text-sm font-medium text-slate-800 dark:text-slate-200 mt-1" x-text="selectedUser.id_card_type || '-'"></span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Identity Number</span>
                                    <span class="block text-sm font-medium text-slate-800 dark:text-slate-200 mt-1" x-text="selectedUser.id_card_number || '-'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Foto Identitas --}}
                        <div class="bg-slate-50/50 dark:bg-slate-900/30 p-6 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest mb-4 flex items-center"><i class="fas fa-camera text-sky-500 mr-2"></i> Identity Document</h4>
                            <template x-if="selectedUser.idCardUrl">
                                <div>
                                    <a :href="selectedUser.idCardUrl" target="_blank" rel="noopener noreferrer" class="block group relative overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 max-w-sm">
                                        <img :src="selectedUser.idCardUrl" alt="Identity Card" class="w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-slate-900/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-external-link-alt text-white text-2xl"></i>
                                        </div>
                                    </a>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-2">Click image to view full size</p>
                                </div>
                            </template>
                            <template x-if="!selectedUser.idCardUrl">
                                <div class="p-6 text-center border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800">
                                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">No identity document uploaded</p>
                                </div>
                            </template>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-slate-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 shrink-0">
                <button type="button" @click="isShowModalOpen = false" class="w-full py-4 bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-bold uppercase tracking-widest transition-none hover:bg-slate-300 dark:hover:bg-slate-600">Close</button>
            </div>
        </div>
    </div>
</template>