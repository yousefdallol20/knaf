<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - إدارة الأسر والضامنين</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <style>
        .kanaf-table-card .btn-sm {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .kanaf-table-card .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }

        .kanaf-table-card .btn-danger:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
            transform: translateY(-1px);
        }

        /* ستايل زر مشطوب بلون أحمر خفيف مريح للعين */
        .btn-struck-out {
            background-color: #fde8e8 !important;
            color: #e53e3e !important;
            border: 1px solid #f8b4b4 !important;
            font-weight: 600;
            cursor: not-allowed;
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
                    <h4 class="fw-bold mb-0 text-dark">إدارة الأسر والضامنين</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-small fw-bold">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right"
                                    href="{{ route('admin.settings.index') }}"><i
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

                <!-- رسائل التأكيد والنجاح / الأخطاء -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
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
                                <table class="table text-right text-small align-middle">
                                    <thead>
                                        <tr>
                                            <th>رقم الملف العائلي</th>
                                            <th>الوصي المعتمد</th>
                                            <th>العنوان والمقر</th>
                                            <th>الهاتف والجوال</th>
                                            <th>عدد الايتام</th>
                                            <th>حالة التحقق القانوني</th>
                                            <th class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($families as $family)
                                            <tr>
                                                <td class="font-monospace">FAM-{{ 100 + $family->id }}</td>
                                                <td>
                                                    <strong
                                                        class="text-dark d-block text-small">{{ $family->name ?? 'غير محدد' }}</strong>
                                                    <span class="text-caption text-muted">رقم الهوية:
                                                        {{ $family->national_id ?? '---' }}</span>
                                                </td>
                                                <td>{{ $family->housing->current_displacement_destination ??
                                                    ($family->guardian->housing->current_displacement_destination ??
                                                        ($family->orphans->first()->housing->current_displacement_destination ?? 'غير محدد')) }}
                                                </td>
                                                <td class="font-monospace">
                                                    {{ $family->user?->phone ?? 'لا يوجد هاتف' }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-primary-green border border-primary-green text-small px-3 py-1">
                                                        {{ $family->orphans_count ?? 0 }} أبناء
                                                    </span>
                                                </td>
                                                <td>
                                                    @if (($family->status ?? 'مصدق') == 'مصدق' || ($family->status ?? '') == 'أصيل ومصدق')
                                                        <span class="badge-kanaf badge-active">أصيل ومصدق</span>
                                                    @elseif(($family->status ?? '') == 'مرفوض')
                                                        <span class="badge bg-danger">مرفوض</span>
                                                    @else
                                                        <span class="badge-kanaf badge-pending">قيد الدراسة ومراجعة
                                                            الإثبات</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div
                                                        class="d-flex gap-1 justify-content-center align-items-center">
                                                        {{-- حالة المصادقة --}}
                                                        @if (($family->status ?? '') == 'مصدق' || ($family->user?->status ?? '') == 'مصدق')
                                                            <button
                                                                class="btn btn-sm btn-light text-muted border px-2 py-1"
                                                                disabled style="font-size: 0.78rem;">
                                                                <i class="bi bi-shield-check me-1 text-success"></i>
                                                                مصدق
                                                            </button>
                                                        @else
                                                            <form id="approve-form-{{ $family->id }}"
                                                                action="{{ route('admin.families.approve', $family->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="button"
                                                                    class="btn btn-sm btn-success px-2 py-1 shadow-sm"
                                                                    style="font-size: 0.78rem;"
                                                                    onclick="confirmApprove('approve-form-{{ $family->id }}')">
                                                                    <i class="bi bi-shield-check me-1"></i> مصادقة
                                                                </button>
                                                            </form>
                                                        @endif

                                                        {{-- زر التفاصيل --}}
                                                        <button
                                                            class="btn btn-sm btn-warning text-dark px-2 py-1 shadow-sm"
                                                            style="font-size: 0.78rem;" data-bs-toggle="modal"
                                                            data-bs-target="#modal{{ $family->id }}">
                                                            <i class="bi bi-eye me-1"></i> تفاصيل
                                                        </button>

                                                        {{-- حالة الشطب / الرفض --}}
                                                        @if (($family->status ?? '') == 'مرفوض')
                                                            <button class="btn btn-sm btn-struck-out px-2 py-1"
                                                                disabled style="font-size: 0.78rem;">
                                                                <i class="bi bi-x-circle me-1"></i> مشطوب
                                                            </button>
                                                        @else
                                                            <form id="reject-form-{{ $family->id }}"
                                                                action="{{ route('admin.families.reject', $family->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger px-2 py-1 shadow-sm"
                                                                    style="font-size: 0.78rem;"
                                                                    onclick="confirmReject('reject-form-{{ $family->id }}')">
                                                                    <i class="bi bi-trash me-1"></i> شطب
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- شريط التنقل بين الصفحات -->
                                @if ($families instanceof \Illuminate\Pagination\AbstractPaginator)
                                    <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                        style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                        <div class="text-secondary text-small fw-semibold">
                                            عرض
                                            <span class="badge px-2 py-1 mx-1"
                                                style="background-color: #e6f4f1; color: #0d8a72; border: 1px solid #b2dfdb;">
                                                {{ $families->firstItem() ?? 0 }}
                                            </span>
                                            إلى
                                            <span class="badge px-2 py-1 mx-1"
                                                style="background-color: #e6f4f1; color: #0d8a72; border: 1px solid #b2dfdb;">
                                                {{ $families->lastItem() ?? 0 }}
                                            </span>
                                            من أصل
                                            <span class="fw-bold text-dark mx-1">{{ $families->total() }}</span>
                                            عائلة/وصي مسجل
                                        </div>

                                        @if ($families->hasPages())
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                                    @if ($families->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link"
                                                                style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="bi bi-chevron-right"></i>
                                                            </span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link shadow-none"
                                                                href="{{ $families->previousPageUrl() }}"
                                                                style="color: #0d8a72; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                <i class="bi bi-chevron-right"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @foreach ($families->getUrlRange(1, $families->lastPage()) as $page => $url)
                                                        @if ($page == $families->currentPage())
                                                            <li class="page-item active">
                                                                <span class="page-link shadow-none"
                                                                    style="background-color: #0d8a72; border-color: #0d8a72; color: #ffffff; border-radius: 8px; font-weight: bold; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ $page }}
                                                                </span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link shadow-none"
                                                                    href="{{ $url }}"
                                                                    style="color: #0d8a72; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; font-weight: 600; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                    {{ $page }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                    @if ($families->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link shadow-none"
                                                                href="{{ $families->nextPageUrl() }}"
                                                                style="color: #0d8a72; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
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
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal تفاصيل العوائل -->
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
                                                <th>حالة التحقق</th>
                                                <td>
                                                    @if (($family->status ?? 'مصدق') == 'مصدق' || ($family->status ?? '') == 'أصيل ومصدق')
                                                        <span class="badge-kanaf badge-active">أصيل ومصدق</span>
                                                    @elseif($family->status == 'مرفوض')
                                                        <span class="badge bg-danger">مرفوض</span>
                                                    @else
                                                        <span class="badge-kanaf badge-pending">قيد الدراسة</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>العنوان الحالي</th>
                                                <td>{{ $family->housing->current_displacement_destination ??
                                                    ($family->guardian->housing->current_displacement_destination ??
                                                        ($family->orphans->first()->housing->current_displacement_destination ?? 'غير محدد')) }}
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
    <!-- ضع السكربت في أسفل الملف قبل إغلاق </body> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. عرض تنبيهات النجاح والخطأ القادمة من الـ Session
        @if (session('success'))
            Swal.fire({
                title: 'تمت العملية بنجاح!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#0d6efd',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'حدث خطأ!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'موافق',
                confirmButtonColor: '#dc3545',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            });
        @endif

        // 2. تأكيد المصادقة
        function confirmApprove(formId) {
            Swal.fire({
                title: 'هل أنت متأكد من المصادقة؟',
                text: "سيم منح الحساب الصلاحيات الكاملة وإرسال إشعار للوصي.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-shield-check me-1"></i> نعم، مصادقة',
                cancelButtonText: 'إلغاء',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // 3. تأكيد الشطب / الرفض
        function confirmReject(formId) {
            Swal.fire({
                title: 'هل أنت متأكد من شطب/رفض الملف؟',
                text: "سيتم تغيير حالة الملف إلى مرفوض وإشعار الوصي بالنتيجة.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> نعم، شطب',
                cancelButtonText: 'تراجع',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmReject(formId) {
            const form = document.getElementById(formId);
            const btn = form.querySelector('button');

            Swal.fire({
                title: 'هل أنت متأكد من شطب/رفض الملف؟',
                text: "سيتم تغيير حالة الملف إلى مرفوض وإشعار الوصي بالنتيجة.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> نعم، شطب',
                cancelButtonText: 'تراجع',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // تغيير ستايل الزر لإظهار أنه تم الضغط عليه وجاري الشطب
                    btn.classList.add('disabled', 'btn-rejected-active');
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> جاري الشطب...';
                    btn.style.pointerEvents = 'none';

                    // إرسال النموذج بعد التأكيد مباشرة
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>
