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
    Route::group(['prefix' => 'register','as' => 'register::'], function (){
        Route::get('register/complete/{token}', ['uses' => 'UserController@getRegisterComplete'])->name('complete');
        // 仮登録トークン期限切れ
        Route::get('register/timeout-token/{token}', ['uses' => 'UserController@getTimeoutToken'])->name('timeout-token');
    });

    Route::group(['middleware' => 'auth.very_basic', 'prefix' => ''], function() {
        Route::group(['prefix' => 'mypage', 'as' => 'mypage::'], function () {
            Route::get('/', ['uses' => 'MypageController@getIndex'])->name('index');
        });

        Route::group(['prefix' => 'entry', 'as' => 'entry::'], function () {
            Route::get('/', ['uses' => 'CertificationController@getCreate'])->name('entry');
            Route::post('/', [ 'uses' => 'CertificationController@postEntry'])->name('post-entry');
        });

        Route::get('', ['uses' => 'AttendanceController@getTop'])->name('top');
        Route::post('arrive/{user}', ['uses' => 'AttendanceController@postStoreArrive'])->name('postStoreArrive');
        Route::post('leave/{user}', ['uses' => 'AttendanceController@postStoreLeave'])->name('postStoreLeave');
        Route::get('/{attendance}_complete/{user}', ['uses' => 'AttendanceController@getStoreComplete'])->name('storeComplete');
    });
});