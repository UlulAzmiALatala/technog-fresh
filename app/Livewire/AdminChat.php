<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminChat extends Component
{
    public $selectedConversationId;
    public $newMessage = '';

    // Listener untuk menerima pesan real-time dari client via Echo
    public function getListeners()
    {
        if ($this->selectedConversationId) {
            return [
                "echo-private:chat.{$this->selectedConversationId},MessageSent" => 'handleIncomingMessage',
            ];
        }
        return [];
    }

    // Fungsi yang berjalan saat ada pesan masuk dari client
    public function handleIncomingMessage($event)
    {
        // Cukup muat ulang pesan untuk menampilkan pesan baru
        if ($this->selectedConversation) {
            $this->selectedConversation->load('messages.user');
        }
    }

    // (BARU) Method kosong untuk polling daftar percakapan
    // Ini memperbaiki error 500
    public function checkForNewConversations()
    {
        // Tidak perlu diisi apa-apa.
        // Saat dipanggil oleh wire:poll, Livewire akan otomatis
        // me-refresh properti $this->conversations jika ada perubahan.
    }

    public function getConversationsProperty()
    {
        return Conversation::where('status', 'open')
            ->with(['user', 'messages' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->get();
    }

    public function getSelectedConversationProperty()
    {
        if ($this->selectedConversationId) {
            return Conversation::with('messages.user')->findOrFail($this->selectedConversationId);
        }
        return null;
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;
        $this->reset('newMessage');
    }

    public function sendMessage()
    {
        if (!$this->selectedConversationId) {
            return;
        }

        $this->validate(['newMessage' => 'required|string|max:1000']);

        $message = $this->selectedConversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->newMessage,
        ]);

        // Kirim pesan ke client menggunakan broadcast via Echo
        broadcast(new MessageSent($message))->toOthers();

        // (UBAH) Mengosongkan input dan mengirim event untuk auto-scroll
        $this->reset('newMessage');
        $this->dispatch('admin-message-sent');
    }

    public function render()
    {
        return view('livewire.admin-chat');
    }
}
