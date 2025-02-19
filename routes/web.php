<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InputOperationController;
use App\Http\Controllers\Admin\MateriauxreController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\POS\POSController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

Route::get('/low-stock', [MateriauxreController::class, 'checkLowStock'])->name('low_stock');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/role-register','Admin\DashboardController@registered');


Route::get('/role-edit/{id}','Admin\DashboardController@registeredit');
Route::put('/role-register-update/{id}','Admin\DashboardController@registerupdate');
Route::delete('/role-delete/{id}','Admin\DashboardController@registerdelete');

Route::get('/materiaux','Admin\MateriauxreController@index');
Route::post('/save-materiaux','Admin\MateriauxreController@store');
Route::get('/materiaux-us/{id}','Admin\MateriauxreController@edit');
Route::put('/materiaux-update/{id}','Admin\MateriauxreController@update');
Route::delete('materiaux-delete/{id}','Admin\MateriauxreController@delete');

Route::get('/magasin','Admin\MagasinController@index');
Route::get('/produit-create','Admin\MagasinController@create');
Route::post('/product-store','Admin\MagasinController@store');
Route::get('/magasin-edit/{id_operation}','Admin\MagasinController@edit');
Route::put('/magasin-update/{id}','Admin\MagasinController@update');
Route::delete('/magasin-delete/{id_operation}','Admin\MagasinController@delete');



Route::get('/stock','Admin\StocksController@index');
Route::post('/save-stock','Admin\StocksController@store');
Route::get('/stock-us/{id_stock}','Admin\StocksController@edit');
Route::put('/stock-update/{id_stock}','Admin\StocksController@update');
Route::delete('stock-us-delete/{id_stock}','Admin\StocksController@delete');

Route::get('/categorie','Admin\CategorieController@index');
Route::get('/categorie-create','Admin\CategorieController@create');
Route::post('/categorie-store','Admin\CategorieController@store');

Route::get('/partenaire','Admin\PartenaireController@index');
Route::get('/partenaire-create','Admin\PartenaireController@create');
Route::post('/partenaire-store','Admin\PartenaireController@store');


Route::get('/prnpriview/stocks','Admin\StocksController@indexx');
Route::get('/printPreview/stocks','Admin\StocksController@printPreview');

Route::get('/print-preview/magasin', 'Admin\MagasinController@indexx')->name('magasin.preview');
Route::get('/print-preview/materiaux', 'Admin\MateriauxreController@indexx')->name('materiaux.preview');

Route::get('/input-operations', [InputOperationController::class, 'index'])->name('input.operations.index');

Route::prefix('pos')->group(function () {
    Route::get('/', [POSController::class, 'index'])->name('pos.index');
    Route::get('/create', [POSController::class, 'create'])->name('pos.create');
    Route::post('/', [POSController::class, 'store'])->name('pos.store');
    Route::get('/{id}/edit', [POSController::class, 'edit'])->name('pos.edit');
    Route::put('/{id}', [POSController::class, 'update'])->name('pos.update');
    Route::delete('/{id}', [POSController::class, 'destroy'])->name('pos.destroy');
});


});

 
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
