<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - كفالاتي السارية</title>
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
                                onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"alt=" "
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
                                    class="dropdown-item text-small text-danger text-right border-0 bg-transparent w-100"><i
                                        class="bi bi-box-arrow-right me-2"></i> خروج آمن</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Dashboard container -->
            <div class="dashboard-container">

                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.html"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">كفالات الأيتام</li>
                        </ol>
                    </nav>
                </div>

                @if (Session::has('success'))
                    {{-- تم تصحيح الكلاس إلى alert-success وتطوير التصميم بـ Bootstrap --}}
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 p-3 mb-4"
                        role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ Session::get('success') }} {{-- جلب نص الرسالة التي أرسلها الكنترولر --}}
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">
                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"> قائمة الأيتام
                                    المكفولين بمدرج التزامك</h5>
                                <a href=" {{ route('orphans') }}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-plus-circle me-1"></i> إضافة
                                    كفالة جديدة</a>
                            </div>

                            <!-- Table list -->
                            <div class="table-responsive">
                                <table class="table text-right" id="sponsor-orphans-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">اليتيم</th>
                                            <th scope="col">تاريخ البدء</th>
                                            <th scope="col">المستحقات الشهرية</th>
                                            <th scope="col">تاريخ آخر دفعة تم دفعها</th>
                                            <th scope="col">حالة الكفالة</th>
                                            <th scope="col" class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sponsorships as $info)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ asset('Uploads/orphans/' . ($info->orphan->personal_photo_path ?? 'default.png')) }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                                            class="rounded-circle shadow-xs" width="40"
                                                            height="40" style="object-fit:cover;">

                                                        <div>
                                                            <strong class="text-dark d-block text-small">
                                                                {{ $info->orphan?->name }}
                                                            </strong>
                                                            <span class="text-caption text-muted">
                                                                {{ $info->orphan?->country }} -
                                                                {{ $info->orphan?->city }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>{{ $info->start_date }}</td>

                                                <td>
                                                    <strong>$
                                                        {{ number_format($info->orphan->required_amount ?? ($info->amount_paid ?? ($info->amount ?? 0)), 2) }}</strong>
                                                    / شهر
                                                </td>

                                                <!-- عرض تاريخ آخر دفعة مسجلة لهذا اليتيم -->
                                                <td>{{ $info->last_batch ?? $info->created_at->format('Y-m-d') }}</td>

                                                <td>
                                                    <span class="badge-kanaf badge-active">
                                                        {{ $info->status ?? 'نشطة سارية' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('sponsorship_detail', $info->orphan_id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-eye"></i>
                                                            التفاصيل
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-inbox fs-3 d-block mb-2 text-secondary"></i>
                                                    لم يتم كفالة أي يتيم حتى الآن
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- شريط التنقل بين الصفحات والإحصائيات -->
                            <div class="d-flex justify-content-between align-items-center p-3 border-top bg-white"
                                style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">

                                <!-- النص التوضيحي باللغة العربية -->
                                <div class="text-secondary text-small fw-semibold">
                                    عرض
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                        {{ $sponsorships->firstItem() ?? 0 }}
                                    </span>
                                    إلى
                                    <span class="badge px-2 py-1 mx-1"
                                        style="background-color: #e8f5e9; color: #0f5b38; border: 1px solid #a3d9a5;">
                                        {{ $sponsorships->lastItem() ?? 0 }}
                                    </span>
                                    من أصل
                                    <span class="fw-bold text-dark mx-1">{{ $sponsorships->total() }}</span>
                                    كفيل مسجل
                                </div>

                                <!-- أزرار الصفحات بالاتجاه الصحيح (RTL) -->
                                @if ($sponsorships->hasPages())
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0 gap-1" style="direction: rtl;">

                                            {{-- زر الصفحة السابقة (السهم الأيمن) --}}
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

                                            {{-- أرقام الصفحات --}}
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
                                                        <a class="page-link shadow-none" href="{{ $url }}"
                                                            style="color: #0f5b38; background-color: #f8f9fa; border-color: #dce7e1; border-radius: 8px; font-weight: 600; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                                            {{ $page }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            {{-- زر الصفحة التالية (السهم الأيسر) --}}
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

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
