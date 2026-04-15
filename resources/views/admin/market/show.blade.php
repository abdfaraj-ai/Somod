@extends('layouts.admin')

@section('title', 'تفاصيل السلعة')
@section('page-title', 'تفاصيل السلعة: ' . $market->name)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.market.index') }}">السوق</a></li>
<li class="breadcrumb-item active">{{ $market->name }}</li>
@endsection

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.market.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right"></i> العودة
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Item Info Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi {{ $market->category_icon }} fs-1 text-primary"></i>
                </div>
                <h3 class="fw-bold mb-2">{{ $market->name }}</h3>
                
                <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                    <span class="badge bg-dark">{{ $market->category_arabic }}</span>
                    <span class="badge bg-{{ $market->availability_color }}">
                        {{ $market->availability_arabic }}
                    </span>
                    <span class="badge bg-{{ $market->status_color }}">
                        {{ $market->status_arabic }}
                    </span>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <!-- Price -->
                    <div class="mb-3">
                        <h5 class="fw-bold text-center">
                            @if($market->price)
                            <span class="text-success">{{ number_format($market->price) }} شيكل</span>
                            @if($market->unit)
                            <small class="text-muted d-block">لل{{ $market->unit }}</small>
                            @endif
                            @else
                            <span class="text-muted">بدون سعر</span>
                            @endif
                        </h5>
                        @if($market->is_negotiable)
                        <div class="text-center">
                            <span class="badge bg-info">السعر قابل للتفاوض</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Location -->
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-geo-alt text-primary me-2"></i>الموقع</h6>
                        <p class="mb-0">{{ $market->location }}</p>
                    </div>
                    
                    <!-- Quantity -->
                    @if($market->quantity)
                    <div class="mb-2">
                        <i class="bi bi-box text-primary me-2"></i>
                        <strong>الكمية:</strong> {{ $market->quantity }} {{ $market->unit ?? 'وحدة' }}
                    </div>
                    @endif
                    
                    <!-- Description -->
                    @if($market->description)
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h6>
                        <p class="mb-0">{{ $market->description }}</p>
                    </div>
                    @endif
                    
                    <!-- Dates -->
                    <div class="mb-2">
                        <i class="bi bi-calendar text-primary me-2"></i>
                        <strong>تاريخ الإضافة:</strong> {{ $market->created_at->format('Y-m-d H:i') }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <strong>آخر تحديث:</strong> {{ $market->updated_at->format('Y-m-d H:i') }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-eye text-primary me-2"></i>
                        <strong>المشاهدات:</strong> {{ $market->views }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Seller Info -->
        @if($market->user)
        <div class="card shadow mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-person me-2"></i>معلومات البائع</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary text-white rounded-circle p-2 me-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $market->user->name }}</h6>
                        <small class="text-muted">{{ $market->user->email }}</small>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="bg-light rounded p-2 mb-2">
                            <i class="bi bi-box-seam text-primary"></i>
                        </div>
                        <small>إجمالي السلع</small>
                        <h6 class="fw-bold">{{ $market->user->marketItems->count() }}</h6>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2 mb-2">
                            <i class="bi bi-calendar text-primary"></i>
                        </div>
                        <small>تاريخ التسجيل</small>
                        <h6 class="fw-bold">{{ $market->user->created_at->format('Y-m-d') }}</h6>
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('admin.users.show', $market->user->id) }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-person-lines-fill me-2"></i> عرض الملف الشخصي
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h6 class="mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($market->status != 'active')
                    <form action="{{ route('admin.market.approve', $market->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle me-2"></i> موافقة
                        </button>
                    </form>
                    @endif
                    
                    @if($market->status != 'rejected')
                    <form action="{{ route('admin.market.reject', $market->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-x-circle me-2"></i> رفض
                        </button>
                    </form>
                    @endif
                    
                    @if($market->status != 'pending')
                    <form action="{{ route('admin.market.suspend', $market->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-pause-circle me-2"></i> تعليق
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.market.destroy', $market->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذه السلعة؟')">
                            <i class="bi bi-trash me-2"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Activity History -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock-history text-primary me-2"></i>سجل النشاط</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">إضافة السلعة</h6>
                                <p class="text-muted small mb-0">{{ $market->created_at->diffForHumans() }}</p>
                                <small class="text-muted">بواسطة: {{ $market->user->name ?? 'غير معروف' }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="bg-{{ $market->status_color }} text-white rounded-circle p-2 me-3">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">الحالة الحالية: {{ $market->status_arabic }}</h6>
                                <p class="text-muted small mb-0">{{ $market->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Similar Items -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-box-seam text-primary me-2"></i>سلع مماثلة من نفس البائع</h6>
            </div>
            <div class="card-body">
                @if($market->user && $market->user->marketItems->where('id', '!=', $market->id)->count() > 0)
                <div class="row g-3">
                    @foreach($market->user->marketItems->where('id', '!=', $market->id)->take(3) as $item)
                    <div class="col-md-4">
                        <div class="card border h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-light rounded-circle p-2 me-2">
                                        <i class="bi {{ $item->category_icon }} text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">{{ $item->name }}</h6>
                                </div>
                                
                                @if($item->price)
                                <div class="text-success fw-bold mb-2">{{ number_format($item->price) }} شيكل</div>
                                @endif
                                
                                <div class="d-flex justify-content-between small text-muted">
                                    <span class="badge bg-{{ $item->availability_color }}">
                                        {{ $item->availability_arabic }}
                                    </span>
                                    <span class="badge bg-{{ $item->status_color }}">
                                        {{ $item->status_arabic }}
                                    </span>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="{{ route('admin.market.show', $item->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-inbox text-muted fs-1"></i>
                    <p class="text-muted mt-2">لا توجد سلع أخرى من هذا البائع</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection