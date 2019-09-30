<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
      'city_id',
      'name'
    ];

    //releation with City Model
    public function city(){
      return $this->belongsTo('App\City');
    }

    //releation with User Model
    public function users(){
      return $this->hasMany('App\User');
    }
}
