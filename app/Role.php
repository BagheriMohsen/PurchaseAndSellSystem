<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
      'name',
      'role'
    ];

    // releation with User table
    public function users(){
      return $this->hasMany('App\User');
    }
}
