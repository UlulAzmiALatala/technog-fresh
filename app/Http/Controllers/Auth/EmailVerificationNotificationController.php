<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification (Modified for OTP Resend).
     */
    public function store(Request $request): RedirectResponse
    {
        // Jika user sudah diverifikasi, langsung arahkan ke dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 1. Generate OTP Baru (6 Digit)
        $newOtpCode = (string) random_int(100000, 999999);

        // 2. Simpan OTP baru ke database dan perbarui masa kedaluwarsa (10 menit)
        $request->user()->update([
            'otp_code' => $newOtpCode,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // 3. Kirim Mailable OTP
        Mail::to($request->user()->email)->send(new OTPMail($newOtpCode, $request->user()->name));

        // 4. Kembali ke halaman verifikasi dengan pesan sukses
        return back()->with('status', 'verification-link-sent');
    }
}
