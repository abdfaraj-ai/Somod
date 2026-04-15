@extends('layouts.app')

@section('title', 'السوق المحلي - منصة صمود')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i>السوق المركزي</h2>
                    <p class="mb-0 opacity-90">أسعار السلع وتوفرها - تحديث مباشر من المجتمع المحلي.</p>
                </div>
                <div class="col-md-4 text-end mt-3 mt-md-0">
                    <a href="#" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addMarketModal">
                        <i class="bi bi-plus-lg"></i> إضافة سلعة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="bi bi-basket text-success fs-1 mb-2"></i>
                    <h4 class="fw-bold">{{ $stats['food'] }}</h4>
                    <p class="text-muted mb-0">مواد غذائية</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="bi bi-lightning text-warning fs-1 mb-2"></i>
                    <h4 class="fw-bold">{{ $stats['energy'] }}</h4>
                    <p class="text-muted mb-0">طاقة ووقود</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="bi bi-capsule text-danger fs-1 mb-2"></i>
                    <h4 class="fw-bold">{{ $stats['medical'] }}</h4>
                    <p class="text-muted mb-0">صحة وأدوية</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body py-3">
                    <i class="bi bi-gear text-primary fs-1 mb-2"></i>
                    <h4 class="fw-bold">{{ $stats['services'] }}</h4>
                    <p class="text-muted mb-0">خدمات</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <!-- Categories -->
            <div class="d-flex gap-2 overflow-auto pb-2 no-scrollbar">
                <a href="{{ route('market.index', ['category' => 'all']) }}" 
                   class="btn {{ $category == 'all' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap">
                    الكل ({{ $stats['total'] }})
                </a>
                <a href="{{ route('market.index', ['category' => 'food']) }}" 
                   class="btn {{ $category == 'food' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap">
                    <i class="bi bi-basket me-1"></i> مواد غذائية
                </a>
                <a href="{{ route('market.index', ['category' => 'energy']) }}" 
                   class="btn {{ $category == 'energy' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap">
                    <i class="bi bi-lightning me-1"></i> طاقة ووقود
                </a>
                <a href="{{ route('market.index', ['category' => 'medical']) }}" 
                   class="btn {{ $category == 'medical' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap">
                    <i class="bi bi-capsule me-1"></i> صحة وأدوية
                </a>
                <a href="{{ route('market.index', ['category' => 'services']) }}" 
                   class="btn {{ $category == 'services' ? 'btn-dark' : 'btn-outline-secondary' }} rounded-pill px-4 text-nowrap">
                    <i class="bi bi-gear me-1"></i> خدمات
                </a>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Sort -->
            <form action="{{ route('market.index') }}" method="GET" class="d-flex gap-2">
                <input type="hidden" name="category" value="{{ $category }}">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>السعر: منخفض إلى مرتفع</option>
                    <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>السعر: مرتفع إلى منخفض</option>
                    <option value="views" {{ $sort == 'views' ? 'selected' : '' }}>الأكثر مشاهدة</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Availability Filter -->
    <div class="mb-4">
        <div class="d-flex gap-2">
            <a href="{{ route('market.index', ['category' => $category, 'availability' => 'all']) }}" 
               class="btn {{ $availability == 'all' ? 'btn-dark' : 'btn-outline-secondary' }} btn-sm">
                الكل
            </a>
            <a href="{{ route('market.index', ['category' => $category, 'availability' => 'available']) }}" 
               class="btn {{ $availability == 'available' ? 'btn-dark' : 'btn-outline-secondary' }} btn-sm">
                <i class="bi bi-check-circle me-1"></i> متوفر
            </a>
            <a href="{{ route('market.index', ['category' => $category, 'availability' => 'scarce']) }}" 
               class="btn {{ $availability == 'scarce' ? 'btn-dark' : 'btn-outline-secondary' }} btn-sm">
                <i class="bi bi-exclamation-triangle me-1"></i> شحيح
            </a>
            <a href="{{ route('market.index', ['category' => $category, 'availability' => 'out']) }}" 
               class="btn {{ $availability == 'out' ? 'btn-dark' : 'btn-outline-secondary' }} btn-sm">
                <i class="bi bi-x-circle me-1"></i> غير متوفر
            </a>
            <a href="{{ route('market.index', ['category' => $category, 'urgent' => true]) }}" 
               class="btn {{ request()->has('urgent') ? 'btn-danger' : 'btn-outline-danger' }} btn-sm">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> عاجل
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden bg-white">
        <form action="" method="GET" class="w-100 d-flex">
            <span class="input-group-text bg-white border-0 ps-3">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="q" class="form-control border-0 shadow-none ps-0" 
                   placeholder="ابحث عن سلعة (طحين، غاز، خيام...)" required>
            <button type="submit" class="btn btn-primary px-4">بحث</button>
        </form>
    </div>

    <!-- Items Grid -->
    @if($items->count() > 0)
    <div class="row g-3" id="market-grid">
        @foreach($items as $item)
        <div class="col-md-4 col-lg-3">
            <div class="card market-item border-0 shadow-sm h-100">
                <div class="card-body">
                    <!-- Urgent Badge -->
                    @if($item->is_urgent)
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-danger"><i class="bi bi-exclamation-triangle-fill"></i> عاجل</span>
                    </div>
                    @endif
                    
                    <!-- Availability Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-{{ $item->availability_color }}">
                            {{ $item->availability_arabic }}
                        </span>
                    </div>
                    
                    <!-- Item Info -->
                    <div class="text-center mb-3">
                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-2">
                            <i class="bi {{ $item->category_icon }} fs-2 text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-1">{{ $item->name }}</h5>
                        <p class="text-muted small mb-2">{{ Str::limit($item->description, 50) }}</p>
                    </div>
                    
                    <!-- Price -->
                    <div class="text-center mb-3">
                        @if($item->price)
                        <h4 class="fw-bold text-success">{{ number_format($item->price) }} شيكل</h4>
                        @if($item->unit)
                        <small class="text-muted">لل{{ $item->unit }}</small>
                        @endif
                        @else
                        <h6 class="fw-bold text-muted">بدون سعر</h6>
                        @endif
                    </div>
                    
                    <!-- Location & Views -->
                    <div class="d-flex justify-content-between small text-muted">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            {{ Str::limit($item->location, 15) }}
                        </div>
                        <div>
                            <i class="bi bi-eye"></i>
                            {{ $item->views }}
                        </div>
                    </div>
                    
                    <!-- Action Button -->
                    <div class="mt-3">
                        <a href="{{ route('market.show', $item->id) }}" class="btn btn-primary w-100">
                            <i class="bi bi-eye me-2"></i> عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $items->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted"></i>
        <h5 class="mt-3">لا توجد سلع</h5>
        <p class="text-muted">لم يتم إضافة أي سلع بعد في هذه الفئة</p>
    </div>
    @endif
