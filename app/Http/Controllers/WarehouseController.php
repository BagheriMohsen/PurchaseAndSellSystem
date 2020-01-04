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
        $users = 'App\User'::Role(['followUpManager','mainWarehouser'])->get();
        $cities = 'App\City'::latest()->get();
        $states = 'App\State'::latest()->get();
        $warehouse = Warehouse::findOrFail($id);
        return view('Admin.WareHouse.warehouse-edit',compact(
            'warehouse',
            'states',
            'cities',
            'users'
        ));
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
            'state'     =>  'required',
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
            'state_id'      =>  $request->state,
            'city_id'       =>  $request->city,
            'description'   =>  $request->description,
            'address'       =>  $request->address,
            'telephone'     =>  $request->telephone,
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
        
        if($warehouse->id == 1){
            $storeRooms = 'App\StoreRoom'::where('warehouse_id',$warehouse->id)
            ->orWhere([
                ['in_out','=',4],
            ])
            ->orWhere([
                ['in_out','=',15],
            ])
            ->latest()->paginate(15);
            return view('Admin.WareHouse.Maininout',compact('storeRooms','warehouse'));
        }else{
            $storeRooms = 'App\StoreRoom'::where([
                ['warehouse_id','=',$warehouse->id],
                ['in_out','!=',8]
            ])
            ->orWhere([
                ['in_out','=',9]
            ])
            ->orWhere([
                ['in_out','=',13]
            ])
            ->orWhere([
                ['in_out','=',16]
            ])
            ->latest()->paginate(15);
            return view('Admin.WareHouse.Fundinout',compact('storeRooms','warehouse'));
        }
        
    }
    /*
    |--------------------------------------------------------------------------
    | Storage List
    |--------------------------------------------------------------------------
    |*/
    public function storage($id){
        $warehouse  = Warehouse::where('id',$id)->firstOrFail();
        $storages = 'App\Storage'::where('warehouse_id',$id)->get();
        $allProduct = 'App\Storage'::where('warehouse_id',$id)->sum('number');
        return view('Admin.WareHouse.storeRoom-index',compact(
            'storages',
            'allProduct',
            'warehouse'
        ));

    }
}
