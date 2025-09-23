<div class="grid grid-cols-12 h-full bg-white rounded-lg shadow-lg border border-gray-200 min-h-0" 
     wire:poll.10s.visible="checkForNewConversations">

    {{-- Kolom Kiri: Daftar Percakapan --}}
    <div class="col-span-4 border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-200 flex-shrink-0">
            <h2 class="text-lg font-semibold text-gray-800">Percakapan Masuk</h2>
        </div>
        <div class="flex-grow overflow-y-auto">
            @forelse ($this->conversations as $conversation)
                <div
                    wire:click="selectConversation({{ $conversation->id }})"
                    class="p-4 border-b border-gray-200 cursor-pointer hover:bg-gray-50 {{ optional($this->selectedConversation)->id === $conversation->id ? 'bg-indigo-50 border-l-4 border-indigo-500' : '' }}">
                    <p class="font-semibold text-gray-900">{{ $conversation->user->name }}</p>
                    <p class="text-sm text-gray-500 truncate">{{ $conversation->messages->last()->body ?? 'Belum ada pesan' }}</p>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500">
                    Tidak ada percakapan aktif.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Kolom Kanan: Jendela Chat --}}
    <div class="col-span-8 flex flex-col min-h-0">
        @if ($this->selectedConversation)
            <div class="flex flex-col h-full" wire:poll.2s.visible>
                {{-- Header Chat --}}
                <div class="p-4 border-b border-gray-200 flex items-center justify-between flex-shrink-0">
                    <h3 class="font-semibold text-gray-800">Chat dengan {{ $this->selectedConversation->user->name }}</h3>
                </div>

                {{-- Area Pesan --}}
                <div class="flex-grow p-4 overflow-y-auto"
                     x-data="{
                         scrollToBottom() {
                             if ($el.scrollTop + $el.clientHeight + 100 < $el.scrollHeight) { return; }
                             $el.scrollTop = $el.scrollHeight;
                         }
                     }"
                     x-init="setTimeout(() => scrollToBottom(), 150)"
                     @admin-message-sent.window="$nextTick(() => scrollToBottom())">

                    @foreach ($this->selectedConversation->messages as $message)
                        @php
                            $isAdminMessage = !$message->user->hasRole('Client');
                        @endphp
                        <div class="flex mb-3 {{ $isAdminMessage ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs md:max-w-md">
                                <div class="px-4 py-2 rounded-lg shadow-sm {{ $isAdminMessage ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
                                    <p class="text-sm">{{ $message->body }}</p>
                                </div>
                                <span class="text-xs text-gray-400 mt-1 block {{ $isAdminMessage ? 'text-right' : 'text-left' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Area Input --}}
                <div class="p-4 bg-gray-50 border-t border-gray-200 flex-shrink-0">
                    <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                        <input
                            wire:model.defer="newMessage"
                            wire:keydown.enter="sendMessage"
                            type="text"
                            placeholder="Ketik balasan Anda..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm h-10"
                            autocomplete="off">
                        <button type="submit" class="bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition w-10 h-10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="flex items-center justify-center h-full text-gray-500">
                <div class="text-center">
                    <i class="fa-regular fa-comments fa-4x mb-4"></i>
                    <p>Pilih percakapan untuk memulai.</p>
                </div>
            </div>
        @endif
    </div>
</div>