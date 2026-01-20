@extends('admin.layouts.app')

@section('title', 'مستخدمي ' . $merchant->name)
@section('page-title', 'إدارة المستخدمين')

@section('content')
<a href="{{ route('admin.merchants.show', $merchant) }}" class="back-link">
    <i class="fas fa-arrow-right"></i> العودة لتفاصيل التاجر
</a>

<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">{{ $merchant->name }}</h5>
            <p class="text-muted mb-0">
                <i class="fas fa-phone me-1"></i> {{ $merchant->phone_primary }}
            </p>
        </div>
        <a href="{{ route('admin.users.create', $merchant) }}" class="btn btn-gradient">
            <i class="fas fa-plus me-1"></i> إضافة مستخدم
        </a>
    </div>
</div>

<div class="table-card">
    <div class="card-header">
        <i class="fas fa-users me-2"></i> قائمة المستخدمين ({{ $users->total() }})
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>الدور</th>
                            <th>تاريخ الإنشاء</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="fw-bold">{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'super' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $user->role === 'super' ? 'مدير' : 'موظف' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.edit', [$merchant, $user]) }}" class="btn btn-sm btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', [$merchant, $user]) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                            <i class="fas fa-trash"></i>
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
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <p>لا يوجد مستخدمين لهذا التاجر</p>
                <a href="{{ route('admin.users.create', $merchant) }}" class="btn btn-gradient mt-2">
                    <i class="fas fa-plus me-1"></i> إضافة مستخدم
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
