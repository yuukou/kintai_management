<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-04
 * Time: 15:00
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ];
}