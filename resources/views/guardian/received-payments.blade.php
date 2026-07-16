<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - المدفوعات الواردة</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div id="kanaf-sidebar">
            <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
                <div class="brand">
                    <!-- <img src="assets/images/logo.png" alt="كنف" height="35"> -->
                    <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                    <button type="button" class="btn-close btn-close-white d-lg-none ms-auto"
                        aria-label="إغلاق القائمة"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
                </div>

                <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                    <li class="menu-item" id="menu-dashboard">
                        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> الرئيسية</a>
                    </li>
                    <li class="menu-item" id="menu-children">
                        <a href="{{ route('children') }}"><i class="bi bi-people-fill"></i> الأطفال المسجلين</a>
                    </li>
                    <li class="menu-item" id="menu-docs">
                        <a href="{{ route('upload_docs') }}"><i class="bi bi-cloud-arrow-up-fill"></i> رفع التوثيق
                            والتقارير</a>
                    </li>
                    <li class="menu-item active" id="menu-payments">
                        <a href="{{ route('received_payments') }}"><i class="bi bi-cash-stack"></i> الدفعات الواردة</a>
                    </li>
                    <li class="menu-item" id="menu-profile">
                        <a href="{{ route('profile') }}"><i class="bi bi-person-fill-gear"></i> الملف الشخصي للوصي</a>
                    </li>
                </ul>

                <div class="p-3 border-top mt-auto">
                    <a href="{{ route('dashboard') }}"
                        class="btn btn-outline-primary w-full d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="bi bi-arrow-right-short fs-5"></i>
                        <span>العودة للرئيسية</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">كشف مستحقات وحوالات الدعم العائلية</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
                                alt="" class="rounded-circle" width="30" height="30"
                                style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-small text-danger text-right"
                                    href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> خروج
                                    آمن</a></li>
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
                            <li class="breadcrumb-item active" aria-current="page">الحوالات الواردة</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>$ 270</h3>
                                <p>إجمالي مبالغ كفالة رعاية الأسرة المحصلة</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-gift-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>3 حوالات</h3>
                                <p>حوالات بنكية مكتملة التسليم</p>
                            </div>
                            <div class="stats-card-icon bg-info-subtle text-info">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-wallet2 text-primary-green me-1"></i> أرشيف سدادات
                                    الحوالات المستحقة للأيتام</h5>
                                <a href="#" class="btn btn-outline-success btn-sm"><i
                                        class="bi bi-ticket-detailed"></i> طلب تدقيق حوالة
                                    مفقودة</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>معرف الدفعة المالي</th>
                                            <th>الطفل المستفيد</th>
                                            <th>مبلغ الدعم الوارد</th>
                                            <th>تاريخ التحويل المصرفي</th>
                                            <th>حساب وتفصيل الاستلام</th>
                                            <th>الحالة وعملية البنك</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-monospace">PAY-2026-0601</td>
                                            <td>اليتيم: <strong>يوسف سليمان الكفارنة</strong></td>
                                            <td class="fw-bold text-success">$ 80</td>
                                            <td>2026-06-01</td>
                                            <td>حساب الوصي ببنك فلسطين جاري (*1204)</td>
                                            <td>
                                                <span class="badge bg-success px-3 py-1 rounded-pill text-small">تم
                                                    التحويل والإيداع</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">PAY-2026-0602</td>
                                            <td>اليتيم: <strong>شهد محمد الدلو</strong></td>
                                            <td class="fw-bold text-success">$ 90</td>
                                            <td>2026-06-01</td>
                                            <td>حساب الوصي ببنك فلسطين جاري (*1204)</td>
                                            <td>
                                                <span class="badge bg-success px-3 py-1 rounded-pill text-small">تم
                                                    التحويل والإيداع</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">PAY-2026-0512</td>
                                            <td>اليتيم: <strong>يوسف سليمان الكفارنة</strong></td>
                                            <td class="fw-bold text-success">$ 80</td>
                                            <td>2026-05-01</td>
                                            <td>حساب الوصي ببنك فلسطين جاري (*1204)</td>
                                            <td>
                                                <span class="badge bg-success px-3 py-1 rounded-pill text-small">تم
                                                    التحويل والإيداع</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">PAY-2026-0445</td>
                                            <td>اليتيم: <strong>لمى محمود الكفارنة</strong></td>
                                            <td class="fw-bold text-warning">$ 100</td>
                                            <td>2026-04-15</td>
                                            <td>بانتظار تخصيص كفيل للحساب</td>
                                            <td>
                                                <span
                                                    class="badge bg-warning text-dark px-3 py-1 rounded-pill text-small">قيد
                                                    المعالجة</span>
                                            </td>
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
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
