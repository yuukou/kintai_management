<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-25
 * Time: 16:58
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function __construct()
    {
    }

    public function getIndex(Request $request)
    {
        return view('front.mypage.index');
    }

    public function getEdit()
    {
        return view('front.mypage.edit');
    }
}