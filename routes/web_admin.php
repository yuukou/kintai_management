<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 20:22
 */

Route::group(['as' => 'admin::'], function (){
    Route::group(['middleware' => 'auth.very_basic', 'prefix' => ''], function() {
        //仮登録
        Route::get('/register', ['uses' => 'UserController@getCreate'])->name('register');
        Route::post('/register', ['uses' => 'UserController@postCreate'])->name('post-register');
        Route::get('/register/pre_complete/{user}', ['uses' => 'UserController@getCreatePreComplete'])->name('register-pre_complete');
        // 本登録確認メール送信
        Route::get('resend-entry-mail-complete', ['uses' => 'UserController@getResendMailComplete'])
            ->name('resend-entry-mail-complete');
    });

//先では、middlewareでadmin用のセキュリティを作成予定。
//    Route::group(['middleware' => ['admin.sentinel_auth']], function () {
//
//    });
});