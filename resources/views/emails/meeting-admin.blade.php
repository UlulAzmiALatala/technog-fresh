<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f5; color: #18181b; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: auto; border-top: 4px solid #4f46e5; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .data-table td { padding: 10px; border-bottom: 1px solid #e4e4e7; }
        .data-table td:first-child { font-weight: bold; width: 35%; color: #52525b; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #4f46e5; margin-top: 0;">Lead Permintaan Meeting Baru!</h2>
        <p>Halo Admin, ada prospek baru yang masuk melalui Pop-up Website.</p>
        
        <table class="data-table">
            <tr><td>Nama / Perusahaan</td><td>{{ $meeting->name }}</td></tr>
            <tr><td>Kontak (WA/Email)</td><td>{{ $meeting->contact }}</td></tr>
            <tr><td>Tipe Meeting</td><td>{{ $meeting->meeting_type }}</td></tr>
            <tr><td>Tanggal</td><td>{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d F Y') }}</td></tr>
            <tr><td>Jam</td><td>{{ $meeting->meeting_time }} WIB</td></tr>
            <tr><td>Topik</td><td>{{ $meeting->topic ?? '-' }}</td></tr>
        </table>

        <p style="margin-top: 30px;">Silakan segera hubungi klien melalui kontak di atas untuk menentukan jadwal pastinya. Anda juga bisa mengupdate statusnya di Dashboard Admin.</p>
    </div>
</body>
</html>