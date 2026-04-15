@extends('layouts.app')

@section('title', $support->title . ' - الدعم النفسي')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('support.index') }}">الدعم النفسي</a></li>
            <li class="breadcrumb-item active">{{ $support->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Support Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-{{ $support->category_color }} text-white rounded-circle p-3 me-3">
                            <i class="bi {{ $support->category_icon }} fs-1"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-2">{{ $support->title }}</h1>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-{{ $support->category_color }}">
                                    {{ $support->category_arabic }}
                                </span>
                                @if($support->is_free)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> مجاني
                                </span>
                                @endif
                                @if($support->verified)
                                <span class="badge bg-primary">
                                    <i class="bi bi-shield-check"></i> موثوق
                                </span>
                                @endif
                                <span class="badge bg-secondary">
                                    {{ $support->language_arabic }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h5>
                        <p class="lead">{{ $support->description }}</p>
                    </div>
                    
                    <!-- Specialties -->
                    @if($support->specialties_array)
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-star text-primary me-2"></i>التخصصات</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($support->specialties_array as $specialty)
                            <span class="badge bg-light text-dark border">{{ $specialty }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-telephone text-primary me-2"></i>معلومات التواصل</h5>
                        <div class="row g-3">
                            @if($support->phone)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-primary text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الهاتف</small>
                                        <h6 class="mb-0">{{ $support->phone }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($support->whatsapp)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الواتساب</small>
                                        <h6 class="mb-0">{{ $support->whatsapp }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($support->email)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-info text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">البريد الإلكتروني</small>
                                        <h6 class="mb-0">{{ $support->email }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($support->website)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-dark text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">الموقع الإلكتروني</small>
                                        <h6 class="mb-0">
                                            <a href="{{ $support->website }}" target="_blank" class="text-decoration-none">
                                                زيارة الموقع
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($support->working_hours)
                            <div class="col-12">
                                <div class="d-flex align-items-center p-3 border rounded-3">
                                    <div class="bg-warning text-white rounded-circle p-2 me-3">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">أوقات العمل</small>
                                        <h6 class="mb-0">{{ $support->working_hours }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        @if($support->phone)
                        <a href="tel:{{ $support->phone }}" class="btn btn-primary">
                            <i class="bi bi-telephone me-2"></i> اتصل الآن
                        </a>
                        @endif
                        
                        @if($support->whatsapp)
                        <a href="https://wa.me/{{ $support->whatsapp }}" target="_blank" class="btn btn-success">
                            <i class="bi bi-whatsapp me-2"></i> واتساب
                        </a>
                        @endif
                        
                        @if($support->email)
                        <a href="mailto:{{ $support->email }}" class="btn btn-info text-white">
                            <i class="bi bi-envelope me-2"></i> إرسال بريد
                        </a>
                        @endif
                        
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i> طباعة
                        </button>
                        
                        <button class="btn btn-outline-primary" onclick="shareSupport()">
                            <i class="bi bi-share me-2"></i> مشاركة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Supports & Info -->
        <div class="col-lg-4">
            <!-- Related Supports -->
            @isset($relatedSupports)
                @if($relatedSupports->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">خدمات دعم مشابهة</h5>
                    </div>
                    <div class="card-body">
                        @foreach($relatedSupports as $related)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-{{ $related->category_color }} text-white rounded-circle p-2 me-3">
                                    <i class="bi {{ $related->category_icon }}"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $related->title }}</h6>
                                    <div class="d-flex gap-1 mb-2">
                                        <small class="text-muted">{{ $related->category_arabic }}</small>
                                        @if($related->is_free)
                                        <small class="badge bg-success">مجاني</small>
                                        @endif
                                    </div>
                                    <a href="{{ route('support.show', $related->id) }}" class="btn btn-sm btn-outline-primary">
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
                        <span>عدد المشاهدات</span>
                        <span class="fw-bold">{{ $support->views }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>التصنيف</span>
                        <span class="badge bg-{{ $support->category_color }}">
                            {{ $support->category_arabic }}
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>اللغة</span>
                        <span class="fw-bold">{{ $support->language_arabic }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>المجانية</span>
                        <span class="fw-bold">{{ $support->is_free ? 'مجاني' : 'مدفوع' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>حالة الخدمة</span>
                        <span class="badge bg-{{ $support->status == 'active' ? 'success' : 'warning' }}">
                            {{ $support->status == 'active' ? 'نشطة' : 'معطلة' }}
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>تاريخ الإضافة</span>
                        <span class="fw-bold">{{ $support->created_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Report Button -->
                    <div class="text-center">
                        <button class="btn btn-outline-danger w-100 mb-2" onclick="reportSupport({{ $support->id }})">
                            <i class="bi bi-flag me-2"></i> الإبلاغ عن خطأ
                        </button>
                        
                        <button class="btn btn-outline-success w-100" onclick="saveToFavorites({{ $support->id }})">
                            <i class="bi bi-bookmark me-2"></i> حفظ في المفضلة
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
    function shareSupport() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $support->title }}',
                text: '{{ Str::limit($support->description, 100) }}',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent('{{ $support->title }} - ' + window.location.href)}`;
            window.open(shareUrl, '_blank');
        }
    }
    
    function reportSupport(supportId) {
        if (confirm('هل تريد الإبلاغ عن خطأ في معلومات هذه الخدمة؟')) {
            // Here you can add logic to report the support service
            alert('شكراً لإبلاغك، سنقوم بمراجعة المعلومات قريباً.');
        }
    }
    
    function saveToFavorites(supportId) {
        // Save to localStorage as a simple favorites system
        let favorites = JSON.parse(localStorage.getItem('support_favorites') || '[]');
        
        if (!favorites.includes(supportId)) {
            favorites.push(supportId);
            localStorage.setItem('support_favorites', JSON.stringify(favorites));
            alert('تم إضافة الخدمة إلى المفضلة.');
        } else {
            alert('الخدمة موجودة بالفعل في المفضلة.');
        }
    }
    
    // Check if service is in favorites
    document.addEventListener('DOMContentLoaded', function() {
        let favorites = JSON.parse(localStorage.getItem('support_favorites') || '[]');
        const supportId = {{ $support->id }};
        
        if (favorites.includes(supportId)) {
            const saveBtn = document.querySelector('button[onclick*="saveToFavorites"]');
            if (saveBtn) {
                saveBtn.innerHTML = '<i class="bi bi-bookmark-check me-2"></i> محفوظة في المفضلة';
                saveBtn.classList.remove('btn-outline-success');
                saveBtn.classList.add('btn-success');
                saveBtn.onclick = function() {
                    removeFromFavorites(supportId);
                };
            }
        }
    });
    
    function removeFromFavorites(supportId) {
        let favorites = JSON.parse(localStorage.getItem('support_favorites') || '[]');
        favorites = favorites.filter(id => id !== supportId);
        localStorage.setItem('support_favorites', JSON.stringify(favorites));
        alert('تم إزالة الخدمة من المفضلة.');
        location.reload();
    }
</script>
@endpush