<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - مصفوفة الصلاحيات</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
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
                <li class="menu-item active" id="menu-permissions">
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

            <!-- Back to main public site link -->
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
                    <h4 class="fw-bold mb-0 text-dark">مصفوفة توزيع الصلاحيات ونظام التحكم</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-small fw-bold">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="profile.html"><i
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
                            <li class="breadcrumb-item"><a href="dashboard.html"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">مصفوفة الصلاحيات</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">

                            <div
                                class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3 flex-wrap gap-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1"><i
                                            class="bi bi-shield-lock-fill text-danger"></i> جدول تنظيم
                                        وتعديل أوراق الأمن والصلاحيات</h5>
                                    <p class="text-muted text-small mb-0">تحديد الخيارات المناسبة لكل ممثل مالي أو
                                        اجتماعي يعمل بالمنصة
                                        لتجنب المخاطر الأمنية.</p>
                                </div>
                                <!-- Dynamic save trigger -->
                                <button onclick="savePermissionMatrix()" class="btn btn-primary btn-sm"><i
                                        class="bi bi-save me-1"></i>
                                    حفظ وتثبيت مصفوفة الصلاحيات</button>
                            </div>

                            <!-- Permission matrix table -->
                            <div class="table-responsive">
                                <table class="table text-right text-small border align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>الدور / الرتبة الوظيفية</th>
                                            <th class="text-center">إدارة الأيتام (إنشاء/تعديل)</th>
                                            <th class="text-center">التوثيق والمستندات (اعتماد)</th>
                                            <th class="text-center">العمليات المالية والتحويلات (قيد)</th>
                                            <th class="text-center">شؤون المستخدمين (حذف/صيانة)</th>
                                            <th class="text-center">قراءة التقارير الحيوية والمالية</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong class="text-dark">مدير عام النظام (أدمن)</strong></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                        </tr>
                                        <tr>
                                            <td><strong class="text-dark">منسق كنف الاجتماعي</strong></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                        </tr>
                                        <tr>
                                            <td><strong class="text-dark">المحاسب المالي والدفع</strong></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                        </tr>
                                        <tr>
                                            <td><strong class="text-dark">مدقق الحسابات الميداني</strong></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input">
                                            </td>
                                            <td class="text-center"><input type="checkbox" class="form-check-input"
                                                    checked></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
