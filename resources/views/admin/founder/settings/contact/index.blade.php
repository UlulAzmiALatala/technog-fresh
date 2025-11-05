{{-- Lokasi: resources/views/admin/founder/settings/contact/index.blade.php (FILE BARU) --}}

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact & Address Settings') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        {{-- Form utama --}}
        <form action="{{ route('admin.founder.settings.contact.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="bg-white dark:bg-slate-800 shadow-xl sm:rounded-2xl overflow-hidden">
                <div class="p-6 lg:p-8 space-y-6">
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Contact Information</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-slate-400">Update the main contact details for your website.</p>
                    </div>

                    <div class="border-t border-gray-200 dark:border-slate-700"></div>

                    {{-- Baris Email --}}
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" 
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                    </div>

                    {{-- Baris Telepon --}}
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" 
                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                               placeholder="+62 812 3456 7890"
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                    </div>

                    {{-- Baris WhatsApp --}}
                    <div>
                        <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 dark:text-slate-300">WhatsApp Number</label>
                        <input type="text" name="contact_whatsapp" id="contact_whatsapp" 
                               value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '') }}"
                               placeholder="+6281234567890 (use country code, no + or spaces)"
                               class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">
                        <x-input-error :messages="$errors->get('contact_whatsapp')" class="mt-2" />
                    </div>

                    {{-- Baris Alamat --}}
                    <div>
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Company Address</label>
                        <textarea name="contact_address" id="contact_address" rows="4" 
                                  class="block w-full mt-1 border-gray-300 dark:border-slate-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white">{{ old('contact_address', $settings['contact_address'] ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('contact_address')" class="mt-2" />
                    </div>

                </div>

                {{-- Footer Form --}}
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-700/50 flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
