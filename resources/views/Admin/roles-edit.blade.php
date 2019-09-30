@extends('Admin.Master.layout')

@section('title')
  ویرایش دسترسی
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'ویرایش دسترسی'])
@endsection

@section('content')

<form class="bg-white pt-2 pb-2" action="{{route('roles.update',$role->id)}}"  class="row" method="post">
  @csrf
  @method('PUT')
  <div class="col-sm-4">
    <label for="name">نام دسترسی:</label>
    <br />
    <input class="col-12" type="text" name="name" value="{{$role->name}}" required>
  </div>
  <div class="col-sm-4">
    <label for="">نامک:</label>
    <br />
    <input class="col-12" type="text" name="role" value="{{$role->role}}" disabled required>
  </div>
  <div class="col-sm-12 mt-5">
    <button class="btn btn-success" type="submit" name="button">
      ذخیره
    </button>
  </div>
</form>

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
