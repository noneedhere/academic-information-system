<?php

use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\BillController as AdminBillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// Guest Routes (unauthenticated)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// =========================================================================
// Authenticated Routes (all roles)
// =========================================================================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings (password change)
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');

    // =====================================================================
    // Teacher Routes
    // =====================================================================
    Route::middleware('role:teacher')->prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
    });

    // =====================================================================
    // Student Routes
    // =====================================================================
    Route::middleware('role:student')->group(function () {
        Route::get('/my-attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance.index');
        Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    });

    // =====================================================================
    // Head Admin Routes
    // =====================================================================
    Route::middleware('role:head_admin')->prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::resource('users', UserController::class)->except(['show']);

        // Attendance (read-only)
        Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');

        // Bill Management
        Route::resource('bills', AdminBillController::class)->except(['show']);
        Route::patch('/bills/{bill}/toggle-status', [AdminBillController::class, 'toggleStatus'])
            ->name('bills.toggle-status');
    });
});
