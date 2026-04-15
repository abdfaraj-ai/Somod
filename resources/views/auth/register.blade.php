@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary d-inline-flex p-3 rounded-circle mb-3">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold">إنشاء حساب جديد</h3>
                    <p class="text-muted">انضم إلينا للمشاركة في التحديثات والمساعدة</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">المنطقة / الحي</label>
                        <select name="area" class="form-select @error('area') is-invalid @enderror" required>
                            <option value="" disabled selected>اختر المنطقة...</option>
                            <option value="شمال غزة" {{ old('area') == 'شمال غزة' ? 'selected' : '' }}>شمال غزة</option>
                            <option value="مدينة غزة" {{ old('area') == 'مدينة غزة' ? 'selected' : '' }}>مدينة غزة</option>
                            <option value="النصيرات" {{ old('area') == 'النصيرات' ? 'selected' : '' }}>النصيرات</option>
                            <option value="دير البلح" {{ old('area') == 'دير البلح' ? 'selected' : '' }}>دير البلح</option>
                            <option value="خانيونس" {{ old('area') == 'خانيونس' ? 'selected' : '' }}>خانيونس</option>
                            <option value="رفح" {{ old('area') == 'رفح' ? 'selected' : '' }}>رفح</option>
                        </select>
                        @error('area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">كلمة المرور</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary fw-bold py-2">إنشاء الحساب</button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted">لديك حساب بالفعل؟</span>
                        <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">
                            تسجيل الدخول
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection