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
     * 位置情報の取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * エージェント情報の取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}