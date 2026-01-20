@extends('admin.layouts.app')

@section('title', 'إضافة تاجر')
@section('page-title', 'إضافة تاجر جديد')

@section('content')
<a href="{{ route('admin.merchants.index') }}" class="back-link">
    <i class="fas fa-arrow-right"></i> العودة للقائمة
</a>

<div class="card">
    <div class="card-header">
        <i class="fas fa-plus me-2"></i> إضافة تاجر جديد
    </div>
    <div class="card-body">
        <form action="{{ route('admin.merchants.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Merchant Info Section -->
                <div class="col-12">
                    <h5 class="mb-3 text-primary"><i class="fas fa-store me-2"></i> بيانات التاجر</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">اسم التاجر / المتجر <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('merchant_name') is-invalid @enderror"
                           name="merchant_name" value="{{ old('merchant_name') }}" required>
                    @error('merchant_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهاتف الأساسي <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone_primary') is-invalid @enderror"
                           name="phone_primary" value="{{ old('phone_primary') }}" required>
                    @error('phone_primary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهاتف الثانوي</label>
                    <input type="text" class="form-control @error('phone_secondary') is-invalid @enderror"
                           name="phone_secondary" value="{{ old('phone_secondary') }}">
                    @error('phone_secondary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">المدينة</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           name="city" value="{{ old('city') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" class="form-control @error('address1') is-invalid @enderror"
                           name="address1" value="{{ old('address1') }}">
                    @error('address1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">باقة الاشتراك <span class="text-danger">*</span></label>
                    <select class="form-select @error('subscription_plan_id') is-invalid @enderror"
                            name="subscription_plan_id" required>
                        <option value="">اختر الباقة...</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - {{ $plan->duration }} يوم ({{ number_format($plan->price, 2) }} ر.س)
                            </option>
                        @endforeach
                    </select>
                    @error('subscription_plan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">وصف المتجر</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Permissions Section -->
                <div class="col-12 mt-4">
                    <h5 class="mb-3 text-primary"><i class="fas fa-key me-2"></i> صلاحيات الوصول</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="can_access_pos" value="1" id="canAccessPos"
                               {{ old('can_access_pos') ? 'checked' : '' }}>
                        <label class="form-check-label" for="canAccessPos">
                            <i class="fas fa-cash-register me-1 text-success"></i>
                            <strong>نظام نقاط البيع (POS)</strong>
                        </label>
                    </div>
                    <small class="text-muted">السماح للتاجر بالوصول إلى نظام نقاط البيع</small>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="can_access_contracts" value="1" id="canAccessContracts"
                               {{ old('can_access_contracts') ? 'checked' : '' }}>
                        <label class="form-check-label" for="canAccessContracts">
                            <i class="fas fa-file-contract me-1 text-primary"></i>
                            <strong>إدارة العقود</strong>
                        </label>
                    </div>
                    <small class="text-muted">السماح للتاجر بالوصول إلى نظام إدارة العقود</small>
                </div>

                <!-- User Info Section -->
                <div class="col-12 mt-4">
                    <h5 class="mb-3 text-primary"><i class="fas fa-user me-2"></i> بيانات المستخدم الرئيسي</h5>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">اسم المستخدم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                           name="user_name" value="{{ old('user_name') }}" required>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم هاتف المستخدم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('user_phone') is-invalid @enderror"
                           name="user_phone" value="{{ old('user_phone') }}" required>
                    @error('user_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">سيستخدم لتسجيل الدخول</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                           name="user_email" value="{{ old('user_email') }}">
                    @error('user_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('user_password') is-invalid @enderror"
                           name="user_password" required minlength="6">
                    @error('user_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">يجب أن تكون 6 أحرف على الأقل</small>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-gradient btn-lg">
                        <i class="fas fa-save me-2"></i> إنشاء التاجر
                    </button>
                    <a href="{{ route('admin.merchants.index') }}" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="fas fa-times me-2"></i> إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
