<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ClientNotificationBell extends Component
{
    /**
     * Fungsi ini akan dijalankan oleh Livewire untuk me-render komponen.
     * Kita akan mengambil notifikasi di sini.
     */
    public function render()
    {
        $notifications = collect(); // Default koleksi kosong
        $count = 0;

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user) {
            $notifications = $user->unreadNotifications()->take(5)->get();
            $count = $user->unreadNotifications()->count();
        }

        return view('livewire.client-notification-bell', [
            'notifications' => $notifications,
            'count' => $count,
        ]);
    }

    /**
     * Fungsi ini akan dipanggil oleh tombol 'Mark all as read'
     * via wire:click="markAsRead"
     */
    public function markAsRead()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }
}
