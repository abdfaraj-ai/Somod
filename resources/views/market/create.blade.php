@extends('layouts.app')

@section('title', 'إضافة سلعة جديدة - السوق المركزي')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('market.index') }}">السوق المركزي</a></li>
            <li class="breadcrumb-item active">إضافة سلعة</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-plus-lg fs-2"></i>
                        </div>
                        <h3 class="fw-bold">إضافة سلعة جديدة</h3>
                        <p class="text-muted">شارك معلومات عن السلع المتوفرة في منطقتك</p>
                    </div>

                    <form action="{{ route('market.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">اسم السلعة *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required placeholder="مثال: ربطة خبز، غاز طهي">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">السعر (شيكل)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" step="0.01" min="0" placeholder="مثال: 10.5">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">الفئة *</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>اختر الفئة...</option>
                                    <option value="food" {{ old('type') == 'food' ? 'selected' : '' }}>مواد غذائية</option>
                                    <option value="energy" {{ old('type') == 'energy' ? 'selected' : '' }}>طاقة ووقود</option>
                                    <option value="medical" {{ old('type') == 'medical' ? 'selected' : '' }}>صحة وأدوية</option>
                                    <option value="services" {{ old('type') == 'services' ? 'selected' : '' }}>خدمات</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">حالة التوفر *</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="" disabled selected>اختر الحالة...</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متوفر بكثرة</option>
                                    <option value="scarce" {{ old('status') == 'scarce' ? 'selected' : '' }}>شحيح / قليل</option>
                                    <option value="out" {{ old('status') == 'out' ? 'selected' : '' }}>غير متوفر</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">المكان *</label>
                                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                       value="{{ old('location') }}" required placeholder="مثال: سوق النصيرات - بسطة أبو محمد">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">ملاحظات إضافية</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3" placeholder="تفاصيل إضافية عن السلعة...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-info border-0 rounded-4 mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>سيتم مراجعة السلعة من قبل المسؤول قبل نشرها للتأكد من دقة المعلومات.</small>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i> إضافة السلعة
                            </button>
                            <a href="{{ route('market.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection