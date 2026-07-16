<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطوات الكفالة - الخطوة الأولى</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-warm">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark kanaf-navbar py-3 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4" href="index.html">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="شعار كنف" height="50" width="110"
                        id="nav-brand-logo" style="object-fit:contain;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                    aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1" id="nav-menu-list">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html" id="nav-link-home">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orphans.html" id="nav-link-orphans">قائمة الأيتام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sponsorship/step1.html" id="nav-link-steps">خطوات الكفالة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html" id="nav-link-contact">اتصل بنا</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2 align-items-center flex-wrap" id="nav-auth-buttons">
                        <a href="auth/login.html" class="btn btn-outline-light px-4 rounded-pill"
                            id="nav-btn-login">تسجيل
                            الدخول</a>
                        <a href="auth/register.html" class="btn btn-secondary px-4 rounded-pill fw-bold"
                            id="nav-btn-register">ابدأ
                            الكفالة الآن</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Steps Indicator Progress bar -->
        <section class="py-4 bg-white border-bottom shadow-xs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center max-w-xl mx-auto">
                    <div class="step-item active">
                        <div class="step-indicator">1</div>
                        <span class="text-small fw-bold">اختيار اليتيم</span>
                    </div>
                    <div class="step-item">
                        <div class="step-indicator">2</div>
                        <span class="text-small text-muted">بيانات الكافل</span>
                    </div>
                    <div class="step-item">
                        <div class="step-indicator">3</div>
                        <span class="text-small text-muted">الدفع والتأكيد</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Step Contents -->
        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                            <h2 class="fw-bold text-primary-green mb-3 text-center">الخطوة الأولى: تأكيد معلومات الكفالة
                                واليتيم
                                Selected</h2>
                            <p class="text-muted text-center mb-5">مرحباً بك في أولى خطوات العطاء المبارك. يرجى مراجعة
                                تفاصيل الكفالة
                                المقررة للطفل المختار أدناه.</p>

                            <!-- Real Selected child Details -->
                            <div>

                                <div class="row align-items-center bg-light p-4 rounded-4 mb-4 g-4">
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('Uploads/orphans/' . $orphan->image) }}" alt="أحمد محمد"
                                            class="img-fluid rounded-circle shadow-xs"
                                            style="width:120px;height:120px;object-fit:cover;">
                                    </div>
                                    <div class="col-md-9 text-center text-md-right select-align">
                                        <span class="badge bg-primary-green mb-2">
                                            {{ $orphan->country }} - {{ $orphan->city }}
                                        </span>
                                        <h4 class="fw-bold text-dark mb-2">
                                            {{ $orphan->name }}
                                        </h4>
                                        <p class="text-muted text-small mb-0 mt-1">
                                            <i class="bi bi-book me-1 text-primary-green"></i>
                                            المستوى الدراسي : {{ $orphan->education_level }} |
                                            الحالة الصحية: {{ $orphan->health_status }}
                                        </p>
                                        <div class="d-flex flex-wrap gap-1 justify-content-center my-2">

                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">
                                                يتيم الأبوين
                                            </span>

                                            <span
                                                class="badge bg-info-subtle text-dark border border-info-subtle rounded-pill px-3 py-2">
                                                أشد حاجة
                                            </span>

                                        </div>
                                    </div>

                                    <div class="card border border-light shadow-xs rounded-3 p-4 mb-5">
                                        <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">ملخص خطة الكفالة</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted">نوع الكفالة</span>
                                            <strong class="text-dark">كفالة رعاية شاملة كنفية (دائمة)</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted">دورة الكفالة</span>
                                            <strong class="text-dark">كفالة شهرية دورية</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-dark fs-5">المبلغ المطلوب شهرياً</span>
                                            <span class="fs-4 fw-bold text-success">
                                                $50
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Navigation links -->
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('orphans') }}"
                                            class="btn btn-outline-secondary px-4 py-2"><i
                                                class="bi bi-arrow-right-short align-middle fs-5"></i> تصفح أيتام
                                            آخرين</a>
                                        <a id="btn-next-step"
                                            href="{{ route('create_step2') }}?orphan_id={{ $orphan->id }}"
                                            class="btn btn-primary px-5 py-2 fw-bold">الخطوة التالية
                                            (بيانات الكافل)
                                            <i class="bi bi-arrow-left-short align-middle fs-5"></i></a>
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
                        <li><a href="index.html" class="text-white text-decoration-none">الصفحة الرئيسية</a></li>
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
