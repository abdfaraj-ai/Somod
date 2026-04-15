<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - صمود</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f5f7fb;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            right: 0;
            top: 0;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .main-content {
            margin-right: 250px;
            transition: all 0.3s;
        }
        
        .sidebar.collapsed {
            right: -250px;
        }
        
        .main-content.expanded {
            margin-right: 0;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-link.active {
            color: white;
            background-color: var(--primary-color);
        }
        
        .nav-link i {
            width: 20px;
            margin-left: 10px;
        }
        
        .stat-card {
            border-radius: 15px;
            border: none;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
        }
        
        .badge-sm {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                right: -250px;
            }
            
            .sidebar.show {
                right: 0;
            }
            
            .main-content {
                margin-right: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex align-items-center">
            <div class="bg-white text-dark rounded-circle p-2 me-3">
                <i class="bi bi-shield-fill-check fs-5"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">لوحة التحكم</h6>
                <small class="text-white-50">منصة صمود</small>
            </div>
        </div>
        
        <nav class="nav flex-column mt-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>لوحة التحكم</span>
            </a>
            
            <div class="px-3 mt-3 mb-1 text-white-50 small">إدارة المحتوى</div>
            
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>المستخدمين</span>
                <span class="badge bg-primary float-start">{{ \App\Models\User::count() }}</span>
            </a>
            
            
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-hospital me-2"></i>
                <span>الخدمات</span>
                <span class="badge bg-primary float-start">{{ \App\Models\Service::count() }}</span>
            </a>

            <a href="{{ route('admin.evacuation.index') }}" class="nav-link {{ request()->routeIs('admin.evacuation.*') ? 'active' : '' }}">
                <i class="bi bi-map me-2"></i>
                <span>خريطة الإخلاء</span>
                <span class="badge bg-primary float-start">{{ \App\Models\EvacuationMap::count() }}</span>
            </a>

            <a href="{{ route('admin.market.index') }}" class="nav-link {{ request()->routeIs('admin.market.*') ? 'active' : '' }}">
                <i class="bi bi-shop me-2"></i>
                <span>السوق</span>
                <span class="badge bg-primary float-start">{{ \App\Models\MarketItem::count() }}</span>
            </a>

            <a href="{{ route('admin.stories.index') }}" class="nav-link {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}">
                <i class="fas fa-book-open me-2"></i>
                <span>قصص الصمود</span>
                <span class="badge bg-primary float-start">{{ \App\Models\Story::count() }}</span>
            </a>

            <a href="{{ route('admin.support.index') }}" class="nav-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                <i class="bi bi-chat-heart me-2"></i>
                <span>الدعم النفسي</span>
                <span class="badge bg-success float-start">{{ \App\Models\Support::count() }}</span>
            </a>

            <a href="{{ route('distress-calls.index') }}" class="nav-link {{ request()->routeIs('distress-calls.*') ? 'active' : '' }}">
                <i class="bi bi-chat-heart me-2"></i>
                <span> نداءات الاستغاثة</span>
                <span class="badge bg-success float-start">{{ \App\Models\DistressCall::count() }}</span>
            </a>
                                    
            <div class="px-3 mt-3 mb-1 text-white-50 small">الإحصائيات</div>
            
            <a href="{{ route('admin.stats') }}" class="nav-link {{ request()->routeIs('admin.stats') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                <span>الإحصائيات</span>
            </a>
            
            <div class="px-3 mt-3 mb-1 text-white-50 small">الإعدادات</div>
            
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>الإعدادات</span>
            </a>
            
            <hr class="text-white-50 mx-3 my-4">
            
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-house-door"></i>
                <span>العودة للموقع</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="px-3">
                @csrf
                <button type="submit" class="nav-link text-start w-100" style="background: none; border: none;">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
            
            <div class="px-3 mt-4">
                <div class="text-white-50 small mb-1">المسؤول الحالي:</div>
                <div class="d-flex align-items-center">
                    <div class="bg-primary rounded-circle p-2 me-2">
                        <i class="bi bi-person-fill text-white"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-white-50">{{ Auth::user()->email }}</small>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <nav class="navbar navbar-light bg-white border-bottom shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell-fill text-primary"></i>
                            <span class="badge bg-danger rounded-pill">1</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person-plus me-2"></i>مستخدم جديد مسجل</a></li>
                        </ul>
                    </div>
                    
                    <div class="dropdown ms-3">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="bg-primary rounded-circle p-2 me-2">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i>الإعدادات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">@yield('page-title')</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
                
                <div>
                    @yield('page-actions')
                </div>
            </div>
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Page Content -->
            @yield('content')
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }
        
        // حفظ حالة السايدبار في localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            const isCollapsed = localStorage.getItem('sidebar-collapsed');
            if (isCollapsed === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
            
            sidebar.addEventListener('transitionend', function() {
                const isNowCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebar-collapsed', isNowCollapsed);
            });
        });
        
        // تحديث الوقت الحالي
        function updateCurrentTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true 
            };
            const timeString = now.toLocaleDateString('ar-SA', options);
            if (document.getElementById('current-time')) {
                document.getElementById('current-time').textContent = timeString;
            }
        }
        
        setInterval(updateCurrentTime, 1000);
        updateCurrentTime();
    </script>
    
    @stack('scripts')
</body>
</html>