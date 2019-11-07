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
  @include('Admin.Master.path',['title'=>'شهرهای ایران'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-6 mx-auto">
      <form action="{{route('cities.store')}}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="نام شهر را وارد کنید" required>
          <div class="input-group-append">
            <a class="input-group-text text-success">
                <i class="far fa-plus-square crud-icon"></i>
            </a>
          </div>
        </div>
      </form>
      <table  id="example2" class="table table-bordered table-striped  bg-white pt-2 pb-2">
        <thead>
        <tr>
          <th class="text-center">نام شهر</th>
          <th class="text-center">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
          <tr>
            <td class="text-center">{{$city->name}}</td>
            <td class="text-center">
              {{-- edit --}}
              <a  class="text-warning" data-toggle="modal" href="#city{{$city->id}}">
                <i class="far fa-edit crud-icon"></i>
              </a>
              {{-- delete --}}
              <a class="text-danger"  href="{{route('cities.destroy',$city->id)}}">
                  <i class="far fa-trash-alt crud-icon"></i>
              </a>

            </td>
          </tr>
      @endforeach
        </tbody>

      </table>
      <ul class="mx-auto">
        {!! $cities->render() !!}
      </ul>
    </div>

  </div>


  @foreach($cities as $city)
  <!-- The Modal -->
  <div class="modal fade" id="city{{$city->id}}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <form action="{{route('cities.update',$city->id)}}" method="post">
            @csrf
            @method('put')
            <div class="input-group mb-3">
              <input type="text" value="{{$city->name}}" class="form-control" name="name" placeholder="نام شهر را وارد کنید" required>
              <div class="input-group-append">
                <button class="input-group-text ">
                    <i class="far fa-arrow-alt-circle-up crud-icon text-success"></i>
                </button>
              </div>
            </div>
          </form>


        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
            بستن
          </button>
        </div>

      </div>
    </div>
  </div>

</div>
@endforeach


@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
