@extends('layouts.app')

@section('content')
    <div class="sos-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Visual Header -->
                    <div class="text-center mb-5 animate__animated animate__pulse animate__infinite animate__slower">
                        <div class="d-inline-flex justify-content-center align-items-center rounded-circle bg-danger bg-opacity-10 p-4 mb-3"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-exclamation-triangle-fill text-danger display-3"></i>
                        </div>
                        <h1 class="text-danger fw-bold display-4">نداء استغاثة</h1>
                        <p class="lead text-muted">نحن هنا لخدمتك 24/7. إذا كنت في خطر أو تحتاج لمساعدة عاجلة، لا تتردد.</p>
                    </div>

                    <!-- SOS Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-danger opacity-0"
                            style="pointer-events: none; z-index: 0;"></div>

                        <div class="card-header bg-danger text-white text-center py-4 position-relative z-1">
                            <h4 class="m-0 fw-bold"><i class="bi bi-broadcast me-2"></i> نموذج الطوارئ</h4>
                        </div>

                        <div class="card-body p-4 p-md-5 position-relative z-1 bg-white">
                            @if(session('success'))
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @else

                                <form action="{{ route('frontend.sos.submit') }}" method="POST">
                                    @csrf
                                    <!-- Honeypot -->
                                    <div style="display: none;">
                                        <input type="text" name="robot_check" value="">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-uppercase text-danger">الاسم الكامل</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i
                                                    class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="name" class="form-control bg-light border-0 py-3" required
                                                placeholder="من يطلب المساعدة؟">
                                        </div>
                                    </div>

                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-uppercase text-danger">رقم
                                                الهاتف</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i
                                                        class="bi bi-telephone text-muted"></i></span>
                                                <input type="tel" name="phone_number"
                                                    class="form-control bg-light border-0 py-3" required
                                                    placeholder="للتواصل العاجل">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-uppercase text-danger">العنوان
                                                التفصيلي</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0"><i
                                                        class="bi bi-geo-alt text-muted"></i></span>
                                                <input type="text" name="detailed_address"
                                                    class="form-control bg-light border-0 py-3" required
                                                    placeholder="أقرب معلم، رقم الشارع...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label fw-bold small text-uppercase text-danger">وصف الحالة / الاحتياج
                                            العاجل</label>
                                        <textarea name="description" class="form-control bg-light border-0 py-3" rows="5"
                                            required placeholder="اشرح لنا ماذا يحدث وماذا تحتاج..."></textarea>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit"
                                            class="btn btn-danger btn-lg py-3 rounded-pill fw-bold fs-5 shadow-sm hover-scale header-sos-btn">
                                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                                aria-hidden="true"></span>
                                            إرسال نداء الاستغاثة فوراً
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted small">جميع البيانات يتم التعامل معها بسرية تامة وتصل فوراً لغرفة العمليات
                            المركزية.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        .header-sos-btn {
            animation: pulse-red 2s infinite -1s;
        }

        @keyframes pulse-red {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                transform: scale(1.03);
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
    </style>
@endsection