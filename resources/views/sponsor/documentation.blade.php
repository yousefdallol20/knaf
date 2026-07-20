<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - وثائق وتقارير الأيتام</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <style>
        #docTypeFilter .btn.active {
            background-color: #1E7E34;
            border-color: #1E7E34;
            color: #fff !important;
        }
    </style>
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

                <li class="menu-item">
                    <a href="{{ route('payments') }}">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>المدفوعات والاشتراكات</span>
                    </a>
                </li>

                <li class="menu-item active">
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

        <!-- Main Workspace Area -->
        <div class="main-content"><!-- Top header bar -->
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
                            <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}"
                                alt="رمز" class="rounded-circle" width="30" height="30"
                                style="object-fit: cover;">
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

            <div class="dashboard-container">

                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard_sponsor') }}"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">سجلات الوثائق والتقارير</li>
                        </ol>
                    </nav>
                </div>

                <!-- Filter bar -->
                <div
                    class="bg-white p-3 rounded-4 shadow-sm border mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted text-small fw-bold">تصنيف ونوع المستند:</span>
                        <div class="btn-group btn-group-sm" id="docTypeFilter">
                            <button class="btn btn-outline-primary active px-3 text-white" data-filter="all">عرض
                                الكل</button>
                            <button class="btn btn-outline-primary px-3" data-filter="Educational_Certificates"><i
                                    class="bi bi-book me-1"></i> دراسي
                                وتعليمي</button>
                            <button class="btn btn-outline-primary px-3" data-filter="Medical_reports"><i
                                    class="bi bi-heart-pulse me-1"></i> كشف طبي وصحي</button>
                        </div>
                    </div>
                    <span class="text-caption text-muted"><i class="bi bi-check-circle-fill text-success"></i> يتم
                        مراجعة وتوثيق
                        جميع التقارير حماية لخصوصية طفلك</span>
                </div>

                <div class="row g-4" id="docsContainer">
                    @foreach ($documents as $document)
                        <div class="col-lg-4 col-md-6 mb-4" data-category="{{ $document->doc_type }}">
                            <div class="kanaf-card bg-white h-100 p-4 border shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-success rounded-pill px-3 py-1">معتمد</span>
                                    <span class="text-muted small">{{ $document->date }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                                        style="width:50px;height:50px;background:#eef8f2;">
                                        <i class="bi bi-journal-check text-success fs-3"></i>
                                    </div>

                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $document->title }}</h6>
                                        <span class="text-primary-green fw-semibold">للطفل:
                                            {{ $document->orphan?->name }}</span>
                                    </div>
                                </div>

                                <p class="text-muted small">
                                    تم رفع التقرير ومراجعته واعتماده من قبل فريق كنف.
                                </p>

                                <div class="mt-4 border-top pt-3 d-flex justify-content-between">
                                    <span class="text-muted small">الحجم: 1.4 MB</span>
                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> تنزيل التقرير
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- رسالة تظهر لو مفيش نتائج بعد الفلترة -->
                <div class="text-center text-muted py-5 d-none" id="noResultsMsg">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    لا توجد وثائق ضمن هذا التصنيف حالياً
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterButtons = document.querySelectorAll('#docTypeFilter button');
            var cards = document.querySelectorAll('#docsContainer [data-category]');
            var noResultsMsg = document.getElementById('noResultsMsg');

            // [للفحص والتأكد] سيطبع لك في Console المتصفح هل عثر على العناصر أم لا
            console.log('تم العثور على أزرار عدد:', filterButtons.length);
            console.log('تم العثور على كروت عدد:', cards.length);

            filterButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {

                    // 1. تبديل كلاس النشط (active) بين الأزرار
                    filterButtons.forEach(function(b) {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');

                    var filterValue = this.getAttribute('data-filter').trim().toLowerCase();
                    var visibleCount = 0;

                    console.log('القسم المختار حالياً للفلترة:', filterValue);

                    // 2. المرور على الكروت وإظهارها أو إخفائها بقوة الـ !important
                    cards.forEach(function(card) {
                        var cardCategory = card.getAttribute('data-category');
                        cardCategory = cardCategory ? cardCategory.trim().toLowerCase() :
                            '';

                        // شرط مرن: يدعم كلمة all أو الكل، أو التطابق التام بين مخرج الداتابيز وقيمة الزر
                        var matches = (filterValue === 'all' || filterValue === 'الكل' ||
                            cardCategory === filterValue);

                        if (matches) {
                            card.style.setProperty('display', '', 'important');
                            visibleCount++;
                        } else {
                            card.style.setProperty('display', 'none', 'important');
                        }
                    });

                    // 3. التحكم في رسالة "لا توجد نتائج"
                    if (noResultsMsg) {
                        if (visibleCount === 0) {
                            noResultsMsg.classList.remove('d-none');
                        } else {
                            noResultsMsg.classList.add('d-none');
                        }
                    }
                });
            });
        });
    </script>


</body>

</html>
