    @extends('layouts.admin')

@section('title', 'تعديل خدمة')
@section('page-title', 'تعديل خدمة: ' . $service->name)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">الخدمات</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.services.show', $service->id) }}">{{ $service->name }}</a></li>
<li class="breadcrumb-item active">تعديل</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-secondary">
    <i class="bi bi-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">اسم الخدمة *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $service->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الفئة *</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="" disabled>اختر الفئة...</option>
                                <option value="medical" {{ old('category', $service->category) == 'medical' ? 'selected' : '' }}>طبي</option>
                                <option value="shelter" {{ old('category', $service->category) == 'shelter' ? 'selected' : '' }}>إيواء</option>
                                <option value="edu" {{ old('category', $service->category) == 'edu' ? 'selected' : '' }}>تعليم</option>
                                <option value="org" {{ old('category', $service->category) == 'org' ? 'selected' : '' }}>مؤسسات</option>
                                <option value="water" {{ old('category', $service->category) == 'water' ? 'selected' : '' }}>مياه</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">الوصف *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">العنوان *</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address', $service->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $service->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">رقم الواتساب</label>
                            <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" 
                                   value="{{ old('whatsapp', $service->whatsapp) }}">
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $service->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الموقع الإلكتروني</label>
                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" 
                                   value="{{ old('website', $service->website) }}" placeholder="https://">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">أوقات العمل (اختياري)</label>
                            <textarea name="working_hours" class="form-control" rows="2"
                                      placeholder="مثال: من الأحد إلى الخميس: 8 صباحاً - 4 مساءً">{{ old('working_hours', $service->working_hours) }}</textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">الحالة *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $service->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('status', $service->status) == 'inactive' ? 'selected' : '' }}>معطل</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">حالة التحقق</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="verified" id="verified" 
                                       {{ old('verified', $service->verified) ? 'checked' : '' }} value="1">
                                <label class="form-check-label" for="verified">متحقق</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.services.show', $service->id) }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection