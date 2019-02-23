<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2019/01/17
 * Time: 17:16
 */

// 各機能の設定を記載するファイル

return [
    'user' => [
        'name' => [
            'max_length' => 200,
        ],

        'email' => [
            // 最大桁数
            'max_length' => 200,
        ],

        'mail_auth_expire_time' => 24,
    ],
];