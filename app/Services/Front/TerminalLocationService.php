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

class TerminalLocationService extends Service
{
    public function store(array $inputs)
    {
        try {
            TerminalLocation::create($inputs);
            Log::info('端末位置情報の登録完了。');
        } catch (\Throwable $e) {
            Log::error('端末位置情報の登録失敗。');
        }
    }

    public function getAddress($userId)
    {
        $terminalLocations = TerminalLocation::where('user_id', '=', $userId)->get()->toArray();
        $addressList = [];
        foreach ($terminalLocations as $terminalLocation) {
            $addressList[] = $terminalLocation['address'];
        }
        return $addressList;
    }
}