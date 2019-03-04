<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-04
 * Time: 15:05
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'agent',
        'token',
    ];
}