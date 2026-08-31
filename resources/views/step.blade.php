<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>كنف | ابدأ رحلة الكفالة</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1b6b43;
            --primary-dark: #0e6858;
            --accent: #d39b1f;
            --accent-dark: #c58f17;
            --bg: #fcfbf9;
            --text: #18382e;
            --muted: #6c7b78;
            --card: #ffffff;
            --line: #e5eeea;
            --white: #ffffff;
            --shadow: 0 18px 50px rgba(20, 70, 60, 0.09);
        }

        /* =========================================================
   Bootstrap Override
   ========================================================= */

        /* Prevent Bootstrap .badge from affecting our hero badge */
        .hero .badge {
            display: inline-block;
            width: auto;
            height: auto;
            padding: 7px 15px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
        }

        /* Prevent Bootstrap .nav from affecting hero navigation */
        .hero .nav {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0;
        }

        /* =========================================================
   Navbar
   ========================================================= */

        .kanaf-navbar {
            background: #2c7751 !important;
        }

        .kanaf-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            transition: 0.25s ease;
        }

        .kanaf-navbar .nav-link:hover {
            color: #ffffff;
        }

        .kanaf-navbar .nav-link.active {
            color: var(--accent) !important;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
        }

        .kanaf-navbar .btn-secondary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #1a1a1a !important;
        }

        .kanaf-navbar .btn-secondary:hover {
            background: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
        }

        /* =========================================================
   Hero
   ========================================================= */

        .hero {
            position: relative;
            overflow: hidden;
            padding: 42px 0 88px;
            background: linear-gradient(135deg,
                    #2C7751 0%,
                    #13492E 52%,
                    #0E3621 100%) !important;
            color: #ffffff;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::before {
            width: 420px;
            height: 420px;
            left: -150px;
            top: -180px;
            background: rgba(255, 255, 255, 0.055);
        }

        .hero::after {
            width: 280px;
            height: 280px;
            right: -100px;
            bottom: -120px;
            background: rgba(255, 255, 255, 0.045);
        }

        /* =========================================================
   Hero Top
   ========================================================= */

        .hero .brand {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #ffffff;
        }

        .hero .badge {
            font-size: 13px;
            padding: 7px 15px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        /* =========================================================
   Hero Grid
   ========================================================= */

        .hero-grid {
            position: relative;
            z-index: 1;

            display: grid;
            grid-template-columns: 1.25fr 0.75fr;

            gap: 55px;
            align-items: center;

            padding-top: 60px;
        }

        /* =========================================================
   Hero Content
   ========================================================= */

        .eyebrow {
            display: inline-flex;
            align-items: center;

            padding: 7px 15px;

            background: rgba(211, 155, 31, 0.14) !important;
            border: 1px solid rgba(211, 155, 31, 0.48) !important;
            border-radius: 999px;

            color: #f5d77a !important;
            font-size: 14px;
        }

        .hero h1 {
            margin: 20px 0 16px;

            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.3;
            font-weight: 800;

            color: #ffffff;
        }

        .hero p {
            max-width: 650px;
            margin: 0 0 28px;

            color: #e4f0ed;
            font-size: 18px;
        }

        /* =========================================================
   Hero Buttons
   ========================================================= */

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /*
   We intentionally keep .btn here because
   the HTML already uses Bootstrap .btn.
*/

        .hero .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 14px 24px;

            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;

            transition: 0.25s ease;
        }

        .hero .btn-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #1a1a1a !important;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .hero .btn-primary:hover {
            background: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
            color: #1a1a1a !important;

            transform: translateY(-2px);
        }

        .hero .btn-outline {
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.38) !important;
            background: transparent !important;
        }

        .hero .btn-outline:hover {
            background: rgba(255, 255, 255, 0.08) !important;
        }

        /* =========================================================
   Hero Card
   ========================================================= */

        .hero-card {
            position: relative;
            z-index: 2;

            width: 100%;
            min-height: 300px;
            height: auto;

            padding: 30px;

            background: rgba(255, 255, 255, 0.10) !important;

            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            border-radius: 30px;

            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);

            overflow: visible !important;
        }

        .hero-card h3 {
            margin: 0 0 25px;

            color: #ffffff;

            font-size: 26px;
            font-weight: 800;

            text-align: center;
        }

        /* =========================================================
   IMPORTANT:
   Bootstrap has .progress.
   We override it completely here.
   ========================================================= */

        .hero .progress {
            /* Override Bootstrap */
            display: flex !important;

            flex-direction: column !important;
            align-items: stretch !important;

            gap: 13px !important;

            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;

            margin: 0 !important;
            padding: 0 !important;

            background: transparent !important;

            border-radius: 0 !important;

            overflow: visible !important;
        }

        /* =========================================================
   Progress Items
   ========================================================= */

        .hero .progress-item {
            display: flex;

            align-items: center;

            width: 100%;

            gap: 12px;

            padding: 10px 12px;

            background: rgba(255, 255, 255, 0.07);

            border: 1px solid rgba(255, 255, 255, 0.05);

            border-radius: 14px;

            color: #ffffff;

            transition: 0.25s ease;
        }

        .hero .progress-item:hover {
            background: rgba(255, 255, 255, 0.12);

            transform: translateX(-3px);
        }

        /* =========================================================
   Number Circle
   ========================================================= */

        .hero .progress-item .num {
            display: flex !important;

            align-items: center;
            justify-content: center;

            width: 40px !important;
            min-width: 40px !important;
            height: 40px !important;

            padding: 0 !important;
            margin: 0 !important;

            border-radius: 50% !important;

            background: var(--accent) !important;

            color: #2b2110 !important;

            font-size: 14px;
            font-weight: 800;

            line-height: 1;
        }

        /* =========================================================
   Progress Text
   ========================================================= */

        .hero .progress-item span {
            display: block;

            flex: 1;

            color: #ffffff;

            font-size: 14px;
            font-weight: 500;

            line-height: 1.7;
        }

        /* =========================================================
   Main Sections
   ========================================================= */

        .section {
            padding: 85px 0;
        }

        .section-head {
            max-width: 700px;

            margin: 0 auto 45px;

            text-align: center;
        }

        .section-head h2 {
            margin: 0 0 8px;

            color: var(--text);

            font-size: 34px;
            font-weight: 800;
        }

        .section-head p {
            margin: 0;

            color: var(--muted);
        }

        /* =========================================================
   Steps
   ========================================================= */

        .steps {
            display: grid;

            grid-template-columns: repeat(5, 1fr);

            gap: 16px;
        }

        .step {
            position: relative;

            padding: 22px;

            background: var(--card);

            border: 1px solid var(--line);
            border-radius: 20px;

            box-shadow: 0 8px 30px rgba(28, 77, 66, 0.04);

            transition: 0.25s ease;
        }

        .step:hover {
            transform: translateY(-4px);

            box-shadow: 0 15px 35px rgba(28, 77, 66, 0.08);
        }

        .step .step-no {
            display: inline-block;

            padding: 5px 10px;

            color: var(--primary) !important;

            background: #e9f4ee !important;

            border-radius: 999px;

            font-size: 12px;
            font-weight: 800;
        }

        .step h3 {
            margin: 15px 0 7px;

            color: var(--text);

            font-size: 17px;
            font-weight: 800;
        }

        .step p {
            margin: 0;

            color: var(--muted);

            font-size: 13px;
            line-height: 1.8;
        }

        /* =========================================================
   Information Section
   ========================================================= */

        .important {
            background: #ffffff;
        }

        .info-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 24px;
        }

        .info-card {
            padding: 30px;

            background: #ffffff;

            border: 1px solid var(--line);
            border-radius: 24px;

            box-shadow: 0 8px 25px rgba(28, 77, 66, 0.03);
        }

        .info-card h3 {
            margin: 0 0 16px;

            color: var(--text);

            font-size: 23px;
            font-weight: 800;
        }

        /* =========================================================
   Check List
   ========================================================= */

        .check-list {
            display: grid;

            gap: 13px;

            margin: 0;
            padding: 0;

            list-style: none;
        }

        .check-list li {
            display: flex;

            align-items: flex-start;

            gap: 10px;

            color: #50615d;
        }

        .check {
            display: grid;

            place-items: center;

            flex: 0 0 25px;

            width: 25px;
            height: 25px;

            background: #e9f5f1;

            border-radius: 8px;

            color: var(--primary);

            font-weight: 800;
        }

        /* =========================================================
   Tip
   ========================================================= */

        .tip {
            background: linear-gradient(135deg,
                    #f3f8f4,
                    #fff9ed) !important;

            border-color: #e8ece1;
        }

        .tip p {
            color: #5e6966;
        }

        /* =========================================================
   FAQ
   ========================================================= */

        .faq {
            display: grid;

            gap: 12px;

            max-width: 800px;

            margin: auto;
        }

        .faq details {
            padding: 17px 20px;

            background: #ffffff;

            border: 1px solid var(--line);
            border-radius: 16px;

            transition: 0.2s ease;
        }

        .faq details:hover {
            border-color: #d5e4dd;
        }

        .faq summary {
            cursor: pointer;

            color: var(--text);

            font-weight: 700;
        }

        .faq p {
            margin: 12px 0 0;

            color: var(--muted);

            font-size: 14px;
        }

        /* =========================================================
   CTA
   ========================================================= */

        .cta {
            padding: 0 0 85px;
        }

        .cta-box {
            padding: 55px 7%;

            background: linear-gradient(135deg,
                    #0e3521 0%,
                    #154e31 100%) !important;

            border-radius: 28px;

            color: #ffffff;

            text-align: center;
        }

        .cta-box h2 {
            margin: 0 0 8px;

            color: #ffffff;

            font-size: 36px;
            font-weight: 800;
        }

        .cta-box p {
            margin: 0 0 24px;

            color: #dcebe7;
        }

        .cta-box .btn-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;

            color: #1a1a1a !important;
        }

        .cta-box .btn-primary:hover {
            background: var(--accent-dark) !important;
            border-color: var(--accent-dark) !important;
        }

        /* =========================================================
   Footer
   ========================================================= */

        .kanaf-footer {
            background: #0e3521 !important;

            color: #ffffff !important;
        }

        .kanaf-footer p,
        .kanaf-footer h5,
        .kanaf-footer h6,
        .kanaf-footer li,
        .kanaf-footer a {
            color: #ffffff !important;
        }

        .kanaf-footer a {
            transition: 0.2s ease;
        }

        .kanaf-footer a:hover {
            color: #d39b1f !important;
        }

        .kanaf-footer hr {
            opacity: 0.2;
        }

        /* =========================================================
   Desktop Improvements
   ========================================================= */

        @media (min-width: 951px) {
            .hero-card {
                max-width: 520px;
                margin-right: auto;
            }
        }

        /* =========================================================
   Tablet
   ========================================================= */

        @media (max-width: 950px) {

            .hero {
                padding-bottom: 60px;
            }

            .hero-grid {
                grid-template-columns: 1fr;

                gap: 35px;

                padding-top: 45px;
            }

            .hero-card {
                max-width: 600px;

                margin: 0 auto;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* =========================================================
   Mobile
   ========================================================= */

        @media (max-width: 560px) {

            .container {
                width: 92%;
            }

            .hero {
                padding: 30px 0 50px;
            }

            .hero .nav {
                gap: 12px;
            }

            .hero .brand {
                font-size: 23px;
            }

            .hero .badge {
                padding: 6px 10px;

                font-size: 11px;
            }

            .hero-grid {
                padding-top: 35px;

                gap: 25px;
            }

            .hero h1 {
                margin-top: 18px;

                font-size: 35px;

                line-height: 1.35;
            }

            .hero p {
                font-size: 15px;
            }

            .actions {
                flex-direction: column;
            }

            .hero .btn {
                width: 100%;
            }

            .hero-card {
                padding: 20px;

                border-radius: 22px;

                min-height: auto;
            }

            .hero-card h3 {
                margin-bottom: 20px;

                font-size: 21px;
            }

            .hero .progress-item {
                padding: 9px;

                gap: 10px;
            }

            .hero .progress-item .num {
                width: 36px !important;
                min-width: 36px !important;
                height: 36px !important;
            }

            .hero .progress-item span {
                font-size: 12px;
            }

            .section {
                padding: 60px 0;
            }

            .section-head {
                margin-bottom: 30px;
            }

            .section-head h2 {
                font-size: 28px;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-card {
                padding: 22px;
            }

            .cta {
                padding-bottom: 60px;
            }

            .cta-box {
                padding: 40px 20px;

                border-radius: 22px;
            }

            .cta-box h2 {
                font-size: 29px;
            }
        }

        /* =========================================================
   Very Small Screens
   ========================================================= */

        @media (max-width: 380px) {

            .hero .nav {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero .badge {
                align-self: flex-start;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero-card {
                padding: 16px;
            }

            .hero-card h3 {
                font-size: 19px;
            }

            .hero .progress-item span {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
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
                            <a class="nav-link" href="{{ route('knaf') }}" id="nav-link-home">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orphans') }}" id="nav-link-orphans">قائمة الأيتام</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('step') }}" id="nav-link-steps">خطوات الكفالة</a>
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
    <header class="hero">
        <div class="container">
            <nav class="nav">
                <div class="brand">كنف</div>
                <div class="badge">رحلة كفالة واضحة وآمنة</div>
            </nav>
            <div class="hero-grid">
                <div>
                    <div class="eyebrow">معك خطوة بخطوة 🤍</div>
                    <h1>ابدأ رحلة الكفالة<br>بكل سهولة واطمئنان</h1>
                    <p>قبل البدء، تعرّف على جميع خطوات الكفالة وما تحتاج إليه، ثم انتقل إلى النموذج لإتمام طلبك بطريقة
                        بسيطة ومنظمة.</p>
                    <div class="actions"><a class="btn btn-primary" href="{{ route('register') }}">ابدأ الكفالة الآن ←</a><a
                            class="btn btn-outline" href="#how">تعرّف على الخطوات</a></div>
                </div>
                <aside class="hero-card">
                    <h3>رحلة الكفالة في 5 خطوات</h3>
                    <div class="progress">
                        <div class="progress-item">
                            <div class="num">1</div><span>اختيار الطفل المطلوب</span>
                        </div>
                        <div class="progress-item">
                            <div class="num">2</div><span>إدخال البيانات المطلوبة</span>
                        </div>
                        <div class="progress-item">
                            <div class="num">3</div><span>مراجعة التفاصيل</span>
                        </div>
                        <div class="progress-item">
                            <div class="num">4</div><span>إتمام الدفع بطريقة آمنة</span>
                        </div>
                        <div class="progress-item">
                            <div class="num">5</div><span>تأكيد الكفالة واستلام الإشعار</span>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </header>
    <main>
        <section class="section" id="how">
            <div class="container">
                <div class="section-head">
                    <h2>كيف تتم عملية الكفالة؟</h2>
                    <p>صممنا الرحلة لتكون واضحة من البداية حتى التأكيد النهائي.</p>
                </div>
                <div class="steps">
                    <div class="step"><span class="step-no">الخطوة 01</span>
                        <h3>اختر الطفل</h3>
                        <p>قم باختيار الطفل الذي تحبه .</p>
                    </div>
                    <div class="step"><span class="step-no">الخطوة 02</span>
                        <h3>أدخل بياناتك</h3>
                        <p>قم بتعبئة بياناتك ومعلومات التواصل المطلوبة.</p>
                    </div>
                    <div class="step"><span class="step-no">الخطوة 03</span>
                        <h3>راجع التفاصيل</h3>
                        <p>تأكد من صحة المعلومات قبل الانتقال للمرحلة التالية.</p>
                    </div>
                    <div class="step"><span class="step-no">الخطوة 04</span>
                        <h3>أكمل الدفع</h3>
                        <p>اختر طريقة الدفع المناسبة وأتمم العملية.</p>
                    </div>
                    <div class="step"><span class="step-no">الخطوة 05</span>
                        <h3>تأكيد الكفالة</h3>
                        <p>احصل على تأكيد طلبك وابدأ متابعة كفالتك.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section important">
            <div class="container">
                <div class="info-grid">
                    <div class="info-card">
                        <h3>ماذا تحتاج قبل البدء؟</h3>
                        <ul class="check-list">
                            <li><span class="check">✓</span><span>البيانات الشخصية الأساسية.</span></li>
                            <li><span class="check">✓</span><span>رقم هاتف ووسيلة تواصل فعالة.</span></li>
                            <li><span class="check">✓</span><span>اختيار نوع الكفالة المناسب لك.</span></li>
                            <li><span class="check">✓</span><span>وسيلة الدفع التي تفضّل استخدامها.</span></li>
                        </ul>
                    </div>
                    <div class="info-card tip">
                        <h3>معلومات مهمة</h3>
                        <ul class="check-list">
                            <li><span class="check">✓</span><span>تستغرق العملية بضع دقائق فقط.</span></li>
                            <li><span class="check">✓</span><span>يمكنك مراجعة بياناتك قبل التأكيد النهائي.</span>
                            </li>
                            <li><span class="check">✓</span><span>يتم التعامل مع بياناتك بسرية وأمان.</span></li>
                            <li><span class="check">✓</span><span>تظهر لك الخطوات بشكل متسلسل وواضح.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="section" id="faq">
            <div class="container">
                <div class="section-head">
                    <h2>أسئلة قد تساعدك قبل البدء</h2>
                    <p>كل ما تحتاج معرفته قبل الانتقال إلى نموذج الكفالة.</p>
                </div>
                <div class="faq">
                    <details open>
                        <summary>هل يمكنني تعديل بياناتي قبل التأكيد؟</summary>
                        <p>نعم، يمكنك مراجعة البيانات والتأكد منها قبل الانتقال إلى الإتمام النهائي حسب خطوات النموذج.
                        </p>
                    </details>
                    <details>
                        <summary>كم تستغرق عملية التسجيل؟</summary>
                        <p>تم تصميم العملية لتكون سريعة، ويمكنك إتمام الخطوات الأساسية خلال بضع دقائق عند تجهيز
                            المعلومات المطلوبة.</p>
                    </details>
                    <details>
                        <summary>ماذا يحدث بعد إتمام الكفالة؟</summary>
                        <p>بعد إتمام الخطوات، يتم تأكيد الطلب وفق إجراءات المنصة وستتمكن من متابعة تفاصيل الكفالة من
                            خلال النظام.</p>
                    </details>
                </div>
            </div>
        </section>
        <section class="cta">
            <div class="container">
                <div class="cta-box">
                    <h2>جاهز لبدء رحلة الكفالة؟</h2>
                    <p>اضغط على الزر للانتقال إلى الخطوة الأولى والبدء في تعبئة طلب الكفالة.</p><a
                        class="btn btn-primary" href="{{ route('register') }}">ابدأ الكفالة الآن ←</a>
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
                        <li><a href="{{ route('login') }}" class="text-white text-decoration-none">بوابة
                                الكافل
                                المشترك</a></li>
                        <li><a href="{{ route('login') }}" class="text-white text-decoration-none">بوابة الأوصياء
                                والأمهات</a>
                        </li>
                        <li><a href="{{ route('login') }}" class="text-white text-decoration-none">لوحة
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
