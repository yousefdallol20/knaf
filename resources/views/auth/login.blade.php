<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منصة كنف لكفالة الأيتام</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-warm d-flex flex-column" style="min-height: 100vh;">

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
                            <a class="nav-link" href="{{ asset('orphans') }}" id="nav-link-orphans">قائمة الأيتام</a>
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
        <!-- Login Area -->
        <section class="flex-grow-1 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border text-center">
                            <h3 class="fw-bold text-primary-green mb-1">تسجيل الدخول لمنصة كَنَفْ</h3>
                            <p class="text-muted text-small mb-4">كفل أيتامك، تتبع الأثر، والتقارير الدراسية بيسر</p>

                            <form id="login-form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- عرض رسالة الخطأ العامة إن وجدت -->
                                @if ($errors->has('login_error'))
                                    <div class="alert alert-danger text-small" role="alert">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                @endif

                                <div class="mb-3 text-start">
                                    <label for="login-email" class="form-label text-small fw-semibold text-muted">البريد
                                        الإلكتروني</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <!-- إضافة name وقيمة old -->
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="login-email" name="email" value="{{ old('email') }}"
                                            placeholder="name@domain.com" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="login-pass" class="form-label text-small fw-semibold text-muted">كلمة
                                        المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="login-pass"
                                            name="password" placeholder="••••••••" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 text-start">
                                    <label for="login-role" class="form-label text-small fw-semibold text-muted">الدور /
                                        بوابتك الخاصة</label>
                                    <!-- إضافة name -->
                                    <select class="form-select bg-light" id="login-role" name="role">
                                        <option value="sponsor">بوابة
                                            الكافل (Sponsor)</option>
                                        <option value="guardian">
                                            بوابة الوصي أو عائلة اليتيم (Guardian)</option>
                                        <option value="admin">لوحة كنف
                                            الإدارية الكاملة (Admin Manager)</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4 text-small">
                                    <div class="form-check">
                                        <!-- إضافة name -->
                                        <input class="form-check-input" type="checkbox" id="login-remember"
                                            name="remember">
                                        <label class="form-check-label text-muted" for="login-remember">تذكرني</label>
                                    </div>
                                    <a href="{{ route('password.request') }}"
                                        class="text-primary-green text-decoration-none">نسيت كلمة المرور؟</a>
                                </div>

                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 fw-bold fs-5 shadow-xs mb-3">تسجيل الدخول
                                    البوابي</button>

                                <div class="text-center text-small text-muted mb-0">
                                    <span>ليس لديك حساب بعد؟</span> <a href="{{ route('register') }}"
                                        class="text-primary-green text-decoration-none fw-bold">أنشئ حساب كافل الآن</a>
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
                                للبحث</a>
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
