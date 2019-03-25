<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','age','gender','height','weight','race','country','illness'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const ADMIN_EMAIL ='admin@gmail.com';

    public function isAdmin(){
      return $this->email===self::ADMIN_EMAIL;
    }


    public function breathing(){
      return $this->hasMany('App\Breathing');
    }

    public function hrv(){
      return $this->hasMany('App\Hrv');
    }


}
