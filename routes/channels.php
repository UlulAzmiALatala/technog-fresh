<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation; // (PENTING) Tambahkan ini di bagian atas

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// (TAMBAHKAN INI) Otorisasi untuk channel chat kita
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {

    // Cari percakapan berdasarkan ID yang diminta
    $conversation = Conversation::find($conversationId);

    // Jika user yang sedang login adalah admin, selalu izinkan.
    // Asumsi Anda menggunakan sistem role, sesuaikan 'Founder', 'Konten', dll.
    if ($user->hasAnyRole(['Founder', 'Pemasukan dan Pengeluaran', 'Konten'])) {
        return true;
    }

    // Jika user adalah client, hanya izinkan jika dia adalah pemilik percakapan tersebut.
    if ($conversation && $user->id === $conversation->user_id) {
        return true;
    }

    // Jika tidak memenuhi syarat di atas, tolak akses.
    return false;
});
