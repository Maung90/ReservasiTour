@extends('layouts.app')

@section('title', 'Senang Tours & Travel - User')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="User"/>

<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama User</th>
      <th>Email</th>
      <th>Username</th>
      <th>Role</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable> 

<!-- modal create User -->
<x-modal id="create-modal" labelId="createLabel" title="Add User" formId="create-user" method="POST">
 <x-input id="nama" type="text" name="nama">Nama User</x-input>
 <x-input id="email" type="text" name="email">Email</x-input>
 <x-input id="username" type="text" name="username">Username</x-input>
 <x-input id="notelp" type="text" name="notelp">No Telp</x-input>
 <div class="form-group">
  <label for="role">Role</label> 
  <select name="role" id="role" class="form-control" required>
    <option selected disabled> Pilih Role</option>
    <option value="2"> Production </option>
    <option value="3"> Operation </option>
    <option value="4"> Accounting </option>
    <option value="5"> Agent </option>
  </select>
</div>
</x-modal>
<!-- tutup modal create User -->

<!-- modal update User -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit User" formId="edit-user" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <div class="modal-body"> 
      <x-input id="nama_edit" type="text" name="nama">Nama User</x-input>
      <x-input id="email_edit" type="text" name="email">Email</x-input>
      <x-input id="username_edit" type="text" name="username">Username</x-input>
      <x-input id="notelp_edit" type="text" name="notelp">No Telp</x-input>
      <div class="form-group">
        <label for="role">Role</label> 
        <select name="role" id="role_edit" class="form-control" required>
          <option selected disabled> Pilih Role</option>
          <option value="2"> Production </option>
          <option value="3"> Operation </option>
          <option value="4"> Accounting </option>
          <option value="5"> Agent </option>
        </select>
      </div>
    </div>
  </div>
</x-modal>
<!-- tutup modal update User -->
<x-loading-spinner id="loading-spinner"/>
@endsection
@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  initDataTable('#datatables', '{{ route('user.tableUser') }}', 
    [
      { data: 'no', name: 'no' },
      { data: 'nama', name: 'nama' },
      { data: 'email', name: 'email' },
      { data: 'username', name: 'username' },
      { data: 'role_id', name: 'role_id' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
      ]
    );

  // modal edit 
  $(document).on('click', '.edit-btn', function() {
    let id = $(this).data('id');
    $('#edit-user').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    $.ajax({
      url: '{{ route("user.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        
        let data = response;
        $('#nama_edit').val(data.nama);
        $('#notelp_edit').val(data.notelp);
        $('#email_edit').val(data.email);
        $('#username_edit').val(data.username);
        $('#role_edit').val(data.role_id);

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: "Error fetching data"
        });
      }
    });
  });


  setupFormSubmit('#create-user', '{{ route("user.store") }}', '#datatables', 'User created successfully!', true, '#create-modal');

  setupFormSubmit('#edit-user', '{{ route("user.update", ":id") }}', '#datatables', 'User updated successfully!',false, '#edit-modal');

  setupDeleteButton('.delete-btn', '{{ route("user.destroy", ":id") }}', '#datatables');
</script>

@endsection