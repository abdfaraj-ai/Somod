@extends('layouts.admin')

@section('title', 'الإحصائيات')
@section('page-title', 'إحصائيات النظام')

@section('content')
<div class="row">
    <!-- Daily Stats -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-calendar-day me-2"></i>إحصائيات اليوم</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="bg-primary bg-opacity-10 rounded p-3 mb-3">
                            <i class="bi bi-door-open-fill fs-1 text-primary"></i>
                        </div>
                        <h3>{{ $dailyStats['logins_today'] }}</h3>
                        <p class="text-muted mb-0">تسجيلات دخول</p>
                    </div>
                    <div class="col-6">
                        <div class="bg-success bg-opacity-10 rounded p-3 mb-3">
                            <i class="bi bi-person-plus-fill fs-1 text-success"></i>
                        </div>
                        <h3>{{ $dailyStats['registrations_today'] }}</h3>
                        <p class="text-muted mb-0">مستخدمين جدد</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-pie-chart-fill me-2"></i>توزيع الأدوار</h6>
            </div>
            <div class="card-body">
                <canvas id="roleChart" height="200"></canvas>
                <div class="mt-3 text-center">
                    <div class="d-inline-block mx-3">
                        <span class="badge bg-primary me-1">●</span>
                        <span>مسؤولون: {{ $roleStats['admin'] ?? 0 }}</span>
                    </div>
                    <div class="d-inline-block mx-3">
                        <span class="badge bg-secondary me-1">●</span>
                        <span>مستخدمون: {{ $roleStats['user'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Distribution Table -->
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-map-fill me-2"></i>توزيع المستخدمين حسب المنطقة</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المنطقة</th>
                                <th>عدد المستخدمين</th>
                                <th>النسبة</th>
                                <th>المسؤولين</th>
                                <th>المستخدمين</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areaStats as $area)
                            @php
                                $totalInArea = \App\Models\User::where('area', $area->area)->count();
                                $adminsInArea = \App\Models\User::where('area', $area->area)->where('role', 'admin')->count();
                                $usersInArea = $totalInArea - $adminsInArea;
                                $percentage = $totalInArea > 0 ? ($area->count / $totalInArea) * 100 : 0;
                            @endphp
                            <tr>
                                <td>
                                    <i class="bi bi-geo-alt me-2"></i>
                                    {{ $area->area ?: 'غير محدد' }}
                                </td>
                                <td>{{ $area->count }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1" style="height: 8px;">
                                            <div class="progress-bar bg-primary" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="ms-2">{{ number_format($percentage, 1) }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $adminsInArea }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $usersInArea }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Growth Chart -->
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>نمو المستخدمين خلال الشهر</h6>
            </div>
            <div class="card-body">
                <canvas id="growthChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // رسم بياني لتوزيع الأدوار
    const roleChartCtx = document.getElementById('roleChart').getContext('2d');
    const roleChart = new Chart(roleChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['مسؤولون', 'مستخدمون'],
            datasets: [{
                data: [{{ $roleStats['admin'] ?? 0 }}, {{ $roleStats['user'] ?? 0 }}],
                backgroundColor: ['#dc3545', '#6c757d'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true
                }
            }
        }
    });

    // رسم بياني للنمو (مثال)
    const growthChartCtx = document.getElementById('growthChart').getContext('2d');
    const growthChart = new Chart(growthChartCtx, {
        type: 'line',
        data: {
            labels: ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4'],
            datasets: [{
                label: 'مستخدمين جدد',
                data: [12, 19, 8, 15],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
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
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection