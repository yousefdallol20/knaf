<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل اليتيم والمراجعة الكاملة - كنف</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <style>
        :root {
            --primary-green: #198754;
            --primary-green-hover: #146c43;
            --secondary-green: #e8f5e9;
            --dark-color: #212529;
            --bg-body: #f8f9fa;
            --card-bg: #ffffff;
            --text-main: #2b303a;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            --radius: 12px;
            --badge-active-bg: #d1fae5;
            --badge-active-color: #065f46;
            --badge-pending-bg: #fff3cd;
            --badge-pending-color: #856404;
            --badge-danger-bg: #f8d7da;
            --badge-danger-color: #842029;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }

        .main-content {
            flex-grow: 1;
            min-height: 100vh;
            background-color: var(--bg-body);
        }

        .dashboard-container {
            padding: 30px 25px;
        }

        .main-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .main-layout {
                grid-template-columns: 1fr;
            }
        }

        .right-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .orphan-photo-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            padding: 25px;
            text-align: center;
        }

        .orphan-photo-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--secondary-green);
            margin-bottom: 15px;
        }

        .orphan-photo-card h2 {
            font-size: 1.3rem;
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .badge-kanaf {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .badge-kanaf-active {
            background-color: var(--badge-active-bg);
            color: var(--badge-active-color);
        }

        .badge-kanaf-pending {
            background-color: var(--badge-pending-bg);
            color: var(--badge-pending-color);
        }

        .badge-kanaf-danger {
            background-color: var(--badge-danger-bg);
            color: var(--badge-danger-color);
        }

        .actions-wrapper {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 10px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            width: 100%;
        }

        .btn-approve {
            background-color: var(--primary-green);
            color: white;
        }

        .btn-approve:hover {
            background-color: var(--primary-green-hover);
            transform: translateY(-1px);
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
        }

        .info-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-header {
            background-color: #fafbfd;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header i {
            font-size: 1.2rem;
            color: var(--primary-green);
        }

        .card-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0;
        }

        .card-body {
            padding: 20px;
        }

        .data-list {
            list-style: none;
            margin-bottom: 0;
            padding-right: 0;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .data-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .data-label {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .data-value {
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.9rem;
            text-align: left;
        }

        .left-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .left-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .left-grid {
                grid-template-columns: 1fr;
            }
        }

        .full-width-card {
            grid-column: 1 / -1;
        }

        .story-text {
            color: #495057;
            line-height: 1.8;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        .document-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .doc-item-box {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: #fafbfd;
            transition: all 0.2s ease-in-out;
        }

        .doc-item-box:hover {
            border-color: var(--primary-green);
            background-color: var(--secondary-green);
        }

        .doc-icon {
            font-size: 1.8rem;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        .doc-title {
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--dark-color);
        }

        .doc-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .btn-view-doc {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            font-size: 0.75rem;
            color: var(--primary-green);
            background-color: var(--secondary-green);
            border: 1px solid var(--primary-green);
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .btn-view-doc:hover {
            color: #fff;
            background-color: var(--primary-green-hover);
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(33, 37, 41, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 1050;
        }

        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .modal-card {
            background-color: var(--card-bg);
            border-radius: var(--radius);
            width: 480px;
            max-width: 90%;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(-20px);
            transition: all 0.2s ease-out;
            border: 1px solid var(--border-color);
        }

        .modal-overlay.open .modal-card {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .modal-header h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0;
        }

        .btn-close-modal {
            background: none;
            border: none;
            font-size: 1.4rem;
            cursor: pointer;
            color: var(--text-muted);
        }

        .btn-close-modal:hover {
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-main);
            text-align: right;
        }

        .form-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            outline: none;
            transition: border-color 0.15s ease-in-out;
            text-align: right;
        }

        .form-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        }

        .form-input-number {
            text-align: left;
        }

        .currency-label {
            position: absolute;
            right: 12px;
            font-weight: bold;
            font-size: 0.85rem;
            color: var(--text-muted);
            pointer-events: none;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
            margin-top: 15px;
        }

        .btn-modal-submit {
            padding: 8px 18px;
            border: none;
            background-color: var(--primary-green);
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-modal-submit:hover {
            background-color: var(--primary-green-hover);
        }

        .btn-modal-submit-danger {
            background-color: #dc3545;
        }

        .btn-modal-submit-danger:hover {
            background-color: #bb2d3b;
        }

        .btn-modal-cancel {
            padding: 8px 18px;
            border: 1px solid var(--border-color);
            background-color: transparent;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-modal-cancel:hover {
            background-color: #f8f9fa;
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
                <li class="menu-item active" id="menu-orphans">
                    <a href="{{ route('orphans_admin') }}"><i class="bi bi-people-fill"></i> إدارة الأيتام</a>
                </li>
                <li class="menu-item" id="menu-families">
                    <a href="{{ route('families_admin') }}"><i class="bi bi-house-fill"></i> إدارة العائلات والوصي</a>
                </li>
                <li class="menu-item" id="menu-sponsors">
                    <a href="{{ route('showSponsors') }}"><i class="bi bi-heart-fill"></i> إدارة الكافلين</a>
                </li>
                <li class="menu-item {{ Route::is('sponsorships_admin') ? 'active' : '' }}" id="menu-sponsorships">
                    <a href="{{ route('sponsorships_admin') }}"><i class="bi bi-arrow-repeat"></i> الكفالات النشطة</a>
                </li>
                <li class="menu-item" id="menu-payments">
                    <a href="{{ route('payments_admin') }}"><i class="bi bi-wallet2"></i> إدارة المدفوعات</a>
                </li>
                <li class="menu-item" id="menu-docs">
                    <a href="{{ route('documents_admin') }}"><i class="bi bi-file-earmark-lock-fill"></i> مراجعة
                        التوثيق</a>
                </li>
                <li class="menu-item" id="menu-users">
                    <a href="{{ route('admin.users.index') }}"><i class="bi bi-person-circle"></i> إدارة المستخدمين</a>
                </li>
                <li class="menu-item" id="menu-permissions">
                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-key-fill"></i> الصلاحيات
                        والأدوار</a>
                </li>
                <li class="menu-item" id="menu-reports">
                    <a href="{{ route('reports_admin') }}"><i class="bi bi-file-earmark-bar-graph-fill"></i> التقارير
                        والتحليلات</a>
                </li>
                <li class="menu-item" id="menu-notifications">
                    <a href="{{ route('admin.notifications.index') }}"><i class="bi bi-send-fill"></i> الإرسال الجماعي
                        والإشعار</a>
                </li>
                <li class="menu-item" id="menu-audit">
                    <a href="{{ route('audit_admin') }}"><i class="bi bi-journal-text"></i> سجل العمليات السري</a>
                </li>
                <li class="menu-item" id="menu-settings">
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

        <div class="main-content">
            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">مركز مراجعة واعتماد طلبات الأيتام</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-small fw-bold">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('admin.settings.index') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100"><i
                                        class="bi bi-box-arrow-right me-2"></i> خروج آمن</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="dashboard-container">
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orphans_admin') }}"
                                    class="text-primary-green text-decoration-none">إدارة الأيتام</a></li>
                            <li class="breadcrumb-item active" aria-current="page">مراجعة وتدقيق ملف اليتيم</li>
                        </ol>
                    </nav>
                </div>

                <div class="main-layout">
                    <!-- العمود الأيمن (اليتيم والقرار) -->
                    <div class="right-sidebar">
                        <div class="orphan-photo-card">
                            <img src="{{ asset('Uploads/orphans/' . $orphan->personal_photo_path) }}" alt=" "
                                onerror="this.onerror=null;this.src='{{ asset('Uploads/parents/default.png') }}';">
                            <h2>{{ $orphan->name }}</h2>
                            <div style="margin-bottom: 15px;">
                                @if (empty($orphan->status) || in_array($orphan->status, ['pending_approval', 'بانتظار الموافقة', 'جديد']))
                                    <span
                                        class="badge-kanaf badge-pending text-warning bg-warning-subtle py-1 px-2 rounded-2">
                                        بانتظار القبول
                                    </span>
                                @elseif (in_array($orphan->status, ['approved_unsponsored', 'approved', 'بانتظار كفيل', 'بانتظار الكفالة', 'غير مكفول']))
                                    <span
                                        class="badge-kanaf badge-pending text-primary bg-primary-subtle py-1 px-2 rounded-2">
                                        غير مكفول
                                    </span>
                                @elseif (in_array($orphan->status, ['sponsored', 'مكفول']))
                                    <span
                                        class="badge-kanaf badge-active text-success bg-success-subtle py-1 px-2 rounded-2">
                                        مكفول
                                    </span>
                                @elseif (in_array($orphan->status, ['rejected', 'مرفوض', 'mrfod']))
                                    <span class="badge-kanaf text-danger bg-danger-subtle py-1 px-2 rounded-2">
                                        مرفوض
                                    </span>
                                @else
                                    <span class="badge-kanaf text-secondary bg-secondary-subtle py-1 px-2 rounded-2">
                                        {{ $orphan->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="card-header">
                                <i class="bi bi-person-fill"></i>
                                <h3>معلومات اليتيم الشخصية</h3>
                            </div>
                            <div class="card-body">
                                <ul class="data-list">
                                    <li class="data-item">
                                        <span class="data-label">رقم الهوية</span>
                                        <span class="data-value">{{ $orphan->national_id }}</span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">تاريخ الميلاد</span>
                                        <span class="data-value">{{ $orphan->birth_date }}</span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">العمر</span>
                                        <span class="data-value">{{ $orphan->age }} سنة</span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">الجنس</span>
                                        <span class="data-value">{{ $orphan->gender }}</span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">المستوى التعليمي</span>
                                        <span class="data-value">{{ $orphan->education_level }}</span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">يتيم الأبوين</span>
                                        <span class="data-value">
                                            @if ($orphan->is_double_orphan)
                                                <span class="badge-kanaf badge-kanaf-active"><i
                                                        class="bi bi-check-circle"></i> نعم</span>
                                            @else
                                                <span class="badge-kanaf badge-kanaf-danger"><i
                                                        class="bi bi-x-circle"></i> لا</span>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="data-item">
                                        <span class="data-label">يعاني من مرض مزمن</span>
                                        <span class="data-value">
                                            @if ($orphan->has_chronic_disease)
                                                <span class="badge-kanaf badge-kanaf-active"><i
                                                        class="bi bi-check-circle"></i> نعم</span>
                                            @else
                                                <span class="badge-kanaf badge-kanaf-danger"><i
                                                        class="bi bi-x-circle"></i> لا</span>
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- تم إضافة شرط Blade لاختفاء الأزرار عند الموافقة أو الرفض -->
                        <!-- بعد التعديل -->
                        {{-- 2. أزرار اتخاذ القرار والتنبيه --}}
                        <div class="actions-wrapper">
                            @if (empty($orphan->status) ||
                                    in_array($orphan->status, ['pending_approval', 'بانتظار الموافقة', 'بانتظار القبول', 'جديد']))
                                {{-- حالة طلب جديد ينتظر الاعتماد --}}
                                <div class="alert alert-warning text-center mb-2 border-0 fw-bold py-2">
                                    <i class="bi bi-clock-history me-1"></i> الملف بانتظار المراجعة والقبول
                                </div>
                                <button class="btn-action btn-approve" id="btnApprove">
                                    <i class="bi bi-check-circle"></i> قبول واعتماد اليتيم
                                </button>
                                <button class="btn-action btn-reject" id="btnReject">
                                    <i class="bi bi-x-circle"></i> رفض الطلب الحالي
                                </button>
                            @elseif (in_array($orphan->status, ['rejected', 'مرفوض', 'mrfod']))
                                {{-- حالة الملف المرفوض --}}
                                <div class="alert alert-danger text-center mb-2 border-0 fw-bold py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i> تم رفض هذا الطلب
                                </div>
                                <button class="btn-action btn-approve" id="btnApprove">
                                    <i class="bi bi-arrow-counterclockwise"></i> إعادة قبول وإدراج اليتيم
                                </button>
                            @else
                                {{-- حالة الملف المقبول أو المكفول --}}
                                <div class="alert alert-success text-center mb-2 border-0 fw-bold py-2"
                                    style="background-color: var(--secondary-green); color: var(--primary-green); border-radius: 8px;">
                                    <i class="bi bi-check-circle-fill me-1"></i> تمت مراجعة الملف واعتتماده
                                </div>
                                <button class="btn-action btn-reject" id="btnReject">
                                    <i class="bi bi-x-circle"></i> تغيير الحالة إلى مرفوض
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- العمود الأيسر (تفاصيل العائلة والسكن والمالية) -->
                    <div class="left-content">
                        <div class="left-grid">
                            <!-- 1. المؤشرات الاجتماعية والحالة الصحية -->
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="bi bi-shield-exclamation"></i>
                                    <h3>المؤشرات الاجتماعية والحالة الصحية</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="data-list">
                                        <li class="data-item">
                                            <span class="data-label">ناجي وحيد للأسرة</span>
                                            <span class="data-value">
                                                @if ($orphan->is_sole_breadwinner)
                                                    <span class="badge-kanaf badge-kanaf-active"><i
                                                            class="bi bi-check-circle"></i> نعم</span>
                                                @else
                                                    <span class="badge-kanaf badge-kanaf-danger"><i
                                                            class="bi bi-x-circle"></i> لا</span>
                                                @endif
                                            </span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">حالة معيشية أشد حاجة</span>
                                            <span class="data-value">
                                                @if ($orphan->is_critically_needy)
                                                    <span class="badge-kanaf badge-kanaf-active"><i
                                                            class="bi bi-check-circle"></i> نعم</span>
                                                @else
                                                    <span class="badge-kanaf badge-kanaf-danger"><i
                                                            class="bi bi-x-circle"></i> لا</span>
                                                @endif
                                            </span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">الحالة الصحية العامة</span>
                                            <span class="data-value">{{ $orphan->health_status }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">وصف الحالة الصحية</span>
                                            <span
                                                class="data-value">{{ $orphan->health_description ?? 'سليم / لا يوجد وصف' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 2. بيانات الوالدين -->
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="bi bi-people"></i>
                                    <h3>بيانات الأب والأم</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="data-list">
                                        <li class="data-item">
                                            <span class="data-label">اسم الأب الراحل</span>
                                            <span
                                                class="data-value">{{ $orphan->parents->name ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">تاريخ وفاته</span>
                                            <span
                                                class="data-value">{{ $orphan->parents->death_date ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">الأم على قيد الحياة؟</span>
                                            <span class="data-value">
                                                @if ($orphan->parents && $orphan->parents->is_mother_alive)
                                                    <span class="badge-kanaf badge-kanaf-active"><i
                                                            class="bi bi-check-circle"></i> نعم</span>
                                                @else
                                                    <span class="badge-kanaf badge-kanaf-danger"><i
                                                            class="bi bi-x-circle"></i> متوفاة</span>
                                                @endif
                                            </span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">سبب وفاة الأم</span>
                                            <span
                                                class="data-value">{{ $orphan->parents->mother_death_reason ?? 'غير متوفر' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 3. بيانات الوصي الحالي -->
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="bi bi-shield-check"></i>
                                    <h3>بيانات الوصي الشرعي</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="data-list">
                                        <li class="data-item">
                                            <span class="data-label">اسم الوصي</span>
                                            <span
                                                class="data-value">{{ $orphan->guardian->name ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">رقم هوية الوصي</span>
                                            <span
                                                class="data-value">{{ $orphan->guardian->national_id ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">صلة القرابة</span>
                                            <span
                                                class="data-value">{{ $orphan->guardian->kinship_relation ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">الحالة الاجتماعية للوصي</span>
                                            <span
                                                class="data-value">{{ $orphan->guardian->marital_status ?? 'غير متوفر' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 4. تفاصيل السكن والنزوح الحالي -->
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="bi bi-house-door"></i>
                                    <h3>تفاصيل السكن والنزوح</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="data-list">
                                        <li class="data-item">
                                            <span class="data-label">نوع السكن الحالي</span>
                                            <span
                                                class="data-value">{{ $orphan->housing->current_housing_type ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">المدينة الأصلية</span>
                                            <span
                                                class="data-value">{{ $orphan->housing->original_city ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">وجهة النزوح الحالية</span>
                                            <span
                                                class="data-value">{{ $orphan->housing->current_displacement_destination ?? 'غير متوفر' }}</span>
                                        </li>
                                        <li class="data-item">
                                            <span class="data-label">العنوان التفصيلي</span>
                                            <span
                                                class="data-value">{{ $orphan->housing->detailed_current_address ?? 'غير متوفر' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 5. البيانات المالية -->
                            <div class="info-card full-width-card">
                                <div class="card-header">
                                    <i class="bi bi-wallet2"></i>
                                    <h3>البيانات المالية وطرق الاستلام</h3>
                                </div>
                                <div class="card-body">
                                    <div
                                        style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;">
                                        <div style="padding: 10px; border-bottom: 1px solid #f8f9fa;">
                                            <span class="data-label" style="display:block; margin-bottom:4px;">جهة
                                                الاستلام المالي</span>
                                            <strong
                                                class="data-value">{{ $orphan->financial_data->official_receiving_entity ?? 'غير متوفر' }}</strong>
                                        </div>
                                        <div style="padding: 10px; border-bottom: 1px solid #f8f9fa;">
                                            <span class="data-label" style="display:block; margin-bottom:4px;">اسم
                                                صاحب الحساب</span>
                                            <strong
                                                class="data-value">{{ $orphan->financial_data->account_holder_name ?? 'غير متوفر' }}</strong>
                                        </div>
                                        <div style="padding: 10px; border-bottom: 1px solid #f8f9fa;">
                                            <span class="data-label" style="display:block; margin-bottom:4px;">رقم
                                                الحساب / IBAN</span>
                                            <strong
                                                class="data-value">{{ $orphan->financial_data->bank_account_or_iban ?? 'غير متوفر' }}</strong>
                                        </div>
                                        <div style="padding: 10px; border-bottom: 1px solid #f8f9fa;">
                                            <span class="data-label" style="display:block; margin-bottom:4px;">مبلغ
                                                الكفالة المقترح</span>
                                            <strong class="data-value"
                                                style="color:var(--primary-green); font-size:1.1rem;">
                                                @if (empty($orphan->status) ||
                                                        in_array($orphan->status, ['pending_approval', 'بانتظار الموافقة', 'بانتظار القبول', 'جديد']) ||
                                                        !$orphan->required_amount)
                                                    <span class="text-muted fs-6">لسا لم يتم التحديد</span>
                                                @else
                                                    {{ number_format($orphan->required_amount, 2) . ' $' }}
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 6. قصة اليتيم -->
                            <div class="info-card full-width-card">
                                <div class="card-header">
                                    <i class="bi bi-book"></i>
                                    <h3>قصة اليتيم الحالية</h3>
                                </div>
                                <div class="card-body">
                                    <p class="story-text">{{ $orphan->story ?? 'لا توجد قصة مسجلة حالياً لليتيم.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- 7. المرفقات الرسمية والوثائق المرفوعة -->
                            <div class="info-card full-width-card">
                                <div class="card-header">
                                    <i class="bi bi-folder2-open"></i>
                                    <h3>المستندات والأوراق الرسمية المرفقة</h3>
                                </div>
                                <div class="card-body">
                                    <div class="document-grid">
                                        <!-- شهادة ميلاد اليتيم من جدول orphans -->
                                        @if ($orphan->birth_certificate_path)
                                            <div class="doc-item-box">
                                                <div class="doc-icon"><i class="bi bi-file-earmark-text-fill"></i>
                                                </div>
                                                <div class="doc-title">شهادة ميلاد الطفل</div>
                                                <div class="doc-meta">رسمي</div>
                                                <a target="_blank"
                                                    href="{{ asset('Uploads/certificates/' . $orphan->birth_certificate_path) }}"
                                                    class="btn-view-doc">
                                                    <i class="bi bi-eye"></i> استعراض
                                                </a>
                                            </div>
                                        @endif

                                        <!-- صك الوصاية الشرعية من جدول guardians -->
                                        @if ($orphan->guardian && $orphan->guardian->legal_guardianship_document)
                                            <div class="doc-item-box">
                                                <div class="doc-icon"><i class="bi bi-shield-lock-fill"></i></div>
                                                <div class="doc-title">صك الوصاية الشرعية</div>
                                                <div class="doc-meta">قانوني</div>
                                                <a target="_blank"
                                                    href="{{ asset('Uploads/guardians/' . $orphan->guardian->legal_guardianship_document) }}"
                                                    class="btn-view-doc">
                                                    <i class="bi bi-eye"></i> استعراض
                                                </a>
                                            </div>
                                        @endif

                                        <!-- التقارير الطبية والمستندات الإضافية من جدول documents -->
                                        @forelse($orphan->documents as $doc)
                                            <div class="doc-item-box">
                                                <div class="doc-icon">
                                                    @if (Str::endsWith($doc->file_path, '.pdf'))
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    @else
                                                        <i class="bi bi-file-earmark-image"></i>
                                                    @endif
                                                </div>
                                                <div class="doc-title">{{ $doc->title }}</div>
                                                <div class="doc-meta">تاريخ الرفع: {{ $doc->date }}</div>
                                                <a target="_blank" href="{{ asset($doc->file_path) }}"
                                                    class="btn-view-doc">
                                                    <i class="bi bi-eye"></i> استعراض
                                                </a>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center w-100">لا توجد وثائق إضافية مرفوعة لليتيم
                                                حالياً.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة منبثقة (Modal) للقبول -->
    <div class="modal-overlay" id="approveModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>اعتماد الطلب وتحديد الكفالة</h3>
                <button class="btn-close-modal" id="closeApproveModalBtn">&times;</button>
            </div>
            <form action="{{ route('orphans.approve', $orphan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="required_amount">تحديد سعر الكفالة الشهرية المقترحة
                            لليتيم</label>
                        <div class="form-input-wrapper">
                            <input type="number" step="0.01" name="required_amount" id="required_amount"
                                class="form-input form-input-number" value="{{ $orphan->required_amount ?? 50.0 }}"
                                min="10" required>
                            <span class="currency-label">دولار ($) / شهرياً</span>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 8px; text-align: right;">
                            * سيتم اعتماد هذا المبلغ ليكون ظاهراً للمتبرعين والجهات الكافلة في المنصة.
                        </p>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-modal-cancel" id="cancelApproveModalBtn">تراجع</button>
                        <button type="submit" class="btn-modal-submit">تأكيد الموافقة</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- نافذة منبثقة (Modal) للرفض -->
    <div class="modal-overlay" id="rejectModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3>سبب رفض الطلب الحالي</h3>
                <button class="btn-close-modal" id="closeRejectModalBtn">&times;</button>
            </div>
            <form action="{{ route('orphans.reject', $orphan->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="reject_reason">أكتب سبب الرفض بالتفصيل</label>
                        <textarea name="reject_reason" id="reject_reason" class="form-input" rows="4" style="resize: none;"
                            placeholder="مثال: يرجى رفع صك الوصاية محدث، أو الأوراق الطبية المرفقة غير واضحة..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reject_type">نوع الرفض</label>
                        <select name="reject_type" id="reject_type" class="form-input" style="font-weight: normal;">
                            <option value="temporary">رفض مؤقت (قابل للتعديل وإعادة التقديم)</option>
                            <option value="permanent">رفض نهائي (أرشفة الطلب بالكامل)</option>
                        </select>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-modal-cancel" id="cancelRejectModalBtn">تراجع</button>
                        <button type="submit" class="btn-modal-submit btn-modal-submit-danger">تأكيد الرفض</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        const btnApprove = document.getElementById('btnApprove');
        const approveModal = document.getElementById('approveModal');
        const closeApproveModalBtn = document.getElementById('closeApproveModalBtn');
        const cancelApproveModalBtn = document.getElementById('cancelApproveModalBtn');

        const btnReject = document.getElementById('btnReject');
        const rejectModal = document.getElementById('rejectModal');
        const closeRejectModalBtn = document.getElementById('closeRejectModalBtn');
        const cancelRejectModalBtn = document.getElementById('cancelRejectModalBtn');

        // أحداث مودال القبول (يتم فحص وجود العناصر لتجنب أخطاء JS عند اختفاء الأزرار)
        if (btnApprove) {
            btnApprove.addEventListener('click', () => {
                approveModal.classList.add('open');
            });
            const closeApproveModal = () => approveModal.classList.remove('open');
            closeApproveModalBtn.addEventListener('click', closeApproveModal);
            cancelApproveModalBtn.addEventListener('click', closeApproveModal);
        }

        // أحداث مودال الرفض
        if (btnReject) {
            btnReject.addEventListener('click', () => {
                rejectModal.classList.add('open');
            });
            const closeRejectModal = () => rejectModal.classList.remove('open');
            closeRejectModalBtn.addEventListener('click', closeRejectModal);
            cancelRejectModalBtn.addEventListener('click', closeRejectModal);
        }
    </script>
</body>

</html>
