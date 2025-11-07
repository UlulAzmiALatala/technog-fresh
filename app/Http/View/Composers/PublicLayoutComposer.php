<?php

namespace App\Http\View\Composers;

use App\Models\Logo;
use App\Models\SocialLink;
use App\Models\Setting; // <-- IMPORT SUDAH BENAR
use Illuminate\View\View;

class PublicLayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // 1. Ambil Logo untuk Footer (Sudah ada)
        $footerLogo = Logo::where('name', 'Footer Light')
            ->where('is_active', true)
            ->first();

        // 2. Ambil Semua Social Links (Sudah ada)
        $socialLinks = SocialLink::orderBy('sort_order', 'asc')->get();

        // --- PERBAIKAN LOGIKA TOTAL DI SINI ---
        // 1. Ambil SEMUA settings, dan ubah menjadi koleksi 'key' => 'value'
        $settingsCollection = Setting::all()->pluck('value', 'key');

        // 2. Buat objek $settings yang rapi agar mudah dibaca oleh View
        $settings = (object) [
            'address'  => $settingsCollection->get('contact_address'),
            'email'    => $settingsCollection->get('contact_email'),
            'phone'    => $settingsCollection->get('contact_phone'),
            'whatsapp' => $settingsCollection->get('contact_whatsapp'),
            // Kita bisa tambahkan apa saja di sini nanti
        ];
        // --- AKHIR PERBAIKAN ---

        // 3. Kirim data ke view
        $view->with('footerLogo', $footerLogo)
            ->with('socialLinks', $socialLinks)
            ->with('settings', $settings); // <-- Sekarang $settings adalah objek yang benar
    }
}
