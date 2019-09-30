@extends('Admin.Master.layout')

@section('title')
  محصولات
@endsection

@section('header')
  @include('Admin.Master.header')
@endsection

@section('sidebar')
  @include('Admin.Master.sidebar')
@endsection

@section('path')
  @include('Admin.Master.path',['title'=>'محصولات'])
@endsection

@section('content')

                <table  id="example2" class="table table-bordered table-striped bg-white pt-2 pb-2">
                  <thead>
                  <tr>
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>کد محصول</th>
                    <th>وضعیت</th>
                    <th>قیمت</th>
                    <th>قیمت خرید</th>
                    <th>عملیات</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($products as $product)
                    <tr>
                      <td>{{$product->image}}</td>
                      <td>{{$product->name}}</td>
                      <td>{{$product->code}}</td>
                      <td>{{$product->status}}</td>
                      <td>{{$product->price}}</td>
                      <td>{{$product->buyPrice}}</td>
                      <td>
                        <a class="btn btn-warning" href="#">ویرایش</a>
                        <a class="btn btn-danger" href="#">حذف</a>
                      </td>
                    </tr>
                @endforeach
                  </tbody>

                </table>


@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
