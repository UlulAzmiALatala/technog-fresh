<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            position: relative; /* Penting untuk pseudoelement */
        }

        /* --- KODE WATERMARK --- */
        body::before {
            content: '';
            position: fixed; /* Akan selalu di latar belakang halaman */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path("images/Logo-Sekunder-Color.png") }}');
            background-repeat: no-repeat;
            background-position: center center;
            
            /* ======================================= */
            /* === INI YANG DIUBAH (DARI 70% JADI 85%) === */
            /* ======================================= */
            background-size: 85%; 
            
            opacity: 0.1; /* Sesuaikan tingkat transparansi (0.1 - 0.3 biasanya bagus) */
            z-index: -1; /* Pastikan watermark ada di bawah konten lain */
            transform: translate(-50%, -50%); /* Atur posisi agar benar-benar di tengah */
            left: 50%;
            top: 50%;
        }
        /* --- AKHIR KODE WATERMARK --- */

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            position: relative; /* Memastikan container di atas watermark */
            z-index: 1; /* Di atas z-index -1 milik watermark */
        }

        /* Styling lama yang sudah ada */
        .header, .footer {
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #000;
        }
        .company-details {
            text-align: right;
            font-size: 12px;
            color: #555;
        }
        .client-details {
            margin-bottom: 30px;
        }
        .invoice-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-details th, .invoice-details td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-details th {
            background-color: #f9f9f9;
            text-align: left;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .status-paid {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #28a745; /* Hijau */
            border: 3px solid #28a745;
            padding: 10px;
            margin-bottom: 30px;
            background-color: #e6f7e9;
        }
        .payment-history th {
            background-color: #fdf8e2;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; border: 0;">
            <tr>
                <td style="width: 50%; border: 0;">
                    <h1 style="font-size: 28px; margin: 0;">TechnoG Solutions</h1>
                    <p style="font-size: 12px; color: #555;">Your Company Address, City, Country<br>
                       Email: contact@technog.com | Phone: +62 123 4567 890
                    </p>
                </td>
                <td style="width: 50%; text-align: right; border: 0;">
                    <h2 style="margin: 0 0 10px 0;">BUKTI PEMBAYARAN</h2>
                    <table style="width: 100%; text-align: right; border: 0;">
                        <tr><td style="border: 0;"><strong>Invoice #:</strong></td><td style="border: 0;">{{ $order->invoice->invoice_number }}</td></tr>
                        <tr><td style="border: 0;"><strong>Tanggal Terbit:</strong></td><td style="border: 0;">{{ \Carbon\Carbon::now()->format('d M Y') }}</td></tr>
                        <tr><td style="border: 0;"><strong>Order ID:</strong></td><td style="border: 0;">#{{ $order->id }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <hr style="margin: 30px 0;">

        <div class="client-details">
            <h3 style="margin-bottom: 5px;">Ditagihkan Kepada:</h3>
            <strong>{{ $order->user->name }}</strong><br>
            {{ $order->user->email }}
            {{-- Tambahkan alamat, no. telp jika ada di model User --}}
            {{-- {{ $order->user->address }} <br> --}}
            {{-- {{ $order->user->phone }} --}}
        </div>

        <div class="status-paid">
            LUNAS (PAID)
        </div>

        <h3 style="margin-bottom: 10px;">Ringkasan Order</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th class="text-right">Kuantitas</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->detailOrders as $detail)
                <tr>
                    <td>{{ $detail->service->name }}</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price / $detail->quantity, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($order->discount_amount > 0)
                <tr>
                    <td colspan="3" class="text-right font-bold">Subtotal</td>
                    <td class="text-right">Rp {{ number_format($order->total_price + $order->discount_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right font-bold">Diskon ({{ $order->discount_code }})</td>
                    <td class="text-right">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr style="background-color: #f0f0f0;">
                    <td colspan="3" class="text-right font-bold" style="font-size: 16px;">Total Tagihan</td>
                    <td class="text-right font-bold" style="font-size: 16px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <h3 style="margin-bottom: 10px;">Riwayat Pembayaran</h3>
        <table class="items-table payment-history">
            <thead>
                <tr>
                    <th>Tanggal Bayar</th>
                    <th>Metode</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $total_paid = 0; @endphp
                @foreach($order->invoice->payments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y, H:i') }}</td>
                    <td>{{ $payment->method }}</td>
                    <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
                @php $total_paid += $payment->amount; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f0f0f0;">
                    <td colspan="2" class="text-right font-bold">Total Terbayar</td>
                    <td class="text-right font-bold">Rp {{ number_format($total_paid, 0, ',', '.') }}</td>
                </tr>
                <tr style="background-color: #e6f7e9;">
                    <td colspan="2" class="text-right font-bold">Sisa Tagihan</td>
                    <td class="text-right font-bold">Rp 0</td>
                </tr>
            </tfoot>
        </table>


        <div class="footer">
            <p>Terima kasih telah menggunakan layanan TechnoG Solutions.</p>
        </div>
    </div>
</body>
</html>