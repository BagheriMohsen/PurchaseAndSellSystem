<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'state_id',
        'city_id',
        'UserID',
        'fullName',
        'mobile',
        'telephone',
        'postalCode',
        'HBD_Date',
        'HBD_Date',
        'address'

    ];
}
