<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - المدفوعات والاشتراكات</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">

            <div class="brand">
                <h5 class="text-primary-green mb-0 fw-bold d-inline-block">
                    لوحة تحكّم كَنَفْ
                </h5>
                <button type="button" class="btn-close btn-close-white d-lg-none ms-auto" aria-label="إغلاق القائمة"
                    onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
            </div>

            <ul class="sidebar-menu flex-grow-1">

                <li class="menu-item">
                    <a href="{{ route('dashboard_sponsor') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('sponsorships') }}">
                        <i class="bi bi-heart-fill"></i>
                        <span>كفالاتي النشطة</span>
                    </a>
                </li>

                <li class="menu-item active">
                    <a href="{{ route('payments') }}">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>المدفوعات والاشتراكات</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('documentation') }}">
                        <i class="bi bi-file-earmark-person-fill"></i>
                        <span>وثائق وتقارير الأيتام</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('notifications') }}">
                        <i class="bi bi-bell-fill"></i>
                        <span>الإشعارات والرسائل</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('profile_sponser') }}">
                        <i class="bi bi-person-fill-gear"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>

            </ul>

            <div class="p-3 border-top mt-auto">

                <a href="{{ route('dashboard_sponsor') }}"
                    class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-pill">
                    <i class="bi bi-arrow-right-short fs-5"></i>
                    <span>العودة للرئيسية</span>
                </a>

            </div>

        </div>

        <!-- Main Content Work area -->
        <div class="main-content">

            <!-- Top header bar -->
            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">لوحة تحكّم الكافـل</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}" alt="رمز"
                                class="rounded-circle" width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ $user->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile_sponser') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-small text-danger text-right"
                                    href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> خروج آمن</a>
                            </li>
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
                            <li class="breadcrumb-item active" aria-current="page">سجلات المدفوعات</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3 id="payment-sum-count">$ 270</h3>
                                <p>إجمالي المبالغ المودعة حتى الآن</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-wallet-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3 id="payment-trans-count">3 دُفعة</h3>
                                <p>عدد الدفعات المصرفية المكتملة</p>
                            </div>
                            <div class="stats-card-icon bg-primary-subtle text-primary-green">
                                <i class="bi bi-journal-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-card-list me-1 text-primary-green"></i> أرشيف سحوبات
                                    الفواتير وإيصالات الكفالة</h5>
                                <div class="d-flex gap-2">
                                    <button onclick="triggerNewManualPayment()" class="btn btn-secondary btn-sm"><i
                                            class="bi bi-plus-circle me-1"></i> تسجيل دفعة كفالة فورية</button>
                                    <button id="excel-btn" class="btn btn-outline-success btn-sm"><i
                                            class="bi bi-file-earmark-excel"></i>
                                        تصدير كشف الحساب</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>رقم الفاتورة المرجعي</th>
                                            <th>توصيف الكفالة المستهدفة</th>
                                            <th>القيمة المودعة</th>
                                            <th>تاريخ العملية</th>
                                            <th>وسيلة الدفع</th>
                                            <th>حالة التحصيل</th>
                                            <th class="text-center">إيصال</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                            <tr>
                                                <td class="font-monospace">KNF-2026-{{ $payment->id }}</td>
                                                <!-- بما أن orphan_id متاح، يفضل مستقبلاً تحميل موديل اليتيم، حالياً سنعرض المعرف أو التوصيف المتاح -->
                                                <td>كفالة مستهدفة رقم: <strong>{{ $payment->orphan_id }}</strong></td>
                                                <td class="fw-bold text-success">{{ $payment->amount_paid }} $</td>
                                                <td>{{ $payment->last_batch ?? '---' }}</td>
                                                <td>{{ $payment->payment_method ?? 'غير محدد' }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $payment->payment_status == 'مؤكدة' ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2 rounded-pill">
                                                        {{ $payment->payment_status ?? 'قيد المراجعة' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-file-earmark-pdf"></i> تحميل
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-3">لا توجد سجلات
                                                    مدفوعات حالية.</td>
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
</body>

</html>
