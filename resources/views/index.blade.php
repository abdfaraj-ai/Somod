@extends('layouts.app')

@section('content')

    



    <!-- نفس محتوى view-home من index.html -->
        <!-- Home View -->
        <div id="view-home" class="view-section active">
            <!-- Hero Banner -->
            <div class="rounded-4 shadow-sm p-4 p-lg-5 mb-5 hero-bg position-relative overflow-hidden">
                <div class="row align-items-center position-relative z-1">
                  <div class="col-lg-7">
                    <span class="badge bg-white text-success mb-3 px-3 py-2 rounded-pill shadow-sm fw-bold">تحديث مستمر ٢٤ ساعة</span>
                    <h1 class="display-4 fw-bold mb-3">معاً نصمد 🇵🇸</h1>
                    <p class="lead mb-4 opacity-90">منصتك الرقمية المتكاملة لدعم الحياة اليومية في غزة. نربطك بالمراكز الطبية، الأسواق، مناطق الإخلاء، والدعم النفسي.</p>
                    <div class="d-flex gap-3 flex-wrap">
                      <a href="{{ route('evacuation.index') }}"><button onclick="switchView('evacuation')" class="btn btn-light text-success btn-lg px-4 fw-bold rounded-pill shadow-sm"><i class="bi bi-map-fill me-2"></i> الخريطة</button>
                    </a>
                      <a href="{{ route('market.index') }}"><button onclick="switchView('market')" class="btn btn-outline-light btn-lg px-4 fw-bold rounded-pill"><i class="bi bi-bag-fill me-2"></i> السوق</button>
                    </a>
                    </div>
                  </div>
                  <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    <div class="hero-img-container">
                        <i class="bi bi-heart-pulse-fill" style="font-size: 8rem;"></i>
                    </div>
                  </div>
                </div>
                <!-- Abstract BG shapes -->
                <i class="bi bi-geo-alt-fill position-absolute text-white opacity-10" style="top: -20px; left: -20px; font-size: 15rem;"></i>
                <i class="bi bi-shield-fill-check position-absolute text-white opacity-10" style="bottom: -50px; left: 50%; font-size: 10rem;"></i>
            </div>
            
        
 <!-- رسالة المنصة (About) -->
    <section id="about">
        <div class="container">
            <div class="bg-light rounded-[50px] p-5 p-lg-5 overflow-hidden position-relative">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="p-lg-4">
                            <h2 class="display-6 fw-black mb-4">رسالة من قلب غزة</h2>
                            <p class="fs-5 text-dark mb-4 border-end border-success border-5 pe-4">
                                "صمود ليست مجرد خدمة رقمية، بل هي رسالة توثّق إصرارنا على الحياة والوقوف بجانب أهلنا في أحلك الظروف."
                            </p>
                            <p class="text-muted">
                                انطلقت منصة صمود كمساحة رقمية آمنة وسريعة للوصول إلى المعلومات التي قد تنقذ حياة. نحن نجمع البيانات من الميدان ومن المصادر الموثوقة لنضعها بين يديك، لنساهم ولو بجزء بسيط في تخفيف المعاناة وتعزيز الثبات.
                            </p>
                            <div class="mt-5">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-check-circle text-success me-3 fs-4"></i>
                                    <span class="fw-bold">بيانات ميدانية موثوقة بنسبة 100%</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-3 fs-4"></i>
                                    <span class="fw-bold">خصوصية تامة لجميع المستخدمين</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=1000" class="img-fluid rounded-5 shadow-lg" alt="About Image">
                    </div>
                </div>
            </div>
        </div>
    </section>


            <div class="row g-4">
                <!-- Services Grid -->
                <div class="col-lg-12">
                    <h4 class="fw-bold mb-4 d-flex align-items-center"><i class="bi bi-grid-fill text-primary me-2"></i> الخدمات الرئيسية</h4>
                    <div class="row g-4">
                        <!-- SOS Card -->
                        <div class="col-md-6 col-lg-3">
                             <div class="card h-100 border-0 shadow-sm hover-shadow cursor-pointer overflow-hidden rounded-4" onclick="switchView('sos')">
                                <div style="height: 120px; background: #fee2e2;" class="d-flex align-items-center justify-content-center">
                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 4rem; opacity: 0.3;"></i>
                                </div>
                                <a href="{{ route('frontend.sos') }}"> 
                                <div class="card-body text-center mt-n5 position-relative z-1">
                                    <div class="icon-box bg-danger text-white shadow mx-auto">
                                        <i class="bi bi-megaphone-fill fs-4"></i>
                                    </div>
                                    </a>
                                    <h5 class="fw-bold mt-3">نداء طوارئ</h5>
                                    <p class="text-muted small">إبلاغ فوري لجهات الاختصاص وتحديد الموقع.</p>
                                </div>
                             </div>
                        </div>
                        
                        <!-- Evacuation Card -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm hover-shadow cursor-pointer overflow-hidden rounded-4" onclick="switchView('evacuation')">
                               <div style="height: 120px; background: #e9ecef;" class="d-flex align-items-center justify-content-center">
                                   <i class="bi bi-map-fill text-dark" style="font-size: 4rem; opacity: 0.3;"></i>
                               </div>
                               <a href="{{ route('evacuation.index') }}"> 
                               <div class="card-body text-center mt-n5 position-relative z-1">
                                   <div class="icon-box bg-dark text-white shadow mx-auto">
                                       <i class="bi bi-geo-alt-fill fs-4"></i>
                                   </div>
                                   </a>
                                   <h5 class="fw-bold mt-3">خريطة الإخلاء</h5>
                                   <p class="text-muted small">مناطق العمليات والمناطق الآمنة.</p>
                               </div>
                            </div>
                       </div>
                       
                       <!-- Market Card -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card h-100 border-0 shadow-sm hover-shadow cursor-pointer overflow-hidden rounded-4" onclick="switchView('market')">
                               <div style="height: 120px; background: #cfe2ff;" class="d-flex align-items-center justify-content-center">
                                   <i class="bi bi-bag-check-fill text-primary" style="font-size: 4rem; opacity: 0.3;"></i>
                               </div>
                               <a href="{{ route('market.index') }}"> 
                               <div class="card-body text-center mt-n5 position-relative z-1">
                                   <div class="icon-box bg-primary text-white shadow mx-auto">
                                       <i class="bi bi-cart-fill fs-4"></i>
                                   </div>
                                   </a>
                                   <h5 class="fw-bold mt-3">السوق المحلي</h5>
                                   <p class="text-muted small">أسعار السلع وتوفر المواد الغذائية.</p>
                               </div>
                            </div>
                       </div>
                       
                       <!-- Services Card -->
                       <div class="col-md-6 col-lg-3">
                       <div class="card h-100 border-0 shadow-sm hover-shadow cursor-pointer overflow-hidden rounded-4">
                           <div style="height: 120px; background: #fff3cd;" class="d-flex align-items-center justify-content-center">
                               <i class="bi bi-hospital-fill text-warning" style="font-size: 4rem; opacity: 0.3;"></i>
                           </div>
                           <a href="{{ route('services.index') }}"> 
                           <div class="card-body text-center mt-n5 position-relative z-1">
                               <div class="icon-box bg-warning text-dark shadow mx-auto">
                                   <i class="bi bi-activity fs-4"></i>
                               </div>
                               </a>
                               <h5 class="fw-bold mt-3">دليل الخدمات</h5>
                               <p class="text-muted small">نقاط طبية، إنترنت، ومحطات تحلية.</p>
                           </div>
                        </div>
                        
                   </div>
                    </div>
                </div>
                
                <!-- Updates & Quick Info -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-bell-fill text-primary me-2"></i> تحديثات المجتمع</span>
                            <span class="badge bg-light text-dark rounded-pill">مباشر</span>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item py-3 border-0 border-bottom">
                                <div class="d-flex gap-3">
                                    <div class="icon-box bg-light text-success shadow-sm" style="width: 45px; height: 45px; margin:0;"><i class="bi bi-fuel-pump-fill"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold mb-1">توفر غاز طهي</h6>
                                            <small class="text-muted">10 د</small>
                                        </div>
                                        <p class="mb-0 text-muted small">متوفر الآن في محطة السلام - دير البلح. الكمية محدودة.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item py-3 border-0 border-bottom">
                                <div class="d-flex gap-3">
                                    <div class="icon-box bg-light text-primary shadow-sm" style="width: 45px; height: 45px; margin:0;"><i class="bi bi-basket-fill"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold mb-1">انخفاض سعر الطحين</h6>
                                            <small class="text-muted">45 د</small>
                                        </div>
                                        <p class="mb-0 text-muted small">السوق المركزي: انخفاض بنسبة 10% على كيس الدقيق الوكالة.</p>
                                    </div>
                                </div>
                            </li>
                             <li class="list-group-item py-3 border-0">
                                <div class="d-flex gap-3">
                                    <div class="icon-box bg-light text-warning shadow-sm" style="width: 45px; height: 45px; margin:0;"><i class="bi bi-lightning-charge-fill"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-bold mb-1">نقطة شحن جوالات</h6>
                                            <small class="text-muted">1 س</small>
                                        </div>
                                        <p class="mb-0 text-muted small">مخيم النصيرات - بجوار مسجد الدعوة. مجاناً من 10ص حتى 2م.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card bg-success text-white border-0 shadow-sm p-4 text-center rounded-4 h-100 position-relative overflow-hidden">
                        <i class="bi bi-chat-heart-fill position-absolute text-white opacity-25" style="top: -20px; right: -20px; font-size: 10rem;"></i>
                        <div class="position-relative z-1 d-flex flex-column h-100 justify-content-center align-items-center">
                            <div class="icon-box bg-white text-success shadow mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-headset fs-1"></i>
                            </div>
                            <h4 class="fw-bold">نحن هنا لأجلك</h4>
                            <p class="small opacity-90 mb-4">فريق متخصص من الأطباء والمرشدين النفسيين متاح للاستماع وتقديم المشورة.</p>
                            <button onclick="switchView('support')" class="btn btn-light text-success fw-bold w-100 rounded-pill shadow-sm">تحدث مع المرشد</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


   <!-- Market Add Modal -->
    <div class="modal fade" id="addMarketModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">إضافة تحديث للسوق</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="marketForm" onsubmit="submitMarketItem(event)">
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">اسم السلعة / الخدمة</label>
                            <input type="text" class="form-control bg-light border-0" id="m-name" required placeholder="مثال: ربطة خبز، شحن جوال">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">السعر (شيكل)</label>
                                <input type="number" class="form-control bg-light border-0" id="m-price" placeholder="مثال: 10">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small fw-bold">الفئة</label>
                                <select class="form-select bg-light border-0" id="m-type">
                                    <option value="food">مواد غذائية</option>
                                    <option value="energy">طاقة ووقود</option>
                                    <option value="medical">صحة وأدوية</option>
                                    <option value="services">خدمات</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">حالة التوفر</label>
                            <select class="form-select bg-light border-0" id="m-status">
                                <option value="available">متوفر بكثرة</option>
                                <option value="scarce">شحيح / قليل</option>
                                <option value="out">غير متوفر</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">المكان / الملاحظات</label>
                            <input type="text" class="form-control bg-light border-0" id="m-location" required placeholder="مثال: سوق النصيرات - بسطة أبو محمد">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill py-2">نشر التحديث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection