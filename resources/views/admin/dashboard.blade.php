<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الإدارة - الرئيسية الشاملة</title>
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
                <!-- <img src="assets/images/logo.png" alt="كنف" height="35"> -->
                <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                <button type="button" class="btn-close btn-close-white d-lg-none ms-auto" aria-label="إغلاق القائمة"
                    onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
            </div>

            <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                <li class="menu-item active" id="menu-dashboard">
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
                    <a href="{{ route('admin.permissions.index') }}"><i class="bi bi-key-fill"></i> الصلاحيات والأدوار</a>
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

            <!-- Back to main public site link -->
            <div class="p-3 border-top mt-auto">
                <a href="{{ route('dashboard_admin') }}"
                    class="btn btn-outline-primary w-full d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-arrow-right-short fs-5"></i>
                    <span>العودة للرئيسية</span>
                </a>
            </div>
        </div>

        <!-- Backdrop overlay shown behind the sidebar on tablets/phones -->
        <div class="sidebar-backdrop" id="kanaf-sidebar-backdrop"
            onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); this.classList.remove('show');">
        </div>

        <!-- Main Workspace -->
        <div class="main-content">

            <div class="dashboard-header">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-lg-none" type="button"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.toggle('show'); document.getElementById('kanaf-sidebar-backdrop').classList.toggle('show');">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="fw-bold mb-0 text-dark">لوحة الإدارة والمراقبة والضبط لكبار المنسقين</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../assets/images/admin.jpg" alt="رمز" class="rounded-circle"
                                width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">أ. عبد الرحمن البكري</span>
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

                <div class="bg-primary-green text-white p-4 p-md-5 rounded-4 shadow-sm mb-4"
                    style="background: linear-gradient(135deg, var(--primary-green) 0%, #0d381c 100%);">
                    <div class="max-w-xl">
                        <h2 class="fw-bold mb-2">مرحباً بك في غرفة عمليات كنف لادارة ومراقبة الكفالة</h2>
                        <p class="mb-0 text-white-50">هنا نتحكم بالصلاحيات الكاملة، نراجع وثائق الأمهات والأوصياء، ننسق
                            شحنات الدفع،
                            وندقق في حالة كفالات الأبناء الأيتام لضمان سلامتهم وتلبية احتياجاتهم المعتمدة.</p>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>245</h3>
                                <p>إجمالي الأيتام المسجلين</p>
                            </div>
                            <div class="stats-card-icon bg-success-subtle text-success">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>187</h3>
                                <p>كفالات سارية ونشطة</p>
                            </div>
                            <div class="stats-card-icon bg-info-subtle text-info">
                                <i class="bi bi-heart-fill text-danger text-opacity-100"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>$ 6,200</h3>
                                <p>حوالات دفعات يونيو</p>
                            </div>
                            <div class="stats-card-icon bg-warning-subtle text-warning">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card">
                            <div class="stats-card-info">
                                <h3>58</h3>
                                <p>أيتام بانتظار الكفلاء</p>
                            </div>
                            <div class="stats-card-icon bg-danger-subtle text-danger">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts grid -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <h5 class="fw-bold text-dark mb-4"><i
                                    class="bi bi-bar-chart-line-fill text-primary-green me-1"></i> حركة
                                الكفالات والواردات الشهرية ($)</h5>
                            <div style="height: 300px;">
                                <canvas id="admin-payments-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                            <h5 class="fw-bold text-dark mb-4"><i
                                    class="bi bi-pie-chart-fill text-primary-green me-1"></i> توزيع
                                كفالات منظومة كنف</h5>
                            <div style="height: 300px;">
                                <canvas id="admin-distribution-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">
                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold mb-0 text-dark"><i
                                        class="bi bi-clock-history me-1 text-primary-green"></i> آخر
                                    العمليات وسجلات الحسابات المباشرة</h5>
                                <a href="{{ route('audit_admin') }}" class="btn btn-outline-primary btn-sm">عرض كل
                                    سجل العمليات</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>معرف السجل</th>
                                            <th>العضو / الفاعل</th>
                                            <th>العملية المنفذة</th>
                                            <th>التفاصيل ومستند الإسناد</th>
                                            <th>توقيت وتاريخ العملية</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-monospace">LOG-801</td>
                                            <td class="fw-semibold text-dark">أدمن النظام</td>
                                            <td><span
                                                    class="badge bg-light text-dark text-small px-2 py-1 border">اعتماد
                                                    كفالة</span></td>
                                            <td class="text-muted">اعتماد كفالة #303 لليتيم محمود أبو العوف</td>
                                            <td>2026-06-07 08:30</td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">LOG-802</td>
                                            <td class="fw-semibold text-dark">عبد الرحمن البكري (كافل)</td>
                                            <td><span
                                                    class="badge bg-light text-dark text-small px-2 py-1 border">تسجيل
                                                    دفعة</span></td>
                                            <td class="text-muted">تسجيل دفعة كفالة لليتيم يوسف الكفارنة بقيمة 80 دولار
                                            </td>
                                            <td>2026-06-06 20:15</td>
                                        </tr>
                                        <tr>
                                            <td class="font-monospace">LOG-803</td>
                                            <td class="fw-semibold text-dark">سلوى الكفارنة (وصي)</td>
                                            <td><span
                                                    class="badge bg-light text-dark text-small px-2 py-1 border">تحديث
                                                    ملف طفل</span></td>
                                            <td class="text-muted">تحديث تقرير المدرسة لليتيم يوسف الكفارنة</td>
                                            <td>2026-06-05 14:22</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Payments Chart
            const paymentsCtx = document.getElementById('admin-payments-chart').getContext('2d');
            new Chart(paymentsCtx, {
                type: 'bar',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                    datasets: [{
                        label: 'الواردات ($)',
                        data: [4200, 4800, 5100, 5600, 5900, 6200],
                        backgroundColor: 'rgba(27, 107, 58, 0.7)',
                        borderColor: '#1B6B3A',
                        borderWidth: 1,
                        borderRadius: 6
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
                                callback: v => '$' + v
                            }
                        }
                    }
                }
            });

            // Distribution Chart
            const distCtx = document.getElementById('admin-distribution-chart').getContext('2d');
            new Chart(distCtx, {
                type: 'doughnut',
                data: {
                    labels: ['كفالات نشطة', 'بانتظار كفيل', 'موقوفة'],
                    datasets: [{
                        data: [187, 58, 0],
                        backgroundColor: ['#1B6B3A', '#F5A623', '#dc3545'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
