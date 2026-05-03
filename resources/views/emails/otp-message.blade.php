<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1a1a2e; color: #ffffff; padding: 20px; }
        .container { background-color: #16213e; padding: 30px; border-radius: 10px; max-width: 500px; margin: auto; text-align: center; border: 1px solid #0f3460; }
        .otp-code { font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #e94560; margin: 20px 0; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 8px; }
        .footer { font-size: 12px; color: #888; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verifikasi Email Anda</h2>
        <p>Halo, {{ $userName }}!</p>
        <p>Terima kasih telah bergabung. Masukkan 6 digit kode OTP di bawah ini untuk memverifikasi alamat email Anda. Kode ini berlaku selama 10 menit.</p>
        
        <div class="otp-code">{{ $otpCode }}</div>
        
        <p>Jika Anda tidak merasa mendaftar di sistem kami, abaikan email ini.</p>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>