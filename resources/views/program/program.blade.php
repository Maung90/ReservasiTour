@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Program')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Program"/>

<x-datatable>
 <thead>
  <tr>
    <th>No</th>
    <th>Nama Program</th>
    <th>Deskripsi</th>
    <th>Durasi</th>
    <th>Created_by</th>
    <th>Updated_by</th>
    @if(auth()->user()->role_id != 3 ):
    <th>Aksi</th>
    @endif
  </tr>
</thead>
</x-datatable>

<!-- modal create Program -->
<x-modal id="create-modal" labelId="createLabel" title="Add Program" formId="create-program" method="POST">
  <x-input id="nama_program" type="text" name="nama_program">Nama Program</x-input>
  <x-input id="deskripsi" type="text" name="deskripsi">Deskripsi</x-input>
  <x-input id="durasi" type="number" name="durasi">Durasi</x-input>
</x-modal>
<!-- tutup modal create program -->

<!-- modal update program -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Program" formId="edit-program" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <x-input id="nama_program_edit" type="text" name="nama_program">Nama Program</x-input>
    <x-input id="deskripsi_edit" type="text" name="deskripsi">Deskripsi</x-input>
    <x-input id="durasi_edit" type="number" name="durasi">Durasi</x-input>
  </div>
</x-modal>
<!-- tutup modal update program -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  $(document).ready(function () {

    var userRoleId = {{ auth()->user()->role_id }};
    initDataTable('#datatables', '{{ route('program.tableProgram') }}', 
      [
        { data: 'no', name: 'no' },
        { data: 'nama_program', name: 'nama_program' },
        { data: 'deskripsi', name: 'deskripsi' },
        { data: 'durasi', name: 'durasi' },
        { data: 'created_by', name: 'created_by' },
        { data: 'updated_by', name: 'updated_by' },
        { data: 'action', name: 'action', orderable: false, searchable: false , visible: userRoleId !== 3 },
        ]
      );


  // modal edit 
    $(document).on('click', '.edit-btn', function() {
      let id = $(this).data('id');
      $('#edit-program').data('id', id);

      $('#form-edit').addClass('d-none');
      $('#loading-modal-edit').removeClass('d-none');

      $.ajax({
        url: '{{ route("program.get", ":id") }}'.replace(':id', id),
        type: 'GET',
        success: function(response) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');

          let data = response;
          $('#nama_program_edit').val(data.nama_program);
          $('#deskripsi_edit').val(data.deskripsi);
          $('#durasi_edit').val(data.durasi);

          $('#edit-modal').modal('show');
        },
        error: function(xhr, status, error) {
          $('#form-edit').removeClass('d-none');
          $('#loading-modal-edit').addClass('d-none');
          console.error("Error fetching data:", error);
        }
      });
    });


    setupFormSubmit('#create-program', '{{ route("program.store") }}', '#datatables', 'Program created successfully!', true, '#create-modal');

    setupFormSubmit('#edit-program', '{{ route("program.update", ":id") }}', '#datatables', 'Program updated successfully!',false, '#edit-modal');

    setupDeleteButton('.delete-btn', '{{ route("program.destroy", ":id") }}', '#datatables');

  });

</script>

@endsection