<?php

namespace App\Http\Controllers\Admin\Founder;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan kontak.
     */
    public function contactIndex()
    {
        // Ambil semua settings dan ubah jadi array [key => value]
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.founder.settings.contact.index', compact('settings'));
    }

    /**
     * Menyimpan/Mengupdate data info kontak dari form tunggal.
     */
    public function contactUpdate(Request $request)
    {
        $validated = $request->validate([
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:500',
            'contact_whatsapp' => 'nullable|string|max:255', // (Opsional)
        ]);

        // Loop setiap data yang valid dan simpan ke database
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],       // Cari berdasarkan 'key'
                ['value' => $value]    // Update atau Buat 'value' baru
            );
        }

        return back()->with('success', 'Contact information has been successfully updated.');
    }
}
