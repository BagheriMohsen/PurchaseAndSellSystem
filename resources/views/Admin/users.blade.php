@extends('Admin.Master.layout')

@section('title')
  کاربران
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'تمام کاربران'])
@endsection

@section('content')

                <table  id="example2" class="table table-bordered table-striped bg-white pt-2 pb-2">
                  <thead>
                  <tr>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>نقش</th>
                    <th>شهر-استان</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                    <tr>
                      <td>{{$user->name}}</td>
                      <td>{{$user->family}}</td>
                      <td>{{$user->role->name}}</td>
                      <td>{{$user->city_id.'-'.$user->state_id}}</td>
                      <td>{{$user->status}}</td>
                      <td >
                        <a  class="text-warning " href="#">
                          <i class="far fa-edit crud-icon"></i>
                        </a>
                        {{-- <a class="btn btn-warning" href="{{route('roles.edit',$city->id)}}">ویرایش</a> --}}
                        <a class="text-danger " href="#">
                            <i class="far fa-trash-alt crud-icon"></i>
                        </a>
                      </td>
                    </tr>
                @endforeach
                  </tbody>

                </table>


@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
