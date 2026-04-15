@extends('layouts.admin')

@section('title', 'إدارة الدعم النفسي')
@section('page-title', 'إدارة الدعم النفسي')

@section('page-actions')
<a href="{{ route('admin.support.create') }}" class="btn btn-success">
    <i class="bi bi-plus-lg"></i> إضافة خدمة دعم
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.support.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الفئة</label>
                        <select name="category" class="form-select">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="therapy" {{ request('category') == 'therapy' ? 'selected' : '' }}>جلسات علاجية</option>
                            <option value="hotline" {{ request('category') == 'hotline' ? 'selected' : '' }}>خطوط مساندة</option>
                            <option value="exercise" {{ request('category') == 'exercise' ? 'selected' : '' }}>تمارين استرخاء</option>
                            <option value="advice" {{ request('category') == 'advice' ? 'selected' : '' }}>نصائح وإرشادات</option>
                            <option value="group" {{ request('category') == 'group' ? 'selected' : '' }}>مجموعات دعم</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>معطل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">المجانية</label>
                        <select name="free" class="form-select">
                            <option value="all" {{ request('free') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="free" {{ request('free') == 'free' ? 'selected' : '' }}>مجاني</option>
                            <option value="paid" {{ request('free') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="اسم الخدمة أو رقم الهاتف..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Supports Table -->
        <div class="card shadow">
            <div class="card-body">
                @if($supports->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الخدمة</th>
                                <th>الفئة</th>
                                <th>الاتصال</th>
                                <th>المشاهدات</th>
                                <th>الحالة</th>
                                <th>التحقق</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supports as $support)
                            <tr>
                                <td>{{ $support->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-{{ $support->category_color }} text-white rounded-circle p-2 me-3">
                                            <i class="bi {{ $support->category_icon }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $support->title }}</div>
                                            <small class="text-muted">{{ Str::limit($support->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $support->category_color }}">
                                        {{ $support->category_arabic }}
                                    </span>
                                    @if($support->is_free)
                                    <span class="badge bg-success">مجاني</span>
                                    @endif
                                </td>
                                <td>
                                    @if($support->phone)
                                    <small>{{ $support->phone }}</small>
                                    @else
                                    <small class="text-muted">لا يوجد</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $support->views }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $support->status == 'active' ? 'success' : 'warning' }}">
                                        {{ $support->status == 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td>
                                    @if($support->verified)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> متحقق
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-clock"></i> غير متحقق
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.support.show', $support->id) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.support.edit', $support->id) }}" 
                                           class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.support.toggle-status', $support->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $support->status == 'active' ? 'warning' : 'success' }}"
                                                    title="{{ $support->status == 'active' ? 'تعطيل' : 'تفعيل' }}">
                                                <i class="bi bi-power"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.support.toggle-verification', $support->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $support->verified ? 'secondary' : 'success' }}"
                                                    title="{{ $support->verified ? 'إلغاء التحقق' : 'تأكيد التحقق' }}">
                                                <i class="bi bi-{{ $support->verified ? 'x-circle' : 'check-circle' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.support.reset-views', $support->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="إعادة تعيين المشاهدات">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.support.destroy', $support->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')"
                                                    title="حذف">
                                                <i class="bi bi-trash"></i>
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
                    {{ $supports->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-chat-heart display-1 text-muted"></i>
                    <h5 class="mt-3">لا توجد خدمات دعم</h5>
                    <p class="text-muted">لم يتم إضافة أي خدمات دعم بعد</p>
                    <a href="{{ route('admin.support.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> إضافة أول خدمة دعم
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection