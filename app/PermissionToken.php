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
 * App\PermissionToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionToken whereUserId($value)
 * @mixin \Eloquent
 */
class PermissionToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
    ];
}