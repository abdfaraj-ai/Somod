@extends('layouts.app')

@section('title', $service->name . ' - دليل الخدمات')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">دليل الخدمات</a></li>
            <li class="breadcrumb-item active">{{ $service->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Service Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-{{ $service->category_color }} text-white rounded-circle p-3 me-3">
                            <i class="bi {{ $service->category_icon }} fs-1"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-2">{{ $service->name }}</h1>
                            <div class="d-flex gap-2">
                                <span class="badge bg-{{ $service->category_color }}">
                                    {{ $service->category_arabic }}
                                </span>
                                @if($service->verified)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> خدمة موثوقة
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">الوصف</h5>
                        <p class="lead">{{ $service->description }}</p>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold"><i class="bi bi-geo-alt text-primary me-2"></i>العنوان</h6>
                                    <p class="mb-0">{{ $service->address }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($service->working_hours)
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold"><i class="bi bi-clock text-primary me-2"></i>أوقات العمل</h6>
                                    <p class="mb-0">{{ $service->working_hours }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">معلومات التواصل</h5>
                        <div class="row g-3">
                            @if($service->phone)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-primary text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الهاتف</small>
                                        <h6 class="mb-0">{{ $service->phone }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($service->whatsapp)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الواتساب</small>
                                        <h6 class="mb-0">{{ $service->whatsapp }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($service->email)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-info text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">البريد الإلكتروني</small>
                                        <h6 class="mb-0">{{ $service->email }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($service->website)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-dark text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الموقع الإلكتروني</small>
                                        <h6 class="mb-0">
                                            <a href="{{ $service->website }}" target="_blank" class="text-decoration-none">
                                                زيارة الموقع
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        @if($service->phone)
                        <a href="tel:{{ $service->phone }}" class="btn btn-primary">
                            <i class="bi bi-telephone me-2"></i> اتصل الآن
                        </a>
                        @endif
                        
                        @if($service->whatsapp)
                        <a href="https://wa.me/{{ $service->whatsapp }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-whatsapp me-2"></i> واتساب
                        </a>
                        @endif
                        
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i> طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Services - التعديل هنا -->
        <div class="col-lg-4">
            <!-- تأكد من وجود المتغير relatedServices -->
            @isset($relatedServices)
                @if($relatedServices->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">خدمات مشابهة</h5>
                    </div>
                    <div class="card-body">
                        @foreach($relatedServices as $related)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-{{ $related->category_color }} text-white rounded-circle p-2 me-3">
                                    <i class="bi {{ $related->category_icon }}"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $related->name }}</h6>
                                    <p class="text-muted small mb-2">{{ Str::limit($related->address, 40) }}</p>
                                    <a href="{{ route('services.show', $related->id) }}" class="btn btn-sm btn-outline-primary">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endisset
            
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">معلومات الخدمة</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>تاريخ الإضافة</span>
                        <span class="fw-bold">{{ $service->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>آخر تحديث</span>
                        <span class="fw-bold">{{ $service->updated_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>حالة الخدمة</span>
                        <span class="badge bg-{{ $service->status == 'active' ? 'success' : 'warning' }}">
                            {{ $service->status == 'active' ? 'نشطة' : 'معطلة' }}
                        </span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <button class="btn btn-outline-danger w-100" onclick="reportService({{ $service->id }})">
                            <i class="bi bi-flag me-2"></i> الإبلاغ عن خطأ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function reportService(serviceId) {
        if (confirm('هل تريد الإبلاغ عن خطأ في معلومات هذه الخدمة؟')) {
            // هنا يمكن إضافة منطق الإبلاغ
            alert('شكراً لإبلاغك، سنقوم بمراجعة المعلومات قريباً.');
        }
    }
</script>
@endpush