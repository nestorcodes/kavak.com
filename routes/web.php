<?php

use Illuminate\Support\Facades\Route;

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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('vehicle', 'CarController')->names('cars')->parameters(['vehicle'=>'car']);
// cars.store
// cars.create
// cars.show
// cars.update
// cars.destroy
// cars.edit
// cars.indexAuth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::group(['prefix' => 'car'], function () {
   Route::get('list', 'CarController@DTLoad')->name('vehicle.list');
});

Route::group(['namespace' => 'Maintenance', 'prefix' => 'maintenance'], function () {
	Route::prefix('brand')->group(function () {
		Route::get('/', 'BrandController@index')->name('maint.brand.index');
	});

	Route::prefix('model')->group(function () {
		Route::get('/', 'ModelController@index')->name('maint.model.index');
	});
});

//Cart
Route::get('/cart', 'CartController@cart')->name('cart.index');
Route::post('/cartadd', 'CartController@add')->name('cart.store');
Route::post('/cartupdate', 'CartController@update')->name('cart.update');
Route::post('/cartremove', 'CartController@remove')->name('cart.remove');
Route::post('/cartclear', 'CartController@clear')->name('cart.clear');