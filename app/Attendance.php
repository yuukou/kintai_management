<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 12:38
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'arrive_at',
        'leave_at',
    ];

    protected $dates = [
        'date',
    ];

    public $timestamps = false;

    /**
     * 社員情報を取得
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}