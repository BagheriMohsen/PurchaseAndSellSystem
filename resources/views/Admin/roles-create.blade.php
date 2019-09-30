@extends('Admin.Master.layout')

@section('title')
  داشبورد
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'سطوح دسترسی'])
@endsection

@section('content')

<form class="bg-white pt-2 pb-2" action="{{route('roles.store')}}" method="post" class="row">
  @csrf
  <div class="col-sm-4">
    <label for="name">نام دسترسی:</label>
    <br />
    <input class="col-12" type="text" name="name" value="" required>
  </div>
  <div class="col-sm-4">
    <label for="">نامک:</label>
    <br />
    <input class="col-12" type="text" name="role" value="" required>
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
