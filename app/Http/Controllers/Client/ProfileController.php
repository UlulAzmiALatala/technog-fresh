<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
// PERBAIKAN: Menggunakan Request standar agar validasi bisa kita atur di sini
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        // PERBAIKAN: Path view disesuaikan kembali ke struktur yang lebih umum
        return view('client.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // PERBAIKAN: Validasi diperbarui untuk mencakup semua kolom baru
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'id_card_type' => ['nullable', 'string', 'in:KTP,Passport,SIM'],
            'id_card_number' => ['nullable', 'string', 'max:255'],
            'id_card_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Mengisi data yang divalidasi
        $user->fill($validated);

        // Jika email diubah, reset status verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // PERBAIKAN: Handle upload gambar kartu identitas
        if ($request->hasFile('id_card_image')) {
            if ($user->id_card_image) {
                Storage::disk('public')->delete($user->id_card_image);
            }
            $user->id_card_image = $request->file('id_card_image')->store('id_cards', 'public');
        }

        // Simpan semua perubahan
        $user->save();

        return Redirect::route('client.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun client.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
