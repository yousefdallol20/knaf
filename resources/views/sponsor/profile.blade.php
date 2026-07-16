<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة الكافل - الملف الشخصي وإعداداتي</title>
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

                <li class="menu-item active">
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
                            <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}" alt="رمز" class="rounded-circle" width="30" height="30"
                                style="object-fit: cover;">
                            <span class="text-small fw-bold">{{ $user->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
                            <li><a class="dropdown-item text-small text-right" href="{{ route('profile_sponser') }}"><i
                                        class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-small text-danger text-right"
                                    href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> خروج
                                    آمن</a></li>
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
                            <li class="breadcrumb-item active" aria-current="page">إعدادات ملفي الشخصي</li>
                        </ol>
                    </nav>
                </div>

                <!-- عرض رسائل النجاح أو الأخطاء للمستخدم -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Left sidebar: Account info status -->
                    <div class="col-lg-4 text-center">
                        <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                            <div class="dropdown d-inline-block mb-3">
                                <div class="position-relative profile-img-container" id="avatarDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}"
                                        id="profile-avatar-preview" alt="الصورة الشخصية"
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
                            <h5 class="fw-bold text-dark mb-1" name="name">{{ $user->name }}</h5>
                            <p class="text-muted text-small mb-3">كافل معتمد -
                                {{ $user->sponsor->country ?? 'غير محدد' }}</p>
                            <hr>
                            <div class="text-right text-small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">حالة الكافل:</span>
                                    <strong class="text-success">نشط ملتزم</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">البريد المعتمد:</span>
                                    <strong class="text-dark font-monospace"
                                        name="email">{{ $user->email }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">رقم الجوال:</span>
                                    <strong class="text-dark font-monospace"
                                        name="phone">{{ $user->phone }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right sidebar: Modify configurations Form -->
                    <div class="col-lg-8">
                        <!-- Account Form -->
                        <div class="bg-white p-4 rounded-4 border shadow-sm mb-4">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-person-fill text-primary-green me-1"></i> تعديل بيانات الحساب الأساسية
                            </h5>

                            <form id="profile-edit-form" class="needs-validation" novalidate
                                action="{{ route('update_Profile_Fields') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- حقل مخفي لرفع الصورة تم وضعه هنا ليكون داخل الفورم الرئيسي بشكل صحيح -->
                                <input type="file" id="avatar-file-input" name="profile_photo" accept="image/*"
                                    style="display: none;" onchange="previewSelectedAvatar(this)">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">الاسم ثلاثي أو
                                            رباعي</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('name', $user->name) }}" name="name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">البريد الإلكتروني
                                            المفضل</label>
                                        <input type="email" class="form-control font-monospace"
                                            value="{{ old('email', $user->email) }}" name="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">رقم الجوال الفعال
                                            للتحقق</label>
                                        <input type="tel" class="form-control font-monospace" name="phone"
                                            value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">مدينة الإقامة
                                            الفعلية</label>
                                        <input type="text" class="form-control" name="country"
                                            value="{{ old('country', $user->sponsor->country) }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 px-4 py-2 text-small">حفظ التغييرات
                                    الجديدة</button>
                            </form>
                        </div>

                        <!-- Password Form -->
                        <div class="bg-white p-4 rounded-4 border shadow-sm">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                                    class="bi bi-key-fill text-primary-green me-1"></i> تغيير كلمة المرور الآمنة</h5>

                            <form id="password-edit-form" class="needs-validation" novalidate
                                action="{{ route('update_Password') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label text-small fw-semibold text-muted">كلمة المرور القديمة
                                            الحالية</label>
                                        <input type="password" class="form-control" placeholder="••••••••" required name="current_password">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">كلمة المرور
                                            الجديدة</label>
                                        <input type="password" id="new-password" class="form-control"
                                            placeholder="6 رموز كحد أدنى" minlength="6" required name="password">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-small fw-semibold text-muted">تأكيد كلمة المرور
                                            الجديدة</label>
                                        <input type="password" id="confirm-password" class="form-control"
                                            placeholder="تطابق كلمة المرور" minlength="6" required name="password_confirmation">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 px-4 py-2 text-small">تعديل وتحديث
                                    الرقم
                                    السري</button>
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
                    <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}"
                        id="modal-full-image" class="img-fluid rounded-4 shadow" style="max-height: 80vh;"
                        alt="صورة الملف الشخصي الكاملة">
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
