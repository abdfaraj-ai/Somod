@extends('layouts.admin')

@section('title', 'إدارة خريطة الإخلاء')
@section('page-title', 'إدارة خريطة الإخلاء')

@section('page-actions')
<div class="btn-group">
    <a href="{{ route('admin.evacuation.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> إضافة بلوك
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.evacuation.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">المنطقة</label>
                        <select name="area" class="form-select">
                            <option value="all" {{ request('area') == 'all' ? 'selected' : '' }}>الكل</option>
                            @foreach($areas as $areaName)
                            <option value="{{ $areaName }}" {{ request('area') == $areaName ? 'selected' : '' }}>{{ $areaName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="safe" {{ request('status') == 'safe' ? 'selected' : '' }}>آمن</option>
                            <option value="warning" {{ request('status') == 'warning' ? 'selected' : '' }}>تحذير</option>
                            <option value="danger" {{ request('status') == 'danger' ? 'selected' : '' }}>خطر</option>
                            <option value="evacuation" {{ request('status') == 'evacuation' ? 'selected' : '' }}>إخلاء</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">مصدر التحديث</label>
                        <select name="source" class="form-select">
                            <option value="all" {{ request('source') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="official" {{ request('source') == 'official' ? 'selected' : '' }}>رسمي</option>
                            <option value="community" {{ request('source') == 'community' ? 'selected' : '' }}>مجتمعي</option>
                            <option value="system" {{ request('source') == 'system' ? 'selected' : '' }}>نظام</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="رقم بلوك أو منطقة..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="bulkForm" action="{{ route('admin.evacuation.bulk-update') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">تحديث حالة متعددة</label>
                            <select name="status" class="form-select" required>
                                <option value="">اختر الحالة...</option>
                                <option value="safe">آمن</option>
                                <option value="warning">تحذير</option>
                                <option value="danger">خطر</option>
                                <option value="evacuation">إخلاء</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الوصف (اختياري)</label>
                            <input type="text" name="description" class="form-control" placeholder="سبب التحديث...">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('هل أنت متأكد؟')">
                                <i class="bi bi-arrow-repeat me-2"></i> تحديث المحدد
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Blocks Table -->
        <div class="card shadow">
            <div class="card-body">
                @if($blocks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>رقم البلوك</th>
                                <th>المنطقة</th>
                                <th>الحالة</th>
                                <th>السكان</th>
                                <th>الخدمات</th>
                                <th>مصدر التحديث</th>
                                <th>آخر تحديث</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blocks as $block)
                            <tr>
                                <td>
                                    <input type="checkbox" name="blocks[]" value="{{ $block->id }}" class="block-checkbox">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $block->block_number }}</div>
                                    <small class="text-muted">{{ Str::limit($block->description, 30) }}</small>
                                </td>
                                <td>{{ $block->area }}</td>
                                <td>
                                    <span class="badge bg-{{ $block->status_color }}">
                                        <i class="bi {{ $block->status_icon }} me-1"></i>
                                        {{ $block->status_arabic }}
                                    </span>
                                </td>
                                <td>{{ $block->population ?? '--' }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if($block->has_shelter)
                                        <span class="badge bg-success" title="ملجأ"><i class="bi bi-house-heart"></i></span>
                                        @endif
                                        @if($block->has_medical)
                                        <span class="badge bg-danger" title="طبي"><i class="bi bi-heart-pulse"></i></span>
                                        @endif
                                        @if($block->has_water)
                                        <span class="badge bg-info" title="مياه"><i class="bi bi-droplet"></i></span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $block->update_source_arabic }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $block->last_updated ? $block->last_updated->diffForHumans() : '--' }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.evacuation.show', $block->id) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.evacuation.edit', $block->id) }}" 
                                           class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.evacuation.update-status', $block->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" title="تغيير الحالة">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.evacuation.destroy', $block->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا البلوك؟')"
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
                    {{ $blocks->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-map display-1 text-muted"></i>
                    <h5 class="mt-3">لا توجد بلوكات</h5>
                    <p class="text-muted">لم يتم إضافة أي بلوكات بعد</p>
                    <a href="{{ route('admin.evacuation.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> إضافة أول بلوك
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">استيراد بيانات CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.evacuation.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">اختر ملف CSV</label>
                        <input type="file" name="file" class="form-control" accept=".csv,.txt" required>
                        <small class="text-muted">يجب أن يحتوي الملف على الأعمدة: block_number, area, status, description</small>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>البيانات الموجودة سيتم تحديثها بناءً على رقم البلوك</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">استيراد</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.block-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Update bulk form with selected checkboxes
    document.getElementById('bulkForm').addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('.block-checkbox:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('يرجى اختيار بلوك واحد على الأقل');
            return false;
        }
        
        // Add selected blocks to form
        checkboxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'blocks[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
</script>
@endpush