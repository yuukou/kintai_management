<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/11
 * Time: 19:00
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Services\Front\AttendanceService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        return view('front.setup.create');
    }

    public function postStoreArrive(AttendanceRequest $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $attendance = $request['attendance'];
        $user = Auth::user();
        $this->attendanceService->store Arrive($user);

        return Redirect::route('storeComplete', [$attendance, $user->id]);
    }

    public function postStoreLeave(User $user, AttendanceRequest $request)
    {
        $attendance = $request->input('attendance');
        $this->attendanceService->storeLeave($user, $attendance);

        return Redirect::route('storeComplete', [$attendance, $user->id]);
    }

    public function getStoreComplete($attendance, User $user)
    {
        $time = $this->attendanceService->getAttendanceTime($user, $attendance);
        return view('attendance_complete')->with(['attendance' => $attendance, 'name' => $user->name, 'time' => $time]);
    }
}