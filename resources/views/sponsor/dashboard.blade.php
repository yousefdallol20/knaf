<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - الرئيسية</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
            <div class="brand">
                <h5 class="text-primary-green mb-0 fw-bold d-inline-block">
                    لوحة تحكّم كَنَفْ
                </h5>
                <button type="button" class="btn-close btn-close-white d-lg-none ms-auto" aria-label="إغلاق القائمة"
                    onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show');"></button>
            </div>

            <ul class="sidebar-menu flex-grow-1">
                <li class="menu-item active">
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
                <li class="menu-item">
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
                <a href="{{ route('knaf') }}"
                    class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-pill">
                    <i class="bi bi-arrow-right-short fs-5"></i>
                    <span>العودة للرئيسية</span>
                </a>
            </div>
        </div>

        <!-- Main Content Panel -->
        <div class="main-content">
            <!-- Top header -->
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
                            <img src="{{ $sponsor && $sponsor->image ? asset('Uploads/sponsors/' . $sponsor->image) : asset('assets/images/Default.png') }}"
                                alt="User Photo" class="rounded-circle" width="30" height="30"
                                style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ $user->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile_sponser') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i> خروج آمن
                                </button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dashboard Container Contents -->
            <div class="dashboard-container">
                <!-- Banner -->
                <div class="bg-primary-green text-white p-4 p-md-5 rounded-4 shadow-sm mb-4"
                    style="background: linear-gradient(135deg, var(--primary-green) 0%, #114b2d 100%);">
                    <div class="max-w-xl">
                        <h2 class="fw-bold mb-2">تقبّل الله طاعتكم وجزاكم خيراً، أ. {{ $user->name }}</h2>
                        <p class="mb-0 text-white-50">مرحباً بك مجدداً في لوحة المتابعة الشاملة لليتامى المكفولين تحت اسمك الكريم.</p>
                    </div>
                </div>

                <!-- Metrics cards row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>{{ $sponsorships->count() }}</h3>
                                <p>كفالات أيتام نشطة</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>$ {{ number_format($totalPaid, 2) }}</h3>
                                <p>إجمالي المدفوعات الخيرية</p>
                            </div>
                            <div class="stats-card-icon bg-warning-subtle text-warning">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>$ {{ number_format($monthlySupportAmount, 2) }}</h3>
                                <p>مبلغ الدعم الشهري</p>
                            </div>
                            <div class="stats-card-icon bg-info-subtle text-info">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Layout Grid: Chart & Active Orphans -->
                <div class="row g-4">
                    <!-- Chart Section -->
                    <div class="col-lg-7">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <h5 class="fw-bold mb-4 text-dark">
                                <i class="bi bi-bar-chart-line-fill text-primary-green me-2"></i> سجل المساهمة الشهرية عبر كنف
                            </h5>
                            <div style="height: 300px; position: relative;">
                                <canvas id="payment-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Active Orphans Section -->
                    <div class="col-lg-5">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 text-dark">
                                    <i class="bi bi-people-fill text-primary-green me-2"></i> كفالاتي السارية
                                </h5>
                                <a href="{{ route('sponsorships') }}" class="text-caption text-primary-green text-decoration-none">
                                    عرض الكل <i class="bi bi-chevron-left text-small align-middle"></i>
                                </a>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                @forelse($sponsorships as $sponsorship)
                                    @if ($sponsorship->orphan)
                                        <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded-3 border">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $sponsorship->orphan->personal_photo_path ? asset('Uploads/orphans/' . $sponsorship->orphan->personal_photo_path) : asset('assets/images/Default.png') }}"
                                                    class="rounded-circle shadow-xs" width="45" height="45" style="object-fit:cover;">
                                                <div>
                                                    <h6 class="fw-bold mb-1 text-dark text-small">{{ $sponsorship->orphan->name }}</h6>
                                                    <span class="text-muted text-small d-block">
                                                        <i class="bi bi-calendar3"></i> العمر: {{ $sponsorship->orphan->age ?? 'غير محدد' }} سنوات
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('sponsorship_detail', $sponsorship->orphan_id) }}" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
                                                التفاصيل
                                            </a>
                                        </div>
                                    @endif
                                @empty
                                    <p class="text-muted text-center py-4">لا توجد كفالات نشطة حالياً.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- تشغيل Chart.js ورسم البيانات من لارافيل -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('payment-chart').getContext('2d');

            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartData) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'مبلغ المساهمة ($)',
                        data: data,
                        backgroundColor: '#1E7548',
                        borderColor: '#114b2d',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
