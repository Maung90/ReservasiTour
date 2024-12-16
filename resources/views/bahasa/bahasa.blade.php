@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Bahasa')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Bahasa"/>

<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Bahasa</th>
      <th>Harga Bahasa</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable>

<!-- modal create bahasa -->
<x-modal id="create-modal" labelId="createLabel" title="Add Bahasa" formId="create-bahasa" method="POST">
  <x-input id="nama_bahasa" type="text" name="nama_bahasa">Nama bahasa</x-input>
  <x-input id="harga_bahasa" type="number" name="harga_bahasa">Harga Bahasa</x-input> 
</x-modal>
<!-- tutup modal create bahasa -->

<!-- modal update bahasa -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Bahasa" formId="edit-bahasa" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <x-input id="nama_bahasa_edit" type="text" name="nama_bahasa">Nama bahasa</x-input>
    <x-input id="harga_bahasa_edit" type="number" name="harga_bahasa">Harga Bahasa</x-input>
  </div>
</x-modal>
<!-- tutup modal update bahasa -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>

  $(document).ready(function () {
   initDataTable('#datatables', '{{ route('bahasa.tableBahasa') }}', 
    [
     {data: 'no', name: 'no' },
     { data: 'nama_bahasa', name: 'nama_bahasa' },
     { 
      data: 'harga_bahasa', 
      name: 'harga_bahasa' ,  
      render: function(data, type, row) {
        return `Rp. ${parseInt(data).toLocaleString('id-ID')}`;
      }
    }, 
    { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
    );

  // modal edit 
   $(document).on('click', '.edit-btn', function() {
    let id = $(this).data('id');
    $('#edit-bahasa').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    $.ajax({
      url: '{{ route("bahasa.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');

        let data = response;
        $('#nama_bahasa_edit').val(data.nama_bahasa);
        $('#harga_bahasa_edit').val(data.harga_bahasa); 

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });


  setupFormSubmit('#create-bahasa', '{{ route("bahasa.store") }}', '#datatables', 'Bahasa created successfully!', true, '#create-modal');

  setupFormSubmit('#edit-bahasa', '{{ route("bahasa.update", ":id") }}', '#datatables', 'Bahasa updated successfully!',false, '#edit-modal');

  setupDeleteButton('.delete-btn', '{{ route("bahasa.destroy", ":id") }}', '#datatables');

 });

</script>

@endsection