<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - عقود كفالة الأيتام</title>
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
                    <h4 class="fw-bold mb-0 text-dark">إدارة عقود وشراكات الكفالة</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-small fw-bold">{{ auth()->user()->name }}</span>
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_admin') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">عقود كفالات منصة كنف</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">
                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-journal-bookmark-fill text-primary-green me-1"></i> السجل المركزي
                                    لعقود الكفالة السارية والمنتهية</h5>
                                <button class="btn btn-primary btn-sm"><i class="bi bi-plus-circle me-1"></i> تسجيل
                                    عقد كفالة فوري</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small align-middle">
                                    <thead>
                                        <tr>
                                            <th>رقم العقد الدقيق</th>
                                            <th>اليتيم المستفيد</th>
                                            <th>الكفيل الملتزم</th>
                                            <th>تاريخ تدشين العقد</th>
                                            <th>المبلغ والالتزام الشهري</th>
                                            <th>الحالة السكنية والعقدية</th>
                                            <th class="text-center">إجراءات التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody id="admin-sponsorships-tbody">
                                        @foreach ($sponsorships as $sponsorship)
                                            @php
                                                // 1️⃣ جلب المبلغ المستحق الصحيح
                                                $requiredAmount =
                                                    $sponsorship->required_amount ??
                                                    ($sponsorship->monthly_amount ??
                                                        ($sponsorship->orphan->required_amount ?? 50));

                                                // 2️⃣ جلب اسم الملف للصورة الشخصية من قاعدة البيانات
                                                $photoName =
                                                    $sponsorship->orphan->personal_photo_path ??
                                                    ($sponsorship->orphan->photo ?? null);

                                                // 3️⃣ تحديد المسار الحقيقي داخل public/Uploads/orphans
                                                if ($photoName && Str::startsWith($photoName, 'http')) {
                                                    $photoUrl = $photoName;
                                                } elseif (
                                                    $photoName &&
                                                    !empty($photoName) &&
                                                    $photoName !== 'default.png'
                                                ) {
                                                    $photoUrl = asset('Uploads/orphans/' . $photoName);
                                                } else {
                                                    // صورة افتراضية عند غياب الصورة
                                                    $photoUrl = asset('assets/images/orphan-1.png');
                                                }
                                            @endphp
                                            <tr>
                                                <td class="font-monospace">CONT-{{ 300 + $sponsorship->id }}</td>

                                                <!-- صورة واسم اليتيم الصحيح -->
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ $photoUrl }}"
                                                            alt="{{ $sponsorship->orphan->name ?? 'صورة اليتيم' }}"
                                                            class="rounded-circle shadow-xs" width="35"
                                                            height="35" style="object-fit: cover;"
                                                            onerror="this.onerror=null;this.src='{{ asset('assets/images/orphan-1.png') }}';">

                                                        <strong class="text-dark text-small">
                                                            {{ $sponsorship->orphan->name ?? $sponsorship->orphan->first_name . ' ' . $sponsorship->orphan->last_name }}
                                                        </strong>
                                                    </div>
                                                </td>

                                                <!-- بيانات الكفيل -->
                                                <td>
                                                    <strong
                                                        class="text-dark text-small d-block">{{ $sponsorship->sponsor->name ?? 'الكفيل' }}</strong>
                                                    <span
                                                        class="text-caption text-muted">{{ $sponsorship->sponsor->user->email ?? ($sponsorship->sponsor->email ?? '') }}</span>
                                                </td>

                                                <!-- تاريخ العقد -->
                                                <td>{{ $sponsorship->created_at ? $sponsorship->created_at->format('Y-m-d') : now()->format('Y-m-d') }}
                                                </td>

                                                <!-- المبلغ والالتزام الشهري -->
                                                <td>
                                                    <strong class="text-success">$
                                                        {{ number_format($requiredAmount, 2) }}</strong> / شهرياً
                                                </td>

                                                <!-- الحالة السكنية والعقدية -->
                                                <td>
                                                    @if ($sponsorship->status == 'نشط' || $sponsorship->status == 'ساري' || empty($sponsorship->status))
                                                        <span class="badge-kanaf badge-active">عقد نشط ساري</span>
                                                    @else
                                                        <span class="badge-kanaf badge-stopped">موقوف / تدقيق
                                                            أمني</span>
                                                    @endif
                                                </td>

                                                <!-- إجراءات التحكم -->
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        @if ($sponsorship->status == 'معلق' || $sponsorship->status == 'موقوف')
                                                            <form
                                                                action="{{ route('admin.sponsors.toggleStatus', $sponsorship->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                    <i class="bi bi-play-circle"></i> تفعيل العقد
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form id="suspend-form-{{ $sponsorship->id }}"
                                                                action="{{ route('admin.sponsors.toggleStatus', $sponsorship->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="reason"
                                                                    id="reason-input-{{ $sponsorship->id }}">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm"
                                                                    onclick="suspendContract({{ $sponsorship->id }})">
                                                                    <i class="bi bi-slash-circle"></i> تعليق العقد
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- شريط التنقل بين الصفحات أسفل مساحة الجدول التابع للبوتستراب وللارافيل -->
                                <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                    style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                    <!-- النص التوضيحي باللغة العربية -->
                                    <div class="text-secondary text-small fw-semibold">
                                        عرض
                                        <span class="badge px-2 py-1 mx-1"
                                            style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">{{ $sponsorships->firstItem() ?? 0 }}</span>
                                        إلى
                                        <span class="badge px-2 py-1 mx-1"
                                            style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">{{ $sponsorships->lastItem() ?? 0 }}</span>
                                        من أصل
                                        <span class="fw-bold text-dark mx-1">{{ $sponsorships->total() }}</span>
                                        عقد كفالة
                                    </div>

                                    <!-- أزرار الصفحات بالاتجاه الصحيح (RTL) -->
                                    @if ($sponsorships->hasPages())
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                                {{-- زر الصفحة السابقة (السهم الأيمن في الواجهة العربية) --}}
                                                @if ($sponsorships->onFirstPage())
                                                    <li class="page-item disabled">
                                                        <span class="page-link"
                                                            style="color: #cbd5e1; background-color: #f8f9fa; border-color: #e2e8f0; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link shadow-none"
                                                            href="{{ $sponsorships->previousPageUrl() }}"
                                                            style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- أرقام الصفحات بالترتيب الصحيح (1, 2, 3...) --}}
                                                @foreach ($sponsorships->getUrlRange(1, $sponsorships->lastPage()) as $page => $url)
                                                    @if ($page == $sponsorships->currentPage())
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

                                                {{-- زر الصفحة التالية (السهم الأيسر في الواجهة العربية) --}}
                                                @if ($sponsorships->hasMorePages())
                                                    <li class="page-item">
                                                        <a class="page-link shadow-none"
                                                            href="{{ $sponsorships->nextPageUrl() }}"
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

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // تنبيه تعليق العقد بإدخال السبب
        function suspendContract(id) {
            Swal.fire({
                title: 'تعليق عقد الكفالة',
                text: 'أدخل سبب التعليق الذي سيتم إرساله في إشعار للكفيل:',
                input: 'text',
                inputValue: 'دواعٍ أمنية وتدقيق في إجراءات التوثيق الدورية',
                inputPlaceholder: 'اكتب سبب التعليق هنا...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-shield-slash me-1"></i> تأكيد التعليق والإشعار',
                cancelButtonText: 'إلغاء',
                customClass: {
                    popup: 'rounded-4 shadow'
                },
                inputValidator: (value) => {
                    if (!value) {
                        return 'يرجى كتابة السبب أو ترك السبب الافتراضي!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reason-input-' + id).value = result.value;
                    document.getElementById('suspend-form-' + id).submit();
                }
            });
        }

        // تنبيه الفلاش في حال نجاح التحديث من لارافيل
        @if (session('success'))
            Swal.fire({
                title: 'تمت العملية بنجاح!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#0d6efd',
                customClass: {
                    popup: 'rounded-4 shadow'
                }
            });
        @endif
    </script>
</body>

</html>
