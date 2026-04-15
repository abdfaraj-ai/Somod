// State
let selectedEmergencyType = null;
let locationCoords = null;
let isBreathing = false;

// Mock Data
let marketItems = [
    { id: 1, name: 'كيس طحين (25 كجم)', price: 120, location: 'النصيرات - السوق الجديد', status: 'available', time: 'منذ 10 د', type: 'food', trend: 'down' },
    { id: 2, name: 'تعبئة غاز (12 كجم)', price: 65, location: 'دير البلح - محطة السلام', status: 'scarce', time: 'منذ ساعة', type: 'energy', trend: 'up' },
    { id: 3, name: 'أرز مصري (1 كجم)', price: 8, location: 'رفح - السوق المركزي', status: 'available', time: 'منذ ساعتين', type: 'food', trend: 'stable' },
    { id: 4, name: 'شحن جوال كامل', price: 2, location: 'مستشفى شهداء الأقصى', status: 'available', time: 'منذ 3 ساعات', type: 'services', trend: 'stable' },
    { id: 5, name: 'حليب أطفال (رقم 1)', price: 45, location: 'صيدلية النور - الزوايدة', status: 'scarce', time: 'منذ 5 ساعات', type: 'medical', trend: 'up' },
    { id: 6, name: 'خيمة إيواء (4 أفراد)', price: 1200, location: 'المواصي - نقطة توزيع', status: 'out', time: 'أمس', type: 'services', trend: 'up' },
];

let servicesData = [
    { id: 1, name: "مستشفى شهداء الأقصى", type: "medical", status: "open", distance: "2 كم", location: "دير البلح", notes: "يعمل للطوارئ فقط" },
    { id: 2, name: "مركز إيواء مدرسة أ", type: "shelter", status: "crowded", distance: "0.5 كم", location: "النصيرات", notes: "ممتلئ، يقبل حالات خاصة" },
    { id: 3, name: "بئر مياه البلدية", type: "water", status: "open", distance: "1.2 كم", location: "الزوايدة", notes: "توزيع مياه حلوة من 8-12 ص" },
    { id: 4, name: "نقطة شحن القوة", type: "net", status: "open", distance: "0.3 كم", location: "شارع البحر", notes: "شحن + نت مجاني" },
    { id: 5, name: "مستشفى العودة", type: "medical", status: "closed", distance: "5 كم", location: "النصيرات", notes: "خارج الخدمة مؤقتاً" },
    { id: 6, name: "نقطة إسعاف الهلال", type: "medical", status: "open", distance: "3 كم", location: "خانيونس", notes: "متاح 24 ساعة" }
];

// Init
document.addEventListener('DOMContentLoaded', () => {
    renderMap();
    renderMarketItems('all');
    renderServices('all');
});

// Navigation Function
// function switchView(viewName) {
//     // Hide all views
//     document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
//     // Show target view
//     const target = document.getElementById('view-' + viewName);
//     if (target) target.classList.add('active');

//     // Update Navbar Active State
//     document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active', 'text-success'));
//     const navLink = document.getElementById('nav-' + viewName);
//     if (navLink) navLink.classList.add('active', 'text-success');

//     // Scroll to top
//     window.scrollTo(0, 0);

//     // Close mobile menu if open
//     const navbarCollapse = document.getElementById('navbarNav');
//     if (navbarCollapse.classList.contains('show')) {
//         new bootstrap.Collapse(navbarCollapse).hide();
//     }
// }

// Authentication Logic
function handleLogin(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> جاري الدخول...';

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;

        // Simulate successful login
        const navBtn = document.getElementById('nav-login-btn');
        navBtn.innerHTML = '<i class="bi bi-person-circle"></i> حسابي';
        navBtn.onclick = function () { alert('أهلاً بك! هذه لوحة المستخدم (محاكاة).'); };
        navBtn.classList.replace('btn-outline-light', 'btn-light');
        navBtn.classList.add('text-success', 'fw-bold');

        switchView('home');
        alert('تم تسجيل الدخول بنجاح!');
    }, 1500);
}

function handleSignup(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> جاري التسجيل...';

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        switchView('login');
        alert('تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.');
    }, 1500);
}

