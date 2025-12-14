<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة البيع #{{ $invoice->id }}</title>
    <meta name="viewport" content="width=700, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f6fa;
            color: #222;
            font-family: 'Tahoma', Arial, sans-serif;
            padding: 30px 0;
        }
        .invoice-box {
            background: #fff;
            max-width: 700px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 2px 8px #ddd;
            padding: 32px 28px 28px 28px;
            border: 1.5px solid #dedede;
        }
        .invoice-logo {
            max-width: 120px;
            max-height: 80px;
            margin-bottom: 10px;
            object-fit: contain;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .invoice-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #355c7d;
            margin-bottom: 7px;
        }
        .table th, .table td {
            vertical-align: middle !important;
        }
        .table th {
            background: #f2f3f8;
        }
        .table tbody tr:last-child td {
            border-bottom: 2px solid #355c7d;
        }
        .summary-row td {
            font-size: 1.2rem;
            font-weight: bold;
            background: #f9fafc;
        }
        .sign-area {
            margin-top: 48px;
            font-size: 1.15rem;
        }
        .company-info {
            text-align: left;
            color: #888;
            font-size: 0.95rem;
        }
        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
            }
            .invoice-box {
                box-shadow: none !important;
                border: none !important;
                padding: 10px !important;
            }
            .no-print { display: none !important; }
        }
    </style>
    <script>
        window.onload = function() { window.print(); }
    </script>
</head>
<body>
<div class="invoice-box" id="printable-invoice">

    <div class="invoice-header">
        <img src="{{ $merchant->logo ?? asset('images/logo.png') }}" alt="Company Logo" class="invoice-logo">
        <div class="company-info mt-2 mb-2">
            <strong>اسم الشركة:</strong> {{ $merchant->name ?? 'شركتك الحديثة' }}<br>
            <strong>العنوان:</strong> {{ $merchant->address ?? 'بغداد، العراق' }}<br>
            <strong>الهاتف:</strong> {{ $merchant->phone_primary ?? '0770-000-0000' }}
        </div>
        <div class="invoice-title">فاتورة بيع</div>
        <div class="text-muted fs-6">رقم الفاتورة: <b>{{ $invoice->id }}</b></div>
    </div>

    <div class="mb-3">
        <div><b>العميل:</b> {{ $invoice->customer->customer_name ?? '' }}</div>
        <div><b>رقم الهاتف:</b> {{ $invoice->customer->phone1 ?? '' }}</div>
        <div><b>التاريخ:</b> {{ \Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d H:i') }}</div>
        @if($invoice->note)
        <div><b>ملاحظة:</b> {{ $invoice->note }}</div>
        @endif
    </div>

    <table class="table table-bordered table-striped align-middle mb-4">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>المتغير</th>
                <th>العدد</th>
                <th>سعر الوحدة</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = is_array($invoice->products) ? $invoice->products : json_decode($invoice->products, true) ?? [];
            @endphp
            @foreach($products as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item['product_name'] ?? '' }}</td>
                    <td>{{ $item['variant_name'] ?? '' }}</td>
                    <td>{{ $item['qnt'] }}</td>
                    <td>{{ number_format($item['unit_price'] ?? 0, 0) }} د.ع</td>
                    <td>{{ number_format($item['total_price'] ?? 0, 0) }} د.ع</td>
                </tr>
            @endforeach
            <tr class="summary-row">
                <td colspan="5" class="text-end"><b>الإجمالي الكلي</b></td>
                <td><b>{{ number_format($invoice->total_price, 0) }} د.ع</b></td>
            </tr>
        </tbody>
    </table>

    <div class="row mt-4">
        <div class="col-6">
            <div><b>حالة الدفع:</b>
                <span style="color:{{ $invoice->payment_status === 'paid' ? '#17a673' : '#d33' }}">
                    {{ $invoice->payment_status === 'paid' ? 'مدفوع' : ($invoice->payment_status === 'pending' ? 'قيد الانتظار' : 'مدفوع جزئيا') }}
                </span>
            </div>
        </div>
        <div class="col-6 text-end">
            <div><b>حالة الطلب:</b>
                <span class="badge bg-info text-dark">{{ $invoice->order_status }}</span>
            </div>
        </div>
    </div>

    <div class="sign-area mt-5">
        التوقيع: _________________________
    </div>

    <div class="text-center mt-4 no-print">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">رجوع</a>
        <button class="btn btn-primary" onclick="window.print();"><i class="fas fa-print"></i> طباعة</button>
    </div>

</div>
</body>
</html>
