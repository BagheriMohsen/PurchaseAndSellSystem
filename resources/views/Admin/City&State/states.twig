@extends('Admin.Master.layout')

@section('title')
  داشبورد
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
  @include('Admin.Master.path',['title'=>'استانهای ایران'])
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-10 mx-auto">
      <form class="mx-auto" action="{{route('states.store')}}" method="post">
        @csrf
        <div class="input-group mb-3 col-sm-10">
          <input type="text" class="form-control" name="name" placeholder="استان مورد نظر را وارد کنید" required>

          <div class="input-group-append  col-sm-4 form-control">
            <select class="form-control  bg-white cities-name col-sm-12" name="city">
              @foreach($cities as $city)
              <option value="{{$city->id}}">{{$city->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="input-group-append">
            <button class="input-group-text text-success">
                <i class="far fa-plus-square crud-icon"></i>
            </button>
          </div>


        </div>
      </form>
      <table  id="example2" class="table table-bordered table-striped  bg-white pt-2 pb-2">
        <thead>
        <tr>
          <th class="text-center">شهر</th>
          <th class="text-center">استان</th>
          <th class="text-center">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($states as $state)
          <tr>
            <td class="text-center">{{$state->name}}</td>
            <td class="text-center">{{$state->city->name}}</td>
            <td class="text-center">
              {{-- edit --}}
              <a  class="text-warning" data-toggle="modal" href="#state{{$state->id}}">
                <i class="far fa-edit crud-icon"></i>
              </a>
              <a  class="text-danger" data-toggle="modal" href="#stateDelete{{$state->id}}">
                <i class="far fa-trash-alt crud-icon"></i>
              </a>
            </td>
          </tr>
      @endforeach
        </tbody>

      </table>
      <ul class="mx-auto col-sm-2">
        {!! $states->render() !!}
      </ul>
    </div>

  </div>

{{-- edit modal --}}
  @foreach($states as $state)
  <!-- The Modal -->
  <div class="modal fade" id="state{{$state->id}}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <form action="{{route('states.update',$state->id)}}" method="post">
            @csrf
            @method('put')
            <div class="input-group mb-3">
              <input type="text" value="{{$state->name}}" class="form-control" name="name" placeholder="نام شهر را وارد کنید" required>
                <div class="input-group-append  col-sm-12 form-control">
                    <select style="width:100%;" class="form-control  bg-white cities-name " name="city">
                        <option value="{{$state->city->id}}">{{$state->city->name}}</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
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
{{-- end edit modal --}}
@foreach($states as $state)
<!-- The Modal -->
<div class="modal fade " id="stateDelete{{$state->id}}">
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
        <form action="{{route('states.destroy',$state->id)}}" method="post">
          @csrf
          @method('delete')
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

{{-- delete modal --}}



{{-- end delete modal --}}

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection

@section('scripts')
  <script src="{{asset('AdminPanel/select2/select2.full.min.js')}}"></script>
  <script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
      $('.cities-name').select2();
    });
  </script>
@endsection
