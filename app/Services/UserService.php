<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-20
 * Time: 17:06
 */

namespace App\Services;

use App\EmailToken;
use App\Exceptions\TokenException;
use App\User;

class UserService extends Service
{
    protected $tokenService;
    protected $sendMailService;

    public function __construct(TokenService $tokenService, SendMailService $sendMailService)
    {
        $this->tokenService = $tokenService;
        $this->sendMailService = $sendMailService;
    }


//    public function __construct()
//    {
//    }

    public function getUserByToken($token)
    {
        // Tokenが存在しない場合は、エラーにする。
        $tokenUser = EmailToken::query()->where('token', '=', $token)->first();
        if (is_null($tokenUser)) {
            throw new TokenException('トークンが存在しません。');
        }

        $tokenUser = $tokenUser->toArray();

        /**
         * User $user
         */
        return User::query()->where('id', '=', $tokenUser['user_id'])->firstOrFail();
    }

    /**
     * 仮登録メール再送信
     *
     * @param $token
     */
    public function resendRegisterMail($token)
    {
        $this->tokenService->extensionTokenTime($token);

        $user = $this->getUserByToken($token);
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ];

        $this->sendMailService->sendMail($data);
    }
}