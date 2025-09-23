<div class="flex flex-col h-full" wire:poll.5s.visible>

    {{-- Container untuk pesan-pesan, dengan auto-scroll --}}
    <div class="flex-1 p-4 space-y-4 overflow-y-auto"
         x-data="{
             scrollToBottom() {
                 // Hanya scroll jika user sudah berada di paling bawah
                 if ($el.scrollTop + $el.clientHeight + 100 < $el.scrollHeight) {
                     return;
                 }
                 $el.scrollTop = $el.scrollHeight;
             }
         }"
         x-init="
            // Untuk load pertama kali
            setTimeout(() => scrollToBottom(), 150);
         "
         @message-sent.window="$nextTick(() => scrollToBottom())">

        @forelse ($this->messages as $message)
            <div class="flex {{ $message->user_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[80%]">
                    <div class="px-4 py-2 rounded-lg shadow-sm {{ $message->user_id === Auth::id() ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-800 rounded-bl-none' }}">
                        <p class="text-sm">{{ $message->body }}</p>
                    </div>
                    <span class="text-xs text-gray-400 mt-1 block {{ $message->user_id === Auth::id() ? 'text-right' : 'text-left' }}">
                        {{ $message->created_at->format('H:i') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center text-sm text-gray-500 my-4 px-4">
                Mulai percakapan dengan kami! Tim kami akan segera merespon.
            </div>
        @endforelse
    </div>

    {{-- Form untuk mengirim pesan baru --}}
    <div class="p-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex-shrink-0">
        <form wire:submit.prevent="sendMessage">
            <div class="flex items-center gap-2">
                <input
                    wire:model.defer="newMessage"
                    wire:keydown.enter="sendMessage"
                    type="text"
                    placeholder="Ketik pesan Anda..."
                    autocomplete="off"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm h-10">
                <button
                    type="submit"
                    class="bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition w-10 h-10 flex items-center justify-center flex-shrink-0"
                    wire:loading.attr="disabled"
                    wire:target="sendMessage">
                    {{-- Loading state --}}
                    <div wire:loading wire:target="sendMessage"><i class="fa-solid fa-spinner fa-spin"></i></div>
                    {{-- Default state --}}
                    <div wire:loading.remove wire:target="sendMessage"><i class="fa-solid fa-paper-plane"></i></div>
                </button>
            </div>
            @error('newMessage') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        </form>
    </div>
</div>