<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Auth
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Auth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Auth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Auth query()
 * @mixin \Eloquent
 */
class Auth extends Model
{
    protected $fillable = [
        'terminal_location_id',
    ];
}
