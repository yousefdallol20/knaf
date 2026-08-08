<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - الأطفال المسجلين</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <style>
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
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
                        onclick="document.getElementById('kanaf-sidebar-wrapper').classList.remove('show'); document.getElementById('kanaf-sidebar-backdrop').classList.remove('show');"></button>
                </div>

                <ul class="sidebar-menu flex-grow-1" id="dynamic-menu-list">
                    <li class="menu-item" id="menu-dashboard">
                        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> الرئيسية</a>
                    </li>
                    <li class="menu-item active" id="menu-children">
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
                    <h4 class="fw-bold mb-0 text-dark">الأطفال والأبناء المسجلين</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">ملفات الأبناء</li>
                        </ol>
                    </nav>
                </div>

                {{-- 1. عرض رسالة النجاح --}}
                @if (Session::has('success'))
                    {{-- تم تصحيح الكلاس إلى alert-success وتطوير التصميم بـ Bootstrap --}}
                    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 p-3 mb-4"
                        role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ Session::get('success') }} {{-- جلب نص الرسالة التي أرسلها الكنترولر --}}
                    </div>
                @endif

                {{-- 2. عرض رسالة الخطأ القادمة من السيرفر (Catch Exception) --}}
                @if ($errors->has('error'))
                    {{-- تم تعديل الكلمة إلى 'error' لتطابق ما يرسله الكنترولر --}}
                    {{-- تم تصحيح الكلاس إلى alert-danger --}}
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 p-3 mb-4"
                        role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first('error') }} {{-- جلب نص الخطأ التقني القادم من السيرفر --}}
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-12">
                        <div class="kanaf-table-card">

                            <div class="kanaf-table-header bg-white">
                                <h5 class="fw-bold text-dark mb-0"><i
                                        class="bi bi-people-fill me-1 text-primary-green"></i> سجل الأطفال
                                    الأيتام التابع لعائلتك</h5>
                                <a href="{{ route('child_form') }}" class="btn btn-primary btn-sm"><i
                                        class="bi bi-plus-circle me-1"></i> إضافة
                                    طفل جديد إلى السجل</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table text-right text-small">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم وجنس الطفل اليتيم</th>
                                            <th>العمر الحالي</th>
                                            <th>المرحلة الدراسية</th>
                                            <th>مستلزمات الدعم المطلوبة</th>
                                            <th>حالة الدعم / الكفالة</th>
                                            <th class="text-center">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orphan as $info)
                                            <tr>
                                                <td class="fw-bold text-muted">#{{ $info->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div>
                                                            <strong
                                                                class="text-dark d-block text-small">{{ $info->name }}</strong>
                                                            <span class="text-caption text-muted">{{ $info->gender }}
                                                                | {{ $info->orphan_location_status }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $info->age }} سنة</td>
                                                <td>{{ $info->education_level }}</td>
                                                <td class="fw-bold text-success">$ {{ $info->required_amount }}
                                                    /شهرياً</td>
                                                <td>
                                                    @if ($info->status == 'بانتظار القبول')
                                                        <span class="badge bg-warning text-dark"><i
                                                                class="bi bi-clock-history me-1"></i> بانتظار
                                                            القبول</span>
                                                    @elseif($info->status == 'مرفوض')
                                                        <span class="badge bg-danger"><i
                                                                class="bi bi-x-circle me-1"></i> تم الرفض</span>
                                                    @elseif($info->status == 'مكفول')
                                                        <span class="badge bg-success"><i
                                                                class="bi bi-check-circle me-1"></i>
                                                            {{ $info->status }}</span>
                                                    @elseif($info->status == 'بانتظار الكفالة')
                                                        <span class="badge-kanaf badge-pending"><i
                                                                class="bi bi-check-circle me-1"></i>
                                                            {{ $info->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="#" class="btn btn-outline-secondary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal-child-{{ $info->id }}"><i
                                                                class="bi bi-eye"></i> تفاصيل</a>
                                                        <a href="{{ route('children.edit', $info->id) }}"
                                                            class="btn btn-outline-primary btn-sm"><i
                                                                class="bi bi-pencil-square"></i> تعديل البيانات</a>
                                                        <form action="{{ route('children.destroy', $info->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا اليتيم وكافة بياناته المرتبطة؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-sm"><i
                                                                    class="bi bi-trash"></i> شطب</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($orphan as $info)
        <div class="modal fade" id="modal-child-{{ $info->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-person-vcard me-2"></i>تفاصيل اليتيمة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="text-center mb-4">
                                <div><img src="{{ asset('Uploads/orphans/' . $info->personal_photo_path) }}"
                                        style="width:100px;height:100px;font-size:32px;border-radius: 100%">
                                </div>
                                <h4 class="fw-bold">{{ $info->name }}</h4>
                                <span>
                                    @if ($info->status == 'بانتظار القبول')
                                        <span class="badge bg-warning text-dark"><i
                                                class="bi bi-clock-history me-1"></i> بانتظار
                                            القبول</span>
                                    @elseif($info->status == 'مرفوض')
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> تم
                                            الرفض</span>
                                    @elseif($info->status == 'مكفول')
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>
                                            {{ $info->status }}</span>
                                    @elseif($info->status == 'بانتظار الكفالة')
                                        <span class="badge-kanaf badge-pending"><i
                                                class="bi bi-check-circle me-1"></i>
                                            {{ $info->status }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light fw-bold">بيانات اليتيم</div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">رقم التعريف</th>
                                                    <td>#{{ $info->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>الاسم</th>
                                                    <td>{{ $info->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>العمر</th>
                                                    <td>{{ $info->age }} سنة</td>
                                                </tr>
                                                <tr>
                                                    <th>الجنس</th>
                                                    <td>{{ $info->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <th>البلد</th>
                                                    <td>{{ $info->country }}</td>
                                                </tr>
                                                <tr>
                                                    <th>المدينة</th>
                                                    <td>{{ $info->city }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light fw-bold">الحالة التعليمية والصحية</div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="40%">الحالة التعليمية</th>
                                                    <td>{{ $info->education_level }}</td>
                                                </tr>
                                                <tr>
                                                    <th>الحالة الصحية</th>
                                                    <td>{{ $info->health_status }}</td>
                                                </tr>
                                                <tr>
                                                    <th>التقييم</th>
                                                    <td>5/5</td>
                                                </tr>
                                                <tr>
                                                    <th>رقم العائلة</th>
                                                    <td>103</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light fw-bold">بيانات الكفالة</div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th width="25%">المبلغ الشهري</th>
                                                    <td>$ {{ $info->required_amount }} </td>
                                                </tr>
                                                <tr>
                                                    <th>حالة الكفالة</th>
                                                    <td>{{ $info->status }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light fw-bold">قصة اليتيم</div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $info->story }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ===== قسم الشهادات والوثائق ===== -->
                                <!-- ===== قسم الشهادات والوثائق ===== -->
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm">
                                        <div
                                            class="card-header bg-light fw-bold d-flex justify-content-between align-items-center">
                                            <span><i class="bi bi-folder2-open me-2 text-primary-green"></i>الشهادات
                                                والوثائق الرسمية المرفوعة</span>
                                            <a href="{{ route('upload_docs', ['id' => $info->id]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-cloud-arrow-up me-1"></i> رفع مستند جديد
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">

                                                {{-- 1. شهادة ميلاد الطفل --}}
                                                @if ($info->birth_certificate_path)
                                                    <div class="col-md-4">
                                                        <div
                                                            class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="p-2 bg-info-subtle text-info rounded-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-file-earmark-person fs-5"></i>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="fw-bold text-small mb-0 text-truncate">
                                                                        شهادة ميلاد الطفل</p>
                                                                    <span class="text-caption text-muted">مستند رسمي
                                                                        أولي</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-auto">
                                                                <a href="{{ asset('Uploads/certificates/' . $info->birth_certificate_path) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-success btn-sm flex-grow-1">
                                                                    <i class="bi bi-eye me-1"></i> عرض
                                                                </a>
                                                                <a href="{{ asset('Uploads/certificates/' . $info->birth_certificate_path) }}"
                                                                    download
                                                                    class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                    <i class="bi bi-download me-1"></i> تحميل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- 2. صك الوصاية القانوني --}}
                                                @if ($info->guardian && $info->guardian->legal_guardianship_document)
                                                    <div class="col-md-4">
                                                        <div
                                                            class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="p-2 bg-warning-subtle text-warning rounded-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-file-earmark-text fs-5"></i>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="fw-bold text-small mb-0 text-truncate">صك
                                                                        الوصاية الشرعي</p>
                                                                    <span class="text-caption text-muted">مستند قانوني
                                                                        للوصي</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-auto">
                                                                <a href="{{ asset('Uploads/guardians/' . $info->guardian->legal_guardianship_document) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-success btn-sm flex-grow-1">
                                                                    <i class="bi bi-eye me-1"></i> عرض
                                                                </a>
                                                                <a href="{{ asset('Uploads/guardians/' . $info->guardian->legal_guardianship_document) }}"
                                                                    download
                                                                    class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                    <i class="bi bi-download me-1"></i> تحميل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- 3. صورة هوية الوصي --}}
                                                @if ($info->guardian && $info->guardian->guardian_id_image)
                                                    <div class="col-md-4">
                                                        <div
                                                            class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="p-2 bg-primary-subtle text-primary rounded-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-card-heading fs-5"></i>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="fw-bold text-small mb-0 text-truncate">
                                                                        بطاقة هوية الوصي</p>
                                                                    <span class="text-caption text-muted">إثبات
                                                                        شخصية</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-auto">
                                                                <a href="{{ asset('Uploads/guardians/' . $info->guardian->guardian_id_image) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-success btn-sm flex-grow-1">
                                                                    <i class="bi bi-eye me-1"></i> عرض
                                                                </a>
                                                                <a href="{{ asset('Uploads/guardians/' . $info->guardian->guardian_id_image) }}"
                                                                    download
                                                                    class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                    <i class="bi bi-download me-1"></i> تحميل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- 4. شهادة وفاة الأب --}}
                                                @if ($info->parents && $info->parents->death_certificate)
                                                    <div class="col-md-4">
                                                        <div
                                                            class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="p-2 bg-danger-subtle text-danger rounded-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-file-earmark-x fs-5"></i>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="fw-bold text-small mb-0 text-truncate">
                                                                        شهادة وفاة الأب</p>
                                                                    <span class="text-caption text-muted">مستند إثبات
                                                                        اليتم</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-auto">
                                                                <a href="{{ asset('Uploads/parents/' . $info->parents->death_certificate) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-success btn-sm flex-grow-1">
                                                                    <i class="bi bi-eye me-1"></i> عرض
                                                                </a>
                                                                <a href="{{ asset('Uploads/parents/' . $info->parents->death_certificate) }}"
                                                                    download
                                                                    class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                    <i class="bi bi-download me-1"></i> تحميل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- 5. شهادة وفاة الأم (إن وجدت) --}}
                                                @if ($info->parents && $info->parents->mother_death_certificate)
                                                    <div class="col-md-4">
                                                        <div
                                                            class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="p-2 bg-danger-subtle text-danger rounded-2 d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="bi bi-file-earmark-x fs-5"></i>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="fw-bold text-small mb-0 text-truncate">
                                                                        شهادة وفاة الأم</p>
                                                                    <span class="text-caption text-muted">مستند إثبات
                                                                        اليتم</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex gap-2 mt-auto">
                                                                <a href="{{ asset('Uploads/parents/' . $info->parents->mother_death_certificate) }}"
                                                                    target="_blank"
                                                                    class="btn btn-outline-success btn-sm flex-grow-1">
                                                                    <i class="bi bi-eye me-1"></i> عرض
                                                                </a>
                                                                <a href="{{ asset('Uploads/parents/' . $info->parents->mother_death_certificate) }}"
                                                                    download
                                                                    class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                    <i class="bi bi-download me-1"></i> تحميل
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                {{-- 6. التقارير والشهادات الإضافية من جدول documents --}}
                                                {{-- 6. التقارير والشهادات الإضافية المقبولة فقط من الأدمن --}}
                                                @foreach ($document as $documents)
                                                    @if ($documents->orphan_id == $info->id && $documents->status == 'مقبول')
                                                        @php
                                                            $ext = pathinfo($documents->file_path, PATHINFO_EXTENSION);
                                                            $isImage = in_array(strtolower($ext), [
                                                                'png',
                                                                'jpg',
                                                                'jpeg',
                                                                'gif',
                                                                'webp',
                                                            ]);
                                                        @endphp
                                                        <div class="col-md-4">
                                                            <div
                                                                class="border rounded-3 p-3 bg-light d-flex flex-column gap-2">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <div class="p-2 {{ $isImage ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }} rounded-2 d-flex align-items-center justify-content-center"
                                                                        style="width: 40px; height: 40px;">
                                                                        <i
                                                                            class="bi {{ $isImage ? 'bi-file-earmark-image' : 'bi-file-earmark-pdf' }} fs-5"></i>
                                                                    </div>
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <p class="fw-bold text-small mb-0 text-truncate"
                                                                            title="{{ $documents->title }}">
                                                                            {{ $documents->title }}
                                                                        </p>
                                                                        <span
                                                                            class="text-caption text-muted text-uppercase">
                                                                            {{ $documents->doc_type }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="d-flex gap-1 text-caption text-muted align-items-center">
                                                                    <i class="bi bi-calendar2 me-1"></i>
                                                                    {{ $documents->date }}
                                                                </div>
                                                                <div class="d-flex gap-2 mt-auto">
                                                                    <a href="{{ asset($documents->file_path) }}"
                                                                        target="_blank"
                                                                        class="btn btn-outline-success btn-sm flex-grow-1">
                                                                        <i class="bi bi-eye me-1"></i> عرض
                                                                    </a>
                                                                    <a href="{{ asset($documents->file_path) }}"
                                                                        download
                                                                        class="btn btn-outline-secondary btn-sm flex-grow-1">
                                                                        <i class="bi bi-download me-1"></i> تحميل
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ===== نهاية قسم الشهادات والوثائق ===== -->
                                <!-- ===== نهاية قسم الشهادات ===== -->

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('children.edit', $info->id) }}" class="btn btn-outline-primary btn-sm"><i
                                class="bi bi-pencil-square me-1"></i>
                            تعديل البيانات</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>

        </div>
    @endforeach

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
