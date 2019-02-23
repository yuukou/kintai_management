<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-14
 * Time: 16:55
 */

namespace App\Services\Front;


use App\Location;
use App\Services\Service;

class LocationService extends Service
{
    public function storeLocation(array $inputs)
    {
        Location::create($inputs);
    }
}