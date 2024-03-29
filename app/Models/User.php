<?php

namespace App\Models;

use App\Src\Traits\Truncateable;
use App\Src\Traits\UUIDPrimaryKey;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, UUIDPrimaryKey, Truncateable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
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
    ];

    /**
     * The accessors to get avatar with full path.
     *
     * @param string $value
     * 
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ? asset("images/avatar/{$this->id}/{$value}") : null;
    }

    /**
     * The model relation hasMany to Post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * The model relation hasMany to SocialLink.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socialLink()
    {
        return $this->hasMany(SocialLink::class);
    }

}
