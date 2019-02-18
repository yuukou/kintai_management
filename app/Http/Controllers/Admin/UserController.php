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
    public function getCreate()
    {
        return  view('admin.register');
    }

    public function postCreate()
    {

    }
}