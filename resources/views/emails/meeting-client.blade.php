<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #1a1a2e; color: #ffffff; padding: 20px; }
        .container { background-color: #16213e; padding: 30px; border-radius: 10px; max-width: 500px; margin: auto; border: 1px solid #0f3460; }
        .footer { font-size: 12px; color: #888; margin-top: 30px; border-top: 1px solid #0f3460; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #818cf8; margin-top: 0;">Permintaan Meeting Diterima!</h2>
        <p>Halo <strong>{{ $meeting->name }}</strong>,</p>
        <p>Terima kasih telah menghubungi TechnoG Solutions. Kami telah menerima permintaan meeting Anda terkait topik:</p>
        <blockquote style="border-left: 3px solid #818cf8; margin-left: 0; padding-left: 15px; font-style: italic; color: #cbd5e1;">
            "{{ $meeting->topic ?? 'Diskusi Project' }}"
        </blockquote>
        <p>Tim expert kami saat ini sedang meninjau ketersediaan jadwal <strong>{{ $meeting->meeting_type }}</strong> pada tanggal <strong>{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d F Y') }}</strong> jam <strong>{{ $meeting->meeting_time }} WIB</strong>. Kami akan segera menghubungi Anda kembali melalui WhatsApp atau Email Anda ({{ $meeting->contact }}).</p>
        <p>Mari bersiap untuk mewujudkan solusi digital terbaik bersama kami!</p>
        
        <div class="footer">
            Salam Hangat,<br>
            <strong>Tim TechnoG Solutions</strong><br>
            <a href="{{ config('app.url') }}" style="color: #818cf8;">{{ config('app.url') }}</a>
        </div>
    </div>
</body>
</html>