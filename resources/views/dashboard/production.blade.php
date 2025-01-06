<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Dashboard')

@section('content') 
{{-- @dump(); --}}
<div class="row">
  <div class="col-lg-12 mb-4 col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h5 class="card-title mb-0">Report</h5>
        <small class="text-muted">Diperbaharui setiap bulan</small>
      </div>
      <div class="card-body ">
        <div class="row gy-3">
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
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 row">
    <div class="col-2"></div>
    <div class="col-lg-8 col-md-6">
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
    <div class="col-2"></div>
    {{-- <div class="col-lg-6 col-md-6">
      <div class="card">
        <div class="card-body d-flex justify-content-between">
          <div class="d-flex flex-column">
            <div class="card-title mb-auto">
              <h5 class="mb-1 text-nowrap">Product</h5>
              <small>Monthly Report</small>
            </div>
            <div class="chart-statistics">
              <h3 class="card-title mb-1">
                009
              </h3>
            </div>
          </div>
          <div id="chart-pie-donut2"></div>
        </div>
      </div>
    </div>  --}}
  </div> 
</div>
@endsection

@section('js')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/apex-chart/apex.line.init.js') }}"></script> --}}
<script src="{{ asset('assets/js/apex-chart/apex.pie.production.js') }}"></script>
@endsection 