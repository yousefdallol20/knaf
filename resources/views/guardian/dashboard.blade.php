<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - الرئيسية</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div id="kanaf-sidebar">
            <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
                <div class="brand">
                    <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="كنف" height="35"> -->
                    <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                    <button type="button" class="btn-close btn-close-white d-lg-none ms-auto"
                        aria-label="إغلاق القائمة"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
                </div>

                <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                    <li class="menu-item active" id="menu-dashboard">
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
                    <li class="menu-item" id="menu-notifications">
                        <a href="{{ route('guardian.notifications') }}"><i class="bi bi-bell-fill"></i> الإشعارات</a>
                    </li>
                    <li class="menu-item" id="menu-profile">
                        <a href="{{ route('profile') }}"><i class="bi bi-person-fill-gear"></i> الملف الشخصي للوصي</a>
                    </li>
                </ul>

                <!-- Back to main public site link -->
                <div class="p-3 border-top mt-auto">
                    <a href="{{ route('dashboard') }}"
                        class="btn btn-outline-primary w-full d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="bi bi-arrow-right-short fs-5"></i>
                        <span>العودة للرئيسية</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="main-content">

            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">بوابة الأوصياء ورعاية الأطفال</h4>
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

                <div class="bg-primary-green text-white p-4 p-md-5 rounded-4 shadow-sm mb-4"
                    style="background: linear-gradient(135deg, var(--primary-green) 0%, #155030 100%);">
                    <div class="max-w-xl">
                        <h2 class="fw-bold mb-2">أهلاً بك {{ auth()->user()->name }} في بوابة كنف
                            لكفالة عائلتك</h2>
                        <p class="mb-0 text-white-50">هنا يمكنك إدارة ملفات أطفالك المسجلين من غزة، رفع الوثائق وشهادات
                            المدرسة
                            لضمان استمرار الكفالة الشريفة والحصول على المستحقات المالية بكامل الكرامة والأمان.</p>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>{{ $childrenCount }}</h3>
                                <p>عدد الأبناء المسجلين</p>
                            </div>
                            <div class="stats-card-icon bg-info-subtle text-info">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>{{ $activeSponsorships }}</h3>
                                <p>كفالات نشطة سارية</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>{{ $requiredDocsCount }}</h3>
                                <p>توثيقات وتقارير مطلوبة</p>
                            </div>
                            <div class="stats-card-icon bg-warning-subtle text-warning">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Active children cards -->
                    <div class="col-lg-8">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-people-fill me-2 text-primary-green"></i> أطفالي
                                    وعائلتي</h5>
                                <a href="{{ route('child_form') }}" class="btn btn-secondary btn-sm"><i
                                        class="bi bi-plus-circle me-1"></i> تسجيل
                                    طفل جديد للتكفل</a>
                            </div>

                            <div class="row g-3">

                                @foreach ($orphan as $info)
                                    <!-- Child 1 -->
                                    <div class="col-md-6">
                                        <div
                                            class="p-3 bg-light rounded-3 border h-100 flex-grow-1 d-flex flex-column justify-content-between">
                                            <div>
                                                <img src="{{ asset('Uploads/orphans/' . $info->personal_photo_path) }}"
                                                    alt=" " class="img-fluid rounded-3 mb-2"
                                                    style="height: 140px; object-fit: cover; width: 100%;">
                                                <h6 class="fw-bold mb-1 text-dark">{{ $info->name }}</h6>
                                                <div
                                                    class="d-flex gap-2 text-muted text-caption align-items-center mb-2">
                                                    <span>العمر: {{ $info->age }} سنة</span>
                                                    <span>|</span>
                                                    <span>{{ $info->education_level }}</span>
                                                </div>
                                                <span>
                                                    @if ($info->status == 'بانتظار القبول')
                                                        <span class="badge bg-warning text-dark"><i
                                                                class="bi bi-clock-history me-1"></i> بانتظار
                                                            القبول</span>
                                                    @elseif($info->status == 'مرفوض')
                                                        <span class="badge bg-danger"><i
                                                                class="bi bi-x-circle me-1"></i> تم
                                                            الرفض</span>
                                                    @elseif($info->status == 'مكفول')
                                                        <span class="badge bg-success"><i
                                                                class="bi bi-check-circle me-1"></i>
                                                            {{ $info->status }}</span>
                                                    @elseif($info->status == 'بانتظار الكفالة')
                                                        <span class="badge-kanaf badge-pending"><i
                                                                class="bi bi-check-circle me-1"></i>
                                                            {{ $info->status }}</span>
                                                    @endif
                                                </span>
                                                <br>
                                                <br>
                                            </div>
                                            <div class="border-top pt-2 d-flex gap-1 justify-content-end">
                                                <a href="{{ route('children.edit', $info->id) }}"
                                                    class="btn btn-outline-primary btn-sm px-2 text-caption">تعديل
                                                    الملف</a>
                                                <a href="{{ route('upload_docs', ['id' => $info->id]) }}"
                                                    class="btn btn-primary btn-sm px-2 text-white text-caption">رفع
                                                    تقرير</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <!-- Shortcuts to documents and quick uploads -->
                    <div class="col-lg-4">
                        <div
                            class="bg-white p-4 rounded-4 shadow-sm border h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">روابط سريعة</h5>

                                <div class="d-flex flex-column gap-3">
                                    <a href="{{ route('upload_docs') }}"
                                        class="p-3 bg-light rounded-3 text-dark text-decoration-none border d-flex gap-3 align-items-center"
                                        style="transition: all 0.3s ease;">
                                        <div class="p-2 bg-success text-white rounded-3"><i
                                                class="bi bi-cloud-arrow-up fs-5"></i></div>
                                        <div>
                                            <h6 class="fw-bold text-small mb-1">رفع شهادة مدرسية جديدة</h6>
                                            <p class="text-caption text-muted mb-0">لإظهارها للمتطوع الكافل فوراً.</p>
                                        </div>
                                    </a>
                                    <a href="{{ route('received_payments') }}"
                                        class="p-3 bg-light rounded-3 text-dark text-decoration-none border d-flex gap-3 align-items-center"
                                        style="transition: all 0.3s ease;">
                                        <div class="p-2 bg-warning text-dark rounded-3"><i
                                                class="bi bi-cash-stack fs-5"></i></div>
                                        <div>
                                            <h6 class="fw-bold text-small mb-1">تفاصيل المبالغ والتحويلات</h6>
                                            <p class="text-caption text-muted mb-0">دفوعات الأيتام المستلمة شهرياً.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div
                                class="mt-4 p-3 rounded-3 bg-success-subtle text-success border border-success-subtle d-flex gap-2">
                                <i class="bi bi-shield-lock-fill fs-4 text-success"></i>
                                <div class="text-caption text-small">
                                    <strong>نظام كنف مأمون للخصوصية</strong><br>
                                    يتم إخفاء صور وملفات أطفالك الطبية عن غير المتبرع المسجل والمعتمد قانونياً حماية
                                    لكم.
                                </div>
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
