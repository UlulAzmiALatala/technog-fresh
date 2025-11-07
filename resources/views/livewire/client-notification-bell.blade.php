{{-- 
    File ini berisi dropdown notifikasi.
    'wire:poll.10s' adalah kuncinya: Ini akan auto-refresh komponen setiap 10 detik.
--}}
<div x-data="{ open: false }" class="relative" wire:poll.10s>
    <button @click="open = !open" title="Notifications" class="relative z-10 block rounded-full p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
        <i class="fas fa-bell"></i>
        @if($count > 0)
            <span class="absolute top-0 right-0 h-2 w-2 mt-1.5 mr-1.5 bg-red-500 rounded-full"></span>
        @endif
    </button>
    <div x-show="open" @click.away="open = false" x-transition 
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20 border border-gray-200" style="display: none;">
        
        <div class="py-2 px-4 text-sm font-semibold text-gray-700">Notifications ({{ $count }})</div>
        <div class="max-h-64 overflow-y-auto">
            @forelse ($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="flex items-center px-4 py-3 border-t border-gray-100 hover:bg-gray-50">
                    <div class="flex-shrink-0 h-8 w-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                        <i class="{{ $notification->data['icon'] ?? 'fas fa-info-circle' }}"></i>
                    </div>
                    <div class="mx-3">
                        <p class="text-gray-600 text-sm">{{ $notification->data['message'] }}</p>
                        <p class="text-blue-500 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @empty
                <p class="text-center text-gray-500 py-4">No new notifications.</p>
            @endforelse
        </div>
        
        @if($count > 0)
            {{-- Tombol ini sekarang memanggil fungsi 'markAsRead' di komponen Livewire --}}
            <button wire:click="markAsRead" class="block bg-gray-50 text-gray-600 text-center font-bold w-full py-2 hover:bg-gray-100 transition-colors text-xs uppercase">
                Mark all as read
            </button>
        @endif
    </div>
</div>