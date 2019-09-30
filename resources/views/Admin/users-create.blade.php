@extends('Admin.Master.layout')

@section('title')
  افزودن کاربر
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('styles')
  <link rel="stylesheet" href="{{asset('AdminPanel/select2/select2.min.css')}}">
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'افزودن کاربر'])
@endsection

@section('content')


<div class="row bg-white pt-3 pb-3">
  <h4 class="col-12 pt-2 pb-3">
    اطلاعات عمومی
  </h4>
  {{-- name and family --}}
  <div class="col-sm-4 mt-1">
    <label for="phone-number">نام
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="محسن باقری"name="cell-phone" value="" required>
  </div>
  {{-- end name and family --}}
  {{-- role --}}
  <div class="col-sm-4 mt-1">
    <label for="phone-number">نقش
      <span class="text-danger">*</span>
    </label>
    <select class="form-control bg-sec"  name="role">
      @foreach($roles as $role)
        <option value="{{$role->id}}">{{$role->name}}</option>
      @endforeach
    </select>
  </div>
  {{-- end role --}}
  {{-- name and family --}}
  <div class="col-sm-4 mt-1">
    <label for="phone-number">شماره همراه
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder="مثال:9106769465"name="cell-phone" value="" required>
  </div>
  {{-- end name and family --}}
  {{--  auto send--}}
  <div class="col-sm-4 mt-5">
    <h6>ارسال خودکار سفارش
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
  {{-- end auto send --}}
  {{--  auto send--}}
  <div class="col-sm-4 mt-5">
    <h6>برگشت کالا از انبار
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
  {{-- end auto send --}}
  {{--  auto send--}}
  <div class="col-sm-4 mt-5">
    <h6>نوع محاسبه هزینه کالا
      <span class="text-danger">*</span>
    </h6>
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">
      براساس جدول و تعرفه پایه
    </label>
    <br />
    <input class=" bg-sec" type="radio" placeholder="100"name="off" value="" >
    <label for="phone-number">
      براساس مبلغ فاکتور
    </label>
  </div>
  {{-- end auto send --}}

  {{-- نقش نماینده --}}
  <div class="col-sm-3 mt-5">
    <label for="phone-number">مدیر نماینده
      <span class="text-danger">*</span>
    </label>
    <select class="form-control bg-sec"  name="country">
      <option value="">بدون مدیر</option>
      <option value="">نماینده</option>
    </select>
  </div>
  {{-- نقش نماینده --}}
  {{-- تعرفه پایه داخلی --}}
  <div class="col-sm-3 mt-5">
    <label for="phone-number">تعرفه پایه داخل
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- تعرفه پایه داخلی --}}
  {{-- تعرفه پایه حومهی --}}
  <div class="col-sm-3 mt-5">
    <label for="phone-number">تعرفه پایه حومه
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- تعرفه پایه حومه--}}
  {{-- تعرفه پایه روستای --}}
  <div class="col-sm-3 mt-5">
    <label for="phone-number">تعرفه پایه روستا
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- تعرفه پایه روستا --}}
</div>


<div class="row bg-white pt-2 pb-3 mt-5">
  <h4 class="col-12 pt-2 pb-3">
  اطلاعات مکان
  </h4>

  {{-- شهر --}}
  <div class="col-sm-6 mt-5">
    <select class="cities col-12 bg-white" name="state">
      @foreach($cities as $city)
        <optgroup class="bg-info" label="{{$city->name}}">
            @foreach($city->states as $state)
              <option value="{{$state->id}}">{{$state->name}}</option>
            @endforeach
        </optgroup>
      @endforeach

    </select>
  </div>
  {{--شهر --}}


</div>

<div class="row bg-white pt-2 pb-3 mt-5">
  <h4 class="col-12 pt-2 pb-3">
  حساب کاربری
  </h4>
  {{-- نام کاربری --}}
  <div class="col-sm-5 mt-5">
    <label for="phone-number">نام کاربری
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="text" placeholder=""name="cell-phone" value="" required>
  </div>
  {{-- نام کاربری--}}
  {{-- گذرواژه --}}
  <div class="col-sm-5 mt-5">
    <label for="phone-number">گذرواژه
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="password" placeholder=""name="cell-phone" value="" required>
  </div>
  {{--گذرواژه--}}
  {{--  وضعیت--}}
  <div class="col-sm-2 mt-5">
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

  <div class="col-12 text-center mt-5">
    <button class="btn btn-success col-2" type="submit" name="button">ثبت کاربر</button>
  </div>
</div>
@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection

@section('scripts')
  <script src="{{asset('AdminPanel/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.cities').select2();
  });
  </script>
@endsection
