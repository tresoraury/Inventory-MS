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
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->hasPermissionTo('view dashboard')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
})->middleware('auth');

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Auth::routes(['register' => false]); // Disable registration

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/role-register', [UserManagementController::class, 'registered'])->name('role.register');
    Route::get('/role-create', [UserManagementController::class, 'create'])->name('role.create');
    Route::post('/role-store', [UserManagementController::class, 'store'])->name('role.store');
    Route::get('/role-edit/{id}', [UserManagementController::class, 'registeredit'])->name('role.edit');
    Route::put('/role-register-update/{id}', [UserManagementController::class, 'registerupdate'])->name('role.update');
    Route::delete('/role-delete/{id}', [UserManagementController::class, 'registerdelete'])->name('role.delete');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/update', [RoleController::class, 'update'])->name('roles.update');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view dashboard');
    
    Route::resource('products', ProductController::class)->middleware('permission:manage products');
    Route::resource('categories', CategoryController::class)->middleware('permission:manage products');
    Route::resource('suppliers', SupplierController::class)->middleware('permission:manage products');
    Route::resource('operation_types', OperationTypeController::class)->middleware('permission:manage operation types');
    Route::resource('operations', OperationController::class)->middleware('permission:manage stock');

    Route::prefix('pos')->group(function () {
        Route::get('/', [POSController::class, 'index'])->name('pos.index')->middleware('permission:manage sales');
        Route::post('/', [POSController::class, 'store'])->name('pos.store')->middleware('permission:manage sales');
    });

    Route::get('/low-stock', [ProductController::class, 'lowStock'])->name('low_stock')->middleware('permission:manage products');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:view reports');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products')->middleware('permission:view reports');
    Route::get('/reports/operations', [ReportController::class, 'operations'])->name('reports.operations')->middleware('permission:view reports');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales')->middleware('permission:view reports');
    Route::get('/reports/suppliers', [ReportController::class, 'suppliers'])->name('reports.suppliers')->middleware('permission:view reports');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');