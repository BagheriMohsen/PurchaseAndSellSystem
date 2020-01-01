<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Costs report page
    |--------------------------------------------------------------------------
    |*/
    public function Costs(){
        return view('Admin.Report.Admin.costs');
    }
    /*
    |--------------------------------------------------------------------------
    | Orders report page
    |--------------------------------------------------------------------------
    |*/
    public function Orders(){
        return view('Admin.Report.Admin.orders');
    }
    /*
    |--------------------------------------------------------------------------
    | Payment report page
    |--------------------------------------------------------------------------
    |*/
    public function Payments(){
        return view('Admin.Report.Admin.payments');
    }
}
