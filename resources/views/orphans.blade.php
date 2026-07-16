<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الأيتام - منصة كنف</title>
    <link rel="stylesheet" href="assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        .page-header-container {
            position: relative;
            background-color: #0e3521;
            padding: 80px 0;
            overflow: hidden;
        }

        .header-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 160, 23, 0.15) 0%, rgba(27, 107, 67, 0) 70%);
            pointer-events: none;
        }

        /* Modern filter bar in sticky setting */
        .sticky-filter-bar {
            top: 0;
            background: rgba(248, 246, 242, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(27, 107, 67, 0.06);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            z-index: 100;
            transition: var(--transition-smooth);
        }

        .form-control,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid rgba(27, 107, 67, 0.1) !important;
            border-radius: 14px !important;
            padding: 12px 18px !important;
            font-weight: 600;
            transition: var(--transition-smooth) !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 4px rgba(27, 107, 67, 0.08) !important;
            transform: translateY(-2px);
        }

        .input-group-text {
            border-radius: 14px 0 0 14px !important;
            border-color: rgba(27, 107, 67, 0.1) !important;
            background-color: #ffffff !important;
            padding-left: 18px !important;
        }

        .search-input-field {
            border-radius: 0 14px 14px 0 !important;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark kanaf-navbar py-3 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4" href="index.html">
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
        <!-- Page Header -->
        <div class="page-header-container text-white text-center">
            <div class="header-glow"></div>
            <div class="container py-3 position-relative" style="z-index: 5;">
                <span class="badge bg-secondary-gold text-dark mb-2 px-3 py-2 fw-extrabold text-uppercase rounded-pill"
                    data-aos="fade-down">قائمة الخير الرحبة</span>
                <h1 class="fw-black mb-3 text-white display-4" data-aos="fade-up" data-aos-delay="100">ابحث عن رفيق
                    الجنة</h1>
                <p class="lead text-white-50 mb-0 mx-auto fs-5" style="max-width: 700px;" data-aos="fade-up"
                    data-aos-delay="200">
                    تصفح حكايات الطهر والطفولة، واختر بقلبك طفلاً لتبدأ برعايته ودعمه صحياً ونفسياً وتوثيقاً بخطوات
                    سريعة.
                </p>
            </div>
        </div>

        <!-- Search & Filters Segment -->
        <section class="py-4">
            <div class="container">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <label class="form-label fw-extrabold text-dark small mb-2"><i
                                class="bi bi-search text-primary-green me-1"></i>
                            ابحث باسم اليتيم</label>
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control search-input-field"
                                placeholder="اكتب اسم اليتيم هنا...">
                            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
                        <label class="form-label fw-extrabold text-dark small mb-2"><i
                                class="bi bi-geo-alt-fill text-primary-green me-1"></i> الموطن والبلد</label>
                        <select id="filter-country" class="form-select">
                            <option value="all">جميع مناطق التغطية</option>
                            <option value="فلسطين">فلسطين (قطاع غزة)</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <label class="form-label fw-extrabold text-dark small mb-2"><i
                                class="bi bi-gender-ambiguous text-primary-green me-1"></i> جنس اليتيم</label>
                        <select id="filter-gender" class="form-select">
                            <option value="all">الكل (ذكور وإناث)</option>
                            <option value="ذكر">الأبناء الذكور</option>
                            <option value="أنثى">الفتيات الإناث</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12" data-aos="fade-up" data-aos-delay="250">
                        <button id="reset-filters" class="btn btn-outline-primary w-100 py-3 fw-bold rounded-pill"><i
                                class="bi bi-arrow-counterclockwise"></i> إعادة ضبط</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Orphans Grid Section -->
        <section class="py-5">
            <div class="container">

                <!-- Empty state container if no orphan matches filter -->
                <div id="orphans-empty-state" class="text-center py-5 d-none" data-aos="zoom-in">
                    <div class="bg-white rounded-5 p-5 shadow-sm border border-light mx-auto"
                        style="max-width: 500px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="لا يوجد نتائج"
                            class="img-fluid mb-4" style="max-height: 120px; opacity: 0.6;">
                        <h3 class="fw-black text-primary-green mb-3">لم نجد قلباً يطابق هذه الخيارات</h3>
                        <p class="text-muted mb-4 fs-6">جرب تعديل كلمات البحث أو تصفية الجنس والوطن لتجد اليتيم.
                        </p>
                    </div>
                </div>

                <!-- Real Orphans Grid with modern styling transition -->
                <div class="row g-4" id="orphans-list-grid"
                    style="transition: opacity 0.2s ease-in-out; opacity: 1;">
                    @foreach ($data as $info)
                        <div class="col-lg-4 col-md-6 list-orphan-element">
                            <div class="kanaf-card h-100 bg-white shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ asset('Uploads/orphans/' . $info->image) }}"
                                        alt="يوسف سليمان الكفارنة" class="card-img-top w-100"
                                        style="height: 250px; object-fit: cover;" referrerpolicy="no-referrer">
                                    <span
                                        class="badge position-absolute top-0 right-0 bg-primary-green px-3 py-2 fw-semibold rounded-3 text-white m-3"
                                        style="right: 14px; left: auto; z-index: 5;"> {{ $info->country ?? 'فلسطين' }}
                                        -
                                        {{ $info->city ?? 'غزة' }}</span>
                                    {{-- @if (($info->status ?? 'بانتظار الكفالة') == 'مكفول') --}}
                                    <span
                                        class="badge position-absolute top-0 left-0 px-3 py-2 fw-semibold rounded-3 text-white m-3 bg-primary-green"
                                        style="left: 14px; right: auto; z-index: 5;">
                                        {{ $info->status ?? 'بانتظار الكفالة' }} </span>
                                    {{-- @else
                                    <span
                                        class="badge position-absolute top-0 left-0 px-3 py-2 fw-semibold rounded-3 text-white m-3 bg-secondary-gold text-dark"
                                        style="left: 14px; right: auto; z-index: 5;">{{ $info->status }}</span>
                                @endif --}}
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-2 d-flex align-items-center gap-1">
                                        <i class="bi bi-star-fill text-secondary-gold"
                                            style="font-size: 0.85rem;"></i>
                                        <i class="bi bi-star-fill text-secondary-gold"
                                            style="font-size: 0.85rem;"></i>
                                        <i class="bi bi-star-fill text-secondary-gold"
                                            style="font-size: 0.85rem;"></i>
                                        <i class="bi bi-star-fill text-secondary-gold"
                                            style="font-size: 0.85rem;"></i>
                                        <i class="bi bi-star-fill text-secondary-gold"
                                            style="font-size: 0.85rem;"></i>
                                    </div>
                                    <h5 class="fw-black text-dark mb-2">{{ $info->name ?? 'يوسف سليمان الكفارنة' }}
                                    </h5>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill"
                                            style="font-size: 0.75rem; font-weight: 700;">{{ $info->orphan_type ?? 'يتيم الأبوين' }}</span>
                                        <span
                                            class="badge bg-info-subtle text-dark border border-info-subtle fs-7 px-2.5 py-1 rounded-pill"
                                            style="font-size: 0.75rem; font-weight: 700;">{{ $info->urgency_level ?? 'أشد حاجة' }}</span>
                                    </div>
                                    <div class="d-flex gap-3 text-muted text-small mb-3"
                                        style="font-size: 0.85rem; font-weight: 600;">
                                        <span><i class="bi bi-calendar3 text-primary-green me-1"></i>العمر
                                            :{{ $info->age ?? '7' }} سنوات</span>
                                        <span><i class="bi bi-shield-heart text-primary-green me-1"></i> الحالة:
                                            {{ $info->health_status ?? 'سليم' }}</span>
                                    </div>
                                    <div class="mb-3 text-muted text-small"
                                        style="font-size: 0.85rem; font-weight: 600;">
                                        <i class="bi bi-book text-primary-green me-1"></i> التعليم: <span
                                            class="fw-semibold text-dark">المرحلة
                                            {{ $info->education_level ?? 'الابتدائية - الصف الأول' }}</span>
                                    </div>
                                    <p class="text-muted text-small small lh-base mb-4"
                                        style="height: 72px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                        {{ $info->story ??
                                            ' ناجي وحيد من عائلته التي استشهدت في شمال غزة. يعيش الآن مع جده في مركز إيواء بدير
                                            البلح برعاية جيدة
                                            ولكنه يحتاج مستلزمات أساسية وطبابة مستمرة.' }}
                                    </p>

                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between text-small mb-1"
                                            style="font-size: 0.82rem; font-weight: 700;">
                                            <span class="text-muted">درجة اكتمال الكفالة</span>
                                            <span class="fw-semibold text-success">0%</span>
                                        </div>
                                        <div class="progress"
                                            style="height: 6px; background-color: var(--light-gray); border-radius: 999px; overflow: hidden;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: 0%; background-color: var(--secondary-gold);"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="border-top pt-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-muted d-block text-small mb-1"
                                                style="font-size: 0.75rem; font-weight: 700;">مبلغ
                                                الكفالة</span>
                                            <span class="fs-4 fw-black text-primary-green">$ 80</span> <span
                                                class="text-muted text-small"
                                                style="font-size: 0.8rem;">/شهرياً</span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('orphans_details', $info->id) }}" class="btn btn-primary">التفاصيل</a>
                                            <a href="{{ route('step1', $info->id) }}"
                                                class="btn btn-secondary btn-sm px-3 fw-bold rounded-pill">
                                                اكفل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
