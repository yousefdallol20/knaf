<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - سجل التدقيق الأمني والعمليات</title>
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
                <li class="menu-item" id="menu-reports">
                    <a href="{{ route('reports_admin') }}"><i class="bi bi-file-earmark-bar-graph-fill"></i> التقارير
                        والتحليلات</a>
                </li>
                <li class="menu-item" id="menu-notifications">
                    <a href="{{ route('admin.notifications.index') }}"><i class="bi bi-send-fill"></i> الإرسال الجماعي
                        والإشعار</a>
                </li>
                <li class="menu-item active" id="menu-audit">
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
                    <h4 class="fw-bold mb-0 text-dark">سجلات التدقيق الأمني ومراقبة تدفقات العمليات</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">سجلات المراقبة والتدقيق</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-shield-fill text-danger me-1"></i>
                                    أرشيف وسجلات
                                    التدقيق والأمن للمنظومة (Compliance Logs)</h5>
                                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i> أرشفة
                                    وتطهير السجلات
                                    القديمة</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>رقم السجل</th>
                                            <th>العضو / المستخدم المحدث</th>
                                            <th>رتبة العضو</th>
                                            <th>العملية والحدث</th>
                                            <th>التفاصيل والمستندات المدخلة</th>
                                            <th>تاريخ وتوقيت العملية</th>
                                        </tr>
                                    </thead>
                                    <tbody id="admin-audit-tbody">

                                        @forelse($logs as $log)
                                            <tr>
                                                <!-- توليد معرف السجل ديناميكياً مع الحفاظ على التنسيق -->
                                                <td class="font-monospace text-muted">#LOG-{{ $log->id }}</td>
                                                <td><strong
                                                        class="text-dark">{{ $log->user->name ?? 'مستخدم غير معروف' }}</strong>
                                                </td>
                                                <td>
                                                    <!-- فحص رتبة العضو وتلوين الشارات الدائرية بناءً على ستايلك الأصلي -->
                                                    @if (optional($log->user)->role === 'admin')
                                                        <span
                                                            class="badge bg-danger text-caption rounded-pill px-2.5 py-1">إداري</span>
                                                    @elseif(optional($log->user)->role === 'guardian')
                                                        <span
                                                            class="badge bg-warning text-dark text-caption rounded-pill px-2.5 py-1">وصي</span>
                                                    @elseif(optional($log->user)->role === 'sponsor')
                                                        <span
                                                            class="badge bg-success text-caption rounded-pill px-2.5 py-1">كافل</span>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold text-small">{{ $log->action }}</td>
                                                <td class="text-muted text-small">{{ $log->details }}</td>
                                                <!-- تنسيق الوقت والتاريخ -->
                                                <td class="font-monospace text-muted">
                                                    {{ $log->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">لا توجد عمليات
                                                    مسجلة في النظام حتى الآن.</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- شريط التنقل بين الصفحات أسفل مساحة الجدول التابع للبوتستراب وللارافيل -->
                            <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                <!-- النص التوضيحي باللغة العربية -->
                                <div class="text-secondary text-small fw-semibold">
                                    عرض
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">{{ $logs->firstItem() ?? 0 }}</span>
                                    إلى
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">{{ $logs->lastItem() ?? 0 }}</span>
                                    من أصل
                                    <span class="fw-bold text-dark mx-1">{{ $logs->total() }}</span>
                                    سجل
                                </div>

                                <!-- أزرار الصفحات بالاتجاه الصحيح (RTL) -->
                                @if ($logs->hasPages())
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                            {{-- زر الصفحة السابقة (السهم الأيمن في الواجهة العربية) --}}
                                            @if ($logs->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"
                                                        style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link shadow-none"
                                                        href="{{ $logs->previousPageUrl() }}"
                                                        style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- أرقام الصفحات بالترتيب الصحيح (1, 2, 3...) --}}
                                            @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                                                @if ($page == $logs->currentPage())
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

                                            {{-- زر الصفحة التالية (السهم الأيسر في الواجهة العربية) --}}
                                            @if ($logs->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link shadow-none"
                                                        href="{{ $logs->nextPageUrl() }}"
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

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
