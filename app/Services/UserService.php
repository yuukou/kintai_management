<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-20
 * Time: 17:06
 */

namespace App\Services;

use App\Exceptions\TokenException;
use App\Token;
use App\User;

class UserService extends Service
{
    protected function getUserForToken($token)
    {
        // Tokenが存在しない場合は、エラーにする。
        $tokenUser = Token::query()->where('token', '=', $token)->first();
        if (is_null($tokenUser)) {
            throw new TokenException('トークンが存在しません。');
        }

        $tokenUser = $tokenUser->toArray();

        /**
         * User $user
         */
        return User::query()->where('id', '=', $tokenUser['user_id'])->firstOrFail();
    }
}