@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('content')
<div class="row">
    <!-- Stat Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            إجمالي المستخدمين
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="bi bi-arrow-up"></i> {{ $stats['new_users_today'] }}
                            </span>
                            <span class="text-muted">جديد اليوم</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            المستخدمين النشطين
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_users'] }}</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </span>
                            <span class="text-muted">{{ number_format(($stats['active_users'] / $stats['total_users']) * 100, 1) }}%</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-check-fill fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            المسؤولين
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['admins_count'] }}</div>
                        <div class="mt-2">
                            <span class="text-warning">
                                <i class="bi bi-shield-fill-check"></i>
                            </span>
                            <span class="text-muted">مسؤول</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-shield-fill fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            نسبة النمو
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">24.5%</div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class="bi bi-arrow-up-right"></i> 12.4%
                            </span>
                            <span class="text-muted">الشهر الماضي</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-graph-up-arrow fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">تسجيلات المستخدمين خلال الأسبوع</h6>
                <select class="form-select form-select-sm w-auto" id="chartPeriod">
                    <option value="7" selected>7 أيام</option>
                    <option value="30">30 يوم</option>
                    <option value="90">90 يوم</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Users by Area -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">توزيع المستخدمين حسب المنطقة</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="areaChart"></canvas>
                </div>
                <div class="mt-4 small">
                    @foreach($usersByArea as $area)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $area->area ?: 'غير محدد' }}</span>
                        <span class="fw-bold">{{ $area->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">آخر المستخدمين المسجلين</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">عرض الكل</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>المنطقة</th>
                                <th>الدور</th>
                                <th>تاريخ التسجيل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $user->area }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'secondary' }}">
                                        {{ $user->role == 'admin' ? 'مسؤول' : 'مستخدم' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'warning' }}">
                                        {{ $user->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // رسم بياني لتسجيلات المستخدمين
    const usersChartCtx = document.getElementById('usersChart').getContext('2d');
    const usersChart = new Chart(usersChartCtx, {
        type: 'line',
        data: {
            labels: @json($userRegistrations->pluck('date')),
            datasets: [{
                label: 'عدد التسجيلات',
                data: @json($userRegistrations->pluck('count')),
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    rtl: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // رسم بياني دائري للمناطق
    const areaChartCtx = document.getElementById('areaChart').getContext('2d');
    const areaChart = new Chart(areaChartCtx, {
        type: 'doughnut',
        data: {
            labels: @json($usersByArea->pluck('area')),
            datasets: [{
                data: @json($usersByArea->pluck('count')),
                backgroundColor: [
                    '#0d6efd', '#6c757d', '#198754', '#ffc107',
                    '#0dcaf0', '#6610f2', '#fd7e14', '#20c997'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                    rtl: true
                }
            }
        }
    });
</script>
@endpush
@endsection