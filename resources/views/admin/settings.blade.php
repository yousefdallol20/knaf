<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات - منظومة كنف</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <style>
        :root {
            --primary-green: #1a5c32;
            --primary-green-light: #e8f5ee;
            --primary-green-soft: #d1ead9;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        /* ── Layout ── */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 0;
            overflow-x: hidden;
        }

        /* ── Header ── */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.75rem;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .dashboard-container {
            padding: 1.75rem;
        }

        /* ── Settings tabs nav ── */
        .settings-nav {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .settings-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.85rem 1.25rem;
            color: #64748b;
            font-weight: 500;
            border-radius: 0;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s, color 0.15s;
        }

        .settings-nav .nav-link:last-child {
            border-bottom: none;
        }

        .settings-nav .nav-link.active {
            background: var(--primary-green-light);
            color: var(--primary-green);
            font-weight: 700;
            border-right: 4px solid var(--primary-green);
        }

        .settings-nav .nav-link:hover:not(.active) {
            background: #f8fafc;
            color: var(--primary-green);
        }

        .settings-nav .nav-link i {
            font-size: 1.1rem;
        }

        /* ── Settings panels ── */
        .settings-panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .settings-panel-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background: #fafafa;
        }

        .settings-panel-body {
            padding: 1.5rem;
        }

        /* ── Section dividers ── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.5rem 0 1rem;
            color: var(--primary-green);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── Form controls ── */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(26, 92, 50, 0.15);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .form-text {
            font-size: 0.78rem;
            color: #94a3b8;
        }

        /* ── Toggle switch ── */
        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* ── Contact info card ── */
        .contact-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: border-color 0.2s;
        }

        .contact-card:hover {
            border-color: var(--primary-green);
        }

        .contact-card .contact-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .contact-card .contact-meta {
            flex: 1;
            padding: 0 0.9rem;
        }

        .contact-card .contact-meta .label {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 1px;
        }

        .contact-card .contact-meta .value {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
        }

        /* ── Btn green ── */
        .btn-primary-green {
            background: var(--primary-green);
            color: #fff;
            border: none;
        }

        .btn-primary-green:hover {
            background: #0d381c;
            color: #fff;
        }

        /* ── Save bar ── */
        .save-bar {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e2e8f0;
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        /* ── Role badge ── */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        /* ── Tab pane animation ── */
        .tab-pane.active {
            animation: fadeUp 0.2s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Notification rows ── */
        .notif-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .notif-row:last-child {
            border-bottom: none;
        }

        .notif-row .notif-label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .notif-row .notif-desc {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 1px;
        }

        /* ── Danger zone ── */
        .danger-zone {
            border: 1.5px solid #fee2e2;
            border-radius: 12px;
            padding: 1.25rem;
            background: #fff5f5;
        }
    </style>
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
            <div class="brand">
                <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                <button type="button" class="btn-close btn-close-white d-lg-none ms-auto" aria-label="إغلاق القائمة"
                    onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
            </div>

            <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                <li class="menu-item" id="menu-dashboard">
                    <a href="{{ route('dashboard_admin') }}"><i class="bi bi-grid-1x2-fill"></i> لوحة التحكم الشاملة</a>
                </li>
                <li class="menu-item" id="menu-orphans">
                    <a href="{{ route('orphans_admin') }}"><i class="bi bi-people-fill"></i> إدارة الأيتام</a>
                </li>
                <li class="menu-item" id="menu-families">
                    <a href="{{ route('families_admin') }}"><i class="bi bi-house-fill"></i> إدارة العائلات والوصي</a>
                </li>
                <li class="menu-item" id="menu-sponsors">
                    <a href="{{ route('showSponsors') }}"><i class="bi bi-heart-fill"></i> إدارة الكافلين</a>
                </li>
                <li class="menu-item" id="menu-sponsorships">
                    <a href="{{ route('sponsorships_admin') }}"><i class="bi bi-arrow-repeat"></i> الكفالات النشطة</a>
                </li>
                <li class="menu-item" id="menu-payments">
                    <a href="{{ route('payments_admin') }}"><i class="bi bi-wallet2"></i> إدارة المدفوعات</a>
                </li>
                <li class="menu-item" id="menu-docs">
                    <a href="{{ route('documents_admin') }}"><i class="bi bi-file-earmark-lock-fill"></i> مراجعة التوثيق</a>
                </li>
                <li class="menu-item" id="menu-users">
                    <a href="{{ route('admin.users.index') }}"><i class="bi bi-person-circle"></i> إدارة المستخدمين</a>
                </li>
                <li class="menu-item" id="menu-permissions">
                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-key-fill"></i> الصلاحيات والأدوار</a>
                </li>
                <li class="menu-item" id="menu-reports">
                    <a href="{{ route('reports_admin') }}"><i class="bi bi-file-earmark-bar-graph-fill"></i> التقارير والتحليلات</a>
                </li>
                <li class="menu-item" id="menu-notifications">
                    <a href="{{ route('admin.notifications.index') }}"><i class="bi bi-send-fill"></i> الإرسال الجماعي والإشعار</a>
                </li>
                <li class="menu-item" id="menu-audit">
                    <a href="{{ route('audit_admin') }}"><i class="bi bi-journal-text"></i> سجل العمليات السري</a>
                </li>
                <li class="menu-item active" id="menu-settings">
                    <a href="{{ route('admin.settings.index') }}"><i class="bi bi-gear-fill"></i> الإعدادات</a>
                </li>
            </ul>

            <div class="p-3 border-top mt-auto">
                <a href="{{ route('dashboard_admin') }}"
                    class="btn btn-outline-primary w-full d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-arrow-right-short fs-5"></i>
                    <span>العودة للرئيسية</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">إعدادات وضبط المنظومة العامة</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/admin.jpg') }}" alt="رمز" class="rounded-circle" width="30"
                                height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ Auth::user()->name ?? 'أ. عبد الرحمن البكري' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="#"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100"><i class="bi bi-box-arrow-right me-2"></i> خروج آمن</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="dashboard-container">

                <!-- رسائل النجاح أو الأخطاء التلقائية -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-right text-small mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Hero Banner -->
                <div class="p-4 rounded-4 shadow-sm mb-4 text-white"
                    style="background: linear-gradient(135deg, var(--primary-green) 0%, #0d381c 100%);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:52px;height:52px;background:rgba(255,255,255,0.15);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">إعدادات وضبط المنظومة</h4>
                            <p class="mb-0 text-white-50 small">تحكم كامل في بيانات المنظمة، وسائل التواصل، الإشعارات، الصلاحيات، والأمان</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">

                    <!-- Nav Tabs -->
                    <div class="col-lg-3">
                        <div class="settings-nav">
                            <div class="nav flex-column" id="settingsTab" role="tablist">
                                <button class="nav-link active" id="tab-org" data-bs-toggle="tab" data-bs-target="#panel-org" type="button">
                                    <i class="bi bi-building"></i> بيانات المنظمة
                                </button>
                                <button class="nav-link" id="tab-contact" data-bs-toggle="tab" data-bs-target="#panel-contact" type="button">
                                    <i class="bi bi-telephone-fill"></i> وسائل التواصل
                                </button>
                                <button class="nav-link" id="tab-notif" data-bs-toggle="tab" data-bs-target="#panel-notif" type="button">
                                    <i class="bi bi-bell-fill"></i> الإشعارات والتنبيهات
                                </button>
                                <button class="nav-link" id="tab-users" data-bs-toggle="tab" data-bs-target="#panel-users" type="button">
                                    <i class="bi bi-people-fill"></i> المستخدمون والصلاحيات
                                </button>
                                <button class="nav-link" id="tab-payments" data-bs-toggle="tab" data-bs-target="#panel-payments" type="button">
                                    <i class="bi bi-cash-coin"></i> إعدادات الدفع
                                </button>
                                <button class="nav-link" id="tab-security" data-bs-toggle="tab" data-bs-target="#panel-security" type="button">
                                    <i class="bi bi-shield-lock-fill"></i> الأمان والنسخ الاحتياطي
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Panels Content -->
                    <div class="col-lg-9">
                        <div class="tab-content">

                            <!-- ════ 1. بيانات المنظمة ════ -->
                            <div class="tab-pane fade show active" id="panel-org">
                                <div class="settings-panel">
                                    <div class="settings-panel-header">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-building me-2 text-primary-green"></i>بيانات المنظمة الرسمية</h5>
                                        <p class="text-muted small mb-0 mt-1">المعلومات الأساسية التي تظهر على الوثائق والتقارير الرسمية</p>
                                    </div>

                                    <!-- نموذج رفع الشعار المنفصل -->
                                    <div class="settings-panel-body border-bottom">
                                        <form action="{{ route('admin.settings.uploadLogo') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="d-flex align-items-center gap-4 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                                <div style="width:72px;height:72px;background:var(--primary-green);border-radius:16px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                                                    @if(isset($settings['org_logo']))
                                                        <img src="{{ asset('storage/' . $settings['org_logo']) }}" alt="الشعار" style="width:100%;height:100%;object-fit:cover;">
                                                    @else
                                                        <i class="bi bi-tree-fill text-white fs-2"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold mb-1">شعار المنظمة الحالي</div>
                                                    <div class="text-muted small mb-2">PNG أو JPG بحجم أقصى 2 ميغابايت</div>
                                                    <div class="d-flex gap-2">
                                                        <input type="file" name="org_logo" id="org_logo_input" class="form-control form-control-sm d-none" onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="document.getElementById('org_logo_input').click()"><i class="bi bi-upload me-1"></i>رفع شعار جديد</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        <div class="settings-panel-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">اسم المنظمة (عربي)</label>
                                                    <input type="text" name="org_name_ar" class="form-control" value="{{ $settings['org_name_ar'] ?? 'منظومة كنف للكفالة' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">اسم المنظمة (إنجليزي)</label>
                                                    <input type="text" name="org_name_en" class="form-control" value="{{ $settings['org_name_en'] ?? 'Kanaf Orphan Care' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">رقم الترخيص / السجل الرسمي</label>
                                                    <input type="text" name="org_license" class="form-control" value="{{ $settings['org_license'] ?? 'NGO-2019-00148' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">البريد الإلكتروني الرسمي</label>
                                                    <input type="email" name="org_email" class="form-control" value="{{ $settings['org_email'] ?? 'info@kanaf.org' }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">العنوان الكامل</label>
                                                    <input type="text" name="org_address" class="form-control" value="{{ $settings['org_address'] ?? 'نابلس، فلسطين - شارع المدينة، مبنى الخدمات الاجتماعية' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">الدولة / الإقليم</label>
                                                    <select name="org_country" class="form-select">
                                                        <option value="فلسطين" {{ ($settings['org_country'] ?? '') == 'فلسطين' ? 'selected' : '' }}>فلسطين</option>
                                                        <option value="الأردن" {{ ($settings['org_country'] ?? '') == 'الأردن' ? 'selected' : '' }}>الأردن</option>
                                                        <option value="لبنان" {{ ($settings['org_country'] ?? '') == 'لبنان' ? 'selected' : '' }}>لبنان</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">المدينة</label>
                                                    <input type="text" name="org_city" class="form-control" value="{{ $settings['org_city'] ?? 'نابلس' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">الرمز البريدي</label>
                                                    <input type="text" name="org_zipcode" class="form-control" value="{{ $settings['org_zipcode'] ?? '44000' }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">نبذة عن المنظمة (تظهر في التقارير)</label>
                                                    <textarea name="org_about" class="form-control" rows="3">{{ $settings['org_about'] ?? 'منظومة كنف هي مبادرة إنسانية تُعنى برعاية الأطفال الأيتام وتأمين كفالتهم من خلال منظومة شاملة تربط بين الكافلين والأسر بإشراف متخصص.' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save-bar">
                                            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>المزامنة نشطة التخزين</span>
                                            <button type="submit" class="btn btn-primary-green px-4">
                                                <i class="bi bi-floppy-fill me-2"></i>حفظ بيانات المنظمة
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ════ 2. وسائل التواصل ════ -->
                            <div class="tab-pane fade" id="panel-contact">
                                <div class="settings-panel">
                                    <div class="settings-panel-header">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-telephone-fill me-2" style="color:var(--primary-green)"></i>وسائل التواصل والاتصال</h5>
                                        <p class="text-muted small mb-0 mt-1">قنوات التواصل الرسمية الظاهرة للكافلين والجهات الخارجية</p>
                                    </div>
                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        <div class="settings-panel-body">
                                            <!-- الهواتف -->
                                            <div class="section-divider"><i class="bi bi-phone-fill"></i> أرقام الهاتف</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">الهاتف الرئيسي</label>
                                                    <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+970 9 234 5678' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">هاتف الطوارئ / المنسق</label>
                                                    <input type="text" name="contact_emergency" class="form-control" value="{{ $settings['contact_emergency'] ?? '+970 59 876 5432' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">رقم الفاكس</label>
                                                    <input type="text" name="contact_fax" class="form-control" value="{{ $settings['contact_fax'] ?? '+970 9 234 5679' }}">
                                                </div>
                                            </div>

                                            <!-- البريد الإلكتروني -->
                                            <div class="section-divider"><i class="bi bi-envelope-fill"></i> البريد الإلكتروني</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">البريد العام</label>
                                                    <input type="email" name="email_general" class="form-control" value="{{ $settings['email_general'] ?? 'info@kanaf.org' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">بريد الدعم والشكاوى</label>
                                                    <input type="email" name="email_support" class="form-control" value="{{ $settings['email_support'] ?? 'support@kanaf.org' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">بريد المحاسبة والمالية</label>
                                                    <input type="email" name="email_finance" class="form-control" value="{{ $settings['email_finance'] ?? 'finance@kanaf.org' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">بريد التنسيق مع المانحين</label>
                                                    <input type="email" name="email_donors" class="form-control" value="{{ $settings['email_donors'] ?? 'donors@kanaf.org' }}">
                                                </div>
                                            </div>

                                            <!-- منصات التواصل الاجتماعي -->
                                            <div class="section-divider"><i class="bi bi-share-fill"></i> منصات التواصل الاجتماعي</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-facebook text-primary me-1"></i>فيسبوك</label>
                                                    <input type="text" name="social_facebook" class="form-control" value="{{ $settings['social_facebook'] ?? 'kanaf.org.ps' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-instagram text-danger me-1"></i>إنستغرام</label>
                                                    <input type="text" name="social_instagram" class="form-control" value="{{ $settings['social_instagram'] ?? 'kanaf_care' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-twitter-x me-1"></i>تويتر / X</label>
                                                    <input type="text" name="social_x" class="form-control" value="{{ $settings['social_x'] ?? 'kanaf_ps' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-youtube text-danger me-1"></i>يوتيوب</label>
                                                    <input type="text" name="social_youtube" class="form-control" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="اختياري">
                                                </div>
                                            </div>

                                            <!-- واتساب وتيليغرام -->
                                            <div class="section-divider"><i class="bi bi-chat-dots-fill"></i> قنوات المراسلة الفورية</div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-whatsapp text-success me-1"></i>واتساب (خط التواصل)</label>
                                                    <input type="text" name="social_whatsapp" class="form-control" value="{{ $settings['social_whatsapp'] ?? '970591234567' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label"><i class="bi bi-telegram text-info me-1"></i>تيليغرام</label>
                                                    <input type="text" name="social_telegram" class="form-control" value="{{ $settings['social_telegram'] ?? 'kanaf_news' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save-bar">
                                            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>حفظ فوري لقنوات الربط</span>
                                            <button type="submit" class="btn btn-primary-green px-4">
                                                <i class="bi bi-floppy-fill me-2"></i>حفظ جهات الاتصال
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ════ 3. الإشعارات ════ -->
                            <div class="tab-pane fade" id="panel-notif">
                                <div class="settings-panel">
                                    <div class="settings-panel-header">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bell-fill me-2" style="color:var(--primary-green)"></i>الإشعارات والتنبيهات</h5>
                                        <p class="text-muted small mb-0 mt-1">تحكم في متى وكيف يتلقى المسؤولون والكافلون الإشعارات</p>
                                    </div>
                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        <div class="settings-panel-body">
                                            <div class="section-divider"><i class="bi bi-person-lines-fill"></i> إشعارات المسؤولين</div>

                                            <!-- إشعارات مخفية يتم إرسالها كـ 0 عند إلغاء تفعيل السويتش -->
                                            <input type="hidden" name="notify_new_sponsor" value="0">
                                            <div class="notif-row">
                                                <div>
                                                    <div class="notif-label">تسجيل كافل جديد</div>
                                                    <div class="notif-desc">إشعار فوري عند تسجيل كافل جديد في المنظومة</div>
                                                </div>
                                                <div class="form-check form-switch ms-3">
                                                    <input class="form-check-input" type="checkbox" name="notify_new_sponsor" value="1" {{ ($settings['notify_new_sponsor'] ?? '1') == '1' ? 'checked' : '' }} style="width:2.5em;height:1.3em;">
                                                </div>
                                            </div>

                                            <input type="hidden" name="notify_doc_auth" value="0">
                                            <div class="notif-row">
                                                <div>
                                                    <div class="notif-label">وثيقة بانتظار المصادقة</div>
                                                    <div class="notif-desc">تنبيه عند رفع وثيقة جديدة تحتاج مراجعة ومصادقة</div>
                                                </div>
                                                <div class="form-check form-switch ms-3">
                                                    <input class="form-check-input" type="checkbox" name="notify_doc_auth" value="1" {{ ($settings['notify_doc_auth'] ?? '1') == '1' ? 'checked' : '' }} style="width:2.5em;height:1.3em;">
                                                </div>
                                            </div>

                                            <input type="hidden" name="notify_payment_received" value="0">
                                            <div class="notif-row">
                                                <div>
                                                    <div class="notif-label">دفعة مالية مستلمة</div>
                                                    <div class="notif-desc">إشعار عند تأكيد استلام حوالة مالية جديدة</div>
                                                </div>
                                                <div class="form-check form-switch ms-3">
                                                    <input class="form-check-input" type="checkbox" name="notify_payment_received" value="1" {{ ($settings['notify_payment_received'] ?? '1') == '1' ? 'checked' : '' }} style="width:2.5em;height:1.3em;">
                                                </div>
                                            </div>

                                            <input type="hidden" name="notify_sponsorship_end" value="0">
                                            <div class="notif-row">
                                                <div>
                                                    <div class="notif-label">كفالة على وشك الانتهاء</div>
                                                    <div class="notif-desc">تذكير قبل 30 يوماً من انتهاء مدة أي كفالة</div>
                                                </div>
                                                <div class="form-check form-switch ms-3">
                                                    <input class="form-check-input" type="checkbox" name="notify_sponsorship_end" value="1" {{ ($settings['notify_sponsorship_end'] ?? '1') == '1' ? 'checked' : '' }} style="width:2.5em;height:1.3em;">
                                                </div>
                                            </div>

                                            <div class="section-divider"><i class="bi bi-send-fill"></i> قناة وتوقيت الإرسال</div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">قناة الإرسال الافتراضية</label>
                                                    <select name="notification_channel" class="form-select">
                                                        <option value="all" {{ ($settings['notification_channel'] ?? '') == 'all' ? 'selected' : '' }}>البريد الإلكتروني + واتساب</option>
                                                        <option value="email" {{ ($settings['notification_channel'] ?? '') == 'email' ? 'selected' : '' }}>البريد الإلكتروني فقط</option>
                                                        <option value="whatsapp" {{ ($settings['notification_channel'] ?? '') == 'whatsapp' ? 'selected' : '' }}>واتساب فقط</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">توقيت إرسال الإشعارات اليومية</label>
                                                    <input type="time" name="notification_time" class="form-control" value="{{ $settings['notification_time'] ?? '09:00' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save-bar">
                                            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>تعديل خريطة التنبيهات</span>
                                            <button type="submit" class="btn btn-primary-green px-4">
                                                <i class="bi bi-floppy-fill me-2"></i>حفظ قنوات التنبيه
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ════ 4. المستخدمون والصلاحيات ════ -->
                            <div class="tab-pane fade" id="panel-users">
                                <div class="settings-panel">
                                    <div class="settings-panel-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill me-2"></i>إدارة المستخدمين والصلاحيات الحالية</h5>
                                            <p class="text-muted small mb-0 mt-1">عرض أدوار فريق العمل ومستويات الوصول المسجلة حالياً</p>
                                        </div>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary-green btn-sm"><i class="bi bi-person-plus-fill me-1"></i>التحكم بالمستخدمين</a>
                                    </div>
                                    <div class="settings-panel-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead style="background:#f8fafc;font-size:.82rem;color:#64748b;">
                                                    <tr>
                                                        <th>المستخدم</th>
                                                        <th>الدور البرمجي</th>
                                                        <th>آخر دخول للأداة</th>
                                                        <th>الحالة</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="users-tbody">
                                                    @forelse($users as $user)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div style="width:36px;height:36px;background:var(--primary-green);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;">
                                                                        {{ mb_substr($user->name, 0, 2) }}
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-semibold">{{ $user->name }}</div>
                                                                        <div class="text-muted" style="font-size:.75rem;">{{ $user->email }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @if($user->role == 'admin')
                                                                    <span class="role-badge" style="background:#fee2e2;color:#991b1b;"><i class="bi bi-shield-fill-check"></i>إداري عام</span>
                                                                @elseif($user->role == 'financial')
                                                                    <span class="role-badge" style="background:#ede9fe;color:#6d28d9;"><i class="bi bi-cash-stack"></i>مسؤول المالية</span>
                                                                @else
                                                                    <span class="role-badge" style="background:#f1f5f9;color:#64748b;"><i class="bi bi-eye-fill"></i>مراقب للنظام</span>
                                                                @endif
                                                            </td>
                                                            <td><span class="text-muted small">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'لم يسجل دخول' }}</span></td>
                                                            <td>
                                                                <span class="badge {{ $user->status == 'active' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }} border">
                                                                    {{ $user->status == 'active' ? 'نشط' : 'معلق' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center text-muted py-3">لا يوجد مستخدمين مسجلين حالياً.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ════ 5. إعدادات الدفع ════ -->
                            <div class="tab-pane fade" id="panel-payments">
                                <div class="settings-panel">
                                    <div class="settings-panel-header">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-cash-coin me-2"></i>إعدادات الدفع والكفالات المالية</h5>
                                        <p class="text-muted small mb-0 mt-1">تحكم في قيم الكفالات وطرق الدفع والعملات المعتمدة</p>
                                    </div>
                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        <div class="settings-panel-body">
                                            <div class="section-divider"><i class="bi bi-currency-dollar"></i> قيم الكفالات الشهرية</div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">كفالة أساسية (شهري)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">$</span>
                                                        <input type="number" name="pay_base_amount" class="form-control" value="{{ $settings['pay_base_amount'] ?? '30' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">كفالة شاملة (تعليم + صحة)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">$</span>
                                                        <input type="number" name="pay_full_amount" class="form-control" value="{{ $settings['pay_full_amount'] ?? '50' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">كفالة متميزة (كاملة)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">$</span>
                                                        <input type="number" name="pay_premium_amount" class="form-control" value="{{ $settings['pay_premium_amount'] ?? '75' }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section-divider"><i class="bi bi-calendar-check-fill"></i> دورة الاستحقاق والعملة</div>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">يوم استحقاق الدفعة (من الشهر)</label>
                                                    <input type="number" name="pay_due_day" class="form-control" min="1" max="28" value="{{ $settings['pay_due_day'] ?? '1' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">العملة الافتراضية</label>
                                                    <select name="pay_currency" class="form-select">
                                                        <option value="USD" {{ ($settings['pay_currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD — دولار أمريكي</option>
                                                        <option value="EUR" {{ ($settings['pay_currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR — يورو</option>
                                                        <option value="SAR" {{ ($settings['pay_currency'] ?? '') == 'SAR' ? 'selected' : '' }}>SAR — ريال سعودي</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">مهلة السماح لتأخر الدفع</label>
                                                    <div class="input-group">
                                                        <input type="number" name="pay_grace_period" class="form-control" value="{{ $settings['pay_grace_period'] ?? '7' }}">
                                                        <span class="input-group-text bg-light">أيام</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save-bar">
                                            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>تحديث أسعار الصرف والكفالة</span>
                                            <button type="submit" class="btn btn-primary-green px-4">
                                                <i class="bi bi-floppy-fill me-2"></i>حفظ تفاصيل الدفع
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- ════ 6. الأمان والنسخ الاحتياطي ════ -->
                            <div class="tab-pane fade" id="panel-security">
                                <div class="settings-panel">
                                    <div class="settings-panel-header">
                                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-shield-lock-fill me-2"></i>الأمان والنسخ الاحتياطي</h5>
                                        <p class="text-muted small mb-0 mt-1">إعدادات حماية البيانات والنسخ الاحتياطي الدوري للنظام</p>
                                    </div>
                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        <div class="settings-panel-body">
                                            <div class="section-divider"><i class="bi bi-lock-fill"></i> معايير الأمان وجلسات العمل</div>
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label">الحد الأدنى لطول كلمة المرور</label>
                                                    <input type="number" name="security_password_len" class="form-control" value="{{ $settings['security_password_len'] ?? '8' }}" min="6" max="32">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">صلاحية الجلسة (تسجيل الدخول)</label>
                                                    <select name="security_session_timeout" class="form-select">
                                                        <option value="1" {{ ($settings['security_session_timeout'] ?? '') == '1' ? 'selected' : '' }}>ساعة واحدة</option>
                                                        <option value="8" {{ ($settings['security_session_timeout'] ?? '8') == '8' ? 'selected' : '' }}>٨ ساعات</option>
                                                        <option value="24" {{ ($settings['security_session_timeout'] ?? '') == '24' ? 'selected' : '' }}>٢٤ ساعة</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="section-divider"><i class="bi bi-cloud-arrow-up-fill"></i> النسخ الاحتياطي التلقائي</div>
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label">تكرار النسخ الاحتياطي التلقائي</label>
                                                    <select name="backup_frequency" class="form-select">
                                                        <option value="daily" {{ ($settings['backup_frequency'] ?? '') == 'daily' ? 'selected' : '' }}>يومي</option>
                                                        <option value="3days" {{ ($settings['backup_frequency'] ?? '3days') == '3days' ? 'selected' : '' }}>كل ٣ أيام</option>
                                                        <option value="weekly" {{ ($settings['backup_frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">مدة الاحتفاظ بالنسخ</label>
                                                    <select name="backup_retention" class="form-select">
                                                        <option value="1month" {{ ($settings['backup_retention'] ?? '1month') == '1month' ? 'selected' : '' }}>شهر واحد</option>
                                                        <option value="3months" {{ ($settings['backup_retention'] ?? '') == '3months' ? 'selected' : '' }}>٣ أشهر</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Danger Zone -->
                                            <div class="danger-zone">
                                                <div class="fw-bold text-danger mb-2"><i class="bi bi-exclamation-triangle-fill me-1"></i>منطقة الخطر الأساسية</div>
                                                <p class="text-muted small mb-3">الإجراءات التالية لا يمكن التراجع عنها وتؤثر بشكل فوري على تخزين النظام.</p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash2 me-1"></i>مسح سجلات التدقيق القديمة</button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i>إعادة ضبط وضع المصنع</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="save-bar">
                                            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i>حماية التشفير والنسخ مفعلة</span>
                                            <button type="submit" class="btn btn-primary-green px-4">
                                                <i class="bi bi-floppy-fill me-2"></i>حفظ إعدادات الأمان
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div><!-- end tab-content -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