// SOS Logic: Get Location
function getLocation() {
    const btn = document.getElementById('btn-location');
    const txt = document.getElementById('location-text');
    const iconBg = document.getElementById('location-icon-bg');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                locationCoords = position.coords;
                btn.style.display = 'none'; // Hide button on success
                txt.textContent = `تم التحديد: ${locationCoords.latitude.toFixed(4)}, ${locationCoords.longitude.toFixed(4)}`;
                txt.classList.add('text-success', 'fw-bold');
                iconBg.classList.remove('bg-white', 'text-danger');
                iconBg.classList.add('bg-success', 'text-white');
            },
            (error) => {
                console.error(error);
                btn.disabled = false;
                btn.textContent = 'تحديد الموقع';
                alert('تعذر تحديد الموقع. يرجى التأكد من تفعيل خدمة الموقع في جهازك.');
            }
        );
    } else {
        btn.disabled = false;
        alert('المتصفح لا يدعم تحديد الموقع.');
    }
}

// SOS Logic: Select Emergency Type
function selectType(btn, type) {
    document.querySelectorAll('.emergency-option').forEach(el => el.classList.remove('active', 'text-white', 'bg-danger', 'bg-warning', 'bg-dark', 'bg-info', 'text-dark'));

    selectedEmergencyType = type;
    btn.classList.add('active');

    // Add contextual background
    if (btn.classList.contains('btn-outline-danger')) btn.classList.add('bg-danger', 'text-white');
    if (btn.classList.contains('btn-outline-warning')) btn.classList.add('bg-warning', 'text-dark');
    if (btn.classList.contains('btn-outline-dark')) btn.classList.add('bg-dark', 'text-white');
    if (btn.classList.contains('btn-outline-info')) btn.classList.add('bg-info', 'text-white');
}

// SOS Logic: Send
function sendSOS() {
    if (!locationCoords && !confirm("لم يتم تحديد موقعك. هل تريد الإرسال بدون موقع دقيق؟")) return;
    if (!selectedEmergencyType) {
        alert("الرجاء اختيار نوع الحالة الطارئة.");
        return;
    }

    const btn = document.getElementById('btn-send-sos');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-grow spinner-grow-sm me-2" role="status" aria-hidden="true"></span> جاري الإرسال...';

    // Simulate API call
    setTimeout(() => {
        document.getElementById('sos-form-container').classList.add('d-none');
        document.getElementById('sos-success').classList.remove('d-none');
        btn.disabled = false;
        btn.innerHTML = originalText;
        window.scrollTo(0, 0);
    }, 1500);
}

// SOS Logic: Reset
function resetSOS() {
    selectedEmergencyType = null;
    // Reset UI Types
    document.querySelectorAll('.emergency-option').forEach(el => {
        el.classList.remove('active', 'text-white', 'bg-danger', 'bg-warning', 'bg-dark', 'bg-info', 'text-dark');
    });

    document.getElementById('sos-success').classList.add('d-none');
    document.getElementById('sos-form-container').classList.remove('d-none');
}

// --- Evacuation Map Logic ---
function renderMap() {
    const gridContainer = document.getElementById('map-grid');
    gridContainer.innerHTML = '';
    const startBlock = 2300;
    const totalBlocks = 80;

    for (let i = 0; i < totalBlocks; i++) {
        const blockNum = startBlock + i;
        let statusClass = 'block-safe'; // default
        let statusText = 'safe';
        const rand = Math.random();
        if (rand < 0.1) { statusClass = 'block-danger'; statusText = 'danger'; }
        else if (rand < 0.25) { statusClass = 'block-warning'; statusText = 'warning'; }

        const el = document.createElement('div');
        el.className = `map-block ${statusClass}`;
        el.textContent = blockNum;
        el.onclick = () => showBlockInfo(blockNum, statusText);
        gridContainer.appendChild(el);
    }
}

function showBlockInfo(blockNum, status) {
    const res = document.getElementById('block-status-result');
    res.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-warning');
    let msg = '';
    if (status === 'safe') {
        res.classList.add('alert-success');
        msg = `<div class="d-flex align-items-center"><i class="bi bi-check-circle-fill fs-4 me-2"></i><div><strong>بلوك ${blockNum} آمن</strong><br><small>لا توجد أوامر إخلاء.</small></div></div>`;
    } else if (status === 'danger') {
        res.classList.add('alert-danger');
        msg = `<div class="d-flex align-items-center"><i class="bi bi-exclamation-octagon-fill fs-4 me-2"></i><div><strong>بلوك ${blockNum} خطر!</strong><br><small>أمر إخلاء فوري.</small></div></div>`;
    } else {
        res.classList.add('alert-warning');
        msg = `<div class="d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i><div><strong>بلوك ${blockNum} حذر</strong><br><small>نشاط عسكري قريب.</small></div></div>`;
    }
    res.innerHTML = msg;
    document.getElementById('block-input').value = blockNum;
}

