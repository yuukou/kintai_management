<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/11
 * Time: 19:00
 */

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AttendanceController
{
    private $userService;
    private $attendanceService;

    public function __construct(UserService $userService, AttendanceService $attendanceService)
    {
        $this->userService = $userService;
        $this->attendanceService = $attendanceService;
    }

    public function getTop()
    {
        $user = $this->userService->getUserByIp();
        return view('attendance')
            ->with(['user' => $user, 'arrivedFlg' => $this->attendanceService->isArrived($user), 'leftFlg' => $this->attendanceService->isLeft($user)]);
    }

    public function postStoreArrive(User $user, Request $request)
    {
        $attendance = $request->input('attendance');

        //この会社の社員の固定IPの中に一致するものがあるか否かで場合分けをする
        if ($user) {
            $this->attendanceService->storeArrive($user);
            return Redirect::route('storeComplete', [$attendance, $user->id]);
        }
        return '';
    }

    public function postStoreLeave(User $user, Request $request)
    {
        $attendance = $request->input('attendance');

        //この会社の社員の固定IPの中に一致するものがあるか否かで場合分けをする
        if ($user) {
            $this->attendanceService->storeLeave($user, $attendance);
            return Redirect::route('storeComplete', [$attendance, $user->id]);
        }
        return '';
    }

    public function getStoreComplete($attendance, User $user)
    {
        $time = $this->attendanceService->getAttendanceTime($user, $attendance);
        return view('attendance_complete')->with(['attendance' => $attendance, 'name' => $user->name, 'time' => $time]);
    }
}