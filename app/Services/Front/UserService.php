<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-20
 * Time: 10:47
 */

namespace App\Services\Front;

use App\Services\UserService as CommonService;
use App\Exceptions\TokenException;
use App\Services\TokenService;
use App\User;
use Illuminate\Support\Facades\DB;

class UserService extends CommonService
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
}