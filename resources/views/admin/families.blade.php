<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - إدارة الأسر والضامنين</title>
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
                <li class="menu-item active" id="menu-families">
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
                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-key-fill"></i> الصلاحيات والأدوار</a>
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
                    <h4 class="fw-bold mb-0 text-dark">إدارة الأسر والضامنين</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../assets/images/admin.jpg" alt="رمز" class="rounded-circle" width="30"
                                height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">أ. عبد الرحمن البكري</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="#"><i
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
                            <li class="breadcrumb-item active" aria-current="page">إدارة أسر الأيتام</li>
                        </ol>
                    </nav>
                </div>

                <!-- رسائل التأكيد والنجاح -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">
                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-house-heart-fill text-primary-green me-1"></i> أرشيف وسجلات
                                    العوائل وأوصياء رعاية الأيتام</h5>
                                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> إدراج
                                    عائلة يتيم جديدة</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>رقم الملف العائلي</th>
                                            <th>الوصي المعتمد</th>
                                            <th>العنوان والمقر</th>
                                            <th>الهاتف والجوال</th>
                                            <th>الأيتام المكفولين</th>
                                            <th>حالة التحقق القانوني</th>
                                            <th class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($families as $family)
                                            <tr>
                                                <!-- رقم المعرف الخاص بالوصي كمعرّف عائلي -->
                                                <td class="font-monospace">FAM-{{ 100 + $family->id }}</td>
                                                <td>
                                                    <!-- الحقول الفعلية من جدول guardians -->
                                                    <strong
                                                        class="text-dark d-block text-small">{{ $family->name }}</strong>
                                                    <span class="text-caption text-muted">رقم الهوية:
                                                        {{ $family->national_id }}</span>
                                                </td>
                                                <!-- جلب العنوان من علاقة السكن المرتبطة بالوصي أو وضع نص افتراضي -->
                                                <td>{{ $family->housing->current_displacement_destination ?? 'غير محدد' }}
                                                </td>
                                                <td class="font-monospace">
                                                    {{ $family->user->phone ?? 'لا يوجد هاتف' }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-primary-green border border-primary-green text-small px-3 py-1">
                                                        {{ $family->orphans_count }} أبناء
                                                    </span>
                                                </td>
                                                <td>
                                                    <!-- يمكنك جعل حالة التحقق مرتبطة بالوصي أو افتراضية -->
                                                    <span
                                                        class="badge-kanaf badge-active text-success bg-success-subtle py-1 px-2 rounded-2">أصيل
                                                        ومصدق</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $family->id }}">
                                                            <i class="bi bi-eye"></i> تفاصيل
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إنشاء الـ Modals ديناميكياً لكل عائلة موجودة -->
    <!-- إنشاء الـ Modals ديناميكياً لكل وصي -->
    @foreach ($families as $family)
        <div class="modal fade" id="modal{{ $family->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content text-right">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-house-fill me-2"></i> تفاصيل العائلة -
                            FAM-{{ 100 + $family->id }}</h5>
                        <button type="button" class="btn-close ms-0" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light fw-bold text-dark">بيانات الوصي</div>
                                    <div class="card-body">
                                        <table class="table table-sm text-small">
                                            <tr>
                                                <th width="40%">الاسم</th>
                                                <td>{{ $family->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>صلة القرابة</th>
                                                <td>{{ $family->kinship_relation }}</td>
                                            </tr>
                                            <tr>
                                                <th>رقم الهوية</th>
                                                <td class="font-monospace">{{ $family->national_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>الحالة الاجتماعية</th>
                                                <td>{{ $family->marital_status }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light fw-bold text-dark">بيانات الملف</div>
                                    <div class="card-body">
                                        <table class="table table-sm text-small">
                                            <tr>
                                                <th width="40%">رقم الملف</th>
                                                <td class="font-monospace">FAM-{{ 100 + $family->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>عدد الأبناء</th>
                                                <td>{{ $family->orphans_count }} أبناء</td>
                                            </tr>
                                            <tr>
                                                <th>العنوان الحالي</th>
                                                <td>{{ $family->housing->current_displacement_destination ?? 'غير محدد' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
