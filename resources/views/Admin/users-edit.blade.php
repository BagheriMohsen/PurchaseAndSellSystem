@extends('Admin.Master.layout')

@section('title')
  افزودن کاربر
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('styles')
  <link rel="stylesheet" href="{{asset('AdminPanel/switch-button/bootstrap-switch-button.min.css')}}">
  <link rel="stylesheet" href="{{asset('AdminPanel/select2/select2.min.css')}}">
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'افزودن کاربر'])
@endsection

@section('content')

<form action="{{route('users.update',$user->id)}}" method="post">
  @csrf
  @method('put')
<div class="row bg-white pt-3 pb-3">
  <h4 class="col-12 pt-2 pb-3">
    اطلاعات عمومی
  </h4>
  {{-- first section --}}
  <div class="col-sm-4 mx-auto">
    <div class="container-fluid">
      <div class="row">
        {{-- نام --}}
        <div class="col-sm-12">
          <label for="phone-number">نام
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" name="name" value="{{$user->name}}" required>
        </div>
        {{-- نام --}}
        {{-- نام خانوادگی  --}}
        <div class="col-sm-12 mt-3">
          <label for="phone-number">
            نام خانوادگی
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" name="family" value="{{$user->family}}" required>
        </div>
        {{-- نام خانوادگی  --}}
        {{-- role --}}
        <div class="col-sm-12  mt-3">
          <label for="phone-number">نقش
            <span class="text-danger">*</span>
          </label>
          <select class="form-control bg-sec"  name="role">
            @foreach($roles as $role)
              <option @if($role->id === $user->role_id ) selected @endif value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
          </select>
        </div>
        {{-- end role --}}
        {{-- name and family --}}
        <div class="col-sm-12 mt-3">
          <label for="phone-number">شماره همراه
            <span class="text-danger">*</span>
          </label>
          <input class="form-control bg-sec" type="text" name="mobile" value="{{$user->mobile}}" required>
        </div>
        {{-- end name and family --}}
      </div>
    </div>
  </div>
  {{-- first section --}}



{{-- third section --}}
<div class="col-sm-4 mx-auto">
  <div class="container-fluid">
    <div class="row">
      {{-- جنسیت --}}
      <div class="col-sm-12 ">
        <label for="phone-number">جنسیت
          <span class="text-danger">*</span>
        </label>
        <select class="form-control bg-sec"  name="sex">
          <option @if($user->sex != 0)  selected @endif value="1">مرد</option>
          <option @if($user->sex != 1)  selected @endif value="0">زن</option>
        </select>
      </div>
      {{-- جنسیت --}}
      {{-- نقش نماینده --}}
      <div class="col-sm-12 mt-3">
        <label for="phone-number">مدیر نماینده
          <span class="text-danger">*</span>
        </label>
        <select class="form-control bg-sec"  name="agent_id">

          <option value="">بدون مدیر</option>
          <option value="">نماینده</option>
        </select>
      </div>
      {{-- نقش نماینده --}}
      {{-- تعرفه پایه داخلی --}}
      <div class="col-sm-12 mt-3">
        <label for="phone-number">تعرفه پایه داخل
          <span class="text-danger">*</span>
        </label>
        <input class="form-control bg-sec" type="text" placeholder="" name="internal" value="{{$user->internalPrice}}" required>
      </div>
      {{-- تعرفه پایه داخلی --}}
      {{-- تعرفه پایه حومهی --}}
      <div class="col-sm-12 mt-3">
        <label for="phone-number">تعرفه پایه حومه
          <span class="text-danger">*</span>
        </label>
        <input class="form-control bg-sec" type="text" placeholder="" name="locally" value="{{$user->locallyPrice}}" required>
      </div>
      {{-- تعرفه پایه حومه--}}
      {{-- تعرفه پایه روستای --}}
      <div class="col-sm-12 mt-3">
        <label for="phone-number">تعرفه پایه روستا
          <span class="text-danger">*</span>
        </label>
        <input class="form-control bg-sec" type="text" placeholder="" name="village" value="{{$user->villagePrice}}" required>
      </div>
      {{-- تعرفه پایه روستا --}}
    </div>
  </div>
