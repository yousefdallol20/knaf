<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - إدارة الأيتام</title>
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
                    <h4 class="fw-bold mb-0 text-dark">مركز إدارة الأيتام المسجلين</h4>
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">إدارة الأيتام</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-people-fill me-1 text-primary-green"></i> سجل جميع
                                    الأيتام في منصة كنف</h5>
                                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> تسجيل
                                    طفل جديد
                                    يدوياً</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>رقم التعريف</th>
                                            <th>الاسم والبلد</th>
                                            <th>العمر</th>
                                            <th>الحالة الطبية والدراسة</th>
                                            <th>القسط المطلوب</th>
                                            <th>حالة الكفالة</th>
                                            <th class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $info)
                                            @if ($info->status !== 'rejected')
                                                <tr>
                                                    <td class="font-monospace">#{{ $info->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center fw-bold text-success"
                                                                style="width:40px;height:40px;font-size:14px;"><img
                                                                    src="{{ asset('Uploads/orphans/' . $info->personal_photo_path) }}"
                                                                    alt="{{ $info->name }}"
                                                                    class="rounded-circle border"
                                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                            </div>
                                                            <div>
                                                                <strong
                                                                    class="text-dark d-block text-small">{{ $info->name }}</strong>
                                                                <span
                                                                    class="text-caption text-muted">{{ $info->country ?? 'فلسطين' }}
                                                                    - {{ $info->city ?? 'غزة' }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $info->age }} سنوات</td>
                                                    <td>
                                                        <span
                                                            class="d-block text-small text-dark fw-semibold">{{ $info->education_level }}</span>
                                                        <span class="text-caption text-success fs-7">الصحة:
                                                            {{ $info->health_status }}</span>
                                                    </td>
                                                    <td><strong class="text-primary-green">$ 80</strong>/شهرياً</td>
                                                    <!-- قسم فحص حالة الكفالة والموافقة الديناميكي -->
                                                    <td>
                                                        @if ($info->status == 'pending_approval' || $info->status == 'بانتظار الموافقة' || empty($info->status))
                                                            {{-- الحالة 1: بانتظار الموافقة --}}
                                                            <span
                                                                class="badge-kanaf badge-pending text-warning bg-warning-subtle py-1 px-2 rounded-2">بانتظار
                                                                الموافقة</span>
                                                        @elseif(
                                                            $info->status == 'approved_unsponsored' ||
                                                                $info->status == 'approved' ||
                                                                $info->status == 'بانتظار كفيل' ||
                                                                $info->status == 'بانتظار الكفالة' ||
                                                                $info->status == 'غير مكفول')
                                                            {{-- الحالة 2: تم الموافقة وبانتظار الكفيل --}}
                                                            <span
                                                                class="badge-kanaf badge-pending text-primary bg-primary-subtle py-1 px-2 rounded-2">غير
                                                                مكفول</span>
                                                        @elseif($info->status == 'sponsored' || $info->status == 'مكفول')
                                                            {{-- الحالة 3: تم الموافقة وهو مكفول حالياً --}}
                                                            <span
                                                                class="badge-kanaf badge-active text-success bg-success-subtle py-1 px-2 rounded-2">مكفول</span>
                                                        @else
                                                            {{-- حماية احتياطية: إذا كانت هناك قيمة مختلفة في قاعدة البيانات، اطبعها مباشرة لكي لا يظهر فارغاً --}}
                                                            <span
                                                                class="badge-kanaf text-secondary bg-secondary-subtle py-1 px-2 rounded-2">{{ $info->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center w-100">
                                                            <a href="{{ route('Orphan_Details', $info->id) }}"
                                                                class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                                <i class="bi bi-eye-fill"></i>
                                                                <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <!-- شهد محمد الدلو -->
                                        <tr>
                                            <td class="font-monospace">#2</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center fw-bold text-info"
                                                        style="width:40px;height:40px;font-size:14px;">ش</div>
                                                    <div>
                                                        <strong class="text-dark d-block text-small">شهد محمد
                                                            الدلو</strong>
                                                        <span class="text-caption text-muted">فلسطين - خانيونس</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>9 سنوات</td>
                                            <td>
                                                <span class="d-block text-small text-dark fw-semibold">المرحلة
                                                    الابتدائية - الصف الثالث</span>
                                                <span class="text-caption text-warning fs-7">الصحة: مريضة ربو
                                                    مزمن</span>
                                            </td>
                                            <td><strong class="text-primary-green">$ 90</strong>/شهرياً</td>
                                            <td><span class="badge-kanaf badge-active">مكفول</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center w-100">
                                                    <a href="Orphan_Details.html"
                                                        class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-eye-fill"></i>
                                                        <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- أنس أحمد اليازجي -->
                                        <tr>
                                            <td class="font-monospace">#3</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center fw-bold text-warning"
                                                        style="width:40px;height:40px;font-size:14px;">أ</div>
                                                    <div>
                                                        <strong class="text-dark d-block text-small">أنس أحمد
                                                            اليازجي</strong>
                                                        <span class="text-caption text-muted">فلسطين - غزة</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>11 سنوات</td>
                                            <td>
                                                <span class="d-block text-small text-dark fw-semibold">المرحلة
                                                    الابتدائية - الصف الخامس</span>
                                                <span class="text-caption text-danger fs-7">الصحة: مصاب حرب - بتر في
                                                    الساق اليسرى</span>
                                            </td>
                                            <td><strong class="text-primary-green">$ 120</strong>/شهرياً</td>
                                            <td><span class="badge-kanaf badge-pending">بانتظار كفيل</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center w-100">
                                                    <a href="Orphan_Details.html"
                                                        class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-eye-fill"></i>
                                                        <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- جنى رائد فياض -->
                                        <tr>
                                            <td class="font-monospace">#4</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center fw-bold text-danger"
                                                        style="width:40px;height:40px;font-size:14px;">ج</div>
                                                    <div>
                                                        <strong class="text-dark d-block text-small">جنى رائد
                                                            فياض</strong>
                                                        <span class="text-caption text-muted">فلسطين - دير البلح</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>5 سنوات</td>
                                            <td>
                                                <span class="d-block text-small text-dark fw-semibold">الروضة</span>
                                                <span class="text-caption text-success fs-7">الصحة: سليم</span>
                                            </td>
                                            <td><strong class="text-primary-green">$ 80</strong>/شهرياً</td>
                                            <td><span class="badge-kanaf badge-pending">بانتظار كفيل</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center w-100">
                                                    <a href="Orphan_Details.html"
                                                        class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-eye-fill"></i>
                                                        <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- محمود خالد أبو العوف -->
                                        <tr>
                                            <td class="font-monospace">#5</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center fw-bold text-success"
                                                        style="width:40px;height:40px;font-size:14px;">م</div>
                                                    <div>
                                                        <strong class="text-dark d-block text-small">محمود خالد أبو
                                                            العوف</strong>
                                                        <span class="text-caption text-muted">فلسطين - رفح</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>13 سنوات</td>
                                            <td>
                                                <span class="d-block text-small text-dark fw-semibold">المرحلة
                                                    الإعدادية - الصف الأول</span>
                                                <span class="text-caption text-success fs-7">الصحة: سليم</span>
                                            </td>
                                            <td><strong class="text-primary-green">$ 100</strong>/شهرياً</td>
                                            <td><span class="badge-kanaf badge-active">مكفول</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center w-100">
                                                    <a href="Orphan_Details.html"
                                                        class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-eye-fill"></i>
                                                        <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- ليان بسام رضوان -->
                                        <tr>
                                            <td class="font-monospace">#6</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle bg-info-subtle d-flex align-items-center justify-content-center fw-bold text-info"
                                                        style="width:40px;height:40px;font-size:14px;">ل</div>
                                                    <div>
                                                        <strong class="text-dark d-block text-small">ليان بسام
                                                            رضوان</strong>
                                                        <span class="text-caption text-muted">فلسطين - شمال غزة</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>12 سنوات</td>
                                            <td>
                                                <span class="d-block text-small text-dark fw-semibold">المرحلة
                                                    الابتدائية - الصف السادس</span>
                                                <span class="text-caption text-warning fs-7">الصحة: مرض مزمن -
                                                    سكري</span>
                                            </td>
                                            <td><strong class="text-primary-green">$ 110</strong>/شهرياً</td>
                                            <td><span class="badge-kanaf badge-pending">بانتظار كفيل</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center w-100">
                                                    <a href="Orphan_Details.html"
                                                        class="btn btn-outline-warning w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                                        <i class="bi bi-eye-fill"></i>
                                                        <span class="fw-bold">عرض التفاصيل الكاملة</span>
                                                    </a>
                                                </div>
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


    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
