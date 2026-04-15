@extends('layouts.admin')

@section('title', 'تفاصيل البلوك')
@section('page-title', 'تفاصيل البلوك: ' . $evacuation->block_number)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.evacuation.index') }}">خريطة الإخلاء</a></li>
<li class="breadcrumb-item active">{{ $evacuation->block_number }}</li>
@endsection

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.evacuation.edit', $evacuation->id) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> تعديل
    </a>
    <a href="{{ route('admin.evacuation.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right"></i> العودة
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Block Info Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="bg-{{ $evacuation->status_color }} text-white rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi {{ $evacuation->status_icon }} fs-1"></i>
                </div>
                <h3 class="fw-bold mb-2">بلوك {{ $evacuation->block_number }}</h3>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-{{ $evacuation->status_color }}">
                        {{ $evacuation->status_arabic }}
                    </span>
                    <span class="badge bg-secondary">
                        {{ $evacuation->area }}
                    </span>
                    <span class="badge bg-dark">
                        {{ $evacuation->update_source_arabic }}
                    </span>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h6>
                        <p class="mb-0">{{ $evacuation->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                    
                    @if($evacuation->instructions)
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-info-square text-primary me-2"></i>تعليمات الإخلاء</h6>
                        <p class="mb-0">{{ $evacuation->instructions }}</p>
                    </div>
                    @endif
                    
                    <div class="mb-2">
                        <i class="bi bi-people text-primary me-2"></i>
                        <strong>عدد السكان:</strong> {{ $evacuation->population ?? 'غير معروف' }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-calendar text-primary me-2"></i>
                        <strong>تاريخ الإضافة:</strong> {{ $evacuation->created_at->format('Y-m-d') }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <strong>آخر تحديث:</strong> {{ $evacuation->updated_at->format('Y-m-d') }}
                    </div>
                    
                    @if($evacuation->last_updated)
                    <div class="mb-2">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        <strong>آخر تحديث للحالة:</strong> {{ $evacuation->last_updated->format('Y-m-d H:i') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Services -->
        <div class="card shadow mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-gear me-2"></i>الخدمات المتاحة</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @if($evacuation->has_shelter)
                    <div class="col-4">
                        <div class="bg-success bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-house-heart text-success fs-3"></i>
                        </div>
                        <small>ملاجئ</small>
                    </div>
                    @endif
                    
                    @if($evacuation->has_medical)
                    <div class="col-4">
                        <div class="bg-danger bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-heart-pulse text-danger fs-3"></i>
                        </div>
                        <small>طبية</small>
                    </div>
                    @endif
                    
                    @if($evacuation->has_water)
                    <div class="col-4">
                        <div class="bg-info bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-droplet text-info fs-3"></i>
                        </div>
                        <small>مياه</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header bg-light">
                <h6 class="mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.evacuation.update-status', $evacuation->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-arrow-repeat me-2"></i> تغيير الحالة
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.evacuation.destroy', $evacuation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذا البلوك؟')">
                            <i class="bi bi-trash me-2"></i> حذف البلوك
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Status History -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clock-history text-primary me-2"></i>سجل التحديثات</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">إنشاء البلوك</h6>
                                <p class="text-muted small mb-0">{{ $evacuation->created_at->diffForHumans() }}</p>
                                <small class="text-muted">بواسطة النظام</small>
                            </div>
                        </div>
                    </div>
                    
                    @if($evacuation->last_updated)
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="bg-{{ $evacuation->status_color }} text-white rounded-circle p-2 me-3">
                                <i class="bi {{ $evacuation->status_icon }}"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">تحديث الحالة إلى {{ $evacuation->status_arabic }}</h6>
                                <p class="text-muted small mb-0">{{ $evacuation->last_updated->diffForHumans() }}</p>
                                <small class="text-muted">المصدر: {{ $evacuation->update_source_arabic }}</small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Coordinates Info -->
        @if($evacuation->coordinates)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-geo-alt text-primary me-2"></i>الإحداثيات الجغرافية</h6>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded">{{ json_encode($evacuation->coordinates, JSON_PRETTY_PRINT) }}</pre>
                
                <div class="mt-3">
                    <button class="btn btn-outline-primary" onclick="copyCoordinates()">
                        <i class="bi bi-clipboard me-2"></i> نسخ الإحداثيات
                    </button>
                    <a href="#" class="btn btn-outline-success" onclick="showOnMap()">
                        <i class="bi bi-map me-2"></i> عرض على الخريطة
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Map Preview -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-map text-primary me-2"></i>عرض على الخريطة</h6>
            </div>
            <div class="card-body">
                <div id="mapPreview" style="height: 300px; background-color: #f8f9fa; border-radius: 8px;"
                     class="d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <i class="bi bi-map display-4 text-muted mb-3"></i>
                        <p class="text-muted">خريطة تفاعلية للبلوك {{ $evacuation->block_number }}</p>
                        <button class="btn btn-primary" onclick="loadMap()">
                            <i class="bi bi-arrow-clockwise me-2"></i> تحميل الخريطة
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
    function copyCoordinates() {
        const coordinates = @json($evacuation->coordinates);
        navigator.clipboard.writeText(JSON.stringify(coordinates));
        alert('تم نسخ الإحداثيات');
    }
    
    function showOnMap() {
        const coordinates = @json($evacuation->coordinates);
        if (coordinates && coordinates.lat && coordinates.lng) {
            const url = `https://www.google.com/maps?q=${coordinates.lat},${coordinates.lng}`;
            window.open(url, '_blank');
        } else {
            alert('لا توجد إحداثيات متاحة');
        }
    }
    
    function loadMap() {
        // هنا يمكنك إضافة كود تحميل خريطة تفاعلية
        alert('سيتم تحميل الخريطة التفاعلية هنا');
    }
</script>
@endpush