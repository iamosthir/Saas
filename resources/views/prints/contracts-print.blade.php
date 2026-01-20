<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $contract->title ?? 'عقد' }}</title>

  <style>
    @page { size: A4; margin: 12mm; }
    * { box-sizing: border-box; }

    body{
      margin:0;
      background:#fff;
      color:#000;
      font-family: "Tahoma", "Arial", sans-serif;
      font-size: 14px;
      line-height: 1.7;
    }

    .toolbar{
      display:flex;
      justify-content:center;
      padding:12px;
      gap:10px;
    }
    .btn{
      padding:8px 14px;
      border:1px solid #000;
      background:#fff;
      font-family: inherit;
      cursor:pointer;
    }

    .page{
      width: 210mm;
      min-height: 297mm;
      margin: 0 auto;
      padding: 0;
    }

    .center{ text-align:center; }
    .title{
      font-weight: 700;
      font-size: 18px;
      margin: 0 0 6mm 0;
    }
    .contract-number{
      font-size: 12px;
      margin: 0 0 4mm 0;
    }
    .bismillah{
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 2mm 0;
    }

    h3{
      margin: 6mm 0 2mm 0;
      font-size: 14px;
      font-weight: 700;
    }

    .two-col{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 6mm 10mm;
      margin-top: 2mm;
    }

    .row{
      display:flex;
      gap: 6px;
      align-items: baseline;
      white-space: normal;
      margin-bottom: 2mm;
    }
    .lbl{
      font-weight: 700;
      white-space: nowrap;
    }
    .fill{
      flex: 1;
      display:inline-block;
      min-width: 30mm;
      border: none;
    }
    .value{
      flex: 1;
      display:inline-block;
      min-width: 30mm;
      border-bottom: 1px solid #000;
      padding-bottom: 1mm;
    }

    .underline{
      display:inline-block;
      min-width: 60mm;
      border-bottom: 1px solid #000;
      height: 5mm;
      vertical-align: bottom;
    }
    .underline.wide{ min-width: 120mm; }
    .underline.small{ min-width: 45mm; }

    .block{
      margin-top: 4mm;
    }

    .terms{
      margin-top: 4mm;
    }
    .terms p{
      margin: 0 0 2.5mm 0;
      text-align: justify;
    }

    .custom-fields{
      margin-top: 4mm;
    }

    .signatures{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 12mm;
      margin-top: 10mm;
    }

    .stamp{
      margin-top: 8mm;
      text-align:center;
      font-weight: 700;
    }

    .meta{
      display:flex;
      justify-content: space-between;
      gap: 12mm;
      margin-top: 6mm;
    }

    .footer-text{
      margin-top: 6mm;
      padding-top: 4mm;
      border-top: 1px dashed #ccc;
      font-size: 12px;
      text-align: center;
    }

    @media print{
      .toolbar{ display:none; }
      .page{
        margin: 0;
        width: auto;
        min-height: auto;
      }
    }
  </style>
</head>
<body>

  <div class="toolbar">
    <button class="btn" onclick="window.print()">Print</button>
  </div>

  <main class="page">
    <div class="center bismillah">بِسْمِ اللهِ الرَّحْمٰنِ الرَّحِيْمِ</div>
    <div class="center title">{{ $contract->title }}</div>
    <div class="center contract-number">رقم العقد: {{ $contract->contract_number }}</div>

    @if($contract->template && $contract->template->customFields->count() > 0)
    <div class="custom-fields">
      <div class="two-col">
        @foreach($contract->template->customFields as $field)
        <div class="row">
          <span class="lbl">{{ $field->field_label }}:</span>
          <span class="value">{{ $contract->custom_fields[$field->field_key] ?? '' }}</span>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    @if($contract->description)
    <h3>شروط الاتفاق</h3>
    <div class="terms">
      {!! nl2br(e($contract->description)) !!}
    </div>
    @endif

    <div class="meta">
      <div class="row" style="flex:1;">
        <span class="lbl">تاريخ العقد:</span>
        <span class="value">{{ $contract->start_date ? $contract->start_date->format('Y-m-d') : '' }}</span>
      </div>
      <div class="row" style="flex:1;">
        <span class="lbl">تاريخ الانتهاء:</span>
        <span class="value">{{ $contract->end_date ? $contract->end_date->format('Y-m-d') : '' }}</span>
      </div>
    </div>

    <div class="signatures">
      <div>
        <div class="row"><span class="lbl">توقيع الطرف الأول:</span><span class="underline"></span></div>
        <div class="row"><span class="lbl">الاسم:</span><span class="underline"></span></div>
      </div>

      <div>
        <div class="row"><span class="lbl">توقيع الطرف الثاني:</span><span class="underline"></span></div>
        <div class="row"><span class="lbl">الاسم:</span><span class="underline"></span></div>
      </div>
    </div>

    <div class="stamp">ختم المكتب: ________________________</div>

    @if($contract->footer_text)
    <div class="footer-text">
      {{ $contract->footer_text }}
    </div>
    @endif
  </main>

</body>
</html>
