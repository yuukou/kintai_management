<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/21
 * Time: 21:26
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\Admin\UserService;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getCreate()
    {
        return view('admin.register.index');
    }

    public function postCreate(UserRequest $request)
    {
        $this->service->store($request->all());

        Session::flash('result_message', trans('admin/message.user.register.complete'));
        return Redirect::route('admin::register');
    }

    public function getCreatePreComplete(User $user)
    {
        return view('admin.register.complete', ['name' => $user->name]);
    }
}