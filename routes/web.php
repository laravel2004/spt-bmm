<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::prefix('/')->group(function () {
    // Auth
    Route::get('login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', 'role:SUPERADMIN'])->group(function () {
        Route::prefix('/super-admin')->group(function () {
            Route::get('dashboard', [\App\Http\Controllers\SuperAdmin\Dashboard\DashboardController::class, 'index'])->name('superadmin.dashboard');

            Route::prefix('users-management')->group(function () {
                Route::get('/', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'index'])->name('superadmin.user-management.index');
                Route::get('/create', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'create'])->name('superadmin.user-management.create');
                Route::post('/store', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'store'])->name('superadmin.user-management.store');
                Route::get('/edit/{id}', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'edit'])->name('superadmin.user-management.edit');
                Route::put('/update/{id}', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'update'])->name('superadmin.user-management.update');
                Route::delete('/delete/{id}', [\App\Http\Controllers\SuperAdmin\UserManagement\UserManagementController::class, 'destroy'])->name('superadmin.user-management.delete');
            });

            Route::prefix('vehicle')->group(function () {
                Route::get('/', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'index'])->name('superadmin.vehicle.index');
            });
        });
    });

    Route::middleware(['auth', 'role:ADMIN'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('dashboard', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('admin.dashboard');
        });
    });

    Route::middleware(['auth', 'role:DRIVER'])->group(function () {
        Route::prefix('/driver')->group(function () {
            Route::get('dashboard', [\App\Http\Controllers\Driver\Dashboard\DashboardController::class, 'index'])->name('driver.dashboard');
        });
    });

});
