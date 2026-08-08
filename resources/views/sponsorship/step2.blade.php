<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطوات الكفالة - الخطوة الثانية</title>
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
                    <div class="step-item completed">
                        <div class="step-indicator">1</div>
                        <span class="text-small fw-bold">اختيار اليتيم</span>
                    </div>
                    <div class="step-item active">
                        <div class="step-indicator">2</div>
                        <span class="text-small fw-bold">بيانات الكافل</span>
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
                            <h2 class="fw-bold text-primary-green mb-3 text-center">الخطوة الثانية: تعبئة معلومات
                                الكافـل الكريّم</h2>
                            <p class="text-muted text-center mb-5">يرجى تسجيل بياناتك لتمكيننا من توثيق عقد الكفالة
                                ومراسلتك بالتقارير
                                المدرسية والصحية الدورية.</p>

                            <form id="sponsor-form" class="needs-validation" novalidate action="{{ route('step2') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="orphan_id" value="{{ old('orphan_id', $orphanId) }}">

                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <label for="sponsor-name" class="form-label fw-bold text-muted text-small">
                                            الاسم الكامل المطابق للهوية الوطنية
                                        </label>
                                        <input type="text" id="sponsor-name" name="name" class="form-control py-2"
                                            placeholder="الاسم الرباعي هنا..." value="{{ old('name', $sponsor->name ?? $user->name) }}" required>
                                        <div class="invalid-feedback">يرجى كتابة الاسم الرباعي الصحيح الخاص بك باللغة
                                            العربية.</div>

                                        @error('name')
                                            <span class="error-msg d-block mt-1"
                                                style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sponsor-email" class="form-label fw-bold text-muted text-small">
                                            البريد الإلكتروني
                                        </label>
                                        <input type="email" id="sponsor-email" name="email"
                                            class="form-control py-2" placeholder="example@domain.com"
                                            value="{{ old('email', $user->email) }}" required>
                                        <div class="invalid-feedback">يرجى كتابة بريد إلكتروني صالح لاستلام التقارير
                                            الدراسية.</div>

                                        @error('email')
                                            <span class="error-msg d-block mt-1"
                                                style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sponsor-phone" class="form-label fw-bold text-muted text-small">
                                            رقم الجوال لتلقي الإشعارات والتحقق
                                        </label>
                                        <input type="tel" id="sponsor-phone" name="phone"
                                            class="form-control py-2" placeholder="05xxxxxxxx" pattern="^05[0-9]{8}$"
                                            value="{{ old('phone', $user->phone ?? $sponsor->phone ?? '') }}" required>
                                        <small class="text-muted text-caption d-block mt-1">صيغة الجوال المعتمدة:
                                            05xxxxxxxx</small>
                                        <div class="invalid-feedback">يرجى إدخال جوال سعودي صالح يتكون من 10 أرقام
                                            ويبدأ بـ 05.</div>

                                        @error('phone')
                                            <span class="error-msg d-block mt-1"
                                                style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sponsor-country"
                                            class="form-label fw-bold text-muted text-small">بلد الإقامة</label>
                                        <input type="text" id="sponsor-country" name="country"
                                            class="form-control py-2" placeholder="السعودية ,الامارات ..."
                                            value="{{ old('country', $sponsor->country ?? '') }}" required>

                                        @error('country')
                                            <span class="error-msg d-block mt-1"
                                                style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sponsor-city"
                                            class="form-label fw-bold text-muted text-small">المدينة</label>
                                        <input type="text" id="sponsor-city" name="city"
                                            class="form-control py-2" placeholder="الرياض، جدة..."
                                            value="{{ old('city', $sponsor->city ?? '') }}" required>
                                        <div class="invalid-feedback">يرجى إدراج اسم مدينة إقامتك الحالية متبوعاً
                                            بمحافظتك.</div>

                                        @error('city')
                                            <span class="error-msg d-block mt-1"
                                                style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a id="btn-back"
                                        href="{{ route('step1', ['id' => old('orphan_id', $orphanId)]) }}"
                                        class="btn btn-outline-secondary px-4 py-2">
                                        <i class="bi bi-arrow-right-short align-middle fs-5"></i> الخطوة السابقة
                                    </a>

                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                        الذهاب لخطوة الدفع <i class="bi bi-arrow-left-short align-middle fs-5"></i>
                                    </button>
                                </div>
                            </form>

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
