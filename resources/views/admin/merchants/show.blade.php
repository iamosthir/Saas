@extends('admin.layouts.app')

@section('title', $merchant->name)
@section('page-title', 'تفاصيل التاجر')

@section('content')
<a href="{{ route('admin.merchants.index') }}" class="back-link">
    <i class="fas fa-arrow-right"></i> العودة للقائمة
</a>

<div class="row g-4">
    <!-- Merchant Info -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-store me-2"></i> بيانات التاجر</span>
                <a href="{{ route('admin.merchants.edit', $merchant) }}" class="btn btn-sm btn-light">
                    <i class="fas fa-edit me-1"></i> تعديل
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">اسم التاجر</label>
                        <p class="fw-bold mb-0">{{ $merchant->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">الحالة</label>
                        <p class="mb-0">
                            @if($merchant->is_active && !$merchant->isSubscriptionExpired())
                                <span class="badge badge-status badge-active">نشط</span>
                            @elseif($merchant->isSubscriptionExpired())
                                <span class="badge badge-status badge-expired">اشتراك منتهي</span>
                            @else
                                <span class="badge badge-status badge-inactive">غير نشط</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">الهاتف الأساسي</label>
                        <p class="fw-bold mb-0">{{ $merchant->phone_primary }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">الهاتف الثانوي</label>
                        <p class="mb-0">{{ $merchant->phone_secondary ?? 'غير محدد' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">المدينة</label>
                        <p class="mb-0">{{ $merchant->city ?? 'غير محدد' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">العنوان</label>
                        <p class="mb-0">{{ $merchant->address1 ?? 'غير محدد' }}</p>
                    </div>
                    @if($merchant->description)
                    <div class="col-12 mb-3">
                        <label class="text-muted">الوصف</label>
                        <p class="mb-0">{{ $merchant->description }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تاريخ الإنشاء</label>
                        <p class="mb-0">{{ $merchant->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2"></i> مستخدمي التاجر ({{ $merchant->users->count() }})</span>
                <a href="{{ route('admin.users.create', $merchant) }}" class="btn btn-sm btn-light">
                    <i class="fas fa-plus me-1"></i> إضافة مستخدم
                </a>
            </div>
            <div class="card-body p-0">
                @if($merchant->users->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>البريد</th>
                                <th>الدور</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($merchant->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $user->role === 'super' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $user->role === 'super' ? 'مدير' : 'موظف' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('admin.users.edit', [$merchant, $user]) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', [$merchant, $user]) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state py-4">
                        <i class="fas fa-users"></i>
                        <p>لا يوجد مستخدمين</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Permissions & Subscription -->
    <div class="col-lg-4">
        <!-- Permissions Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-key me-2"></i> صلاحيات الوصول
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="fas fa-cash-register me-2 text-success"></i>
                        <strong>نظام نقاط البيع (POS)</strong>
                    </div>
                    @if($merchant->can_access_pos)
                        <span class="badge bg-success"><i class="fas fa-check me-1"></i> مفعّل</span>
                    @else
                        <span class="badge bg-secondary"><i class="fas fa-times me-1"></i> غير مفعّل</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-contract me-2 text-primary"></i>
                        <strong>إدارة العقود</strong>
                    </div>
                    @if($merchant->can_access_contracts)
                        <span class="badge bg-success"><i class="fas fa-check me-1"></i> مفعّل</span>
                    @else
                        <span class="badge bg-secondary"><i class="fas fa-times me-1"></i> غير مفعّل</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Subscription Card -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-credit-card me-2"></i> بيانات الاشتراك
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted">الباقة الحالية</label>
                    <p class="fw-bold mb-0">{{ $merchant->subscriptionPlan->name ?? 'بدون باقة' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">بداية الاشتراك</label>
                    <p class="mb-0">{{ $merchant->subscription_start_date ? $merchant->subscription_start_date->format('Y-m-d') : 'غير محدد' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">نهاية الاشتراك</label>
                    <p class="mb-0">
                        @if($merchant->subscription_end_date)
                            @if($merchant->subscription_end_date < now())
                                <span class="text-danger fw-bold">
                                    {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                    <br><small>(منتهي)</small>
                                </span>
                            @elseif($merchant->subscription_end_date < now()->addDays(7))
                                <span class="text-warning fw-bold">
                                    {{ $merchant->subscription_end_date->format('Y-m-d') }}
                                    <br><small>(ينتهي قريباً)</small>
                                </span>
                            @else
                                <span class="text-success fw-bold">{{ $merchant->subscription_end_date->format('Y-m-d') }}</span>
                            @endif
                        @else
                            غير محدد
                        @endif
                    </p>
                </div>

                <hr>

                <!-- Quick Actions -->
                <h6 class="mb-3">إجراءات سريعة</h6>

                <form action="{{ route('admin.subscriptions.extend', $merchant) }}" method="POST" class="mb-2">
                    @csrf
                    <div class="input-group">
                        <input type="number" name="days" class="form-control" placeholder="عدد الأيام" value="30" min="1">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i> تمديد
                        </button>
                    </div>
                </form>

                <form action="{{ route('admin.merchants.toggle-status', $merchant) }}" method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn {{ $merchant->is_active ? 'btn-danger' : 'btn-success' }} w-100">
                        <i class="fas {{ $merchant->is_active ? 'fa-ban' : 'fa-check' }} me-1"></i>
                        {{ $merchant->is_active ? 'إلغاء التفعيل' : 'تفعيل التاجر' }}
                    </button>
                </form>

                @if($merchant->is_active)
                <form action="{{ route('admin.subscriptions.revoke', $merchant) }}" method="POST"
                      onsubmit="return confirm('هل أنت متأكد من إلغاء الاشتراك؟')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-times me-1"></i> إلغاء الاشتراك
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
