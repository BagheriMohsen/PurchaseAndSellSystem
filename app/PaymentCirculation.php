<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCirculation extends Model
{
    protected $table = 'payment_circulations';
    protected $fillable = [
        'bank_account_id',
        'receiptImage',
        'user_id',
        'status_id',
        'bill',
        'billDate',
        'confirmDate',
        'OnconfirmDate',
        'trackingCode',
        'paymentMethod',
        'billDesc',
        'type'
    ];
    /*
    |--------------------------------------------------------------------------
    | Releation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /*
    |--------------------------------------------------------------------------
    | Releation with BankAccount Model
    |--------------------------------------------------------------------------
    */
    public function bankAccount(){
        return $this->belongsTo('App\BankAccount','bank_account_id','id');
    }

}
