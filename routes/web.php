<?php
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
  Route::get('/','AdminController@index')->name('index');
  Route::get('/general-setting','AdminController@GeneralSetting')->name('GeneralSetting');
  Route::post('/general-setting-update/{id}','AdminController@GeneralSettingUpdate')->name('GeneralSettingUpdate');
});
/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'users/','as'=>'users.'],function(){
  Route::get('agents','UserController@agents')->name('agents');
  Route::get('sellers','UserController@sellers')->name('sellers');
  Route::get('callCenters','UserController@callCenter')->name('callCenters');
  Route::get('{id}/switchAccount','UserController@switchAccount')->name('switchAccount');
  Route::get('backToPerivouseAccount','UserController@backToPerivouseAccount')->name('backToPerivouseAccount');
  Route::get('{id}/Myedit','UserController@userPublicEdit')->name('public.edit');
  Route::put('{id}/Myupdate','UserController@userPublicUpdate')->name('public.update');
  Route::get('uploadCS_status/{id}','UserController@uploadCS_status')->name('uploadCS_status');
  Route::get('followUpManagerStateStore','UserController@followUpManagerStateStore')->name('followUpManager.stateStore');
  Route::get('followUpManagerStateClear/{StateName}','UserController@followUpManagerStateClear')->name('followUpManagerStateClear');
  /* Admin Dashboard */
  Route::get('Admin-Dashboard','UserController@AdminDashboard')->name('AdminDashboard');
  Route::get('Admin-Dashboard-Chart-API','UserController@AdminDashboardChartApi')->name('AdminDashboardChartApi');
  /* Agent Dashboard */
  Route::get('Agent-Dashboard','UserController@AgentDashboard')->name('AgentDashboard');
  Route::get('Agent-Dashboard-Chart-API/{userID}','UserController@AgentDashboardChartApi')->name('AgentDashboardChartApi');
  /* Agent Chief Dashboard */
  Route::get('AgentChief-Dashboard/','UserController@AgentChiefDashboard')->name('AgentChiefDashboard');
  Route::get('AgentListsForAgentChief/','UserController@AgentListsForAgentChief')->name('AgentListsForAgentChief');
  Route::get('Agent-Chief-Dashboard-Chart-API/','UserController@AgentChiefDashboardChartApi')->name('AgentChiefDashboardChartApi');

  /* Seller Dashboard */
  Route::get('Seller-Dashboard','UserController@SellerDashboard')->name('SellerDashboard');
  /* CallCenter */
  Route::get('callCenterAddNewOrderChange/{id}','UserController@callCenterAddNewOrderChange')->name('callCenterAddNewOrderChange');
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
Route::middleware('auth')->get('types/{id}','ProductTypeController@index')->name('types.index');
Route::middleware('auth')->resource('types','ProductTypeController',['except'=>[
  'index'
]]);

/*
|--------------------------------------------------------------------------
| Orders Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middlware'=>['auth'],'prefix'=>'/admin/orders/','as'=>'orders.'],function(){
  /* Sellers */
  Route::get('ProductList','OrderController@ProductList')->name('ProductList');
  Route::get('AgentExistInState/{CityName}','OrderController@AgentExistInState')->name('AgentExistInState');
  Route::get('sellerOrdersLists','OrderController@sellerOrdersLists')->name('sellerOrdersLists');
  Route::get('sellerNoActionOrders','OrderController@sellerNoActionOrders')->name('sellerNoActionOrders');
  Route::get('sellerOrderCallBack','OrderController@sellerOrderCallBack')->name('sellerOrderCallBack');
  Route::get('receiveOrderFromFollowUpManager','OrderController@receiveOrderFromFollowUpManager')->name('receiveOrderFromFollowUpManager');
  Route::get('OrdersForEdit','OrderController@OrdersForEdit')->name('OrdersForEdit');
  Route::get('OrdersProductForEditPage/{id}','OrderController@OrdersProductForEditPage')->name('OrdersProductForEditPage');
  Route::post('update/{id}','OrderController@update')->name('update');
  
  /* Agents */
  Route::get('AgentOrderLists','OrderController@AgentOrderLists')->name('AgentOrderLists');
  Route::get('AgentOrderCollectedlist','OrderController@AgentOrderCollectedlist')->name('AgentOrderCollectedlist');
  Route::get('AgentOrderCanceledList','OrderController@AgentOrderCanceledList')->name('AgentOrderCanceledList');
  Route::get('AgentOrderSuspendedList','OrderController@AgentOrderSuspendedList')->name('AgentOrderSuspendedList');
  Route::get('AgentChangeOrderStatus','OrderController@AgentChangeOrderStatus')->name('AgentChangeOrderStatus');
  //FollowUpManager 
  Route::get('UnverifiedOrderList','OrderController@UnverifiedOrderList')->name('UnverifiedOrderList');
  Route::get('receiveOrderFromAgent','OrderController@receiveOrderFromAgent')->name('receiveOrderFromAgent');
  Route::get('chooseAgentForDelivary','OrderController@chooseAgentForDelivary')->name('chooseAgentForDelivary');
  //Agent Chief
  Route::get('AgentsDelivaryOrders','OrderController@AgentsDelivaryOrders')->name('AgentsDelivaryOrders');
  Route::get('AgentsCollectedOrders','OrderController@AgentsCollectedOrders')->name('AgentsCollectedOrders');
  Route::get('AgentsCancelledOrders','OrderController@AgentsCancelledOrders')->name('AgentsCancelledOrders');
  Route::get('AgentsSuspendedOrders','OrderController@AgentsSuspendedOrders')->name('AgentsSuspendedOrders');
  //Factor
  Route::get('Factor/{id}','OrderController@Factor')->name('Factor');
});
Route::get('order-change','OrderController@change_it');
Route::middleware('auth')->resource('orders','OrderController',['except' => [
  'update',
]]);

