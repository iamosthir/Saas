@extends('admin.layouts.app')

@section('title', 'الرئيسية')
@section('page-title', 'لوحة التحكم الرئيسية')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>إجمالي التجار</h6>
                    <h3>{{ $stats['total_merchants'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-store"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>التجار النشطين</h6>
                    <h3 class="text-success">{{ $stats['active_merchants'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>اشتراكات منتهية</h6>
                    <h3 class="text-danger">{{ $stats['expired_subscriptions'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #ff6b6b, #ffa502);">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>تنتهي قريباً</h6>
                    <h3 class="text-warning">{{ $stats['expiring_soon'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #feca57, #ff9ff3);">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>إجمالي المستخدمين</h6>
                    <h3>{{ $stats['total_users'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #a8edea, #fed6e3);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6>باقات الاشتراك</h6>
                    <h3>{{ $stats['total_plans'] }}</h3>
                </div>
                <div class="icon" style="background: linear-gradient(135deg, #e94560, #1a1a2e);">
                    <i class="fas fa-tags"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i> إجراءات سريعة
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.merchants.create') }}" class="btn btn-gradient">
                        <i class="fas fa-plus me-2"></i> إضافة تاجر جديد
                    </a>
                    <a href="{{ route('admin.subscriptions.index', ['filter' => 'expired']) }}" class="btn btn-outline-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> عرض الاشتراكات المنتهية
                    </a>
                    <a href="{{ route('admin.subscriptions.plans') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tags me-2"></i> إدارة الباقات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Merchants -->
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-store me-2"></i> أحدث التجار</span>
                <a href="{{ route('admin.merchants.index') }}" class="btn btn-sm btn-light">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                @if($recentMerchants->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الباقة</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMerchants as $merchant)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.merchants.show', $merchant) }}" class="text-decoration-none">
                                        {{ $merchant->name }}
                                    </a>
                                </td>
                                <td>{{ $merchant->subscriptionPlan->name ?? 'بدون باقة' }}</td>
                                <td>
                                    @if($merchant->is_active && !$merchant->isSubscriptionExpired())
                                        <span class="badge badge-status badge-active">نشط</span>
                                    @elseif($merchant->isSubscriptionExpired())
                                        <span class="badge badge-status badge-expired">منتهي</span>
                                    @else
                                        <span class="badge badge-status badge-inactive">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-store"></i>
                        <p>لا يوجد تجار حتى الآن</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Expiring Soon -->
    <div class="col-lg-6">
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-exclamation-circle me-2"></i> اشتراكات تنتهي قريباً</span>
                <a href="{{ route('admin.subscriptions.index', ['filter' => 'expiring']) }}" class="btn btn-sm btn-light">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                @if($expiringMerchants->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>التاجر</th>
                                <th>تاريخ الانتهاء</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringMerchants as $merchant)
                            <tr>
                                <td>{{ $merchant->name }}</td>
                                <td>
                                    <span class="text-warning">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.subscriptions.extend', $merchant) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="days" value="30">
                                        <button type="submit" class="btn btn-sm btn-gradient">
                                            <i class="fas fa-plus me-1"></i> تمديد 30 يوم
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle text-success"></i>
                        <p>لا توجد اشتراكات تنتهي قريباً</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
