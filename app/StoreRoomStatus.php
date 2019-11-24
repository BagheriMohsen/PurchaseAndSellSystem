<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreRoomStatus extends Model
{
    protected $fillable = [
        'name'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoom Model
    |--------------------------------------------------------------------------
    */
    public function storeRooms(){
        return $this->hasMany('App\StoreRoom');
    }

}
