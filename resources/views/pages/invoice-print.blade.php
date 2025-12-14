<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Tahoma', Arial, sans-serif;
            padding: 20px;
            background: #fff;
            color: #000;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 120px;
            max-height: 80px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-info {
            font-size: 14px;
            line-height: 1.6;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }
        .invoice-number {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 5px 0;
            font-weight: bold;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        .divider {
            border-bottom: 1px solid #000;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
        }
        table td {
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }
        .text-right {
            text-align: right !important;
        }
        .summary {
            float: right;
            width: 300px;
            margin-top: 10px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .summary-row.total {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            font-weight: bold;
            font-size: 18px;
            margin-top: 5px;
        }
        .signature-section {
            clear: both;
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
            width: 200px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            padding-top: 15px;
            border-top: 1px solid #000;
        }
        .no-print {
            text-align: center;
            margin-top: 20px;
        }
        .no-print button {
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-container {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</head>
<body>
<div class="invoice-container">
    <!-- Header -->
    <div class="header">
        @if($merchant->logo)
            <img src="{{ asset('storage/' . $merchant->logo) }}" alt="Logo" class="logo">
        @endif
        <div class="company-name">{{ $merchant->name ?? 'اسم الشركة' }}</div>
        <div class="company-info">
            @if($merchant->address)
                العنوان: {{ $merchant->address }}<br>
            @endif
            @if($merchant->phone_primary)
                الهاتف: {{ $merchant->phone_primary }}
            @endif
        </div>
        <div class="invoice-title">فاتورة</div>
        <div class="invoice-number">رقم الفاتورة: {{ $invoice->invoice_number }}</div>
        <div>التاريخ: {{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}</div>
    </div>

    <!-- Customer Info -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">اسم العميل:</div>
            <div class="info-value">{{ $invoice->customer->customer_name ?? 'غير محدد' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">رقم الهاتف:</div>
            <div class="info-value">{{ $invoice->customer->phone1 ?? 'غير محدد' }}</div>
        </div>
        @if($invoice->customer && $invoice->customer->state)
        <div class="info-row">
            <div class="info-label">المحافظة/المدينة:</div>
            <div class="info-value">{{ $invoice->customer->state }}@if($invoice->customer->city) - {{ $invoice->customer->city }}@endif</div>
        </div>
        @endif
    </div>

    <div class="divider"></div>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>اسم المنتج</th>
                <th>المتغير</th>
                <th style="width: 80px;">الكمية</th>
                <th style="width: 100px;">السعر</th>
                <th style="width: 120px;">المجموع</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->variation_name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->custom_price, 0) }}</td>
                <td>{{ number_format($item->line_total, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-row">
            <span>المجموع الفرعي:</span>
            <span>{{ number_format($invoice->subtotal, 0) }} د.ع</span>
        </div>

        @if($invoice->discount_amount > 0)
        <div class="summary-row">
            <span>الخصم:</span>
            <span>-{{ number_format($invoice->discount_amount, 0) }} د.ع</span>
        </div>
        @endif

        @if($invoice->extra_charge > 0)
        <div class="summary-row">
            <span>رسوم إضافية:</span>
            <span>{{ number_format($invoice->extra_charge, 0) }} د.ع</span>
        </div>
        @endif

        <div class="summary-row total">
            <span>الإجمالي:</span>
            <span>{{ number_format($invoice->total_amount, 0) }} د.ع</span>
        </div>
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">توقيع العميل</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع المحاسب</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        شكراً لتعاملكم معنا<br>
        تاريخ الطباعة: {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}
    </div>

    <!-- Print Buttons -->
    <div class="no-print">
        <button onclick="window.close();">إغلاق</button>
        <button onclick="window.print();">طباعة</button>
    </div>
</div>
</body>
</html>
