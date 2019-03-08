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

class TerminalLocationService extends Service
{
    public function store(array $inputs)
    {
        TerminalLocation::create($inputs);
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