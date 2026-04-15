@extends('layouts.admin')

@section('title', 'إدارة الخدمات')
@section('page-title', 'إدارة الخدمات')

@section('page-actions')
<a href="{{ route('admin.services.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> إضافة خدمة
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.services.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الفئة</label>
                        <select name="category" class="form-select">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="medical" {{ request('category') == 'medical' ? 'selected' : '' }}>طبي</option>
                            <option value="shelter" {{ request('category') == 'shelter' ? 'selected' : '' }}>إيواء</option>
                            <option value="edu" {{ request('category') == 'edu' ? 'selected' : '' }}>تعليم</option>
                            <option value="org" {{ request('category') == 'org' ? 'selected' : '' }}>مؤسسات</option>
                            <option value="water" {{ request('category') == 'water' ? 'selected' : '' }}>مياه</option>
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
                        <label class="form-label">حالة التحقق</label>
                        <select name="verified" class="form-select">
                            <option value="all" {{ request('verified') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="verified" {{ request('verified') == 'verified' ? 'selected' : '' }}>متحقق</option>
                            <option value="unverified" {{ request('verified') == 'unverified' ? 'selected' : '' }}>غير متحقق</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="اسم الخدمة أو العنوان..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Services Table -->
        <div class="card shadow">
            <div class="card-body">
                @if($services->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الخدمة</th>
                                <th>الفئة</th>
                                <th>العنوان</th>
                                <th>الحالة</th>
                                <th>التحقق</th>
                                <th>تاريخ الإضافة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-{{ $service->category_color }} text-white rounded-circle p-2 me-3">
                                            <i class="bi {{ $service->category_icon }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $service->name }}</div>
                                            <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $service->category_color }}">
                                        {{ $service->category_arabic }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($service->address, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $service->status == 'active' ? 'success' : 'warning' }}">
                                        {{ $service->status == 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td>
                                    @if($service->verified)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> متحقق
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-clock"></i> غير متحقق
                                    </span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.services.show', $service->id) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service->id) }}" 
                                           class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.services.toggle-status', $service->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $service->status == 'active' ? 'warning' : 'success' }}"
                                                    title="{{ $service->status == 'active' ? 'تعطيل' : 'تفعيل' }}">
                                                <i class="bi bi-power"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.services.toggle-verification', $service->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-{{ $service->verified ? 'secondary' : 'success' }}"
                                                    title="{{ $service->verified ? 'إلغاء التحقق' : 'تأكيد التحقق' }}">
                                                <i class="bi bi-{{ $service->verified ? 'x-circle' : 'check-circle' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" 
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
                    {{ $services->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h5 class="mt-3">لا توجد خدمات</h5>
                    <p class="text-muted">لم يتم إضافة أي خدمات بعد</p>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> إضافة أول خدمة
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection