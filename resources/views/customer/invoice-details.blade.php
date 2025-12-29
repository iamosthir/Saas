@extends('layouts.customer-master')

@section('page-icon')
    <i class="fas fa-file-invoice-dollar"></i>
@endsection

@section('page-title')
    تفاصيل الفاتورة {{ $invoice->invoice_number }}
@endsection

@section('page-subtitle')
    عرض تفاصيل الفاتورة والمنتجات والمدفوعات
@endsection

@section('extra-css')
<style>
    .invoice-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-left: 0.75rem;
        font-size: 1.75rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-label {
        font-weight: 600;
        color: #4a5568;
    }

    .info-value {
        color: #2d3748;
        font-weight: 500;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
    }

    .badge-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .badge-warning {
        background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
        color: white;
    }

    .badge-danger {
        background: linear-gradient(135deg, #ff6b6b 0%, #ffa502 100%);
        color: white;
    }

    .table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table thead th {
        border: none;
        font-weight: 600;
        padding: 1rem;
    }

    .table tbody tr {
        border-bottom: 1px solid #e2e8f0;
    }

    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 1.1rem;
    }

    .summary-row.total {
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        margin-top: 0.5rem;
        padding-top: 1rem;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .payment-status-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .payment-status-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        border: 3px solid;
        transition: all 0.3s ease;
    }

    .payment-status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .payment-status-card.total {
        border-color: #667eea;
    }

    .payment-status-card.paid {
        border-color: #43e97b;
    }

    .payment-status-card.remaining {
        border-color: #fa709a;
    }

    .payment-status-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .payment-status-card.total .payment-status-icon {
        color: #667eea;
    }

    .payment-status-card.paid .payment-status-icon {
        color: #43e97b;
    }

    .payment-status-card.remaining .payment-status-icon {
        color: #fa709a;
    }

    .payment-status-amount {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .payment-status-label {
        font-size: 0.95rem;
        color: #718096;
        font-weight: 600;
    }

    /* Installment Timeline */
    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline-item {
        position: relative;
        padding: 0 0 2rem 4rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #e2e8f0;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-marker {
        position: absolute;
        right: -10px;
        top: 5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        box-shadow: 0 0 0 4px white;
    }

    .timeline-marker.bg-success {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .timeline-marker.bg-secondary {
        background: #cbd5e0;
    }

    .timeline-content {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .timeline-item-paid .timeline-content {
        border-color: #43e97b;
        background: rgba(67, 233, 123, 0.05);
    }

    .timeline-content:hover {
        transform: translateX(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .installment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .installment-header h6 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d3748;
    }

    .installment-date {
        color: #718096;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .installment-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
    }

    .installment-paid {
        font-size: 0.9rem;
        color: #43e97b;
        font-weight: 600;
    }

    .back-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        text-decoration: none;
        display: inline-block;
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('customer.invoices') }}" class="back-button">
            <i class="fas fa-arrow-right me-2"></i> العودة إلى قائمة الفواتير
        </a>
    </div>

    <!-- Invoice Header -->
    <div class="invoice-card">
        <div class="section-title">
            <i class="fas fa-info-circle"></i>
            معلومات الفاتورة
        </div>
        <div class="info-row">
            <span class="info-label">رقم الفاتورة:</span>
            <span class="info-value"><strong>{{ $invoice->invoice_number }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">تاريخ الإنشاء:</span>
            <span class="info-value">{{ $invoice->created_at->format('Y-m-d h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">نوع الدفع:</span>
            <span class="info-value">
                {{ $invoice->payment_type === 'full_payment' ? 'دفعة واحدة' : 'أقساط' }}
                @if($invoice->payment_type === 'installment')
                    ({{ $invoice->installment_months }} شهر)
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">حالة الدفع:</span>
            <span class="info-value">
                @if($invoice->is_fully_paid)
                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> مدفوع بالكامل</span>
                @elseif($invoice->payment_status === 'partial')
                    <span class="badge badge-warning"><i class="fas fa-clock"></i> مدفوع جزئياً</span>
                @else
                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> غير مدفوع</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Products Table -->
    <div class="invoice-card">
        <div class="section-title">
            <i class="fas fa-shopping-cart"></i>
            المنتجات
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الصنف</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>المجموع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->variation_name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->custom_price, 0) }} IQD</td>
                        <td><strong>{{ number_format($item->line_total, 0) }} IQD</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Summary -->
    <div class="invoice-card">
        <div class="section-title">
            <i class="fas fa-calculator"></i>
            ملخص الفاتورة
        </div>
        <div class="summary-card">
            <div class="summary-row">
                <span>المجموع الفرعي:</span>
                <span>{{ number_format($invoice->subtotal, 0) }} IQD</span>
            </div>
            @if($invoice->discount_amount > 0)
            <div class="summary-row">
                <span>الخصم ({{ $invoice->discount_type === 'percentage' ? $invoice->discount_amount . '%' : 'ثابت' }}):</span>
                <span>- {{ number_format($invoice->discount_amount, 0) }} IQD</span>
            </div>
            @endif
            @if($invoice->extra_charge > 0)
            <div class="summary-row">
                <span>رسوم إضافية:</span>
                <span>+ {{ number_format($invoice->extra_charge, 0) }} IQD</span>
            </div>
            @endif
            <div class="summary-row total">
                <span>المجموع الإجمالي:</span>
                <span>{{ number_format($invoice->total_amount, 0) }} IQD</span>
            </div>
        </div>

        <!-- Payment Status Cards -->
        <div class="payment-status-grid">
            <div class="payment-status-card total">
                <div class="payment-status-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="payment-status-amount">{{ number_format($invoice->total_amount, 0) }} IQD</div>
                <div class="payment-status-label">المبلغ الإجمالي</div>
            </div>
            <div class="payment-status-card paid">
                <div class="payment-status-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="payment-status-amount">{{ number_format($invoice->paid_amount, 0) }} IQD</div>
                <div class="payment-status-label">المبلغ المدفوع</div>
            </div>
            <div class="payment-status-card remaining">
                <div class="payment-status-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="payment-status-amount">{{ number_format($invoice->remaining_amount, 0) }} IQD</div>
                <div class="payment-status-label">المبلغ المتبقي</div>
            </div>
        </div>
    </div>

    <!-- Installment Schedule (if applicable) -->
    @if($invoice->payment_type === 'installment' && $invoice->installmentSchedules->count() > 0)
    <div class="invoice-card">
        <div class="section-title">
            <i class="fas fa-calendar-alt"></i>
            جدول الأقساط
        </div>
        <div class="timeline">
            @foreach($invoice->installmentSchedules as $installment)
            <div class="timeline-item {{ $installment->status === 'paid' ? 'timeline-item-paid' : '' }}">
                <div class="timeline-marker {{ $installment->status === 'paid' ? 'bg-success' : 'bg-secondary' }}">
                    <i class="fas {{ $installment->status === 'paid' ? 'fa-check' : 'fa-circle' }}"></i>
                </div>
                <div class="timeline-content">
                    <div class="installment-header">
                        <h6>
                            القسط {{ $installment->installment_number }}
                            <span class="badge {{ $installment->status === 'paid' ? 'badge-success' : 'badge-danger' }}">
                                {{ $installment->status === 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                            </span>
                        </h6>
                    </div>
                    <p class="installment-date">
                        <i class="fas fa-calendar"></i>
                        تاريخ الاستحقاق: {{ $installment->due_date }}
                        @if($installment->paid_date)
                            <br><i class="fas fa-check"></i> تاريخ الدفع: {{ $installment->paid_date }}
                        @endif
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="installment-amount">{{ number_format($installment->amount, 0) }} IQD</div>
                        @if($installment->paid_amount > 0)
                            <div class="installment-paid">
                                <i class="fas fa-check-circle"></i> مدفوع: {{ number_format($installment->paid_amount, 0) }} IQD
                            </div>
                        @endif
                    </div>
                    @if($installment->notes)
                        <p class="mt-2 mb-0" style="color: #718096; font-size: 0.9rem;">
                            <i class="fas fa-sticky-note"></i> {{ $installment->notes }}
                        </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
