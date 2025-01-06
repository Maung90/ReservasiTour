<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Dashboard')

@section('content') 

<div class="row">
  <div class="col-lg-12 mb-4 col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Report</h5>
        <small class="text-muted">Diperbaharui setiap bulan</small>
      </div>
      <div class="card-body ">
        <div class="row gy-3">
          <div class="col-md-1"></div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge bg-primary me-3 p-2">
                <i class="ti ti-chart-pie"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">{{$statistik['reservasi_count']}}</h5>
                <small>Sales</small>
              </div>
            </div>
          </div>

          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-danger me-3 p-2">
                <i class="ti ti-shopping-cart ti-sm"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  <?=  number_format(($statistik['nonpaid_count'] == null || $statistik['nonpaid_count'] <= 0 )? 0 : $statistik['nonpaid_count'], 0, ',', '.');?>
                </h5>
                <small>Non Paid</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-success me-3 p-2">
                <i class="ti ti-credit-card ti-sm"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  <?=  number_format(($statistik['paid_count'] == null || $statistik['paid_count'] <= 0 )? 0 : $statistik['paid_count'], 0, ',', '.');?>
                </h5>
                <small>Revenue</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-warning me-3 p-2">
                <i class="tf-icons ti ti-color-swatch"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  {{$statistik['totalProduct']}} 
                </h5>
                <small>Product</small>
              </div>
            </div>
          </div>
          <div class="col-md-2 col-6">
            <div class="d-flex align-items-center">
              <div class="badge  bg-info me-3 p-2">
                <i class="tf-icons ti ti-table-options"></i>
              </div>
              <div class="card-info">
                <h5 class="mb-0">
                  {{$statistik['totalProgram']}}
                </h5>
                <small>Program</small>
              </div>
            </div>
          </div>
          <div class="col-md-1"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header d-flex">
        <h5 class="card-title mb-0">Income</h5>
      </div>
      <div class="card-body">
        <div id="chart-line-gradient"></div>
        <div class="d-flex justify-content-between align-items-center mt-3 gap-3">
          <h4 class="mb-0">
            Rp.<?=  number_format(($statistik['paid_count'] == null || $statistik['paid_count'] <= 0 )? 0 : $statistik['paid_count'], 0, ',', '.');?>
          </h4>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body d-flex justify-content-between">
        <div class="d-flex flex-column">
          <div class="card-title mb-auto">
            <h5 class="mb-1 text-nowrap">Program</h5>
            <small>Monthly Report</small>
          </div>
          <div class="chart-statistics">
            <h3 class="card-title mb-1"> 
              {{$statistik['paket_count']}} 
            </h3>
          </div>
        </div>
        <div id="chart-pie-donut"></div>
      </div>
    </div>
  </div> 
</div>
@endsection

@section('js')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/apex-chart/apex.line.accounting.js') }}"></script>
<script src="{{ asset('assets/js/apex-chart/apex.pie.production.js') }}"></script>
@endsection 