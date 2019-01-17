<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:23
 */

namespace App\Services;

use App\Attendance;
use App\Exceptions\DuplicateException;
use Carbon\Carbon;

class AttendanceService extends Service
{
    use SlackService;

    public function storeArrive($user)
    {
        $info = $this->getInfo($user);

//        $this->checkArriveDuplication($attendance);
        $this->store($info['date'], $info['shainId']);
        $this->arrive($info['shainName']);
        $this->send();
    }

    public function storeLeave($user, $attendance)
    {
        $info = $this->getInfo($user);
        $attendanceQuery = $this->getUserQuery($info['date'], $info['shainId']);

//        $this->checkLeaveDuplication($attendance, $attendanceQuery);
        $this->update($attendanceQuery, $info['date'], $info['shainId']);
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

    private function store($date, $shainId)
    {
        $inputs = [
            'user_id' => $shainId,
            'date' => $date,
            'arrive_at' => $date,
        ];
        Attendance::create($inputs);
    }

    private function update($attendanceQuery, $date, $shainId)
    {
        $inputs = $attendanceQuery->first()->toArray();
        $inputs['leave_at'] = $date;
        Attendance::updateOrCreate(['user_id' => $shainId], $inputs);
    }

    private function checkArriveDuplication($attendance)
    {
        if ($attendance == 'arrive') {
            throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
        }
    }

    private function checkLeaveDuplication($attendance, $attendanceQuery)
    {
        $leaveAttendanceQuery = $attendanceQuery->whereNotNull('leave_at');
        if ($attendance == 'leave' && $leaveAttendanceQuery->exists()) {
            throw new DuplicateException('本日の退社処理は既に行われています😌😌😌');
        }
    }

    public function getAttendanceTime($user, $attendance)
    {
        $info = $this->getInfo($user);
        $attendanceQuery = $this->getUserQuery($info['date'], $info['shainId']);

        $inputs = $attendanceQuery->first()->toArray();

        if ($attendance == 'arrive') {
            $time = $inputs['arrive_at'];
            return $time;
        } elseif ($attendance == 'leave') {
            $time = $inputs['leave_at'];
            return $time;
        } else {
            return '';
        }
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