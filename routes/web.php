<?php

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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

route::group(['middleware' => ['auth','admin']], function () {
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

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


Route::get('/prnpriview','Admin\StocksController@indexx');
Route::get('/printPreview','Admin\StocksController@printPreview');

Route::get('/prnpriview','Admin\MagasinController@indexx');
Route::get('/printPreview','Admin\MagasinController@printPreview');

Route::get('/prnpriview','Admin\MateriauxreController@indexx');
Route::get('/printPreview','Admin\MateriauxreController@printPreview');
});

 