<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'id_card_type' => ['nullable', 'string', 'max:255'],
            // [PERUBAHAN] Validasi nomor identitas disesuaikan, contoh: NIK KTP adalah 16 digit numerik
            'id_card_number' => ['nullable', 'string', 'max:20'],
            // [DIHAPUS] Validasi untuk id_card_image dihapus dari sini
        ]);

        // [DIHAPUS] Logika untuk menyimpan file gambar dihapus

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'position' => $request->position,
            'id_card_type' => $request->id_card_type,
            'id_card_number' => $request->id_card_number,
            // [DIHAPUS] Kolom id_card_image tidak diisi saat registrasi
        ]);

        $user->assignRole('Client');
        // --------------------------

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
