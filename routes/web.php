<?php

use App\Http\Controllers\FilamentAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\SubmissionController;
use App\Models\Module;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Course Details Pages
Route::get('/courses-overview', function () {
    return view('frontend.courses-overview');
})->name('courses.overview');

// Policy routes
Route::get('/terms', function () {
    return view('frontend.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('frontend.privacy');
})->name('privacy');

Route::get('/cookies', function () {
    return view('frontend.cookies');
})->name('cookies');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot password / OTP flow
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Course routes
Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/{course}', [CourseController::class, 'show'])->name('show');
    Route::get('/module/{module}', [CourseController::class, 'module'])->name('module');

    // Quiz and completion (authenticated)
    Route::middleware('auth')->group(function () {
        Route::post('/module/{module}/quiz', [CourseController::class, 'submitQuiz'])->name('module.quiz');
        Route::post('/module/{module}/complete', [CourseController::class, 'completeModule'])->name('module.complete');
    });
});

// Dashboard routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/my-courses', [DashboardController::class, 'myCourses'])->name('.my-courses');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('.payments');
    });

    // Submission routes
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [SubmissionController::class, 'index'])->name('index');
        Route::get('/create', [SubmissionController::class, 'create'])->name('create');
        Route::post('/', [SubmissionController::class, 'store'])->name('store');
        Route::post('/bunny-prepare', [SubmissionController::class, 'prepareBunnyUpload'])->name('bunny.prepare');
        Route::post('/bunny-confirm', [SubmissionController::class, 'confirmBunnyUpload'])->name('bunny.confirm');
        Route::get('/{submission}', [SubmissionController::class, 'show'])->name('show');
    });

    // Payment routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::post('/course/{course}', [PaymentController::class, 'initiateCoursePayment'])->name('course');
        Route::post('/module/{module}', [PaymentController::class, 'initiateModulePayment'])->name('module');
        Route::post('/webxpay/process', [PaymentController::class, 'processWebxpayPayment'])->name('webxpay.process');
        Route::post('/bank-transfer/submit', [PaymentController::class, 'submitBankTransfer'])->name('bank-transfer.submit');
        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    });
});

// WEBXPAY return URL (no auth required — WEBXPAY POSTs back via browser redirect)
Route::post('/payment/webxpay/return', [PaymentController::class, 'webxpayReturn'])->name('payment.webxpay.return');

// Filament panel OTP password reset (admin + branch)
foreach (['admin', 'branch'] as $panel) {
    Route::prefix($panel)->middleware('web')->group(function () use ($panel) {
        Route::get('/forgot-password', [FilamentAuthController::class, 'showForgotPassword'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.forgot-password");
        Route::post('/forgot-password', [FilamentAuthController::class, 'sendOtp'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.send-otp");
        Route::get('/verify-otp', [FilamentAuthController::class, 'showVerifyOtp'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.verify-otp");
        Route::post('/verify-otp', [FilamentAuthController::class, 'verifyOtp'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.verify-otp.submit");
        Route::get('/reset-password', [FilamentAuthController::class, 'showResetPassword'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.reset-password");
        Route::post('/reset-password', [FilamentAuthController::class, 'resetPassword'])
            ->defaults('panel', $panel)
            ->name("filament.{$panel}.auth.reset-password.submit");
    });
}

// Admin: prepare direct Bunny.net video upload (returns tus credentials; file never touches this server)
Route::post('/admin-api/bunny-prepare-video', [\App\Http\Controllers\Admin\BunnyController::class, 'prepareVideoUpload'])
    ->middleware('auth')
    ->name('admin.bunny.prepare.video');

// API helper: get modules for a course (used by submission create form)
Route::get('/api/courses/{course}/modules', function (\App\Models\Course $course) {
    return $course->modules()->orderBy('order')->get(['id', 'title']);
})->middleware('auth');

// Fallback route - must be last
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
