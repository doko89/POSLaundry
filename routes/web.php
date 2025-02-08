<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Owner Controllers
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\WorkerController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\Owner\ProfileController as OwnerProfileController;
use App\Http\Controllers\Owner\WhatsAppController;

// Worker Controllers
use App\Http\Controllers\Worker\DashboardController as WorkerDashboardController;
use App\Http\Controllers\Worker\CustomerController;
use App\Http\Controllers\Worker\OrderController;
use App\Http\Controllers\Worker\StatusController;
use App\Http\Controllers\Worker\ProfileController as WorkerProfileController;
use App\Http\Controllers\Worker\TransactionController;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KiosController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityLogController;


    // Owner Routes
    Route::group(['middleware' => ['auth', 'role:owner'], 'prefix' => 'owner', 'as' => 'owner.'], function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('workers', WorkerController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::resource('services', ServiceController::class);
        Route::get('/profile', [OwnerProfileController::class, 'index'])->name('profile');

        // WhatsApp Routes
        Route::get('/whatsapp/scan', [WhatsAppController::class, 'showScanPage'])->name('whatsapp.scan');
        Route::get('/whatsapp/generate-qr', [WhatsAppController::class, 'generateQR'])->name('whatsapp.generate-qr');
        Route::post('/whatsapp/verify', [WhatsAppController::class, 'verifyConnection'])->name('whatsapp.verify');
    });

    // Worker Routes
    Route::group(['middleware' => ['auth', 'role:worker'], 'prefix' => 'worker', 'as' => 'worker.'], function () {
        // Dashboard
        Route::get('/dashboard', [WorkerDashboardController::class, 'index'])->name('dashboard');

        // Orders
        Route::resource('orders', OrderController::class);
        Route::put('/orders/{order}/process', [OrderController::class, 'process'])->name('orders.process');
        Route::put('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        // Customers
        Route::resource('customers', CustomerController::class);
        Route::post('/customers/quick-store', [CustomerController::class, 'quickStore'])->name('customers.quick-store');

        // Status &amp; Profile
        Route::get('/status', [StatusController::class, 'index'])->name('status.index');
        Route::post('/status/start', [StatusController::class, 'start'])->name('status.start');
        Route::post('/status/end', [StatusController::class, 'end'])->name('status.end');
        Route::get('/profile', [WorkerProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [WorkerProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [WorkerProfileController::class, 'updatePassword'])->name('profile.update-password');

        // Transactions
        Route::resource('transactions', TransactionController::class)->only(['index', 'store', 'show']);
        Route::put('/transactions/{transaction}/mark-as-paid', [TransactionController::class, 'markAsPaid'])->name('transactions.mark-as-paid');
    });

    // Admin Routes
    Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('kios', KiosController::class);
        Route::resource('users', UserController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

Auth::routes([
    'register' => false,
    'reset' => true,
    'verify' => false
]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'owner' => redirect()->route('owner.dashboard'),
            'worker' => redirect()->route('worker.dashboard'),
            default => redirect()->route('login')
        };
    }
    return redirect()->route('login');
});
