@extends('Admin.Master.layout')

@section('title')
  افزودن محصول
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
  @include('Admin.Master.path',['title'=>'افزودن محصول'])
@endsection

@section('content')
  <form action="{{route('products.store')}}" method="post" class="row bg-white pt-2 pb-3" enctype="multipart/form-data">
    @csrf
    {{-- عنوان کالا--}}
    <div class="col-sm-4 mt-5">
      <label for="phone-number">عنوان کالا
        <span class="text-danger">*</span>
      </label>
      <input class="form-control bg-sec" type="text" placeholder="" name="name" value="" required>
    </div>
    {{-- عنوان کالا --}}
    {{--کد کالا--}}
    <div class="col-sm-4 mt-5">
      <label for="phone-number">کد کالا
        <span class="text-danger">*</span>
      </label>
      <input class="form-control bg-sec" type="text" placeholder=""name="code" value="" required>
    </div>
    {{--کد کالاا --}}
    {{--تصویر محصول--}}
    <div class="col-sm-4 mt-5">
      <label for="phone-number">تصویر محصول
        <span class="text-danger">*</span>
      </label>
      <input class="form-control bg-sec" type="file" placeholder=""name="image" value="" required>
    </div>
    {{-- تصویر محصول--}}
    {{--قیمت محصول--}}
    <div class="col-sm-6 mt-5">
      <label for="phone-number">قیمت محصول
        <span class="text-danger">*</span>
      </label>
      <input class="form-control bg-sec" type="text" placeholder=""name="price" value="" required>
    </div>
    {{--قیمت محصول--}}
    {{--قیمت خرید--}}
    <div class="col-sm-4 mt-5">
      <label for="phone-number">قیمت خرید
        <span class="text-danger">*</span>
      </label>
      <input class="form-control bg-sec" type="text" placeholder=""name="buyPrice" value="" required>
    </div>
    {{--قیمت خرید--}}
    <div class="col-sm-4">
      <div class="container-fluid">
        <div class="row">
          {{--  وضعیت--}}
          <div class="col-sm-12 mt-5">
            <h6>وضعیت
              <span class="text-danger">*</span>
            </h6>
            <div class="ckbx-style-11">
                <input type="checkbox" id="ckbx-style-11-1" value="active" name="status">
                <label for="ckbx-style-11-1"></label>
            </div>
          </div>
          {{-- وضعیت --}}
          {{--  ارسال پیامک--}}
          <div class="col-sm-12 mt-5">
            <h6>ارسال پیامک
              <span class="text-danger">*</span>
            </h6>
            <div class="ckbx-style-11">
                <input type="checkbox" id="ckbx-style-12-1" value="active" name="message">
                <label for="ckbx-style-12-1"></label>
            </div>
          </div>
          {{-- ارسال پیامک --}}
        </div>
      </div>
    </div>
    {{-- توضیحات --}}
    <div class="col-sm-7 mx-auto mt-5">
      <label for="description">توضیحات محصول</label>
      <textarea class="col-12" name="description" placeholder="توضیحات این محصول را وارد کنید" rows="8" cols="80"></textarea>
    </div>
    {{-- توضیحات --}}
    <div class="col-12 text-center mt-5">
      <button class="btn btn-success col-2" type="submit" name="button">ثبت محصول</button>
    </div>


  </form>

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