/*
|--------------------------------------------------------------------------
| States Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middlware'=>['auth'],'prefix'=>'/states/','as'=>'states.'],function(){
    Route::get('AllStatesAndCitiesName','StateController@AllStatesAndCitiesName')->name('AllStatesAndCitiesName');
});
Route::middleware('auth')->resource('states','StateController');

/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middlware'=>['auth'],'prefix'=>'/cities/','as'=>'cities.'],function(){
  Route::get('search','CityController@search')->name('search');
});
Route::middleware('auth')->resource('cities','CityController');

/*
|--------------------------------------------------------------------------
| SpecialTariff Routes
|--------------------------------------------------------------------------
|*/
Route::get('special-tariffs-index/{id}','SpecialTariffController@index')->name('special-tariffs.index');
Route::middleware('auth')->resource('special-tariffs','SpecialTariffController',['except'=>[
  'index'
]]);

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
    Route::get('/returnFromFund','StoreRoomController@returnFromFund')->name('returnFromFund');
    Route::get('/acceptFromFundForm','StoreRoomController@acceptFromFundForm')->name('acceptFromFundForm');
    Route::get('/acceptFromFund/{id}','StoreRoomController@acceptFromFund')->name('acceptFromFund');
    /* FundWareHouse */
    Route::get('/mainReceive','StoreRoomController@mainReceive')->name('mainReceive');
    Route::get('/acceptMainReceive/{id}','StoreRoomController@acceptMainReceive')->name('acceptMainReceive');
    Route::get('/AgentExchangesForm','StoreRoomController@AgentExchangesForm')->name('AgentExchangesForm');
    Route::post('/sendToAgent','StoreRoomController@sendToAgent')->name('sendToAgent');
    Route::post('/AgentToAgent','StoreRoomController@AgentToAgent')->name('AgentToAgent');
    Route::post('/returnToMain','StoreRoomController@returnToMain')->name('returnToMain');
    Route::get('/AgentExchangeStorage','StoreRoomController@AgentExchangeStorage')->name('AgentExchangeStorage');
    Route::get('/SendToAgentList','StoreRoomController@SendToAgentList')->name('SendToAgentList');
    Route::get('/returnFromAgents','StoreRoomController@returnFromAgents')->name('returnFromAgents');
    Route::get('/ReturnFromAgentPage','StoreRoomController@ReturnFromAgentPage')->name('ReturnFromAgentPage');
    Route::get('/AcceptAgentReturnedProducts/{id}','StoreRoomController@AcceptAgentReturnedProducts')->name('AcceptAgentReturnedProducts');
    /* AgentWareHouse */
    Route::get('/AgentReceive','StoreRoomController@AgentReceive')->name('AgentReceive');
    Route::get('/acceptFundReceive/{id}','StoreRoomController@acceptFundReceive')->name('acceptFundReceive');
    Route::get('/AgentIndexWarehouse','StoreRoomController@AgentIndexWarehouse')->name('AgentIndexWarehouse');
    Route::get('/AgentOut','StoreRoomController@AgentOut')->name('AgentOut');
    Route::get('/AgentIn','StoreRoomController@AgentIn')->name('AgentIn');
    Route::get('/returnToFundForm','StoreRoomController@returnToFundForm')->name('returnToFundForm');
    Route::post('/returnToFund','StoreRoomController@returnToFund')->name('returnToFund');
    Route::get('DeliveryToCustomersList','StoreRoomController@DeliveryToCustomersList')->name('DeliveryToCustomersList');
    /* AgentChief WareHouse Check*/
    Route::get('AgentsListForCheckStorage','StoreRoomController@AgentsListForCheckStorage')->name('AgentsListForCheckStorage');
    Route::get('AgensStorageWareHoouse/{agent_id}','StoreRoomController@AgensStorageWareHoouse')->name('AgensStorageWareHoouse');
    Route::get('AgensStorageIn/{agent_id}','StoreRoomController@AgensStorageIn')->name('AgensStorageIn');
    Route::get('AgensStorageOut/{agent_id}','StoreRoomController@AgensStorageOut')->name('AgensStorageOut');
    Route::get('AgensDeliveryToCustomers/{agent_id}','StoreRoomController@AgensDeliveryToCustomers')->name('AgensDeliveryToCustomers');
    /** Delete Rows From Store_rooms table  */
    Route::get('/delete/{id}','StoreRoomController@delete')->name('delete');
    /** Update Rows From Store_rooms table  */
    Route::post('/storeRoomsUpdate/{id}','StoreRoomController@storeRoomsUpdate')->name('storeRoomsUpdate');

  });

