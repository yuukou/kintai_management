<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-19
 * Time: 14:09
 */

/**
 * app・・・アプリ名
 * subject・・・件名
 *              管理者宛てのエラー通知系メールの件名には、重要度別に下記を付与すること
 *              [ERROR] 重大なエラー（即対応が必要）
 *              [WARNING] 重大なエラー（即対応は不要だが修正が必要）
 *              [NOTICE] 軽微なエラー
 * from・・・差出人アドレス
 * from_name・・・差出人
 * reply_to・・・返信先
 * return_path・・・送信エラー時の返信先
 * bcc・・・BCC宛先
 */

return [
    'app' => 'kintai管理システム',
    //社員の初期登録完了時の送信メール
    'register' => [
        'subject' => '勤怠管理システムの登録について',
        'from' => env('MAIL_FROM_ONLY'),
        'from_name' => '勤怠管理システム',
        'reply_to' => env('MAIL_FROM_ONLY'),
        'return_path' => env('MAIL_MAINTE'),
        'bcc' => '',
    ],
];
