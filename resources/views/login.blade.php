@extends('layouts.app')

@section('content')
    <div class="view-section py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="icon-box bg-success bg-opacity-10 text-success mx-auto mb-3">
                                <i class="bi bi-person-fill fs-2"></i>
                            </div>
                            <h3 class="fw-bold">تسجيل الدخول</h3>
                            <p class="text-muted small">مرحباً بك مجدداً في مجتمع صمود</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control bg-light border-0 py-2 rounded-3" placeholder="name@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">كلمة المرور</label>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2 rounded-3" placeholder="******" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label small text-muted" for="rememberMe">تذكرني</label>
                                </div>
                                <a href="#" class="text-decoration-none small text-muted">نسيت كلمة المرور؟</a>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success fw-bold rounded-pill py-2 shadow-sm">دخول</button>
                            </div>
                            <div class="text-center small">
                                <span class="text-muted">ليس لديك حساب؟</span>
                                <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none ms-1">إنشاء حساب جديد</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection