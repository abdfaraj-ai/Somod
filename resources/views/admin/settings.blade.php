@extends('layouts.admin')

@section('title', 'إعدادات النظام')
@section('page-title', 'إعدادات النظام')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-gear-fill me-2"></i>الإعدادات العامة</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">معلومات الموقع</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم الموقع</label>
                                <input type="text" name="site_name" class="form-control" 
                                       value="{{ old('site_name', 'منصة صمود') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">البريد الإلكتروني للتواصل</label>
                                <input type="email" name="contact_email" class="form-control" 
                                       value="{{ old('contact_email', 'info@samod.ps') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">إعدادات العرض</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">عدد العناصر في الصفحة</label>
                                <input type="number" name="items_per_page" class="form-control" 
                                       value="{{ old('items_per_page', 20) }}" min="5" max="100">
                                <small class="text-muted">عدد العناصر المعروضة في الجداول</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المنطقة الافتراضية</label>
                                <select name="default_area" class="form-select">
                                    <option value="مدينة غزة">مدينة غزة</option>
                                    <option value="شمال غزة">شمال غزة</option>
                                    <option value="النصيرات">النصيرات</option>
                                    <option value="دير البلح">دير البلح</option>
                                    <option value="خانيونس">خانيونس</option>
                                    <option value="رفح">رفح</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">إعدادات الأمان</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="registration_enabled" 
                                   id="registration_enabled" checked>
                            <label class="form-check-label" for="registration_enabled">تفعيل التسجيل للمستخدمين الجدد</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="email_verification" 
                                   id="email_verification">
                            <label class="form-check-label" for="email_verification">التأكيد عبر البريد الإلكتروني</label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">إعدادات الإشعارات</h6>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="notify_new_users" 
                                   id="notify_new_users" checked>
                            <label class="form-check-label" for="notify_new_users">إشعار عند تسجيل مستخدم جديد</label>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i> حفظ الإعدادات
                        </button>
                        <button type="reset" class="btn btn-secondary">إعادة تعيين</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- System Info -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>معلومات النظام</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>إصدار Laravel:</strong>
                    <span class="float-start">{{ app()->version() }}</span>
                </div>
                <div class="mb-3">
                    <strong>بيئة التشغيل:</strong>
                    <span class="float-start">{{ app()->environment() }}</span>
                </div>
                <div class="mb-3">
                    <strong>المنطقة الزمنية:</strong>
                    <span class="float-start">{{ config('app.timezone') }}</span>
                </div>
                <div class="mb-3">
                    <strong>وقت الخادم:</strong>
                    <span class="float-start">{{ now()->format('Y-m-d H:i:s') }}</span>
                </div>
                <div class="mb-3">
                    <strong>حالة التخزين:</strong>
                    <span class="float-start">
                        @if(disk_free_space('/') !== false)
                            {{ number_format(disk_free_space('/') / (1024 * 1024 * 1024), 2) }} GB متاحة
                        @else
                            غير معروف
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning-fill me-2"></i>إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" onclick="clearCache()">
                        <i class="bi bi-trash me-2"></i> مسح ذاكرة التخزين المؤقت
                    </button>
                    <button class="btn btn-outline-warning text-start" onclick="backupDatabase()">
                        <i class="bi bi-database me-2"></i> نسخ قاعدة البيانات احتياطي
                    </button>
                    <button class="btn btn-outline-danger text-start" onclick="showMaintenanceModal()">
                        <i class="bi bi-wrench me-2"></i> وضع الصيانة
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">وضع الصيانة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل تريد تفعيل وضع الصيانة؟ سيتم إغلاق الموقع أمام المستخدمين العاديين.</p>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="allowAdmins">
                    <label class="form-check-label" for="allowAdmins">
                        السماح للمسؤولين بالدخول
                    </label>
                </div>
                <div class="mb-3">
                    <label class="form-label">رسالة الصيانة</label>
                    <textarea class="form-control" rows="3" placeholder="يتم إجراء صيانة للنظام..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" onclick="enableMaintenance()">تفعيل</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function clearCache() {
        if (confirm('هل أنت متأكد من مسح ذاكرة التخزين المؤقت؟')) {
            fetch('/admin/clear-cache', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم مسح ذاكرة التخزين المؤقت بنجاح');
                }
            });
        }
    }
    
    function backupDatabase() {
        alert('جاري إنشاء نسخة احتياطية...');
        // هنا يمكنك إضافة API endpoint لنسخ قاعدة البيانات
    }
    
    function showMaintenanceModal() {
        const modal = new bootstrap.Modal(document.getElementById('maintenanceModal'));
        modal.show();
    }
    
    function enableMaintenance() {
        // تفعيل وضع الصيانة
        alert('تم تفعيل وضع الصيانة');
        document.getElementById('maintenanceModal').querySelector('.btn-close').click();
    }
</script>
@endpush
@endsection