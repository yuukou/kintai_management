<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-18
 * Time: 16:07
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\TerminalLocationRequest;
use App\Services\Front\TerminalLocationService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TerminalLocationController extends Controller
{
    private $terminalLocationService;

    public function __construct(TerminalLocationService $terminalLocationService)
    {
        $this->terminalLocationService = $terminalLocationService;
    }

    public function postIndex(TerminalLocationRequest $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();

        $this->terminalLocationService->store($inputs);

        return $request;
    }
}