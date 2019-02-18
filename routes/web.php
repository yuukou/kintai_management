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

Route::group(['as' => 'front::'], function (){
    Route::group(['middleware' => 'auth.very_basic', 'prefix' => ''], function() {
        Route::get('/entry', ['uses' => 'CertificationController@getCreate'])->name('enry');
        Route::post('/entry', [ 'uses' => 'CertificationController@postEntry'])->name('post-entry');

        Route::get('', ['uses' => 'AttendanceController@getTop'])->name('top');
        Route::post('arrive/{user}', ['uses' => 'AttendanceController@postStoreArrive'])->name('postStoreArrive');
        Route::post('leave/{user}', ['uses' => 'AttendanceController@postStoreLeave'])->name('postStoreLeave');
        Route::get('/{attendance}_complete/{user}', ['uses' => 'AttendanceController@getStoreComplete'])->name('storeComplete');
    });
});

Route::group(['as' => 'admin::'], function (){
    Route::get('register', ['uses' => 'UserController@getCreate']);
    Route::post('register', ['uses' => 'UserController@postCreate']);

//    Route::group(['middleware' => ['admin.sentinel_auth']], function () {
//
//    });
});