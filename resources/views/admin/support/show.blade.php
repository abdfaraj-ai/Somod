@extends('layouts.admin')

@section('title', 'تفاصيل خدمة الدعم')
@section('page-title', 'تفاصيل خدمة الدعم: ' . $support->title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.support.index') }}">الدعم النفسي</a></li>
<li class="breadcrumb-item active">{{ $support->title }}</li>
@endsection

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.support.edit', $support->id) }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> تعديل
    </a>
    <a href="{{ route('admin.support.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right"></i> العودة
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Support Info Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                <div class="bg-{{ $support->category_color }} text-white rounded-circle d-inline-flex p-4 mb-3">
                    <i class="bi {{ $support->category_icon }} fs-1"></i>
                </div>
                <h3 class="fw-bold mb-2">{{ $support->title }}</h3>
                
                <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
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
                        <i class="bi bi-shield-check"></i> متحقق
                    </span>
                    @endif
                    <span class="badge bg-secondary">
                        {{ $support->language_arabic }}
                    </span>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-card-text text-primary me-2"></i>الوصف</h6>
                        <p class="mb-0">{{ $support->description }}</p>
                    </div>
                    
                    @if($support->working_hours)
                    <div class="mb-3">
                        <h6 class="fw-bold"><i class="bi bi-clock text-primary me-2"></i>أوقات العمل</h6>
                        <p class="mb-0">{{ $support->working_hours }}</p>
                    </div>
                    @endif
                    
                    @if($support->phone)
                    <div class="mb-2">
                        <i class="bi bi-telephone text-primary me-2"></i>
                        <strong>الهاتف:</strong> {{ $support->phone }}
                    </div>
                    @endif
                    
                    @if($support->whatsapp)
                    <div class="mb-2">
                        <i class="bi bi-whatsapp text-success me-2"></i>
                        <strong>الواتساب:</strong> {{ $support->whatsapp }}
                    </div>
                    @endif
                    
                    @if($support->email)
                    <div class="mb-2">
                        <i class="bi bi-envelope text-primary me-2"></i>
                        <strong>البريد:</strong> {{ $support->email }}
                    </div>
                    @endif
                    
                    @if($support->website)
                    <div class="mb-2">
                        <i class="bi bi-globe text-primary me-2"></i>
                        <strong>الموقع:</strong> 
                        <a href="{{ $support->website }}" target="_blank" class="text-decoration-none">
                            {{ $support->website }}
                        </a>
                    </div>
                    @endif
                    
                    <div class="mb-2">
                        <i class="bi bi-eye text-primary me-2"></i>
                        <strong>عدد المشاهدات:</strong> {{ $support->views }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-calendar text-primary me-2"></i>
                        <strong>تاريخ الإضافة:</strong> {{ $support->created_at->format('Y-m-d') }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="bi bi-clock text-primary me-2"></i>
                        <strong>آخر تحديث:</strong> {{ $support->updated_at->format('Y-m-d') }}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Specialties -->
        @if($support->specialties_array)
        <div class="card shadow mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-star me-2"></i>التخصصات</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($support->specialties_array as $specialty)
                    <span class="badge bg-light text-dark border">{{ $specialty }}</span>
                    @endforeach
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
                    <form action="{{ route('admin.support.toggle-status', $support->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $support->status == 'active' ? 'warning' : 'success' }} w-100">
                            <i class="bi bi-power me-2"></i>
                            {{ $support->status == 'active' ? 'تعطيل الخدمة' : 'تفعيل الخدمة' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.support.toggle-verification', $support->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $support->verified ? 'secondary' : 'success' }} w-100">
                            <i class="bi bi-{{ $support->verified ? 'x-circle' : 'check-circle' }} me-2"></i>
                            {{ $support->verified ? 'إلغاء التحقق' : 'تأكيد التحقق' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.support.reset-views', $support->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info w-100" onclick="return confirm('هل تريد إعادة تعيين عدد المشاهدات؟')">
                            <i class="bi bi-arrow-clockwise me-2"></i> إعادة تعيين المشاهدات
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.support.destroy', $support->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')">
                            <i class="bi bi-trash me-2"></i> حذف الخدمة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Statistics -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bar-chart text-primary me-2"></i>إحصائيات الخدمة</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-eye fs-1 text-primary"></i>
                        </div>
                        <h4>{{ $support->views }}</h4>
                        <p class="text-muted mb-0">عدد المشاهدات</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-success bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                        </div>
                        <h4>{{ $support->verified ? 'نعم' : 'لا' }}</h4>
                        <p class="text-muted mb-0">الحالة التحقق</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-warning bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-currency-dollar fs-1 text-warning"></i>
                        </div>
                        <h4>{{ $support->is_free ? 'مجاني' : 'مدفوع' }}</h4>
                        <p class="text-muted mb-0">نوع الخدمة</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-info bg-opacity-10 rounded p-3 mb-2">
                            <i class="bi bi-translate fs-1 text-info"></i>
                        </div>
                        <h6>{{ $support->language_arabic }}</h6>
                        <p class="text-muted mb-0">اللغة</p>
                    </div>
                </div>
                
                <!-- Activity Timeline -->
                <div class="mt-4">
                    <h6 class="border-bottom pb-2">سجل النشاط</h6>
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-plus-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">إنشاء الخدمة</h6>
                                    <p class="text-muted small mb-0">{{ $support->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="bg-success text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-pencil"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">آخر تحديث</h6>
                                    <p class="text-muted small mb-0">{{ $support->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Preview -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-eye text-primary me-2"></i>معاينة كيف تظهر للمستخدمين</h6>
            </div>
            <div class="card-body">
                <div class="bg-light p-4 rounded-3">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-{{ $support->category_color }} text-white rounded-circle p-2 me-3">
                            <i class="bi {{ $support->category_icon }} fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $support->title }}</h5>
                            <small class="text-muted">{{ $support->category_arabic }}</small>
                        </div>
                    </div>
                    
                    <p class="text-muted small mb-3">{{ Str::limit($support->description, 150) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-eye text-muted me-1"></i>
                            <small class="text-muted">{{ $support->views }} مشاهدة</small>
                        </div>
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i> عرض التفاصيل
                        </button>
                    </div>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="{{ route('support.show', $support->id) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-up-right me-2"></i> عرض الصفحة للمستخدمين
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection