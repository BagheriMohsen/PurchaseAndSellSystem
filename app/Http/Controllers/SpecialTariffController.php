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
    public function index($id)
    {
        $user = 'App\User'::findOrFail($id);

        return Response()->json($user->tariffs,200,[],JSON_UNESCAPED_UNICODE);
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
      
        $user_id    = $request->user_id;
        $product_id = $request->product_id;
        $place      = $request->place;

        $product_status = SpecialTariff::where([
            ['user_id','=',$user_id],
            ['product_id','=',$product_id]
        ])->exists(); 

        if($product_status){
            $specialShareds = SpecialTariff::where([
                ['user_id','=',$user_id],
                ['product_id','=',$product_id]
            ])->get(); 

            foreach($specialShareds as $specialShared){

                if($specialShared->place == $place){
                    $result = ['message' => 'اطلاعات برای این محصول و این نماینده قبلا وارد شده است', 'status' => '0'];
                    return Response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
                }
            }

        }

        
        
          SpecialTariff::create([
            'user_id'       =>  $request->user_id,
            'product_id'    =>  $request->product_id,
            'place'         =>  $request->place,
            'price'         =>  $request->price,
          ]);
          $result = ['message' => 'اطلاعات وارد شد', 'status' => '1'];
          return Response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
        

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
          'user_id'         =>  $request->user_id,
          'product_id'      =>  $request->product_id,
          'place'           =>  $request->place,
          'price'           =>  $request->price,
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
