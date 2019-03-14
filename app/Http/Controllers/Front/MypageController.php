<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-25
 * Time: 16:58
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\TerminalLocationService;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    private $terminalLocationService;

    public function __construct(TerminalLocationService $terminalLocationService)
    {
        $this->terminalLocationService = $terminalLocationService;
    }

    public function getIndex()
    {
        $user = Auth::user();
        $addressList = $this->terminalLocationService->getAddress($user->id);
        return view('front.mypage.index', ['user' => $user ,'addressList' => $addressList]);
    }
}