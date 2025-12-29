@extends('layouts.customer-master')

@section('page-icon')
    <i class="fas fa-home"></i>
@endsection

@section('page-title')
    مرحباً {{ $customer->customer_name }}
@endsection

@section('page-subtitle')
    نظرة عامة على فواتيرك ومدفوعاتك
@endsection

@section('extra-css')
<style>
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        text-align: center;
        border: 2px solid transparent;
    }

    .stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stats-card.blue {
        border-color: #4facfe;
    }

    .stats-card.blue .stats-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stats-card.purple {
        border-color: #667eea;
    }

    .stats-card.purple .stats-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stats-card.green {
        border-color: #43e97b;
    }

    .stats-card.green .stats-icon {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .stats-card.orange {
        border-color: #fa709a;
    }

    .stats-card.orange .stats-icon {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    .stats-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        font-size: 1rem;
        color: #718096;
        font-weight: 600;
    }

    .recent-invoices {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1.5rem;
    }

    .table {
        margin-bottom: 0;
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
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
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

    .btn-view-all {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 15px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        display: inline-block;
        text-decoration: none;
    }

    .btn-view-all:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #718096;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="stats-card blue">
                <div class="stats-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stats-number">{{ $stats['total_invoices'] }}</div>
                <div class="stats-label">إجمالي الفواتير</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card purple">
                <div class="stats-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stats-number">{{ number_format($stats['total_amount'], 0) }}</div>
                <div class="stats-label">المبلغ الإجمالي (IQD)</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card green">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-number">{{ number_format($stats['paid_amount'], 0) }}</div>
                <div class="stats-label">المبلغ المدفوع (IQD)</div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-card orange">
                <div class="stats-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stats-number">{{ number_format($stats['remaining_amount'], 0) }}</div>
                <div class="stats-label">المبلغ المتبقي (IQD)</div>
            </div>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="recent-invoices">
        <h2 class="section-title">آخر الفواتير</h2>

        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>المبلغ الإجمالي</th>
                            <th>المدفوع</th>
                            <th>المتبقي</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td><strong>{{ $invoice->invoice_number }}</strong></td>
                            <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                            <td>{{ number_format($invoice->total_amount, 0) }} IQD</td>
                            <td class="text-success"><strong>{{ number_format($invoice->paid_amount, 0) }} IQD</strong></td>
                            <td class="text-danger"><strong>{{ number_format($invoice->remaining_amount, 0) }} IQD</strong></td>
                            <td>
                                @if($invoice->is_fully_paid)
                                    <span class="badge badge-success">مدفوع</span>
                                @elseif($invoice->payment_status === 'partial')
                                    <span class="badge badge-warning">مدفوع جزئياً</span>
                                @else
                                    <span class="badge badge-danger">غير مدفوع</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('customer.invoices.show', $invoice->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> عرض
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('customer.invoices') }}" class="btn-view-all">
                    <i class="fas fa-list me-2"></i> عرض جميع الفواتير
                </a>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>لا توجد فواتير حتى الآن</h3>
                <p>لم يتم إنشاء أي فواتير لحسابك بعد. يرجى التواصل مع التاجر.</p>
            </div>
        @endif
    </div>
</div>
@endsection
