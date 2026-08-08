<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة الأيتام - منصة كنف</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
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
                    @include('orphans-list', ['data' => $data])
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
                        <li><a href="{{ route('knaf') }}" class="text-white text-decoration-none">الصفحة الرئيسية</a>
                        </li>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1️⃣ إمساك العناصر من الـ DOM بالاستعانة بالـ ID الموجود بالواجهة
            const searchInput = document.getElementById('search-input');
            const filterCountry = document.getElementById('filter-country');
            const filterGender = document.getElementById('filter-gender');
            const resetBtn = document.getElementById('reset-filters');
            const gridContainer = document.getElementById('orphans-list-grid');
            const emptyState = document.getElementById('orphans-empty-state');

            let debounceTimer; // متغيّر لحفظ الوقت عند الكتابة لتخفيف الطلبات (Debounce)

            // 2️⃣ دالة إرسال طلب الـ Ajax وجلب البيانات من السيرفر
            function fetchFilteredOrphans() {
                // خفض الشفافية لإعطاء انطباع للمستخدم بأن البيانات جارٍ تحميلها
                gridContainer.style.opacity = '0.4';

                // تجميع معايير البحث المكتوبة والمحددة في عناصر الـ Input
                const params = new URLSearchParams({
                    search: searchInput.value.trim(),
                    country: filterCountry.value,
                    gender: filterGender.value
                });

                // إرسال طلب fetch إلى الـ Route
                fetch(`{{ route('orphans') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest' // هذا الهيدر يتيح للارافيل معرفة أن الطلب نوعه Ajax عبر $request->ajax()
                        }
                    })
                    .then(response => response
                .text()) // تحويل النتيجة المرتجعة لنص HTML (الذي يمثله كود ملف الـ partial)
                    .then(html => {
                        // استبدال كروت الأيتام الحالية بالـ HTML الجديد القادم من لارافيل
                        gridContainer.innerHTML = html;
                        gridContainer.style.opacity = '1'; // إعادة الشفافية لوضعها الطبيعي

                        // إذا كان الـ HTML العائد فارغاً (لا توجد أيتام) نُظهر مربع "لم نجد نتائج"
                        if (html.trim() === '') {
                            emptyState.classList.remove('d-none');
                        } else {
                            emptyState.classList.add('d-none');
                        }
                    })
                    .catch(error => {
                        console.error('حدث خطأ أثناء جلب البيانات:', error);
                        gridContainer.style.opacity = '1';
                    });
            }

            // 3️⃣ ربط الأحداث (Event Listeners)

            // أ) عند الكتابة في مربع البحث باسم اليتيم (مع تأخير 300ms كي لا يرسل طلب مع كل حرف مباشرة)
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchFilteredOrphans, 300);
            });

            // ب) عند تغيير دولة الموطن من الـ Select Box
            filterCountry.addEventListener('change', fetchFilteredOrphans);

            // ج) عند تغيير جنس اليتيم من الـ Select Box
            filterGender.addEventListener('change', fetchFilteredOrphans);

            // د) زر "إعادة ضبط" لتصفير كافة الخانات
            resetBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterCountry.value = 'all';
                filterGender.value = 'all';
                fetchFilteredOrphans(); // جلب كافة الأيتام من جديد
            });
        });
    </script>
</body>

</html>
