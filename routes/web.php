<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GuardiansController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\sponsorshipController;
use Illuminate\Support\Facades\Route;

// ===================================================
// =================== Public Routes =================
// ===================================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/knaf', function () {
    return view('index');
})->name('knaf');

Route::get('/orphans', [HomeController::class, 'orphans'])->name('orphans');
Route::get('/orphans_details/{id}', [HomeController::class, 'orphans_details'])->name('orphans_details');


// ===================================================
// ================== Guest / Auth Routes ============
// ===================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // مسارات إعادة تعيين كلمة المرور الجديدة عبر الرابط
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

// ===================================================
// ================= Protected Routes ================
// ===================================================
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    // ---------------------------------------------------
    // -------------------- Guardians --------------------
    // ---------------------------------------------------
    Route::group([], function () {
        Route::get('/dashboard', [GuardiansController::class, 'dashboard'])->name('dashboard');
        Route::get('/children', [GuardiansController::class, 'children'])->name('children');
        Route::get('/child_form', [GuardiansController::class, 'child_form'])->name('child_form');
        Route::post('/new_child_form', [GuardiansController::class, 'new_child_form'])->name('new_child_form');

        Route::get('/children/{id}/edit', [GuardiansController::class, 'edit'])->name('children.edit');
        Route::put('/children/{id}', [GuardiansController::class, 'update'])->name('children.update');
        Route::delete('/children/{id}', [GuardiansController::class, 'destroy'])->name('children.destroy');

        Route::get('/upload_docs', [GuardiansController::class, 'upload_docs'])->name('upload_docs');
        Route::post('/upload_docs_store', [GuardiansController::class, 'upload_docs_store'])->name('upload_docs_store');
        Route::get('/received_payments', [GuardiansController::class, 'received_payments'])->name('received_payments');

        Route::get('/notifications', [GuardiansController::class, 'notifications'])->name('guardian.notifications');
        Route::post('/guardian/notifications/mark-all-read', [GuardiansController::class, 'markAllRead'])->name('guardian_notifications.markAllRead');

        Route::get('/profile', [GuardiansController::class, 'profile'])->name('profile');
        Route::post('/profile/update-fields', [GuardiansController::class, 'updateProfileFields'])->name('profile.update.fields');
        Route::post('/profile/update-password', [GuardiansController::class, 'updatePassword'])->name('profile.update.password');
    });

    // -------------------------------------------------
    // ------------------- Sponsor ---------------------
    // -------------------------------------------------
    Route::group([], function () {
        Route::get('/dashboard_sponsor', [SponsorController::class, 'dashboard_sponsor'])->name('dashboard_sponsor');
        Route::get('/sponsorships', [SponsorController::class, 'sponsorships'])->name('sponsorships');
        Route::get('/sponsorship_detail/{id}', [SponsorController::class, 'sponsorship_detail'])->name('sponsorship_detail');

        Route::get('/step1/{id}', [sponsorshipController::class, 'step1'])->name('step1');
        Route::get('/create_step2', [sponsorshipController::class, 'create_step2'])->name('create_step2');
        Route::post('/step2', [sponsorshipController::class, 'step2'])->name('step2');
        Route::get('/create_step3', [sponsorshipController::class, 'create_step3'])->name('create_step3');
        Route::post('/step3', [sponsorshipController::class, 'step3'])->name('step3');

        // عرض الصفحة
        Route::get('/payments', [SponsorController::class, 'payments'])->name('payments');

        // تصدير كشف الحساب CSV
        Route::get('/payments/export-csv', [SponsorController::class, 'exportPaymentsCsv'])->name('payments.export.csv');

        // تحميل الإيصال المالي
        Route::get('/payments/{id}/download-receipt', [SponsorController::class, 'downloadReceipt'])->name('payments.download.receipt');

        // تسجيل دفعة كفالة فورية
        Route::post('/payments/store-manual', [SponsorController::class, 'storeManualPayment'])->name('payments.store.manual');

        Route::get('documentation', [SponsorController::class, 'documentation'])->name('documentation');
        Route::get('/notifications/sponsor', [SponsorController::class, 'sponsorIndex'])->name('notifications');
        Route::post('/notifications/mark-all-read', [SponsorController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::get('profile_sponser', [SponsorController::class, 'profile_sponser'])->name('profile_sponser');
        Route::post('/update_Profile_Fields', [SponsorController::class, 'update_Profile_Fields'])->name('update_Profile_Fields');
        Route::post('/update_Password', [SponsorController::class, 'update_Password'])->name('update_Password');
    });

    // -------------------------------------------------
    // -------------------- admin ----------------------
    // -------------------------------------------------

    Route::group([], function () {
        Route::get('/dashboard_admin', [AdminController::class, 'dashboard_admin'])->name('dashboard_admin');
        Route::get('/orphans_admin', [AdminController::class, 'orphans_admin'])
            ->name('orphans_admin');

        // مسار عرض التفاصيل الكاملة ليتيم محدد (حل مشكلة الارتباط وتمرير الـ ID)
        Route::get('/Orphan_Details/{id}', [AdminController::class, 'Orphan_Details'])
            ->name('Orphan_Details');

        // مسار إرسال نموذج قبول واعتماد طلب اليتيم وتحديد مبلغ الكفالة
        Route::post('/orphans/{id}/approve', [AdminController::class, 'approveOrphan'])
            ->name('orphans.approve');

        // مسار إرسال نموذج رفض الطلب وتحديد نوع الرفض والسبب
        Route::post('/orphans/{id}/reject', [AdminController::class, 'rejectOrphan'])
            ->name('orphans.reject');

        // ======================================

        Route::get('/families', [AdminController::class, 'families'])->name('families_admin');
        Route::post('/admin/families/{id}/approve', [AdminController::class, 'approveFamily'])->name('admin.families.approve');
        Route::post('/admin/families/{id}/reject', [AdminController::class, 'rejectFamily'])->name('admin.families.reject');
        // ===================
        Route::get('/showSponsors', [AdminController::class, 'showSponsors'])->name('showSponsors');
        Route::put('/admin/sponsors/{id}', [AdminController::class, 'updateSponsor'])->name('admin.sponsors.update');

        Route::patch('/admin/sponsors/{id}/toggle-status', [AdminController::class, 'toggleSponsorStatus'])->name('admin.sponsors.toggleStatus');
        // ===================
        // مسار تغيير حالة عقد الكفالة (تفعيل / تعليق)
        // Route::patch('/admin/sponsorships/{id}/toggle-status', [AdminController::class, 'toggleSponsorshipStatus'])->name('admin.sponsorships.toggleStatus');
        // رابط صفحة إدارة عقود الكفالات في لوحة التحكم للآدمن
        Route::get('/admin/sponsorships', [AdminController::class, 'sponsorships_admin'])->name('sponsorships_admin');
        // ===================

        // مسارات إدارة المدفوعات والتدقيق المالي
        Route::get('/admin/payments', [AdminController::class, 'payments_admin'])->name('payments_admin');
        Route::post('/admin/payments/{id}/approve', [AdminController::class, 'approve_payment'])->name('approve_payment');
        Route::delete('/admin/payments/{id}/delete', [AdminController::class, 'delete_payment'])->name('payments_delete');

        // مسارات نظام مراجعة وتدقيق المستندات للآدمن
        Route::get('/admin/documents', [AdminController::class, 'documents_admin'])->name('documents_admin');
        Route::post('/admin/documents/{id}/approve', [AdminController::class, 'approve_document'])->name('documents_approve');
        Route::post('/admin/documents/{id}/reject', [AdminController::class, 'reject_document'])->name('documents_reject');


        Route::get('/admin/reports', [AdminController::class, 'reports_admin'])->name('reports_admin');
        Route::post('/admin/reports/generate', [AdminController::class, 'generate_report'])->name('reports_generate');
        Route::get('/admin/reports/download/{file}', [AdminController::class, 'download_ready_report'])->name('reports_download');

        Route::get('/admin/audit-logs', [AdminController::class, 'audit_logs_admin'])->name('audit_admin');


        Route::get('/admin/notifications', [AdminController::class, 'adminIndex'])->name('admin.notifications.index');
        Route::post('/admin/notifications/send', [AdminController::class, 'sendBroadcast'])->name('admin.notifications.send');

        // رابط عرض الصفحة والجدول الرئيسي
        Route::get('/users', [AdminController::class, 'users_index'])->name('admin.users.index');

        // ✅ المسار الجديد الصحيح
        Route::patch('/admin/users/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
        Route::get('/permissions', [AdminController::class, 'permissions'])->name('admin.permissions.index');


        Route::get('/settings', [AdminController::class, 'settings_index'])->name('admin.settings.index');

        // تحديث إعدادات المفتاح والقيمة التابعة للأقسام
        Route::post('/update', [AdminController::class, 'update'])->name('admin.settings.update');

        // رفع شعار المنظمة بشكل منفصل
        Route::post('/upload-logo', [AdminController::class, 'uploadLogo'])->name('admin.settings.uploadLogo');
    });
});
