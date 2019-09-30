@extends('Master.layout')

@section('title')
لیست نماینده
@endsection

@section('header')
  @include('Master.header')
@endsection

@section('sidebar')
  @include('Master.sidebar')
@endsection

@section('path')
  @include('Master.path')
@endsection

@section('content')

  <div class="row">
    <div class="card ">
                <div class="card-header">
                  <h3 class="card-title">لیست سفارشات در انتظار تحویل</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body " style="overflow-x:auto;">
                  <table  id="example2" class="table table-bordered table-striped ">
                    <thead>
                    <tr>
                      <th>تاریخ ثبت</th>
                      <th>تاریخ تخصیص</th>
                      <th>استان-شهر</th>
                      <th>آدرس</th>
                      <th>کدارسالی</th>
                      <th>نام خریدار</th>
                      <th>همراه-ثابت</th>
                      <th>نام کالا</th>
                      <th>جمع کل سفارش</th>
                      <th>پیش پرداخت</th>
                      <th>هزینه ارسال</th>
                      <th>تعداد اقلام سفارش</th>
                      <th>جمع تعداد کالا</th>
                      <th>تخفیف</th>
                      <th>نوع پرداخت</th>
                      <th>کالستنتر</th>
                      <th>توضیحات فروشنده</th>
                      <th>توضیحات ارسال</th>
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
                    <tfoot>
                    <tr>
                      <th>موتور رندر</th>
                      <th>مرورگر</th>
                      <th>سیستم عامل</th>
                      <th>ورژن</th>
                      <th>امتیاز</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
          </div>

          <from class="row">

            <div class="col-sm-6">
              <label for="status">
                تعیین وضعیت
                <span class="text-danger">*</span>
              </label>
              <select class="bg-light p-2 pb-2" name="status">
                <option value="">گزینه ای انتخاب نشده</option>
                <option value="">تحویل به مشتری(داخل شهری)</option>
                <option value="">تحویل به مشتری(بیرون شهری)</option>
                <option value="">تحویل به مشتری(روستا)</option>
                <option value="">معلق</option>
                <option value="">انصراف مشتری</option>
              </select>
              <button class="btn btn-success " type="button" name="button">
                ذخیره
              </button>

              <div class="mt-5 text-center">

              </div>


            </div>

            <div class="col-sm-6 text-center">

                <a class="btn btn-primary  col-4" href="#">چاپ</a>
                <a class="btn btn-info  col-4" href="#">اکسل</a>
                <a class="col-4 btn btn-danger mt-4" href="#">
                  برگشت به مدیر پیگیری
                </a>
            </div>
          </from>




@endsection

@section('footer')
  @include('Master.footer')
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
