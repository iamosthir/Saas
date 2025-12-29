@extends('layouts.customer-master')

@section('page-icon')
    <i class="fas fa-file-invoice"></i>
@endsection

@section('page-title')
    فواتيري
@endsection

@section('page-subtitle')
    جميع الفواتير الخاصة بك
@endsection

@section('extra-css')
<style>
    .invoices-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
        text-align: center;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 1rem;
        text-align: center;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #e2e8f0;
    }

    .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.85rem;
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

    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        text-decoration: none;
        display: inline-block;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-state i {
        font-size: 6rem;
        color: #cbd5e0;
        margin-bottom: 2rem;
    }

    .empty-state h3 {
        color: #4a5568;
        margin-bottom: 1rem;
        font-size: 1.75rem;
    }

    .empty-state p {
        color: #718096;
        font-size: 1.1rem;
    }

    .pagination {
        margin-top: 2rem;
        justify-content: center;
    }

    .pagination .page-link {
        border: 2px solid #667eea;
        color: #667eea;
        font-weight: 600;
        margin: 0 0.25rem;
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="invoices-container">
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table">
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
                            <td><strong>{{ number_format($invoice->total_amount, 0) }}</strong> IQD</td>
                            <td class="text-success"><strong>{{ number_format($invoice->paid_amount, 0) }}</strong> IQD</td>
                            <td class="text-danger"><strong>{{ number_format($invoice->remaining_amount, 0) }}</strong> IQD</td>
                            <td>
                                @if($invoice->is_fully_paid)
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> مدفوع</span>
                                @elseif($invoice->payment_status === 'partial')
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> مدفوع جزئياً</span>
                                @else
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> غير مدفوع</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('customer.invoices.show', $invoice->id) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> عرض التفاصيل
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>لا توجد فواتير</h3>
                <p>لم يتم إنشاء أي فواتير لحسابك بعد. يرجى التواصل مع التاجر للحصول على مزيد من المعلومات.</p>
            </div>
        @endif
    </div>
</div>
@endsection
