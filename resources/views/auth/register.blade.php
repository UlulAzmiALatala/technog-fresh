<x-auth>

    {{-- Sets the specific title for this page --}}
    <x-slot name="title">
        Register - {{ config('app.name', 'Laravel') }}
    </x-slot>

    <div x-data="{
        id_card_type: '{{ old('id_card_type', '') }}',
        id_card_number: '{{ old('id_card_number', '') }}',
        id_error: '',
        validateIdNumber() {
            this.id_card_number = this.id_card_number.replace(/\D/g, ''); // Allow numbers only
            if (this.id_card_type === 'KTP') {
                if (this.id_card_number.length > 16) { this.id_card_number = this.id_card_number.slice(0, 16); }
                if (this.id_card_number.length > 0 && this.id_card_number.length < 16) {
                    this.id_error = 'National ID (KTP) must be 16 digits.';
                } else {
                    this.id_error = '';
                }
            } else if (this.id_card_type === 'NPWP') {
                if (this.id_card_number.length > 16) { this.id_card_number = this.id_card_number.slice(0, 16); }
                if (this.id_card_number.length > 0 && this.id_card_number.length < 15) {
                    this.id_error = 'Tax ID (NPWP) must be at least 15 digits.';
                } else {
                    this.id_error = '';
                }
            } else {
                this.id_error = '';
            }
        }
    }" x-init="validateIdNumber()">

        <h2 class="text-3xl font-bold text-center text-white mb-8 form-gradient-text">Create a New Account</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                {{-- Left Column: Account Information --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-white/20 pb-2">Account Information</h3>
                    <div>
                        <x-input-label for="name" value="Full Name" class="text-white/80"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email" class="text-white/80"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div x-data="{ show: false }">
                        <x-input-label for="password" value="Password" class="text-white/80"/>
                        <div class="relative">
                            <input id="password"
                                   class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   :type="show ? 'text' : 'password'"
                                   name="password"
                                   required autocomplete="new-password">
                            <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                <svg x-show="!show" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" style="display: none;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div x-data="{ show: false }">
                        <x-input-label for="password_confirmation" value="Confirm Password" class="text-white/80"/>
                        <div class="relative">
                            <input id="password_confirmation"
                                   class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   :type="show ? 'text' : 'password'"
                                   name="password_confirmation"
                                   required autocomplete="new-password">
                            <div @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-400">
                                <svg x-show="!show" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" style="display: none;" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                {{-- Right Column: Additional Information --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white border-b border-white/20 pb-2">Additional Information (Optional)</h3>
                    <div>
                        <x-input-label for="company_name" value="Company Name" class="text-white/80"/>
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                    </div>
                    <div>
                        <x-input-label for="position" value="Position" class="text-white/80"/>
                        <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" />
                    </div>
                    <div>
                        <x-input-label for="id_card_type" value="ID Type" class="text-white/80"/>
                        <select name="id_card_type" id="id_card_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" x-model="id_card_type" @change="validateIdNumber()">
                            <option value="" @selected(old('id_card_type') == '')>Select Type</option>
                            <option value="KTP" @selected(old('id_card_type') == 'KTP')>National ID (KTP)</option>
                            <option value="Passport" @selected(old('id_card_type') == 'Passport')>Passport</option>
                            <option value="NPWP" @selected(old('id_card_type') == 'NPWP')>Tax ID (NPWP)</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="id_card_number" value="ID Number" class="text-white/80"/>
                        <x-text-input x-model="id_card_number" @input="validateIdNumber()" id="id_card_number" class="block mt-1 w-full" type="text" name="id_card_number" />
                        <div x-show="id_error" class="text-red-400 text-sm mt-2" x-text="id_error" style="display: none;"></div>
                        <x-input-error :messages="$errors->get('id_card_number')" class="mt-2" />
                    </div>
                </div>
                
                <div class="md:col-span-2 mt-4">
                    <div id="recaptcha-container"></div>
                    <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                </div>
                
                <div class="md:col-span-2 mt-2">
                    <x-primary-button class="w-full justify-center text-base py-3">
                        {{ __('Register Now') }}
                    </x-primary-button>
                </div>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-white/70">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-white hover:underline">
                Login
            </a>
        </p>
    </div>
</x-auth>