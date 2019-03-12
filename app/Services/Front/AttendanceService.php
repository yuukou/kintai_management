<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:23
 */

namespace App\Services\Front;

use App\Attendance;
use App\Exceptions\DuplicateException;
use App\Services\Service;
use Carbon\Carbon;

class AttendanceService extends Service
{
    use SlackService;

    public function storeArrive($user)
    {
        $info = $this->getInfo($user);
        $date = $info['date'];
        $shainId = $info['shainId'];

        $inputs = [
            'user_id' => $shainId,
            'date' => $date,
            'arrive_at' => $date,
        ];
        Attendance::create($inputs);

        //スラックの勤怠チャンネルに出社通知を行う。
        $this->arrive($info['shainName']);
        $this->send();
    }

    public function storeLeave($user)
    {
        $info = $this->getInfo($user);
        $date = $info['date'];
        $shainId = $info['shainId'];
        $attendanceQuery = $this->getUserQuery($info['date'], $info['shainId']);

        $inputs = $attendanceQuery->first()->toArray();
        $inputs['leave_at'] = $date;
        Attendance::updateOrCreate(['user_id' => $shainId], $inputs);

        //スラックの勤怠チャンネルに退社通知を行う。
        $this->leave($info['shainName']);
        $this->send();
    }

    public function isArrived($user)
    {
        $info = $this->getInfo($user);
        return $this->getUserQuery($info['date'], $info['shainId'])->whereNotNull('arrive_at')->exists();
    }

    public function isLeft($user)
    {
        $info = $this->getInfo($user);
        return $this->getUserQuery($info['date'], $info['shainId'])->whereNotNull('leave_at')->exists();
    }

    public function checkArriveDuplication($userId)
    {
        $today = Carbon::today()->format('Y/m/d');
        $arriveAttendanceQuery = Attendance::where('user_id', '=', $userId)
            ->where('created_at', '=', $today);
        if ($arriveAttendanceQuery->exists()) {
            return false;
        }
        return true;
    }

    public function checkLeaveDuplication($userId)
    {
        $today = Carbon::today()->format('Y/m/d');
        $leaveAttendanceQuery = Attendance::where('user_id', '=', $userId)
            ->where('created_at', '=', $today);
        if ($leaveAttendanceQuery->exists()) {
            return false;
        }
        return true;
    }

    private function getInfo($user)
    {
        return [
            'shainName' => $user->name,
            'shainId' => $user->id,
            'date' => Carbon::create()
        ];
    }

    private function getUserQuery($date, $shainId)
    {
        return Attendance::where('date', '=', $date)->where('user_id', '=', $shainId);
    }
}