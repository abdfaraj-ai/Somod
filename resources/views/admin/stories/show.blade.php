@extends('layouts.admin')

@section('title', 'تفاصيل القصة')
@section('page-title', 'تفاصيل القصة: ' . $story->title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}">قصص الصمود</a></li>
<li class="breadcrumb-item active">{{ Str::limit($story->title, 30) }}</li>
@endsection

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.stories.edit', $story->id) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> تعديل
    </a>
    <a href="{{ route('admin.stories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-right"></i> العودة
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Story Info Card -->
        <div class="card shadow mb-4">
            <div class="card-body text-center">
                @if($story->image_path)
                <img src="{{ Storage::url($story->image_path) }}" 
                     class="img-fluid rounded mb-3" 
                     style="max-height: 200px; object-fit: cover;">
                @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                     style="height: 200px;">
                    <i class="fas fa-book-open display-4 text-muted"></i>
                </div>
                @endif
                
                <h3 class="fw-bold mb-2">{{ $story->title }}</h3>
                
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-{{ $story->category == 'resilience' ? 'success' : ($story->category == 'solidarity' ? 'primary' : 'warning') }}">
                        {{ $story->category_arabic }}
                    </span>
                    
                    @if($story->is_published)
                    <span class="badge bg-success">
                        <i class="fas fa-check"></i> منشورة
                    </span>
                    @else
                    <span class="badge bg-warning">
                        <i class="fas fa-clock"></i> مسودة
                    </span>
                    @endif
                    
                    @if($story->is_featured)
                    <span class="badge bg-info">
                        <i class="fas fa-star"></i> مميزة
                    </span>
                    @endif
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-2">
                        <i class="fas fa-user text-primary me-2"></i>
                        <strong>المؤلف:</strong> {{ $story->author_name ?? 'مجهول' }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <strong>الموقع:</strong> {{ $story->author_location }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-eye text-primary me-2"></i>
                        <strong>المشاهدات:</strong> {{ $story->views_count }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-heart text-primary me-2"></i>
                        <strong>الإعجابات:</strong> {{ $story->likes_count }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-clock text-primary me-2"></i>
                        <strong>وقت القراءة:</strong> {{ $story->reading_time }} دقيقة
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-calendar text-primary me-2"></i>
                        <strong>تاريخ النشر:</strong> {{ $story->published_at ? $story->published_at->format('Y-m-d') : 'لم تنشر بعد' }}
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-calendar-plus text-primary me-2"></i>
                        <strong>تاريخ الإنشاء:</strong> {{ $story->created_at->format('Y-m-d') }}
                    </div>
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
                    <form action="{{ route('admin.stories.toggle-publish', $story->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $story->is_published ? 'warning' : 'success' }} w-100">
                            <i class="fas fa-{{ $story->is_published ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $story->is_published ? 'إلغاء النشر' : 'نشر القصة' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.stories.toggle-featured', $story->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $story->is_featured ? 'secondary' : 'info' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $story->is_featured ? 'إلغاء التميز' : 'تمييز القصة' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('هل أنت متأكد من حذف هذه القصة؟')">
                            <i class="fas fa-trash me-2"></i> حذف القصة
                        </button>
                    </form>
                    
                    <a href="{{ route('stories.show', $story->slug) }}" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="fas fa-external-link-alt me-2"></i> عرض في الموقع
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Story Content -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-align-left text-primary me-2"></i>محتوى القصة</h6>
            </div>
            <div class="card-body">
                @if($story->excerpt)
                <div class="alert alert-info border-0 rounded-4 mb-4">
                    <i class="fas fa-quote-right me-2"></i>
                    {{ $story->excerpt }}
                </div>
                @endif
                
                <div class="story-content">
                    {!! nl2br(e($story->content)) !!}
                </div>
            </div>
        </div>
        
        <!-- Story Statistics -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>إحصائيات</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <div class="bg-primary bg-opacity-10 rounded p-3 mb-2">
                            <i class="fas fa-eye text-primary fs-2"></i>
                        </div>
                        <h4>{{ $story->views_count }}</h4>
                        <small class="text-muted">مشاهدة</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-success bg-opacity-10 rounded p-3 mb-2">
                            <i class="fas fa-heart text-success fs-2"></i>
                        </div>
                        <h4>{{ $story->likes_count }}</h4>
                        <small class="text-muted">إعجاب</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-warning bg-opacity-10 rounded p-3 mb-2">
                            <i class="fas fa-clock text-warning fs-2"></i>
                        </div>
                        <h4>{{ $story->reading_time }}</h4>
                        <small class="text-muted">دقيقة قراءة</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-info bg-opacity-10 rounded p-3 mb-2">
                            <i class="fas fa-calendar text-info fs-2"></i>
                        </div>
                        <h6>{{ $story->created_at->format('Y-m-d') }}</h6>
                        <small class="text-muted">تاريخ الإنشاء</small>
                    </div>
                </div>
                
                <!-- Views History -->
                <div class="mt-4">
                    <h6 class="border-bottom pb-2">آخر التحديثات</h6>
                    <div class="list-group">
                        <div class="list-group-item border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-plus-circle text-success me-2"></i>
                                    <span>تم إنشاء القصة</span>
                                </div>
                                <small class="text-muted">{{ $story->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if($story->published_at)
                        <div class="list-group-item border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-eye text-primary me-2"></i>
                                    <span>تم نشر القصة</span>
                                </div>
                                <small class="text-muted">{{ $story->published_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endif
                        <div class="list-group-item border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-edit text-warning me-2"></i>
                                    <span>آخر تحديث</span>
                                </div>
                                <small class="text-muted">{{ $story->updated_at->diffForHumans() }}</small>
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
    .story-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    
    .story-content p {
        margin-bottom: 1.5rem;
    }
</style>
@endpush