{{-- Location: resources/views/client/profile.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ activeTab: 'profile' }" class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Left Navigation Column --}}
                <div class="md:col-span-1">
                    {{-- User Avatar --}}
                    <div class="flex flex-col items-center text-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-gray-200 mb-3 flex items-center justify-center overflow-hidden">
                            {{-- Show avatar if it exists, otherwise show initials --}}
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Photo" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl font-bold text-gray-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">Client</p>
                    </div>

                    {{-- Navigation Menu --}}
                    <ul class="space-y-2">
                        <li>
                            <a href="#" @click.prevent="activeTab = 'profile'"
                               class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors duration-200"
                               :class="{ 'bg-indigo-600 text-white shadow': activeTab === 'profile', 'text-gray-600 hover:bg-gray-100': activeTab !== 'profile' }">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                                Profile Information
                            </a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="activeTab = 'password'"
                               class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors duration-200"
                               :class="{ 'bg-indigo-600 text-white shadow': activeTab === 'password', 'text-gray-600 hover:bg-gray-100': activeTab !== 'password' }">
                               <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                Update Password
                            </a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="activeTab = 'delete'"
                               class="flex items-center p-3 rounded-lg text-sm font-medium transition-colors duration-200"
                               :class="{ 'bg-indigo-600 text-white shadow': activeTab === 'delete', 'text-gray-600 hover:bg-gray-100 hover:text-red-600': activeTab !== 'delete' }">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09 1.02-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                Delete Account
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Right Content Column --}}
                <div class="md:col-span-3">
                    <div x-show="activeTab === 'profile'" x-transition class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        @include('client.partials.update-profile-information-form')
                    </div>
                    <div x-show="activeTab === 'password'" x-transition style="display: none;" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        @include('client.partials.update-password-form')
                    </div>
                    <div x-show="activeTab === 'delete'" x-transition style="display: none;" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        @include('client.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.app-footer')
</x-app-layout>