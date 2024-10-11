<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @method static paginate()
 * @method static find($id)
 */
class User extends Authenticatable
{
    use Notifiable; use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token' , 'api_token'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation Ship.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function posts(){
        return $this->hasMany( Post::class );

    }

    /**
     * Relation Ship.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany( Comment::class );

    }

}
