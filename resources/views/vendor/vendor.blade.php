@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Vendor')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Vendor"/>
<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Vendor</th>
      <th>Contact</th>
      <th>Bank</th>
      <th>Periode Validasi</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable> 

<!-- modal create vendor -->
<x-modal id="create-modal" labelId="createLabel" title="Add Vendor" formId="create-vendor" method="POST">
  <x-input id="nama_vendor" type="text" name="nama_vendor">Nama Vendor</x-input>
  <x-input id="contact" type="text" name="contact">Contact</x-input>
  <x-input id="bank" type="text" name="bank">Bank</x-input>
  <x-input id="no_rekening" type="number" name="no_rekening">No Rekening</x-input>
  <x-input id="account_name" type="text" name="account_name">Nama Akun</x-input>
  <x-input id="validity_period" type="date" name="validity_period">Periode Validasi</x-input> 
</x-modal>
<!-- tutup modal create vendor -->


<!-- modal info vendor -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Vendor" formId="info-vendor" method="POST" :showSaveButton="false">
  <x-loading-spinner id="loading-info"/>
  <table class="table border" id="table-info">
    <thead>
     <tr><th>Nama Vendor</th><td id="name_vendor-info">-</td></tr>
     <tr><th>Contact</th><td id="contact-info">-</td></tr>
     <tr><th>Bank</th><td id="bank-info">-</td></tr>
     <tr><th>No Rekening</th><td id="no_rekening-info">-</td></tr>
     <tr><th>Nama AKun</th><td id="account_name-info">-</td></tr>
     <tr><th>Periode Validasi</th><td id="validity_period-info">-</td></tr>
     <tr><th>Waktu Dibuat</th><td id="created-at-info">-</td></tr>
   </thead>
 </table>
</x-modal>
<!-- tutup modal info vendor -->

<!-- modal update vendor -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Vendor" formId="edit-vendor" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <x-input id="nama_vendor_update" type="text" name="nama_vendor">Nama Vendor</x-input>
    <x-input id="contact_update" type="text" name="contact">Contact</x-input>
    <x-input id="bank_update" type="text" name="bank">Bank</x-input>
    <x-input id="no_rekening_update" type="number" name="no_rekening">No Rekening</x-input>
    <x-input id="account_name_update" type="text" name="account_name">Nama Akun</x-input>
    <x-input id="validity_period_update" type="date" name="validity_period">Periode Validasi</x-input>
  </div>
</x-modal>
<!-- tutup modal update vendor -->
<x-loading-spinner id="loading-spinner"/>
@endsection


@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  initDataTable('#datatables', '{{ route('Vendor.tableVendor') }}', 
    [
     { data: 'no', name: 'no' },
     { data: 'nama_vendor', name: 'nama_vendor' },
     { data: 'contact', name: 'contact' },
     { data: 'bank', name: 'bank' },
     { data: 'validity_period', name: 'validity_period' },
     { data: 'action', name: 'action', orderable: false, searchable: false },
     ]
    );

  // modal info
  $(document).on('click', '.info-btn', function() {
    let id = $(this).data('id');

    $('#table-info').addClass('d-none');
    $('#loading-info').removeClass('d-none');

    $.ajax({
      url: '{{ route("vendor.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        let data = response;

        if (data.created_at) {
          const date = new Date(data.created_at);
          const formattedDate = new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
          }).format(date);

          $('#created-at-info').text(formattedDate);
        }

        $('#name_vendor-info').text(data.nama_vendor);
        $('#contact-info').text(data.contact);
        $('#bank-info').text(data.bank);
        $('#validity_period-info').text(data.validity_period);
        $('#account_name-info').text(data.account_name);
        $('#no_rekening-info').text(data.no_rekening);

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

  // modal edit 
  $(document).on('click', '.edit-btn', function() {
    let id = $(this).data('id');
    $('#edit-vendor').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    $.ajax({
      url: '{{ route("vendor.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');

        let data = response;
        $('#nama_vendor_update').val(data.nama_vendor);
        $('#contact_update').val(data.contact);
        $('#bank_update').val(data.bank);
        $('#validity_period_update').val(data.validity_period);
        $('#account_name_update').val(data.account_name);
        $('#no_rekening_update').val(data.no_rekening);

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });

  setupFormSubmit('#create-vendor', '{{ route("vendor.store") }}', '#datatables', 'Vendor created successfully!', true, '#create-modal');

  setupFormSubmit('#edit-vendor', '{{ route("vendor.update", ":id") }}', '#datatables', 'Vendor updated successfully!',false, '#edit-modal');

  setupDeleteButton('.delete-btn', '{{ route("vendor.destroy", ":id") }}', '#datatables');

</script>

@endsection