<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - رفع التوثيق والتقارير</title>
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
                    <!-- <img src="assets/images/logo.png" alt="كنف" height="35"> -->
                    <h5 class="text-primary-green mb-0 fw-bold d-inline-block">لوحة تحكّم كَنَفْ</h5>
                    <button type="button" class="btn-close btn-close-white d-lg-none ms-auto"
                        aria-label="إغلاق القائمة"
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
                </div>

                <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                    <li class="menu-item" id="menu-dashboard">
                        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> الرئيسية</a>
                    </li>
                    <li class="menu-item" id="menu-children">
                        <a href="{{ route('children') }}"><i class="bi bi-people-fill"></i> الأطفال المسجلين</a>
                    </li>
                    <li class="menu-item active" id="menu-docs">
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
                    <h4 class="fw-bold mb-0 text-dark">تنزيل ورفع وثائق الأبناء وتحديثات الكافلين</h4>
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
                            <li class="breadcrumb-item"><a href="dashboard.html"
                                    class="text-primary-green text-decoration-none">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">رفع وثائق التتبع والتقارير</li>
                        </ol>
                    </nav>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">

                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-cloud-arrow-up text-primary-green me-1"></i> تحميل نموذج تتبع دراسي
                                وصحي لليتيم</h5>
                            <p class="text-muted text-small mb-4">يسعد المتبرع الكافل كثيراً برؤية نجاح وتفوق الأبناء
                                ومتابعة حالتهم
                                الصحية. تعبئة هذه النماذج بانتظام تضمن استدامة كفالته بكل سرور ومحبة.</p>

                            <form id="guardian-doc-form" class="needs-validation" novalidate
                                action="{{ route('upload_docs_store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">اختر الطفل اليتيم
                                            المعني بهذا التقرير</label>
                                        <select id="doc-child-select" name="orphan_id" class="form-select" required>
                                            <option value="" selected disabled>قم بتحديد الطفل المعني بالملفات :
                                            </option>
                                            @foreach ($orphan as $info)
                                                <option value="{{ $info->id }}">{{ $info->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">يرجى اختيار الطفل المعني.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">نوع المستند
                                            المرفق</label>
                                        <select id="doc-type-select" name="doc_type" class="form-select" required>
                                            <option value="" selected disabled>قم بتحديد نوع المستند :</option>
                                            <option value="Educational_Certificates">شهادة دراسية وتعليمية</option>
                                            <option value="Medical_reports">كشف وفحص طبي وصحي</option>
                                        </select>
                                        <div class="invalid-feedback">يرجى اختيار نوع المستند.</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">عنوان التتبع أو
                                            التوصيف المكتوب</label>
                                        <input type="text" id="doc-title-input" name="title"
                                            class="form-control"
                                            placeholder="مثال: شهادة تفوق الفصل الدراسي الثاني - ممتاز" required>
                                        <div class="invalid-feedback">يرجى وضع عنوان تقرير وصفي للاطلاع.</div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <label class="form-label text-small fw-semibold text-muted">إسقاط وتحميل ملف
                                            PDF أو الصور الملتقطة</label>

                                        <div class="p-5 border-dashed border-2 rounded-4 text-center cursor-pointer bg-light d-flex flex-column align-items-center justify-content-center"
                                            id="upload-drag-area"
                                            style="border-color: var(--primary-green); cursor: pointer;">
                                            <i
                                                class="bi bi-file-earmark-arrow-up-fill text-primary-green fs-1 d-block mb-3"></i>
                                            <h6 class="fw-bold mb-1">اسحب ملفات شهادة الطفل هنا أو اضغط للاستعراض</h6>
                                            <p class="text-caption text-muted mb-0">يرجى رفع ملفات PDF أو صور لا تتجاوز
                                                4 ميغابايت.</p>

                                            <input type="file" id="real-file-input" class="form-control mt-3"
                                                name="document" required>
                                        </div>
                                        <div id="file-name-indicator"
                                            class="mt-2 text-primary-green text-small text-center fw-bold d-none">
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-5 border-top pt-4 text-left">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">تقديم ومباشرة
                                        إرسال التقرير للمراجعة</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- Documentation instructions side-card list -->
                    <div class="col-lg-4">
                        <div class="bg-white p-4 rounded-4 border shadow-sm">
                            <h5 class="fw-bold text-dark mb-3">إرشادات توثيق كنف</h5>

                            <ul class="d-flex flex-column gap-3 list-unstyled text-small text-muted mb-0">
                                <li class="d-flex gap-2">
                                    <i class="bi bi-award-fill text-secondary-gold"></i>
                                    <div>
                                        <strong>تفوق وتقدير الدراسي:</strong><br>
                                        يرجى الحرص على تصوير كشف الدرجات من الإدارة المدرسية المعتمدة (الأونروا / وزارة
                                        التربية والتعليم)
                                        وإرفاقه كل نهاية فصل دراسي.
                                    </div>
                                </li>
                                <li class="d-flex gap-2">
                                    <i class="bi bi-heart-pulse-fill text-danger"></i>
                                    <div>
                                        <strong>وثيقة الحالة الصحية واللقاحات:</strong><br>
                                        في حال مراجعة العيادات بشكل مبرر، يفضل تزويد منصتنا بتقرير الطبيب المعتمد لدفع
                                        مستحقات العناية
                                        الإضافية.
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
