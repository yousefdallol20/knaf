<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - التنبيهات والتعاميم</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
            <div class="brand">
                <!-- <img src="assets/images/logo.png" alt="كنف" height="35"> -->
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
                <li class="menu-item active" id="menu-notifications">
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

            <!-- Back to main public site link -->
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
                    <h4 class="fw-bold mb-0 text-dark">مركز إطلاق الإشعارات والخطابات</h4>
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
                            <li class="breadcrumb-item"><a href="dashboard.html"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">توزيع التنبيهات والتعاميم</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="bg-white p-4 p-md-5 rounded-4 border shadow-sm h-100">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-megaphone-fill text-primary-green"></i> صياغة وإطلاق إشعار جماعي</h5>

                            <!-- نموذج الإرسال للأدمن -->
                            <form id="admin-broadcast-form" action="{{ route('admin.notifications.send') }}"
                                method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">عنوان الخطاب /
                                            الإعلان التنموي</label>
                                        <input type="text" name="title" id="notif-title" class="form-control"
                                            placeholder="اكتب عنوان التعميم المباشر المقتضب" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">الفئة والجهة
                                            المستهدفة بالتبليغ</label>
                                        <select name="user_type" id="notif-user-type" class="form-select bg-light">
                                            <option value="sponsor">جميع المتبرعين الكفلاء المعتمدين</option>
                                            <option value="guardian">جميع الأوصياء والأمهات حاضنات اليتيم</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">النوع والتصنيف
                                            العضوي</label>
                                        <select name="type" id="notif-type" class="form-select bg-light">
                                            <option value="منظومة">تنبيه متعلق بالنظام العام</option>
                                            <option value="دفع">تذكير بسدادات مالية وحسابات</option>
                                            <option value="توثيق">مراجعة وثائق وصكوك العوائل الأيتام</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">تفاصيل ونص التعميم
                                            الصادر</label>
                                        <textarea name="body" id="notif-body" class="form-control text-small text-right" rows="5"
                                            placeholder="أدخل هنا النص التفصيلي الذي تود إرساله كتعميم لكل مستخدم بالمنصة برمز تنبيه عاجل..." required></textarea>
                                    </div>
                                </div>

                                <div class="mt-4 text-left">
                                    <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold text-small">
                                        <i class="bi bi-send-fill me-1"></i> إطلاق التنبيه في البوابة كافّة
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- History of dispatched announcements -->
                    <div class="col-lg-6">
                        <div
                            class="bg-white p-4 p-md-5 rounded-4 border shadow-sm h-100 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">سجل التعاميم والخطابات المصدرة
                                    مسبقاً</h5>
                                <div class="d-flex flex-column gap-3" id="admin-broadcasts-history">
                                    @forelse($broadcasts as $broadcast)
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="badge bg-primary text-white text-caption fw-semibold">
                                                    {{ $broadcast['notifiable_type'] == 'App\Models\User' ? 'المستهدفين' : 'فئة مخصصة' }}
                                                </span>
                                                <span class="text-muted text-caption font-monospace">
                                                    <i class="bi bi-clock"></i>
                                                    {{ \Carbon\Carbon::parse($broadcast['created_at'])->format('Y-m-d') }}
                                                </span>
                                            </div>
                                            <h6 class="fw-bold mb-1 text-dark text-small">
                                                {{ $broadcast['data']['title'] ?? '' }}</h6>
                                            <p class="text-muted text-caption text-small mb-0 lh-base text-right">
                                                {{ $broadcast['data']['body'] ?? '' }}
                                            </p>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center text-small">لا يوجد تعاميم صادرة مسبقاً.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded text-center text-muted text-caption">
                                ملاحظة: تظهر هذه الخطابات المباشرة للجهات المستهدفة بمجرد البث والفرز الفوري.
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
