@extends('layouts.app')

@section('title', 'نتائج البحث - السوق المحلي')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('market.index') }}">السوق المحلي</a></li>
            <li class="breadcrumb-item active">نتائج البحث</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-3"><i class="bi bi-search text-primary me-2"></i>نتائج البحث</h2>
            
            @if(!empty($query))
            <p class="text-muted">عرض نتائج البحث عن: <span class="fw-bold">"{{ $query }}"</span></p>
            @endif
        </div>
    </div>

    @if($items->count() > 0)
    <div class="row g-3">
        @foreach($items as $item)
        <div class="col-md-4 col-lg-3">
            <div class="card market-item border-0 shadow-sm h-100">
                <div class="card-body">
                    <!-- Availability Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-{{ $item->availability_color }}">
                            {{ $item->availability_arabic }}
                        </span>
                    </div>
                    
                    <!-- Item Info -->
                    <div class="text-center mb-3">
                        <div class="bg-light rounded-circle d-inline-flex p-2 mb-2">
                            <i class="bi {{ $item->category_icon }} fs-4 text-primary"></i>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $item->name }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($item->description, 40) }}</p>
                    </div>
                    
                    <!-- Price -->
                    <div class="text-center mb-3">
                        @if($item->price)
                        <h5 class="fw-bold text-success">{{ number_format($item->price) }} شيكل</h5>
                        @else
                        <small class="text-muted">بدون سعر</small>
                        @endif
                    </div>
                    
                    <!-- Location -->
                    <div class="small text-muted mb-3 text-center">
                        <i class="bi bi-geo-alt"></i>
                        {{ Str::limit($item->location, 20) }}
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
        <i class="bi bi-search display-1 text-muted"></i>
        <h4 class="mt-3">لا توجد نتائج</h4>
        <p class="text-muted">لم نتمكن من العثور على أي سلع تطابق بحثك</p>
        <a href="{{ route('market.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-right me-2"></i> عرض جميع السلع
        </a>
    </div>
    @endif
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
</style>
@endpush