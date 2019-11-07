@extends('Admin.Master.layout')

@section('title')
  افزودن کاربر
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
  @include('Admin.Master.path',['title'=>'نماینده ها'])
@endsection

@section('content')
<div class="card-body " style="overflow-x:auto;">
    <table  id="example2" class="table table-bordered table-striped ">
      <thead>
      <tr>
        <th>نام</th>
        <th>وضعیت</th>
        <th>ارسال خودکار</th>
        <th>استان</th>
        <th>نام کاربری</th>
        <th>مدیر نماینده</th>
        <th>تعرفه پیش فرض داخلی</th>
        <th>تعرفه پیش فرض حومه</th>
        <th>تعرفه پیش فرض روستا</th>
        <th>نوع محاسبه مشارکت</th>
        <th>عملیات</th>
      </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{$user->name.' '.$user->family}}</td>
          @if ($user->status != null)
            <td class="text-success">{{'فعال'}}</td>
          @else
            <td class="text-danger">{{'غیر فعال'}}</td>
          @endif
          @if ($user->reciveAuto != null)
            <td class="text-success">{{'فعال'}}</td>
          @else
            <td class="text-danger">{{'غیر فعال'}}</td>
          @endif
          <td>{{$user->state->name}}</td>
          <td>{{$user->username}}</td>
          @if($user->chief != null)
            <td class="text-primary">{{$user->chief->name.' '.$user->chief->family}}  </td>
          @elseif($user->role_id === 6)
            <td >{{'مدیر'}}  </td>
          @else
            <td >{{'بدون نماینده'}}  </td>
          @endif
          <td>{{$user->internalPrice}}</td>
          <td>{{$user->locallyPrice}}</td>
          <td>{{$user->villagePrice}}</td>
          @if ($user->calType != null)
            <td class="text-success">{{'فاکتور خرید'}}</td>
          @else
            <td class="text-primary">{{'تعرفه'}}</td>
          @endif
          <td>
            <a  class="text-success" data-toggle="modal" href="#types{{$user->id}}">
              <sub class="text-success">
                {{count($user->tariffs)}}
              </sub>
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
</div>
@endsection



{{-- delete user --}}
@foreach($users as $user)
<!-- The Modal -->
<div class="modal fade " id="types{{$user->id}}">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header ">

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center ">
        <table  class="table table-bordered table-striped bg-white pt-2 pb-2">
          <thead>
          <tr class="text-center">
            <th>محصول</th>
            <th>تعرفه داخلی</th>
            <th>تعرفه حومه</th>
            <th>تعرفه روستا</th>
            <th>عملیات</th>
          </tr>
          </thead>
          <tbody>


            @foreach($user->tariffs as $tariff)
              <tr class="text-center">
                @php
                  $product = 'App\Product'::find($tariff->product_id);
                @endphp
                <td>{{$product->name}}</td>
                <th>{{$tariff->internalPrice}}</th>
                <th>{{$tariff->locallyPrice}}</th>
                <th>{{$tariff->villagePrice}}</th>
                <td>
                  <a  class="text-warning " href="#">
                    <i class="far fa-edit crud-icon"></i>
                  </a>
                  <form  action="{{route('special-tariffs.destroy',$tariff->id)}}" method="post" >
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
        <form action="{{route('special-tariffs.store')}}" method="post">
          @csrf
          <div class=" mb-3">
            <div class="form-control bg-white col-sm-5 mx-auto">
              <select style="width:100%" class="users-product" name="product_id">
                @foreach($products as $product)
                  <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach

              </select>
            </div>
            <input type="text" class="form-control mt-2 col-sm-5 mx-auto" name="internalPrice" placeholder="تعرفه داخلی" required>
            <input type="text" class="form-control mt-2 col-sm-5 mx-auto" name="locallyPrice" placeholder="تعرفه حومه" required>
            <input type="text" class="form-control mt-2 col-sm-5 mx-auto" name="villagePrice" placeholder="تعرفه روستا" required>
            <input type="hidden" name="user_id" value="{{$user->id}}">

              <button type="submit" class="col-sm-4 mx-auto mt-3 btn btn-outline-success">
                  ثبت
              </button>

          </div>
        </form>

      </div>


    </div>
  </div>
</div>

</div>
@endforeach
{{-- delete user --}}





@section('footer')
  @include('Master.footer')
@endsection
@section('scripts')
  <script src="{{asset('AdminPanel/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('AdminPanel/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('AdminPanel/select2/select2.full.min.js')}}"></script>
  <script>
  $(function () {
    $("#example1").DataTable({
        "language": {
            "paginate": {
                "next": "بعدی",
                "previous" : "قبلی"
            }
        },
        "info" : false,
    });
    $('#example2').DataTable({
        "language": {
            "paginate": {
                "next": "بعدی",
                "previous" : "قبلی"
            }
        },
      "info" : true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "autoWidth": false
    });
  });
</script>

  <script type="text/javascript">
  // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
      $('.users-product').select2();
    });
  </script>
@endsection
