<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة كنف لكفالة الأيتام - اتصل بنا</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        body {
            background-color: #fcfefe;
            color: #333;
        }

        .contact-hero {
            background: linear-gradient(135deg, var(--primary-green) 0%, #114227 100%);
            color: white;
            padding: 5rem 0 4rem;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 60px;
            background: #fcfefe;
            transform: skewY(-2deg);
        }

        .contact-info-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .contact-info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05) !important;
        }

        .info-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light-green);
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        .card-contact-form {
            border: none;
            border-radius: 20px;
            background: white;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border-color: #e2e8f0;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(26, 94, 56, 0.15);
        }

        .btn-submit-contact {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            border-radius: 12px;
            padding: 0.85rem 2rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-submit-contact:hover {
            background-color: #114227;
            border-color: #114227;
            color: white;
            transform: translateY(-2px);
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
                            <a class="nav-link" href=" {{ route('step') }}" id="nav-link-steps">خطوات الكفالة</a>
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
        <!-- Hero Section -->
        <section class="contact-hero text-center text-md-start">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-md-7">
                        <span class="badge bg-white text-success px-3 py-2 rounded-pill fw-bold mb-3 fs-7"
                            style="color: var(--primary-green) !important;">تواصل معنا الآن</span>
                        <h1 class="fw-black text-white display-5 mb-3" style="font-family: 'Cairo', sans-serif;">نسعد
                            دائماً
                            بالإجابة
                            على استفساراتكم الشريفة</h1>
                        <p class="lead text-white-50 mb-0">نحن هنا لمساعدتكم في كل ما يتعلق بكفالة الأيتام وتوفير
                            الرعاية الكريمة
                            لعائلات شهداء غزة. فريق منصة كنف مكرّس لخدمتكم على مدار الساعة.</p>
                    </div>
                    <div class="col-md-5 text-center text-md-end d-none d-md-block">
                        <i class="bi bi-envelope-heart text-white-50" style="font-size: 8rem;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main section -->
        <section class="py-5" style="margin-top: -1.5rem; position: relative; z-index: 5;">
            <div class="container">
                <div class="row g-4">

                    <!-- Contact Info column (Right) -->
                    <div class="col-lg-4">
                        <div class="d-flex flex-column gap-4">

                            <!-- Address Card -->
                            <div class="card contact-info-card p-4 shadow-sm border">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="info-icon-wrapper flex-shrink-0">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">المكتب الرئيسي</h5>
                                        <p class="text-muted small mb-0">شمال قطاع غزة، جباليا البلد / فرع الطوارئ
                                            الإداري المساعد بدير
                                            البلح،
                                            وسط قطاع غزة، فلسطين.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Email Card -->
                            <div class="card contact-info-card p-4 shadow-sm border">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="info-icon-wrapper flex-shrink-0">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">البريد الإلكتروني</h5>
                                        <p class="text-muted small mb-1">للاستفسارات والتقارير العامة:</p>
                                        <a href="mailto:info@kanaf.ps"
                                            class="text-primary-green fw-bold text-decoration-none small">info@kanaf.ps</a>
                                        <p class="text-muted small mt-2 mb-1">لقضايا الدعم والتوثيق المالي:</p>
                                        <a href="mailto:sponsorships@kanaf.ps"
                                            class="text-primary-green fw-bold text-decoration-none small">sponsorships@kanaf.ps</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone Card -->
                            <div class="card contact-info-card p-4 shadow-sm border">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="info-icon-wrapper flex-shrink-0">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">اتصال مباشر وواتساب</h5>
                                        <p class="text-muted small mb-1">خدمة الكافلين الجدد:</p>
                                        <a href="tel:+970591234567" class="text-dark fw-bold text-decoration-none small"
                                            dir="ltr">+970
                                            59-123-4567</a>
                                        <p class="text-muted small mt-2 mb-1">شؤون الأوصياء ومطالبات العائلات بغزة:</p>
                                        <a href="tel:+970597654321"
                                            class="text-dark fw-bold text-decoration-none small" dir="ltr">+970
                                            59-765-4321</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Working Hours Card -->
                            <div
                                class="card contact-info-card p-4 shadow-sm border bg-success-subtle text-success border-success-subtle">
                                <div class="d-flex gap-3">
                                    <i class="bi bi-clock-history fs-4"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">ساعات العمل والرد</h6>
                                        <p class="small mb-0 text-muted">يعمل فريق المجهزين والباحثين الميدانيين طيلة
                                            أيام الأسبوع لمجابهة
                                            الحالات الصعبة، ويتم الرد الإداري من السبت إلى الخميس: 9:00 صباحاً - 4:00
                                            مساءً بتوقيت القدس
                                            المعتمد.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Contact Form column (Left) -->
                    <div class="col-lg-8">
                        <div class="card card-contact-form p-4 p-md-5 shadow-sm border">
                            <h4 class="fw-bold text-dark mb-2"><i
                                    class="bi bi-chat-right-text-fill text-primary-green me-2"></i>
                                إرسال
                                رسالة واستفسار جديد</h4>
                            <p class="text-muted text-small mb-4">يرجى تعبئة الحقول المطلوبة بدقة وتوجيه رسالتك للقسم
                                المعني ليتم
                                إحالة
                                الطلب مباشرة للجنة المختصة.</p>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.send') }}" method="POST" id="kanaf-contact-form">
                                @csrf
                                <div class="row g-3">

                                    <!-- Full Name -->
                                    <div class="col-md-6 text-start">
                                        <label for="contact-name"
                                            class="form-label text-small fw-semibold text-muted">اسمك بالكامل <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="contact-name"
                                            placeholder="مثال: عبد الرحمن الباتع" required>
                                        <div class="invalid-feedback">يرجى كتابة الاسم بالكامل لضمان الرد المصنف.</div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 text-start">
                                        <label for="contact-email"
                                            class="form-label text-small fw-semibold text-muted">البريد الإلكتروني
                                            <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="contact-email"
                                            placeholder="name@example.com" required>
                                        <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صالح لنتمكن من الرد
                                            عليك.</div>
                                    </div>

                                    <!-- Phone number -->
                                    <div class="col-md-6 text-start">
                                        <label for="contact-phone"
                                            class="form-label text-small fw-semibold text-muted">رقم الجوال /
                                            الواتساب
                                            <span class="text-caption text-muted">(اختياري)</span></label>
                                        <input type="tel" name="phone" class="form-control text-start"
                                            id="contact-phone" placeholder="059XXXXXXX" dir="ltr">
                                    </div>

                                    <!-- Query Type -->
                                    <div class="col-md-6 text-start">
                                        <label for="contact-type"
                                            class="form-label text-small fw-semibold text-muted">قسم الاستفسار الرئيسي
                                            <span class="text-danger">*</span></label>
                                        <select name="type" class="form-select text-small" id="contact-type"
                                            required>
                                            <option value="" disabled selected>اختر القسم المناسب للرسالة...
                                            </option>
                                            <option value="sponsorship_inquiry">استفسار حول كفالة يتيم جديد (أفراد
                                                ومؤسسات)</option>
                                            <option value="guardian_support">حقوق ومطالبات أوصياء الأيتام (عائلات غزة)
                                            </option>
                                            <option value="partnership_request">شراكة وتعاون مؤسسي أو دعم عيني طارئ
                                            </option>
                                            <option value="technical_issue">مشكلة تقنية داخل لوحة التحكم أو الحساب
                                            </option>
                                            <option value="other">استفسارات أخرى عامة</option>
                                        </select>
                                        <div class="invalid-feedback">يرجى تحديد قسم الاستفسار لتصل رسالتك بدقة.</div>
                                    </div>

                                    <!-- Email Subject -->
                                    <div class="col-md-12 text-start">
                                        <label for="contact-subject"
                                            class="form-label text-small fw-semibold text-muted">موضوع الاستفسار
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="subject" class="form-control"
                                            id="contact-subject"
                                            placeholder="مثال: الاستفسار عن كفالة أطفال عائلة اليازجي غزة" required>
                                        <div class="invalid-feedback">يرجى تحديد موضوع موجز ومفهوم للرسالة.</div>
                                    </div>

                                    <!-- Message Box -->
                                    <div class="col-md-12 text-start">
                                        <label for="contact-message"
                                            class="form-label text-small fw-semibold text-muted">تفاصيل الرسالة
                                            والاستفسار <span class="text-danger">*</span></label>
                                        <textarea name="message" class="form-control" id="contact-message" rows="5"
                                            placeholder="اكتب تفاصيل استفسارك الشريف وسيقوم منسق القسم بالإجابة الوافية عليكم..." required
                                            style="resize: none;"></textarea>
                                        <div class="invalid-feedback">يرجى كتابة نص رسالتك الشريفة.</div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="col-12 mt-4 text-center text-md-start">
                                        <button type="submit"
                                            class="btn btn-submit-contact px-5 fs-6 w-100 w-md-auto">
                                            <i class="bi bi-send-fill me-2"></i> إرسال الاستفسار الآن للإدارة
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="py-4 bg-light">
            <div class="container text-center">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-shield-fill-check text-primary-green me-1"></i>
                    ضمان ومنهجية
                    تتبع كنف الموثوقة</h5>
                <p class="max-w-xl mx-auto small text-muted mb-0">جميع البيانات والرسائل الواردة إلينا عبر هذا النموذج
                    مشفرة
                    ومصنفة بالكامل بأعلى مستوى من النزاهة القانونية وحقوق وحماية الطفل. ستتلقى إشعاراً مرجعياً مباشراً
                    بالاستجابة
                    على بريدك الإلكتروني المدخل فور مراجعة أحد المنسقين.</p>
            </div>
        </section>

    </main>

    <footer class="kanaf-footer py-5 mt-5 pb-0">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <div class="d-flex align-items-center gap-2 mb-3">
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
</body>

</html>
