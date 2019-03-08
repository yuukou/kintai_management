<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-05
 * Time: 22:53
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TerminalLocation
 *
 * @package App
 * @property int $id
 * @property int $user_id
 * @property string $address
 * @property float $longitude
 * @property float $latitude
 * @property string $terminal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereTerminal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TerminalLocation whereUserId($value)
 * @mixin \Eloquent
 */
class TerminalLocation extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'longitude',
        'latitude',
        'terminal',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'date',
    ];
}