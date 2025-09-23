<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;      // (TAMBAHKAN) Sesuaikan jika nama model Anda berbeda
use App\Events\MessageSent; // (TAMBAHKAN) Kita akan menggunakan event ini
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatWidget extends Component
{
    public Conversation $conversation;
    public $newMessage = '';

    // (TAMBAHKAN) Listener untuk menerima pesan real-time dari admin
    public function getListeners()
    {
        if (!$this->conversation) {
            return [];
        }

        return [
            "echo-private:chat.{$this->conversation->id},MessageSent" => 'handleIncomingMessage',
        ];
    }

    // (TAMBAHKAN) Fungsi ini akan berjalan saat ada pesan masuk dari admin
    public function handleIncomingMessage($event)
    {
        // Cukup muat ulang relasi messages untuk menampilkan pesan baru dari admin
        // Tidak perlu query manual, biarkan Livewire yang me-render ulang
        $this->conversation->load('messages');
    }

    public function getMessagesProperty()
    {
        // Memuat ulang relasi untuk memastikan data selalu baru
        $this->conversation->load('messages.user'); // load user juga agar nama tampil
        return $this->conversation->messages->sortBy('created_at');
    }

    public function mount()
    {
        $this->loadConversation();
    }

    public function loadConversation()
    {
        $this->conversation = Conversation::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'open'],
            []
        );
    }

    public function sendMessage()
    {
        $this->validate(['newMessage' => 'required|string|max:1000']);

        // Simpan pesan ke dalam variabel agar bisa dikirim via broadcast
        $message = $this->conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $this->newMessage,
        ]);

        // (UBAH) Kirim pesan ke admin menggunakan broadcast
        // toOthers() agar pesan tidak diterima kembali oleh pengirim
        broadcast(new MessageSent($message))->toOthers();

        // Mengosongkan input (ini sudah benar)
        $this->reset('newMessage');
    }

    public function render()
    {
        return view('livewire.chat-widget');
    }
}
