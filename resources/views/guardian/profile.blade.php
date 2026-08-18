<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الوصي - الملف الشخصي وإعداداتي</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    <link class="styles" rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>

    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div id="kanaf-sidebar">
            <div class="sidebar d-flex flex-column" id="kanaf-sidebar-wrapper">
                <div class="brand">
                    <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="كنف" height="35"> -->
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
                    <li class="menu-item active" id="menu-profile">
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
                    <h4 class="fw-bold mb-0 text-dark">إعدادات ملف الوصي الرئيسي</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">إعدادات ملفي الشخصي كوصي</li>
                        </ol>
                    </nav>
                </div>

                <!-- عرض رسائل النجاح أو الأخطاء للمستخدم -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-lg-4 text-center">
                        <div class="bg-white p-4 rounded-4 border shadow-sm text-center">

                            <div class="dropdown d-inline-block mb-3">
                                <div class="position-relative profile-img-container" id="avatarDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
                                        onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                                        id="profile-avatar-preview" alt=""
                                        class="rounded-circle border border-3 border-success shadow-xs" width="110"
                                        height="110" style="object-fit: cover;">
                                </div>
                                <ul class="dropdown-menu dropdown-menu-center shadow border-0 avatar-dropdown-menu"
                                    aria-labelledby="avatarDropdown">
                                    <li>
                                        <a class="dropdown-item text-small" href="#" data-bs-toggle="modal"
                                            data-bs-target="#viewImageModal">
                                            <i class="bi bi-eye me-2 text-muted"></i> عرض الصورة
                                        </a>
                                    </li>
                                    <li>
                                        <label class="dropdown-item text-small mb-0 style-pointer"
                                            style="cursor: pointer;" for="avatar-file-input">
                                            <i class="bi bi-camera me-2 text-muted"></i> تغيير الصورة
                                        </label>
                                    </li>
                                </ul>
                            </div>

                            <h5 class="fw-bold text-dark mb-1" id="profile-guardian-name">{{ $user->name }}</h5>
                           <!-- التعديل هنا: إزالة old() لعرض القيمة المحدثة فوراً من قاعدة البيانات -->
<p class="text-muted text-small mb-3" id="profile-guardian-city">شريك وصية معتمدة |
    {{ $housing->current_displacement_destination ?? 'غير محدد' }}
</p>

                            <hr>
                            <div class="text-right text-small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">الصفة العائلية:</span>
                                    <strong class="text-dark"
                                        id="profile-guardian-relation">{{ $user->guardian->kinship_relation ?? 'وصي شرعي' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">رقم هوية الوصية الصادرة:</span>
                                    <strong
                                        class="text-dark font-monospace">{{ $user->guardian->national_id ?? 'غير متوفر' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">الحالة الاجتماعية:</span>
                                    <strong class="text-primary-green"
                                        id="profile-guardian-status">{{ $user->guardian->marital_status ?? 'غير محدد' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">تاريخ الميلاد:</span>
                                    <strong
                                        class="text-muted font-monospace">{{ $user->guardian->birth_date ?? 'غير محدد' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-person-fill text-primary-green me-1"></i> تعديل بيانات ملف الوصي</h5>

                            <form id="guardian-edit-form" class="needs-validation"
                                action="{{ route('profile.update.fields') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- حقل رفع الصورة الشخصية -->
                                <input type="file" id="avatar-file-input" name="profile_photo" accept="image/*"
                                    style="display: none;" onchange="previewSelectedAvatar(this)">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">اسم الوصي
                                            بالكامل</label>
                                        <input type="text" name="name" id="p-guard-name" class="form-control"
                                            value="{{ old('name', $user->name) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">رقم الهاتف
                                            الفعال</label>
                                        <input type="tel" name="phone" id="p-guard-phone"
                                            class="form-control font-monospace"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">البريد
                                            الإلكتروني</label>
                                        <input type="email" name="email" id="p-guard-original-city"
                                            class="form-control" value="{{ old('email', $user->email) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">وجهة النزوح
                                            الحالية</label>
                                        <input type="text" name="current_displacement_destination"
                                            id="p-guard-displacement" class="form-control"
                                            value="{{ $housing->current_displacement_destination ?? '' }}">
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">الحالة الصحية
                                            للوصي</label>
                                        <input type="text" name="health_status" id="p-guard-health"
                                            class="form-control"
                                            placeholder="اكتب الحالة الصحية الحالية أو أي التزامات طبية إن وجدت"
                                            value="{{ old('health_status', $user->guardian->health_status ?? '') }}">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4 px-4 py-2 text-small">تحديث
                                    البيانات</button>
                            </form>
                        </div>

                        <!-- Pass config editing form -->
                        <div class="bg-white p-4 rounded-4 border shadow-sm">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-key-fill text-primary-green me-1"></i> تغيير كلمة المرور المعتمدة</h5>

                            <form id="guardian-pass-form" class="needs-validation" novalidate
                                action="{{ route('profile.update.password') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">الرقم السري
                                            الحالي</label>
                                        <input type="password" name="current_password" class="form-control"
                                            placeholder="••••••••" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">الرقم السري
                                            الجديد</label>
                                        <input type="password" name="password" id="g-pass-new" class="form-control"
                                            placeholder="6 رموز على الأقل" minlength="6" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">تأكيد كلمة المرور
                                            الجديدة</label>
                                        <input type="password" name="password_confirmation" id="g-pass-confirm"
                                            class="form-control" placeholder="التطابق الحرفي المطلوب" minlength="6"
                                            required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 px-4 py-2 text-small">تحديث الرقم
                                    السري الآمن</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-body text-center p-0 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-none"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <!-- تعديل مسار الصورة هنا ليعرض صورة المستخدم الحالية بدقة بدلاً من الصورة الاستاتيكية -->
                    <img src="{{ $user->guardian && $user->guardian->image ? asset('Uploads/guardians/' . $user->guardian->image) : asset('Uploads/guardians/default.png') }}"
                        onerror="this.onerror=null;this.src='{{ asset('Uploads/orphans/default.png') }}';"
                        id="modal-full-image" class="img-fluid rounded-4 shadow" style="max-height: 80vh;"
                        alt=" ">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // دالة استعراض وتحديث الصورة الشخصية محلياً فور اختيارها قبل الحفظ الفعلي
        function previewSelectedAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // تحديث الصورة في الكرت الجانبي
                    document.getElementById('profile-avatar-preview').src = e.target.result;
                    // تحديث الصورة داخل نافذة العرض المكبرة
                    document.getElementById('modal-full-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
