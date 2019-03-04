<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $fillable = [
        'user_id',
        'agent_id',
        'location_id',
    ];
}
