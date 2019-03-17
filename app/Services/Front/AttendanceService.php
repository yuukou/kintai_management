<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 14:23
 */

namespace App\Services\Front;

use App\Attendance;
use App\Services\Service;
use App\TerminalLocation;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Integer;

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
        $today = Carbon::today();
        $arriveAttendanceQuery = Attendance::where('user_id', '=', $userId)
            ->where('date', '=', $today)->whereNotNull('arrive_at');
        if ($arriveAttendanceQuery->exists()) {
            return true;
        }
        return false;
    }

    public function checkLeaveDuplication($userId)
    {
        $today = Carbon::today();
        $leaveAttendanceQuery = Attendance::where('user_id', '=', $userId)
            ->where('date', '=', $today)->whereNotNull('leave_at');
        if ($leaveAttendanceQuery->exists()) {
            return true;
        }
        return false;
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

//    /**
//     * 出退勤処理を行うユーザーが登録端末位置情報と同等であるかを判定する
//     *
//     * @param array $inputs
//     * @return bool
//     */
//    public function checkTerminalLocation(array $inputs)
//    {
//        $terminalLocations = TerminalLocation::where('user_id', '=', $inputs['user_id'])->get()->toArray();
//
//        $destinationLongitude = $inputs['longitude'];
//        $destinationLatitude = $inputs['latitude'];
//        foreach ($terminalLocations as $terminalLocation) {
//             $originLongitude = $terminalLocation['longitude'];
//             $originLatitude = $terminalLocation['latitude'];
//             $distance = $this->getPointsDistance($destinationLongitude, $destinationLatitude, $originLongitude, $originLatitude);
//
//             if ($distance <= 100) {
//                 return true;
//             }
//        }
//        return false;
//    }

//    /**
//     * @param $lat1
//     * @param $lng1
//     * @param $lat2
//     * @param $lng2
//     * @return float
//     */
//    private function getPointsDistance($lat1, $lng1, $lat2, $lng2){
//        $pi1 = pi();
//        $lat1 = $lat1*$pi1/180;
//        $lng1 = $lng1*$pi1/180;
//        $lat2 = $lat2*$pi1/180;
//        $lng2 = $lng2*$pi1/180;
//        $deg = sin($lat1)*sin($lat2) + cos($lat1)*cos($lat2)*cos($lng2-$lng1);
//        return round(6378140*(atan2(-$deg,sqrt(-$deg*$deg+1))+$pi1/2), 0);
//    }
}