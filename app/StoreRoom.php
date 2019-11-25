<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StoreRoom extends Model
{
   
    protected $fillable = [
      'user_id',
      'agent_id',
      'product_id',
      'warehouse_id',
      'storage_id',
      'receiver_id',
      'transport_id',
      'sender_id',
      'user_id',
      'number',
      'in_out',
      'description',
      'status',
      'in_date',
      'out_date',
      'image' 
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with StoreRoomStatus Model
    |--------------------------------------------------------------------------
    */
    public function status(){
        return $this->belongsTo('App\StoreRoomStatus','in_out','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model - sender
    |--------------------------------------------------------------------------
    */
    public function sender(){
        return $this->belongsTo('App\User','sender_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model - receiver
    |--------------------------------------------------------------------------
    */
    public function receiver(){
        return $this->belongsTo('App\User','receiver_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo('App\Product');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Warehouse Model
    |--------------------------------------------------------------------------
    */
    public function Warehouse(){
        return $this->belongsTo('App\Warehouse');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Storage Model
    |--------------------------------------------------------------------------
    */
    public function storage(){
        return $this->belongsTo('App\Storage');
    }
   
}
