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
                Route::get('/create', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'create'])->name('superadmin.vehicle.create');
                Route::post('/store', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'store'])->name('superadmin.vehicle.store');
                Route::get('/edit/{id}', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'edit'])->name('superadmin.vehicle.edit');
                Route::put('/update/{id}', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'update'])->name('superadmin.vehicle.update');
                Route::delete('/delete/{id}', [\App\Http\Controllers\SuperAdmin\Vehicle\VehicleController::class, 'destroy'])->name('superadmin.vehicle.delete');
            });

            Route::prefix('transportir')->group(function () {
                Route::get('/', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'index'])->name('superadmin.transportir.index');
                Route::get('/create', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'create'])->name('superadmin.transportir.create');
                Route::post('/store', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'store'])->name('superadmin.transportir.store');
                Route::get('/edit/{id}', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'edit'])->name('superadmin.transportir.edit');
                Route::put('/update/{id}', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'update'])->name('superadmin.transportir.update');
                Route::delete('/delete/{id}', [\App\Http\Controllers\SuperAdmin\Transportir\TransportirController::class, 'destroy'])->name('superadmin.transportir.delete');
            });

            Route::prefix('customer')->group(function () {
                Route::get('/', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'index'])->name('superadmin.customer.index');
                Route::get('/create', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'create'])->name('superadmin.customer.create');
                Route::post('/store', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'store'])->name('superadmin.customer.store');
                Route::get('/edit/{id}', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'edit'])->name('superadmin.customer.edit');
                Route::put('/update/{id}', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'update'])->name('superadmin.customer.update');
                Route::delete('/delete/{id}', [\App\Http\Controllers\SuperAdmin\Customer\CustomerController::class, 'destroy'])->name('superadmin.customer.delete');
            });

            Route::prefix('driver')->group(function () {
                Route::get('/', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'index'])->name('superadmin.driver.index');
                Route::get('/create', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'create'])->name('superadmin.driver.create');
                Route::post('/store', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'store'])->name('superadmin.driver.store');
                Route::get('/{id}/edit', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'edit'])->name('superadmin.driver.edit');
                Route::put('/{id}', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'update'])->name('superadmin.driver.update');
                Route::delete('/{id}', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'destroy'])->name('superadmin.driver.delete');
                Route::get('/{id}', [\App\Http\Controllers\SuperAdmin\Driver\DriverController::class, 'show'])->name('superadmin.driver.show');
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
