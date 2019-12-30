<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentCost extends Model
{
    protected $table = 'agent_costs';
    protected $fillable = [
        'create_date',
        'trackingCode',  
        'user_id',       
        'price',
        'desc',
        'created_at',
        'updated_at',
        'confirmDate',
        'onConfirmDate'    
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
