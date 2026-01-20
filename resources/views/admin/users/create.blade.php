@extends('admin.layouts.app')

@section('title', 'إضافة مستخدم')
@section('page-title', 'إضافة مستخدم جديد')

@section('content')
<a href="{{ route('admin.users.index', $merchant) }}" class="back-link">
    <i class="fas fa-arrow-right"></i> العودة للقائمة
</a>

<div class="card mb-4">
    <div class="card-body">
        <h6 class="text-muted mb-1">إضافة مستخدم جديد إلى:</h6>
        <h5 class="mb-0">{{ $merchant->name }}</h5>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-user-plus me-2"></i> بيانات المستخدم الجديد
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store', $merchant) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">سيستخدم لتسجيل الدخول</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">الدور <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>موظف</option>
                        <option value="super" {{ old('role') === 'super' ? 'selected' : '' }}>مدير</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required minlength="6">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">يجب أن تكون 6 أحرف على الأقل</small>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-gradient btn-lg">
                        <i class="fas fa-save me-2"></i> إنشاء المستخدم
                    </button>
                    <a href="{{ route('admin.users.index', $merchant) }}" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="fas fa-times me-2"></i> إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
