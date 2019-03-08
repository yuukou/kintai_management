<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 16:07
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\TerminalLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CertificationController extends Controller
{
    private $terminalLocationService;

    public function __construct(TerminalLocationService $terminalLocationService)
    {
        $this->terminalLocationService = $terminalLocationService;
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

        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();

        $this->terminalLocationService->store($inputs);

        return response()->json($request);
    }
}