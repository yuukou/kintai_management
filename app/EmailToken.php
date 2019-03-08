<?php
/**
 * Created by PhpStorm.
 * User: yukotanaka
 * Date: 2019-03-04
 * Time: 15:00
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EmailToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailToken whereUserId($value)
 * @mixin \Eloquent
 */
class EmailToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ];
}