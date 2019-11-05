<?php
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|*/



Route::get('/test',function(){
  return view('test');
});
Auth::routes();
Route::get('/logout','HomeController@logout')->name('logout');
Route::post('/loginToSite','HomeController@loginToSite')->name('loginToSite');
/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|*/

Route::group(['middleware'=>'auth','prefix'=>'users','as'=>'users.'],function(){
    Route::get('agents','UserController@agents')->name('agents');
    Route::get('sellers','UserController@sellers')->name('sellers');
});

Route::middleware('auth')->resource('users','UserController');
/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('roles','RoleController');
/*
|--------------------------------------------------------------------------
| Products Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('products','ProductController');
/*
|--------------------------------------------------------------------------
| ProductType Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('types','ProductTypeController');
/*
|--------------------------------------------------------------------------
| Orders Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('orders','OrderController');
/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('cities','CityController');
/*
|--------------------------------------------------------------------------
| States Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('states','StateController');
/*
|--------------------------------------------------------------------------
| SpecialTariff Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->resource('special-tariffs','SpecialTariffController');
/*
|--------------------------------------------------------------------------
| Custom Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->get('/','AdminController@index')->name('admin.index'); // index page for admin
