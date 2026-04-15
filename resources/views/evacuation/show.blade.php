@extends('layouts.app')

@section('title', 'بلوك ' . $block->block_number . ' - خريطة الإخلاء')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('evacuation.index') }}">خريطة الإخلاء</a></li>
            <li class="breadcrumb-item active">بلوك {{ $block->block_number }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Block Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $block->status_color }} text-white rounded-circle p-3 me-3">
                                <i class="bi {{ $block->status_icon }} fs-1"></i>
                            </div>
                            <div>
                                <h1 class="fw-bold mb-1">بلوك {{ $block->block_number }}</h1>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-{{ $block->status_color }}">
                                        {{ $block->status_arabic }}
                                    </span>
                                    <span class="badge bg-secondary">
                                        {{ $block->area }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Emergency Button -->
                        @if($block->needs_evacuation)
                        <div class="alert alert-danger border-0 rounded-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>انتباه:</strong> هذه منطقة تحتاج لإخلاء فوري
                        </div>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h5>
                        <p class="lead">{{ $block->description ?? 'لا يوجد وصف متاح' }}</p>
                    </div>
                    
                    <!-- Instructions -->
                    @if($block->instructions)
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-info-square text-primary me-2"></i>تعليمات الإخلاء</h5>
                        <div class="alert alert-info border-0 rounded-4">
                            <i class="bi bi-lightbulb me-2"></i>
                            {{ $block->instructions }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Services -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-gear text-primary me-2"></i>الخدمات المتاحة</h5>
                        <div class="row g-3">
                            @if($block->has_shelter)
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-house-heart text-success fs-1 mb-2"></i>
                                        <h6 class="fw-bold">ملاجئ</h6>
                                        <small class="text-muted">ملاجئ متاحة</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($block->has_medical)
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-heart-pulse text-danger fs-1 mb-2"></i>
                                        <h6 class="fw-bold">خدمات طبية</h6>
                                        <small class="text-muted">رعاية صحية</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($block->has_water)
                            <div class="col-md-4">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-droplet text-info fs-1 mb-2"></i>
                                        <h6 class="fw-bold">مياه</h6>
                                        <small class="text-muted">مياه صالحة للشرب</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-people text-primary fs-1 mb-2"></i>
                                    <h4 class="fw-bold">{{ $block->population ?? 'غير معروف' }}</h4>
                                    <p class="text-muted mb-0">عدد السكان المقدر</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-clock-history text-primary fs-1 mb-2"></i>
                                    <h4 class="fw-bold">{{ $block->last_updated ? $block->last_updated->format('H:i') : '--:--' }}</h4>
                                    <p class="text-muted mb-0">آخر تحديث</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-source text-primary fs-1 mb-2"></i>
                                    <h6 class="fw-bold">{{ $block->update_source_arabic }}</h6>
                                    <p class="text-muted mb-0">مصدر التحديث</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Report Status Form -->
                    @auth
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="bi bi-flag text-primary me-2"></i>تحديث حالة البلوك</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('evacuation.update-status', $block->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الحالة الجديدة</label>
                                        <select name="status" class="form-select">
                                            <option value="safe" {{ $block->status == 'safe' ? 'selected' : '' }}>آمن</option>
                                            <option value="warning" {{ $block->status == 'warning' ? 'selected' : '' }}>تحذير</option>
                                            <option value="danger" {{ $block->status == 'danger' ? 'selected' : '' }}>خطر</option>
                                            <option value="evacuation" {{ $block->status == 'evacuation' ? 'selected' : '' }}>إخلاء فوري</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">ملاحظات</label>
                                        <textarea name="description" class="form-control" rows="1" placeholder="سبب التحديث..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-2"></i> إرسال التحديث
                                        </button>
                                        <small class="text-muted ms-3">سيتم مراجعة تحديثات المجتمع</small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info border-0 rounded-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <a href="{{ route('login') }}" class="text-decoration-none">سجّل الدخول</a> لتحديث حالة البلوك
                    </div>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Neighbor Blocks -->
        <div class="col-lg-4">
            <!-- Nearby Blocks -->
            @if($neighborBlocks->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">البلوكات المجاورة</h5>
                </div>
                <div class="card-body">
                    @foreach($neighborBlocks as $neighbor)
                    <a href="{{ route('evacuation.show', $neighbor->id) }}" class="text-decoration-none">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">بلوك {{ $neighbor->block_number }}</h6>
                                    <small class="text-muted">{{ $neighbor->area }}</small>
                                </div>
                                <span class="badge bg-{{ $neighbor->status_color }}">
                                    {{ $neighbor->status_arabic }}
                                </span>
                            </div>
                            @if($neighbor->description)
                            <small class="text-muted d-block mt-2">{{ Str::limit($neighbor->description, 60) }}</small>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Quick Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">معلومات سريعة</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>رقم البلوك</span>
                        <span class="fw-bold">{{ $block->block_number }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>المنطقة</span>
                        <span class="fw-bold">{{ $block->area }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>تاريخ الإضافة</span>
                        <span class="fw-bold">{{ $block->created_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>آخر تحديث</span>
                        <span class="fw-bold">{{ $block->updated_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Emergency Actions -->
                    <div class="text-center">
                        <button class="btn btn-outline-danger w-100 mb-2" onclick="shareLocation()">
                            <i class="bi bi-share me-2"></i> مشاركة الموقع
                        </button>
                        
                        <button class="btn btn-outline-primary w-100" onclick="printPage()">
                            <i class="bi bi-printer me-2"></i> طباعة المعلومات
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
    function shareLocation() {
        if (navigator.share) {
            navigator.share({
                title: 'حالة بلوك {{ $block->block_number }}',
                text: 'بلوك {{ $block->block_number }} في {{ $block->area }} - الحالة: {{ $block->status_arabic }}',
                url: window.location.href
            });
        } else {
            alert('شارك الرابط: ' + window.location.href);
        }
    }
    
    function printPage() {
        window.print();
    }
</script>
@endpush