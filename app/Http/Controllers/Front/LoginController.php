<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-07
 * Time: 10:27
 */

namespace App\Http\Controllers\Front;

use App\Exceptions\TokenException;
use App\Http\Controllers\Controller;
use App\Services\Front\UserService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/mypage';

    private $tokenService;
    private $userService;

    public function __construct(TokenService $tokenService, UserService $userService)
    {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
    }

    public function showLoginForm($token)
    {
        return view('front.login.index', ['token' => $token]);
    }

    public function login(Request $request, $token)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request, $token)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                $this->username() => [
                    'bail',
                    'required',
                ],
                'password' => [
                    'bail',
                    'required',
                    'string'
                ],
            ],
            [],
            [
                $this->username() => 'メールアドレス',
                'password' => 'パスワード',
            ]
        );
    }

    protected function hasTooManyLoginAttempts()
    {
        return false;
    }

    protected function redirectTo()
    {
        return $this->redirectTo;
    }

    protected function attemptLogin(Request $request, $token)
    {
        $userToken = $this->tokenService->getEmailToken($token);

        if (is_null($userToken)) {
            throw new TokenException('tokenが正常ではありません。');
        }

        $result = $this->tokenService->checkToken($userToken);
        if (! $result) {
            return Redirect::route('front::register::timeout-token', ['token' => $token]);
        }
        $result = $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );

        $this->userService->update($token);
        return $result;
    }
}