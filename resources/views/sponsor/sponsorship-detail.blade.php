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
                <li class="menu-item">
                    <a href="{{ route('dashboard_sponsor') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>
                <li class="menu-item active">
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
                            <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/orphans/default.png') }}"
                                onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"alt="رمز"
                                class="rounded-circle" width="30" height="30" style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ $user->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile_sponser') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i> خروج آمن
                                </button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="dashboard-container">

                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_sponsor') }}"
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
                            $amountDisplay =
                                $orphan->required_amount ??
                                ($sponsorship->amount_paid ?? ($sponsorship->amount ?? 0.0));
                        @endphp

                        <!-- Left sidebar in detail workspace: Child core card -->
                        <div class="col-lg-4">
                            <div class="bg-white p-4 rounded-4 border shadow-sm text-center">
                                <img src="{{ asset('Uploads/orphans/' . ($orphan->personal_photo_path ?? 'default.png')) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                    alt="" class="img-fluid rounded-4 mb-3 border shadow-xs"
                                    style="max-height:250px;object-fit:cover;width:100%;">
                                <h4 class="fw-bold text-dark mb-1">
                                    {{ $orphan->name ?? 'غير محدد' }}
                                </h4>
                                <p class="text-muted text-small mb-4">
                                    <i class="bi bi-geo-alt-fill text-danger"></i>
                                    {{ $orphan->city ?? '' }} - {{ $orphan->country ?? '' }}
                                </p>

                                <div class="bg-light p-3 rounded-3 text-start mb-4">
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">العمر الحالي</span>
                                        <strong class="text-dark" id="detail-orphan-age">{{ $orphan->age ?? '-' }}
                                            سنوات</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">المرحلة التعليمية</span>
                                        <strong class="text-dark"
                                            id="detail-orphan-education">{{ $orphan->education_level ?? '-' }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 text-small">
                                        <span class="text-muted">الحالة الصحية</span>
                                        <strong class="text-dark"
                                            id="detail-orphan-health">{{ $orphan->health_status ?? '-' }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-0 text-small">
                                        <span class="text-muted">مبلغ الكفالة الشهري</span>
                                        <strong
                                            class="text-success fw-bold">${{ number_format($amountDisplay, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('step1', $orphan->id ?? $sponsorship->orphan_id) }}"
                                        class="btn btn-secondary fw-bold py-2">
                                        <i class="bi bi-wallet2 me-1"></i> سداد استحقاق الكفالة القادمة
                                    </a>
                                    <a href="{{ route('orphans_details', $orphan->id ?? $sponsorship->orphan_id) }}"
                                        id="btn-view-public" class="btn btn-outline-primary py-2 btn-sm">
                                        مشاهدة الملف التفصيلي
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right layout details: Tab contents of payments and reports -->
                        <div class="col-lg-8">
                            <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                                <h5 class="fw-bold text-dark mb-3">حكاية وقصة الطفل الكفيل</h5>
                                <p class="text-muted text-small lh-lg mb-0" style="text-align:justify;">
                                    {{ $orphan->story ?? 'لا توجد قصة مسجلة لهذا اليتيم حالياً.' }}
                                </p>
                            </div>

                            <!-- Tabs segment -->
                            <div class="bg-white p-4 rounded-4 border shadow-sm">
                                <!-- Tabs list -->
                                <ul class="nav nav-tabs mb-4" id="detailTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active text-small fw-semibold" id="tab-payments-btn"
                                            data-bs-toggle="tab" data-bs-target="#tab-payments" type="button"
                                            role="tab" aria-controls="tab-payments" aria-selected="true">
                                            <i class="bi bi-credit-card-fill me-1"></i> سجل المدفوعات للطفل
                                            ({{ $allPayments->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-small fw-semibold" id="tab-reports-btn"
                                            data-bs-toggle="tab" data-bs-target="#tab-reports" type="button"
                                            role="tab" aria-controls="tab-reports" aria-selected="false">
                                            <i class="bi bi-file-earmark-person-fill me-1"></i> وثائق وتقارير الوصي
                                            المعتمدة ({{ $documents->count() }})
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="detailTabsContent">
                                    <!-- 1️⃣ سجل جميع المدفوعات للطفل -->
                                    <div class="tab-pane fade show active" id="tab-payments" role="tabpanel"
                                        aria-labelledby="tab-payments-btn">
                                        <div class="table-responsive">
                                            <table class="table text-right text-small align-middle">
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
                                                    @forelse ($allPayments as $payment)
                                                        <tr>
                                                            <td>KNF-2026-{{ $payment->id }}</td>
                                                            <td>{{ $payment->last_batch ?? $payment->created_at->format('Y-m-d') }}
                                                            </td>
                                                            <td class="fw-bold text-success">
                                                                ${{ number_format($payment->amount_paid > 50 ? $payment->amount_paid : $sponsorship->orphan->required_amount, 2) }}
                                                            </td>
                                                            <td>
                                                                {{ $payment->payment_method == 'card' ? 'بطاقة إلكترونية' : ($payment->payment_method == 'bank_transfer' ? 'تحويل بنكي' : $payment->payment_method ?? 'بطاقة إلكترونية') }}
                                                            </td>
                                                            <td>
                                                                @if (in_array($payment->payment_status, ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة']))
                                                                    <span class="badge bg-success">مؤكدة</span>
                                                                @else
                                                                    <span class="badge bg-warning text-dark">قيد
                                                                        المراجعة</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-4 text-muted">لا
                                                                توجد عمليات دفع مسجلة لهذا الطفل حتى الآن.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 2️⃣ الوثائق والتقارير المعتمدة من الأدمن فقط -->
                                    <div class="tab-pane fade" id="tab-reports" role="tabpanel"
                                        aria-labelledby="tab-reports-btn">
                                        <div class="row g-3">
                                            @forelse($documents as $document)
                                                <div class="col-md-6">
                                                    <div class="bg-light p-3 rounded-3 border">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-success"><i
                                                                    class="bi bi-check-circle-fill me-1"></i> معتمد من
                                                                الإدارة</span>
                                                            <small
                                                                class="text-muted">{{ $document->created_at ? $document->created_at->format('Y-m-d') : '' }}</small>
                                                        </div>
                                                        <h6 class="mt-2 text-dark fw-bold">
                                                            @if (str_contains(strtolower($document->document_type ?? ''), 'صح') ||
                                                                    str_contains($document->document_type ?? '', 'طب'))
                                                                <i class="bi bi-heart-pulse-fill text-danger me-1"></i>
                                                            @else
                                                                <i
                                                                    class="bi bi-journal-bookmark-fill text-primary me-1"></i>
                                                            @endif
                                                            {{ $document->title ?? ($document->document_type ?? 'تقرير رسمي') }}
                                                        </h6>
                                                        <p class="text-muted text-caption mb-3">
                                                            المرفق:
                                                            {{ $document->description ?? 'وثيقة رسمية معتمدة خاصة بالطفل' }}
                                                        </p>
                                                        <a href="{{ asset($document->file_path ? (str_starts_with($document->file_path, 'Uploads/') ? $document->file_path : 'Uploads/document/' . $document->file_path) : '#') }}"
                                                            target="_blank"
                                                            class="btn btn-outline-primary btn-sm rounded-pill w-100">
                                                            <i class="bi bi-file-earmark-pdf"></i> استعراض التقرير
                                                            المعتمد
                                                        </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 text-center py-5">
                                                    <i class="bi bi-folder-x text-muted fs-1 d-block mb-2"></i>
                                                    <p class="text-muted mb-0">لا توجد وثائق أو تقارير اعتمدها الأدمن
                                                        لهذا الطفل حتى الآن.</p>
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

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
