<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة ليبل المنتجات</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        @page {
            size: auto;
            margin: 4mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Tahoma, Arial, sans-serif;
            background: #f2f3f5;
            color: #111;
        }

        .toolbar {
            max-width: 1200px;
            margin: 16px auto;
            padding: 0 10px;
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
        }

        .btn {
            border: none;
            border-radius: 6px;
            padding: 8px 14px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-print {
            background: #1976d2;
            color: #fff;
        }

        .btn-back {
            background: #6c757d;
            color: #fff;
            text-decoration: none;
        }

        .labels-grid {
            max-width: 1200px;
            margin: 0 auto 20px auto;
            padding: 8px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50mm, 50mm));
            justify-content: center;
            gap: 3mm;
        }

        .label-card {
            width: 50mm;
            height: 30mm;
            background: #fff;
            border: 1px solid #000;
            padding: 1.6mm 2mm;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .merchant {
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-name {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.15;
            min-height: 9mm;
            max-height: 9mm;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-price {
            text-align: center;
            font-size: 7.8px;
            font-weight: 700;
            line-height: 1;
        }

        .barcode-wrap {
            text-align: center;
            line-height: 1;
            margin-top: 0.8mm;
        }

        .barcode-text {
            text-align: center;
            font-size: 6px;
            margin-top: 0.3mm;
            color: #444;
        }

        @media print {
            body {
                background: #fff;
            }

            .toolbar {
                display: none !important;
            }

            .labels-grid {
                margin: 0 auto;
                padding: 0;
                gap: 2.5mm;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button class="btn btn-print" onclick="window.print()">طباعة</button>
        <a href="{{ url()->previous() }}" class="btn btn-back">رجوع</a>
    </div>

    <div class="labels-grid">
        @foreach($products as $product)
            @php
                $barcodeValue = trim((string) ($product->model_name ?: $product->id));
                $priceValue = number_format((float) $product->sell_price, 0);
            @endphp
            <div class="label-card">
                <div class="merchant">{{ $merchantName }}</div>
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">{{ $priceValue }} IQD</div>
                <div class="barcode-wrap">
                    <svg class="js-barcode" data-value="{{ $barcodeValue }}"></svg>
                    <div class="barcode-text">{{ $barcodeValue }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.js-barcode').forEach(function (el) {
            const value = el.getAttribute('data-value');
            if (!value) {
                return;
            }

            JsBarcode(el, value, {
                format: 'CODE128',
                width: 1.25,
                height: 18,
                displayValue: false,
                margin: 0
            });
        });
    </script>
</body>
</html>
