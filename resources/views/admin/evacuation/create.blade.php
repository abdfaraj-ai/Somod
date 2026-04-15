@extends('layouts.admin')

@section('title', 'إضافة بلوك جديد')
@section('page-title', 'إضافة بلوك جديد')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.evacuation.index') }}">خريطة الإخلاء</a></li>
<li class="breadcrumb-item active">إضافة جديد</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.evacuation.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.evacuation.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم البلوك *</label>
                            <input type="text" name="block_number" class="form-control @error('block_number') is-invalid @enderror" 
                                   value="{{ old('block_number') }}" required placeholder="مثال: 2301, A15, B7">
                            @error('block_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">المنطقة *</label>
                            <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" 
                                   value="{{ old('area') }}" required placeholder="مثال: شمال غزة، خانيونس">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الحالة *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر الحالة...</option>
                                <option value="safe" {{ old('status') == 'safe' ? 'selected' : '' }}>آمن</option>
                                <option value="warning" {{ old('status') == 'warning' ? 'selected' : '' }}>تحذير</option>
                                <option value="danger" {{ old('status') == 'danger' ? 'selected' : '' }}>خطر</option>
                                <option value="evacuation" {{ old('status') == 'evacuation' ? 'selected' : '' }}>إخلاء فوري</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">مصدر التحديث *</label>
                            <select name="update_source" class="form-select @error('update_source') is-invalid @enderror" required>
                                <option value="official" {{ old('update_source') == 'official' ? 'selected' : '' }}>رسمي</option>
                                <option value="community" {{ old('update_source') == 'community' ? 'selected' : '' }}>مجتمعي</option>
                                <option value="system" {{ old('update_source') == 'system' ? 'selected' : '' }}>نظام</option>
                            </select>
                            @error('update_source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">الوصف</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" placeholder="وصف حالة البلوك...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">تعليمات الإخلاء</label>
                            <textarea name="instructions" class="form-control" 
                                      rows="2" placeholder="تعليمات للمواطنين في حالة الإخلاء...">{{ old('instructions') }}</textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">إحداثيات الخريطة (JSON)</label>
                            <textarea name="coordinates" class="form-control" 
                                      rows="2" placeholder='{"lat": 31.5, "lng": 34.5}'>{{ old('coordinates') }}</textarea>
                            <small class="text-muted">إحداثيات البلوك على الخريطة بصيغة JSON</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">عدد السكان المقدر</label>
                            <input type="number" name="population" class="form-control" 
                                   value="{{ old('population') }}" min="0" placeholder="عدد السكان">
                        </div>
                        
                        <!-- Services -->
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold">الخدمات المتاحة</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="has_shelter" 
                                               id="has_shelter" {{ old('has_shelter') ? 'checked' : '' }} value="1">
                                        <label class="form-check-label" for="has_shelter">ملاجئ</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="has_medical" 
                                               id="has_medical" {{ old('has_medical') ? 'checked' : '' }} value="1">
                                        <label class="form-check-label" for="has_medical">خدمات طبية</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="has_water" 
                                               id="has_water" {{ old('has_water') ? 'checked' : '' }} value="1">
                                        <label class="form-check-label" for="has_water">مياه</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> حفظ البلوك
                        </button>
                        <a href="{{ route('admin.evacuation.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection