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
                <a class="btn btn-outline-success btn-sm mb-2" href="{{route('products.create')}}">
                  افزودن محصول
                </a>
                <table  id="example2" class="table table-bordered table-striped bg-white pt-2 pb-2">
                  <thead>
                  <tr class="text-center">
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>کد محصول</th>
                    <th>وضعیت</th>
                    <th>وضعیت پیامک</th>
                    <th>قیمت</th>
                    <th>قیمت خرید</th>
                    <th>عملیات</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($products as $product)
                    <tr class="text-center">
                      <td>
                        <img style="width:75px;" src="storage/{{$product->image}}" alt="">
                      </td>
                      <td>{{$product->name}}</td>
                      <td>{{$product->code}}</td>
                        @if($product->status != null)
                          <td class="text-success" >{{'فعال'}}</td>
                        @else
                          <td class="text-danger" >{{'غیر فعال'}}</td>
                        @endif
                        @if($product->messageStatus != null)
                          <td class="text-success" >{{'فعال'}}</td>
                        @else
                          <td class="text-danger" >{{'غیر فعال'}}</td>
                        @endif
                      <td>{{$product->price}}</td>
                      <td>{{$product->buyPrice}}</td>
                      <td>
                        <a  class="text-success" data-toggle="modal" href="#types{{$product->id}}">
                          <sub class="text-success">
                            {{count($product->types)}}
                          </sub>
                          <i class="fas fa-plus crud-icon"></i>
                        </a>
                        <a  class="text-warning " href="{{route('products.edit',$product->id)}}">
                          <i class="far fa-edit crud-icon"></i>
                        </a>
                        <a  class="text-danger" data-toggle="modal" href="#productDelete{{$product->id}}">
                          <i class="far fa-trash-alt crud-icon"></i>
                        </a>
                      </td>
                    </tr>
                @endforeach
                  </tbody>

                </table>


{{-- delete product --}}
@foreach($products as $product)
<!-- The Modal -->
<div class="modal fade " id="types{{$product->id}}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header ">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center ">
        <table  id="example2" class="table table-bordered table-striped bg-white pt-2 pb-2">
          <thead>
          <tr class="text-center">
            <th>نوع محصول</th>
            <th>عملیات</th>
          </tr>
          </thead>
          <tbody>
          @foreach($product->types as $type)
            <tr class="text-center">
              <td>{{$type->name}}</td>
              <td>
                <a  class="text-warning " href="#">
                  <i class="far fa-edit crud-icon"></i>
                </a>
                <form  action="{{route('types.destroy',$type->id)}}" method="post" >
                  @csrf
                  @method('delete')
                  <button class="btn btn-default text-danger btn-sm" type="submit" name="button">
                    <i class="far fa-trash-alt crud-icon"></i>
                  </button>
                </form>
              </td>
            </tr>
        @endforeach
          </tbody>

        </table>
        <form action="{{route('types.store')}}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="name" placeholder="نوع محصول را وارد کنید" required>
            <input type="hidden" name="product" value="{{$product->id}}">
            <div class="input-group-append">
              <button type="submit" class="input-group-text text-success">
                  <i class="far fa-plus-square crud-icon"></i>
              </button>
            </div>
          </div>
        </form>

      </div>


    </div>
  </div>
</div>

</div>
@endforeach
{{-- delete product --}}

{{-- ProductType --}}
@foreach($products as $product)
<!-- The Modal -->
<div class="modal fade " id="types{{$product->id}}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header ">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center ">
        <i class="fas fa-exclamation-triangle text-danger"></i>
          آیا از این بابت مطمئنید؟
        <form action="{{route('products.destroy',$product->id)}}" method="post">
          @csrf
          <div class="input-group mb-3 mx-auto">

            <div class="text-center">


            </div>
          </div>

      </div>
      <div class="card-footer text-center">
        <button type="submit" class="col-sm-3 btn btn-outline-danger">
            بله
        </button>
      </div>

      </form>
    </div>
  </div>
</div>

</div>
@endforeach
{{-- ProductType --}}

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
