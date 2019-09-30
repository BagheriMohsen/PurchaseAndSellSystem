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
  @include('Admin.Master.path',['title'=>'داشبورد'])
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <strong>سفارشات ثبت شده کال سنتر</strong>
        <div class="mt-3 pt-2 pb-2">
          <p>
            ماه جاری:
            20
          </p>
          <p>
            امروز:
            2
          </p>
        </div>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>

    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <strong>سفارشات در انتظار تحویل</strong>
        <div class="mt-3 pt-2 pb-2">
          <p>
            ماه جاری:
            20
          </p>
          <p>
            امروز:
            2
          </p>
        </div>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>

    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <strong>سفارشات تحویل داده شده</strong>
        <div class="mt-3 pt-2 pb-2">
          <p>
            ماه جاری:
            20
          </p>
          <p>
            امروز:
            2
          </p>
        </div>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6 ">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <strong>سفارشات برگشت خورده</strong>
        <div class="mt-3 pt-2 pb-2">
          <p>
            ماه جاری:
            20
          </p>
          <p>
            امروز:
            2
          </p>
        </div>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>

    </div>
  </div>
  <!-- ./col -->
</div>
<!-- /.row -->
<div class="row mt-5 mb-5">
  {{-- item --}}
  <div class="col-sm-3">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="bg-info">کالاهای تحویل داده شده امروز</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
            </div>
            <div class="col-2 mx-auto">
                5
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
            </div>
            <div class="col-2 mx-auto">
                5
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
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
  {{-- item --}}
  <div class="col-sm-3 ">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="bg-info">پرفروش ترینها</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
            </div>
            <div class="col-2 mx-auto">
                5
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
            </div>
            <div class="col-2 mx-auto">
                5
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-10 mx-auto">
              شامپو
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
  {{-- item --}}
  <div class="col-sm-3">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="bg-info">لیست بدهکاران</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="row">
            <div class="col-9 mx-auto">
              نماینده تهران
            </div>
            <div class="col-3 mx-auto">
                220,500
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-9 mx-auto">
              نماینده تهران
            </div>
            <div class="col-3 mx-auto">
                220,500
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-9 mx-auto">
              نماینده تهران
            </div>
            <div class="col-3 mx-auto">
                220,500
            </div>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  {{-- end item --}}
  {{-- item --}}
  <div class="col-sm-3">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="bg-info">پیامک های دریافتی امروز</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="row">
            <div class="col-7 mx-auto">
              فروشنده تهران
            </div>
            <div class="col-5 mx-auto">
                سوم شهریور
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-7 mx-auto">
              فروشنده تهران
            </div>
            <div class="col-5 mx-auto">
                سوم شهریور
            </div>
        </td>
      </tr>
      <tr>
        <td class="row">
            <div class="col-7 mx-auto">
              فروشنده تهران
            </div>
            <div class="col-5 mx-auto">
                سوم شهریور
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
          <i class="fa fa-square text-success"></i> سفارشات ثبت شده
        </span>
        <span>
          <i class="fa fa-square text-warning"></i> پیام های دریافتی
        </span>
      </div>
    </div>
  </div>
  <!-- /.chart -->
</div>
{{-- end chart --}}

@endsection

@section('footer')
  @include('Admin.Master.footer')
@endsection
