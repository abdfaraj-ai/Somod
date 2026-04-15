@extends('layouts.app')

@section('title', $story->title . ' - قصص الصمود')

@section('content')
<div class="story-detail-page">
    <!-- صورة القصة -->
    @if($story->image_path)
    <div class="story-hero-image" style="background-image: url('{{ Storage::url($story->image_path) }}');">
        <div class="overlay"></div>
    </div>
    @endif

    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('stories.index') }}">قصص الصمود</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($story->title, 30) }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- محتوى القصة -->
            <div class="col-lg-8">
                <article class="story-article">
                    <!-- معلومات القصة -->
                    <div class="story-meta mb-4">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="badge bg-{{ $story->category == 'resilience' ? 'success' : ($story->category == 'solidarity' ? 'primary' : 'warning') }} fs-6">
                                {{ $story->category_arabic }}
                            </span>
                            
                            @if($story->author_name)
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-user text-muted"></i>
                                <span class="fw-bold">{{ $story->author_name }}</span>
                            </span>
                            @endif
                            
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-map-marker-alt text-muted"></i>
                                <span>{{ $story->author_location }}</span>
                            </span>
                            
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-calendar text-muted"></i>
                                <span>{{ $story->published_at->format('Y-m-d') }}</span>
                            </span>
                            
                            <span class="d-flex align-items-center gap-1">
                                <i class="fas fa-clock text-muted"></i>
                                <span>{{ $story->reading_time }} دقيقة قراءة</span>
                            </span>
                        </div>
                    </div>

                    <!-- عنوان القصة -->
                    <h1 class="display-4 fw-bold mb-4">{{ $story->title }}</h1>

                    <!-- مقتطف -->
                    @if($story->excerpt)
                    <div class="alert alert-info border-0 rounded-4 mb-4">
                        <i class="fas fa-quote-right me-2"></i>
                        {{ $story->excerpt }}
                    </div>
                    @endif

                    <!-- محتوى القصة -->
                    <div class="story-content mb-5">
                        {!! nl2br(e($story->content)) !!}
                    </div>

                    <!-- إحصائيات التفاعل -->
                    <div class="story-stats border-top border-bottom py-3 mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-eye text-primary fs-4"></i>
                                    <div>
                                        <div class="fw-bold fs-5">{{ $story->views_count }}</div>
                                        <small class="text-muted">مشاهدة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-heart text-danger fs-4"></i>
                                    <div>
                                        <div class="fw-bold fs-5">{{ $story->likes_count }}</div>
                                        <small class="text-muted">إعجاب</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <i class="fas fa-share-alt text-success fs-4"></i>
                                    <div>
                                        <div class="fw-bold fs-5">شارك</div>
                                        <small class="text-muted">القصة</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار المشاركة -->
                    <div class="d-flex gap-2 mb-5">
                        <button class="btn btn-outline-primary" onclick="shareStory('facebook')">
                            <i class="fab fa-facebook me-2"></i> فيسبوك
                        </button>
                        <button class="btn btn-outline-info" onclick="shareStory('twitter')">
                            <i class="fab fa-twitter me-2"></i> تويتر
                        </button>
                        <button class="btn btn-outline-success" onclick="shareStory('whatsapp')">
                            <i class="fab fa-whatsapp me-2"></i> واتساب
                        </button>
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> طباعة
                        </button>
                    </div>
                </article>
            </div>

            <!-- القصص المشابهة -->
            <div class="col-lg-4">
                @if($relatedStories->count() > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>قصص مشابهة</h5>
                    </div>
                    <div class="card-body">
                        @foreach($relatedStories as $related)
                        <div class="border-bottom pb-3 mb-3">
                            <h6 class="fw-bold">{{ $related->title }}</h6>
                            <small class="text-muted d-block mb-2">{{ Str::limit($related->excerpt ?? $related->content, 80) }}</small>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $related->author_location }}
                                </small>
                                <a href="{{ route('stories.show', $related->slug) }}" class="btn btn-sm btn-outline-success">
                                    اقرأ <i class="fas fa-arrow-left ms-1"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- معلومات الكاتب -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                            <i class="fas fa-user-edit fs-1 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">عن الكاتب</h5>
                        <p class="text-muted">
                            {{ $story->author_name ? $story->author_name . ' من ' . $story->author_location : 'شخص غزي من ' . $story->author_location }}
                        </p>
                        <p class="small text-muted">
                            شارك قصته لتكون مصدر إلهام للآخرين في زمن المحن.
                        </p>
                        <a href="{{ route('stories.index', ['category' => $story->category]) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-book me-2"></i> قصص {{ $story->category_arabic }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .story-hero-image {
        height: 400px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .story-hero-image .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
    }

    .story-article {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .story-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .story-content p {
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .story-hero-image {
            height: 250px;
        }
        
        .story-article {
            padding: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function shareStory(platform) {
        const url = window.location.href;
        const title = "{{ $story->title }}";
        const text = "{{ Str::limit($story->excerpt ?? $story->content, 100) }}";

        let shareUrl = '';
        
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' - ' + url)}`;
                break;
        }

        if(shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    }
</script>
@endpush