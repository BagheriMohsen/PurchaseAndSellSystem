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
                  <tr class="text-center">
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>نقش</th>
                    <th>شهر-استان</th>
                    <th >وضعیت</th>
                    <th >عملیات</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                    <tr class="text-center">
                      <td>{{$user->name}}</td>
                      <td>{{$user->family}}</td>
                      <td>{{$user->role->name}}</td>
                      <td>{{$user->state->name}}</td>
                      @if($user->status != null)
                      <td class="text-success">  {{'فعال'}} </td>
                      @else
                      <td class="text-danger ">   {{'غیر فعال'}} </td>
                      @endif
                      <td class="text-center">
                        <a  class="text-success " href="#">
                          <i class="fas fa-plus crud-icon"></i>
                        </a>
                        <a  class="text-warning " href="{{route('users.edit',$user->id)}}">
                          <i class="far fa-edit crud-icon"></i>
                        </a>
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
