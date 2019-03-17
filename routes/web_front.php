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

Route::group(['as' => 'front::', 'middleware' => ['web']], function (){
    Route::group(['prefix' => 'register','as' => 'register::'], function (){
        Route::get('/complete/{token}', ['uses' => 'UserController@getRegisterComplete'])->name('complete');
        // 仮登録トークン期限切れ
        Route::get('/timeout-token/{token}', ['uses' => 'UserController@getTimeoutToken'])->name('timeout-token');
        // 本登録確認メール送信
        Route::get('resend-entry-mail-complete/{token}', ['uses' => 'UserController@getResendMailComplete'])
            ->name('resend-entry-mail-complete');
    });

    //ログイン処理
    Route::group(['prefix' => 'login', 'as' => 'login::'], function (){
        Route::get('/{token}', ['uses' => 'LoginController@showLoginForm'])->name('index');
        Route::post('/{token}', ['uses' => 'LoginController@login'])->name('post');
    });

    //マイページ
//    Route::group(['middleware' => 'auth.very_basic', 'prefix' => ''], function() {
        Route::group(['prefix' => 'mypage', 'as' => 'mypage::'], function () {
            Route::get('/', ['uses' => 'MypageController@getIndex'])->name('index');
        });

    //端末位置情報の登録処理
    Route::group(['prefix' => 'terminal-location', 'as' => 'terminalLocation::'], function () {
        Route::post('/', [ 'uses' => 'TerminalLocationController@postIndex'])->name('post-index');
    });

    //出退勤処理
    Route::group(['prefix' => 'attendance', 'as' => 'attendance::'], function () {
        Route::get('', ['uses' => 'AttendanceController@getIndex'])->name('index');
        Route::post('/arrive', ['uses' => 'AttendanceController@postStoreArrive'])->name('post-store-arrive');
        Route::post('/leave', ['uses' => 'AttendanceController@postStoreLeave'])->name('post-store-leave');
        Route::post('/post-location', ['uses' => 'AttendanceController@postLocation'])->name('post-location');
    });
});