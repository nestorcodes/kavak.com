<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'APICarController@login');
    Route::post('signup', 'APICarController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'APICarController@logout');
        Route::get('user', 'APICarController@user');
        Route::get('cars', 'APICarController@index');
        Route::get('cars/{id}', 'APICarController@show');
    });
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Resource not found.'], 404);
});