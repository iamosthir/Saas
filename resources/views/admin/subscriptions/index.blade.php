@extends('admin.layouts.app')

@section('title', 'إدارة الاشتراكات')
@section('page-title', 'إدارة الاشتراكات')

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" placeholder="بحث بالاسم أو رقم الهاتف..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select">
                    <option value="">كل الاشتراكات</option>
                    <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="expiring" {{ request('filter') === 'expiring' ? 'selected' : '' }}>ينتهي قريباً</option>
                    <option value="expired" {{ request('filter') === 'expired' ? 'selected' : '' }}>منتهي</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-gradient">
                    <i class="fas fa-filter me-1"></i> تصفية
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> مسح
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Subscriptions Table -->
<div class="table-card">
    <div class="card-header">
        <i class="fas fa-credit-card me-2"></i> قائمة الاشتراكات ({{ $merchants->total() }})
    </div>
    <div class="card-body p-0">
        @if($merchants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>التاجر</th>
                            <th>الباقة</th>
                            <th>بداية الاشتراك</th>
                            <th>نهاية الاشتراك</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($merchants as $merchant)
                        <tr>
                            <td>
                                <a href="{{ route('admin.merchants.show', $merchant) }}" class="text-decoration-none fw-bold">
                                    {{ $merchant->name }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $merchant->phone_primary }}</small>
                            </td>
                            <td>{{ $merchant->subscriptionPlan->name ?? 'بدون باقة' }}</td>
                            <td>{{ $merchant->subscription_start_date ? $merchant->subscription_start_date->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($merchant->subscription_end_date)
                                    @if($merchant->subscription_end_date < now())
                                        <span class="text-danger fw-bold">
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @elseif($merchant->subscription_end_date < now()->addDays(7))
                                        <span class="text-warning fw-bold">
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                        </span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!$merchant->is_active)
                                    <span class="badge badge-status badge-inactive">غير نشط</span>
                                @elseif($merchant->isSubscriptionExpired())
                                    <span class="badge badge-status badge-expired">منتهي</span>
                                @elseif($merchant->subscription_end_date && $merchant->subscription_end_date < now()->addDays(7))
                                    <span class="badge badge-status badge-expiring">ينتهي قريباً</span>
                                @else
                                    <span class="badge badge-status badge-active">نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Quick Extend -->
                                    <form action="{{ route('admin.subscriptions.extend', $merchant) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="days" value="30">
                                        <button type="submit" class="btn btn-sm btn-success" title="تمديد 30 يوم">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>

                                    <!-- Edit Dates Modal Trigger -->
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $merchant->id }}" title="تعديل التواريخ">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>

                                    <!-- Change Plan Modal Trigger -->
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#planModal{{ $merchant->id }}" title="تغيير الباقة">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>

                                    @if($merchant->is_active)
                                    <form action="{{ route('admin.subscriptions.revoke', $merchant) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء الاشتراك؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="إلغاء الاشتراك">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                <!-- Edit Dates Modal -->
                                <div class="modal fade" id="editModal{{ $merchant->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.subscriptions.update-dates', $merchant) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تعديل تواريخ الاشتراك - {{ $merchant->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">تاريخ البداية</label>
                                                        <input type="date" class="form-control" name="subscription_start_date"
                                                               value="{{ $merchant->subscription_start_date ? $merchant->subscription_start_date->format('Y-m-d') : '' }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">تاريخ النهاية</label>
                                                        <input type="date" class="form-control" name="subscription_end_date"
                                                               value="{{ $merchant->subscription_end_date ? $merchant->subscription_end_date->format('Y-m-d') : '' }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                    <button type="submit" class="btn btn-gradient">حفظ التغييرات</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Change Plan Modal -->
                                <div class="modal fade" id="planModal{{ $merchant->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.subscriptions.change-plan', $merchant) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تغيير الباقة - {{ $merchant->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">الباقة الجديدة</label>
                                                        <select class="form-select" name="subscription_plan_id" required>
                                                            @foreach($plans as $plan)
                                                                <option value="{{ $plan->id }}" {{ $merchant->subscription_plan_id == $plan->id ? 'selected' : '' }}>
                                                                    {{ $plan->name }} - {{ $plan->duration }} يوم
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="reset_dates" value="1" id="resetDates{{ $merchant->id }}">
                                                        <label class="form-check-label" for="resetDates{{ $merchant->id }}">
                                                            إعادة تعيين التواريخ (يبدأ من اليوم)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                    <button type="submit" class="btn btn-gradient">تغيير الباقة</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                <i class="fas fa-credit-card"></i>
                <p>لا يوجد اشتراكات مطابقة للبحث</p>
            </div>
        @endif
    </div>
</div>
@endsection
