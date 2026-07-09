{{-- Lokasi: resources/views/emails/order-notification.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechnoG Solutions Notification</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; color: #1e293b; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg, #1e293b, #4f46e5); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: 1px; }
        .header p { color: #c7d2fe; margin: 10px 0 0 0; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; font-weight: bold;}
        .content { padding: 40px 30px; line-height: 1.6; }
        .greeting { font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #0f172a; }
        .message-box { background-color: #f8fafc; border-left: 4px solid #4f46e5; padding: 20px; border-radius: 0 8px 8px 0; margin-bottom: 30px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th { text-align: left; padding: 12px; border-bottom: 2px solid #e2e8f0; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .details-table td { padding: 16px 12px; border-bottom: 1px solid #e2e8f0; font-weight: 600; font-size: 15px; }
        .total-row td { border-bottom: none; font-size: 18px; color: #4f46e5; }
        .footer { background-color: #f1f5f9; padding: 30px; text-align: center; color: #64748b; font-size: 13px; }
        .footer a { color: #4f46e5; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TechnoG Solutions</h1>
            <p>Intelligence Powered by Data</p>
        </div>
        
        <div class="content">
            <div class="greeting">Hello, {{ $order->user->name }}!</div>
            
            <div class="message-box">
                @if($type === 'payment_uploaded')
                    Terima kasih! Kami telah menerima bukti transfer untuk pesanan Anda. Tim <strong>Finance</strong> kami akan segera melakukan verifikasi maksimal 1x24 jam kerja. Kami akan mengabari Anda kembali setelah pembayaran terverifikasi.
                @else
                    Terima kasih telah mempercayakan proyek Anda kepada TechnoG Solutions! Permintaan pesanan Anda telah berhasil tercatat dalam sistem kami. Tim ahli kami akan segera meninjau kebutuhan Anda.
                @endif
            </div>

            <table class="details-table">
                <tr>
                    <th colspan="2">Project Summary</th>
                </tr>
                <tr>
                    <td style="color: #64748b; font-weight: normal; font-size: 14px;">Order ID</td>
                    <td style="text-align: right;">#{{ $order->id }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; font-weight: normal; font-size: 14px;">Service Name</td>
                    <td style="text-align: right;">{{ $order->detailOrders->first()->service->name ?? 'Enterprise Service' }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; font-weight: normal; font-size: 14px;">Order Date</td>
                    <td style="text-align: right;">{{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Investment</td>
                    <td style="text-align: right;">$ {{ number_format($order->total_price, 2) }}</td>
                </tr>
            </table>

            <p style="color: #475569; font-size: 14px;">
                Jika Anda memiliki pertanyaan lebih lanjut, silakan balas email ini atau hubungi tim <strong>Support</strong> kami.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TechnoG Solutions Global Ltd. All rights reserved.<br>
            <a href="{{ url('/') }}">Visit Our Website</a>
        </div>
    </div>
</body>
</html>