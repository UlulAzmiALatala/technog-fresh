{{-- (DIPERBAIKI) Menggunakan layout admin yang benar, bukan app-layout --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Live Chat') }}
        </h2>
    </x-slot>

    {{-- Komponen Livewire AdminChat akan dimuat di sini di dalam layout yang benar --}}
    <div class="h-[calc(100vh-15rem)]"> {{-- Memberi tinggi agar chat bisa scroll --}}
        <livewire:admin-chat />
    </div>
</x-admin-layout>

