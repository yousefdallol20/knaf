<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملف اليتيم التفصيلي - منصة كنف</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark kanaf-navbar py-3 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4" href="{{ route('knaf') }}">
                    <img src="assets/images/logo.png" alt="شعار كنف" height="50" width="110" id="nav-brand-logo"
                        style="object-fit:contain;">
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
                            <a class="nav-link" href="sponsorship/step1.html" id="nav-link-steps">خطوات الكفالة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html" id="nav-link-contact">اتصل بنا</a>
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

    <main>
        <section class="py-5" id="main-profile-container">
            <div class="container py-3">

                    <!-- Real Profile Card Content (Hidden initially until JS loads) -->
                    <div id="profile-content">

                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('knaf') }}"
                                        class="text-primary-green text-decoration-none">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('orphans') }}"
                                        class="text-primary-green text-decoration-none">قائمة
                                        الأيتام</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $orphan->name }}
                                </li>
                            </ol>
                        </nav>

                        <div class="row g-4">
                            <!-- Profile image and core call to action -->
                            <div class="col-lg-5">
                                <div class="bg-white p-4 rounded-4 shadow-sm border text-center">
                                    <div class="position-relative mb-4">
                                        <img src="{{ asset('Uploads/orphans/' . $orphan->personal_photo_path) }}" alt=" "
                                            class="img-fluid rounded-4 shadow-xs"
                                            style="max-height:380px;object-fit:cover;width:100%;">
                                        <span
                                            class="badge bg-primary-green position-absolute top-0 end-0 m-3 px-3 py-2">
                                            {{ $orphan->country }} - {{ $orphan->city }}
                                        </span>
                                    </div>

                                    <div class="bg-light-gray-subtle p-3 rounded-3 mb-4 text-center">
                                        <p class="text-muted text-small mb-1">المبلغ المطلوب للكفالة الشهرية الشاملة</p>
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <h3 class="fw-bold text-primary-green mb-0">
                                                {{ $orphan->required_amount }}
                                            </h3>
                                            <span class="fs-5 text-muted">$ / شهرياً</span>
                                        </div>
                                    </div>

                                    <!-- Action buttons -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('step1', $orphan->id) }}" class="btn btn-secondary btn-lg py-3 fw-bold">
                                            ابدأ كفالة الطفل الآن
                                        </a>
                                        <button class="btn btn-outline-primary btn-lg py-2"><i
                                                class="bi bi-share me-2"></i> مشاركة الملف
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Description and history -->
                            <div class="col-lg-7">
                                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border h-100">
                                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-semibold"
                                        id="child-status-badge">{{ $orphan->status }}</span>
                                    <h1 class="fw-bold text-primary-green mb-3">
                                        {{ $orphan->name }}
                                    </h1>
                                    <!-- Smart Humanitarian Classification Badges -->
                                    <div class="d-flex flex-wrap gap-1 mb-3">

                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                            يتيم الأبوين
                                        </span>

                                        <span
                                            class="badge bg-info-subtle text-dark border border-info-subtle px-3 py-2 rounded-pill">
                                            أشد حاجة
                                        </span>

                                    </div>
                                    <p class="text-muted mb-4">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        {{ $orphan->country }} - {{ $orphan->city }}
                                    </p>

                                    <hr class="my-4">

                                    <h4 class="fw-bold mb-3 text-dark"><i
                                            class="bi bi-person-badge-fill me-2 text-primary-green"></i>
                                        البيانات الشخصية</h4>
                                    <div class="row g-3 mb-4">
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3">
                                                <span class="text-caption d-block">العمر الحالي</span>
                                                <strong class="text-dark fs-5">
                                                    {{ $orphan->age }} سنوات
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3">
                                                <span class="text-caption d-block">الجنس</span>
                                                <strong class="text-dark fs-5">
                                                    {{ $orphan->gender }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3">
                                                <span class="text-caption d-block">المرحلة والمستوى التعليمي</span>
                                                <strong class="text-dark fs-5">
                                                    {{ $orphan->education_level }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="p-3 bg-light rounded-3">
                                                <span class="text-caption d-block">الحالة الصحية العامة</span>
                                                <strong class="text-dark fs-5">
                                                    {{ $orphan->health_status }}
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="fw-bold mb-3 text-dark"><i
                                            class="bi bi-chat-quote-fill me-2 text-primary-green"></i> قصة
                                        وحكاية اليتيم</h4>
                                    <div
                                        class="p-4 bg-light rounded-4 border-start border-4 border-primary-green mb-0">
                                        <p class="mb-0 text-muted lh-lg" style="text-align:justify;">
                                            {{ $orphan->story }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>

    <footer class="kanaf-footer py-5 mt-5 pb-0">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <!-- <img src="assets/images/logo.png" alt="كنف" height="60" style="object-fit: cover;"> -->
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
                        <li><a href="{{ route('knaf') }}" class="text-white text-decoration-none">الصفحة الرئيسية</a></li>
                        <li><a href="orphans.html" class="text-white text-decoration-none">قائمة الأيتام للبحث</a>
                        </li>
                        <li><a href="sponsorship/step1.html" class="text-white text-decoration-none">خطوات وبدء
                                الكفالة</a></li>
                        <li><a href="auth/login.html" class="text-white text-decoration-none">دخول المستخدمين</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white fw-bold mb-3">اللوحات الخاصة</h6>
                    <ul class="list-unstyled text-small text-white d-flex flex-column gap-2 mb-0">
                        <li><a href="sponsor/dashboard.html" class="text-white text-decoration-none">بوابة الكافل
                                المشترك</a></li>
                        <li><a href="guardian/dashboard.html" class="text-white text-decoration-none">بوابة الأوصياء
                                والأمهات</a>
                        </li>
                        <li><a href="admin/dashboard.html" class="text-white text-decoration-none">لوحة الإدارة
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
</body>

</html>
