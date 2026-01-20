@extends('admin.layouts.app')

@section('title', 'باقات الاشتراك')
@section('page-title', 'إدارة باقات الاشتراك')

@section('content')
<div class="row g-4">
    <!-- Add New Plan -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus me-2"></i> إضافة باقة جديدة
            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscriptions.plans.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">اسم الباقة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المدة (بالأيام) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror"
                               name="duration" value="{{ old('duration') }}" min="1" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">السعر <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                   name="price" value="{{ old('price') }}" min="0" required>
                            <span class="input-group-text">ر.س</span>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient w-100">
                        <i class="fas fa-save me-1"></i> إضافة الباقة
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Plans List -->
    <div class="col-lg-8">
        <div class="table-card">
            <div class="card-header">
                <i class="fas fa-tags me-2"></i> قائمة الباقات ({{ $plans->count() }})
            </div>
            <div class="card-body p-0">
                @if($plans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>الباقة</th>
                                    <th>المدة</th>
                                    <th>السعر</th>
                                    <th>التجار</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $plan->name }}</span>
                                        @if($plan->description)
                                            <br><small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $plan->duration }} يوم</td>
                                    <td>{{ number_format($plan->price, 2) }} ر.س</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $plan->merchants_count }} تاجر</span>
                                    </td>
                                    <td>
                                        @if($plan->is_active)
                                            <span class="badge badge-status badge-active">نشط</span>
                                        @else
                                            <span class="badge badge-status badge-inactive">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id }}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($plan->merchants_count == 0)
                                            <form action="{{ route('admin.subscriptions.plans.destroy', $plan) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>

                                        <!-- Edit Plan Modal -->
                                        <div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.subscriptions.plans.update', $plan) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">تعديل الباقة - {{ $plan->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">اسم الباقة</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $plan->name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">المدة (بالأيام)</label>
                                                                <input type="number" class="form-control" name="duration" value="{{ $plan->duration }}" min="1" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">السعر</label>
                                                                <input type="number" step="0.01" class="form-control" name="price" value="{{ $plan->price }}" min="0" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">الوصف</label>
                                                                <textarea class="form-control" name="description" rows="3">{{ $plan->description }}</textarea>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive{{ $plan->id }}" {{ $plan->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="isActive{{ $plan->id }}">
                                                                    نشط (متاح للتسجيل)
                                                                </label>
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
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-tags"></i>
                        <p>لا يوجد باقات اشتراك</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
