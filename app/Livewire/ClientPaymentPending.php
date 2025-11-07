<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ClientPaymentPending extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'You do not have access to this order.');
        }
        $this->order = $order;
    }

    /**
     * Render view-nya.
     * Logika ini akan dijalankan setiap 5 detik (karena wire:poll).
     */
    public function render()
    {
        // 1. Muat ulang status order terbaru dari database
        $this->order->refresh();

        // 2. Cek logikanya: JIKA status SUDAH BUKAN 'Menunggu Konfirmasi'
        if ($this->order->status !== 'Menunggu Konfirmasi') {

            // --- INI PERBAIKANNYA ---
            // Kita panggil $this->redirect() (milik Livewire), bukan me-return redirect() (milik Laravel).
            // 'navigate: true' membuatnya pindah halaman tanpa full refresh (SPA-style).
            $this->redirect(route('client.payment.success', $this->order), navigate: true);
            // --- AKHIR PERBAIKAN ---
        }

        // 4. Ambil data payment terakhir
        $lastPayment = $this->order->payments()->latest()->first();

        // 5. JIKA status MASIH 'Menunggu Konfirmasi', tetap tampilkan halaman 'pending'
        // Fungsi render() sekarang SELALU mengembalikan 'view', yang akan
        // dibungkus dengan layout dan mencegah error.
        return view('livewire.client-payment-pending', [
            'order' => $this->order,
            'lastPayment' => $lastPayment
        ]);
    }
}
