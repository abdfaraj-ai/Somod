@extends('layouts.admin')

@section('title', 'إضافة خدمة دعم جديدة')
@section('page-title', 'إضافة خدمة دعم جديدة')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.support.index') }}">الدعم النفسي</a></li>
<li class="breadcrumb-item active">إضافة جديد</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.support.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.support.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">عنوان الخدمة *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" required placeholder="مثال: خط الدعم النفسي">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الفئة *</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="" disabled selected>اختر الفئة...</option>
                                <option value="therapy" {{ old('category') == 'therapy' ? 'selected' : '' }}>جلسات علاجية</option>
                                <option value="hotline" {{ old('category') == 'hotline' ? 'selected' : '' }}>خطوط مساندة</option>
                                <option value="exercise" {{ old('category') == 'exercise' ? 'selected' : '' }}>تمارين استرخاء</option>
                                <option value="advice" {{ old('category') == 'advice' ? 'selected' : '' }}>نصائح وإرشادات</option>
                                <option value="group" {{ old('category') == 'group' ? 'selected' : '' }}>مجموعات دعم</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">الوصف *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" required placeholder="وصف مفصل للخدمة...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}" placeholder="رقم للتواصل">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم الواتساب</label>
                            <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" 
                                   value="{{ old('whatsapp') }}" placeholder="رقم واتساب">
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الموقع الإلكتروني</label>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" 
                                   value="{{ old('website') }}" placeholder="https://">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">أوقات العمل</label>
                            <input type="text" name="working_hours" class="form-control" 
                                   value="{{ old('working_hours') }}" placeholder="مثال: 24 ساعة، أو من 9 صباحاً إلى 5 مساءً">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">اللغة *</label>
                            <select name="language" class="form-select @error('language') is-invalid @enderror" required>
                                <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>عربي</option>
                                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>إنجليزي</option>
                                <option value="both" {{ old('language') == 'both' ? 'selected' : '' }}>العربية والإنجليزية</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">التكلفة</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_free" id="is_free" 
                                       {{ old('is_free', true) ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="is_free">خدمة مجانية</label>
                            </div>
                        </div>
                        
                        <!-- Specialties -->
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">التخصصات (اختياري)</label>
                            <div class="row g-2">
                                @php
                                    $commonSpecialties = ['قلق', 'اكتئاب', 'توتر', 'صدمة', 'إدمان', 'علاقات أسرية', 'إرشاد تربوي', 'دعم أطفال'];
                                @endphp
                                @foreach($commonSpecialties as $specialty)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="specialties[]" 
                                               value="{{ $specialty }}" id="spec_{{ $loop->index }}"
                                               {{ in_array($specialty, old('specialties', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="spec_{{ $loop->index }}">
                                            {{ $specialty }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                
                                <div class="col-12 mt-2">
                                    <input type="text" class="form-control" 
                                           placeholder="أضف تخصصات أخرى (افصل بينها بفاصلة)" 
                                           onchange="addCustomSpecialties(this)">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الحالة *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">حالة التحقق</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="verified" id="verified" 
                                       {{ old('verified') ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="verified">متحقق</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-2"></i> حفظ خدمة الدعم
                        </button>
                        <a href="{{ route('admin.support.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addCustomSpecialties(input) {
        const value = input.value.trim();
        if (!value) return;
        
        const specialties = value.split(',').map(s => s.trim()).filter(s => s);
        const container = input.closest('.row');
        
        specialties.forEach(specialty => {
            const id = 'spec_custom_' + Date.now();
            const html = `
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="specialties[]" 
                               value="${specialty}" id="${id}" checked>
                        <label class="form-check-label" for="${id}">
                            ${specialty}
                        </label>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', html);
        });
        
        input.value = '';
    }
</script>
@endpush