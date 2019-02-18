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
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $service;
    private $tokenService;

    public function __construct(UserService $service, TokenService $tokenService)
    {
        $this->service = $service;
        $this->tokenService = $tokenService;
    }

    public function getRegisterComplete($token)
    {
        if (! $this->tokenService->checkTokenEffectivity($token)) {
            throw new TokenException('tokenが正常ではありません。');
        };

        Session::forget('entry_token');
        $this->service->update($token);

        return view('front.setup.create');
    }
}