<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SpecialTariff;
class SpecialTariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $status = SpecialTariff::where([
          ['user_id'    ,'='  ,$request->user_id],
          ['product_id' ,'='  ,$request->product_id]
        ])->exists();

        if($status != True){
          SpecialTariff::create([
            'user_id'       =>  $request->user_id,
            'product_id'    =>  $request->product_id,
            'internalPrice' =>  $request->internalPrice,
            'locallyPrice'  =>  $request->locallyPrice,
            'villagePrice'  =>  $request->villagePrice
          ]);
          $message = 'اطلاعات وارد شد';
          return Response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
        }else{
          $message = 'اطلاعات برای این محصول و این نماینده قبلا وارد شده است';
          return Response()->json($message,200,[],JSON_UNESCAPED_UNICODE);
        }

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
        //
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
        $tariff = SpecialTariff::find($id);
        $tariff->update([
          'user_id'       =>  $request->user_id,
          'product_id'    =>  $request->product_id,
          'internalPrice' =>  $request->internalPrice,
          'locallyPrice'  =>  $request->locallyPrice,
          'villagePrice'  =>  $request->villagePrice
        ]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SpecialTariff::destroy($id);
        return back();
    }
}