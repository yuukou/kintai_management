<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-02-14
 * Time: 16:55
 */

namespace App\Services;


use App\Location;

class LocationService
{
    public function storeLocation(array $inputs)
    {
        Location::create($inputs);
    }
}