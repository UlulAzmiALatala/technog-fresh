{{-- Lokasi: resources/views/admin/founder/settings/contact/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        {{-- KUNCI SEJAJAR: Tambahkan max-w-4xl mx-auto w-full di div ini --}}
        <div class="max-w-4xl mx-auto w-full flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-slate-900 dark:text-white tracking-tight font-black uppercase">Contact Settings</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium tracking-widest mt-1 uppercase">Manage your company's public contact info</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto relative font-normal">
        
        {{-- FORM CARD (Glassmorphism Level 2) --}}
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl p-8 md:p-12 rounded-[2.5rem] border border-white/40 dark:border-slate-700/50 shadow-xl shadow-slate-200/20 dark:shadow-none relative overflow-hidden">
            
            {{-- Aksen Glow di Pojok Kanan Atas --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

            <form action="{{ route('admin.founder.settings.contact.update') }}" method="POST" class="relative z-10 space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Email --}}
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Contact Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                            </div>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" 
                                   class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white"
                                   placeholder="company@example.com">
                        </div>
                        @error('contact_email') <span class="text-xs text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Contact Phone</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone-alt text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                            </div>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" 
                                   class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white"
                                   placeholder="+62 812 3456 7890">
                        </div>
                        @error('contact_phone') <span class="text-xs text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">WhatsApp Number</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fab fa-whatsapp text-emerald-500 text-lg"></i>
                        </div>
                        <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '') }}" 
                               class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white"
                               placeholder="6281234567890 (No + or spaces)">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2 font-medium">Use country code without '+' (e.g., 62 for Indonesia). This will be used for direct wa.me links.</p>
                    @error('contact_whatsapp') <span class="text-xs text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Address --}}
                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-slate-400 mb-2 font-bold">Company Address</label>
                    <div class="relative group">
                        <div class="absolute top-4 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <textarea name="contact_address" rows="4" 
                                  class="w-full pl-11 py-3 rounded-xl border-slate-200 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-900 dark:text-white"
                                  placeholder="Enter your full company address...">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                    </div>
                    @error('contact_address') <span class="text-xs text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                </div>

                {{-- Footer Action --}}
                <div class="flex justify-end pt-6 border-t border-slate-200/50 dark:border-slate-700/50">
                    <button type="submit" class="px-8 py-4 bg-[#5046e5] hover:bg-[#4338ca] text-white rounded-2xl shadow-lg shadow-indigo-500/30 text-xs font-bold uppercase tracking-widest transition-all">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>