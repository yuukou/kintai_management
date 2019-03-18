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
use App\Http\Requests\AttendanceAjaxRequest;
use App\Http\Requests\AttendanceRequest;
use App\Services\Front\AttendanceService;
use App\Services\Front\TerminalLocationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttendanceController extends Controller
{
    private $attendanceService;
    private $terminalLocationService;

    public function __construct(AttendanceService $attendanceService, TerminalLocationService $terminalLocationService)
    {
        $this->attendanceService = $attendanceService;
        $this->terminalLocationService = $terminalLocationService;
    }

    public function getIndex()
    {
//        Session::forget('arrivedFlg', 'leftFlg');
        $userId = Auth::id();

        if (! Session::exists('arrivedFlg') || ! Session::exists('leftFlg'))
        {
            if ($this->attendanceService->checkArriveDuplication($userId)) {
                throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
            }

            if ($this->attendanceService->checkLeaveDuplication($userId)) {
                throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
            }

            Session::put(['arrivedFlg' => false, 'leftFlg' => false]);
        }

        if (Session::exists('arrivedFlg')) {
            if (! $this->attendanceService->checkArriveDuplication($userId)) {
                Session::forget('arrivedFlg');
            }
        }

        if (Session::exists('leftFlg')) {
            if (! $this->attendanceService->checkLeaveDuplication($userId)) {
                Session::forget('leftFlg');
            }
        }

        return view('front.attendances.index');
    }

    //submitで送信した用
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

        $this->attendanceService->storeArrive($user);
        $arrivedFlg = $this->attendanceService->isArrived($user);
        $leftFlg = $this->attendanceService->isLeft($user);
        Session::forget('arrivedFlg', 'leftFlg');
        Session::put(compact('arrivedFlg', 'leftFlg'));
        Session::flash('result_message', '出社処理が完了致しました。');
//        return view('front.attendances.index', ['arrivedFlg' => $arrivedFlg, 'leftFlg' => $leftFlg]);
//        $attendance = $request['attendance'];
//        return $attendance;

        return $request;
    }

    //submitで送信した用
    public function postStoreLeave(AttendanceRequest $request)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $user = Auth::user();
        $userId = $user->id;
        //もし、既にその日の退社処理を終了している時に、再度アクセスがあった場合は、
        //既に退社処理を終えている旨をユーザーに伝え、処理を途中で終了する。
        if ($this->attendanceService->checkLeaveDuplication($userId)) {
            throw new DuplicateException('本日の出社処理は既に行われています😌😌😌');
        }

        $this->attendanceService->storeLeave($user);
        $arrivedFlg = $this->attendanceService->isArrived($user);
        $leftFlg = $this->attendanceService->isLeft($user);
        Session::forget('arrivedFlg', 'leftFlg');
        Session::put(compact('arrivedFlg', 'leftFlg'));
        Session::flash('result_message', '退社処理が完了致しました。');

//        return Redirect::route('front::attendance::index', ['arrived_flg' => $arrived_flg, 'left_flg' => $left_flg]);
//        return Redirect::route('front::attendance::index');
//        return view('front.attendances.index', ['arrivedFlg' => $arrivedFlg, 'leftFlg' => $leftFlg]);

        return $request;
    }

    /**
     * 登録済みの位置情報を取得し、現在地情報と一緒にjsに返す
     *
     * @param AttendanceAjaxRequest $ajaxRequest
     * @return array
     */
    public function postLocation(AttendanceAjaxRequest $ajaxRequest)
    {
        if (! \Request::ajax()) {
            throw new NotFoundHttpException('許可しないHTTPメソッドです');
        }

        $userId = Auth::id();
        $terminal = $ajaxRequest['terminal'];
        $originalAddressLocations = $this->terminalLocationService->getOriginAddressLocation($userId, $terminal);
//        $data = [
//            'originLongitude' => $location['longitude'],
//            'originLatitude' =>  $location['latitude'],
//            'destinationLongitude' => $ajaxRequest['longitude'],
//            'destinationLatitude' => $ajaxRequest['latitude'],
//        ];

        $destinationAddressLocation = [
            'longitude' => $ajaxRequest['longitude'],
            'latitude' => $ajaxRequest['latitude'],
            'address' => $ajaxRequest['address'],
        ];

        return compact('originalAddressLocations', 'destinationAddressLocation');
        //ここでは、一定の範囲内に存在しなかった場合なので、一定の範囲内に存在していないという旨のエラーを返す。
    }
}