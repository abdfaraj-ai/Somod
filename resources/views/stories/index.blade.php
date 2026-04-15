@extends('layouts.app')

@section('title', 'قصص الصمود - منصة صمود')

@section('content')
<div class="stories-page">
    <!-- الهيرو -->
    <header class="stories-hero">
        <div class="container">
            <h1 class="animate__animated animate__fadeInDown">حكايات الصمود</h1>
            <p class="animate__animated animate__fadeInUp">أرواح غزة التي لا تُهزم، توثيق حي للإرادة والحياة في وجه المستحيل.</p>
        </div>
    </header>

    <!-- الفلترة والإحصائيات -->
    <section class="container py-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('stories.index', ['category' => 'all']) }}" 
                       class="btn {{ $category == 'all' ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill">
                        الكل ({{ $stats['total'] }})
                    </a>
                    <a href="{{ route('stories.index', ['category' => 'resilience']) }}" 
                       class="btn {{ $category == 'resilience' ? 'btn-success' : 'btn-outline-success' }} rounded-pill">
                        إرادة صلبة ({{ $stats['resilience'] }})
                    </a>
                    <a href="{{ route('stories.index', ['category' => 'solidarity']) }}" 
                       class="btn {{ $category == 'solidarity' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill">
                        تكافل اجتماعي ({{ $stats['solidarity'] }})
                    </a>
                    <a href="{{ route('stories.index', ['category' => 'innovation']) }}" 
                       class="btn {{ $category == 'innovation' ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill">
                        إبداع وتحدي ({{ $stats['innovation'] }})
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <form action="{{ route('stories.search') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control rounded-pill-start" placeholder="ابحث في القصص...">
                    <button type="submit" class="btn btn-success rounded-pill-end">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>



        <!-- القصص المميزة -->
        @if($featuredStories->count() > 0)
    <section class="container py-5">
        <div class="row g-5">
                @foreach($featuredStories as $story)
                <div class="col-lg-6">
                    <div class="story-card">
                        @if($story->image_path)
                        <img src="{{ Storage::url($story->image_path) }}" class="story-img" alt="{{ $story->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="story-content">
                            <span class="story-tag">{{ $story->category_arabic }}</span>
                            <h2 class="story-title">{{ $story->title }}</h2>
                            <p class="story-quote">{{ Str::limit($story->excerpt ?? $story->content, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <span class="small fw-bold text-success"><i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $story->author_location }}</span>
                                </small>
                                <a href="{{ route('stories.show', $story->slug) }}" class="btn btn-link text-success">
                                    اقرأ القصة <i class="fas fa-arrow-left ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- جميع القصص -->
        <h3 class="fw-bold mb-4">جميع قصص الصمود</h3>
        @if($stories->count() > 0)
        <div class="row g-4">
            @foreach($stories as $story)
            <div class="col-lg-4 col-md-6">
                <div class="card story-card h-100 border-0 shadow-sm hover-lift">
                    @if($story->image_path)
                    <img src="{{ Storage::url($story->image_path) }}" class="card-img-top" alt="{{ $story->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-book-open display-4 text-muted"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-{{ $story->category == 'resilience' ? 'success' : ($story->category == 'solidarity' ? 'primary' : 'warning') }} mb-2">
                            {{ $story->category_arabic }}
                        </span>
                        <h5 class="card-title fw-bold">{{ $story->title }}</h5>
                        <p class="story-quote">{{ Str::limit($story->excerpt ?? $story->content, 150) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted d-block">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $story->author_name ?? 'مجهول' }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $story->author_location }}
                                </small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ $story->views_count }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-heart me-1"></i>
                                    {{ $story->likes_count }}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('stories.show', $story->slug) }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-book-open me-2"></i> اقرأ القصة كاملة
                        </a>
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
            <i class="fas fa-book-open display-1 text-muted mb-4"></i>
            <h4>لا توجد قصص متاحة حالياً</h4>
            <p class="text-muted">سيتم إضافة قصص جديدة قريباً</p>
        </div>
        @endif
    </section>

    <!-- نموذج مشاركة القصة -->
        <div class="share-section shadow-2xl">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-black mb-4">لديك قصة؟ <br> العالم ينتظر سماعها</h2>
                    <p class="fs-5 opacity-75 mb-5">ساعدنا في توثيق الحقيقة ونشر الأمل. قصتك قد تكون الدافع الذي يحتاجه شخص آخر ليستمر.</p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white p-3 rounded-circle">
                            <i class="fas fa-shield-alt fs-4"></i>
                        </div>
                        <p class="mb-0 fw-bold">نضمن سرية البيانات وحماية الهوية حسب رغبتك.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('stories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="author_name" class="form-control" placeholder="الاسم (اختياري)" value="{{ old('author_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="author_location" class="form-control" placeholder="المنطقة *" value="{{ old('author_location') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="بريدك الإلكتروني للتواصل (اختياري)" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <select name="category" class="form-select" required>
                                <option value="">اختر فئة القصة *</option>
                                <option value="resilience" {{ old('category') == 'resilience' ? 'selected' : '' }}>إرادة صلبة</option>
                                <option value="solidarity" {{ old('category') == 'solidarity' ? 'selected' : '' }}>تكافل اجتماعي</option>
                                <option value="innovation" {{ old('category') == 'innovation' ? 'selected' : '' }}>إبداع وتحدي</option>
                                <option value="heroes" {{ old('category') == 'heroes' ? 'selected' : '' }}>أبطال الميدان</option>
                                <option value="hope" {{ old('category') == 'hope' ? 'selected' : '' }}>أمل وتفاؤل</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="title" class="form-control" placeholder="عنوان القصة *" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="5" placeholder="اكتب قصة صمودك هنا... *" required>{{ old('content') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i> إرسال القصة للمراجعة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .stories-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        text-align: center;
        margin-bottom: 50px;
    }

    .stories-hero h1 {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 20px;
    }

    .story-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 15px;
        overflow: hidden;
    }

    .story-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        transition: transform 0.2s;
    }

    .share-section {
        border-radius: 20px;
        padding: 50px;
    }

    @media (max-width: 768px) {
        .stories-hero h1 {
            font-size: 2.5rem;
        }
        
        .share-section {
            padding: 30px 20px;
        }
    }
</style>
@endpush