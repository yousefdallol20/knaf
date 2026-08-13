<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد - منصة كنف</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-warm d-flex flex-column" style="min-height: 100vh;">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark kanaf-navbar py-3 sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-4" href="{{ route('knaf') }}">
                    <img src="../assets/images/logo.png" alt="شعار كنف" height="50" width="110"
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
        <section class="flex-grow-1 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-9">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border text-center">
                            <h3 class="fw-bold text-primary-green mb-1">تسجيل حساب كنف جديد</h3>
                            <p class="text-muted text-small mb-4">انضم لعائلات وأوصياء أيتامنا أو ابدأ رحلة الكفالة
                                والإحسان الشامل
                            </p>

                           <form id="register-form" method="POST" action="{{ route('register') }}"
    class="needs-validation" novalidate
    onsubmit="this.querySelector('button[type=submit]').disabled = true;">
    @csrf

    <!-- أزرار اختيار نوع الحساب -->
    <div class="row mb-4">
        <div class="col-6">
            <div class="form-check form-check-inline p-3 border rounded-3 w-100 text-start bg-light cursor-pointer">
                <input class="form-check-input" type="radio" name="role"
                    id="role-sponsor" value="sponsor"
                    {{ old('role', 'sponsor') == 'sponsor' ? 'checked' : '' }}>
                <label class="form-check-label fw-bold text-dark block text-small cursor-pointer"
                    for="role-sponsor">أنا كافل جديد</label>
                <p class="text-muted text-caption mb-0">أريد تصفح الأيتام وكفالتهم مباشرة.</p>
            </div>
        </div>
        <div class="col-6">
            <div class="form-check form-check-inline p-3 border rounded-3 w-100 text-start bg-light cursor-pointer">
                <input class="form-check-input" type="radio" name="role"
                    id="role-guardian" value="guardian"
                    {{ old('role') == 'guardian' ? 'checked' : '' }}>
                <label class="form-check-label fw-bold text-dark block text-small cursor-pointer"
                    for="role-guardian">أنا وصي يتيم</label>
                <p class="text-muted text-caption mb-0">أريد تسجيل أطفالنا اليتامى لطلب كفلاء.</p>
            </div>
        </div>
    </div>

    <div class="row g-3 text-start mb-4">
        <div class="col-md-12">
            <label for="reg-name" class="form-label text-small fw-semibold text-muted">الاسم الكامل المطابق للهوية</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="reg-name" name="name" value="{{ old('name') }}"
                placeholder="الاسم الكامل باللغة العربية" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="reg-email" class="form-label text-small fw-semibold text-muted">البريد الإلكتروني</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                id="reg-email" name="email" value="{{ old('email') }}"
                placeholder="example@domain.com" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="reg-phone" class="form-label text-small fw-semibold text-muted">رقم الجوال لتلقي التوثيق</label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                id="reg-phone" name="phone" value="{{ old('phone') }}"
                placeholder="05xxxxxxxx" required>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="reg-pass" class="form-label text-small fw-semibold text-muted">كلمة المرور</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                id="reg-pass" name="password"
                placeholder="أدخل 6 خانات رموز وأحرف على الأقل" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="reg-confirm" class="form-label text-small fw-semibold text-muted">تأكيد كلمة المرور</label>
            <input type="password" class="form-control" id="reg-confirm"
                name="password_confirmation" placeholder="تطابق كلمة المرور" required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-full py-2 fw-bold fs-5 shadow-xs mb-3">
        إنشاء وتوثيق حسابي
    </button>
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
