<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\BankAccount;

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
    | Relation with User Model
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relation with BankAccount Model
    |--------------------------------------------------------------------------
    */
    public function bankAccount(){
        return $this->belongsTo(BankAccount::class, 'bank_account_id','id');
    }

}
