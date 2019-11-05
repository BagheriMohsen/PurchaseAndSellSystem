@extends('Admin.Master.layout')

@section('title')
  نماینده ها
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



          <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
            <li class="nav-item">
              <a class="nav-link active bg-light" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just"
                aria-selected="true">نماینده های فعال</a>
            </li>
            <li class="nav-item">
              <a class="nav-link bg-light" id="profile-tab-just" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just"
                aria-selected="false">نماینده های غیر فعال</a>
            </li>

          </ul>
          <div class="tab-content card pt-5" id="myTabContentJust">
            <div class="tab-pane fade show active" id="home-just" role="tabpanel" aria-labelledby="home-tab-just">
              <table  id="example2" class="table table-bordered table-striped ">
                <thead>
                <tr>
                  <th>نام</th>
                  <th>ارسال خودکار</th>
                  <th>استان-شهر</th>
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
                <tr>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                </tbody>

              </table>
            </div>
            <div  class="tab-pane fade" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-just">
              <table  id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                  <th>نام</th>
                  <th>ارسال خودکار</th>
                  <th>استان-شهر</th>
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
                <tr>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                </tbody>

              </table>
            </div>

          </div>

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
@section('scripts')
  <script src="{{asset('AdminPanel/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('AdminPanel/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
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
@endsection
