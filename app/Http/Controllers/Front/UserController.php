<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-19
 * Time: 22:36
 */

namespace App\Http\Controllers\Front;

use App\Exceptions\TokenException;
use App\Http\Controllers\Controller;
use App\Services\Front\UserService;
use App\Services\TokenService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $userService;
    private $tokenService;

    public function __construct(UserService $userService, TokenService $tokenService)
    {
        $this->userService = $userService;
        $this->tokenService = $tokenService;
    }

    public function getRegisterComplete($token)
    {
//        $userToken = $this->tokenService->getEmailToken($token);
//
//        if (is_null($userToken)) {
//            throw new TokenException('tokenが正常ではありません。');
//        }
//
//        $result = $this->tokenService->checkToken($userToken);
//        if (! $result) {
//            return Redirect::route('front::register::timeout-token', ['token' => $token]);
//        }

//        Session::forget('register_token');
        $this->userService->update($token);

        return Redirect::route('front::login::index');
    }

    /**
     * トークン有効期限切れ
     *
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTimeoutToken($token)
    {
        if(empty($token)) {
            throw new TokenException('該当するトークンが存在しません。');
        }

//        Session::put('register_token',$token);

        return view('front.register.timeout_token', ['token' => $token]);
    }

    /**
     * 仮登録メール再送信
     *
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getResendMailComplete($token)
    {
        if (empty($token)) {
            throw new TokenException('tokenが正しくありません。');
        }

        $this->userService->resendRegisterMail($token);
        Session::flash('result_message', trans('admin/message.user.resend_mail.complete'));

        return Redirect::route('front::register::timeout-token', ['token' => $token]);
    }
}