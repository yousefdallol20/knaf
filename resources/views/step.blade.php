<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة كَنَفْ | لكفالة الأيتام</title>

    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        :root {
            --primary-green: #1b5e20;
            --primary-green-hover: #134217;
            --secondary-gold: #ffc107;
            --warm-bg: #fdfbf7;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #ffffff;
            color: #333333;
        }

        /* Custom Utility Classes */
        .bg-warm {
            background-color: var(--warm-bg) !important;
        }

        .text-primary-green {
            color: var(--primary-green) !important;
        }

        .bg-primary-green {
            background-color: var(--primary-green) !important;
        }

        .bg-secondary-gold {
            background-color: var(--secondary-gold) !important;
        }

        .btn-primary-green {
            background-color: var(--primary-green);
            color: #fff;
            border: none;
        }

        .btn-primary-green:hover {
            background-color: var(--primary-green-hover);
            color: #fff;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.8rem;
            color: var(--primary-green);
        }

        .hero-section {
            padding: 100px 0 80px;
            background: linear-gradient(135deg, var(--warm-bg) 0%, #ffffff 100%);
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark kanaf-navbar py-3 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4" href="{{ route('knaf') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="شعار كنف" height="50" width="110"
                        id="nav-brand-logo" style="object-fit:contain;">
                    <!-- <span id="nav-brand-text">منصة كَنَفْ</span> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                    aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1" id="nav-menu-list">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('knaf') }}" id="nav-link-home">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orphans') }}" id="nav-link-orphans">قائمة الأيتام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('step') }}" id="nav-link-steps">خطوات الكفالة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}" id="nav-link-contact">اتصل بنا</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2 align-items-center flex-wrap" id="nav-auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline-light px-4 rounded-pill"
                            id="nav-btn-login">تسجيل
                            الدخول</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary px-4 rounded-pill fw-bold"
                            id="nav-btn-register">ابدأ
                            الكفالة الآن</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- 2. قسم الهيرو (Hero Section) -->
    <section class="hero-section border-bottom">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="bi bi-star-fill me-1"></i> منصة موثوقة لكفالة الأيتام
                    </span>
                    <h1 class="display-4 fw-bold text-primary-green mb-4 lh-base">
                        كن كافلاً... وكن معي في الجنة
                    </h1>
                    <p class="lead text-muted mb-4 lh-lg">
                        تتيح لك منصة **كَنَفْ** كفالة الأيتام بطريقة رسمية ومباشرة، مع توفير تقارير دورية تضمن لك متابعة
                        كافة احتياجاتهم التعليمية والصحية والرعاية الكاملة.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="#orphans-section"
                            class="btn btn-primary-green btn-lg px-4 py-3 rounded-pill fw-bold shadow-sm">
                            اختر يتيماً لكفالته <i class="bi bi-arrow-left ms-2"></i>
                        </a>
                        <a href="#sponsorship-steps-section"
                            class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-pill fw-bold">
                            كيف تعمل المنصة؟
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative d-inline-block">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800&auto=format&fit=crop"
                            class="img-fluid rounded-4 shadow-lg" alt="رعاية الأيتام">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. قسم خطوات الكفالة -->
    <section class="py-5 bg-warm border-bottom" id="sponsorship-steps-section">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-secondary-gold text-dark mb-2 px-3 py-2 fw-bold rounded-pill">
                    <i class="bi bi-diagram-3-fill me-1"></i> دليل الكفالة الميسر
                </span>
                <h2 class="fw-bold text-primary-green display-6 mb-3">كيف تكفل يتيماً في 3 خطوات؟</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    رحلة عطاء سلسة وموثقة تبدأ باختيار الطفل وتنتهي بتوثيق الكفالة وتلقي التقارير الدورية.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- خطوة 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-primary-green rounded-circle p-3 mb-3 mx-auto"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-person-check-fill fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">1. اختيار اليتيم</h5>
                        <p class="text-muted small lh-lg mb-0">
                            تصفح قائمة الأيتام واستعرض حالاتهم الصحية والدراسية ومدى الاحتياج، ثم حدد الطفل المختار.
                        </p>
                    </div>
                </div>

                <!-- خطوة 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-dark rounded-circle p-3 mb-3 mx-auto"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-card-heading fs-2 text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-3">2. إدخال بيانات الكافل</h5>
                        <p class="text-muted small lh-lg mb-0">
                            سجل بيانات التواصل الأساسية لتمكيننا من توثيق عقد الكفالة ومراسلتك بالتقارير الدورية.
                        </p>
                    </div>
                </div>

                <!-- خطوة 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                        <div class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info-emphasis rounded-circle p-3 mb-3 mx-auto"
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-credit-card-2-front-fill fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">3. الدفع وتأكيد الكفالة</h5>
                        <p class="text-muted small lh-lg mb-0">
                            اختر طريقة الدفع المناسبة لتقديم الدفعة الأولى لتتم عملية الاعتماد وتنشيط الكفالة فوراً.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. قسم الأيتام المتاحين للكفالة -->
    <section class="py-5" id="orphans-section">
        <div class="container py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5">
                <div>
                    <h2 class="fw-bold text-primary-green display-6 mb-2">أيتام بانتظار كفالتك</h2>
                    <p class="text-muted mb-0">ساهم في تغيير حياة طفل ووفر له العيش الكريم</p>
                </div>
                <a href="#" class="btn btn-outline-success rounded-pill fw-bold mt-3 mt-md-0">عرض جميع
                    الحالات</a>
            </div>

            <div class="row g-4">
                <!-- كرت يتيم 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=500&auto=format&fit=crop"
                            class="card-img-top" alt="طفل" style="height: 220px; object-fit: cover;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark border">عمر: 8 سنوات</span>
                                <span class="badge bg-danger-subtle text-danger">شدد الاحتياج</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">أحمد محمد</h5>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt text-muted me-1"></i> غزة، فلسطين
                            </p>
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex justify-content-between text-small fw-bold mb-1">
                                    <span>مبلغ الكفالة الشهري:</span>
                                    <span class="text-primary-green">150 شيكل</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary-green w-100 rounded-pill fw-bold py-2">تكفل
                                الآن</a>
                        </div>
                    </div>
                </div>

                <!-- كرت يتيم 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?q=80&w=500&auto=format&fit=crop"
                            class="card-img-top" alt="طفلة" style="height: 220px; object-fit: cover;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark border">عمر: 6 سنوات</span>
                                <span class="badge bg-warning-subtle text-dark">يتيمة الأبوين</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">مريم خالد</h5>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt text-muted me-1"></i> غزة، فلسطين
                            </p>
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex justify-content-between text-small fw-bold mb-1">
                                    <span>مبلغ الكفالة الشهري:</span>
                                    <span class="text-primary-green">200 شيكل</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary-green w-100 rounded-pill fw-bold py-2">تكفل
                                الآن</a>
                        </div>
                    </div>
                </div>

                <!-- كرت يتيم 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=500&auto=format&fit=crop"
                            class="card-img-top" alt="طفل" style="height: 220px; object-fit: cover;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark border">عمر: 10 سنوات</span>
                                <span class="badge bg-success-subtle text-success">طالب علم</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">يوسف محمود</h5>
                            <p class="text-muted small mb-3"><i class="bi bi-geo-alt text-muted me-1"></i> غزة، فلسطين
                            </p>
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex justify-content-between text-small fw-bold mb-1">
                                    <span>مبلغ الكفالة الشهري:</span>
                                    <span class="text-primary-green">150 شيكل</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary-green w-100 rounded-pill fw-bold py-2">تكفل
                                الآن</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. قسم الأرقام والإحصائيات -->
    <section class="py-5 bg-primary-green text-white">
        <div class="container py-3">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-warning">+1,200</h2>
                    <p class="fs-5 mb-0">يتيم مكفول</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-warning">+850</h2>
                    <p class="fs-5 mb-0">كافل مسجل</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-5 fw-bold text-warning">100%</h2>
                    <p class="fs-5 mb-0">شفافية وتوثيق دوري</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. الفوتر (Footer) -->
    <footer class="kanaf-footer py-5 mt-5 pb-0">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="كنف" height="60" style="object-fit: cover;"> -->
                            <h5 class="text-white mb-0 fw-bold">منصة كَنَفْ لكفالة الأيتام</h5>
                        </div>
                        <p class="text-white text-small">منصة تفاعلية رقمية موثوقة وآمنة تهدف لربط الكافلين بالأيتام
                            الأكثر احتياجاً
                            لمتابعة حالتهم وتحقيق الكفالة الشاملة بكل شفافية وحب.</p>
                        <div class="d-flex gap-2 mt-4 text-white">
                            <a href="#" class="btn btn-sm btn-outline-secondary text-white"><i
                                    class="bi bi-twitter-x"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-secondary text-white"><i
                                    class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-secondary text-white"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="#" class="btn btn-sm btn-outline-secondary text-white"><i
                                    class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">روابط مساعدة</h6>
                    <ul class="list-unstyled text-small text-white d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('knaf') }}" class="text-white text-decoration-none">الصفحة الرئيسية</a>
                        </li>
                        <li><a href="{{ route('orphans') }}" class="text-white text-decoration-none">قائمة الأيتام
                                للبحث</a></li>
                        <li><a href=" {{ route('step') }}" class="text-white text-decoration-none">خطوات وبدء
                                الكفالة</a></li>
                        <li><a href=" {{ route('login') }}" class="text-white text-decoration-none">دخول
                                المستخدمين</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">اللوحات الخاصة</h6>
                    <ul class="list-unstyled text-small text-white d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('dashboard_sponsor') }}" class="text-white text-decoration-none">بوابة
                                الكافل
                                المشترك</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-white text-decoration-none">بوابة الأوصياء
                                والأمهات</a>
                        </li>
                        <li><a href="{{ route('dashboard_admin') }}" class="text-white text-decoration-none">لوحة
                                الإدارة
                                الشاملة</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white fw-bold mb-3">النشرة الإخبارية</h6>
                    <p class="text-white text-small mb-3">اشترك معنا ليصلك تحديثات وتقارير أثر الكفالات وأحدث الأيتام
                        المسجلين.
                    </p>
                    <div class="input-group">
                        <input type="email" class="form-control text-small" style="text-align: right;"
                            placeholder="بريدك الإلكتروني" aria-label="البريد">
                        <button class="btn btn-secondary text-small" type="button">اشترك</button>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center text-white text-small mb-0">
                <p class="mb-0">جميع الحقوق محفوظة © لمنصة كَنَفْ لكفالة الأيتام 2026. صناعة حب وشفافية وطمأنينة.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>


    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
