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
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingsController;
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

Auth::routes(['register' => false]);

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
    Route::resource('customers', CustomerController::class)->middleware('permission:manage customers');

    Route::prefix('pos')->group(function () {
        Route::post('/confirm', [POSController::class, 'confirmSale'])->name('pos.confirm')->middleware('permission:manage sales');
        Route::delete('/remove-from-cart/{id}', [POSController::class, 'removeFromCart'])->name('pos.remove-from-cart')->middleware('permission:manage sales');
        Route::delete('/clear-cart', [POSController::class, 'clearCart'])->name('pos.clear-cart')->middleware('permission:manage sales');
        Route::get('/search-products', [POSController::class, 'searchProducts'])->name('pos.search-products')->middleware('permission:manage sales');
        Route::post('/add-to-cart', [POSController::class, 'addToCart'])->name('pos.add-to-cart')->middleware('permission:manage sales');
        Route::get('/', [POSController::class, 'index'])->name('pos.index')->middleware('permission:manage sales');
        Route::get('/create', [POSController::class, 'create'])->name('pos.create')->middleware('permission:manage sales');
        Route::post('/store', [POSController::class, 'store'])->name('pos.store')->middleware('permission:manage sales');
        Route::get('/transaction/{saleTransaction}/edit', [POSController::class, 'edit'])->name('pos.edit')->middleware('permission:manage sales');
        Route::put('/transaction/{saleTransaction}', [POSController::class, 'update'])->name('pos.update')->middleware('permission:manage sales');
        Route::delete('/transaction/{saleTransaction}', [POSController::class, 'destroy'])->name('pos.destroy')->middleware('permission:manage sales');
        Route::get('/transaction/{saleTransaction}/view', [POSController::class, 'view'])->name('pos.view')->middleware('permission:manage sales');
        Route::post('/test-confirm', [POSController::class, 'confirmSale'])->name('pos.test-confirm')->middleware('permission:manage sales');
    });

    Route::get('/low-stock', [ProductController::class, 'lowStock'])->name('low_stock')->middleware('permission:manage products');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:view reports');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products')->middleware('permission:view reports');
    Route::get('/reports/operations', [ReportController::class, 'operations'])->name('reports.operations')->middleware('permission:view reports');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales')->middleware('permission:view reports');
    Route::get('/reports/suppliers', [ReportController::class, 'suppliers'])->name('reports.suppliers')->middleware('permission:view reports');
    Route::get('/reports/purchase-orders', [ReportController::class, 'purchaseOrders'])->name('reports.purchase-orders')->middleware('permission:view reports');

    Route::middleware(['permission:manage purchase orders'])->group(function () {
        Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders.index');
        Route::get('/purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase_orders.create');
        Route::post('/purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchase_orders.store');
        Route::get('/purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'show'])->name('purchase_orders.show');
        Route::get('/purchase-orders/{purchaseOrder}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase_orders.edit');
        Route::put('/purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'update'])->name('purchase_orders.update');
        Route::delete('/purchase-orders/{purchaseOrder}', [PurchaseOrderController::class, 'destroy'])->name('purchase_orders.destroy');
        Route::post('/purchase-orders/{purchaseOrder}/receive', [PurchaseOrderController::class, 'receive'])->name('purchase_orders.receive');
        Route::post('/purchase-orders/{purchaseOrder}/cancel', [PurchaseOrderController::class, 'cancel'])->name('purchase_orders.cancel');
    });

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('permission:manage settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update')->middleware('permission:manage settings');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');