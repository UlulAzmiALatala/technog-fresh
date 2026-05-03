<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\Recaptcha;
use App\Mail\OTPMail; // Import Mailable OTP

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
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns,filter', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'id_card_type' => ['nullable', 'string', 'max:255'],
            'id_card_number' => ['nullable', 'string', 'max:20'],
            'g-recaptcha-response' => ['required', new Recaptcha],
        ]);

        // Generate OTP 6 Digit Random
        $otpCode = (string) random_int(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'position' => $request->position,
            'id_card_type' => $request->id_card_type,
            'id_card_number' => $request->id_card_number,
            'otp_code' => $otpCode,
            'otp_expires_at' => now()->addMinutes(10), // Berlaku 10 menit
        ]);

        $user->assignRole('Client');

        // Kirim Email OTP
        Mail::to($user->email)->send(new OTPMail($otpCode, $user->name));

        // Catatan: event(new Registered($user)); dimatikan agar tidak mengirim email verifikasi bawaan Laravel

        Auth::login($user);

        // Arahkan ke halaman verifikasi OTP
        return redirect(route('verification.notice', absolute: false));
    }
}
