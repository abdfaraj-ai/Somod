@extends('layouts.app')

@section('title', 'تمارين الاسترخاء - الدعم النفسي')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('support.index') }}">الدعم النفسي</a></li>
            <li class="breadcrumb-item active">تمارين الاسترخاء</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="hero-section text-center mb-5 shadow rounded-4 p-4 p-lg-5 bg-primary text-white">
        <h1 class="fw-bold display-5 mb-3"><i class="bi bi-wind me-2"></i>تمارين الاسترخاء والتأمل</h1>
        <p class="lead opacity-90 mb-0">مجموعة من التمارين المسجلة لمساعدتك على الاسترخاء وتقليل التوتر.</p>
    </div>

    <!-- Breathing Exercise -->
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3"><i class="bi bi-wind text-primary me-2"></i>تمرين التنفس العميق</h3>
                    <p class="text-muted mb-4">هذا التمرين يساعد على تنظيم التنفس وتقليل التوتر خلال دقيقة واحدة فقط.</p>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">خطوات التمرين:</h6>
                        <ol class="text-muted">
                            <li class="mb-2">اجلس في وضع مريح مع استقامة الظهر</li>
                            <li class="mb-2">خذ نفساً عميقاً من الأنف لمدة 4 ثوان</li>
                            <li class="mb-2">احتفظ بالنفس لمدة 4 ثوان</li>
                            <li class="mb-2">أخرج النفس ببطء من الفم لمدة 6 ثوان</li>
                            <li>كرر التمرين 5 مرات</li>
                        </ol>
                    </div>
                    
                    <button class="btn btn-primary" onclick="startBreathingExercise()">
                        <i class="bi bi-play-circle me-2"></i> بدء التمرين
                    </button>
                </div>
                <div class="col-lg-6 text-center">
                    <div id="main-breathing-circle" class="breathing-circle-large mx-auto">
                        <span id="main-breath-text">استعد</span>
                    </div>
                    <div id="breathing-timer" class="mt-3 fw-bold fs-5 text-primary">00:00</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Exercises -->
    @if($exercises->count() > 0)
    <h3 class="fw-bold mb-4"><i class="bi bi-collection-play text-primary me-2"></i>تمارين إضافية</h3>
    <div class="row g-4">
        @foreach($exercises as $exercise)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="bi bi-play-circle-fill text-primary fs-1"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-center mb-2">{{ $exercise->title }}</h5>
                    <p class="text-muted small text-center mb-3">{{ Str::limit($exercise->description, 80) }}</p>
                    
                    @if($exercise->specialties_array)
                    <div class="text-center mb-3">
                        @foreach($exercise->specialties_array as $specialty)
                        <span class="badge bg-light text-dark me-1 mb-1">{{ $specialty }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="text-center">
                        <a href="{{ route('support.show', $exercise->id) }}" class="btn btn-outline-primary">
                            <i class="bi bi-play me-2"></i> تشغيل التمرين
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-wind display-1 text-muted"></i>
        <h5 class="mt-3">لا توجد تمارين متاحة</h5>
        <p class="text-muted">سيتم إضافة تمارين استرخاء قريباً</p>
    </div>
    @endif

    <!-- Tips Section -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-center mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>نصائح للاستفادة القصوى</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">اختر وقتاً هادئاً</h6>
                                    <p class="text-muted small mb-0">اختر وقتاً لا توجد فيه مشتقات</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">مكان مريح</h6>
                                    <p class="text-muted small mb-0">اجلس في مكان مريح وهادئ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">مارس بانتظام</h6>
                                    <p class="text-muted small mb-0">التكرار يساعد في تحسين النتائج</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">لا تتوقع الكمال</h6>
                                    <p class="text-muted small mb-0">تقبل أن كل جلسة مختلفة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .breathing-circle-large {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #e8f5e9;
        border: 5px solid #4caf50;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
        transition: all 1s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    let mainBreathingInterval;
    let mainIsBreathing = false;
    let timerSeconds = 0;
    let timerInterval;
    
    function startBreathingExercise() {
        const circle = document.getElementById('main-breathing-circle');
        const text = document.getElementById('main-breath-text');
        const timer = document.getElementById('breathing-timer');
        
        if (!mainIsBreathing) {
            mainIsBreathing = true;
            timerSeconds = 0;
            updateTimer(timer);
            
            // Start timer
            timerInterval = setInterval(() => {
                timerSeconds++;
                updateTimer(timer);
            }, 1000);
            
            let phase = 0;
            mainBreathingInterval = setInterval(() => {
                phase = (phase + 1) % 4;
                
                switch(phase) {
                    case 0: // شهيق
                        circle.style.transform = 'scale(1.2)';
                        circle.style.backgroundColor = '#c8e6c9';
                        circle.style.borderColor = '#2e7d32';
                        text.textContent = 'شهيق (4 ثوان)';
                        break;
                    case 1: // احتفاظ
                        circle.style.transform = 'scale(1.2)';
                        circle.style.backgroundColor = '#a5d6a7';
                        circle.style.borderColor = '#1b5e20';
                        text.textContent = 'احتفظ (4 ثوان)';
                        break;
                    case 2: // زفير
                        circle.style.transform = 'scale(1)';
                        circle.style.backgroundColor = '#81c784';
                        circle.style.borderColor = '#388e3c';
                        text.textContent = 'زفير (6 ثوان)';
                        break;
                    case 3: // استرخاء
                        circle.style.transform = 'scale(1)';
                        circle.style.backgroundColor = '#e8f5e9';
                        circle.style.borderColor = '#4caf50';
                        text.textContent = 'استرخ (2 ثانية)';
                        break;
                }
            }, 4000); // 4 ثوان لكل مرحلة
            
            // Stop after 5 minutes
            setTimeout(() => {
                if (mainIsBreathing) {
                    stopBreathingExercise();
                    alert('تهانينا! أكملت جلسة التنفس بنجاح.');
                }
            }, 5 * 60 * 1000);
        } else {
            stopBreathingExercise();
        }
    }
    
    function stopBreathingExercise() {
        clearInterval(mainBreathingInterval);
        clearInterval(timerInterval);
        mainIsBreathing = false;
        
        const circle = document.getElementById('main-breathing-circle');
        const text = document.getElementById('main-breath-text');
        
        circle.style.transform = 'scale(1)';
        circle.style.backgroundColor = '#e8f5e9';
        circle.style.borderColor = '#4caf50';
        text.textContent = 'استعد';
    }
    
    function updateTimer(timerElement) {
        const minutes = Math.floor(timerSeconds / 60);
        const seconds = timerSeconds % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
</script>
@endpush