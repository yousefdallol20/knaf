<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور - منصة كنف لكفالة الأيتام</title>
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
        <section class="flex-grow-1 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">

                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border text-center">
                            <div class="mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                                    style="width:64px;height:64px;background:rgba(var(--bs-success-rgb, 25,135,84),0.08);">
                                    <i class="bi bi-shield-lock fs-2 text-primary-green"></i>
                                </div>
                                <h3 class="fw-bold text-primary-green mb-1">إنشاء كلمة مرور جديدة</h3>
                                <p class="text-muted text-small mb-0">
                                    أدخل كلمة المرور الجديدة لحماية حسابك، ثم أكدها مرة أخرى.
                                </p>
                            </div>

                            <form id="reset-password-form" method="POST" action="{{ route('password.update') }}"
                                novalidate>
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3 text-start">
                                    <label for="email" class="form-label text-small fw-semibold text-muted">
                                        البريد الإلكتروني
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ $email ?? old('email') }}" readonly
                                            required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="new-password" class="form-label text-small fw-semibold text-muted">
                                        كلمة المرور الجديدة
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="new-password" name="password" placeholder="أدخل كلمة المرور الجديدة"
                                            minlength="8" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="toggle-new-password" aria-label="إظهار كلمة المرور">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="confirm-password"
                                        class="form-label text-small fw-semibold text-muted">
                                        تأكيد كلمة المرور
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" class="form-control" id="confirm-password"
                                            name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="toggle-confirm-password" aria-label="إظهار كلمة المرور">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div id="password-match-error" class="invalid-feedback text-start">
                                        كلمتا المرور غير متطابقتين.
                                    </div>
                                </div>

                                <div class="alert text-small text-start mb-4"
                                    style="background:#f0faf5;border:1px solid #b7e4cc;color:#166534;border-radius:10px;">
                                    <i class="bi bi-info-circle me-1"></i>
                                    يجب أن تحتوي كلمة المرور على <strong>8 أحرف على الأقل</strong>.
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold fs-5 shadow-xs mb-3">
                                    <span id="btn-reset-text">تعيين كلمة المرور</span>
                                    <span id="btn-reset-spinner" class="spinner-border spinner-border-sm d-none ms-1"
                                        role="status"></span>
                                </button>

                                <div class="text-center text-small text-muted">
                                    <a href="{{ route('login') }}" class="text-primary-green text-decoration-none">
                                        <i class="bi bi-arrow-right me-1"></i>العودة لتسجيل الدخول
                                    </a>
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
                            @if (!empty($settings['social_facebook']))
                                <a href="https://facebook.com/{{ $settings['social_facebook'] }}" target="_blank"
                                    rel="noopener" class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-facebook"></i></a>
                            @endif
                            @if (!empty($settings['social_instagram']))
                                <a href="https://instagram.com/{{ $settings['social_instagram'] }}" target="_blank"
                                    rel="noopener" class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-instagram"></i></a>
                            @endif
                            @if (!empty($settings['social_x']))
                                <a href="https://x.com/{{ $settings['social_x'] }}" target="_blank" rel="noopener"
                                    class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-twitter-x"></i></a>
                            @endif
                            @if (!empty($settings['social_youtube']))
                                <a href="https://youtube.com/{{ $settings['social_youtube'] }}" target="_blank"
                                    rel="noopener" class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-youtube"></i></a>
                            @endif
                            @if (!empty($settings['social_whatsapp']))
                                <a href="https://wa.me/{{ $settings['social_whatsapp'] }}" target="_blank"
                                    rel="noopener" class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-whatsapp"></i></a>
                            @endif
                            @if (!empty($settings['social_telegram']))
                                <a href="https://t.me/{{ $settings['social_telegram'] }}" target="_blank"
                                    rel="noopener" class="btn btn-sm btn-outline-secondary text-white"><i
                                        class="bi bi-telegram"></i></a>
                            @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reset-password-form');
            const newPassword = document.getElementById('new-password');
            const confirmPassword = document.getElementById('confirm-password');
            const matchError = document.getElementById('password-match-error');

            function togglePassword(buttonId, inputId) {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);

                button.addEventListener('click', function() {
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    button.innerHTML = isPassword ?
                        '<i class="bi bi-eye-slash"></i>' :
                        '<i class="bi bi-eye"></i>';
                    button.setAttribute(
                        'aria-label',
                        isPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'
                    );
                });
            }

            togglePassword('toggle-new-password', 'new-password');
            togglePassword('toggle-confirm-password', 'confirm-password');

            function validateMatch() {
                if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
                    confirmPassword.classList.add('is-invalid');
                    matchError.style.display = 'block';
                    return false;
                }

                confirmPassword.classList.remove('is-invalid');
                matchError.style.display = '';
                return true;
            }

            confirmPassword.addEventListener('input', validateMatch);
            newPassword.addEventListener('input', function() {
                if (confirmPassword.value) validateMatch();
            });

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity() || !validateMatch()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                    return;
                }

                document.getElementById('btn-reset-text').textContent = 'جارٍ الحفظ...';
                document.getElementById('btn-reset-spinner').classList.remove('d-none');
            });
        });
    </script>
</body>

</html>
