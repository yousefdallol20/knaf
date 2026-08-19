<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - التنبيهات والإشعارات</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
            <div class="brand">
                <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة الوصي - كَنَفْ</h5>
                <button type="button" class="btn-close btn-close-white d-lg-none ms-auto" aria-label="إغلاق القائمة"
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
                <li class="menu-item" id="menu-payments">
                    <a href="{{ route('received_payments') }}"><i class="bi bi-cash-stack"></i> الدفعات الواردة</a>
                </li>
                <li class="menu-item active" id="menu-notifications">
                    <a href="{{ route('guardian.notifications') }}"><i class="bi bi-bell-fill"></i> الإشعارات</a>
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

        <div class="main-content">

            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">مركز الإشعارات والتعاميم</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
                                onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                alt=" " class="rounded-circle" width="30" height="30"
                                style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ $user->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile') }}"><i
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">الإشعارات</li>
                        </ol>
                    </nav>

                    <button type="button" class="btn btn-outline-primary btn-sm fw-bold"
                        onclick="markAllNotificationsAsRead()">
                        <i class="bi bi-check-all fs-5 me-1"></i> تحديد الكل كمقروء
                    </button>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-white p-4 p-md-5 rounded-4 border shadow-sm">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">
                                <i class="bi bi-bell-fill text-primary-green me-2"></i> الإشعارات الواردة من الإدارة
                            </h5>

                            <div class="d-flex flex-column gap-3" id="guardian-notifications-list">
                                @forelse($notifications as $notification)
                                    @php
                                        $type = $notification->data['type'] ?? 'منظومة';
                                        $icon = 'bi-shield-check text-info';
                                        if ($type == 'دفع') {
                                            $icon = 'bi-credit-card-fill text-success';
                                        }
                                        if ($type == 'توثيق') {
                                            $icon = 'bi-file-text-fill text-primary';
                                        }
                                        $isUnread = is_null($notification->read_at);
                                    @endphp

                                    <div class="notification-item p-3 rounded-3 border {{ $isUnread ? 'border-success bg-success-subtle' : 'bg-light' }}"
                                        style="{{ $isUnread ? 'cursor: pointer;' : '' }}"
                                        @if ($isUnread) onclick="markAllNotificationsAsRead()" @endif>
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="p-2 rounded-circle bg-white border d-flex align-items-center justify-content-center"
                                                style="width:42px;height:42px;">
                                                <i class="bi {{ $icon }} fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="fw-bold mb-0">
                                                        {{ $notification->data['title'] ?? 'إشعار جديد' }}
                                                        @if ($isUnread)
                                                            <span class="badge bg-danger ms-2">جديد</span>
                                                        @endif
                                                    </h6>
                                                    <span class="text-muted small font-monospace">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $notification->created_at ? $notification->created_at->format('Y-m-d H:i') : '' }}
                                                    </span>
                                                </div>
                                                <p class="text-muted mb-0 lh-base text-right">
                                                    {{ $notification->data['body'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-5 text-center text-muted">
                                        <i class="bi bi-bell-slash fs-1 mb-2 d-block text-secondary"></i>
                                        <p class="mb-0">لا توجد إشعارات أو تعاميم موجهة لك حالياً.</p>
                                    </div>
                                @endforelse

                                @if ($notifications->hasPages())
                                    <div class="mt-4">
                                        {{ $notifications->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function markAllNotificationsAsRead() {
            // 1. تحديث شكل الإشعارات فوراً في الشاشة لإعطاء استجابة سريعة للمستخدم
            document.querySelectorAll('#guardian-notifications-list .bg-success-subtle').forEach(card => {
                card.classList.remove('bg-success-subtle', 'border-success');
                card.classList.add('bg-light');
                card.style.cursor = 'default';
            });

            // إزالة شارة "جديد" الحمراء
            document.querySelectorAll('#guardian-notifications-list .badge.bg-danger').forEach(badge => badge.remove());

            // 2. إرسال الطلب لجدول الإشعارات في قاعدة البيانات
            fetch("{{ route('guardian_notifications.markAllRead') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // إعادة تحميل الصفحة لتحديث حالة البيانات بالكامل
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>
