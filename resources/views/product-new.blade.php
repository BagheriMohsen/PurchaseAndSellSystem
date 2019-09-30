@extends('Master.layout')

@section('title')
  ثبت محصول
@endsection

@section('header')
  @include('Master.header')
@endsection

@section('sidebar')
  @include('Master.sidebar')
@endsection

@section('path')
  @include('Master.path')
@endsection

@section('content')

<div class="row bg-white pt-2 pb-3">
  {{-- عنوان کالا--}}
  <div class="col-sm-4 mt-5">
    <label for="phone-number">عنوان کالا
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- عنوان کالا --}}
  {{--کد کالا--}}
  <div class="col-sm-4 mt-5">
    <label for="phone-number">کد کالا
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{--کد کالاا --}}
  {{--تصویر محصول--}}
  <div class="col-sm-4 mt-5">
    <label for="phone-number">تصویر محصول
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="file" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- تصویر محصول--}}
  {{--قیمت محصول--}}
  <div class="col-sm-6 mt-5">
    <label for="phone-number">قیمت محصول
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{--قیمت محصول--}}
  {{--قیمت خرید--}}
  <div class="col-sm-6 mt-5">
    <label for="phone-number">قیمت خرید
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{--قیمت خرید--}}
  {{--  وضعیت--}}
  <div class="col-sm-4 mt-5">
    <h6>وضعیت
      <span class="text-danger">*</span>
    </h6>
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">فعال
    </label>
    <br />
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">غیر فعال
    </label>
  </div>
  {{-- وضعیت --}}
  {{--  ارسال پیامک--}}
  <div class="col-sm-4 mt-5">
    <h6>ارسال پیامک
      <span class="text-danger">*</span>
    </h6>
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">فعال
    </label>
    <br />
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">غیر فعال
    </label>
  </div>
  {{-- ارسال پیامک --}}

  <div class="col-12 text-center mt-5">
    <button class="btn btn-success col-2" type="submit" name="button">ثبت محصول</button>
  </div>
</div>

@endsection

@section('footer')
  @include('Master.footer')
@endsection
