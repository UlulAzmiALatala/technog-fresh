{{-- Lokasi: resources/views/livewire/admin-chat.blade.php --}}
<div class="grid grid-cols-1 md:grid-cols-12 min-h-[600px] bg-white/60 dark:bg-slate-800/60 backdrop-blur-2xl rounded-[2.5rem] shadow-xl border border-white/40 dark:border-slate-700/50 overflow-hidden relative" 
     wire:poll.10s.visible="checkForNewConversations">

    {{-- Efek Glow Halus di Background --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    {{-- KOLOM KIRI: DAFTAR PERCAKAPAN --}}
    <div class="col-span-1 md:col-span-4 lg:col-span-3 border-r border-slate-200/60 dark:border-slate-700/50 flex flex-col bg-slate-50/50 dark:bg-slate-900/30 relative z-10">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700/50 flex-shrink-0 flex items-center justify-between">
            <h2 class="text-xs font-black uppercase tracking-widest text-slate-800 dark:text-slate-200">Active Chats</h2>
            <span class="bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400 py-0.5 px-2 rounded-lg text-[10px] font-bold">{{ count($this->conversations) }}</span>
        </div>

        <div class="flex-grow overflow-y-auto custom-scrollbar">
            @forelse ($this->conversations as $conversation)
                <div wire:click="selectConversation({{ $conversation->id }})"
                     class="p-5 border-b border-slate-100 dark:border-slate-800/50 cursor-pointer transition-all duration-200 group relative
                     {{ optional($this->selectedConversation)->id === $conversation->id ? 'bg-white dark:bg-slate-800 shadow-sm' : 'hover:bg-white/50 dark:hover:bg-slate-800/50' }}">
                    
                    @if(optional($this->selectedConversation)->id === $conversation->id)
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 rounded-r-full shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>
                    @endif

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm transition-colors duration-200
                             {{ optional($this->selectedConversation)->id === $conversation->id ? 'bg-indigo-500 text-white shadow-md' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 group-hover:bg-indigo-100 group-hover:text-indigo-600' }}">
                            {{ substr($conversation->user->name, 0, 1) }}
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <p class="text-sm font-bold text-slate-900 dark:text-white truncate pr-2 {{ optional($this->selectedConversation)->id === $conversation->id ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{ $conversation->user->name }}
                                </p>
                                @if($conversation->messages->count() > 0)
                                    <span class="text-[9px] font-bold text-slate-400 whitespace-nowrap">
                                        {{ $conversation->messages->last()->created_at->format('H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate font-medium">
                                {{ $conversation->messages->last()->body ?? 'No messages yet.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-400">
                    <p class="text-[10px] font-bold uppercase tracking-widest">No Active Conversations</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- KOLOM KANAN: RUANG CHAT --}}
    <div class="col-span-1 md:col-span-8 lg:col-span-9 flex flex-col relative z-10">
        @if ($this->selectedConversation)
            <div class="flex flex-col flex-grow" wire:poll.2s.visible>
                
                <div class="px-8 py-5 border-b border-slate-200/60 dark:border-slate-700/50 flex items-center justify-between bg-white/40 dark:bg-slate-800/40 backdrop-blur-md">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-300 font-black text-sm">
                            {{ substr($this->selectedConversation->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white">{{ $this->selectedConversation->user->name }}</h3>
                            <p class="text-[10px] uppercase font-bold tracking-widest text-emerald-500 flex items-center mt-0.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Client Connected
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Area Pesan (Flex-grow agar bisa tumbuh) --}}
                <div class="flex-grow p-6 md:p-8 overflow-y-auto custom-scrollbar flex flex-col gap-4 scroll-smooth"
                     id="chat-messages-container"
                     x-data="{ scrollToBottom() { $el.scrollTop = $el.scrollHeight; } }"
                     x-init="setTimeout(() => scrollToBottom(), 150)"
                     @admin-message-sent.window="$nextTick(() => scrollToBottom())">

                    @foreach ($this->selectedConversation->messages as $message)
                        @php $isAdminMessage = !$message->user->hasRole('Client'); @endphp
                        
                        <div class="flex w-full {{ $isAdminMessage ? 'justify-end' : 'justify-start' }} group">
                            <div class="flex flex-col {{ $isAdminMessage ? 'items-end' : 'items-start' }} max-w-[80%] md:max-w-[60%]">
                                <div class="px-5 py-3 {{ $isAdminMessage 
                                    ? 'bg-[#5046e5] text-white rounded-[1.25rem] rounded-br-[0.25rem] shadow-md' 
                                    : 'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-100 dark:border-slate-600 rounded-[1.25rem] rounded-bl-[0.25rem] shadow-sm' }}">
                                    <p class="text-[13px] font-medium leading-relaxed break-words">{{ $message->body }}</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-400 mt-1.5 tracking-wider px-1">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Area Input --}}
                <div class="p-6 md:p-8 pt-4 border-t border-slate-200/60 dark:border-slate-700/50 bg-white/40 dark:bg-slate-800/40 backdrop-blur-md">
                    <form wire:submit.prevent="sendMessage" class="flex items-end gap-3">
                        <input wire:model.defer="newMessage"
                               wire:keydown.enter="sendMessage"
                               type="text"
                               placeholder="Type your reply here..."
                               class="w-full py-4 pl-6 pr-6 rounded-2xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-medium text-slate-900 dark:text-white shadow-inner focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"
                               autocomplete="off">
                        <button type="submit" class="h-[52px] w-[52px] bg-[#5046e5] text-white rounded-2xl hover:bg-[#4338ca] shadow-lg shadow-indigo-500/30 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-full text-slate-400">
                <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-6 shadow-inner">
                    <i class="fa-regular fa-paper-plane fa-3x text-slate-300 dark:text-slate-600 ml-[-5px]"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-tight mb-2">Select a Conversation</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Click on a chat to start assisting.</p>
            </div>
        @endif
    </div>
</div>