/*
|--------------------------------------------------------------------------
| Warehouse Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'warehouses','as'=>'warehouses.'],function(){
    Route::get('{slug}','WarehouseController@inout')->name('inout');
    Route::get('/storage/{id}','WarehouseController@storage')->name('storage');
});
/*
|--------------------------------------------------------------------------
| Money Circulation Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'user-inventory','as'=>'userInventory.'],function(){
    /* Agent */
    Route::get('AgentCurrentBills','MoneyCirculationController@AgentCurrentBills')->name('AgentCurrentBills');
    Route::get('AgentPaymentOrders','MoneyCirculationController@AgentPaymentOrders')->name('AgentPaymentOrders');
    Route::get('AgentPaymentList','MoneyCirculationController@AgentPaymentList')->name('AgentPaymentList');
    Route::get('AgentPaymentDelete/{id}','MoneyCirculationController@AgentPaymentDelete')->name('AgentPaymentDelete');
    Route::post('AgentPaymentListUpdate/{id}','MoneyCirculationController@AgentPaymentListUpdate')->name('AgentPaymentListUpdate');
    Route::get('AgentCostsList','MoneyCirculationController@AgentCostsList')->name('AgentCostsList');
    Route::post('AgentCostsStore','MoneyCirculationController@AgentCostsStore')->name('AgentCostsStore');      
    Route::post('AgentCostsUpdate/{id}','MoneyCirculationController@AgentCostsUpdate')->name('AgentCostsUpdate');      
    Route::get('AgentCostsDelete/{id}','MoneyCirculationController@AgentCostsDelete')->name('AgentCostsDelete');
    Route::get('AgentPaybackList','MoneyCirculationController@AgentPaybackList')->name('AgentPaybackList');
    Route::get('AgentpaymentSettlement ','MoneyCirculationController@AgentpaymentSettlement')->name('AgentpaymentSettlement');
    Route::post('cartStore','MoneyCirculationController@cartStore')->name('cartStore');
    Route::get('cartSetDefaultStore/{id}','MoneyCirculationController@cartSetDefault')->name('cartSetDefault');
    Route::get('cartDelete/{id}','MoneyCirculationController@cartDelete')->name('cartDelete');
    Route::post('AgentPayMoney','MoneyCirculationController@AgentPayMoney')->name('AgentPayMoney');
    Route::get('/currentBillsDebtor/{user_id}','MoneyCirculationController@currentBillsDebtor')->name('currentBillsDebtor');
    Route::get('/currentBillsCreditor/{user_id}','MoneyCirculationController@currentBillsCreditor')->name('currentBillsCreditor');
    /* Agent Chief */
    Route::get('AgentsMoneyCirculation','MoneyCirculationController@AgentsMoneyCirculation')->name('AgentsMoneyCirculation');
    Route::get('AgentsPaymentList/{agent_id}','MoneyCirculationController@AgentsPaymentList')->name('AgentsPaymentList');
    /* Admin */
    Route::get('AgentUnverifiedPayment','MoneyCirculationController@AgentUnverifiedPayment')->name('AgentUnverifiedPayment');
    Route::get('AdminAcceptAgentPayment/{id}','MoneyCirculationController@AdminAcceptAgentPayment')->name('AdminAcceptAgentPayment');
    Route::get('RejectPayment/{id}','MoneyCirculationController@RejectPayment')->name('RejectPayment');
    Route::get('AgentUnverifiedCosts','MoneyCirculationController@AgentUnverifiedCosts')->name('AgentUnverifiedCosts');
    Route::get('AgentCostConfirm/{id}','MoneyCirculationController@AgentCostConfirm')->name('AgentCostConfirm');
    Route::get('RejectCost/{id}','MoneyCirculationController@RejectCost')->name('RejectCost');

});

/*
|--------------------------------------------------------------------------
| Search Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'search','as'=>'search.'],function(){
    /* Admin */
    Route::get('AdminAdvancedSearchPage','SearchController@AdminAdvancedSearchPage')->name('AdminAdvancedSearchPage');
    Route::post('AdminAdvancedSearch','SearchController@AdminAdvancedSearch')->name('AdminAdvancedSearch');
});
/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
|*/
Route::group(['middleware'=>'auth','prefix'=>'report/','as'=>'report.'],function(){

  Route::get('Costs','ReportController@Costs')->name('Costs');
  Route::post('Costs-Filter','ReportController@costs_filter')->name('costs_filter');
  Route::get('Orders','ReportController@Orders')->name('Orders');
  Route::post('orders-Filter','ReportController@orders_filter')->name('orders_filter');
  Route::get('Payments','ReportController@Payments')->name('Payments');
  Route::post('Payments-Filter','ReportController@payments_filter')->name('payments_filter');


  
});

Route::middleware('auth')->resource('warehouses','WarehouseController');