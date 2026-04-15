@extends('layouts.app')

@section('content')
    <div class="view-section py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                <i class="bi bi-person-plus-fill fs-2"></i>
                            </div>
                            <h3 class="fw-bold">إنشاء حساب جديد</h3>
                            <p class="text-muted small">انضم إلينا للمشاركة في التحديثات والمساعدة</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3"style="color: brown;">
                                <label  style="color : red;" class="form-label fw-bold small text-muted" style="color: brown;">الاسم الكامل</label>
                                <input type="text"  name="name" class="form-control" style="color: brown;" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">المنطقة / الحي</label>
                                <select name="area" class="form-select bg-light border-0 py-2 rounded-3">
                                    <option selected disabled>اختر المنطقة...</option>
                                    <option>شمال غزة</option>
                                    <option>مدينة غزة</option>
                                    <option>النصيرات</option>
                                    <option>دير البلح</option>
                                    <option>خانيونس</option>
                                    <option>رفح</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control bg-light border-0 py-2 rounded-3" style="color: brown;" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">كلمة المرور</label>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2 rounded-3" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2 rounded-3" required>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary fw-bold rounded-pill py-2 shadow-sm">تسجيل</button>
                            </div>
                            <div class="text-center small">
                                <span class="text-muted">لديك حساب بالفعل؟</span>
                                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none ms-1">تسجيل الدخول</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection