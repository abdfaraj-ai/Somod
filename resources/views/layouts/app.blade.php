<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>منصة صمود - SaMod</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-3" href="{{ route('home') }}" onclick="switchView('home'); return false;">
            <img width="150" src="assets/images/logo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-2 p-lg-0">
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="{{ route('home') }}">الرئيسية</a></li>
            <li class="nav-item">
                <a class="nav-link px-3 fw-bold" href="{{ route('evacuation.index') }}">خريطة الإخلاء</a>
            </li>                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="{{ route('market.index') }}">السوق</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="{{ route('services.index') }}">دليل الخدمات</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="{{ route('support.index') }}" >دعم نفسي</a></li>
                <li class="nav-item"><a class="nav-link px-3 fw-bold" href="{{ route('stories.index') }}" >قصص الصمود</a></li>
            </ul>
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                @auth
                    <span class="text-white me-3" style="margin-top:10px;">مرحباً {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="margin-top:7px;" class="btn btn-outline-light btn-sm">تسجيل الخروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm d-none d-lg-block rounded-pill px-3">تسجيل الدخول</a>
                    <a href="{{ route('frontend.sos') }}" class="btn btn-danger fw-bold d-flex align-items-center gap-2 rounded-pill px-3">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        نداء استغاثة
                    </a>
                @endauth
                

            </div>
            </div>
        </div>
    </nav>
    

    <!-- المحتوى -->
    <main class="flex-grow-1 container py-4">
        @yield('content')
    </main>

    <!-- التذييل -->
    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-auto border-top border-secondary">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-shield-fill-check fs-5"></i>
                        </div>
                        <h5 class="m-0 fw-bold">منصة صمود</h5>
                    </div>
                    <p class="text-white-50 small leading-relaxed">منصة مجتمعية غير ربحية تهدف لتعزيز صمود المجتمع وتوفير المعلومات الحيوية في أوقات الأزمات.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3 text-white">روابط سريعة</h6>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('frontend.sos') }}" onclick="switchView('sos'); return false;" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-left me-2 small"></i>نداء استغاثة</a></li>
                        <li><a href="{{ route('evacuation.index') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-left me-2 small"></i>خريطة الإخلاء</a></li>
                        <li><a href="{{ route('market.index') }}" onclick="switchView('market'); return false;" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-left me-2 small"></i>السوق المحلي</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3 text-white">تواصل معنا</h6>
                    <div class="d-flex gap-3 mb-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                    <p class="small text-white-50">للطوارئ والتبليغ عن مشاكل تقنية.</p>
                </div>
            </div>
            <hr class="border-secondary opacity-25 my-4" />
            <div class="text-center small text-white-50">جميع الحقوق محفوظة &copy; 2026 منصة صمود - غزة</div>
        </div>
    </footer>


  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>