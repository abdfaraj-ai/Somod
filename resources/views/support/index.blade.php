@extends('layouts.app')

@section('title', 'الدعم النفسي - منصة صمود')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="hero-section text-center mb-5 shadow rounded-4 p-4 p-lg-5 bg-success text-white">
        <h1 class="fw-bold display-5 mb-3"><i class="bi bi-chat-heart-fill me-2"></i>الدعم النفسي والاجتماعي</h1>
        <p class="lead opacity-90 mb-0">مساحة آمنة للدعم النفسي، تمارين الاسترخاء، والتواصل مع المختصين.</p>
    </div>

    <!-- Emergency Hotlines -->
    @if(isset($hotlines) && $hotlines->count() > 0)
    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-5">
        <div class="d-flex align-items-center">
            <i class="bi bi-telephone-plus fs-2 me-3"></i>
            <div class="flex-grow-1">
                <h5 class="fw-bold mb-2">خطوط الطوارئ النفسية</h5>
                <div class="row g-3">
                    @foreach($hotlines as $hotline)
                    <div class="col-md-4">
                        <div class="bg-white bg-opacity-25 p-3 rounded-3">
                            <h6 class="fw-bold mb-1">{{ $hotline->title }}</h6>
                            @if($hotline->phone)
                            <div class="d-flex justify-content-between align-items-center">
                                <small>{{ $hotline->phone }}</small>
                                <a href="tel:{{ $hotline->phone }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-telephone"></i>
                                </a>
                            </div>
                            @endif
                            @if($hotline->whatsapp)
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small>{{ $hotline->whatsapp }}</small>
                                <a href="https://wa.me/{{ $hotline->whatsapp }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Categories Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex gap-2 overflow-auto pb-2 no-scrollbar justify-content-md-center">
                @foreach($categories as $key => $cat)
                <a href="{{ route('support.index', ['category' => $key]) }}" 
                   class="btn {{ $category == $key ? 'btn-dark' : 'btn-outline-success' }} filter-btn">
                    {{ $cat['name'] }} ({{ $cat['count'] }})
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Support Services List -->
        <div class="col-lg-8">
            @if($supports->count() > 0)
            <div id="support-grid" class="row g-3">
                @foreach($supports as $support)
                <div class="col-md-6">
                    <div class="card support-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-{{ $support->category_color }} text-white rounded-circle p-2 me-3">
                                    <i class="bi {{ $support->category_icon }} fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">{{ $support->title }}</h5>
                                    <div class="d-flex gap-1">
                                        <small class="text-muted">{{ $support->category_arabic }}</small>
                                        @if($support->is_free)
                                        <small class="badge bg-success">مجاني</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-muted small mb-3">{{ Str::limit($support->description, 100) }}</p>
                            
                            <!-- Specialties -->
                            @if($support->specialties_array)
                            <div class="mb-3">
                                @foreach($support->specialties_array as $specialty)
                                <span class="badge bg-light text-dark me-1 mb-1">{{ $specialty }}</span>
                                @endforeach
                            </div>
                            @endif
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-eye text-muted me-1"></i>
                                    <small class="text-muted">{{ $support->views }} مشاهدة</small>
                                </div>
                                <a href="{{ route('support.show', $support->id) }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-eye"></i> عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-chat-heart display-1 text-muted"></i>
                <h5 class="mt-3">لا توجد خدمات دعم</h5>
                <p class="text-muted">لم يتم إضافة أي خدمات دعم بعد في هذه الفئة</p>
            </div>
            @endif
        </div>

        <!-- Quick Help & Resources -->
        <div class="col-lg-4">
            <!-- Breathing Exercise -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-3"><i class="bi bi-wind text-primary me-2"></i>تمرين التنفس العميق</h5>
                    <p class="text-muted small mb-4">يساعد هذا التمرين على تقليل التوتر والقلق في دقيقة واحدة.</p>
                    
                    <div id="breathing-circle" class="breathing-circle mb-4 mx-auto" style="width: 120px; height: 120px;">
                        <span id="breath-text">استعد</span>
                    </div>
                    
                    <button class="btn btn-outline-primary rounded-pill px-4" id="btn-breath" onclick="toggleBreathing()">بدء التمرين</button>

                </div>
            </div>

            <!-- Quick Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>نصائح سريعة</h5>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 py-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>خذ نفساً عميقاً عند الشعور بالقلق</small>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>تواصل مع شخص تثق به</small>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>خصص وقتاً للراحة والاسترخاء</small>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>مارس تمارين الاسترخاء بانتظام</small>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <a href="{{ route('support.exercises') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-play-circle me-2"></i> تمارين استرخاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .support-card {
        transition: transform 0.3s;
    }
    
    .support-card:hover {
        transform: translateY(-5px);
    }
    
    .filter-btn {
        white-space: nowrap;
        border-radius: 50px;
        padding: 8px 20px;
    }
    
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    
    .breathing-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-color: #e8f5e9;
        border: 3px solid #4caf50;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 1s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    let breathingInterval;
    let isBreathing = false;
    
    function startBreathingExercise() {
        const circle = document.getElementById('breathing-circle');
        const text = document.getElementById('breath-text');
        const button = document.getElementById('btn-breath');
        
        if (!isBreathing) {
            isBreathing = true;
            button.innerHTML = '<i class="bi bi-pause me-2"></i> إيقاف التمرين';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-primary');
            
            let phase = 0;
            breathingInterval = setInterval(() => {
                phase = (phase + 1) % 4;
                
                switch(phase) {
                    case 0: // شهيق
                        circle.style.transform = 'scale(1.2)';
                        circle.style.backgroundColor = '#c8e6c9';
                        text.textContent = 'شهيق';
                        break;
                    case 1: // احتفاظ
                        circle.style.transform = 'scale(1.2)';
                        circle.style.backgroundColor = '#a5d6a7';
                        text.textContent = 'احتفظ';
                        break;
                    case 2: // زفير
                        circle.style.transform = 'scale(1)';
                        circle.style.backgroundColor = '#81c784';
                        text.textContent = 'زفير';
                        break;
                    case 3: // استرخاء
                        circle.style.transform = 'scale(1)';
                        circle.style.backgroundColor = '#e8f5e9';
                        text.textContent = 'استرخ';
                        break;
                }
            }, 4000); // 4 ثوان لكل مرحلة
        } else {
            stopBreathingExercise();
        }
    }
    
    function stopBreathingExercise() {
        clearInterval(breathingInterval);
        isBreathing = false;
        
        const circle = document.getElementById('breathing-circle');
        const text = document.getElementById('breath-text');
        const button = document.getElementById('btn-breath');
        
        circle.style.transform = 'scale(1)';
        circle.style.backgroundColor = '#e8f5e9';
        text.textContent = 'استعد';
        
        button.innerHTML = '<i class="bi bi-play me-2"></i> بدء التمرين';
        button.classList.remove('btn-primary');
        button.classList.add('btn-outline-primary');
    }
    
    // توقف التمرين تلقائياً بعد 5 دقائق
    setTimeout(() => {
        if (isBreathing) {
            stopBreathingExercise();
            alert('تم إكمال جلسة التنفس بنجاح!');
        }
    }, 5 * 60 * 1000);
</script>
@endpush