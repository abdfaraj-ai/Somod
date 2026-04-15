@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 text-success d-inline-flex p-3 rounded-circle mb-3">
                        <i class="bi bi-person-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold">تسجيل الدخول</h3>
                    <p class="text-muted">مرحباً بك مجدداً في مجتمع صمود</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus>
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

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-success fw-bold py-2">تسجيل الدخول</button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted">ليس لديك حساب؟</span>
                        <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">
                            إنشاء حساب جديد
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection