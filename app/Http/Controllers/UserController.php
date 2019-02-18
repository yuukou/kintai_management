<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/21
 * Time: 21:26
 */

namespace App\Http\Controllers;


use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    private $service;
    private $locationService;

    public function __construct(UserService $service, LocationService $locationService)
    {
        $this->service = $service;
        $this->locationService = $locationService;
    }

    public function getCreate()
    {
        return view('setup.create');
    }

    public function postEntry(Request $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $this->locationService->storeLocation($request->all());

        return $request;
    }
}