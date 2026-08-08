<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - إدارة الكفلاء</title>
    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                            <img src="{{ asset('assets/images/admin.jpg') }}" alt=" " class="rounded-circle"
                                width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ Auth::user()->name ?? 'إدارة منصة كنف' }}</span>
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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-right" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

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
                                                <td class="font-monospace">SPON-{{ $sponsor->id }}</td>
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
                                                        {{ $sponsor->sponsorships_count ?? 0 }} كفالات نشطة
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
                                                        <!-- زر التعديل الأصلي -->
                                                        <button class="btn btn-outline-primary btn-sm edit-sponsor-btn"
                                                            data-id="{{ $sponsor->id }}"
                                                            data-name="{{ $sponsor->name }}"
                                                            data-email="{{ $sponsor->email }}"
                                                            data-phone="{{ $sponsor->phone }}"
                                                            data-country="{{ $sponsor->country }}"
                                                            data-city="{{ $sponsor->city }}" data-bs-toggle="modal"
                                                            data-bs-target="#editSponsorModal">
                                                            <i class="bi bi-pencil"></i> تعديل
                                                        </button>

                                                        <!-- زر التعليق / التفعيل مع SweetAlert2 لتفادي النوافذ المنبثقة للـ Browser -->
                                                        <form id="toggle-form-{{ $sponsor->id }}"
                                                            action="{{ route('admin.sponsors.toggleStatus', $sponsor->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if ($sponsor->status == 'active')
                                                                <button type="button"
                                                                    class="btn btn-outline-warning btn-sm toggle-status-btn"
                                                                    data-id="{{ $sponsor->id }}"
                                                                    data-action="suspend"
                                                                    data-name="{{ $sponsor->name }}">
                                                                    <i class="bi bi-slash-circle"></i> تعليق
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-outline-success btn-sm toggle-status-btn"
                                                                    data-id="{{ $sponsor->id }}"
                                                                    data-action="activate"
                                                                    data-name="{{ $sponsor->name }}">
                                                                    <i class="bi bi-check-circle"></i> تفعيل
                                                                </button>
                                                            @endif
                                                        </form>
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
                                <!-- شريط التنقل بين الصفحات والإحصائيات -->
                                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                    style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                    <!-- النص التوضيحي باللغة العربية -->
                                    <div class="text-secondary text-small fw-semibold">
                                        عرض
                                        <span class="badge px-2 py-1 mx-1"
                                            style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                            {{ $sponsors->firstItem() ?? 0 }}
                                        </span>
                                        إلى
                                        <span class="badge px-2 py-1 mx-1"
                                            style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                            {{ $sponsors->lastItem() ?? 0 }}
                                        </span>
                                        من أصل
                                        <span class="fw-bold text-dark mx-1">{{ $sponsors->total() }}</span>
                                        كفيل مسجل
                                    </div>

                                    <!-- أزرار الصفحات بالاتجاه الصحيح (RTL) -->
                                    @if ($sponsors->hasPages())
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                                {{-- زر الصفحة السابقة (السهم الأيمن) --}}
                                                @if ($sponsors->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link"
                                                            style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link shadow-none"
                                                            href="{{ $sponsors->previousPageUrl() }}"
                                                            style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- أرقام الصفحات --}}
                                                @foreach ($sponsors->getUrlRange(1, $sponsors->lastPage()) as $page => $url)
                                                    @if ($page == $sponsors->currentPage())
                                                        <li class="page-item active">
                                                            <span class="page-link shadow-none"
                                                                style="background-color: #0f5b38; border-color: #0f5b38; color: #ffffff; border-radius: 8px; font-weight: bold; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                {{ $page }}
                                                            </span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link shadow-none"
                                                                href="{{ $url }}"
                                                                style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; font-weight: 600; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                                {{ $page }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- زر الصفحة التالية (السهم الأيسر) --}}
                                                @if ($sponsors->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link shadow-none"
                                                            href="{{ $sponsors->nextPageUrl() }}"
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

    <!-- مودال تعديل بيانات الكافل -->
    <div class="modal fade" id="editSponsorModal" tabindex="-1" aria-labelledby="editSponsorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-right">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editSponsorModalLabel"><i
                            class="bi bi-pencil-square text-primary me-1"></i> تعديل بيانات الكافل</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editSponsorForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-small">الاسم الكامل</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-small">البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-small">رقم الجوال</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-6 mb-3">
                                <label class="form-label text-small">الدولة</label>
                                <input type="text" name="country" id="edit_country" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-small">المدينة</label>
                                <input type="text" name="city" id="edit_city" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-small"
                            data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary text-small">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Assets -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. تعبئة المودال عند التعديل
            const editButtons = document.querySelectorAll('.edit-sponsor-btn');
            const editForm = document.getElementById('editSponsorForm');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    editForm.action = `/admin/sponsors/${id}`;

                    document.getElementById('edit_name').value = this.getAttribute('data-name');
                    document.getElementById('edit_email').value = this.getAttribute('data-email');
                    document.getElementById('edit_phone').value = this.getAttribute('data-phone');
                    document.getElementById('edit_country').value = this.getAttribute(
                        'data-country');
                    document.getElementById('edit_city').value = this.getAttribute('data-city');
                });
            });

            // 2. تنبيه عصري لتأكيد التفعيل/التعليق
            const toggleButtons = document.querySelectorAll('.toggle-status-btn');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sponsorId = this.getAttribute('data-id');
                    const action = this.getAttribute('data-action');
                    const sponsorName = this.getAttribute('data-name');
                    const form = document.getElementById(`toggle-form-${sponsorId}`);

                    const isSuspend = action === 'suspend';

                    Swal.fire({
                        title: isSuspend ? 'هل أنت تأكد من تعليق/تجميد حساب الكافل؟' :
                            'هل أنت تأكد من إعاده تفعيل حساب الكافل؟',
                        text: isSuspend ?
                            `سيتم تعليق حساب الكافل (${sponsorName}) مؤقتاً.` :
                            `سيتم إعادة تنشيط حساب الكافل (${sponsorName}).`,
                        icon: isSuspend ? 'warning' : 'question',
                        showCancelButton: true,
                        confirmButtonColor: isSuspend ? '#d33' : '#3085d6',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: isSuspend ? 'نعم، قم بالتعليق' :
                            'نعم، قم بالتفعيل',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
