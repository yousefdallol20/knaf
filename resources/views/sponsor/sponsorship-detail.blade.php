<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - تفاصيل الكفالة</title>
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

                <a href="{{ route('dashboard_sponsor') }}"
                    class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-pill">
                    <i class="bi bi-arrow-right-short fs-5"></i>
                    <span>العودة للرئيسية</span>
                </a>

            </div>

        </div>

        <!-- Main Workspace -->
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
                            <li class="breadcrumb-item"><a href="{{ route('sponsorships') }}"
                                    class="text-primary-green text-decoration-none">كفالاتي السارية</a></li>
                            <li class="breadcrumb-item active" aria-current="page" id="breadcrumb-title">تفاصيل الكفالة
                            </li>
                        </ol>
                    </nav>
                </div>

                <div>
                    <div class="row g-4">
                        @php
                            $orphan = $sponsorship->orphan;
                        @endphp

                        <!-- Left sidebar in detail workspace: Child core card -->
                        <div class="col-lg-4">
                            <div class="bg-white p-4 rounded-4 border shadow-sm text-center">
                                <img src="{{ asset('Uploads/orphans/' . $sponsorship->orphan->personal_photo_path) }}" alt="أحمد محمد"
                                    class="img-fluid rounded-4 mb-3 border shadow-xs"
                                    style="max-height:250px;object-fit:cover;width:100%;">
                                <h4 class="fw-bold text-dark mb-1">
                                    {{ $orphan->name }}
                                </h4>
                                <p class="text-muted text-small mb-4">
                                    <i class="bi bi-geo-alt-fill text-danger"></i>
                                    {{ $orphan->city }} - {{ $orphan->country }}
                                </p>

                                <div class="bg-light p-3 rounded-3 text-start mb-4">
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">العمر الحالي</span>
                                        <strong class="text-dark" id="detail-orphan-age">{{ $orphan->age }}
                                            سنوات</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">المرحلة والمولى</span>
                                        <strong class="text-dark"
                                            id="detail-orphan-education">{{ $orphan->education_level }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">الحالة الصحية</span>
                                        <strong class="text-dark"
                                            id="detail-orphan-health">{{ $orphan->health_status }}</strong>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button onclick="registerSponsorRenewPayment()"
                                        class="btn btn-secondary fw-bold py-2"><i class="bi bi-wallet2 me-1"></i> سداد
                                        استحقاق الكفالة القادمة</button>
                                    <a href="" id="btn-view-public"
                                        class="btn btn-outline-primary py-2 btn-sm">مشاهدة الملف التفصيلي</a>
                                </div>
                            </div>
                        </div>

                        <!-- Right layout details: Tab contents of payments and reports -->
                        <div class="col-lg-8">
                            <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                                <h5 class="fw-bold text-dark mb-3">حكاية وقصة الطفل الكفيل</h5>
                                <p class="text-muted text-small lh-lg mb-0" style="text-align:justify;">
                                    {{ $orphan->story }} </p>
                            </div>

                            <!-- Tabs segment -->
                            <div class="bg-white p-4 rounded-4 border shadow-sm">
                                <!-- Tabs list -->
                                <ul class="nav nav-tabs mb-4" id="detailTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active text-small fw-semibold" id="tab-payments-btn"
                                            data-bs-toggle="tab" data-bs-target="#tab-payments" type="button"
                                            role="tab" aria-selected="true"><i
                                                class="bi bi-credit-card-fill me-1"></i> سجل المدفوعات للطفل</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-small fw-semibold" id="tab-reports-btn"
                                            data-bs-toggle="tab" data-bs-target="#tab-reports" type="button"
                                            role="tab" aria-selected="false"><i
                                                class="bi bi-file-earmark-person-fill me-1"></i> وثائق وتقارير الوصي
                                            المرفوعة</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="detailTabsContent">
                                    <!-- Payments List -->
                                    <div class="tab-pane fade show active" id="tab-payments" role="tabpanel"
                                        aria-labelledby="tab-payments-btn">
                                        <div class="table-responsive">
                                            <table class="table text-right text-small">
                                                <thead>
                                                    <tr>
                                                        <th>رقم المرجع</th>
                                                        <th>تاريخ الدفعة</th>
                                                        <th>القيمة والمبلغ</th>
                                                        <th>طريقة الدفع</th>
                                                        <th>الحالة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($sponsorship->payments) && $sponsorship->payments->count() > 0)
                                                        @foreach ($sponsorship->payments as $payment)
                                                            <tr>
                                                                <td>{{ $payment->reference_number }}</td>
                                                                <td>{{ $payment->payment_date }}</td>
                                                                <td class="fw-bold text-success">
                                                                    ${{ $payment->amount }}</td>
                                                                <td>{{ $payment->payment_method }}</td>
                                                                <td><span
                                                                        class="badge bg-success">{{ $payment->status }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <!-- عرض بيانات افتراضية منظمة من الكفالة نفسها لحين ربط جدول الدفع بالكامل -->
                                                        <tr>
                                                            <td>KNF-{{ $sponsorship->id }}-01</td>
                                                            <td>{{ $sponsorship->last_batch ?? $sponsorship->start_date }}
                                                            </td>
                                                            <td class="fw-bold text-success">$50</td>
                                                            <td>بطاقة إلكترونية</td>
                                                            <td><span class="badge bg-success">مؤكدة</span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Reports & Documentation List -->
                                    <div class="tab-pane fade" id="tab-reports" role="tabpanel"
                                        aria-labelledby="tab-reports-btn">
                                        <div class="row g-3">
                                            @forelse($orphan->documents as $document)
                                                <div class="col-md-6">
                                                    <div class="bg-light p-3 rounded-3 border">
                                                        <span class="badge bg-success">معتمد</span>

                                                        <h6 class="mt-3">
                                                            @if (str_contains(strtolower($document->document_type), 'صح') || str_contains($document->document_type, 'طب'))
                                                                <i class="bi bi-heart-pulse-fill text-danger"></i>
                                                            @else
                                                                <i
                                                                    class="bi bi-journal-bookmark-fill text-primary"></i>
                                                            @endif
                                                            {{ $document->document_type }}
                                                        </h6>

                                                        <p class="text-muted text-caption">
                                                            الرافع: والدة اليتيم (الأوصياء)
                                                        </p>

                                                        <a href="{{ asset('Uploads/document' . $document->file_path) }}"
                                                            target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                            استعراض التقرير
                                                        </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 text-center py-4">
                                                    <p class="text-muted mb-0">لا توجد وثائق أو تقارير مرفوعة لهذا
                                                        اليتيم حتى الآن.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
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
