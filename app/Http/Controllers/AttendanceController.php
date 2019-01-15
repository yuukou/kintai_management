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
        $query = $this->getQuery();

        return view('attendance')
            ->with('checkAttendanceFlg', $this->attendanceService->checkAttendance($query));
    }

    public function checkForIpAddress(Request $request)
    {
        $attendance = $request->input('attendance');

        $query = $this->getQuery();

        $id = $query->first()->id;

        //この会社の社員の固定IPの中に一致するものがあるか否かで場合分けをする
        if ($query->exists()) {
            $this->attendanceService->check($query, $attendance);
            return Redirect::route('attendanceComplete', [$attendance, $id]);
        }

        return '';
    }

    public function getAttendanceComplete($attendance, User $user)
    {
        $name = $user->name;
        $query = $this->getQuery();
        $time = $this->attendanceService->getAttendanceTime($query, $attendance);
        return view('attendance_complete')->with(['attendance' => $attendance, 'name' => $name, 'time' => $time]);
    }

    private function getQuery()
    {
        $ipAddress = $_SERVER["REMOTE_ADDR"];
        $query = User::where('ip_address', '=', $ipAddress);
        return $query;
    }
}