function checkBlock() {
    const val = parseInt(document.getElementById('block-input').value);
    if (!val) return;
    const lastDigit = val % 10;
    let status = 'safe';
    if ([1, 6].includes(lastDigit)) status = 'danger';
    else if ([3, 8].includes(lastDigit)) status = 'warning';
    showBlockInfo(val, status);
}



// --- Services Logic ---
function renderServices(filter, btn) {
    const container = document.getElementById('services-list');
    container.innerHTML = '';

    if (btn) {
        document.querySelectorAll('.service-filter').forEach(el => { el.classList.remove('btn-dark', 'active'); el.classList.add('btn-outline-secondary'); });
        btn.classList.remove('btn-outline-secondary'); btn.classList.add('btn-dark', 'active');
    }

    const filtered = filter === 'all' ? servicesData : servicesData.filter(item => item.type === filter);

    filtered.forEach(item => {
        let icon = 'bi-geo-alt';
        let color = 'primary';
        if (item.type === 'medical') { icon = 'bi-hospital'; color = 'danger'; }
        if (item.type === 'shelter') { icon = 'bi-house-heart'; color = 'dark'; }
        if (item.type === 'water') { icon = 'bi-droplet'; color = 'info'; }
        if (item.type === 'net') { icon = 'bi-wifi'; color = 'warning'; }

        let statusBadge = '';
        if (item.status === 'open') statusBadge = '<span class="badge bg-success rounded-pill">مفتوح</span>';
        else if (item.status === 'crowded') statusBadge = '<span class="badge bg-warning text-dark rounded-pill">مزدحم</span>';
        else statusBadge = '<span class="badge bg-secondary rounded-pill">مغلق</span>';

        const cardHtml = `
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box bg-${color} bg-opacity-10 text-${color} flex-shrink-0" style="margin-bottom:0">
                            <i class="bi ${icon} fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold mb-0">${item.name}</h6>
                                ${statusBadge}
                            </div>
                            <div class="small text-muted mb-1"><i class="bi bi-geo-alt me-1"></i>${item.location} (${item.distance})</div>
                            <div class="small text-muted opacity-75">${item.notes}</div>
                        </div>
                        <a href="#" class="btn btn-light rounded-circle text-primary"><i class="bi bi-arrow-left"></i></a>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', cardHtml);
    });
}

function filterServices(type, btn) {
    renderServices(type, btn);
}

// --- Support Logic ---
function toggleBreathing() {
    const circle = document.getElementById('breathing-circle');
    const txt = document.getElementById('breath-text');
    const btn = document.getElementById('btn-breath');

    if (isBreathing) {
        circle.classList.remove('breathing-active');
        txt.textContent = 'استعد';
        btn.textContent = 'بدء التمرين';
        btn.classList.replace('btn-primary', 'btn-outline-primary');
        isBreathing = false;
    } else {
        circle.classList.add('breathing-active');
        txt.textContent = 'شهيق... زفير';
        btn.textContent = 'إيقاف';
        btn.classList.replace('btn-outline-primary', 'btn-primary');
        isBreathing = true;
    }
}

function submitSupportRequest(e) {
    e.preventDefault();
    const btn = e.target.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.textContent = 'جاري الإرسال...';
    setTimeout(() => {
        alert('تم استلام طلبك بسرية تامة. سيتم التواصل معك قريباً.');
        e.target.reset();
        btn.disabled = false;
        btn.textContent = 'إرسال الطلب';
    }, 1500);
}

const servicesData2 = [
    {
        id: 1,
        name: "مستشفى الشفاء الميداني",
        category: "medical",
        location: "غزة - الرمال",
        status: "نشط",
        desc: "تقديم خدمات الطوارئ والجراحة العامة على مدار الساعة.",
        details: "المستشفى مجهز بـ 50 سرير، قسم استقبال، وغرفة عمليات صغرى. يرجى التوجه للحالات الطارئة فقط.",
        icon: "bi-hospital",
        color: "bg-danger-subtle text-danger"
    },
    {
        id: 2,
        name: "مدرسة الفاخورة للإيواء",
        category: "shelter",
        location: "شمال غزة - جباليا",
        status: "مزدحم",
        desc: "مركز نزوح تابع للأونروا يوفر خدمات الإقامة الأساسية.",
        details: "المركز يضم حالياً 3000 نازح. يتم توزيع وجبات الطعام يومياً الساعة 2 ظهراً.",
        icon: "bi-house-heart",
        color: "bg-primary-subtle text-primary"
    },
    {
        id: 3,
        name: "خيمة التعليم التفاعلية",
        category: "edu",
        location: "دير البلح - المخيم",
        status: "نشط",
        desc: "مبادرة تعليمية لتعويض الفاقد الدراسي للأطفال.",
        details: "نقدم دروساً في اللغة العربية والرياضيات للأطفال من سن 6-12 سنة. الدوام من 8 صباحاً حتى 12 ظهراً.",
        icon: "bi-book",
        color: "bg-warning-subtle text-warning"
    },
    {
        id: 4,
        name: "مؤسسة انقاذ المستقبل الشبابي",
        category: "org",
        location: "غزة - مفترق اللبابيدي",
        status: "نشط",
        desc: "توزيع طرود غذائية ومساعدات نقدية للعائلات المتضررة.",
        details: "المؤسسة تعمل على تسجيل العائلات الجديدة للحصول على حصص تموينية شهرية. يرجى إحضار الهوية الشخصية.",
        icon: "bi-people",
        color: "bg-info-subtle text-info"
    },
    {
        id: 5,
        name: "نقطة تزويد مياه (بئر الصلاح)",
        category: "water",
        location: "رفح - تل السلطان",
        status: "نشط",
        desc: "توفير مياه صالحة للشرب مجاناً للمواطنين.",
        details: "تعمل النقطة بالطاقة الشمسية من الساعة 8 صباحاً حتى غياب الشمس. يرجى إحضار أوعية نظيفة.",
        icon: "bi-droplet",
        color: "bg-info-subtle text-primary"
    },
    {
        id: 6,
        name: "مركز التدريب المهني",
        category: "edu",
        location: "النصيرات - شارع البحر",
        status: "نشط",
        desc: "دورات قصيرة في صيانة الهواتف والطاقة الشمسية.",
        details: "برنامج تدريبي مكثف للشباب لتمكينهم من صيانة الأدوات الضرورية في وقت الأزمات.",
        icon: "bi-tools",
        color: "bg-success-subtle text-success"
    }
];

function renderServices(filter = 'all') {
    const grid = document.getElementById('services-grid');
    grid.innerHTML = '';

    const filtered = filter === 'all' ? servicesData2 : servicesData2.filter(s => s.category === filter);

    filtered.forEach(service => {
        grid.innerHTML += `
                    <div class="col-md-6">
                        <div class="card card-service h-100 p-3 shadow-sm border-0" onclick="showDetails(${service.id}, this)">
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon ${service.color} me-3">
                                    <i class="bi ${service.icon}"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">${service.name}</h5>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>${service.location}</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">${service.desc}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge ${service.status === 'نشط' ? 'bg-success' : 'bg-warning'} rounded-pill">${service.status}</span>
                                <span class="text-primary fw-bold small">التفاصيل <i class="bi bi-arrow-left"></i></span>
                            </div>
                        </div>
                    </div>
                `;
    });
}

function showDetails(id, element) {
    // Remove active class from all cards
    document.querySelectorAll('.card-service').forEach(c => c.classList.remove('active'));
    // Add active class to selected card
    element.classList.add('active');

    const service = servicesData2.find(s => s.id === id);
    const detailPanel = document.getElementById('detail-card');

    detailPanel.innerHTML = `
                <div class="animate__animated animate__fadeIn">
                    <div class="map-placeholder mb-4 shadow-sm">
                        <div class="map-overlay">
                            <i class="bi bi-geo-fill text-danger display-4 animate-bounce"></i>
                        </div>
                        <img src="https://picsum.photos/seed/${service.id}/400/200" class="w-100 h-100 object-fit-cover" style="opacity:0.4">
                    </div>
                    <div class="text-start">
                        <h3 class="fw-bold text-success mb-2">${service.name}</h3>
                        <p class="text-muted mb-4"><i class="bi bi-geo-alt-fill text-danger me-1"></i>${service.location}</p>
                        
                        <div class="bg-light p-3 rounded-4 mb-4 border-start border-4 border-success">
                            <h6 class="fw-bold mb-2">نبذة تعريفية</h6>
                            <p class="text-secondary small mb-0">${service.details}</p>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-success py-3 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-telephone-fill me-2"></i> تواصل الآن
                            </button>
                            <button class="btn btn-outline-secondary py-3 rounded-3 fw-bold">
                                <i class="bi bi-map-fill me-2"></i> عرض في خرائط جوجل
                            </button>
                        </div>
                    </div>
                </div>
            `;
}

function filterServices(category, btn) {
    // Update UI buttons
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'btn-dark'));
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.add('btn-outline-success'));
    btn.classList.add('active', 'btn-dark');
    btn.classList.remove('btn-outline-success');

    renderServices(category);
}

// Initial Render
renderServices();