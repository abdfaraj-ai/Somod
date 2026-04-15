@extends('layouts.admin')

@section('title', 'تعديل مستخدم')
@section('page-title', 'تعديل مستخدم: ' . $user->name)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></li>
<li class="breadcrumb-item active">تعديل</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
    <i class="bi bi-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الاسم الكامل *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">البريد الإلكتروني *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">المنطقة *</label>
                            <select name="area" class="form-select @error('area') is-invalid @enderror" required>
                                <option value="" disabled>اختر المنطقة...</option>
                                <option value="شمال غزة" {{ old('area', $user->area) == 'شمال غزة' ? 'selected' : '' }}>شمال غزة</option>
                                <option value="مدينة غزة" {{ old('area', $user->area) == 'مدينة غزة' ? 'selected' : '' }}>مدينة غزة</option>
                                <option value="النصيرات" {{ old('area', $user->area) == 'النصيرات' ? 'selected' : '' }}>النصيرات</option>
                                <option value="دير البلح" {{ old('area', $user->area) == 'دير البلح' ? 'selected' : '' }}>دير البلح</option>
                                <option value="خانيونس" {{ old('area', $user->area) == 'خانيونس' ? 'selected' : '' }}>خانيونس</option>
                                <option value="رفح" {{ old('area', $user->area) == 'رفح' ? 'selected' : '' }}>رفح</option>
                            </select>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الدور *</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>مستخدم</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>مسؤول</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الحالة</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">الحساب نشط</label>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">تغيير كلمة المرور</h6>
                                    <p class="text-muted small mb-3">اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">كلمة المرور الجديدة</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">تأكيد كلمة المرور</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection