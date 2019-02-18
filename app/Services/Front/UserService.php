<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-20
 * Time: 10:47
 */

namespace App\Services\Front;

use App\Exceptions\TokenException;
use App\Services\Service;
use App\Services\TokenService;
use App\Token;
use App\User;
use Illuminate\Support\Facades\DB;

class UserService extends Service
{
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function update($token)
    {
        $user = $this->getUserForToken($token);

        // 本登録対象のメルアドが使用済みならエラーにする
        $isAlreadyExistsEmail = User::query()->where('email', '=', $user->email)->where('status', '=', USER_STATUS_ENTER)->exists();
        if ($isAlreadyExistsEmail) {
            throw new TokenException('既に本登録済みのユーザーです。');
        }

        //本登録でステータスを更新、更新後は安全性とゴミデータになるためトークンを削除
        DB::transaction(function () use ($token, $user) {
            $user->update(['status' => USER_STATUS_ENTER]);

            $this->tokenService->deleteToken($token);
        });
    }

    private function getUserForToken($token)
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