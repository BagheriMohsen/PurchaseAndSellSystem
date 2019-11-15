<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class StoreRoom extends Model
{
   
    protected $fillable = [
      'user_id',
      'product_id',
      'warehouse_id',
      'storage_id',
      'rcv_agent_id',
      'sender_agent_id',
      'user_id',
      'number',
      'in_out',
      'description',
      'status',
      'in_date',
      'out_date'  
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('App\User','agent_id','id');
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
