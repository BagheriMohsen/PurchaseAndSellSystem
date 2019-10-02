@extends('Admin.Master.layout')

@section('title')
  ویرایش
  {{$product->name}}
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('styles')
  <link rel="stylesheet" href="{{asset('AdminPanel/check-box/checkboxes.min.css')}}">
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>$product->name])
@endsection

@section('content')
  <form action="{{route('products.update',$product->id)}}" method="post" class="row bg-white pt-2 pb-3" enctype="multipart/form-data">
    @csrf
    @method('put')
    {{--تصویر محصول--}}
    <div class="col-sm-4 mt-5">
      <img  class="col-sm-12" src="/storage/{{$product->image}}" alt="">
      <input class="form-control bg-sec col-sm-12 mt-2" type="file" placeholder=""name="image" value="" >
    </div>
    {{-- تصویر محصول--}}
    <div class="col-sm-8">
      <div class="container-fluid">
        <div class="row">
          {{-- عنوان کالا--}}
          <div class="col-sm-6 mt-5">
            <label for="phone-number">عنوان کالا
              <span class="text-danger">*</span>
            </label>
            <input class="form-control bg-sec" type="text" placeholder="" name="name" value="{{$product->name}}" required>
          </div>
          {{-- عنوان کالا --}}
          {{--کد کالا--}}
          <div class="col-sm-6 mt-5">
            <label for="phone-number">کد کالا
              <span class="text-danger">*</span>
            </label>
            <input class="form-control bg-sec" type="text" placeholder=""name="code" value="{{$product->code}}" required>
          </div>
          {{--کد کالاا --}}
          {{--قیمت محصول--}}
          <div class="col-sm-6 mt-5">
            <label for="phone-number">قیمت محصول
              <span class="text-danger">*</span>
            </label>
            <input class="form-control bg-sec" type="text" placeholder=""name="price" value="{{$product->price}}" required>
          </div>
          {{--قیمت محصول--}}
          {{--قیمت خرید--}}
          <div class="col-sm-6 mt-5">
            <label for="phone-number">قیمت خرید
              <span class="text-danger">*</span>
            </label>
            <input class="form-control bg-sec" type="text" placeholder=""name="buyPrice" value="{{$product->buyPrice}}" required>
          </div>
          {{--قیمت خرید--}}
          {{--  وضعیت--}}
          <div class="col-sm-6 mt-5">
            <h6>وضعیت
              <span class="text-danger">*</span>
            </h6>
            <div class="ckbx-style-11">
                <input type="checkbox" id="ckbx-style-11-1" value="active" name="status" @if($product->status != null) checked @endif>
                <label for="ckbx-style-11-1"></label>
            </div>
          </div>
          {{-- وضعیت --}}
          {{--  ارسال پیامک--}}
          <div class="col-sm-6 mt-5">
            <h6>ارسال پیامک
              <span class="text-danger">*</span>
            </h6>
            <div class="ckbx-style-11">
                <input type="checkbox" id="ckbx-style-12-1" value="active" name="message" @if($product->messageStatus != null) checked @endif>
                <label for="ckbx-style-12-1"></label>
            </div>
          </div>
          {{-- ارسال پیامک --}}
        </div>
      </div>
    </div>


    {{-- توضیحات --}}
    <div style="direction:rtl;" class="col-sm-6 mx-auto mt-5">
      <label for="description">توضیحات محصول</label>
      <textarea class="col-12" name="description" placeholder="توضیحات این محصول را وارد کنید" rows="8" cols="80">
        {!! $product->descriptsion !!}
      </textarea>
    </div>
    {{-- توضیحات --}}
    <div class="col-12 text-center mt-5">
      <button class="btn btn-info col-2" type="submit" name="button">ویرایش محصول</button>
    </div>


  </form>

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
