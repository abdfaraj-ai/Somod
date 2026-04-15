@extends('layouts.admin')

@section('title', 'إحصائيات السوق')
@section('page-title', 'إحصائيات السوق')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.market.index') }}">السوق</a></li>
<li class="breadcrumb-item active">الإحصائيات</li>
@endsection

@section('page-actions')
<a href="{{ route('admin.market.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-right"></i> العودة
</a>
@endsection

@section('content')
<div class="row">
    <!-- Category Stats -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-pie-chart text-primary me-2"></i>توزيع السلع حسب الفئة</h6>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" height="200"></canvas>
                <div class="mt-3">
                    @foreach($categoryStats as $stat)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $stat->category_arabic }}</span>
                        <span class="fw-bold">{{ $stat->count }}</span>
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        @php
                            $total = $categoryStats->sum('count');
                            $percentage = $total > 0 ? ($stat->count / $total) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Availability Stats -->
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bar-chart text-primary me-2"></i>توزيع السلع حسب التوفر</h6>
            </div>
            <div class="card-body">
                <canvas id="availabilityChart" height="200"></canvas>
                <div class="mt-3">
                    @foreach($availabilityStats as $stat)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $stat->availability_arabic }}</span>
                        <span class="fw-bold">{{ $stat->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Stats -->
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-calendar text-primary me-2"></i>السلع المضافة خلال الأسبوع</h6>
            </div>
            <div class="card-body">
                <canvas id="weeklyChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Users -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-people text-primary me-2"></i>أكثر المستخدمين إضافة</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($topUsers as $index => $user)
                    <div class="list-group-item border-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <span class="fw-bold">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->items_count }} سلعة</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-eye text-primary fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ number_format(\App\Models\MarketItem::sum('views')) }}</h3>
                        <p class="text-muted mb-0">إجمالي المشاهدات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-exchange text-success fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ number_format(\App\Models\MarketItem::avg('price') ?? 0, 2) }}</h3>
                        <p class="text-muted mb-0">متوسط السعر</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                        <h3 class="fw-bold">{{ \App\Models\MarketItem::whereDate('created_at', today())->count() }}</h3>
                        <p class="text-muted mb-0">سلع اليوم</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-chat-dots text-info fs-1 mb-2"></i>
                        <h3 class="fw-bold">0</h3>
                        <p class="text-muted mb-0">التعليقات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categoryStats->pluck('category_arabic')),
            datasets: [{
                data: @json($categoryStats->pluck('count')),
                backgroundColor: ['#0d6efd', '#6c757d', '#198754', '#ffc107']
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

    // Availability Chart
    const availabilityCtx = document.getElementById('availabilityChart').getContext('2d');
    const availabilityChart = new Chart(availabilityCtx, {
        type: 'bar',
        data: {
            labels: @json($availabilityStats->pluck('availability_arabic')),
            datasets: [{
                label: 'عدد السلع',
                data: @json($availabilityStats->pluck('count')),
                backgroundColor: ['#198754', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Weekly Chart
    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    const weeklyChart = new Chart(weeklyCtx, {
        type: 'line',
        data: {
            labels: @json($weeklyStats->pluck('date')),
            datasets: [{
                label: 'عدد السلع',
                data: @json($weeklyStats->pluck('count')),
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
                    display: false
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