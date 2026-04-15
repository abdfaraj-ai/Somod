@extends('layouts.admin')

@section('title', 'إدارة السوق')
@section('page-title', 'إدارة السوق')

@section('page-actions')
<a href="{{ route('admin.market.statistics') }}" class="btn btn-outline-primary">
    <i class="bi bi-bar-chart"></i> الإحصائيات
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-box-seam text-primary fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ $stats['total'] }}</h3>
                        <p class="text-muted mb-0">إجمالي السلع</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ $stats['active'] }}</h3>
                        <p class="text-muted mb-0">نشطة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-clock text-warning fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ $stats['pending'] }}</h3>
                        <p class="text-muted mb-0">قيد المراجعة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-x-circle text-danger fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ $stats['rejected'] }}</h3>
                        <p class="text-muted mb-0">مرفوضة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.market.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">الفئة</label>
                        <select name="category" class="form-select">
                            <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>مواد غذائية</option>
                            <option value="energy" {{ request('category') == 'energy' ? 'selected' : '' }}>طاقة ووقود</option>
                            <option value="medical" {{ request('category') == 'medical' ? 'selected' : '' }}>صحة وأدوية</option>
                            <option value="services" {{ request('category') == 'services' ? 'selected' : '' }}>خدمات</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشطة</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">حالة التوفر</label>
                        <select name="availability" class="form-select">
                            <option value="all" {{ request('availability') == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>متوفر</option>
                            <option value="scarce" {{ request('availability') == 'scarce' ? 'selected' : '' }}>شحيح</option>
                            <option value="out" {{ request('availability') == 'out' ? 'selected' : '' }}>غير متوفر</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">بحث</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="اسم السلعة أو البائع..." value="{{ request('search') }}">
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
                <form id="bulkForm" action="{{ route('admin.market.bulk-update') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">إجراء جماعي</label>
                            <select name="action" class="form-select" required>
                                <option value="">اختر الإجراء...</option>
                                <option value="approve">موافقة</option>
                                <option value="reject">رفض</option>
                                <option value="suspend">تعليق</option>
                                <option value="delete">حذف</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirmBulkAction()">
                                <i class="bi bi-play-circle me-2"></i> تنفيذ على المحدد
                            </button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    تحديد الكل
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Items Table -->
        <div class="card shadow">
            <div class="card-body">
                @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>السلعة</th>
                                <th>الفئة</th>
                                <th>السعر</th>
                                <th>التوفر</th>
                                <th>البائع</th>
                                <th>الحالة</th>
                                <th>المشاهدات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}" class="item-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="bi {{ $item->category_icon }} text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $item->name }}</div>
                                            <small class="text-muted">{{ Str::limit($item->location, 20) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-dark">{{ $item->category_arabic }}</span>
                                </td>
                                <td>
                                    @if($item->price)
                                    <span class="fw-bold text-success">{{ number_format($item->price) }} شيكل</span>
                                    @else
                                    <span class="text-muted">بدون سعر</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $item->availability_color }}">
                                        {{ $item->availability_arabic }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->user)
                                    <div>
                                        <div class="fw-bold">{{ $item->user->name }}</div>
                                        <small class="text-muted">{{ $item->user->email }}</small>
                                    </div>
                                    @else
                                    <span class="text-muted">غير معروف</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $item->status_color }}">
                                        {{ $item->status_arabic }}
                                    </span>
                                </td>
                                <td>{{ $item->views }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.market.show', $item->id) }}" 
                                           class="btn btn-sm btn-info" title="عرض">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if($item->status != 'active')
                                        <form action="{{ route('admin.market.approve', $item->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="موافقة">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        @if($item->status != 'rejected')
                                        <form action="{{ route('admin.market.reject', $item->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-danger" title="رفض">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        @if($item->status != 'pending')
                                        <form action="{{ route('admin.market.suspend', $item->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" title="تعليق">
                                                <i class="bi bi-pause"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.market.destroy', $item->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-dark" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه السلعة؟')"
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
                    {{ $items->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h5 class="mt-3">لا توجد سلع</h5>
                    <p class="text-muted">لم يتم إضافة أي سلع بعد</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    document.getElementById('checkAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    function confirmBulkAction() {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('يرجى اختيار سلعة واحدة على الأقل');
            return false;
        }
        
        const action = document.querySelector('select[name="action"]').value;
        if (!action) {
            alert('يرجى اختيار إجراء');
            return false;
        }
        
        return confirm(`هل أنت متأكد من ${action} ${checkboxes.length} سلعة؟`);
    }
    
    // Update bulk form with selected checkboxes
    document.getElementById('bulkForm').addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('.item-checkbox:checked');
        if (checkboxes.length === 0) {
            e.preventDefault();
            alert('يرجى اختيار سلعة واحدة على الأقل');
            return false;
        }
        
        // Add selected items to form
        checkboxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'items[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
</script>
@endpush