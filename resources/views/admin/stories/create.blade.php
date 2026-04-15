@extends('layouts.admin')

@section('title', 'إضافة قصة جديدة')
@section('page-title', 'إضافة قصة جديدة')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}">قصص الصمود</a></li>
<li class="breadcrumb-item active">إضافة جديد</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">عنوان القصة *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">الفئة *</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر الفئة...</option>
                                <option value="resilience" {{ old('category') == 'resilience' ? 'selected' : '' }}>إرادة صلبة</option>
                                <option value="solidarity" {{ old('category') == 'solidarity' ? 'selected' : '' }}>تكافل اجتماعي</option>
                                <option value="innovation" {{ old('category') == 'innovation' ? 'selected' : '' }}>إبداع وتحدي</option>
                                <option value="heroes" {{ old('category') == 'heroes' ? 'selected' : '' }}>أبطال الميدان</option>
                                <option value="hope" {{ old('category') == 'hope' ? 'selected' : '' }}>أمل وتفاؤل</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">اسم المؤلف (اختياري)</label>
                            <input type="text" name="author_name" class="form-control" 
                                   value="{{ old('author_name') }}" placeholder="يمكن تركه فارغاً">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">موقع المؤلف *</label>
                            <input type="text" name="author_location" class="form-control @error('author_location') is-invalid @enderror" 
                                   value="{{ old('author_location') }}" required placeholder="مثال: شمال غزة، خانيونس">
                            @error('author_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">مقتطف القصة (اختياري)</label>
                            <textarea name="excerpt" class="form-control" rows="2" 
                                      placeholder="ملخص قصير للقصة يظهر في صفحة القصص الرئيسية">{{ old('excerpt') }}</textarea>
                            <small class="text-muted">يجب أن يكون بين 100-200 حرف</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">محتوى القصة *</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" 
                                      rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">اكتب القصة بالتفصيل. يمكنك استخدام الفقرات والعناوين الفرعية.</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">صورة القصة (اختياري)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">الحجم الأقصى: 2MB. الصيغ المقبولة: JPG, PNG, GIF</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الإعدادات</label>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" 
                                       id="is_featured" {{ old('is_featured') ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="is_featured">قصة مميزة</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_published" 
                                       id="is_published" {{ old('is_published') ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="is_published">نشر مباشرة</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> حفظ القصة
                        </button>
                        <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-light">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // حساب عدد الأحرف في المقتطف
    document.querySelector('textarea[name="excerpt"]').addEventListener('input', function() {
        const charCount = this.value.length;
        const helpText = this.nextElementSibling;
        
        if (charCount < 100) {
            helpText.textContent = `يجب أن يكون بين 100-200 حرف (${charCount}/100)`;
            helpText.className = 'text-muted';
        } else if (charCount > 200) {
            helpText.textContent = `تجاوزت الحد الأقصى (${charCount}/200)`;
            helpText.className = 'text-danger';
        } else {
            helpText.textContent = `مناسب (${charCount}/200)`;
            helpText.className = 'text-success';
        }
    });
</script>
@endpush