<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nev', 'email', 'username', 'password', 'munkakor',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Visszaadja a user munkakörét
     */
    public function munkakor()
    {
        return $this->belongsTo('App\Munkakor', 'munkakor', 'nev');
    }

    /**
     * Visszaadja a userhez tartozó megrendelőheteket
     */
    public function megrendeloHetek()
    {
        return $this->hasMany('App\MegrendeloHet', 'kiszallito_id', 'id');
    }
}
