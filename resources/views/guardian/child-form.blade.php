@php
    $isEdit = isset($editId);
    $prefill = $prefill ?? [];
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - تسجيل عائلة وأيتام جدد</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <style>
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .step-progress-bar {
            position: absolute;
            top: 22px;
            right: 20px;
            left: 20px;
            height: 4px;
            background: var(--primary-green);
            z-index: -1;
            width: 0%;
            transition: width 0.4s ease;
        }

        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-number {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 3px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 0.5rem;
            transition: all 0.3s ease;
            color: #6c757d;
            font-size: 1rem;
        }

        .step-item.active .step-number {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: #fff;
            box-shadow: 0 0 0 5px rgba(25, 83, 43, 0.15);
        }

        .step-item.completed .step-number {
            background: var(--secondary-gold);
            border-color: var(--secondary-gold);
            color: #fff;
        }

        .step-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .step-item.active .step-title {
            color: var(--primary-green);
        }

        .step-item.completed .step-title {
            color: var(--secondary-gold);
        }

        @media (max-width: 991px) {
            .step-number {
                width: 38px;
                height: 38px;
                font-size: 0.9rem;
                border-width: 2px;
            }

            .step-indicator::before,
            .step-progress-bar {
                top: 19px;
                height: 3px;
                left: 15px;
                right: 15px;
            }

            .step-title {
                font-size: 0.75rem;
                max-width: 85px;
                margin: 0 auto;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }

        @media (max-width: 576px) {
            .step-number {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
                border-width: 2px;
            }

            .step-indicator::before,
            .step-progress-bar {
                top: 16px;
                height: 3px;
                left: 10px;
                right: 10px;
            }

            .step-title {
                display: none;
            }

            .step-item.active .step-title {
                display: block;
                position: absolute;
                top: 40px;
                left: 50%;
                transform: translateX(-50%);
                white-space: nowrap;
                font-size: 0.72rem;
                width: 110px;
                max-width: 110px;
                font-weight: 800;
                color: var(--primary-green);
            }

            .step-indicator {
                margin-bottom: 3rem;
            }
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .file-upload-box {
            border: 2px dashed #ccd3ce;
            padding: 1.75rem;
            border-radius: 14px;
            text-align: center;
            background: #fdfdfd;
            transition: all 0.25s ease-in-out;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(25, 83, 43, 0.1);
        }

        .form-label {
            font-size: 0.88rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .kanaf-section-box {
            background: #ffffff;
            border: 1px solid #eef2f5;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn {
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover {
            background-color: #123e20;
            border-color: #123e20;
        }

        .btn-success {
            background-color: #1a7139;
            border-color: #1a7139;
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-green);
            color: #fff;
        }

        .badge-check-box {
            background: #fafafc;
            border: 2px solid #eaedf0;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #6c757d;
        }

        .error-msg {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <div class="dashboard-wrapper">
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
                    <h4 class="fw-bold mb-0 text-dark">
                        {{ $isEdit ? 'تعديل بيانات اليتيم وعائلته' : 'الأطفال والأبناء المسجلين' }}</h4>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
                                onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
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
                            <li class="breadcrumb-item"><a href="{{ route('children') }}"
                                    class="text-primary-green text-decoration-none">ملفات
                                    الأبناء</a></li>
                            <li class="breadcrumb-item active" aria-current="page">استمارة التسجيل الشاملة</li>
                        </ol>
                    </nav>
                </div>

                <div class="alert alert-info border-0 rounded-4 d-flex align-items-center gap-3 p-3 mb-4"
                    style="background-color: #f1f8f3; color: #19532B;">
                    <i class="bi bi-info-circle-fill fs-4 text-primary-green"></i>
                    <div>
                        <strong class="d-block mb-1">تسهيل الإجراءات والملء السريع للأوصياء:</strong>
                        <span style="font-size: 0.88rem;">يمكنك تصفح كافة الخطوات والملء بأريحية تامة، وسيتم اعتماد
                            الطلب بعد
                            المراجعة الميدانية.</span>
                    </div>
                </div>

                <div class="row g-4 justify-content-center">
                    <div class="col-lg-11">

                        <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                            <div class="step-indicator">
                                <div class="step-progress-bar" id="step-progress"></div>

                                <div class="step-item active" id="indicator-1">
                                    <div class="step-number">1</div>
                                    <div class="step-title">الوصي</div>
                                </div>
                                <div class="step-item" id="indicator-2">
                                    <div class="step-number">2</div>
                                    <div class="step-title">الوالدين</div>
                                </div>
                                <div class="step-item" id="indicator-3">
                                    <div class="step-number">3</div>
                                    <div class="step-title">السكن والنزوح</div>
                                </div>
                                <div class="step-item" id="indicator-4">
                                    <div class="step-number">4</div>
                                    <div class="step-title">الاستلام المالي</div>
                                </div>
                                <div class="step-item" id="indicator-5">
                                    <div class="step-number">5</div>
                                    <div class="step-title">الأيتام</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-4">
                            <form id="kanaf-multi-wizard"
                                action="{{ $isEdit ? route('children.update', $editId) : route('new_child_form') }}"
                                method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                @if ($isEdit)
                                    @method('PUT')
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger rounded-4 border-0 mb-4" id="form-error-summary">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                            <strong>يرجى تصحيح الأخطاء التالية قبل المتابعة:</strong>
                                        </div>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li style="font-size: 0.85rem;">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="step-content active" id="step-form-1">
                                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-2">
                                        <div class="p-2 rounded-3 bg-light-green text-primary-green"
                                            style="background: var(--soft-green);">
                                            <i class="bi bi-person-badge-fill fs-4"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary-green mb-0">المرحلة الأولى: بيانات الوصي
                                            (Guardian Data)</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label"><i
                                                    class="bi bi-person me-1 text-primary-green"></i> الاسم الرباعي
                                                الكامل للوصي</label>
                                            <input type="text" name="guardian_name" class="form-control"
                                                placeholder="الاسم الرباعي المطابق للهوية شخصية"
                                                value="{{ old('guardian_name', $prefill['guardian_name'] ?? '') }}">
                                            @error('guardian_name')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">
                                                <i class="bi bi-card-text me-1 text-primary-green"></i> رقم الهوية
                                                الشخصية
                                            </label>
                                            <input type="text" name="guardian_national_id" class="form-control"
                                                placeholder="9 خانات رقمية"
                                                value="{{ old('guardian_national_id', $prefill['guardian_national_id'] ?? '') }}"
                                                {{ $isEdit ? 'readonly' : '' }}>
                                            @error('guardian_national_id')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label"><i
                                                    class="bi bi-calendar-event me-1 text-primary-green"></i> تاريخ
                                                الميلاد</label>
                                            <input type="date" name="guardian_birth_date" class="form-control"
                                                value="{{ old('guardian_birth_date', $prefill['guardian_birth_date'] ?? '') }}">
                                            @error('guardian_birth_date')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label"><i
                                                    class="bi bi-people me-1 text-primary-green"></i> صلة القرابة
                                                باليتيم</label>
                                            <select name="guardian_relationship" class="form-select">
                                                <option value="" selected disabled>قم بتحديد صلة القرابة :
                                                </option>
                                                <option value="جد"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'جد' ? 'selected' : '' }}>
                                                    جد
                                                </option>
                                                <option value="جدة"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'جدة' ? 'selected' : '' }}>
                                                    جدة</option>
                                                <option value="عم"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'عم' ? 'selected' : '' }}>
                                                    عم
                                                </option>
                                                <option value="عمة"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'عمة' ? 'selected' : '' }}>
                                                    عمة
                                                </option>
                                                <option value="خال"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'خال' ? 'selected' : '' }}>
                                                    خال
                                                </option>
                                                <option value="خالة"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'خالة' ? 'selected' : '' }}>
                                                    خالة
                                                </option>
                                                <option value="أخ"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'أخ' ? 'selected' : '' }}>
                                                    أخ
                                                    أكبر</option>
                                                <option value="أخت"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'أخت' ? 'selected' : '' }}>
                                                    أخت
                                                    كبرى</option>
                                                <option value="أم"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'أم' ? 'selected' : '' }}>
                                                    الأم
                                                </option>
                                                <option value="أخرى"
                                                    {{ old('guardian_relationship', $prefill['guardian_relationship'] ?? '') == 'أخرى' ? 'selected' : '' }}>
                                                    أخرى
                                                    (وصاية شرعية قريبة)</option>
                                            </select>
                                            @error('guardian_relationship')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label"><i
                                                    class="bi bi-heart me-1 text-primary-green"></i> الحالة
                                                الاجتماعية</label>
                                            <select name="guardian_marital_status" class="form-select">
                                                <option value="" selected disabled>قم بتحديد الحالة الاجتماعية :
                                                </option>
                                                <option value="متزوج"
                                                    {{ old('guardian_marital_status', $prefill['guardian_marital_status'] ?? '') == 'متزوج' ? 'selected' : '' }}>
                                                    متزوج / متزوجة</option>
                                                <option value="أعزب"
                                                    {{ old('guardian_marital_status', $prefill['guardian_marital_status'] ?? '') == 'أعزب' ? 'selected' : '' }}>
                                                    أعزب / عزباء</option>
                                                <option value="أرمل"
                                                    {{ old('guardian_marital_status', $prefill['guardian_marital_status'] ?? '') == 'أرمل' ? 'selected' : '' }}>
                                                    أرمل / أرملة</option>
                                                <option value="مطلق"
                                                    {{ old('guardian_marital_status', $prefill['guardian_marital_status'] ?? '') == 'مطلق' ? 'selected' : '' }}>
                                                    مطلق / مطلقة</option>
                                            </select>
                                            @error('guardian_marital_status')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label"><i
                                                    class="bi bi-activity me-1 text-primary-green"></i> الحالة الصحية
                                                للوصي</label>
                                            <!-- أُضيف id="guardian_health_status" -->
                                            <select name="guardian_health_status" id="guardian_health_status"
                                                class="form-select">
                                                <option value="" selected disabled>قم بتحديد الحالة الصحية للوصي
                                                    :</option>
                                                <option value="سليم"
                                                    {{ old('guardian_health_status', $prefill['guardian_health_status'] ?? '') == 'سليم' ? 'selected' : '' }}>
                                                    سليم معافى
                                                </option>
                                                <option value="مريض"
                                                    {{ old('guardian_health_status', $prefill['guardian_health_status'] ?? '') == 'مريض' ? 'selected' : '' }}>
                                                    يعاني من مرض / حالة صحية خاصة
                                                </option>
                                            </select>
                                            @error('guardian_health_status')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- أُضيف id="guardian-health-details-wrapper" ومخفي افتراضياً -->
                                        <div class="col-12" id="guardian-health-details-wrapper"
                                            style="display: none;">
                                            <div
                                                class="p-3 bg-light-subtle rounded-3 border border-danger-subtle mt-1">
                                                <label class="form-label text-danger"><i
                                                        class="bi bi-envelope-heart me-1"></i> تفاصيل الحالة الصحية
                                                    والطبية للوصي</label>
                                                <textarea name="guardian_health_details" class="form-control" rows="2"
                                                    placeholder="يرجى كتابة تفاصيل الحالة الصحية والأمراض التي يعاني منها الوصي للاحتياجات...">{{ old('guardian_health_details', $prefill['guardian_health_details'] ?? '') }}</textarea>
                                                @error('guardian_health_details')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label"><i
                                                    class="bi bi-cash-stack me-1 text-primary-green"></i> مصدر الدخل
                                                للعائلة</label>
                                            <select name="family_income_source" class="form-select">
                                                <option value="" selected disabled>قم بتحديد مصدر الخل الخاص
                                                    بالوصي :</option>
                                                <option value="لا يوجد"
                                                    {{ old('family_income_source', $prefill['family_income_source'] ?? '') == 'لا يوجد' ? 'selected' : '' }}>
                                                    لا يوجد أي مصدر دخل ثابت</option>
                                                <option value="يوجد"
                                                    {{ old('family_income_source', $prefill['family_income_source'] ?? '') == 'يوجد' ? 'selected' : '' }}>
                                                    يوجد
                                                    مصدر دخل (جزئي أو ثابت)</option>
                                            </select>
                                            @error('family_income_source')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mt-4">
                                            <label class="form-label d-block border-bottom pb-2"><i
                                                    class="bi bi-paperclip me-1 text-primary-green"></i> المرفقات
                                                الرسمية الثبوتية للوصي</label>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="file-upload-box">
                                                        <i
                                                            class="bi bi-card-image fs-1 text-primary-green mb-2 d-block"></i>
                                                        <strong class="d-block text-dark"
                                                            style="font-size: 0.95rem;">صورة هوية الوصي
                                                            الشخصية</strong>
                                                        <span class="text-muted d-block mt-1"
                                                            style="font-size: 0.8rem;">اضغط لإدراج صورة الهوية (الأمام
                                                            والخلف)</span>
                                                        <input type="file" name="guardian_id_photo"
                                                            class="form-control mt-2">
                                                        @error('guardian_id_photo')
                                                            <span class="error-msg"
                                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="file-upload-box">
                                                        <i
                                                            class="bi bi-file-earmark-pdf-fill fs-1 text-warning mb-2 d-block"></i>
                                                        <strong class="d-block text-dark"
                                                            style="font-size: 0.95rem;">صك الوصاية القانونية
                                                            الشرعي</strong>
                                                        <span class="text-muted d-block mt-1"
                                                            style="font-size: 0.8rem;">اضغط لرفع صك الوصاية القانوني في
                                                            حال توفره</span>
                                                        <input type="file" name="guardian_legal_document"
                                                            class="form-control mt-2">
                                                        @error('guardian_legal_document')
                                                            <span class="error-msg"
                                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-form-2">
                                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-2">
                                        <div class="p-2 rounded-3 bg-light-green text-primary-green"
                                            style="background: var(--soft-green);">
                                            <i class="bi bi-heart-break-fill fs-4"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary-green mb-0">المرحلة الثانية: بيانات الوالدين
                                            وصك الوفاة (Parents Data)</h4>
                                    </div>

                                    <div class="kanaf-section-box">
                                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i
                                                class="bi bi-caret-left-fill text-secondary-gold"></i> ١. بيانات الأب
                                            (المتوفى/الشهيد)</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">الاسم الرباعي للأب المتوفى</label>
                                                <input type="text" name="father_name" class="form-control"
                                                    placeholder="الاسم الرباعي للأب كاملاً"
                                                    value="{{ old('father_name', $prefill['father_name'] ?? '') }}">
                                                @error('father_name')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">رقم هوية الأب</label>
                                                <input type="text" name="father_national_id" class="form-control"
                                                    placeholder="9 خانات رقمية"
                                                    value="{{ old('father_national_id', $prefill['father_national_id'] ?? '') }}">
                                                @error('father_national_id')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">تاريخ الوفاة / الاستشهاد</label>
                                                <input type="date" name="father_death_date" class="form-control"
                                                    value="{{ old('father_death_date', $prefill['father_death_date'] ?? '') }}">
                                                @error('father_death_date')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">سبب الوفاة</label>
                                                <select name="father_death_reason" class="form-select">
                                                    <option value="" selected disabled>قم بتحديد سبب الوفاة :
                                                    </option>
                                                    <option value="شهيد بالقصف"
                                                        {{ old('father_death_reason', $prefill['father_death_reason'] ?? '') == 'شهيد بالقصف' ? 'selected' : '' }}>
                                                        شهيد (قصف أو استهداف مباشر)</option>
                                                    <option value="مفقود"
                                                        {{ old('father_death_reason', $prefill['father_death_reason'] ?? '') == 'مفقود' ? 'selected' : '' }}>
                                                        مفقود تحت الأنقاض أو مغيب</option>
                                                    <option value="وفاة طبيعية"
                                                        {{ old('father_death_reason', $prefill['father_death_reason'] ?? '') == 'وفاة طبيعية' ? 'selected' : '' }}>
                                                        وفاة طبيعية (مرض/كبر سن)</option>
                                                    <option value="أخرى"
                                                        {{ old('father_death_reason', $prefill['father_death_reason'] ?? '') == 'أخرى' ? 'selected' : '' }}>
                                                        أسباب أخرى (نقص رعاية طبية بسبب الحرب)</option>
                                                </select>
                                                @error('father_death_reason')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">مرفق شهادة الوفاة / إثبات الفقدان</label>
                                                <input type="file" name="father_death_certificate"
                                                    class="form-control">
                                                @error('father_death_certificate')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="kanaf-section-box">
                                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i
                                                class="bi bi-caret-left-fill text-secondary-gold"></i> ٢. بيانات الأم
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-label d-block">هل الأم لا تزال على قيد
                                                    الحياة؟</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="mother_alive" id="mother-alive-yes" value="yes"
                                                            {{ old('mother_alive', $prefill['mother_alive'] ?? 'yes') == 'yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold"
                                                            for="mother-alive-yes">نعم، على قيد الحياة</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="mother_alive" id="mother-alive-no" value="no"
                                                            {{ old('mother_alive', $prefill['mother_alive'] ?? 'yes') == 'no' ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold text-danger"
                                                            for="mother-alive-no">لا، متوفاة / شهيدة</label>
                                                    </div>
                                                </div>
                                                @error('mother_alive')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12" id="mother-death-details">
                                                <div
                                                    class="row g-3 bg-light p-3 rounded-4 border border-danger-subtle">
                                                    <div class="col-md-4">
                                                        <label class="form-label">تاريخ وفاة الأم</label>
                                                        <input type="date" name="mother_death_date"
                                                            class="form-control"
                                                            value="{{ old('mother_death_date', $prefill['mother_death_date'] ?? '') }}">
                                                        @error('mother_death_date')
                                                            <span class="error-msg"
                                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">سبب وفاة الأم</label>
                                                        <select name="mother_death_reason" class="form-select">
                                                            <option value="" selected disabled>قم بتحديد سبب
                                                                الوفاة :</option>
                                                            <option value="شهيدة"
                                                                {{ old('mother_death_reason', $prefill['mother_death_reason'] ?? '') == 'شهيدة' ? 'selected' : '' }}>
                                                                شهيدة (قصف)</option>
                                                            <option value="وفاة طبيعية"
                                                                {{ old('mother_death_reason', $prefill['mother_death_reason'] ?? '') == 'وفاة طبيعية' ? 'selected' : '' }}>
                                                                وفاة طبيعية</option>
                                                            <option value="مفقودة"
                                                                {{ old('mother_death_reason', $prefill['mother_death_reason'] ?? '') == 'مفقودة' ? 'selected' : '' }}>
                                                                مفقودة</option>
                                                        </select>
                                                        @error('mother_death_reason')
                                                            <span class="error-msg"
                                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">شهادة وفاة الأم أو إثباتها</label>
                                                        <input type="file" name="mother_death_certificate"
                                                            class="form-control">
                                                        @error('mother_death_certificate')
                                                            <span class="error-msg"
                                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-form-3">
                                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-2">
                                        <div class="p-2 rounded-3 bg-light-green text-primary-green"
                                            style="background: var(--soft-green);">
                                            <i class="bi bi-house-door-fill fs-4"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary-green mb-0">المرحلة الثالثة: السكن والنزوح
                                            الحالي (Housing & Displacement)</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">نوع السكن الحالي</label>
                                            <select name="housing_type" class="form-select">
                                                <option value="" selected disabled>قم بتحديد نوع السكن :</option>
                                                <option value="خيمة"
                                                    {{ old('housing_type', $prefill['housing_type'] ?? '') == 'خيمة' ? 'selected' : '' }}>
                                                    خيمة نزوح (في
                                                    مخيم مؤقت)</option>
                                                <option value="مركز إيواء"
                                                    {{ old('housing_type', $prefill['housing_type'] ?? '') == 'مركز إيواء' ? 'selected' : '' }}>
                                                    مركز إيواء (مدارس الإونروا / أماكن عامة)</option>
                                                <option value="إيجار"
                                                    {{ old('housing_type', $prefill['housing_type'] ?? '') == 'إيجار' ? 'selected' : '' }}>
                                                    بيت مستأجر
                                                    مؤقتاً</option>
                                                <option value="ملك"
                                                    {{ old('housing_type', $prefill['housing_type'] ?? '') == 'ملك' ? 'selected' : '' }}>
                                                    ملك خاص (متبقٍ
                                                    أو جزئي)</option>
                                            </select>
                                            @error('housing_type')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">حالة وصلاحية السكن</label>
                                            <select name="housing_condition" id="housing_condition"
                                                class="form-select">
                                                <option value="" selected disabled>قم بتحديد حالة السكن :
                                                </option>
                                                <option value="صالح للسكن"
                                                    {{ old('housing_condition', $prefill['housing_condition'] ?? '') == 'صالح للسكن' ? 'selected' : '' }}>
                                                    صالح للسكن حالياً</option>
                                                <option value="غير صالح"
                                                    {{ old('housing_condition', $prefill['housing_condition'] ?? '') == 'غير صالح' ? 'selected' : '' }}>
                                                    غير صالح للسكن (متضرر كلياً أو جزئياً من القصف)</option>
                                            </select>
                                            @error('housing_condition')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12" id="housing-damage-wrapper" style="display: none;">
                                            <div
                                                class="p-3 bg-light-subtle rounded-3 border border-danger-subtle mt-1">
                                                <label class="form-label text-danger">وصف أضرار وتصدعات المسكن
                                                    بالتفصيل</label>
                                                <textarea name="housing_damage_details" class="form-control" rows="2"
                                                    placeholder="يرجى توضيح حجم الدمار أو الأضرار الحاصلة ببيت الأيتام لتراعيها الجمعية...">{{ old('housing_damage_details', $prefill['housing_damage_details'] ?? '') }}</textarea>
                                                @error('housing_damage_details')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">المدينة الأصلية (قبل الحرب)</label>
                                            <select name="original_city" class="form-select">
                                                <option value="" selected disabled>قم بتحديد المدينة الاصلية :
                                                </option>
                                                <option value="غزة"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'غزة' ? 'selected' : '' }}>
                                                    مدينة
                                                    غزة</option>
                                                <option value="شمال غزة"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'شمال غزة' ? 'selected' : '' }}>
                                                    شمال غزة
                                                    (جباليا/بيت لاهيا)</option>
                                                <option value="خانيونس"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'خانيونس' ? 'selected' : '' }}>
                                                    خان يونس
                                                </option>
                                                <option value="رفح"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'رفح' ? 'selected' : '' }}>
                                                    رفح</option>
                                                <option value="دير البلح"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'دير البلح' ? 'selected' : '' }}>
                                                    دير
                                                    البلح</option>
                                                <option value="بيت حانون"
                                                    {{ old('original_city', $prefill['original_city'] ?? '') == 'بيت حانون' ? 'selected' : '' }}>
                                                    بيت
                                                    حانون</option>
                                            </select>
                                            @error('original_city')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">وجهة النزوح الحالية بالكامل</label>
                                            <select name="current_displacement_destination" class="form-select">
                                                <option value="" selected disabled>قم بتحديد وجهة النزوح :
                                                </option>
                                                <option value="مطابق"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'مطابق' ? 'selected' : '' }}>
                                                    مطابق للمدينة الأصلية</option>
                                                <option value="دير البلح"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'دير البلح' ? 'selected' : '' }}>
                                                    دير البلح (الوسطى)</option>
                                                <option value="خانيونس"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'خانيونس' ? 'selected' : '' }}>
                                                    خان يونس</option>
                                                <option value="رفح"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'رفح' ? 'selected' : '' }}>
                                                    رفح</option>
                                                <option value="شمال غزة"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'شمال غزة' ? 'selected' : '' }}>
                                                    شمال غزة</option>
                                                <option value="غزة"
                                                    {{ old('current_displacement_destination', $prefill['current_displacement_destination'] ?? '') == 'غزة' ? 'selected' : '' }}>
                                                    مدينة غزة</option>
                                            </select>
                                            @error('current_displacement_destination')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">تموضع السكن والعنوان التفصيلي الحالي (مهم جداً
                                                لتوجيه الباحث الميداني)</label>
                                            <textarea name="current_address_details" class="form-control" rows="3"
                                                placeholder="اكتب تفاصيل الوصول بدقة (اسم مدرسة الإيواء ورقم الغرفة، أو اسم المخيم ورقم البلوك، أو علامة مميزة قريبة)">{{ old('current_address_details', $prefill['current_address_details'] ?? 'مخيم دير البلح العام، مدرسة شهداء الأقصى للإيواء، الغرفة رقم 14 الدور الأرضي') }}</textarea>
                                            @error('current_address_details')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-form-4">
                                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-2">
                                        <div class="p-2 rounded-3 bg-light-green text-primary-green"
                                            style="background: var(--soft-green);">
                                            <i class="bi bi-wallet2 fs-4"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary-green mb-0">المرحلة الرابعة: بيانات الاستلام
                                            المالي (Financial Data)</h4>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">جهة الاستلام المالي الرسمية</label>
                                            <select name="financial_entity" class="form-select">
                                                <option value="" selected disabled>قم بتحديد وجهة الاستلام :
                                                </option>
                                                <option value="بنك فلسطين"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'بنك فلسطين' ? 'selected' : '' }}>
                                                    بنك فلسطين (Bank of Palestine)</option>
                                                <option value="البنك الإسلامي"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'البنك الإسلامي' ? 'selected' : '' }}>
                                                    البنك الإسلامي الفلسطيني / العربي</option>
                                                <option value="القاهرة عمان"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'القاهرة عمان' ? 'selected' : '' }}>
                                                    بنك القاهرة عمان</option>
                                                <option value="بنك الأردن"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'بنك الأردن' ? 'selected' : '' }}>
                                                    بنك
                                                    الأردن</option>
                                                <option value="Jawwal Pay"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'Jawwal Pay' ? 'selected' : '' }}>
                                                    محفظة جوال باي (Jawwal Pay)</option>
                                                <option value="PalPay"
                                                    {{ old('financial_entity', $prefill['financial_entity'] ?? '') == 'PalPay' ? 'selected' : '' }}>
                                                    محفظة
                                                    بال باي (PalPay)</option>
                                            </select>
                                            @error('financial_entity')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">اسم صاحب الحساب كاملاً كما هو مسجل رسمياً</label>
                                            <input type="text" name="account_holder_name" class="form-control"
                                                placeholder="الاسم المطابق لدفتر البنك أو المحفظة للإرسال"
                                                value="{{ old('account_holder_name', $prefill['account_holder_name'] ?? '') }}">
                                            @error('account_holder_name')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6" id="finance-bank-div">
                                            <label class="form-label text-success">رقم الحساب البنكي أو رقم الـ IBAN
                                                الدولي</label>
                                            <input type="text" name="iban_or_account_number" class="form-control"
                                                placeholder="PS90 PBAL 0000 0000 1234 5678"
                                                value="{{ old('iban_or_account_number', $prefill['iban_or_account_number'] ?? '') }}">
                                            @error('iban_or_account_number')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label d-block mt-3">التقييم والوضع المادي الحالي
                                                للأسرة</label>
                                            <div class="row g-3 mt-1">
                                                <div class="col-md-4">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="family_financial_rating" id="rating-poor"
                                                                value="حالة ضعيفة"
                                                                {{ old('family_financial_rating', $prefill['family_financial_rating'] ?? '') == 'حالة ضعيفة' ? 'checked' : '' }}>
                                                            <label class="form-check-label text-danger fw-bold"
                                                                for="rating-poor">حالة ضعيفة جداً (تحت خط
                                                                الفقر)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="family_financial_rating" id="rating-medium"
                                                                value="حالة متوسطة"
                                                                {{ old('family_financial_rating', $prefill['family_financial_rating'] ?? '') == 'حالة متوسطة' ? 'checked' : '' }}>
                                                            <label class="form-check-label text-warning fw-bold"
                                                                for="rating-medium">حالة متوسطة (تغطية جزئية)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="p-3 border rounded-3 bg-light">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="family_financial_rating" id="rating-good"
                                                                value="حالة جيدة"
                                                                {{ old('family_financial_rating', $prefill['family_financial_rating'] ?? '') == 'حالة جيدة' ? 'checked' : '' }}>
                                                            <label class="form-check-label text-success fw-bold"
                                                                for="rating-good">حالة جيدة (مساندة خارجية)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('family_financial_rating')
                                                <span class="error-msg"
                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mt-4 p-3 rounded-4 bg-light border">
                                            <div class="d-flex align-items-start gap-3">
                                                <i class="bi bi-shield-fill-exclamation text-danger fs-2 mt-1"></i>
                                                <div>
                                                    <strong class="text-dark d-block mb-1">نظام حماية الحوالات وكفالة
                                                        اليتيم المأمونة</strong>
                                                    <span class="text-muted text-small d-block"
                                                        style="font-size: 0.82rem;">بموجب ضوابط الخصوصية والأمان في
                                                        منصة كنف، يتم حماية الحسابات المالية وصرف المبالغ بطرق آمنة
                                                        وموثقة.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="step-content" id="step-form-5">
                                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-2">
                                        <div class="p-2 rounded-3 bg-light-green text-primary-green"
                                            style="background: var(--soft-green);">
                                            <i class="bi bi-person-heart fs-4"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary-green mb-0">المرحلة الخامسة: بيانات الطفل
                                            اليتيم (Orphan Data)</h4>
                                    </div>

                                    <div class="p-4 bg-light rounded-4 border mb-4"
                                        style="border-right: 5px solid var(--primary-green) !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <strong class="text-primary-green fs-5"><i
                                                    class="bi bi-tag-fill me-1 text-secondary-gold"></i> استمارة اليتيم
                                                الأساسية</strong>
                                            <span class="badge bg-secondary py-2 px-3 rounded-pill">طفل رقم ١ في
                                                العائلة</span>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="p-3 bg-amber-subtle text-dark border-0 rounded-3 mb-2"
                                                    style="background-color: #fffaf0; border-right: 4px solid var(--secondary-gold) !important; font-size: 0.85rem;">
                                                    <i class="bi bi-lock-fill text-secondary-gold me-1"></i>
                                                    <strong>حفظ الخصوصية للأطفال:</strong> الاسم الأول فقط واللقب
                                                    المستعار هما ما سيظهر لغير الكفلاء ومزودي الخدمة، بينما التفاصيل
                                                    الكاملة ورقم الهوية ستظل محجوبة تماماً في النظام المغلق للإدارة.
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">الاسم الأول فقط للطفل (الذي سيظهر
                                                    للعامة)</label>
                                                <input type="text" name="child_first_name" class="form-control"
                                                    placeholder="مثال 'احمد'"
                                                    value="{{ old('child_first_name', $prefill['child_first_name'] ?? '') }}">
                                                @error('child_first_name')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">الاسم الرباعي الكامل</label>
                                                <input type="text" name="child_full_name" id="child_full_name"
                                                    class="form-control"
                                                    value="{{ old('child_full_name', $prefill['child_full_name'] ?? '') }}">
                                                @error('child_full_name')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">ورقم الهوية</label>
                                                <input type="text" name="child_national_id" class="form-control"
                                                    value="{{ old('child_national_id', $prefill['child_national_id'] ?? '') }}">
                                                @error('child_national_id')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">تاريخ ميلاد الطفل</label>
                                                <input type="date" name="child_birth_date" class="form-control"
                                                    value="{{ old('child_birth_date', $prefill['child_birth_date'] ?? '') }}">
                                                @error('child_birth_date')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">العمر </label>
                                                <input type="number" name="child_age" class="form-control"
                                                    min="0" max="18" placeholder="العمر "
                                                    value="{{ old('child_age', $prefill['child_age'] ?? '') }}">
                                                @error('child_age')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">الجنس</label>
                                                <select name="child_gender" class="form-select">
                                                    <option value="" selected disabled>قم بتحديد الجنس :</option>
                                                    <option value="ذكر"
                                                        {{ old('child_gender', $prefill['child_gender'] ?? '') == 'ذكر' ? 'selected' : '' }}>
                                                        ذكر</option>
                                                    <option value="أنثى"
                                                        {{ old('child_gender', $prefill['child_gender'] ?? '') == 'أنثى' ? 'selected' : '' }}>
                                                        أنثى
                                                    </option>
                                                </select>
                                                @error('child_gender')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">الحالة التعليمية والصف الحالي للطفل</label>
                                                <input type="text" name="child_education_status"
                                                    class="form-control"
                                                    placeholder="الصف الرابع، أو منقطع مؤقتاً بسبب الحرب"
                                                    value="{{ old('child_education_status', $prefill['child_education_status'] ?? '') }}">
                                                @error('child_education_status')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">حالة تواجد اليتيم</label>
                                                <select name="child_presence_status" class="form-select">
                                                    <option value="" selected disabled>قم بتحديد مكان الاقامة :
                                                    </option>
                                                    <option value="داخل البلد"
                                                        {{ old('child_presence_status', $prefill['child_presence_status'] ?? '') == 'داخل البلد' ? 'selected' : '' }}>
                                                        داخل البلد (قطاع غزة حالياً)</option>
                                                    <option value="مسافر للخارج"
                                                        {{ old('child_presence_status', $prefill['child_presence_status'] ?? '') == 'مسافر للخارج' ? 'selected' : '' }}>
                                                        مسافر للخارج (برحلة علاج أو لجوء مؤقت)</option>
                                                </select>
                                                @error('child_presence_status')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 mt-3">
                                                <label class="form-label d-block text-muted mb-2"><i
                                                        class="bi bi-award-fill text-secondary-gold"></i> الأوسمة
                                                    والتصنيفات الإنسانية الذكية (تظهر للكفلاء لتوجيه الدعم
                                                    الأنسب)</label>
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <div class="badge-check-box">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="badge_both_parents" id="badge-both-parents"
                                                                value="1"
                                                                {{ old('badge_both_parents', $prefill['badge_both_parents'] ?? '') ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold p-0 m-0"
                                                                for="badge-both-parents"><i
                                                                    class="bi bi-people-fill text-danger me-1"></i>
                                                                يتيم الأبوين (أب وأم)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="badge-check-box">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="badge_lone_survivor" id="badge-lone-survivor"
                                                                value="1"
                                                                {{ old('badge_lone_survivor', $prefill['badge_lone_survivor'] ?? '1') == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold p-0 m-0"
                                                                for="badge-lone-survivor"><i
                                                                    class="bi bi-life-preserver text-warning me-1"></i>
                                                                ناجي وحيد للعائلة</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="badge-check-box">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="badge_extreme_need" id="badge-extreme-need"
                                                                value="1"
                                                                {{ old('badge_extreme_need', $prefill['badge_extreme_need'] ?? '1') == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold p-0 m-0"
                                                                for="badge-extreme-need"><i
                                                                    class="bi bi-star-fill text-warning me-1"></i> حالة
                                                                معيشية أشد حاجة</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="badge-check-box">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="badge_injured" id="badge-injured"
                                                                value="1"
                                                                {{ old('badge_injured', $prefill['badge_injured'] ?? '') ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold p-0 m-0"
                                                                for="badge-injured"><i
                                                                    class="bi bi-prescription2 text-secondary me-1"></i>
                                                                مصاب حرب / جريح</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="badge-check-box">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="badge_chronic_disease"
                                                                id="badge-chronic-disease" value="1"
                                                                {{ old('badge_chronic_disease', $prefill['badge_chronic_disease'] ?? '') ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold p-0 m-0"
                                                                for="badge-chronic-disease"><i
                                                                    class="bi bi-activity text-info me-1"></i> يعاني من
                                                                مرض مزمن</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">الحالة الصحية لليتيم</label>
                                                <!-- أُضيف id="child_health_status" -->
                                                <select name="child_health_status" id="child_health_status"
                                                    class="form-select">
                                                    <option value="" selected disabled>قم بتحديد الحالة الصحية :
                                                    </option>
                                                    <option value="طبيعي"
                                                        {{ old('child_health_status', $prefill['child_health_status'] ?? '') == 'طبيعي' ? 'selected' : '' }}>
                                                        طبيعي معافى</option>
                                                    <option value="حالة صحية خاصة"
                                                        {{ old('child_health_status', $prefill['child_health_status'] ?? '') == 'حالة صحية خاصة' ? 'selected' : '' }}>
                                                        يعاني من حالة صحية خاصة أو إصابة</option>
                                                </select>
                                                @error('child_health_status')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label text-danger">وصف الحالة الصحية والاحتياجات
                                                    الطبية بالأرقام</label>
                                                <!-- أُضيف id="child_medical_needs" -->
                                                <input type="text" name="child_medical_needs"
                                                    id="child_medical_needs" class="form-control"
                                                    placeholder="مثال: بحاجة لطرف اصطناعي وعلاج طبيعي"
                                                    value="{{ old('child_medical_needs', $prefill['child_medical_needs'] ?? '') }}">
                                                @error('child_medical_needs')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">قصة اليتيم والاحتياجات المعيشية اليومية لربطه
                                                    بالقلوب الكافلة</label>
                                                <textarea name="child_story" class="form-control" rows="3"
                                                    placeholder="تكلم بصدق واختصار عن وضع اليتيم لتسهيل قبوله وعرض احتياجاته التعليمية والمعيشية...">{{ old('child_story', $prefill['child_story'] ?? '') }}</textarea>
                                                @error('child_story')
                                                    <span class="error-msg"
                                                        style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-12 mt-4">
                                                <label class="form-label d-block text-muted border-bottom pb-2"><i
                                                        class="bi bi-paperclip me-1"></i> المستندات والوثائق الخاصة
                                                    باليتيم</label>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="file-upload-box">
                                                            <i
                                                                class="bi bi-file-earmark-medical-fill fs-1 text-primary-green mb-2 d-block"></i>
                                                            <strong class="d-block text-dark"
                                                                style="font-size: 0.95rem;">صورة شهادة ميلاد
                                                                الطفل</strong>
                                                            <span class="text-muted d-block mt-1"
                                                                style="font-size: 0.8rem;">اضغط لرفع شهادة ميلاد الطفل
                                                                كاثبات للسن</span>
                                                            <input type="file" name="child_birth_certificate"
                                                                class="form-control mt-2">
                                                            @error('child_birth_certificate')
                                                                <span class="error-msg"
                                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="file-upload-box">
                                                            <i
                                                                class="bi bi-person-fill-gear fs-1 text-success mb-2 d-block"></i>
                                                            <strong class="d-block text-dark"
                                                                style="font-size: 0.95rem;">صورة اليتيم الشخصية
                                                                الرسمية</strong>
                                                            <span class="text-muted d-block mt-1"
                                                                style="font-size: 0.8rem;">مربعة الشكل وواضحة جداً
                                                                (ستعرض للكفلاء المعتمدين)</span>
                                                            <input type="file" name="child_photo"
                                                                class="form-control mt-2">
                                                            @error('child_photo')
                                                                <span class="error-msg"
                                                                    style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="p-3 bg-light rounded-4 border">
                                        <div class="form-check text-start d-flex align-items-center gap-2">
                                            <input class="form-check-input m-0" type="checkbox"
                                                name="legal_affirmation" id="legal-affirmation" value="1"
                                                style="width: 20px; height: 20px;"
                                                {{ old('legal_affirmation', $prefill['legal_affirmation'] ?? '') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark text-small m-0 ps-1"
                                                for="legal-affirmation" style="line-height:1.6; font-size: 0.82rem;">
                                                أقر بموثوقية كافة البيانات والمستندات المرفقة أعلاه وأتعهد بصحة القرابة،
                                                وموافقتي التامة على سياسات منصة كنف الميدانية.
                                            </label>
                                        </div>
                                        @error('legal_affirmation')
                                            <span class="error-msg"
                                                style="color: rgb(255, 0, 0)">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="mt-5 border-top pt-4 d-flex justify-content-between flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-secondary px-4 py-2 d-none"
                                        id="btn-back" onclick="navigateStep(-1)">
                                        <i class="bi bi-arrow-right-short align-middle fs-5"></i> السابق
                                    </button>
                                    <a href="{{ route('children') }}" class="btn btn-outline-secondary px-4 py-2"
                                        id="btn-cancel">
                                        إلغاء وخروج
                                    </a>

                                    <button type="button" class="btn btn-primary px-5 py-2 fw-bold" id="btn-next"
                                        onclick="navigateStep(1)">
                                        التالي <i class="bi bi-arrow-left-short align-middle fs-5"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        // ===== معالج الخطوات (Wizard) مع تحقق من جانب العميل لكل خطوة =====
        let currentStep = 1;
        const totalSteps = 5;
        const form = document.getElementById('kanaf-multi-wizard');
        const isEdit = {{ $isEdit ? 'true' : 'false' }};

        // الحقول المطلوبة لكل خطوة (تم إزالة child_rating لعدم وجوده بالفورم)
        const requiredByStep = {
            1: ['guardian_name', 'guardian_national_id', 'guardian_birth_date', 'guardian_relationship',
                'guardian_marital_status', 'guardian_health_status'
            ],
            2: ['father_name', 'mother_alive'],
            3: ['housing_type', 'housing_condition', 'original_city', 'current_displacement_destination',
                'current_address_details'
            ],
            4: ['financial_entity', 'account_holder_name', 'iban_or_account_number', 'family_financial_rating'],
            5: ['child_first_name', 'child_full_name', 'child_national_id', 'child_birth_date', 'child_age',
                'child_gender', 'child_education_status', 'child_presence_status', 'child_health_status',
                'legal_affirmation'
            ],
        };

        // خريطة الحقول للقفز لأول خطوة تحتوي على خطأ سيرفر
        const fieldStep = {
            guardian_name: 1,
            guardian_national_id: 1,
            guardian_birth_date: 1,
            guardian_relationship: 1,
            guardian_marital_status: 1,
            guardian_health_status: 1,
            guardian_health_details: 1,
            family_income_source: 1,
            guardian_id_photo: 1,
            guardian_legal_document: 1,
            father_name: 2,
            father_national_id: 2,
            father_death_date: 2,
            father_death_reason: 2,
            father_death_certificate: 2,
            mother_alive: 2,
            mother_death_date: 2,
            mother_death_reason: 2,
            mother_death_certificate: 2,
            housing_type: 3,
            housing_condition: 3,
            housing_damage_details: 3,
            original_city: 3,
            current_displacement_destination: 3,
            current_address_details: 3,
            financial_entity: 4,
            account_holder_name: 4,
            iban_or_account_number: 4,
            family_financial_rating: 4,
            child_first_name: 5,
            child_full_name: 5,
            child_national_id: 5,
            child_birth_date: 5,
            child_age: 5,
            child_gender: 5,
            child_education_status: 5,
            child_presence_status: 5,
            child_health_status: 5,
            child_medical_needs: 5,
            child_story: 5,
            child_photo: 5,
            child_birth_certificate: 5,
            legal_affirmation: 5,
        };

        // تفاصيل ودعم حقل الاحتياجات الطبية لليتيم
        const childHealthSelect = document.getElementById('child_health_status');
        const childMedicalNeedsInput = document.getElementById('child_medical_needs');

        function toggleChildMedicalNeeds() {
            if (childHealthSelect && childMedicalNeedsInput) {
                if (childHealthSelect.value === 'طبيعي' || childHealthSelect.value === '') {
                    childMedicalNeedsInput.disabled = true;
                    childMedicalNeedsInput.value = ''; // مسح القيمة إن وجدت عند تحويله لطبيعي
                } else {
                    childMedicalNeedsInput.disabled = false;
                }
            }
        }

        if (childHealthSelect) {
            childHealthSelect.addEventListener('change', toggleChildMedicalNeeds);
            toggleChildMedicalNeeds(); // تشغيل التحقق تلقائياً عند تحميل الصفحة
        }

        function validateStep(step) {
            const names = requiredByStep[step] || [];
            for (const name of names) {
                const els = form.querySelectorAll(`[name="${name}"]`);
                if (!els.length) continue;

                let filled = false;
                let isChoice = false;
                els.forEach(el => {
                    if (el.type === 'radio' || el.type === 'checkbox') {
                        isChoice = true;
                        if (el.checked) filled = true;
                    } else if (el.value && el.value.trim() !== '') {
                        filled = true;
                    }
                });

                if (!filled) {
                    const first = els[0];
                    first.setCustomValidity(isChoice ? 'هذا الاختيار مطلوب' : 'هذا الحقل مطلوب');
                    first.reportValidity();
                    first.focus();
                    const clear = () => {
                        first.setCustomValidity('');
                        first.removeEventListener('input', clear);
                        first.removeEventListener('change', clear);
                    };
                    first.addEventListener('input', clear);
                    first.addEventListener('change', clear);
                    return false;
                }
            }
            return true;
        }

        function navigateStep(direction) {
            if (direction === 1 && !validateStep(currentStep)) return;

            if (currentStep === totalSteps && direction === 1) {
                form.submit();
                return;
            }

            currentStep += direction;
            if (currentStep < 1) currentStep = 1;
            if (currentStep > totalSteps) currentStep = totalSteps;

            refreshUI();
        }

        function refreshUI() {
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step-form-${i}`).classList.toggle('active', i === currentStep);
                const ind = document.getElementById(`indicator-${i}`);
                ind.classList.toggle('active', i === currentStep);
                ind.classList.toggle('completed', i < currentStep);
            }
            updateButtons();
            updateProgressBar();
        }

        function updateButtons() {
            const btnBack = document.getElementById('btn-back');
            const btnNext = document.getElementById('btn-next');
            const btnCancel = document.getElementById('btn-cancel');

            btnBack.classList.toggle('d-none', currentStep === 1);
            btnCancel.classList.toggle('d-none', currentStep !== 1);

            if (currentStep === totalSteps) {
                btnNext.innerHTML = isEdit ?
                    'حفظ التعديلات <i class="bi bi-check-circle ms-1"></i>' :
                    'حفظ واعتماد عائلة الأيتام <i class="bi bi-shield-fill-check ms-1"></i>';
                btnNext.classList.remove('btn-primary');
                btnNext.classList.add('btn-success');
            } else {
                btnNext.innerHTML = 'التالي <i class="bi bi-arrow-left-short align-middle fs-5"></i>';
                btnNext.classList.remove('btn-success');
                btnNext.classList.add('btn-primary');
            }
        }

        function updateProgressBar() {
            const stepPct = ((currentStep - 1) / (totalSteps - 1)) * 95;
            document.getElementById('step-progress').style.width = stepPct + '%';
        }

        // القفز التلقائي للخطوة التي تعود بأخطاء validation من السيرفر
        const erroredFields = @json($errors->keys());
        (function initWizard() {
            if (erroredFields && erroredFields.length) {
                let earliest = null;
                erroredFields.forEach(f => {
                    const s = fieldStep[f];
                    if (s && (earliest === null || s < earliest)) earliest = s;
                });
                if (earliest) currentStep = earliest;
            }
            refreshUI();
        })();

        // معالجة إظهار وإخفاء الحقول المشروطة عند تجهيز الـ DOM
        document.addEventListener('DOMContentLoaded', function() {
            // 1. تفاصيل وفاة الأم
            const motherAliveYes = document.getElementById('mother-alive-yes');
            const motherAliveNo = document.getElementById('mother-alive-no');
            const motherDeathDetails = document.getElementById('mother-death-details');

            function toggleMotherDetails() {
                if (motherAliveNo && motherAliveNo.checked) {
                    motherDeathDetails.style.display = 'block';
                } else {
                    motherDeathDetails.style.display = 'none';
                }
            }

            if (motherAliveYes && motherAliveNo && motherDeathDetails) {
                motherAliveYes.addEventListener('change', toggleMotherDetails);
                motherAliveNo.addEventListener('change', toggleMotherDetails);
                toggleMotherDetails();
            }

            // 2. تفاصيل حالة الوصي الصحية
            const guardianHealthSelect = document.getElementById('guardian_health_status');
            const guardianHealthDetailsWrapper = document.getElementById('guardian-health-details-wrapper');

            function toggleGuardianHealthDetails() {
                if (guardianHealthSelect && guardianHealthDetailsWrapper) {
                    guardianHealthDetailsWrapper.style.display = (guardianHealthSelect.value === 'مريض') ? 'block' :
                        'none';
                }
            }

            if (guardianHealthSelect) {
                guardianHealthSelect.addEventListener('change', toggleGuardianHealthDetails);
                toggleGuardianHealthDetails();
            }

            // 3. تفاصيل أضرار السكن
            const housingConditionSelect = document.getElementById('housing_condition');
            const housingDamageWrapper = document.getElementById('housing-damage-wrapper');

            function toggleHousingDamageDetails() {
                if (housingConditionSelect && housingDamageWrapper) {
                    housingDamageWrapper.style.display = (housingConditionSelect.value === 'غير صالح') ? 'block' :
                        'none';
                }
            }

            if (housingConditionSelect) {
                housingConditionSelect.addEventListener('change', toggleHousingDamageDetails);
                toggleHousingDamageDetails();
            }
        });
    </script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
