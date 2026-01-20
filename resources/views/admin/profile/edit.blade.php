@extends('admin.layouts.app')

@section('title', 'الملف الشخصي')
@section('page-title', 'الملف الشخصي')

@section('content')
<div class="row g-4">
    <!-- Profile Info -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user me-2"></i> البيانات الشخصية
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name', $admin->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $admin->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               name="phone" value="{{ old('phone', $admin->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock me-2"></i> تغيير كلمة المرور
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الحالية <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                               name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الجديدة <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required minlength="6">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">يجب أن تكون 6 أحرف على الأقل</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"
                               name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-gradient">
                        <i class="fas fa-key me-1"></i> تغيير كلمة المرور
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Account Info -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> معلومات الحساب
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-muted">تاريخ الإنشاء</label>
                        <p class="mb-0">{{ $admin->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted">آخر تسجيل دخول</label>
                        <p class="mb-0">{{ $admin->last_login_at ? $admin->last_login_at->format('Y-m-d H:i') : 'لم يتم التسجيل بعد' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted">نوع الحساب</label>
                        <p class="mb-0">
                            @if($admin->is_super)
                                <span class="badge bg-primary">Super Admin</span>
                            @else
                                <span class="badge bg-secondary">Admin</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
