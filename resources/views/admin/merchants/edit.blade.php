@extends('admin.layouts.app')

@section('title', 'تعديل التاجر')
@section('page-title', 'تعديل بيانات التاجر')

@section('content')
<a href="{{ route('admin.merchants.show', $merchant) }}" class="back-link">
    <i class="fas fa-arrow-right"></i> العودة للتفاصيل
</a>

<div class="card">
    <div class="card-header">
        <i class="fas fa-edit me-2"></i> تعديل بيانات: {{ $merchant->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('admin.merchants.update', $merchant) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">اسم التاجر / المتجر <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name', $merchant->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهاتف الأساسي <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone_primary') is-invalid @enderror"
                           name="phone_primary" value="{{ old('phone_primary', $merchant->phone_primary) }}" required>
                    @error('phone_primary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">رقم الهاتف الثانوي</label>
                    <input type="text" class="form-control @error('phone_secondary') is-invalid @enderror"
                           name="phone_secondary" value="{{ old('phone_secondary', $merchant->phone_secondary) }}">
                    @error('phone_secondary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">المدينة</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           name="city" value="{{ old('city', $merchant->city) }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text" class="form-control @error('address1') is-invalid @enderror"
                           name="address1" value="{{ old('address1', $merchant->address1) }}">
                    @error('address1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">وصف المتجر</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              name="description" rows="3">{{ old('description', $merchant->description) }}</textarea>
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
                               {{ old('can_access_pos', $merchant->can_access_pos) ? 'checked' : '' }}>
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
                               {{ old('can_access_contracts', $merchant->can_access_contracts) ? 'checked' : '' }}>
                        <label class="form-check-label" for="canAccessContracts">
                            <i class="fas fa-file-contract me-1 text-primary"></i>
                            <strong>إدارة العقود</strong>
                        </label>
                    </div>
                    <small class="text-muted">السماح للتاجر بالوصول إلى نظام إدارة العقود</small>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="can_access_manufacturing" value="1" id="canAccessManufacturing"
                               {{ old('can_access_manufacturing', $merchant->can_access_manufacturing) ? 'checked' : '' }}>
                        <label class="form-check-label" for="canAccessManufacturing">
                            <i class="fas fa-industry me-1 text-warning"></i>
                            <strong>نظام التصنيع</strong>
                        </label>
                    </div>
                    <small class="text-muted">السماح للتاجر بالوصول إلى نظام التصنيع والإنتاج</small>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-gradient btn-lg">
                        <i class="fas fa-save me-2"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.merchants.show', $merchant) }}" class="btn btn-outline-secondary btn-lg me-2">
                        <i class="fas fa-times me-2"></i> إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
