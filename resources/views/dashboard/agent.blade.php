<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Dashboard')

@section('content') 

{{-- @php dump($statistik); @endphp --}}
<div class="row">
  <div class="col-lg-12 mb-4 col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Report</h5>
        <small class="text-muted">Diperbaharui setiap bulan</small>
      </div>
      <div class="card-body ">
        <div class="row gy-3">
          <div class="col-md-1 col-6">
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge bg-primary me-3 p-2">
                <i class="ti ti-chart-pie"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{$statistik['reservasi_count']}}</h5>
                <small>Reservasi</small>
              </div>
            </div>
          </div>

          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-warning me-3 p-2">
                <i class="ti ti-shopping-cart ti-sm"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  {{$statistik['paket_count']}}
                </h5>
                <small>Paket</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-secondary me-3 p-2">
                <i class="ti ti-shopping-cart ti-sm"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  {{$statistik['custom_count']}}
                </h5>
                <small>Custom</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-success me-3 p-2">
                <i class="ti ti-currency-dollar ti-sm"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  <?=  number_format(($statistik['paid_count'] == null || $statistik['paid_count'] <= 0 )? 0 : $statistik['paid_count'], 0, ',', '.');?>
                </h5>
                <small>Paid</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge bg-danger me-3 p-2">
                <i class="tf-icons ti ti-currency-dollar"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  <?=  number_format(($statistik['nonpaid_count'] == null || $statistik['nonpaid_count'] <= 0 )? 0 : $statistik['nonpaid_count'], 0, ',', '.');?>
                </h5>
                <small>Unpaid</small>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-6">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 mb-4 col-md-12 row">
    <div class="col-3">
      <div class="card w-100">
        <div class="card-body">
          <h5 class="card-title fw-semibold">Weekly Stats</h5>
          <p class="card-subtitle mb-0">Average sales</p>
          <div id="stats" class="my-4"></div>
          <div class="position-relative">
            <div class="d-flex align-items-center justify-content-between mb-7">
              <div class="d-flex">
                <div class="p-6 bg-light rounded me-6 d-flex align-items-center justify-content-center">
                  <i class="ti ti-grid-dots fs-6"></i>
                </div>
                <div>
                  <p class="fs-3 mb-0 fw-normal">Profit</p>
                  <div class="bg-light-primary badge">
                    <p class="fs-3 text-primary fw-semibold mb-0">{{$statistik['persentasePerWeek']}}%</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-9 d-flex align-items-strech">
      <div class="card w-100">
        <div class="card-body">
          <div>
            <h5 class="card-title fw-semibold mb-1">Yearly Statistic</h5>
            <p class="card-subtitle mb-0">Every month</p>
            <div id="salary" class="mb-7 pb-8"></div>
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
              </div>
              <div class="d-flex align-items-center">
                <div class="bg-light rounded me-8 p-8 d-flex align-items-center justify-content-center">
                  <i class="ti ti-grid-dots text-muted fs-6"></i>
                </div>
                <div>
                  <p class="fs-3 mb-0 fw-normal">Profit</p>
                  <h6 class="fw-semibold text-dark fs-4 mb-0">{{$statistik['persentasePerYears']}}%</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('js')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboardAgent.js') }}"></script>
{{-- 
<script src="{{ asset('assets/js/apex-chart/apex.line.init.js') }}"></script>
<script src="{{ asset('assets/js/apex-chart/apex.pie.init.js') }}"></script> --}}
@endsection 