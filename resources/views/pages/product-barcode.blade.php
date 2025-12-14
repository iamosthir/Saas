<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>باركود المنتج - {{ $product->name }}</title>
    <meta name="viewport" content="width=700, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        body {
            background: #f5f6fa;
            color: #222;
            font-family: 'Tahoma', Arial, sans-serif;
            padding: 30px 0;
        }
        .barcode-box {
            background: #fff;
            max-width: 700px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 2px 8px #ddd;
            padding: 32px 28px 28px 28px;
            border: 1.5px solid #dedede;
        }
        .barcode-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .barcode-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #355c7d;
            margin-bottom: 7px;
        }
        .product-info {
            background: #f9fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .product-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }
        .product-details {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
        }
        .detail-item {
            text-align: center;
        }
        .detail-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .barcode-image {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
        }
        .variations-container {
            margin-top: 30px;
        }
        .variation-card {
            background: #f9fafc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
        .variation-header {
            font-weight: bold;
            margin-bottom: 10px;
            color: #3498db;
            text-align: center;
            font-size: 1.1rem;
        }
        .variation-barcode {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .no-print {
            margin-top: 30px;
        }
        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
            }
            .barcode-box {
                box-shadow: none !important;
                border: none !important;
                padding: 10px !important;
                max-width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
            .variation-card {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }
        }
    </style>
    <script>
        window.onload = function() {
            // Auto print when page loads
            setTimeout(function() {
                window.print();
            }, 1000);
        }
    </script>
</head>
<body>
<div class="barcode-box" id="printable-barcode">

    <div class="barcode-header">
        <div class="barcode-title">باركود المنتج</div>
        <div class="text-muted fs-6">معرف المنتج: <b>{{ $product->id }}</b></div>
    </div>

    <!-- Main Product Barcode -->
    <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-details">
            <div class="detail-item">
                <div class="detail-label">معرف المنتج</div>
                <div class="detail-value">#{{ $product->id }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">السعر</div>
                <div class="detail-value">{{ number_format($product->sell_price, 2) }} IQD</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">المخزون</div>
                <div class="detail-value">{{ $product->total_stock }}</div>
            </div>
        </div>
    </div>

    <div class="barcode-image">
        <svg id="main-barcode"></svg>
        <div class="mt-2">
            <strong>معرف المنتج: {{ $product->id }}</strong>
        </div>
    </div>

    <!-- Variations Barcodes -->
    @if($product->variation && count($product->variation) > 0)
    <div class="variations-container">
        <h3 class="text-center mb-4">باركود المتغيرات</h3>

        @foreach($product->variation as $variation)
        <div class="variation-card">
            <div class="variation-header">
                {{ $variation->var_name }}
                @if($variation->attribute_values)
                    @foreach($variation->attribute_values as $key => $value)
                        <span class="badge bg-secondary me-1">{{ $key }}: {{ $value }}</span>
                    @endforeach
                @endif
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label">السعر</div>
                        <div class="detail-value">{{ number_format($variation->price, 2) }} IQD</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label">المخزون</div>
                        <div class="detail-value">{{ $variation->quantity }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label">معرف المتغير</div>
                        <div class="detail-value">#{{ $variation->id }}</div>
                    </div>
                </div>
            </div>

            <div class="variation-barcode">
                <svg id="variation-barcode-{{ $variation->id }}"></svg>
                <div class="mt-2">
                    <strong>معرف المتغير: {{ $variation->id }}</strong>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="text-center no-print">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">رجوع</a>
        <button class="btn btn-primary" onclick="window.print();"><i class="fas fa-print"></i> طباعة</button>
    </div>

</div>

<script>
    // Generate main product barcode
    JsBarcode("#main-barcode", "{{ $product->id }}", {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: true,
        fontSize: 14,
        margin: 10
    });

    // Generate variation barcodes
    @if($product->variation && count($product->variation) > 0)
        @foreach($product->variation as $variation)
            JsBarcode("#variation-barcode-{{ $variation->id }}", "{{ $variation->id }}", {
                format: "CODE128",
                width: 2,
                height: 60,
                displayValue: true,
                fontSize: 12,
                margin: 8
            });
        @endforeach
    @endif
</script>
</body>
</html>
