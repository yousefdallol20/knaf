<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطوات الكفالة - الخطوة الثالثة والأخيرة</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-warm">

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
                            <a class="nav-link" href="sponsorship/step1.html" id="nav-link-steps">خطوات الكفالة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}" id="nav-link-contact">اتصل بنا</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2 align-items-center flex-wrap" id="nav-auth-buttons">
                        <a href=" {{ route('login') }}" class="btn btn-outline-light px-4 rounded-pill"
                            id="nav-btn-login">تسجيل الدخول</a>
                        <a href=" {{ route('register') }}" class="btn btn-secondary px-4 rounded-pill fw-bold"
                            id="nav-btn-register">ابدأ الكفالة الآن</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="py-4 bg-white border-bottom shadow-xs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center max-w-xl mx-auto">
                    <div class="step-item completed">
                        <div class="step-indicator">1</div>
                        <span class="text-small fw-bold">اختيار اليتيم</span>
                    </div>
                    <div class="step-item completed">
                        <div class="step-indicator">2</div>
                        <span class="text-small fw-bold">بيانات الكافل</span>
                    </div>
                    <div class="step-item active">
                        <div class="step-indicator">3</div>
                        <span class="text-small fw-bold">الدفع والتأكيد</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8" id="payment-workspace">

                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                            <h2 class="fw-bold text-primary-green mb-3 text-center">الخطوة الثالثة والأخيرة: المدفوعات
                                وتأكيد الكفالة</h2>
                            <p class="text-muted text-center mb-5">يرجى تحديد طريقة الدفع المناسبة لإيداع الكفالة
                                الشهرية الأولى.</p>

                            <div class="row g-4 mb-5">
                                <div class="col-md-5 order-md-2">
                                    <div class="bg-light p-4 rounded-4 border">
                                        <h5 class="fw-bold text-dark mb-3">ملخص الكفالة</h5>

                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <img src="{{ $orphan->orphan && $orphan->orphan->personal_photo_path ? asset('Uploads/orphans/' . $orphan->orphan->personal_photo_path) : asset('Uploads/orphans/default.png') }}"
                                                onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                                class="rounded-circle shadow-xs"
                                                style="width:50px;height:50px;object-fit:cover;">
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">
                                                    {{ $orphan->name }}
                                                </h6>
                                                <span class="text-muted text-small">
                                                    {{ $orphan->country ?? 'فلسطين' }} - {{ $orphan->city ?? 'غزة' }}
                                                </span>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-between mb-2 text-small">
                                            <span class="text-muted">مبلغ الكفالة الشهري</span>
                                            <span class="fw-bold text-dark" id="recap-base">$
                                                {{ $orphan->required_amount }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2 text-small">
                                            <span class="text-muted">رسوم البوابة والضرائب</span>
                                            <span class="text-success fw-bold">كفالة خيرية (0%)</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center text-dark">
                                            <span class="fw-bold">المبلغ الإجمالي المحصل</span>
                                            <strong class="fs-4 text-primary-green" id="recap-total">
                                                {{ $orphan->required_amount }}$</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7 order-md-1">
                                    <h5 class="fw-bold mb-3 text-dark">اختر وسيلة إيداع الدفعة الأولى</h5>

                                    <div class="nav nav-pills gap-2 mb-4 d-flex" id="payment-tabs" role="tablist">
                                        <button class="nav-link flex-fill py-2 active text-center border"
                                            id="tab-card-btn" data-bs-toggle="pill" data-bs-target="#tab-card"
                                            type="button" role="tab" aria-selected="true">
                                            <i class="bi bi-credit-card-2-back me-1"></i> مدى / فيزا
                                        </button>
                                        <button class="nav-link flex-fill py-2 text-center border" id="tab-bank-btn"
                                            data-bs-toggle="pill" data-bs-target="#tab-bank" type="button"
                                            role="tab" aria-selected="false">
                                            <i class="bi bi-bank me-1"></i> تحويل مصرفي
                                        </button>
                                    </div>

                                    <div class="tab-content" id="payment-tab-content">

                                        <!-- 1️⃣ التبويب الأول: الدفع بالبطاقة -->
                                        <div class="tab-pane fade show active" id="tab-card" role="tabpanel"
                                            aria-labelledby="tab-card-btn">
                                            <form id="card-pay-form" class="needs-validation" novalidate
                                                action="{{ route('step3') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="orphan_id" value="{{ $orphan->id }}">
                                                <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
                                                <input type="hidden" name="amount_paid"
                                                    value="{{ $amountToPay }}">
                                                <input type="hidden" name="payment_method" value="card">
                                                <input type="hidden" name="transaction_id"
                                                    value="CARD_{{ time() }}_{{ rand(1000, 9999) }}">

                                                <div class="mb-3">
                                                    <label class="form-label text-small fw-bold text-muted">اسم كرت
                                                        الدفع (الاسم المكتوب على البطاقة)</label>
                                                    <input type="text" name="card_name" class="form-control"
                                                        placeholder="A. ALOTAIBI" value="{{ old('card_name') }}"
                                                        required>
                                                    @error('card_name')
                                                        <span class="error-msg d-block mt-1"
                                                            style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-small fw-bold text-muted">رقم
                                                        البطاقة</label>
                                                    <input type="text" name="card_number" class="form-control"
                                                        placeholder="4000 1234 5678 9010" pattern="^[0-9 ]{16,19}$"
                                                        required>
                                                </div>
                                                <div class="row g-2 mb-4">
                                                    <div class="col-7">
                                                        <label class="form-label text-small fw-bold text-muted">تاريخ
                                                            الانتهاء</label>
                                                        <input type="text" name="card_expiry"
                                                            class="form-control text-center" placeholder="MM/YY"
                                                            pattern="^(0[1-9]|1[0-2])\/([0-9]{2})$" maxlength="5"
                                                            required>
                                                        <div class="invalid-feedback">يرجى إدخال صيغة تاريخ صحيحة
                                                            (MM/YY).</div>
                                                    </div>
                                                    <div class="col-5">
                                                        <label class="form-label text-small fw-bold text-muted">الرقم
                                                            السري (CVV)</label>
                                                        <input type="password" name="card_cvv"
                                                            class="form-control text-center" placeholder="123"
                                                            pattern="^[0-9]{3,4}$" required>
                                                    </div>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary w-100 py-3 fw-bold fs-5 border-0">
                                                    إتمام عملية الفوترة والدفع الآمن
                                                </button>
                                            </form>
                                        </div>

                                        <!-- 2️⃣ التبويب الثاني: التحويل المصرفي -->
                                        <div class="tab-pane fade" id="tab-bank" role="tabpanel"
                                            aria-labelledby="tab-bank-btn">
                                            <div class="alert alert-info py-3 mb-4 text-small">
                                                <h6 class="fw-bold mb-2"><i class="bi bi-info-circle-fill me-1"></i>
                                                    تعليمات التحويل المصرفي</h6>
                                                <p class="mb-0">يرجى تحويل مبلغ الكفالة إلى حساب "مؤسسة كنف لكفالة
                                                    الأيتام" المعتمد أدناه، ثم كتابة رقم مرجع التحويل أو إشعار التحويل
                                                    لتأكيد الكفالة يدوياً.</p>
                                            </div>

                                            <div class="bg-light p-3 rounded-3 border mb-4 text-small">
                                                <div class="mb-2"><strong>البنك:</strong> بنك فلسطين (حساب كفالة
                                                    أيتام غزة المعتمد)</div>
                                                <div class="mb-2"><strong>اسم الحساب:</strong> كنف لبناء ورعاية أيتام
                                                    فلسطين</div>
                                                <div class="mb-2"><strong>رقم الآيبان:</strong>
                                                    PS24BOPD000000000120455621</div>
                                            </div>

                                            <form id="bank-pay-form" class="needs-validation" novalidate
                                                action="{{ route('step3') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <input type="hidden" name="orphan_id" value="{{ $orphan->id }}">
                                                <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
                                                <input type="hidden" name="amount_paid"
                                                    value="{{ $amountToPay }}">
                                                <input type="hidden" name="payment_method" value="bank_transfer">

                                                <div class="mb-3">
                                                    <label class="form-label text-small fw-bold text-muted">رقم
                                                        مرجع التحويل (الموجود في تطبيق بنكك)</label>
                                                    <input type="text" id="bank-ref" name="bank_reference_number"
                                                        class="form-control" placeholder="مثال: TRX9018227"
                                                        value="{{ old('bank_reference_number') }}" required>
                                                    @error('bank_reference_number')
                                                        <span class="error-msg d-block mt-1"
                                                            style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label text-small fw-bold text-muted">إرفاق
                                                        إشعار تحويل البنك (مطلوب للتحقق)</label>
                                                    <input type="file" name="bank_receipt_file"
                                                        class="form-control text-small" required>
                                                    @error('bank_receipt_file')
                                                        <span class="error-msg d-block mt-1"
                                                            style="color: rgb(255, 0, 0); font-size: 0.85rem;">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <button type="submit"
                                                    class="btn btn-primary w-100 py-3 fw-bold fs-5 text-white border-0">
                                                    إرسال إشعار التحويل البنكي للمراجعة
                                                </button>
                                            </form>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="d-flex justify-content-between border-top pt-4">
                                <a id="btn-back-step"
                                    href="{{ route('create_step2', ['orphan_id' => $orphan->id]) }}"
                                    class="btn btn-outline-secondary px-4 py-2"><i
                                        class="bi bi-arrow-right-short align-middle fs-5"></i> تعديل بياناتي</a>
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
                            <h5 class="text-white mb-0 fw-bold">منصة كَنَفْ لكفالة الأيتام</h5>
                        </div>
                        <p class="text-white text-small">منصة تفاعلية رقمية موثوقة وآمنة تهدف لربط الكافلين بالأيتام
                            الأكثر احتياجاً لمتابعة حالتهم وتحقيق الكفالة الشاملة بكل شفافية وحب.</p>
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
                                والأمهات</a></li>
                        <li><a href="admin/dashboard.html" class="text-white text-decoration-none">لوحة الإدارة
                                الشاملة</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white fw-bold mb-3">النشرة الإخبارية</h6>
                    <p class="text-white text-small mb-3">اشترك معنا ليصلك تحديثات وتقارير أثر الكفالات وأحدث الأيتام
                        المسجلين.</p>
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
