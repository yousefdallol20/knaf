<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة كنف لكفالة الأيتام - الصفحة الرئيسية</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .hero-container {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background-color: #0e3521;
        }

        .hero-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.35;
            z-index: 1;
            transform: scale(1.05);
        }

        .hero-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(14, 53, 33, 0.95) 0%, rgba(27, 107, 67, 0.75) 50%, rgba(248, 246, 242, 0.1) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
        }

        /* Floating Stats cards inside Hero */
        .hero-floating-stat {
            position: absolute;
            z-index: 4;
            border-radius: var(--border-radius-stat);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 16px 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition-smooth);
        }

        .hero-floating-stat:hover {
            transform: scale(1.05) translateY(-5px);
            background: rgba(255, 255, 255, 0.95);
        }

        /* Interactive Orphans grid filters */
        .filter-wrapper {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 100px;
            padding: 6px;
            border: 1px solid rgba(27, 107, 67, 0.05);
            display: inline-flex;
        }

        /* Organic backgrounds blobs in CTA Section */
        .cta-container {
            position: relative;
            background: linear-gradient(135deg, #0d2a1b 0%, #154e31 100%);
            overflow: hidden;
            border-radius: 36px;
            box-shadow: 0 30px 60px rgba(13, 42, 27, 0.3);
            padding: 80px 40px;
        }

        .cta-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 1;
            opacity: 0.35;
            pointer-events: none;
        }

        .cta-blob-1 {
            width: 300px;
            height: 300px;
            background: var(--secondary-gold);
            top: -10%;
            right: -10%;
            animation: float-blob-1 10s infinite ease-in-out;
        }

        .cta-blob-2 {
            width: 250px;
            height: 250px;
            background: var(--primary-green);
            bottom: -10%;
            left: -5%;
            animation: float-blob-2 12s infinite ease-in-out;
        }

        @keyframes float-blob-1 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-30px, 20px) scale(1.1);
            }
        }

        @keyframes float-blob-2 {

            0%,
            100% {
                transform: translate(0, 0) scale(1.1);
            }

            50% {
                transform: translate(40px, -30px) scale(0.9);
            }
        }

        /* Testimonials Swiper Override for 3D look */
        .testimonials-swiper {
            padding: 40px 10px;
        }

        .testimonial-3d-card {
            background: #ffffff;
            border-radius: var(--border-radius-card);
            border: 1px solid rgba(27, 107, 67, 0.04);
            box-shadow: var(--card-shadow);
            padding: 35px;
            transition: var(--transition-smooth);
        }

        .swiper-slide-active .testimonial-3d-card {
            box-shadow: var(--card-shadow-hover);
            border-color: var(--primary-green);
        }

        /* Fluid typography setup */
        .fluid-hero-title {
            font-size: clamp(2.2rem, 3.8vw + 1rem, 4.4rem);
            line-height: 1.2;
            font-weight: 900;
            text-align: right;
        }

        .testimonial-nav-btn {
            width: 55px;
            height: 55px;
            border: none;
            border-radius: 50%;
            background: #fff;
            color: var(--bs-primary);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            transition: all .3s ease;
        }

        .testimonial-nav-btn:hover {
            transform: translateY(-4px);
            background: var(--bs-primary);
            color: #fff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .15);
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
                            <a class="nav-link" href="sponsorship/step1.html" id="nav-link-steps">خطوات الكفالة</a>
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

    <main>
        <section class="hero-container">
            <!-- Parallax child emotional image background -->
            <img src="{{ asset('assets/images/salah-darwish-gDk-wVG43pI-unsplash.jpg') }}" alt="طفل يتطلع بابتسامة وأمل"
                class="hero-bg-img" id="hero-parallax-bg">
            <div class="hero-gradient"></div>

            <div class="container py-5 hero-content">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7 text-white text-end">
                        <span
                            class="badge bg-secondary-gold text-dark mb-3 px-3 py-2 fw-extrabold text-uppercase rounded-pill shadow-sm text-right"
                            data-aos="fade-down" data-aos-delay="200"><i class="bi bi-star-fill me-1"></i> كنف
                            الإنسانية: رعاية لا
                            تنقطع</span>
                        <h1 class="fluid-hero-title mb-4 lh-base text-white" id="hero-text-reveal">
                            كُنْ مَعَ <span class="text-secondary-gold">اليَتِيمِ</span> كَنَفَاً،<br>تنعم بالسكينَةِ
                            والبركَة
                        </h1>
                        <p class="lead text-white-50 mb-5 fs-5 style-arabic-poetry"
                            style="max-width: 630px; line-height: 1.9; text-align: right;" data-aos="fade-up"
                            data-aos-delay="600">
                            أنت لا كافل ليتيم فحسب، بل رفيقُ مجرى حياة بأكمله، تنعم بشفافية مفرطة، وبتقارير تفاعلية،
                            واتصال روحي
                            وإنساني
                            يصنع الفارق الحقيقي كل يوم.
                        </p>
                        <div class="d-flex flex-wrap gap-3 hero-ctas" data-aos="fade-up" data-aos-delay="800">
                            <a href="{{ route('orphans') }}"
                                class="btn btn-secondary btn-lg px-5 py-3 shadow-lg rounded-pill"> اكفل طفلاً
                                الآن</a>
                            <a href="#how-it-works" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">كيف تعمل
                                كنف؟</a>
                        </div>
                    </div>

                    <div class="col-lg-5 position-relative text-center d-none d-lg-block">
                        <!-- Glassmorphism Floating Cards on the side portrait -->
                        <div class="hero-floating-stat floating-element" style="top: -60px; right: 20px; width: 280px;">
                            <div class="bg-primary-green text-white rounded-3 p-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-heart-pulse-fill fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">كفالة صحية شاملة</h6>
                                <p class="text-muted small mb-0">تغطية طبية دائمة للأبناء</p>
                            </div>
                        </div>

                        <div class="hero-floating-stat floating-element-reverse"
                            style="bottom: -20px; left: -10px; width: 280px;">
                            <div class="bg-secondary-gold text-dark rounded-3 p-3 d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-mortarboard-fill fs-3 text-white"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">التمكين التعليمي الأرقى
                                </h6>
                                <p class="text-muted small mb-0">مسار دراسي متكامل وموثق</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5" id="stats-section"
            style="background-color: #fcfbf9; border-bottom: 1px solid rgba(27, 107, 67, 0.05);">
            <div class="container py-4">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div
                            class="p-4 bg-white rounded-4 shadow-sm border border-light text-center h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-warm opacity-25"
                                style="z-index: 1;"></div>
                            <div class="position-relative" style="z-index: 2;">
                                <div class="text-secondary-gold mb-2"><i class="bi bi-people-fill fs-1"></i></div>
                                <!-- القيمة تتغير ديناميكياً بناءً على عدد المكفولين -->
                                <h2 class="display-3 fw-black text-primary-green mb-1 count-number"
                                    data-target="{{ $sponsoredCount ?? 0 }}">0</h2>
                                <p class="text-muted fw-bold mb-0">يتيم تم كفالته برعاية تفاعلية</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="p-4 bg-white rounded-4 shadow-sm border border-light text-center h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-warm opacity-25"
                                style="z-index: 1;"></div>
                            <div class="position-relative" style="z-index: 2;">
                                <div class="text-secondary-gold mb-2"><i class="bi bi-globe2 fs-1"></i></div>
                                <!-- القيمة تتغير ديناميكياً بناءً على المناطق المغطاة -->
                                <h2 class="display-3 fw-black text-primary-green mb-1 count-number"
                                    data-target="{{ $citiesCount ?? 0 }}">0</h2>
                                <p class="text-muted fw-bold mb-0">مدن وتجمعات جغرافية مغطاة</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div
                            class="p-4 bg-white rounded-4 shadow-sm border border-light text-center h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-warm opacity-25"
                                style="z-index: 1;"></div>
                            <div class="position-relative" style="z-index: 2;">
                                <div class="text-secondary-gold mb-2"><i class="bi bi-shield-fill-check fs-1"></i>
                                </div>
                                <h2 class="display-3 fw-black text-primary-green mb-1 count-number" data-target="100">
                                    0</h2>
                                <p class="text-muted fw-bold mb-0">نسبة الشفافية والتقارير المرفقة %</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================================================= --}}
        <section class="py-5" id="interactive-orphans-section">
            <div class="container py-4">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="text-secondary-gold fw-bold tracking-widest text-uppercase d-block mb-2">استقبال فوري
                        للدعم</span>
                    <h2 class="fw-black text-primary-green display-5 mb-3">أيتام يائسون بانتظار يد الكفالة</h2>
                    <p class="text-muted fs-5 mx-auto" style="max-width: 650px;">
                        بلمسة واحدة يمكنك أن تكون منبع الأمل لقلب صغير. اختر من القائمة أدناه لتبدأ رحلة أثر تفاعلية
                        مسجلة يومياً.
                    </p>
                </div>

                <!-- Shimmer loader simulator (Highly interactive experience) -->
                <div id="orphans-loader" class="row g-4 d-none">
                    <div class="col-lg-4 col-md-6">
                        <div class="kanaf-card bg-white" style="height: 480px;">
                            <div class="shimmer-bg w-100" style="height: 240px;"></div>
                            <div class="card-body p-4">
                                <div class="shimmer-bg rounded-pill w-50 mb-3" style="height: 20px;"></div>
                                <div class="shimmer-bg rounded-pill w-100 mb-2" style="height: 14px;"></div>
                                <div class="shimmer-bg rounded-pill w-75" style="height: 14px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="kanaf-card bg-white" style="height: 480px;">
                            <div class="shimmer-bg w-100" style="height: 240px;"></div>
                            <div class="card-body p-4">
                                <div class="shimmer-bg rounded-pill w-50 mb-3" style="height: 20px;"></div>
                                <div class="shimmer-bg rounded-pill w-100 mb-2" style="height: 14px;"></div>
                                <div class="shimmer-bg rounded-pill w-75" style="height: 14px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center d-none d-md-block">
                        <div class="kanaf-card bg-white" style="height: 480px;">
                            <div class="shimmer-bg w-100" style="height: 240px;"></div>
                            <div class="card-body p-4">
                                <div class="shimmer-bg rounded-pill w-50 mb-3" style="height: 20px;"></div>
                                <div class="shimmer-bg rounded-pill w-100 mb-2" style="height: 14px;"></div>
                                <div class="shimmer-bg rounded-pill w-75" style="height: 14px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4" id="orphans-grid" data-aos="fade-up" data-aos-delay="300">
                    <div class="row g-4" id="orphans-grid" data-aos="fade-up" data-aos-delay="300">
                        @forelse($orphans as $orphan)
                            <div class="col-lg-4 col-md-6">
                                <div class="kanaf-card h-100 bg-white">
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ $orphan->personal_photo_path ? asset('Uploads/orphans/' . $orphan->personal_photo_path) : asset('Uploads/orphans/default.png') }}"
                                            onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                            class="card-img-top w-100" style="height:260px;object-fit:cover;">

                                        <span
                                            class="badge position-absolute top-0 bg-primary-green px-3 py-2 fw-semibold rounded-3 text-white m-3"
                                            style="right:10px;">
                                            {{ $orphan->country ?? 'فلسطين' }}
                                        </span>
                                    </div>

                                    <div class="card-body p-4">
                                        <h5 class="fw-black text-dark mb-2">
                                            {{ $orphan->name }}
                                        </h5>

                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            @if ($orphan->is_double_orphan)
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill"
                                                    style="font-size: 0.72rem; font-weight: 700;">
                                                    يتيم الأبوين
                                                </span>
                                            @endif

                                            @if ($orphan->is_sole_breadwinner)
                                                <span
                                                    class="badge bg-dark-subtle text-dark border border-dark-subtle px-2.5 py-1 rounded-pill"
                                                    style="font-size: 0.72rem; font-weight: 700;">
                                                    ناجي وحيد
                                                </span>
                                            @endif

                                            @if ($orphan->is_critically_needy)
                                                <span
                                                    class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1 rounded-pill"
                                                    style="font-size: 0.72rem; font-weight: 700;">
                                                    أشد حاجة
                                                </span>
                                            @endif

                                            @if ($orphan->is_war_injured)
                                                <span class="badge bg-danger text-white px-2.5 py-1 rounded-pill"
                                                    style="font-size: 0.72rem; font-weight: 700;">
                                                    جريح حرب
                                                </span>
                                            @endif

                                            @if ($orphan->has_chronic_disease)
                                                <span
                                                    class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2.5 py-1 rounded-pill"
                                                    style="font-size: 0.72rem; font-weight: 700;">
                                                    مرض مزمن
                                                </span>
                                            @endif
                                        </div>

                                        <div class="d-flex gap-3 text-muted mb-3"
                                            style="font-size:.85rem;font-weight:600;">
                                            <span>
                                                <i class="bi bi-calendar3 text-primary-green me-1"></i>
                                                العمر: {{ $orphan->age ?? 10 }} سنوات
                                            </span>

                                            <span>
                                                <i class="bi bi-gender-ambiguous text-primary-green me-1"></i>
                                                الجنس: {{ $orphan->gender ?? 'ذكر' }}
                                            </span>
                                        </div>

                                        <p class="text-muted small lh-base mb-4">
                                            {{ Str::limit($orphan->story ?? 'يحتاج إلى دعم مستمر لتأمين التعليم والرعاية الصحية.', 110) }}
                                        </p>

                                        <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-muted d-block mb-1" style="font-size:.75rem;">
                                                    مبلغ الكفالة
                                                </span>

                                                <span class="fs-4 fw-black text-primary-green">
                                                    ${{ $orphan->required_amount }}
                                                </span>

                                                <span class="text-muted">
                                                    / شهرياً
                                                </span>
                                            </div>

                                            <a href="{{ route('orphans_details', $orphan->id) }}"
                                                class="btn btn-primary py-2 px-4 btn-sm fw-bold rounded-pill">
                                                تفاصيل
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted fs-5">لا يوجد أيتام بانتظار الكفالة حالياً.</p>
                            </div>
                        @endforelse

                    </div>

                </div>

                <div class="text-center mt-5" data-aos="zoom-in">
                    <a href="{{ route('orphans') }}" class="btn btn-outline-primary btn-lg px-5 py-3 rounded-pill">
                        استكشف جميع قصص الأيتام المسجلين <i class="bi bi-arrow-left fs-5 ms-2 align-middle"></i>
                    </a>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-5 bg-white border-top border-bottom overflow-hidden">
            <div class="container py-4">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="text-secondary-gold fw-bold tracking-widest text-uppercase d-block mb-2">الرحلة
                        المتكاملة</span>
                    <h2 class="fw-black text-primary-green display-5 mb-3">كيف تصنع كنف رحلة كفالة تنبض بالأثر؟</h2>
                    <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">عملية تواصل رقمية عالية الدقة تنقل
                        مشاعر الدعم من
                        قلب كنفك إلى مستقر حياة اليتيم.</p>
                </div>

                <div class="row g-5 align-items-center mt-3">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <h4 class="fw-bold text-primary-green mb-2">1. اختيار اليتيم وقصته الإنسانية</h4>
                            <p class="text-muted">استعراض صور تفاعلية، وقصص حقيقية مدققة ومحدثة بشكل تام لنفوس تنبض
                                بالأمل، لتختار من
                                تبتغي أن تكون كنفه وظله.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <h4 class="fw-bold text-primary-green mb-2">2. التزام الكفالة برضا مالي فوري</h4>
                            <p class="text-muted">نظام تعبئة ميسر وبوابات كفالة تلقائية فورية تضمن الثبات المالي لليتيم
                                شهراً تلو
                                الآخر
                                بثقة وطمأنينة تامة.</p>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <h4 class="fw-bold text-primary-green mb-2">3. الشفافية والمتابعة الروحية</h4>
                            <p class="text-muted">استلام تقارير دورية دراسية وصحية شاملة موقعة من الوصي والأم المتابعة
                                بشكل مباشر،
                                لتشعر
                                بنبض تقدم هذا الطفل الدائم.</p>
                        </div>
                    </div>

                    <div class="col-lg-6 position-relative text-center" data-aos="fade-left">
                        <div class="p-3 bg-warm rounded-5 overflow-hidden shadow-sm border">
                            <img src="{{ asset('assets/images/salah-darwish-XUrUZAimWyI-unsplash.jpg') }}"
                                alt="نشر الفرح بين الأطفال"
                                class="img-fluid rounded-4 shadow-lg border border-3 border-white floating-element"
                                style="max-height: 400px; object-fit: cover; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-warm text-dark overflow-hidden">
            <div class="container py-4">

                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="text-secondary-gold fw-bold tracking-widest text-uppercase d-block mb-1">
                        شهادات تروى بالروح
                    </span>
                    <h2 class="fw-black text-primary-green display-5 mb-3">
                        مشاعر كافلينا وشركاء الأثر
                    </h2>
                    <p class="text-muted fs-5 mx-auto" style="max-width: 600px;">
                        قصص كفلاء حقيقيين لمسوا التغيير والبركة في حياتهم وفي شؤون أبنائنا اليتامى.
                    </p>
                </div>

                <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel"
                    data-bs-interval="5000" data-aos="fade-up" data-aos-delay="200">

                    <!-- Indicators -->
                    <div class="carousel-indicators position-relative mt-4">
                        <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="0"
                            class="active"></button>

                        <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="1"></button>
                    </div>

                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row g-4">

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">د. صالح بن محمد الرويلي</h6>
                                                <p class="text-muted mb-0 small">
                                                    كافل لليتيم أحمد منذ عامين
                                                </p>
                                            </div>

                                            <div class="ms-auto text-warning">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            منصة كنف تفوق التوقعات بروحيتها وشفافيتها. التقارير الدراسية التي تصلني
                                            بانتظام تجعلني أحضر فرحة
                                            أحمد
                                            بنجاحه كما لو كان ابني الحقيقي تماماً.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">أ. منيرة بنت عبد الله سليمان</h6>
                                                <p class="text-muted mb-0 small">
                                                    كافلة لثلاثة أيتام
                                                </p>
                                            </div>

                                            <div class="ms-auto text-warning d-none d-sm-block">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            تسهيل عمليات الخصم التلقائي والبطاقات الائتمانية رفع عبئاً كبيراً عني وجعل
                                            متابعة الأطفال أكثر
                                            سهولة
                                            وراحة.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">م. خالد العثمان</h6>
                                                <p class="text-muted mb-0 small">
                                                    متبرع وشريك أثر كنف
                                                </p>
                                            </div>

                                            <div class="ms-auto text-warning d-none d-sm-block">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            تفاجأت بمستوى الحداثة البصرية والأداء الراقي للوحة التحكم وتجربة الكفالة
                                            السلسة والممتعة.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row g-4">

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">د. فاطمة الشمري</h6>
                                                <p class="text-muted mb-0 small">
                                                    كافلة منذ 3 سنوات
                                                </p>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            التقارير الشهرية والصور المحدثة جعلتني أشعر أنني قريبة من الطفل الذي أكفله
                                            وأتابع نجاحاته
                                            باستمرار.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">عبد الرحمن القحطاني</h6>
                                                <p class="text-muted mb-0 small">
                                                    داعم دائم للمشاريع
                                                </p>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            من أكثر المنصات وضوحاً واحترافية في عرض أثر التبرعات وإيصال التقارير المالية
                                            والتنموية.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="testimonial-3d-card h-100">
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=120&q=80"
                                                class="rounded-circle border" width="60" height="60"
                                                style="object-fit:cover;" alt=" "">

                                            <div>
                                                <h6 class="fw-black mb-1">ريم السبيعي</h6>
                                                <p class="text-muted mb-0 small">
                                                    شريكة أثر
                                                </p>
                                            </div>
                                        </div>

                                        <p class="text-muted lh-lg mb-0">
                                            تجربة جميلة ومؤثرة جعلتني أحرص على زيادة مساهمتي السنوية ومشاركة المنصة مع
                                            عائلتي وأصدقائي.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-3 mt-5">

                        <button class="testimonial-nav-btn" type="button" data-bs-target="#testimonialsCarousel"
                            data-bs-slide="prev">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <button class="testimonial-nav-btn" type="button" data-bs-target="#testimonialsCarousel"
                            data-bs-slide="next">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                    </div>

                </div>

            </div>
        </section>

        <section class="py-5" id="cta-section">
            <div class="container py-3">
                <div class="cta-container text-center text-white position-relative">
                    <div class="cta-blob cta-blob-1"></div>
                    <div class="cta-blob cta-blob-2"></div>

                    <div class="position-relative" style="z-index: 5;" data-aos="zoom-in">
                        <span
                            class="badge bg-secondary-gold text-dark mb-3 px-3 py-2 fw-extrabold text-uppercase rounded-pill">نداء
                            الروح والإنسانية</span>
                        <h2 class="display-3 fw-black text-white mb-4 lh-sm">
                            فقدوا دِفءَ الآباءِ.. <br>
                            <span class="text-secondary-gold">َفلا تَترُكْهُم يَفْقدُونَ الأَمَلَ</span>
                        </h2>
                        <p class="lead text-white-50 mb-5 mx-auto"
                            style="max-width: 650px; font-size: 1.2rem; line-height: 1.9;">
                            بمبلغ يسير جداً كل شهر، تضمن حماية ورعاية يتيم كنف. اجعل كفالتك صدقةً جارية تمنح طفلاً فرصة
                            حياة كريمة،
                            وتحفر اسمك في صفحات الخير.
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('orphans') }}"
                                class="btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-lg"> اكفل طفلاً
                                الآن</a>
                            <a href=" {{ route('register') }}"
                                class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">انضم لشركاء
                                كنف</a>
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
                        <li><a href="sponsorship/step1.html" class="text-white text-decoration-none">خطوات وبدء
                                الكفالة</a></li>
                        <li><a href=" {{ route('login') }}" class="text-white text-decoration-none">دخول
                                المستخدمين</a></li>
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
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll(".count-number");

            counters.forEach(counter => {
                const target = parseInt(counter.dataset.target);
                let current = 0;

                const increment = Math.ceil(target / 100);

                const updateCounter = () => {
                    current += increment;

                    if (current >= target) {
                        counter.innerText = target;
                    } else {
                        counter.innerText = current;
                        requestAnimationFrame(updateCounter);
                    }
                };

                updateCounter();
            });
        });
    </script>
</body>

</html>
