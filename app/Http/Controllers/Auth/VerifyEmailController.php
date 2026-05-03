<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified (Default Link Verification).
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            // FIX: Hapus intended()
            return redirect()->route('dashboard', ['verified' => 1]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // FIX: Hapus intended()
        return redirect()->route('dashboard', ['verified' => 1]);
    }

    /**
     * Mark the authenticated user's email address as verified using OTP.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        // Jika sudah diverifikasi, langsung ke dashboard
        if ($user->hasVerifiedEmail()) {
            // FIX: Hapus intended()
            return redirect()->route('dashboard', ['verified' => 1]);
        }

        // Cek kecocokan OTP
        if ($user->otp_code !== $request->otp_code) {
            throw ValidationException::withMessages([
                'otp_code' => 'Kode OTP yang dimasukkan tidak valid.',
            ]);
        }

        // Cek kedaluwarsa OTP
        if (now()->greaterThan($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp_code' => 'Kode OTP sudah kedaluwarsa. Silakan minta ulang OTP baru.',
            ]);
        }

        // Proses verifikasi berhasil
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Hapus kode OTP agar tidak bisa digunakan lagi
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // FIX: Hapus intended()
        return redirect()->route('dashboard', ['verified' => 1]);
    }
}
