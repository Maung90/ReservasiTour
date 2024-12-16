@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Kendaraan')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Kendaraan"/>
<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Jenis Kendaraan</th>
      <th>No Kendaraan</th>
      <th>kapasitas</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable> 

<!-- modal create Kendaraan --> 
<x-modal id="create-modal" labelId="createLabel" title="Add Kendaraan" formId="create-kendaraan" method="POST">
 <x-input id="jenis_kendaraan" type="text" name="jenis_kendaraan">Jenis Kendaraan</x-input>
 <x-input id="nomor_kendaraan" type="text" name="nomor_kendaraan">No Kendaraan</x-input>
 <x-input id="kapasitas" type="number" name="kapasitas">Kapasitas</x-input>
 <div class="form-group">
  <label for="status">Status</label>
  <select name="status" id="status" class="form-control" required>
    <option selected disabled> Pilih Status</option>
    <option value="available"> Available </option>
    <option value="unavailable"> Unavailable </option>
  </select>
</div>
</x-modal>
<!-- tutup modal create kendaraan -->

<!-- modal update kendaraan -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Kendaraan" formId="edit-kendaraan" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
   <x-input id="jenis_kendaraan_edit" type="text" name="jenis_kendaraan">Jenis Kendaraan</x-input>
   <x-input id="nomor_kendaraan_edit" type="text" name="nomor_kendaraan">No Kendaraan</x-input>
   <x-input id="kapasitas_edit" type="number" name="kapasitas">Kapasitas</x-input>
   <div class="form-group">
    <label for="status_edit">Status</label>
    <select name="status" id="status_edit" class="form-control" required>
      <option selected disabled> Pilih Status</option>
      <option value="available"> Available </option>
      <option value="unavailable"> Unavailable </option>
    </select>
  </div>
</div>
</x-modal>
<!-- tutup modal update kendaraan -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>

  $(document).ready(function () {
    initDataTable('#datatables', '{{ route('kendaraan.tableKendaraan') }}', 
      [
        { data: 'no', name: 'no' },
        { data: 'jenis_kendaraan', name: 'jenis_kendaraan' },
        { data: 'nomor_kendaraan', name: 'nomor_kendaraan' },
        { data: 'kapasitas', name: 'kapasitas' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
      );
    
    $(document).on('click', '.edit-btn', function() {
      let id = $(this).data('id');
      $('#edit-kendaraan').data('id', id);

      $('#form-edit').addClass('d-none');
      $('#loading-modal-edit').removeClass('d-none');

      $.ajax({
        url: '{{ route("kendaraan.get", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function(response) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');

          let data = response;
          $('#jenis_kendaraan_edit').val(data.jenis_kendaraan);
          $('#nomor_kendaraan_edit').val(data.nomor_kendaraan);
          $('#kapasitas_edit').val(data.kapasitas);
          $('#status_edit').val(data.status);

          $('#edit-modal').modal('show');
        },
        error: function(xhr, status, error) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');
          console.error("Error fetching data:", error);
        }
      });
    });


    setupFormSubmit('#create-kendaraan', '{{ route("kendaraan.store") }}', '#datatables', 'Kendaraan created successfully!', true, '#create-modal');

    setupFormSubmit('#edit-kendaraan', '{{ route("kendaraan.update", ":id") }}', '#datatables', 'Kendaraan updated successfully!',false, '#edit-modal');

    setupDeleteButton('.delete-btn', '{{ route("kendaraan.destroy", ":id") }}', '#datatables');

  });

</script>

@endsection