<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-05
 * Time: 22:56
 */

namespace App\Services\Front;

use App\Services\Service;
use App\TerminalLocation;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TerminalLocationService extends Service
{
    /**
     * @param array $inputs
     */
    public function store(array $inputs)
    {
        try {
            TerminalLocation::create($inputs);
            Log::info('端末位置情報の登録完了。');
        } catch (\Throwable $e) {
            Log::error('端末位置情報の登録失敗。' . $e->getMessage());
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public function getAddress($userId)
    {
        $mainAddressTerminalLocation = TerminalLocation::where('user_id', '=', $userId)
            ->where('workspace_type', '=', MAIN_WORKSPACE)
            ->first();

        $subAddressTerminalLocation = TerminalLocation::where('user_id', '=', $userId)
            ->where('workspace_type', '=', SUB_WORKSPACE)
            ->first();

        $mainAddress = $mainAddressTerminalLocation['address'];
        $subAddress = $subAddressTerminalLocation['address'];

        return compact('mainAddress', 'subAddress');
    }

    /**
     * @param $userId
     * @param $terminal
     * @return array
     */
    public function getOriginAddressLocation($userId, $terminal)
    {
        $terminalLocationQuery = TerminalLocation::where('user_id', '=', $userId)
            ->where('terminal', '=', $terminal);

        $subTerminalLocationQuery = $terminalLocationQuery;

        if ($subTerminalLocationQuery->exists())
        {
            $terminalLocations = $terminalLocationQuery->get()->toArray();

            $locations = [];
            foreach ($terminalLocations as $terminalLocation) {
                $inLocation = [
                    'longitude' => $terminalLocation['longitude'],
                    'latitude' => $terminalLocation['latitude'],
                    'address' => $terminalLocation['address'],
                 ];
                $locations[] = $inLocation;
            }

            return $locations;
        } else {
            throw new NotFoundHttpException('該当するデータが存在しません。');
        }
    }
}