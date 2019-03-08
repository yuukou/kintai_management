<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $status
 * @property string|null $last_login
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Auth[] $auth
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EmailToken[] $emailTokens
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PermissionToken[] $permissionTokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 */
class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array hidden
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * emailToken取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emailTokens()
    {
        return $this->hasMany(EmailToken::class);
    }

    /**
     * permissionTokenの取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissionTokens()
    {
        return $this->hasMany(PermissionToken::class);
    }

    /**
     * 認証処理に関する情報にの取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auth()
    {
        return $this->hasMany(Auth::class);
    }

    /**
     * 端末位置情報の取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function terminalLocations()
    {
        return $this->hasMany(TerminalLocation::class);
    }
}