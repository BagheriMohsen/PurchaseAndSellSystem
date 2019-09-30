<?php
use App\User;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|*/
Auth::routes();
Route::get('/logout','HomeController@logout')->name('logout');
Route::post('/loginToSite','HomeController@loginToSite')->name('loginToSite');
/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|*/
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
| Custom Routes
|--------------------------------------------------------------------------
|*/
Route::middleware('auth')->get('/','AdminController@index')->name('admin.index'); // index page for admin
