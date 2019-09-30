@extends('Master.layout')

@section('title')
  داشبورد نماینده
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
            <div class="col-12 col-sm-6 col-md-4">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa fa-gear"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">سفارشات در انتظار تحویل</span>
                  <span class="info-box-number">
                    10
                    <small>%</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-4 ">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-google-plus"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">سفارشات معلق</span>
                  <span class="info-box-number">2</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-4 ">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">سفارشات تحویل داده شده</span>
                  <span class="info-box-number">5</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-4 ">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">سفارشات برگشت خورده</span>
                  <span class="info-box-number">6</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-4 ">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">سطح</span>
                  <span class="info-box-number">A</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-4 ">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">درصد وصول</span>
                  <span class="info-box-number">60%</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>


          <div class="row mt-5 mb-5">
            {{-- item --}}
            <div class="col-sm-6 mx-auto">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="bg-primary text-center">صورت حساب جاری شما</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                      مجموع فروش
                      </div>
                      <div class="col-2 mx-auto">
                          1,500,000
                      </div>
                  </td>
                </tr>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                        مجموع پیش واریزی
                      </div>
                      <div class="col-2 mx-auto">
                          500,000
                      </div>
                  </td>
                </tr>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                        هزینه حمل
                      </div>
                      <div class="col-2 mx-auto">
                          50,000
                      </div>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>
            {{-- end item --}}
            {{-- item --}}
            <div class="col-sm-6  mx-auto">
              <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th class="bg-warning text-center">مبلغ بدهی شما</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                      تخفیف
                      </div>
                      <div class="col-2 mx-auto">
                          100,000
                      </div>
                  </td>
                </tr>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                        جایزه
                      </div>
                      <div class="col-2 mx-auto">
                          5
                      </div>
                  </td>
                </tr>
                <tr>
                  <td class="row">
                      <div class="col-10 mx-auto">
                        امتیاز
                      </div>
                      <div class="col-2 mx-auto">
                          5
                      </div>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>
            {{-- end item --}}

          </div>


          {{-- chart --}}
          <div class="row text-center d-block mt-5">
            <h4 >نمودار وضعیت سفارش ها در 30 روز گذشته</h4>
            <hr width="300px" style="border-bottom:5px solid red;" />
          {{-- chart --}}
            <div class="card mt-3">
              <div class="card-header no-border">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">وضعیت سفارش ها</h3>
                  {{-- <a href="javascript:void(0);">مشاهده گزارش</a> --}}
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">

                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="visitors-chart" height="200"></canvas>
                </div>
                  <div class="text-right mb-2">
                    <strong>
                      راهنمای نمودار:
                    </strong>
                  </div>
                <div class="d-flex flex-row justify-content-start">
                  <span class="ml-2">
                    <i class="fa fa-square text-info"></i> سفارشات وصولی
                  </span>
                  <span class="ml-2">
                    <i class="fa fa-square text-danger"></i> سفارشات کنسلی
                  </span>
                  <span class="ml-2">
                    <i class="fa fa-square text-warning"></i> سفارشات در انتظار و معلق
                  </span>

                </div>
              </div>
            </div>
            <!-- /.chart -->
          </div>
          {{-- end chart --}}

@endsection

@section('footer')
  @include('Master.footer')
@endsection
