<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contract->title }} - رقم {{ $contract->contract_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Tahoma', sans-serif;
            direction: rtl;
            background: #f5f5f5;
            padding: 20px;
        }

        /* Print Actions - Hidden when printing */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Contract Page */
        .contract-page {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 30px 40px 20px;
            border-bottom: 3px double #000;
        }

        .header-car {
            width: 120px;
            flex-shrink: 0;
        }

        .header-car img {
            width: 100%;
            height: auto;
        }

        .header-content {
            flex: 1;
            text-align: center;
            padding: 0 20px;
        }

        .bismillah {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            font-family: 'Traditional Arabic', serif;
        }

        .main-title {
            font-size: 26px;
            font-weight: bold;
            margin: 15px 0;
            text-decoration: underline;
        }

        .contract-number {
            font-size: 16px;
            margin-top: 10px;
            font-weight: 600;
        }

        /* Contract Body */
        .contract-body {
            padding: 30px 40px 40px;
        }

        /* Parties Section */
        .parties-section {
            margin-bottom: 30px;
        }

        .party-box {
            margin-bottom: 25px;
            padding: 15px;
        }

        .party-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
            text-align: center;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px dotted #999;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th {
            text-align: right;
            padding: 10px 15px;
            width: 30%;
            font-weight: 600;
            font-size: 15px;
            border-bottom: 1px solid #000;
        }

        .info-table td {
            padding: 10px 15px;
            font-size: 15px;
        }

        /* Contract Terms */
        .section-heading {
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0 15px;
            padding: 10px;
            background: #f8f8f8;
            border-right: 4px solid #000;
        }

        .contract-terms {
            margin: 25px 0;
        }

        .terms-content {
            padding: 20px;
            line-height: 2;
            font-size: 15px;
            text-align: justify;
            background: #fafafa;
        }

        .terms-content p {
            margin-bottom: 15px;
        }

        .terms-content ul,
        .terms-content ol {
            margin: 15px 0;
            padding-right: 30px;
        }

        .terms-content li {
            margin-bottom: 10px;
        }

        /* Additional Fields */
        .additional-fields {
            margin: 25px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }

        .details-table th {
            text-align: right;
            padding: 12px 15px;
            background: #f0f0f0;
            font-weight: 600;
            width: 35%;
        }

        .details-table td {
            padding: 12px 15px;
        }

        /* Footer Note */
        .footer-note {
            margin: 25px 0;
            padding: 15px 20px;
            line-height: 1.8;
            font-size: 14px;
        }

        /* Agreement Clause */
        .agreement-clause {
            margin: 30px 0;
            padding: 20px;
            background: #f8f8f8;
            text-align: center;
        }

        .agreement-clause p {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .contract-dates-info {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 15px;
            font-size: 14px;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            margin-top: 50px;
            padding-top: 30px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
        }

        .signature-label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 50px;
        }

        .signature-line {
            border-bottom: 2px solid #000;
            margin: 0 20px 20px;
        }

        .signature-info {
            text-align: right;
            padding: 0 20px;
            font-size: 14px;
        }

        .signature-info div {
            margin: 8px 0;
        }

        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                padding: 0;
                background: white;
            }

            .contract-page {
                max-width: 100%;
                box-shadow: none;
            }

            .page-header {
                padding: 20px 30px 15px;
            }

            .contract-body {
                padding: 20px 30px 30px;
            }

            /* Ensure proper page breaks */
            .party-box,
            .contract-terms,
            .signatures {
                page-break-inside: avoid;
            }

            /* Print colors */
            .party-box,
            .details-table th,
            .agreement-clause {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    </div>
</body>
</html>

<script>
    // Auto print when page loads
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
    };
