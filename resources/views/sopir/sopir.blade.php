@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Sopir')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Sopir"/>
<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Sopir</th>
      <th>No Telp</th>
      <th>Status</th>
      @if(auth()->user()->role_id != 3 ):
      <th>Aksi</th>
      @endif
    </tr>
  </thead>
</x-datatable> 

<!-- modal create Sopir -->
<x-modal id="create-modal" labelId="createLabel" title="Add Sopir" formId="create-sopir" method="POST">
  <x-input id="nama_sopir" type="text" name="nama_sopir">Nama Sopir</x-input>
  <x-input id="no_telp" type="text" name="no_telp">No Telp</x-input>
  <div class="form-group">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control" required>
      <option selected disabled> Pilih Status</option>
      <option value="available"> Available </option>
      <option value="unavailable"> Unavailable </option>
    </select>
  </div>
</x-modal>
<!-- tutup modal create sopir -->

<!-- modal update sopir -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Sopir" formId="edit-sopir" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <x-input id="nama_sopir_edit" type="text" name="nama_sopir">Nama Sopir</x-input>
    <x-input id="no_telp_edit" type="text" name="no_telp">No Telp</x-input>
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
<!-- tutup modal update sopir -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>

  $(document).ready(function () {
    var userRoleId = {{ auth()->user()->role_id }};
    initDataTable('#datatables', '{{ route('sopir.tableSopir') }}', 
      [
        { data: 'no', name: 'no' },
        { data: 'nama_sopir', name: 'nama_sopir' },
        { data: 'no_telp', name: 'no_telp' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false,  visible: userRoleId !== 3 },
        ]
      );

  // modal edit 
    $(document).on('click', '.edit-btn', function() {
      let id = $(this).data('id');
      $('#edit-sopir').data('id', id);

      $('#form-edit').addClass('d-none');
      $('#loading-modal-edit').removeClass('d-none');

      $.ajax({
        url: '{{ route("sopir.get", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function(response) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');

          let data = response;
          $('#nama_sopir_edit').val(data.nama_sopir);
          $('#no_telp_edit').val(data.no_telp);
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

    setupFormSubmit('#create-sopir', '{{ route("sopir.store") }}', '#datatables', 'Sopir created successfully!', true, '#create-modal');

    setupFormSubmit('#edit-sopir', '{{ route("sopir.update", ":id") }}', '#datatables', 'Sopir updated successfully!',false, '#edit-modal');

    setupDeleteButton('.delete-btn', '{{ route("sopir.destroy", ":id") }}', '#datatables');

  });

</script>

@endsection