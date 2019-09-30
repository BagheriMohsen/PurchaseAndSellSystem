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
  @include('Admin.Master.path',['title'=>'سطوح دسترسی'])
@endsection

@section('content')
                {{-- <a class="btn btn-info mb-4" href="{{route('roles.create')}}">
                  دسترسی جدید
                </a> --}}
                <table  id="example2" class="table table-bordered table-striped bg-white pt-2 pb-2">
                  <thead>
                  <tr>
                    <th>نام</th>
                    <th>نامک</th>
                    <th>عملیات</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($roles as $role)
                    <tr>
                      <td>{{$role->name}}</td>
                      <td>{{$role->role}}</td>

                      <td>
                        <a class="text-warning" href="{{route('roles.edit',$role->id)}}">
                          <i class="far fa-edit crud-icon"></i>
                        </a>
                        {{-- <a class="btn btn-danger" href="{{route('roles.destroy',$role->id)}}">حذف</a> --}}
                      </td>
                    </tr>
                @endforeach
                  </tbody>

                </table>


@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
