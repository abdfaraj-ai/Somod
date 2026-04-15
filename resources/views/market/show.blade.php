@extends('layouts.app')

@section('title', $item->name . ' - السوق المحلي')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('market.index') }}">السوق المحلي</a></li>
            <li class="breadcrumb-item active">{{ $item->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Item Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-light rounded-circle p-3 me-3">
                            <i class="bi {{ $item->category_icon }} fs-1 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h1 class="fw-bold mb-2">{{ $item->name }}</h1>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-dark">{{ $item->category_arabic }}</span>
                                <span class="badge bg-{{ $item->availability_color }}">
                                    {{ $item->availability_arabic }}
                                </span>
                                @if($item->is_urgent)
                                <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill"></i> عاجل</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Price Section -->
                    <div class="mb-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center py-4">
                                @if($item->price)
                                <h2 class="fw-bold text-success display-4">{{ number_format($item->price) }} شيكل</h2>
                                @if($item->unit)
                                <p class="text-muted">لل{{ $item->unit }}</p>
                                @endif
                                @else
                                <h4 class="fw-bold text-muted">بدون سعر محدد</h4>
                                <p class="text-muted">تواصل مع البائع للتفاوض على السعر</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h5>
                        <p class="lead">{{ $item->description ?? 'لا يوجد وصف متاح' }}</p>
                    </div>
                    
                    <!-- Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold"><i class="bi bi-geo-alt text-primary me-2"></i>الموقع</h6>
                                    <p class="mb-0">{{ $item->location }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($item->quantity)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="fw-bold"><i class="bi bi-box text-primary me-2"></i>الكمية المتوفرة</h6>
                                    <p class="mb-0">{{ $item->quantity }} {{ $item->unit ?? 'وحدة' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Contact Info -->
                    @if($item->contact_info)
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-telephone text-primary me-2"></i>معلومات الاتصال</h5>
                        <div class="alert alert-info border-0">
                            <i class="bi bi-info-circle me-2"></i>
                            {{ $item->contact_info }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-primary" onclick="contactSeller()">
                            <i class="bi bi-chat-dots me-2"></i> تواصل مع البائع
                        </button>
                        <button class="btn btn-outline-secondary" onclick="shareItem()">
                            <i class="bi bi-share me-2"></i> مشاركة
                        </button>
                        <button class="btn btn-outline-danger" onclick="reportItem()">
                            <i class="bi bi-flag me-2"></i> الإبلاغ
                        </button>
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i> طباعة
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">معلومات السلعة</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>تاريخ الإضافة</span>
                        <span class="fw-bold">{{ $item->created_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>آخر تحديث</span>
                        <span class="fw-bold">{{ $item->updated_at->format('Y-m-d') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>عدد المشاهدات</span>
                        <span class="fw-bold">{{ $item->views }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>حالة السلعة</span>
                        <span class="badge bg-{{ $item->availability_color }}">
                            {{ $item->availability_arabic }}
                        </span>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Quick Stats -->
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="bg-light rounded p-2 mb-2">
                                <i class="bi bi-clock text-primary"></i>
                            </div>
                            <small>تم النشر</small>
                            <h6 class="fw-bold">{{ $item->created_at->diffForHumans() }}</h6>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2 mb-2">
                                <i class="bi bi-arrow-clockwise text-primary"></i>
                            </div>
                            <small>آخر تحديث</small>
                            <h6 class="fw-bold">{{ $item->updated_at->diffForHumans() }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Items -->
            @if($relatedItems->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">سلع مشابهة</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedItems as $related)
                    <a href="{{ route('market.show', $related->id) }}" class="text-decoration-none">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="bg-light rounded-circle p-2 me-3">
                                    <i class="bi {{ $related->category_icon }} text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $related->name }}</h6>
                                    <div class="d-flex justify-content-between">
                                        @if($related->price)
                                        <small class="text-success fw-bold">{{ number_format($related->price) }} شيكل</small>
                                        @else
                                        <small class="text-muted">بدون سعر</small>
                                        @endif
                                        <span class="badge bg-{{ $related->availability_color }} small">
                                            {{ $related->availability_arabic }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function contactSeller() {
        alert('سيتم فتح نافذة للتواصل مع البائع قريباً');
    }
    
    function shareItem() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $item->name }}',
                text: 'شاهد هذه السلعة في سوق منصة صمود',
                url: window.location.href
            });
        } else {
            alert('شارك الرابط: ' + window.location.href);
        }
    }
    
    function reportItem() {
        if (confirm('هل تريد الإبلاغ عن مشكلة في هذه السلعة؟')) {
            // هنا يمكن إضافة منطق الإبلاغ
            alert('شكراً لإبلاغك، سنقوم بمراجعة السلعة قريباً.');
        }
    }
</script>
@endpush