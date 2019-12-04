<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function AdminAdvancedSearchPage(){
        return view('Admin.Search.Admin.index');
    }
}
