<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - المدفوعات الواردة</title>
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
                    <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                    <button type="button" class="btn-close btn-close-white d-lg-none ms-auto"
                        aria-label="إغلاق القائمة"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show');"></button>
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
                    <li class="menu-item active" id="menu-payments">
                        <a href="{{ route('received_payments') }}"><i class="bi bi-cash-stack"></i> الدفعات الواردة</a>
                    </li>
                    <li class="menu-item" id="menu-notifications">
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
        </div>

        <div class="main-content">

            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show')">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">كشف مستحقات وحوالات الدعم العائلية</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
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

                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">الحوالات الواردة</li>
                        </ol>
                    </nav>
                </div>

                <!-- الإحصائيات الديناميكية -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>$ {{ number_format($totalReceived ?? 0, 2) }}</h3>
                                <p>إجمالي مبالغ كفالة رعاية الأسرة المحصلة</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-gift-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>{{ $paymentsCount ?? 0 }} حوالات</h3>
                                <p>حوالات بنكية مكتملة التسليم</p>
                            </div>
                            <div class="stats-card-icon bg-info-subtle text-info">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- جدول الدفعات الواردة الحقيقي -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div
                                class="kanaf-table-header bg-white d-flex justify-content-between align-items-center p-3">
                                <h5 class="fw-bold text-dark mb-0">
                                    <i class="bi bi-wallet2 text-primary-green me-1"></i> أرشيف سدادات الحوالات
                                    المستحقة للأيتام
                                </h5>
                                <a href="{{ route('guardian.notifications') }}"
                                    class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-ticket-detailed"></i> طلب تدقيق حوالة مفقودة
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>معرف الدفعة المالي</th>
                                            <th>الطفل المستفيد</th>
                                            <th>مبلغ الدعم الوارد</th>
                                            <th>تاريخ التحويل المصرفي</th>
                                            <th>طريقة / وسيلة الاستلام</th>
                                            <th>الحالة وعملية البنك</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payments as $payment)
                                            <tr>
                                                <!-- معرف الدفعة المالي -->
                                                <td class="font-monospace">
                                                    {{ $payment->transaction_id ?? ($payment->bank_reference_number ?? 'PAY-' . date('Y') . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT)) }}
                                                </td>

                                                <td>اليتيم:
                                                    <strong>{{ $payment->orphan->name ?? ($payment->orphan->first_name ?? 'غير محدد') }}</strong>
                                                </td>

                                                <!-- مبلغ الدعم الوارد -->
                                                <td class="fw-bold text-success">
                                                    {{ number_format($payment->amount_paid, 0) }} $
                                                </td>

                                                <!-- تاريخ التحويل المصرفي -->
                                                <td>{{ $payment->start_date ?? ($payment->created_at ? $payment->created_at->format('Y-m-d') : '—') }}
                                                </td>

                                                <!-- وسيلة الاستلام -->
                                                <td>
                                                    @if ($payment->payment_method == 'card')
                                                        بطاقة ائتمان
                                                    @elseif($payment->payment_method == 'bank_transfer')
                                                        تحويل بنكي
                                                    @else
                                                        حساب الوصي البنكي
                                                    @endif
                                                </td>

                                                <!-- الحالة وعملية البنك -->
                                                <td>
                                                    @if ($payment->payment_status == 'paid')
                                                        <span
                                                            class="badge bg-success px-3 py-1 rounded-pill text-small">تم
                                                            التحويل والإيداع</span>
                                                    @elseif($payment->payment_status == 'pending')
                                                        <span
                                                            class="badge bg-warning text-dark px-3 py-1 rounded-pill text-small">قيد
                                                            المعالجة والتدقيق</span>
                                                    @else
                                                        <span
                                                            class="badge bg-danger px-3 py-1 rounded-pill text-small">فشلت
                                                            / ملغاة</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">لا توجد حوالات
                                                    أودعت بحساب الأطفال حالياً.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if (isset($payments) && method_exists($payments, 'hasPages') && $payments->hasPages())
                                <div class="p-3 bg-light border-top">
                                    {{ $payments->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
