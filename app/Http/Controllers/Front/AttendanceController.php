<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/11
 * Time: 19:00
 */

namespace App\Http\Controllers\Front;

use App\Exceptions\DuplicateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Services\Front\AttendanceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttendanceController extends Controller
{
    private $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function getIndex()
    {

        return view('front.attendances.index');
    }

    public function postStoreArrive(AttendanceRequest $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $user = Auth::user();
        $userId = $user->id;
        //もし、既にその日の出社処理を終了している時に、再度アクセスがあった場合は、
        //既に出社処理を終えている旨をユーザーに伝え、処理を途中で終了する。
        if ($this->attendanceService->checkArriveDuplication($userId)) {
            throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
        }

        $attendance = $request['attendance'];
        $this->attendanceService->storeArrive($user);
        Session::flash('attendance_complete', '出社処理が完了致しました。');
        return Redirect::route('front::attendance::index', [$attendance]);
    }

    public function postStoreLeave(AttendanceRequest $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        //もし、既にその日の退社処理を終了している時に、再度アクセスがあった場合は
        //既に退社処理を終えている旨をユーザーに伝え、処理を途中で終了する。

        $user = Auth::user();
        $userId = $user->id;
        //もし、既にその日の退社処理を終了している時に、再度アクセスがあった場合は、
        //既に退社処理を終えている旨をユーザーに伝え、処理を途中で終了する。
        if ($this->attendanceService->checkLeaveDuplication($userId)) {
            throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
        }
        $attendance = $request['attendance'];
        $this->attendanceService->storeLeave($user);
        Session::flash('attendance_complete', '退社処理が完了致しました。');

        return Redirect::route('front::attendance::index', ['attendance' => $attendance]);
    }
}
