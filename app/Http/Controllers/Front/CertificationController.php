<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 16:07
 */

namespace App\Http\Controllers;

use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CertificationController extends Controller
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