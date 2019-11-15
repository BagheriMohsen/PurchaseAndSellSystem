<?php
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
| AdminController Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','as'=>'admin.'],function(){
  Route::get('/home','AdminController@index')->name('index');
});
/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'users','as'=>'users.'],function(){
    Route::get('agents','UserController@agents')->name('agents');
    Route::get('sellers','UserController@sellers')->name('sellers');
    Route::get('{id}/switchAccount','UserController@switchAccount')->name('switchAccount');
    Route::get('backToPerivouseAccount','UserController@backToPerivouseAccount')->name('backToPerivouseAccount');
    Route::get('//{username}/Myedit','UserController@userPublicEdit')->name('public.edit');
    Route::put('/{username}/Myupdate','UserController@userPublicUpdate')->name('public.update');
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
Route::group(['middlware'=>['auth'],'prefix'=>'/admin/products/','as'=>'products.'],function(){
    Route::get('{slug}','ProductController@edit')->name('edit');
    Route::get('off/{slug}','ProductController@off_index')->name('off');
    Route::post('off/{id}','ProductController@off_store')->name('off.store');
    Route::delete('off/{id}','ProductController@off_destroy')->name('off.destroy');
});
Route::middleware('auth')->resource('products','ProductController',['except' => [
  'show',
  'edit'
]]);
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
| Store Room Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','as'=>'storeRooms.','prefix'=>'/storeRooms'],function(){
      Route::get('/','StoreRoomController@index')->name('index');
      /* MainWareHouse */
      Route::get('/create','StoreRoomController@create')->name('create');
      Route::post('/inStore','StoreRoomController@inManage')->name('inManage');
      Route::post('/outStore','StoreRoomController@outManage')->name('outManage');
      Route::post('/storageChange','StoreRoomController@storageChange')->name('storageChange');
      Route::get('/in','StoreRoomController@inStorage')->name('in');
      Route::get('/out','StoreRoomController@outStorage')->name('out');
      Route::get('/storageManage','StoreRoomController@storageManage')->name('storageManage');
      Route::get('/mainReceive','StoreRoomController@mainReceive')->name('mainReceive');
      /* FundWareHouse */
      Route::get('/acceptMainReceive/{id}','StoreRoomController@acceptMainReceive')->name('acceptMainReceive');
      Route::get('/AgentExchangesForm','StoreRoomController@AgentExchangesForm')->name('AgentExchangesForm');
      Route::post('/sendToAgent','StoreRoomController@sendToAgent')->name('sendToAgent');
      Route::post('/AgentToAgent','StoreRoomController@AgentToAgent')->name('AgentToAgent');
});

/*
|--------------------------------------------------------------------------
| Warehouse Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'warehouses','as'=>'warehouses.'],function(){
    Route::get('{slug}','WarehouseController@inout')->name('inout');
});

Route::middleware('auth')->resource('warehouses','WarehouseController');