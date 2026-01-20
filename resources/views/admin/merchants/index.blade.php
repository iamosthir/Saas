@extends('admin.layouts.app')

@section('title', 'التجار')
@section('page-title', 'إدارة التجار')

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.merchants.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" placeholder="بحث بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>اشتراك منتهي</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-filter me-1"></i> تصفية
                </button>
                <a href="{{ route('admin.merchants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> مسح
                </a>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.merchants.create') }}" class="btn btn-gradient">
                    <i class="fas fa-plus me-1"></i> إضافة تاجر
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Merchants Table -->
<div class="table-card">
    <div class="card-header">
        <i class="fas fa-store me-2"></i> قائمة التجار ({{ $merchants->total() }})
    </div>
    <div class="card-body p-0">
        @if($merchants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>الباقة</th>
                            <th>انتهاء الاشتراك</th>
                            <th>المستخدمين</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($merchants as $merchant)
                        <tr>
                            <td>{{ $merchant->id }}</td>
                            <td>
                                <a href="{{ route('admin.merchants.show', $merchant) }}" class="text-decoration-none fw-bold">
                                    {{ $merchant->name }}
                                </a>
                            </td>
                            <td>{{ $merchant->phone_primary }}</td>
                            <td>{{ $merchant->subscriptionPlan->name ?? 'بدون باقة' }}</td>
                            <td>
                                @if($merchant->subscription_end_date)
                                    @if($merchant->subscription_end_date < now())
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @elseif($merchant->subscription_end_date < now()->addDays(7))
                                        <span class="text-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.index', $merchant) }}" class="badge bg-primary text-decoration-none">
                                    {{ $merchant->users->count() }} مستخدم
                                </a>
                            </td>
                            <td>
                                @if($merchant->is_active && !$merchant->isSubscriptionExpired())
                                    <span class="badge badge-status badge-active">نشط</span>
                                @elseif($merchant->isSubscriptionExpired())
                                    <span class="badge badge-status badge-expired">منتهي</span>
                                @else
                                    <span class="badge badge-status badge-inactive">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.merchants.show', $merchant) }}" class="btn btn-sm btn-info" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.merchants.edit', $merchant) }}" class="btn btn-sm btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.merchants.toggle-status', $merchant) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $merchant->is_active ? 'btn-danger' : 'btn-success' }}" title="{{ $merchant->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                            <i class="fas {{ $merchant->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center p-3">
                {{ $merchants->withQueryString()->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-store"></i>
                <p>لا يوجد تجار مطابقين للبحث</p>
                <a href="{{ route('admin.merchants.create') }}" class="btn btn-gradient mt-2">
                    <i class="fas fa-plus me-1"></i> إضافة تاجر جديد
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
