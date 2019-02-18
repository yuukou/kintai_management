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
        $token = $this->service->store($request->all());

        // 当セッションは、仮登録メールの再送信時のトークンの有効期限を延長するために使用します。
        // entry_token使用タイミングは以下になります。
        // 1.仮登録状態でマイページからメールの再送信、
        // 2. トークン有効期限が切れた時点から仮登録完了メール記載のURLをクリックし、メール再送信画面に遷移時
        // トークン削除タイミングは本登録完了時
        // tokenテーブルに使用用途のカラムがないため、DBからトークンを取得するのは妥当ではないと判断したため
        // セッション保持をしています。
        Session::put('entry_token', $token);

        return Redirect::route('admin::register-pre_complete');
    }

    public function getCreatePreComplete()
    {
        return view('admin.register.complete');
    }
}