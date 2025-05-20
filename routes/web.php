<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationTypeController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Auth::routes();

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/role-register', [UserManagementController::class, 'registered'])->name('role.register');
    Route::get('/role-edit/{id}', [UserManagementController::class, 'registeredit'])->name('role.edit');
    Route::put('/role-register-update/{id}', [UserManagementController::class, 'registerupdate'])->name('role.update');
    Route::delete('/role-delete/{id}', [UserManagementController::class, 'registerdelete'])->name('role.delete');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update');

    Route::resource('products', ProductController::class)->middleware('permission:manage products');
    Route::resource('categories', CategoryController::class)->middleware('permission:manage products');
    Route::resource('suppliers', SupplierController::class)->middleware('permission:manage products');
    Route::resource('operation_types', OperationTypeController::class)->middleware('permission:manage operation types');
    Route::resource('operations', OperationController::class)->middleware('permission:manage stock');

    Route::prefix('pos')->group(function () {
        Route::get('/', [POSController::class, 'index'])->name('pos.index');
        Route::post('/', [POSController::class, 'store'])->name('pos.store');
    });

    Route::get('/low-stock', [ProductController::class, 'lowStock'])->name('low_stock');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');