@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Program')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Produk"/>

<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Produk</th>
      <th>Harga</th>
      <th>Area</th>
      <th>Tipe Produk</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable>
<!-- modal create Produk -->
<x-modal id="create-modal" labelId="createLabel" title="Add Produk" formId="create-produk" method="POST">
  <x-input id="nama_produk" type="text" name="nama_produk">Nama Produk</x-input>
  <x-input id="harga" type="number" name="harga">Harga</x-input>
  <x-input id="area" type="text" name="area">Area</x-input>
  <div class="form-group">
    <label for="tipe_produk">Tipe Produk</label>
    <select name="tipe_produk" id="tipe_produk" class="form-control">
      <option selected disabled>Pilih Tipe</option>
      <option value="transport">Transport</option>
      <option value="hotel">Hotel</option>
      <option value="restaurant">Restaurant</option>
      <option value="tourist_attraction">Tourist Attraction</option>
      <option value="etc">Etc</option>
    </select>
  </div>
  <div class="form-group">
    <label for="vendor">Vendor</label>
    <select name="vendor_id" id="vendor" class="form-control">
      @foreach($vendors as $vendor):
      <option value="{{$vendor->id}}">{{$vendor->nama_vendor}}</option>
      @endforeach
    </select>
  </div>
  <x-input id="deskripsi" type="text" name="deskripsi">Deskripsi</x-input>
</x-modal>
<!-- tutup modal create produk -->

<!-- modal update produk -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Produk" formId="edit-produk" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/> 
  <div id="form-edit">
    <x-input id="nama_produk_edit" type="text" name="nama_produk">Nama Produk</x-input>
    <x-input id="harga_edit" type="number" name="harga">Harga</x-input>
    <x-input id="area_edit" type="text" name="area">Area</x-input>
    <div class="form-group">
      <label for="tipe_produk_edit">Tipe Produk</label>
      <select name="tipe_produk" id="tipe_produk_edit" class="form-control">
        <option selected disabled>Pilih Tipe</option>
        <option value="transport">Transport</option>
        <option value="hotel">Hotel</option>
        <option value="restaurant">Restaurant</option>
        <option value="tourist_attraction">Tourist Attraction</option>
        <option value="etc">Etc</option>
      </select>
    </div>
    <div class="form-group">
      <label for="vendor_edit">Vendor</label>
      <select name="vendor_id" id="vendor_edit" class="form-control">
        @foreach($vendors as $vendor):
        <option value="{{$vendor->id}}">{{$vendor->nama_vendor}}</option>
        @endforeach
      </select>
    </div>
    <x-input id="deskripsi_edit" type="text" name="deskripsi">Deskripsi</x-input>
  </div>
</x-modal>
<!-- tutup modal update produk -->

<!-- modal info produk -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Produk" formId="info-produk" method="POST" :showSaveButton="false">
  <x-loading-spinner id="loading-info"/>
  <table class="table border" id="table-info">
    <thead>
      <tr><th>Nama guide</th><td id="nama_produk_info">-</td></tr>
      <tr><th>No Telp</th><td id="harga_info">-</td></tr>
      <tr><th>Bahasa</th><td id="area_info">-</td></tr>
      <tr><th>Tipe Produk</th><td id="tipe_produk_info">-</td></tr>
      <tr><th>Vendor</th><td id="vendor_info">-</td></tr>
      <tr><th>Deskripsi</th><td id="deskripsi_info">-</td></tr>
      <tr><th>Create By</th><td id="created_by_info">-</td></tr>
      <tr><th>Update By</th><td id="updated_by_info">-</td></tr>
    </thead>
  </table>
</x-modal>

<!-- tutup modal info produk -->

<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>

  $(document).ready(function () {
    initDataTable('#datatables', '{{ route('produk.tableProduk') }}', 
      [
        { data: 'no', name: 'no' },
        { data: 'nama_produk', name: 'nama_produk' },
        { 
          data: 'harga', 
          name: 'harga' ,  
          render: function(data, type, row) {
            return `Rp. ${parseInt(data).toLocaleString('id-ID')}`;
          }
        }, 
        { data: 'area', name: 'area' },
        { data: 'tipe_produk', name: 'tipe_produk' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
      );
  // modal edit 
    $(document).on('click', '.edit-btn', function() {
      let id = $(this).data('id');
      $('#edit-produk').data('id', id);

      $('#form-edit').addClass('d-none');
      $('#loading-modal-edit').removeClass('d-none');

      $.ajax({
        url: '{{ route("produk.get", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function(response) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');

          let data = response;
          $('#nama_produk_edit').val(data.nama_produk);
          $('#harga_edit').val(data.harga);
          $('#area_edit').val(data.area);
          $('#tipe_produk_edit').val(data.tipe_produk);
          $('#deskripsi_edit').val(data.deskripsi);
          $('#vendor_edit').val(data.vendor_id);
          

          $('#edit-modal').modal('show');
        },
        error: function(xhr, status, error) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');
          console.error("Error fetching data:", error);
        }
      });
    });

// modal info
    $(document).on('click', '.info-btn', function() {
      let id = $(this).data('id');

      $('#table-info').addClass('d-none');
      $('#loading-info').removeClass('d-none');

      $.ajax({
        url: '{{ route("produk.get", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function(response) {
          let data = response;

          $('#nama_produk_info').text(data.nama_produk);
          $('#harga_info').text(data.harga);
          $('#area_info').text(data.area);
          $('#tipe_produk_info').text(data.tipe_produk);
          $('#vendor_info').text(data.vendor['nama_vendor']);
          $('#deskripsi_info').text(data.deskripsi);
          $('#created_by_info').text(data.creator['nama']);
          $('#updated_by_info').text(data.updator['nama']);

          $('#loading-info').addClass('d-none');
          $('#table-info').removeClass('d-none');

          $('#info-modal').modal('show');
        },
        error: function(xhr, status, error) {
          $('#loading-info').addClass('d-none');
          $('#table-info').removeClass('d-none');
          console.error("Error fetching data:", error);
        }
      });
    });


    setupFormSubmit('#create-produk', '{{ route("produk.store") }}', '#datatables', 'Produk created successfully!', true, '#create-modal');

    setupFormSubmit('#edit-produk', '{{ route("produk.update", ":id") }}', '#datatables', 'Produk updated successfully!',false, '#edit-modal');

    setupDeleteButton('.delete-btn', '{{ route("produk.destroy", ":id") }}', '#datatables');

  });

</script>

@endsection