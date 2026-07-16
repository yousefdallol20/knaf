<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة الكافل - الإشعارات والرسائل</title>
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

        <li class="menu-item active">
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
            <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2" type="button"
              id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ $user->sponsor && $user->sponsor->image ? asset('Uploads/sponsors/' . $user->sponsor->image) : asset('Uploads/parents/default.png') }}" alt="رمز" class="rounded-circle"
                width="30" height="30" style="object-fit: cover;">
              <span class="text-small fw-bold">{{ $user->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu">
              <li><a class="dropdown-item text-small text-right" href="{{ route('profile_sponser') }}"><i
                    class="bi bi-gear-fill me-2 text-muted"></i> إعدادات حسابي</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-small text-danger text-right" href="{{ route('logout') }}"><i
                    class="bi bi-box-arrow-right me-2"></i> خروج آمن</a></li>
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
              <li class="breadcrumb-item active" aria-current="page">الإشعارات</li>
            </ol>
          </nav>
        </div>

        <div class="row g-4">
          <div class="col-lg-10 mx-auto">
            <div class="bg-white rounded-4 border shadow-sm p-4">

              <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bell-fill text-primary-green me-1"></i> تنبيهات حسابك
                  الساري</h5>
                <button onclick="markAllNotificationsAsRead()" class="btn btn-outline-primary btn-sm"><i
                    class="bi bi-check-all"></i> تحديد الكل كمقروء</button>
              </div>

              <!-- Notifications list feed -->
              <div class="d-flex flex-column gap-3">

                <div class="p-3 rounded-3 border border-success bg-success-subtle">
                  <div class="d-flex align-items-start gap-3">

                    <div class="p-2 rounded-circle bg-white border d-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;">
                      <i class="bi bi-credit-card-fill text-success fs-5"></i>
                    </div>

                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0">
                          تم استلام دفعتك الشهرية
                          <span class="badge bg-danger">جديد</span>
                        </h6>

                        <span class="text-muted small">
                          <i class="bi bi-clock"></i>
                          2026-06-10
                        </span>
                      </div>

                      <p class="text-muted mb-0">
                        تم استلام مبلغ الكفالة الشهري بنجاح وإضافته إلى سجل المدفوعات الخاص بك.
                      </p>
                    </div>

                  </div>
                </div>

                <div class="p-3 rounded-3 border">
                  <div class="d-flex align-items-start gap-3">

                    <div class="p-2 rounded-circle bg-white border d-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;">
                      <i class="bi bi-file-text-fill text-primary fs-5"></i>
                    </div>

                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0">
                          تقرير دراسي جديد
                        </h6>

                        <span class="text-muted small">
                          <i class="bi bi-clock"></i>
                          2026-06-08
                        </span>
                      </div>

                      <p class="text-muted mb-0">
                        تم رفع تقرير دراسي جديد لأحد الأيتام المكفولين لديك وأصبح متاحاً للمراجعة.
                      </p>
                    </div>

                  </div>
                </div>

                <div class="p-3 rounded-3 border">
                  <div class="d-flex align-items-start gap-3">

                    <div class="p-2 rounded-circle bg-white border d-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;">
                      <i class="bi bi-heart-fill text-danger fs-5"></i>
                    </div>

                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0">
                          تحديث حالة الكفالة
                        </h6>

                        <span class="text-muted small">
                          <i class="bi bi-clock"></i>
                          2026-06-05
                        </span>
                      </div>

                      <p class="text-muted mb-0">
                        تم تحديث بيانات أحد الأطفال المكفولين وإضافة معلومات جديدة إلى ملفه.
                      </p>
                    </div>

                  </div>
                </div>

                <div class="p-3 rounded-3 border">
                  <div class="d-flex align-items-start gap-3">

                    <div class="p-2 rounded-circle bg-white border d-flex align-items-center justify-content-center"
                      style="width:42px;height:42px;">
                      <i class="bi bi-shield-check text-info fs-5"></i>
                    </div>

                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold mb-0">
                          إشعار من إدارة كنف
                        </h6>

                        <span class="text-muted small">
                          <i class="bi bi-clock"></i>
                          2026-06-01
                        </span>
                      </div>

                      <p class="text-muted mb-0">
                        نشكركم على استمرار دعمكم ورعايتكم للأيتام، وتم تحديث سياسات المنصة مؤخراً.
                      </p>
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
