<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:22
 */

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\User;

class UserService extends Service
{
    public function getUserByIp()
    {
        $user = User::where('ip_address', '=', $_SERVER["REMOTE_ADDR"])->first();
        if (is_null($user)) {
            throw new UserNotFoundException(trans('message.error.not_shain'));
        }
        return $user;
    }
}