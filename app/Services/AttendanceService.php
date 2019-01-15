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

    public function check($query, $attendance)
    {
        $info = $this->getInfo($query);

        $attendanceQuery = Attendance::where('date', '=', $info['date'])->where('user_id', '=', $info['shainId']);

        if (!$attendanceQuery->exists()) {
            $this->store($info['date'], $info['shainId']);
            $this->arrive($info['shainName']);
            $this->send();
        } else {
            $this->checkArriveDuplication($attendance);
            $this->checkLeaveDuplication($attendance, $attendanceQuery);

            $attendanceQuery = Attendance::where('date', '=', $info['date'])->where('user_id', '=', $info['shainId']);
            $this->update($attendanceQuery, $info['date'], $info['shainId']);
            $this->leave($info['shainName']);
            $this->send();
        }
    }

    public function checkAttendance($query)
    {
        $shainId = $query->first()->id;
        $date = Carbon::create();
        $attendanceQuery = Attendance::where('date', '=', $date)->where('user_id', '=', $shainId);

        return $attendanceQuery->exists();
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

    public function getAttendanceTime($query, $attendance)
    {
        $info = $this->getInfo($query);
        $inputs = Attendance::where('date', '=', $info['date'])->where('user_id', '=', $info['shainId'])->first()->toArray();

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

    private function getInfo($query)
    {
        $shainName = $query->first()->name;
        $shainId = $query->first()->id;
        $date = Carbon::create();

        return ['shainName' => $shainName,
            'shainId' => $shainId,
            'date' => $date
        ];
    }
}