<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *       schema="UserToken",
 *       @OA\Property(
 *           property="token",
 *           type="string",
 *           example="tl3waWcgC7o1oORhpZzjBnWcoz130pCgYjVWrX1f0ff6cfee"
 *       )
 *  )
 *
 * @OA\Schema(
 *       schema="User",
 *       @OA\Property(
 *           property="id",
 *           type="integer",
 *           example="1"
 *       ),
 *       @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Example"
 *       ),
 *       @OA\Property(
 *           property="email",
 *           type="string",
 *           example="example@mail.com"
 *       ),
 *       @OA\Property(
 *           property="email_verified_at",
 *           type="datetime",
 *           example="2023-09-27T06:16:30.000000Z"
 *       ),
 *       @OA\Property(
 *           property="created_at",
 *           type="datetime",
 *           example="2023-09-27T06:16:30.000000Z"
 *       ),
 *       @OA\Property(
 *           property="updated_at",
 *           type="datetime",
 *           example="2023-09-27T06:16:30.000000Z"
 *       ),
 *  )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }

    public function transactions(): HasMany {
        return $this->hasMany(Transaction::class);
    }
}
