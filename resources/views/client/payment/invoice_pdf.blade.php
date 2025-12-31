{{-- Lokasi: resources/views/client/payment/invoice_pdf.blade.php (SOVEREIGN AUDIT PDF EDITION) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $order->invoice->invoice_number }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0F172A;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #FFFFFF;
        }

        /* --- WATERMARK LOGIC --- */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%; /* Sesuai permintaan Anda */
            z-index: -1000;
            opacity: 0.05;
        }

        .container {
            padding: 50px;
            position: relative;
        }

        /* --- TOP BRANDING --- */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #F1F5F9;
            padding-bottom: 30px;
            margin-bottom: 40px;
        }
        .brand-name {
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1px;
            color: #4F46E5;
        }
        .document-type {
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1E293B;
            text-align: right;
        }

        /* --- INFO GRID --- */
        .info-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .info-label {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            color: #94A3B8;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* --- STATUS BADGE --- */
        .status-paid {
            background-color: #ECFDF5;
            color: #059669;
            border: 1px solid #10B981;
            padding: 10px;
            text-align: center;
            font-weight: 900;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 40px;
        }

        /* --- ITEMS TABLE --- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            border-bottom: 1px solid #E2E8F0;
            padding: 12px 10px;
            text-align: left;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
        }
        .items-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .font-black { font-weight: 900; }

        /* --- TOTALS --- */
        .totals-table {
            width: 40%;
            margin-left: 60%;
            border-collapse: collapse;
        }
        .total-row td { padding: 8px 10px; }
        .grand-total {
            background-color: #4F46E5;
            color: #FFFFFF;
        }
        .grand-total td {
            padding: 15px 10px;
            font-weight: 900;
            font-size: 14px;
        }

        /* --- AUDIT SIGNATURE --- */
        .audit-footer {
            margin-top: 60px;
            border-top: 1px solid #F1F5F9;
            padding-top: 20px;
        }
        .audit-token {
            font-family: 'Courier', monospace;
            font-size: 10px;
            font-weight: 700;
            color: #4F46E5;
        }
    </style>
</head>
<body>
    {{-- Watermark Image --}}
    @if(file_exists(public_path("images/Logo-Sekunder-Color.png")))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/Logo-Sekunder-Color.png'))) }}" class="watermark">
    @endif

    <div class="container">
        {{-- Top Branding --}}
        <table class="header-table">
            <tr>
                <td>
                    <div class="brand-name">TechnoG Solutions</div>
                    <div style="color: #64748B; font-size: 10px; font-weight: 700; text-transform: uppercase;">Cyber Architecture & Development</div>
                </td>
                <td class="document-type">
                    Official Receipt
                </td>
            </tr>
        </table>

        {{-- Meta Info --}}
        <table class="info-table">
            <tr>
                <td width="33%">
                    <div class="info-label">Billed To</div>
                    <div class="info-value">{{ $order->user->name }}</div>
                    <div style="color: #64748B; font-size: 10px;">{{ $order->user->email }}</div>
                </td>
                <td width="33%">
                    <div class="info-label">Invoice Details</div>
                    <div class="info-value">{{ $order->invoice->invoice_number }}</div>
                    <div style="color: #64748B; font-size: 10px;">ID: #{{ $order->id }}</div>
                </td>
                <td width="33%" style="text-align: right;">
                    <div class="info-label">Issue Date</div>
                    <div class="info-value">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                </td>
            </tr>
        </table>

        {{-- Status Badge --}}
        <div class="status-paid">
            Settlement Verified
        </div>

        {{-- Items --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th width="50%">Service Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->detailOrders as $detail)
                <tr>
                    <td class="font-black" style="text-transform: uppercase;">{{ $detail->service->name }}</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">$ {{ number_format($detail->price / $detail->quantity, 2) }}</td>
                    <td class="text-right font-black">$ {{ number_format($detail->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="totals-table">
            @if($order->discount_amount > 0)
            <tr class="total-row">
                <td class="info-label">Subtotal</td>
                <td class="text-right font-black">$ {{ number_format($order->total_price + $order->discount_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td class="info-label">Promotion</td>
                <td class="text-right" style="color: #EF4444;">- $ {{ number_format($order->discount_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="grand-total">
                <td style="text-transform: uppercase; letter-spacing: 1px;">Amount Paid</td>
                <td class="text-right">$ {{ number_format($order->total_price, 2) }}</td>
            </tr>
        </table>

        {{-- Audit Signature (Sesuai Halaman Sukses) --}}
        <div class="audit-footer">
            <div class="info-label">System Verification Hash</div>
            <div class="audit-token">
                TXN-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr(md5(optional($order->payments()->latest()->first())->id ?? 'paid'), 0, 8)) }}
            </div>
            <div style="margin-top: 10px; font-size: 9px; color: #94A3B8; text-transform: uppercase; font-weight: 700;">
                This document is electronically verified by TechnoG Nodal Intelligence. No physical signature is required.
            </div>
        </div>
    </div>
</body>
</html>