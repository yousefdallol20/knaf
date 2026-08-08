<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - التقارير الإحصائية</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
            <div class="brand">
                <!-- <img src="assets/images/logo.png" alt="كنف" height="35"> -->
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
                <li class="menu-item active" id="menu-reports">
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

            <!-- Back to main public site link -->
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
                    <h4 class="fw-bold mb-0 text-dark">مركز إصدار وتوليد التقارير الحيوية والمالية</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/admin.jpg') }}" alt=" " class="rounded-circle"
                                width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ Auth::user()->name ?? 'أ. عبد الرحمن البكري' }}</span>
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
                            <li class="breadcrumb-item active" aria-current="page">مركز التقارير</li>
                        </ol>
                    </nav>
                </div>

                <!-- عرض تنبيهات نجاح التوليد أو التنزيل -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-right text-small mb-4"
                        role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-lg-8">
                        <!-- الـ Form المسؤول عن جمع بيانات وخيارات التوليد وإرسالها برمجياً عند الضغط على الزر الرئيسي -->
                        <form action="{{ route('reports_generate') }}" method="POST"
                            class="bg-white p-4 p-md-5 rounded-4 border shadow-sm h-100 flex-grow-1 d-flex flex-column justify-content-between">
                            @csrf
                            <div>
                                <h5 class="fw-bold text-dark mb-3"><i
                                        class="bi bi-file-earmark-text-fill text-primary-green"></i> توليد
                                    تقارير أداء ذكية فوراً</h5>
                                <p class="text-muted text-small mb-4 lh-base">حدد نوع التقارير الذي ترغب في استخلاصه من
                                    مخازن البيانات،
                                    لتجهيز کتب وتقارير إدارية سنوية أو تقديم الكشوفات الضريبية للجهات الرقابية الحكومية
                                    بالمملكة.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">نوع ومسار
                                            التقرير</label>
                                        <select id="rep-type-select" name="report_type" class="form-select bg-light">
                                            <option value="كشف الواردات والصافي المالي المركزي">كشف الواردات والصافي
                                                المالي المركزي</option>
                                            <option value="التقرير الصحي والتعليمي والنمو الاجتماعي">التقرير الصحي
                                                والتعليمي والنمو الاجتماعي</option>
                                            <option value="إحصائيات المرتدات والتزام الكفلاء الشهري">إحصائيات المرتدات
                                                والتزام الكفلاء الشهري</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">نطاق وفترات
                                            التقرير</label>
                                        <select id="rep-period-select" name="report_period"
                                            class="form-select bg-light">
                                            <option value="الستة أشهر المنصرمة (يناير - يونيو)">الستة أشهر المنصرمة
                                                (يناير - يونيو)</option>
                                            <option value="أرشيف العام المالي السابق بالكامل">أرشيف العام المالي السابق
                                                بالكامل</option>
                                            <option value="الربع المالي الحالي">الربع المالي الحالي</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-grow-0 mt-5 border-top pt-4 text-left">
                                <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold text-small"><i
                                        class="bi bi-gear-wide-connected"></i>
                                    معالجة وتوليد التقرير السنوي</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div
                            class="bg-white p-4 rounded-4 border shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">تقارير جاهزة سريعة التحميل</h5>
                                <div class="d-flex flex-column gap-3">
                                    <div
                                        class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center border">
                                        <div>
                                            <h6 class="fw-bold mb-1 text-small">التقرير السنوي الشامل 2025</h6>
                                            <span class="text-caption text-muted">الحجم: 4.8 MB | نوع: PDF</span>
                                        </div>
                                        <a href="{{ route('reports_download', 'annual_report_2025.pdf') }}"
                                            class="btn btn-sm btn-outline-primary px-3 text-caption"><i
                                                class="bi bi-download"></i></a>
                                    </div>
                                    <div
                                        class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center border">
                                        <div>
                                            <h6 class="fw-bold mb-1 text-small">التحليل المالي للتحصيلات Q1</h6>
                                            <span class="text-caption text-muted">الحجم: 2.1 MB | نوع: Excel</span>
                                        </div>
                                        <a href="{{ route('reports_download', 'financial_q1.xlsx') }}"
                                            class="btn btn-sm btn-outline-primary px-3 text-caption"><i
                                                class="bi bi-download"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-success-subtle p-3 rounded-3 mt-4 border text-success">
                                <p class="mb-0 text-caption text-small d-flex gap-1">
                                    <i class="bi bi-info-circle-fill"></i>
                                    يتم سحب وتحديث كل دقيقة وتوليد وتحويل السجلات البرمجية مأمونة لتضمن تماسك الإدارة.
                                </p>
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
