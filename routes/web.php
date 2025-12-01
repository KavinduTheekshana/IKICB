<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CourseController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Course routes
Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/{course}', [CourseController::class, 'show'])->name('show');
    Route::get('/module/{module}', [CourseController::class, 'module'])->name('module');
});

// Dashboard routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/my-courses', [DashboardController::class, 'myCourses'])->name('.my-courses');
        Route::get('/payments', [DashboardController::class, 'payments'])->name('.payments');
    });

    // Payment routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::post('/course/{course}', [PaymentController::class, 'initiateCoursePayment'])->name('course');
        Route::post('/module/{module}', [PaymentController::class, 'initiateModulePayment'])->name('module');
        Route::get('/return', [PaymentController::class, 'return'])->name('return');
        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
    });
});

// PayHere notification (no auth required)
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');
