<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule // DIUBAH: Mengimplementasikan interface baru
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('app.recaptcha_secret_key'),
            'response' => $value,
        ]);

        // Jika respons dari Google tidak sukses, maka validasi gagal.
        if (! $response->json('success')) {
            $fail('The reCAPTCHA verification failed. Please try again.');
        }
    }
}