</script>

    <!-- Contract Document -->
    <div class="contract-page">
        <!-- Header with car images -->
        <div class="page-header">
            <div class="header-car header-car-left">
                <img src="{{ asset('images/car-left.png') }}" alt="Car" onerror="this.style.display='none'">
            </div>

            <div class="header-content">
                <div class="bismillah">بسم الله الرحمن الرحيم</div>
                <h1 class="main-title">{{ $contract->title }}</h1>
                <div class="contract-number">رقم العقد: {{ $contract->contract_number }}</div>
            </div>

            <div class="header-car header-car-right">
                <img src="{{ asset('images/car-right.png') }}" alt="Car" onerror="this.style.display='none'">
            </div>
        </div>

        <!-- Contract Body -->
        <div class="contract-body">
            <!-- Parties Information -->
            <div class="parties-section">
                @php
                    $firstPartyFields = collect($contract->template->customFields ?? [])->filter(function($field) {
                        return str_starts_with($field->field_key, 'first_party_');
                    });

                    $secondPartyFields = collect($contract->template->customFields ?? [])->filter(function($field) {
                        return str_starts_with($field->field_key, 'second_party_');
                    });
                @endphp

                <!-- First Party -->
                @if($firstPartyFields->count() > 0)
                <div class="party-box">
                    <h3 class="party-title">الطرف الأول (البائع)</h3>
                    <table class="info-table">
                        @foreach($firstPartyFields as $field)
                        <tr>
                            <th>{{ $field->field_label }}</th>
                            <td>{{ $contract->custom_fields[$field->field_key] ?? '.............................' }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif

                <!-- Second Party -->
                @if($secondPartyFields->count() > 0)
                <div class="party-box">
                    <h3 class="party-title">الطرف الثاني (المشتري)</h3>
                    <table class="info-table">
                        @foreach($secondPartyFields as $field)
                        <tr>
                            <th>{{ $field->field_label }}</th>
                            <td>{{ $contract->custom_fields[$field->field_key] ?? '.............................' }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>

            <!-- Contract Description/Terms -->
            <div class="contract-terms">
                <h3 class="section-heading">نص العقد</h3>
                <div class="terms-content">
                    {!! $contract->description !!}
                </div>
            </div>

            <!-- Additional Custom Fields (excluding party fields) -->
            @php
                $otherFields = collect($contract->template->customFields ?? [])->filter(function($field) {
                    return !str_starts_with($field->field_key, 'first_party_')
                        && !str_starts_with($field->field_key, 'second_party_');
                });
            @endphp

            @if($otherFields->count() > 0)
            <div class="additional-fields">
                <h3 class="section-heading">تفاصيل إضافية</h3>
                <table class="details-table">
                    @foreach($otherFields as $field)
                    <tr>
                        <th>{{ $field->field_label }}</th>
                        <td>
                            @php
                                $value = $contract->custom_fields[$field->field_key] ?? null;
                                if ($field->field_type === 'date' && $value) {
                                    echo \Carbon\Carbon::parse($value)->translatedFormat('d F Y');
                                } elseif ($field->field_type === 'number' && $value) {
                                    echo number_format($value);
                                } else {
                                    echo $value ?? '...........................';
                                }
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            <!-- Footer Text -->
            @if($contract->footer_text)
            <div class="footer-note">
                {{ $contract->footer_text }}
            </div>
            @endif

            <!-- Agreement Clause -->
            <div class="agreement-clause">
                <p>عقدت هذه الاتفاقية بين الطرفين حسب ما يلي:</p>
                @if($contract->start_date || $contract->end_date)
                <p class="contract-dates-info">
                    @if($contract->start_date)
                    <span>تاريخ البدء: {{ \Carbon\Carbon::parse($contract->start_date)->translatedFormat('d F Y') }}</span>
                    @endif
                    @if($contract->end_date)
                    <span>تاريخ الانتهاء: {{ \Carbon\Carbon::parse($contract->end_date)->translatedFormat('d F Y') }}</span>
                    @endif
                </p>
                @endif
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-label">توقيع الطرف الأول</div>
                    <div class="signature-line"></div>
                    <div class="signature-info">
                        <div>الاسم: ...................................</div>
                        <div>التاريخ: {{ now()->translatedFormat('d F Y') }}</div>
                    </div>
                </div>

                <div class="signature-box">
                    <div class="signature-label">توقيع الطرف الثاني</div>
                    <div class="signature-line"></div>
                    <div class="signature-info">
                        <div>الاسم: ...................................</div>
                        <div>التاريخ: {{ now()->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
