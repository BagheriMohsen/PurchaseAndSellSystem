<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';
    protected $fillable = [
        'name',
        'user_id',
        'cartNumber',
        'shabaNumber',
        'default'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
