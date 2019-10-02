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
        'name',
        'family',
        'sex',
        'username',
        'password',
        'mobile',
        'status',
        'state_id',
        'role_id',
        'address',
        'uploadCS',
        'level',
        'reciveAuto',
        'sendAuto',
        'callCenter',
        'agent_id',
        'porsantSeller',
        'percent',
        'calType',
        'locallyPrice',
        'internalPrice',
        'villagePrice',
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

    // releation with Role Model
    public function role(){
      return $this->belongsTo('App\Role');
    }

    // releation with State Model
    public function state(){
      return $this->belongsTo('App\State');
    }
}