</div>

<!-- Add Market Item Modal -->
<div class="modal fade" id="addMarketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">إضافة سلعة جديدة</h5>
                <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('market.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">اسم السلعة</label>
                    <input type="text" name="name" class="form-control bg-light border-0" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small fw-bold">السعر</label>
                        <input type="number" name="price" class="form-control bg-light border-0">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small fw-bold">الفئة</label>
                        <select name="category" class="form-select bg-light border-0">
                            <option value="food">مواد غذائية</option>
                            <option value="energy">طاقة</option>
                            <option value="medical">صحة</option>
                            <option value="services">خدمات</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">التوفر</label>
                    <select name="availability" class="form-select bg-light border-0">
                        <option value="available">متوفر</option>
                        <option value="scarce">شحيح</option>
                        <option value="out">غير متوفر</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold">الموقع</label>
                    <input type="text" name="location" class="form-control bg-light border-0" required>
                </div>

                <input type="hidden" name="status" value="pending">

                <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-2">
                    نشر السلعة
                </button>
            </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .market-item {
        transition: transform 0.3s;
    }
    
    .market-item:hover {
        transform: translateY(-5px);
    }
    
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    function submitMarketItem(event) {
        event.preventDefault();
        
        const item = {
            name: document.getElementById('m-name').value,
            price: document.getElementById('m-price').value,
            type: document.getElementById('m-type').value,
            status: document.getElementById('m-status').value,
            location: document.getElementById('m-location').value,
            contact: document.getElementById('m-contact').value
        };
        
        // هنا يمكن إرسال البيانات إلى الخادم
        console.log('Item data:', item);
        
        // إغلاق المودال
        const modal = bootstrap.Modal.getInstance(document.getElementById('addMarketModal'));
        modal.hide();
        
        // إظهار رسالة نجاح
        alert('تم إضافة السلعة بنجاح! سيتم مراجعتها من قبل الإدارة.');
        
        // تفريغ الحقول
        document.getElementById('marketForm').reset();
    }
</script>
@endpush