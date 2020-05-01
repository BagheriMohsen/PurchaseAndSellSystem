<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\StoreRoomStatus;
use App\Models\User;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Storage;


class StoreRoom extends Model
{
   
    protected $fillable = [
      'user_id',
      'agent_id',
      'product_id',
      'warehouse_id',
      'storage_id',
      'receiver_id',
      'sender_id',
      'user_id',
      'number',
      'in_out',
      'description',
      'status',
      'in_date',
      'out_date',
      'image',
      'customerName',
      'pejak'
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
        return $this->belongsTo(User::class, 'sender_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model - receiver
    |--------------------------------------------------------------------------
    */
    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id','id');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Product Model
    |--------------------------------------------------------------------------
    */
    public function product(){
        return $this->belongsTo(Product::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Warehouse Model
    |--------------------------------------------------------------------------
    */
    public function Warehouse(){
        return $this->belongsTo('');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with Storage Model
    |--------------------------------------------------------------------------
    */
    public function storage(){
        return $this->belongsTo(Storage::class);
    }
   
}
