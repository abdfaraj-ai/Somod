@extends('layouts.app')

@section('title', 'دليل الخدمات - منصة صمود')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="hero-section text-center mb-5 shadow rounded-4 p-4 p-lg-5 bg-primary text-white">
        <h1 class="fw-bold display-5 mb-3"><i class="bi bi-hospital-fill me-2"></i>دليل الخدمات الحيوية</h1>
        <p class="lead opacity-90 mb-0">ابحث عن أقرب المرافق الطبية، مراكز الإيواء، والمؤسسات التعليمية النشطة حالياً.</p>
    </div>

    <!-- Categories Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex gap-2 overflow-auto pb-2 no-scrollbar justify-content-md-center">
                @foreach($categories as $key => $cat)
                <a href="{{ url('/services?category=' . $key) }}" 
                   class="btn {{ $category == $key ? 'btn-dark' : 'btn-outline-success' }} filter-btn">
                    {{ $cat['name'] }} ({{ $cat['count'] }})
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Services Cards List -->
        <div class="col-lg-8">
            @if($services && $services->count() > 0)
            <div class="row g-3">
                @foreach($services as $service)
                <div class="col-md-6">
                    <div class="card service-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-{{ $service->category_color }} text-white rounded-circle p-2 me-3">
                                    <i class="bi {{ $service->category_icon }} fs-4"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">{{ $service->name }}</h5>
                                    <small class="text-muted">{{ $service->category_arabic }}</small>
                                </div>
                            </div>
                            
                            <p class="text-muted small mb-3">
                                @if(strlen($service->description) > 100)
                                    {{ substr($service->description, 0, 100) }}...
                                @else
                                    {{ $service->description }}
                                @endif
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-geo-alt text-muted me-1"></i>
                                    <small class="text-muted">
                                        @if(strlen($service->address) > 30)
                                            {{ substr($service->address, 0, 30) }}...
                                        @else
                                            {{ $service->address }}
                                        @endif
                                    </small>
                                </div>
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h5 class="mt-3">لا توجد خدمات</h5>
                <p class="text-muted">لم يتم إضافة أي خدمات بعد في هذه الفئة</p>
                <a href="{{ url('/services') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i> عرض جميع الخدمات
                </a>
            </div>
            @endif
        </div>

        <!-- Stats Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <h5 class="fw-bold mb-3">إحصائيات الخدمات</h5>
                
                @foreach($categories as $key => $cat)
                @if($key !== 'all')
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ $cat['name'] }}</span>
                    <span class="badge bg-primary">{{ $cat['count'] }}</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    @php
                        $total = $categories['all']['count'] > 0 ? $categories['all']['count'] : 1;
                        $percentage = ($cat['count'] / $total) * 100;
                    @endphp
                    <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                </div>
                @endif
                @endforeach
                
                <hr class="my-4">
                
                <div class="text-center">
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <i class="bi bi-shield-check text-success fs-1"></i>
                        <h4 class="mt-2">{{ $categories['all']['count'] }}</h4>
                        <p class="text-muted mb-0">خدمة موثوقة</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>جميع الخدمات خضعت للتدقيق والتحقق</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .service-card {
        transition: transform 0.3s;
        cursor: pointer;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .filter-btn {
        white-space: nowrap;
        border-radius: 50px;
        padding: 8px 20px;
        text-decoration: none;
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