</div>
{{-- end third section --}}

{{-- second section --}}
<div class="col-sm-12 mt-5">
  <div class="container-fluid">
    <div class="row">
      {{--  auto send--}}
      <div class="col-sm-4 mt-3">
        <h6>ارسال سفارش

        </h6>
        <input type="checkbox"
           data-toggle="switchbutton"
           data-onstyle="success"
           data-offstyle="danger"
           data-onlabel="خودکار"
           data-offlabel="دستی" name="sendAuto" @if($user->sendAuto != null) checked @endif>
      </div>
      {{-- end auto send --}}
      {{--  auto send--}}
      <div class="col-sm-4 mt-3">
        <h6>برگشت کالا از انبار

        </h6>
        <input type="checkbox"
           data-toggle="switchbutton"
           data-onstyle="success"
           data-offstyle="danger"
           data-onlabel="خودکار"
           data-offlabel="دستی" name="reciveAuto" @if($user->reciveAuto != null) checked @endif>
      </div>
      {{-- end auto send --}}
      {{--  auto send--}}
      <div class="col-sm-4 mt-3">
        <h6>نوع محاسبه هزینه کالا
        </h6>
        <input type="checkbox"
           data-toggle="switchbutton"
           data-onstyle="success"
           data-offstyle="info"
           data-onlabel="مبلغ فاکتور"
           data-offlabel="تعرفه تعیین شده" name="calType" @if($user->calType != null) checked @endif>
      </div>
      {{-- end auto send --}}
    </div>
  </div>
</div>
{{-- end second section --}}



</div>


<div class="row bg-white pt-2 pb-3 mt-5">
  <h4 class="col-12 pt-2 pb-3">
  اطلاعات مکان
  </h4>

  {{-- شهر --}}
  <div class="col-sm-5  mt-5">
    <select class="cities col-12 bg-white" name="state">

      @foreach($cities as $city)
        <optgroup class="bg-info" label="{{$city->name}}">
            @foreach($city->states as $state)
              <option @if($state->id === $user->state_id) selected @endif value="{{$state->id}}">{{$state->name}}</option>
            @endforeach
        </optgroup>
      @endforeach

    </select>
  </div>
  {{--شهر --}}
  {{-- آدرس کامل --}}
  <div class="col-sm-5 px-5">
    <label for="address">آدرس کامل:</label>
    <textarea name="address" placeholder="آدرس را بصورت دقیق و کامل وارد کنید..." rows="8" cols="80">
      {!! $user->address !!}
    </textarea>
  </div>
  {{-- آدرس کامل --}}


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
    <input class="form-control bg-sec" type="text" placeholder="" name="username" value="{{$user->username}}" required>
  </div>
  {{-- نام کاربری--}}
  {{-- گذرواژه --}}
  <div class="col-sm-5 mt-5">
    <label for="phone-number">گذرواژه
      <span class="text-danger">*</span>
    </label>
    <input class="form-control bg-sec" type="password" placeholder="" name="password" value="" required>
  </div>
  {{--گذرواژه--}}
  {{--  وضعیت--}}
  <div class="col-sm-2 mt-5">
    <h6>
      وضعیت کاربر

    </h6>
    <input type="checkbox"
       data-toggle="switchbutton"
       data-onstyle="success"
       data-offstyle="danger"
       data-onlabel="فعال"
       data-offlabel="غیر فعال" name="status" @if($user->status != null) checked @endif>
  </div>
  {{-- وضعیت --}}

  <div class="col-12 text-center mt-5">
    <button class="btn btn-success col-2" type="submit" name="button">ویرایش کاربر</button>
  </div>
</div>


</form>
@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection

@section('scripts')
  <script src="{{asset('AdminPanel/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('AdminPanel/switch-button/bootstrap-switch-button.min.js')}}"></script>

  <script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
  $(document).ready(function() {
      $('.cities').select2();
  });
  </script>
@endsection
