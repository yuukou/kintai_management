<?php
/**
 * @copyright Copyright (C) Logical-Studio Co.,Ltd.
 * @since     2018/08/03
 */
namespace App\Monolog\Processor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * ログにユーザー情報を出力できるようにする
 *
 * @package App\Monolog\Processor
 */
class UserProcessor
{
    public function __invoke(array $record)
    {
        try {
            $record['extra']['login_id'] = Auth::check() ? Auth::id() : '';
        } catch (\Throwable $e) {
            $record['extra']['login_id'] = $e->getMessage();
        }

        try {
            $record['extra']['session_id'] = Session::getId();
        } catch (\Throwable $e) {
            $record['extra']['session_id'] = $e->getMessage();
        }

        $record['extra']['ua'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

        return $record;
    }
}
