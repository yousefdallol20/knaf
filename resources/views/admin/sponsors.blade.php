<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - إدارة الكفلاء</title>
    <!-- استبدال مسارات الأصول بـ asset() لضمان عملها بشكل صحيح في Laravel -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
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
                <li class="menu-item active" id="menu-sponsors">
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

            <!-- العودة للموقع الرئيسي -->
            <div class="p-3 border-top mt-auto">
                <a href="{{ url('/') }}"
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
                    <h4 class="fw-bold mb-0 text-dark">إدارة الكفلاء والمتبرعين</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- عرض اسم المستخدم المسؤول المسجل حالياً -->
                            <img src="{{ asset('assets/images/admin.jpg') }}" alt="رمز" class="rounded-circle"
                                width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ Auth::user()->name ?? 'المدير العام' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="#"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100"><i
                                            class="bi bi-box-arrow-right me-2"></i> خروج آمن</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="dashboard-container">

                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">إدارة الكفلاء</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-person-heart text-primary-green me-1"></i> لائحة
                                    المحسنين المسجلين في كنف</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addSponsorModal">
                                    <i class="bi bi-plus-circle me-1"></i> إدراج كفيل / متبرع جديد بالمنظومة
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>رقم الملف المالي</th>
                                            <th>الكفيل المسجل</th>
                                            <th>البريد الإلكتروني المخدم</th>
                                            <th>العنوان وجوال الكفيل</th>
                                            <th>الكفالات النشطة</th>
                                            <th>حالة الحساب المالي</th>
                                            <th class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="admin-sponsors-tbody">

                                        @forelse ($sponsors as $sponsor)
                                            <tr data-sponsor-id="{{ $sponsor->id }}"
                                                data-status="{{ $sponsor->status }}">
                                                <!-- صياغة رقم الملف المالي بناءً على الـ ID -->
                                                <td class="font-monospace">SPON-{{ 200 + $sponsor->id }}</td>
                                                <td>
                                                    <strong
                                                        class="text-dark d-block text-small sponsor-name">{{ $sponsor->name }}</strong>
                                                    <span class="text-caption text-muted">الكائن: فرد محسن</span>
                                                </td>
                                                <td class="font-monospace text-muted sponsor-email">
                                                    {{ $sponsor->email }}</td>
                                                <td>
                                                    <span
                                                        class="d-block text-small text-dark font-monospace sponsor-phone">{{ $sponsor->phone }}</span>
                                                    <span
                                                        class="text-caption text-muted sponsor-city">{{ $sponsor->city ?? $sponsor->country }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-success border border-success text-small px-3 py-1 fw-bold">
                                                        {{ $sponsor->sponsorships_count }} كفالات نشطة
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($sponsor->status == 'active')
                                                        <span class="badge-kanaf badge-active">متعاون أصيل</span>
                                                    @else
                                                        <span class="badge-kanaf badge-stopped">قيد تجميد
                                                            الاشتراك</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button class="btn btn-outline-primary btn-sm"><i
                                                                class="bi bi-pencil"></i> تعديل</button>
                                                        <button class="btn btn-outline-warning btn-sm"><i
                                                                class="bi bi-slash-circle"></i> تعليق</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">لا يوجد كفلاء
                                                    مسجلين حالياً بالمنظومة.</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
