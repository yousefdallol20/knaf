<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GuardiansController;
use App\Http\Controllers\HomeController;
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
});

Route::get('/orphans', [HomeController::class, 'orphans'])->name('orphans');
Route::get('/orphans_details/{id}', [HomeController::class, 'orphans_details'])->name('orphans_details');


// ===================================================
// ================== Guest / Auth Routes ============
// ===================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])    ;

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

// مسار تسجيل الخروج لكل مستخدمي النظام
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


// ===================================================
// ================= Protected Routes ================
// ===================================================
Route::middleware(['auth'])->group(function () {

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

        Route::get('/payments', [SponsorController::class, 'payments'])->name('payments');
        Route::get('documentation', [SponsorController::class, 'documentation'])->name('documentation');
        Route::get('notifications', [SponsorController::class, 'notifications'])->name('notifications');
        Route::get('profile_sponser', [SponsorController::class, 'profile_sponser'])->name('profile_sponser');
        Route::post('/update_Profile_Fields', [SponsorController::class, 'update_Profile_Fields'])->name('update_Profile_Fields');
        Route::post('/update_Password', [SponsorController::class, 'update_Password'])->name('update_Password');

    });
});
