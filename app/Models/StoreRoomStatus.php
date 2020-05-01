<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\StoreRoom;

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
        return $this->hasMany(StoreRoom::class, 'in_out','id');
    }

}
