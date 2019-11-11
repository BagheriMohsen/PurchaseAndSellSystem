<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('Admin.WareHouse.warehouse-index',compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = 'App\City'::latest()->get();
        return view('Admin.WareHouse.warehouse-create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>  'required | unique:warehouses',
            'city'      =>  'required',
            'address'   =>  'required'
        ],[
            'name.required'     =>      'نام انبار الزامی ست',
            'name.unique'       =>      'این نام قبلا انتخاب شده',
            'city.required'     =>      'شهر انتخاب نشده',
            'address.required'  =>      'لطفا فیلد آدرس را پر کنید'
        ]);
        
        Warehouse::create([
            'user_id'       =>  auth()->user()->id,
            'name'          =>  $request->name,
            'city_id'       =>  $request->city,
            'description'   =>  $request->description,
            'address'       =>  $request->address,
            'telephon'      =>  $request->telephon,
            'postalCard'    =>  $request->postalCard 
        ]);
        $message = $request->name.' به لیست انبارها اضافه شد';
        return redirect()->route('warehouses.index')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cities = 'App\City'::latest()->get();
        $warehouse = Warehouse::findOrFail($id);
        return view('Admin.WareHouse.warehouse-edit',compact('warehouse','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      =>  'required',
            'city'      =>  'required',
            'address'   =>  'required'
        ],[
            'name.required'     =>      'نام انبار الزامی ست',
            'city.required'     =>      'شهر انتخاب نشده',
            'address.required'  =>      'لطفا فیلد آدرس را پر کنید'
        ]);
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'user_id'       =>  auth()->user()->id,
            'name'          =>  $request->name,
            'city_id'       =>  $request->city,
            'description'   =>  $request->description,
            'address'       =>  $request->address,
            'telephon'      =>  $request->telephon,
            'postalCard'    =>  $request->postalCard 
        ]);
        $message = $request->name.' به روز رسانی شد';
        return redirect()->route('warehouses.index')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $name = $warehouse->name;
        Warehouse::destroy($id);
        $message =$name.' از لیست انبارها حذف شد';
        return redirect()->route('warehouses.index')->with('message',$message);
    }
    /*
    |--------------------------------------------------------------------------
    | Warehouse IN-OUT List
    |--------------------------------------------------------------------------
    |*/
    public function inout($slug){
        $warehouse  = Warehouse::where('slug',$slug)->firstOrFail();
        $storeRooms = 'App\StoreRoom'::where('warehouse_id',$warehouse->id)
        ->latest()->paginate(10);
        return view('Admin.WareHouse.inout',compact('storeRooms','warehouse'));
    }
}
