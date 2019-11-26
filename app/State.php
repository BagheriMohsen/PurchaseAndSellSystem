<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'name'
    ];

    //releation with City Model
    public function cities(){
      return $this->hasMany('App\City');
    }

    //releation with User Model
    public function users(){
      return $this->hasMany('App\User');
    }
}
