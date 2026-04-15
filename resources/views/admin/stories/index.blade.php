@extends('layouts.admin')

@section('title', 'إدارة قصص الصمود')
@section('page-title', 'إدارة قصص الصمود')

@section('page-actions')
<a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> إضافة قصة جديدة
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.stories.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>منشورة</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">الفئة</label>
                        <select name="category" class="form-select">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="resilience" {{ request('category') == 'resilience' ? 'selected' : '' }}>إرادة صلبة</option>
                            <option value="solidarity" {{ request('category') == 'solidarity' ? 'selected' : '' }}>تكافل اجتماعي</option>
                            <option value="innovation" {{ request('category') == 'innovation' ? 'selected' : '' }}>إبداع وتحدي</option>
                            <option value="heroes" {{ request('category') == 'heroes' ? 'selected' : '' }}>أبطال الميدان</option>
                            <option value="hope" {{ request('category') == 'hope' ? 'selected' : '' }}>أمل وتفاؤل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">بحث</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="بحث في العناوين والمحتوى..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-redo"></i> إعادة تعيين
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stories Table -->
        <div class="card shadow">
            <div class="card-body">
                @if($stories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>القصة</th>
                                <th>المؤلف</th>
                                <th>الفئة</th>
                                <th>الحالة</th>
                                <th>المشاهدات</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stories as $story)
                            <tr>
                                <td>{{ $story->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($story->image_path)
                                        <img src="{{ Storage::url($story->image_path) }}" 
                                             class="rounded me-3" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $story->title }}</div>
                                            <small class="text-muted">{{ Str::limit($story->excerpt, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $story->author_name ?? 'مجهول' }}</div>
                                    <small class="text-muted">{{ $story->author_location }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $story->category == 'resilience' ? 'success' : ($story->category == 'solidarity' ? 'primary' : 'warning') }}">
                                        {{ $story->category_arabic }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
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
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $story->views_count }}</div>
                                        <small class="text-muted">مشاهدة</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted d-block">{{ $story->created_at->format('Y-m-d') }}</small>
                                    <small class="text-muted">{{ $story->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.stories.show', $story->id) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.stories.edit', $story->id) }}" 
                                           class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.stories.toggle-publish', $story->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $story->is_published ? 'warning' : 'success' }}"
                                                    title="{{ $story->is_published ? 'إلغاء النشر' : 'نشر' }}">
                                                <i class="fas fa-{{ $story->is_published ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.stories.toggle-featured', $story->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $story->is_featured ? 'secondary' : 'info' }}"
                                                    title="{{ $story->is_featured ? 'إلغاء التميز' : 'تمييز' }}">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.stories.destroy', $story->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه القصة؟')"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $stories->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-book-open display-1 text-muted"></i>
                    <h5 class="mt-3">لا توجد قصص</h5>
                    <p class="text-muted">لم يتم إضافة أي قصص بعد</p>
                    <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة أول قصة
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection