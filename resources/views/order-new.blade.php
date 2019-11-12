@extends('Master.layout')

@section('title')
  ثبت سفارش
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

<div class="row bg-white pt-3 pb-3">
  <h4 class="pt-2 pb-2 col-12 text-center">
    مشخصات مشتری
    <hr width="200px" style="border-bottom:5px solid red;" />
  </h4>
  {{-- cell-phone --}}
  <div class="col-sm-3 mt-1">
    <label for="phone-number">موبایل(بدون صفر)
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="مثال:9106769465"name="cell-phone" value="" required>
  </div>
  {{-- landline-phone --}}
  <div class="col-sm-3 mt-1">
    <label for="phone-number">تلفن ثابت
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="مثال:9106769465"name="landline-phone" value="" required>
  </div>
  {{-- state --}}
  <div class="col-sm-3 mt-1">
    <label for="phone-number">استان
      <span class="text-danger">*</span>
    </label>
    <select class="form-control bg-sec" name="state">
      <option value="">جعفریه</option>
      <option value="">کهک</option>
    </select>
  </div>
  {{-- country --}}
  <div class="col-sm-3 mt-1">
    <label for="phone-number">شهر
      <span class="text-danger">*</span>
    </label>
    <select class="form-control bg-sec"  name="country">
      <option value="">قم</option>
      <option value="">تهران</option>
    </select>
  </div>
  {{-- detail:name-family-code-hbd --}}
  <div class="col-sm-6 mt-5">
    <div class="container-fluid">
      <div class="row">
        {{-- name and family --}}
        <div class="col-sm-12">
          <label for="phone-number">نام و نام خانوادگی
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="محسن باقری"name="landline-phone" value="" required>
        </div>
        {{-- code --}}
        <div class="col-sm-6 mt-4">
          <label for="phone-number">کد پستی
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="محسن باقری"name="landline-phone" value="" required>
        </div>
        {{-- HBD --}}
        <div class="col-sm-6 mt-4">
          <label for="phone-number">تاریخ تولد
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="date" placeholder="محسن باقری"name="landline-phone" value="" required>
        </div>
        {{-- end --}}
      </div>
    </div>
  </div>
  {{-- address --}}
  <div class="col-sm-6 mt-5">
    <label for="phone-number">آدرس
      <span class="text-danger">*</span>
    </label>
    <textarea rows="5" cols="50" class="form-control bg-sec" type="text" placeholder="مثال:9106769465"name="landline-phone" value="" required>
    </textarea>
  </div>

</div>



<div class="row mt-5 bg-white pt-3 pb-3">
  <h4 class="pt-2 pb-2 col-12 text-center">
    محصولات
    <hr width="150px" style="border-bottom:5px solid red;" />
  </h4>
    {{-- item row --}}
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <label for="phone-number">انتخاب محصول
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="شامپو"name="product" value="" required>
        </div>
        <div class="col-sm-1">
          <label for="phone-number">تعداد
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="1"name="count" value="" required>
        </div>
        <div class="col-sm-2">
          <label for="phone-number">قیمت-تومان
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="1500,000"name="price" value="" required>
        </div>
        <div class="col-sm-2">
          <label for="phone-number">تخفیف
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" placeholder="100"name="off" value="" required>
        </div>
        <div class="col-sm-3 mt-1">
          <label for="phone-number">مدل محصول
            <span class="text-danger">*</span>
          </label>
          <select class="form-control bg-sec"  name="model">
            <option value="">روز</option>
            <option value="">شب</option>
          </select>
      </div>
      <div class="col-sm-1 mt-1 text-center mt-5 " >
        <strong>
          <a class="text-danger" href="#">
            X
          </a>
        </strong>
      </div>

    </div>
  </div>
  {{-- end item row --}}

  <a class="btn btn-success mt-4" href="#">
    افزودن محصول
  </a>
</div>



<div class="row mt-5 bg-white pt-3 pb-3">
  {{-- title --}}
  <h4 class="pt-2 pb-2 col-12 text-center">
    پرداخت
    <hr width="150px" style="border-bottom:5px solid red;" />
  </h4>

  <div class="col-sm-2">
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">نقدی
    </label>

    <br />
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">غیر نقدی
    </label>

  </div>
  <div class="col-sm-3">
    <label for="phone-number">هزینه ارسال
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="100"name="off" value="" >
  </div>

  <div class="col-sm-3">
    <label for="phone-number">مبلغ پرداخت نقدی
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="100"name="off" value="" >
  </div>

  <div class="col-sm-3">
    <label for="phone-number">مبلغ پیش واریزی
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="100"name="off" value="" >
  </div>

  <div class="col-sm-4 mt-4 ">
    <label for="phone-number">مبلغ پرداخت بصورت چک
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="100"name="off" value="" >
  </div>
  <div class="col-sm-4 mt-4 mx-auto">
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">عادی
    </label>

    <br />
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">غیر عادی
    </label>

  </div>

  <div class="col-sm-6 mt-5">
    <label for="phone-number">توضیحات
      <span class="text-danger">*</span>
    </label>
    <textarea rows="10" cols="50" class="form-control bg-sec" type="text" placeholder="مثال:9106769465"name="landline-phone" value="" required>
    </textarea>
  </div>

<div class="col-sm-12 mt-5 text-center">
  <button class="btn btn-info col-2" type="submit" name="button">
    ثبت سفارش
  </button>
</div>
</div>
@endsection

@section('footer')
  @include('Master.footer')
@endsection