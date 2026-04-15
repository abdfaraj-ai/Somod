@extends('layouts.app')

@section('title', 'بحث في قصص الصمود')

@section('content')
<div class="container py-5">
    <!-- عناوين البحث -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="fw-bold mb-3">نتائج البحث</h1>
            <p class="text-muted">
                @if($query)
                عرض النتائج عن: "<span class="fw-bold text-success">{{ $query }}</span>"
                @endif
            </p>
            
            <form action="{{ route('stories.search') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="q" class="form-control form-control-lg" 
                           placeholder="ابحث في قصص الصمود..." value="{{ $query }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-search me-2"></i> بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- نتائج البحث -->
    @if($stories->count() > 0)
    <div class="row g-4">
        <div class="col-12">
            <h4 class="fw-bold mb-4">تم العثور على {{ $stories->total() }} قصة</h4>
        </div>
        
        @foreach($stories as $story)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                @if($story->image_path)
                <img src="{{ Storage::url($story->image_path) }}" class="card-img-top" alt="{{ $story->title }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-success mb-2">{{ $story->category_arabic }}</span>
                    <h5 class="card-title fw-bold">{{ $story->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($story->excerpt ?? $story->content, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $story->author_location }}
                        </small>
                        <a href="{{ route('stories.show', $story->slug) }}" class="btn btn-sm btn-outline-success">
                            اقرأ القصة
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- الترقيم -->
    <div class="d-flex justify-content-center mt-5">
        {{ $stories->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-search display-1 text-muted mb-4"></i>
        <h4>لم يتم العثور على نتائج</h4>
        <p class="text-muted mb-4">جرب مصطلحات بحث أخرى أو استعرض جميع القصص</p>
        <a href="{{ route('stories.index') }}" class="btn btn-success">
            <i class="fas fa-book-open me-2"></i> استعرض جميع القصص
        </a>
    </div>
    @endif
</div>
@endsection