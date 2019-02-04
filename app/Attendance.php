<?php
/**
 * Created by PhpStorm.
 * User: tanakayuko
 * Date: 2018/12/20
 * Time: 12:38
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Attendance
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property string $arrive_at
 * @property string|null $leave_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereArriveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereLeaveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereUserId($value)
 * @mixin \Eloquent
 */
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