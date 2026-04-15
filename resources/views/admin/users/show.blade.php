@extends('layouts.admin')

@section('title', 'تفاصيل المستخدم')
@section('page-title', 'تفاصيل المستخدم')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
<li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> تعديل
    </a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right"></i> العودة
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md">
        <!-- User Profile Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <h4 class="fw-bold">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }}">
                        {{ $user->role == 'admin' ? 'مسؤول' : 'مستخدم' }}
                    </span>
                    <span class="badge bg-{{ $user->is_active ? 'success' : 'warning' }}">
                        {{ $user->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-2">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        <strong>المنطقة:</strong> {{ $user->area }}
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <strong>الهاتف:</strong> {{ $user->phone ?? 'غير محدد' }}
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-calendar text-primary me-2"></i>
                        <strong>تاريخ التسجيل:</strong> {{ $user->created_at->format('Y-m-d') }}
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <strong>آخر دخول:</strong> 
                        @if($user->last_login_at)
                            {{ $user->last_login_at->diffForHumans() }}
                        @else
                            لم يسجل دخول بعد
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h6 class="mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($user->id != auth()->id())
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} w-100">
                            <i class="bi bi-{{ $user->is_active ? 'person-x' : 'person-check' }} me-2"></i>
                            {{ $user->is_active ? 'تعطيل الحساب' : 'تفعيل الحساب' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                            <i class="bi bi-trash me-2"></i> حذف المستخدم
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection