<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-19
 * Time: 11:55
 */

namespace App\Services;

use App\EmailToken;
use App\Exceptions\TokenException;

class TokenService extends Service
{
    /**
     * トークン作成
     * 戻り値の例
     * 初期登録の場合は、名前とメールアドレスと現在日時YmdHisを結合した文字列
     *
     * @param array $data
     * @return string
     */
    public function createRegisterToken(array $data)
    {
        $hash = hash('sha256', $data['name'].$data['email'].date("Y/m/d H:i:s"));
        return $hash;
    }

    /**
     * 有効トークンチェック
     * @param $user
     * @return bool
     */
    public function checkToken($user)
    {
        $result = false;
        $today = date("Y/m/d H:i:s");
        $target_day = $user->created_at;
        $exp_time = $target_day->addHour(config('project.user.mail_auth_expire_time'));
        if (strtotime($today) <= strtotime($exp_time))
        {
            $result = true;
        }

        return $result;
    }

    /**
     * トークン削除
     *
     * @param $token
     */
    public function deleteToken($token)
    {
        EmailToken::query()->where('token', '=', $token)->delete();
    }

    public function getEmailToken($token)
    {
        return EmailToken::where('token', '=', $token)->first();
    }

    /**
     * トークンの有効時間延長
     *
     * @param $token
     */
    public function extensionTokenTime($token)
    {
        $userToken = EmailToken::query()->where('token', '=', $token)->first();

        if(empty($userToken)){
            throw new TokenException('該当するtokenが存在しません。');
        }

        // トークン削除
        $this->deleteToken($token);

        // 同じトークンでレコード再生成
        // トークン再生成による、古いトークンの有効期限内での使用不可を防ぐため、
        // トークンの有効期限を延長する方式を採用
        $inputsToken['token'] = $token;
        $inputsToken['user_id'] = $userToken->user_id;
        EmailToken::create($inputsToken);
    }
}