<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - تدقيق الوثائق</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <!-- مكتبة التنبيهات SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <li class="menu-item active" id="menu-docs">
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
                    <h4 class="fw-bold mb-0 text-dark">نظام مراجعة وتدقيق المستندات والتقارير المرفوعة</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">غرفة تتبع المستندات</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">
                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold mb-0 text-dark"><i
                                        class="bi bi-file-earmark-check-fill text-primary-green me-1"></i>
                                    وثائق وتقارير أيتامنا المرفوعة من الأوصياء للمراجعة والمصادقة</h5>
                                <span class="text-caption text-muted"><i class="bi bi-shield-lock-fill"></i> مراجعة
                                    الوثائق تضمن خصوصية وسرية معلومات الأطفال الأيتام</span>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small align-middle">
                                    <thead>
                                        <tr>
                                            <th>رقم المستند</th>
                                            <th>اليتيم المعني والوصي</th>
                                            <th>نوع المستند</th>
                                            <th>توصيف التقرير المدرج</th>
                                            <th>تاريخ ورفع المستند</th>
                                            <th>حالة المراجعة</th>
                                            <th class="text-center">إجراءات المراجعة</th>
                                        </tr>
                                    </thead>
                                    <tbody id="admin-docs-tbody">
                                        @forelse($documents as $doc)
                                            <tr>
                                                <td class="font-monospace">DOC-{{ 400 + $doc->id }}</td>
                                                <td>
                                                    <strong
                                                        class="text-dark d-block text-small">{{ $doc->orphan->name ?? ($doc->orphan->first_name ?? 'اليتيم') }}</strong>
                                                    <span class="text-caption text-muted">الوصي:
                                                        {{ $doc->orphan->guardian->name ?? 'معلومات العائلة' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-primary-green border border-primary-green text-caption px-2 py-1">
                                                        {{ $doc->doc_type }}
                                                    </span>
                                                </td>
                                                <td><strong>{{ $doc->title }}</strong></td>
                                                <td>{{ $doc->date }}</td>
                                                <td>
                                                    @if ($doc->status == 'مقبول')
                                                        <span
                                                            class="badge bg-success text-caption px-3 py-1 rounded-pill">معتمد</span>
                                                    @elseif($doc->status == 'بانتظار المراجعة')
                                                        <span
                                                            class="badge bg-warning text-dark text-caption px-3 py-1 rounded-pill">قيد
                                                            المراجعة</span>
                                                    @else
                                                        <span
                                                            class="badge bg-danger text-white text-caption px-3 py-1 rounded-pill">مرفوض</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ $doc->file_url }}" target="_blank"
                                                            class="btn btn-outline-primary btn-sm"><i
                                                                class="bi bi-eye"></i> استعراض</a>

                                                        @if ($doc->status == 'بانتظار المراجعة')
                                                            <!-- زر الاعتماد -->
                                                            <form action="{{ route('documents_approve', $doc->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    style="color:white !important;"><i
                                                                        class="bi bi-check-lg"></i> اعتماد</button>
                                                            </form>

                                                            <!-- زر الرفض مع سبب -->
                                                            <form id="reject-doc-form-{{ $doc->id }}"
                                                                action="{{ route('documents_reject', $doc->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="rejection_reason"
                                                                    id="reject-reason-{{ $doc->id }}">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    onclick="rejectDocument({{ $doc->id }})">
                                                                    <i class="bi bi-x-lg"></i> رفض
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-outline-secondary btn-sm"
                                                                disabled><i class="bi bi-lock"></i> مقفل</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">لا توجد وثائق
                                                    أو مستندات مرفوعة بانتظار المراجعة حالياً.</td>
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
    <script>
        // دالة رفض المستند وإدخال السبب
        function rejectDocument(id) {
            Swal.fire({
                title: 'رفض المستند المرفوع',
                text: 'يرجى تحديد سبب الرفض (عدم وضوح الصورة، ملف غير صحيح، تزوير/بيانات خاطئة...):',
                input: 'select',
                inputOptions: {
                    'عدم وضوح الصورة أو جودة الملف ضعيفة': 'عدم وضوح الصورة أو جودة الملف ضعيفة',
                    'المستند المرفق غير صحيح أو لا يطابق المطلوب': 'المستند المرفق غير صحيح أو لا يطابق المطلوب',
                    'اشتباه في تزوير أو عدم صحة البيانات المرفقة': 'اشتباه في تزوير أو عدم صحة البيانات المرفقة',
                    'تاريخ المستند منتهي الصلاحية': 'تاريخ المستند منتهي الصلاحية',
                    'آخر': 'سبب آخر (اكتبه أدناه)'
                },
                inputPlaceholder: 'اختر سبب الرفض...',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-x-circle me-1"></i> تأكيد الرفض والإشعار',
                cancelButtonText: 'إلغاء',
                customClass: {
                    popup: 'rounded-4 shadow'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'يجب اختيار سبب الرفض لإبلاغ الوصي!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value === 'آخر') {
                        // إذا اختار "سبب آخر" نفتح له مربع نص حر
                        Swal.fire({
                            title: 'اكتب سبب الرفض بالتفصيل:',
                            input: 'text',
                            inputPlaceholder: 'مثال: الصورة غير ملونة، أو الاسم غير واضح...',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            confirmButtonText: 'إرسال',
                            cancelButtonText: 'إلغاء',
                            inputValidator: (text) => {
                                if (!text) return 'يرجى كتابة السبب!';
                            }
                        }).then((customResult) => {
                            if (customResult.isConfirmed) {
                                document.getElementById('reject-reason-' + id).value = customResult.value;
                                document.getElementById('reject-doc-form-' + id).submit();
                            }
                        });
                    } else {
                        document.getElementById('reject-reason-' + id).value = result.value;
                        document.getElementById('reject-doc-form-' + id).submit();
                    }
                }
            });
        }

        // تنبيهات النجاح والخطأ
        @if (session('success'))
            Swal.fire({
                title: 'تمت العملية!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#0d6efd',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            });
        @endif

        @if (session('danger'))
            Swal.fire({
                title: 'تم الرفض!',
                text: "{{ session('danger') }}",
                icon: 'error',
                confirmButtonColor: '#dc3545',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            });
        @endif
    </script>
</body>

</html>
