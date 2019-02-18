<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 16:07
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\LocationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CertificationController extends Controller
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getCreate()
    {
        return view('front.setup.create');
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