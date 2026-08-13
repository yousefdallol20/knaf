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
                    <h4 class="fw-bold mb-0 text-dark">مركز إدارة الأيتام المسجلين</h4>
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
                                            <tr>
                                                <td class="font-monospace">#{{ $info->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center fw-bold text-success"
                                                            style="width:40px;height:40px;font-size:14px;">
                                                            <img src="{{ asset('Uploads/orphans/' . $info->personal_photo_path) }}"
                                                                alt="" class="rounded-circle border"
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
                                                <td>
                                                    <strong class="text-primary-green">
                                                        @if (empty($info->status) || in_array($info->status, ['pending_approval', 'بانتظار الموافقة', 'بانتظار القبول', 'جديد']))
                                                            <span class="text-muted fw-normal">غير محدد بعد</span>
                                                        @else
                                                            {{ $info->required_amount ? '$' . number_format($info->required_amount, 2) . ' /شهرياً' : 'غير محدد' }}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td>
                                                    @if (empty($info->status) || in_array($info->status, ['pending_approval', 'بانتظار الموافقة', 'جديد']))
                                                        <span
                                                            class="badge-kanaf badge-pending text-warning bg-warning-subtle py-1 px-2 rounded-2">
                                                            بانتظار القبول
                                                        </span>
                                                    @elseif (in_array($info->status, ['approved_unsponsored', 'approved', 'بانتظار كفيل', 'بانتظار الكفالة', 'غير مكفول']))
                                                        <span
                                                            class="badge-kanaf badge-pending text-primary bg-primary-subtle py-1 px-2 rounded-2">
                                                            غير مكفول
                                                        </span>
                                                    @elseif (in_array($info->status, ['sponsored', 'مكفول']))
                                                        <span
                                                            class="badge-kanaf badge-active text-success bg-success-subtle py-1 px-2 rounded-2">
                                                            مكفول
                                                        </span>
                                                    @elseif (in_array($info->status, ['rejected', 'مرفوض', 'mrfod']))
                                                        <span
                                                            class="badge-kanaf text-danger bg-danger-subtle py-1 px-2 rounded-2">
                                                            مرفوض
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge-kanaf text-secondary bg-secondary-subtle py-1 px-2 rounded-2">
                                                            {{ $info->status }}
                                                        </span>
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
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <!-- شريط التنقل بين الصفحات والإحصائيات -->
                            <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                <!-- النص التوضيحي باللغة العربية -->
                                <div class="text-secondary text-small fw-semibold">
                                    عرض
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                        {{ $data->firstItem() ?? 0 }}
                                    </span>
                                    إلى
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                        {{ $data->lastItem() ?? 0 }}
                                    </span>
                                    من أصل
                                    <span class="fw-bold text-dark mx-1">{{ $data->total() }}</span>
                                    كفيل مسجل
                                </div>

                                <!-- أزرار الصفحات بالاتجاه الصحيح (RTL) -->
                                @if ($data->hasPages())
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                            {{-- زر الصفحة السابقة (السهم الأيمن) --}}
                                            @if ($data->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"
                                                        style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link shadow-none"
                                                        href="{{ $data->previousPageUrl() }}"
                                                        style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- أرقام الصفحات --}}
                                            @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                                                @if ($page == $data->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link shadow-none"
                                                            style="background-color: #0f5b38; border-color: #0f5b38; color: #ffffff; border-radius: 8px; font-weight: bold; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            {{ $page }}
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link shadow-none" href="{{ $url }}"
                                                            style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; font-weight: 600; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            {{ $page }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- زر الصفحة التالية (السهم الأيسر) --}}
                                            @if ($data->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link shadow-none"
                                                        href="{{ $data->nextPageUrl() }}"
                                                        style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link"
                                                        style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @endif

                                        </ul>
                                    </nav>
                                @endif

                            </div>
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
