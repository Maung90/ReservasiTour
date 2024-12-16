@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Guide')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css')}}">
<style>
  .select2-container--default .select2-results__option--selected {
    background-color: #5D87FF;
    color: #fff;
  }

/* Ubah warna teks elemen terpilih pada input Select2 */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #5D87FF; 
  border-color: #5D87FF;
  color: #fff;
}

</style>
@endsection


@section('content') 
<x-card-breadcrumb title="Guide"/>

<x-datatable>
 <thead>
  <tr>
    <th>No</th>
    <th>Nama Guide</th>
    <th>No Telp</th> 
    <th>Status</th>
    <th>Aksi</th>
  </tr>
</thead>
</x-datatable>
<!-- modal create Guide -->
<x-modal id="create-modal" labelId="createLabel" title="Add Guide" formId="create-guide" method="POST">

  <x-input id="nama_guide" type="text" name="nama_guide">Nama Guide</x-input>
  <x-input id="no_telp" type="text" name="no_telp">No Telp</x-input>
  <div class="form-group">
    <label for="bahasa">Bahasa</label>
    <select class="select2 form-control" name="bahasa[]" id="bahasa" multiple="multiple" style="height: 36px; width: 100%">
      @foreach ($bahasas as $b)
      <option value="{{ $b->id }}" {{ in_array($b->id, old('bahasa', $selectedBahasa ?? [])) ? 'selected' : '' }}>
        {{ $b->nama_bahasa }}
      </option>
      @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="status">Status</label>
    <select name="status" id="status" class="form-control" required>
      <option selected disabled> Pilih Status</option>
      <option value="available"> Available </option>
      <option value="unavailable"> Unavailable </option>
    </select>
  </div>

</x-modal>
<!-- tutup modal create guide -->

<!-- modal update guide -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Guide" formId="edit-guide" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <x-input id="nama_guide_edit" type="text" name="nama_guide">Nama Guide</x-input>
    <x-input id="no_telp_edit" type="text" name="no_telp">No Telp</x-input>
    <div class="form-group">
      <label for="bahasa_edit">Bahasa</label>
      <select class="select2 form-control" name="bahasa[]" id="bahasa_edit" multiple="multiple" style="height: 36px; width: 100%"></select>
    </div>
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
<!-- tutup modal update guide -->

<!-- modal info guide -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Guide" formId="info-guide" method="POST" :showSaveButton="false">
  <x-loading-spinner id="loading-info"/>
  <table class="table border" id="table-info">
    <thead>
      <tr><th>Nama guide</th><td id="nama_guide_info">-</td></tr>
      <tr><th>No Telp</th><td id="no_telp_info">-</td></tr>
      <tr><th>Bahasa</th><td id="bahasa_info">-</td></tr>
      <tr><th>Status</th><td id="status_info">-</td></tr>
    </thead>
  </table>
</x-modal>

<!-- tutup modal info guide -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script> 
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>

  $(document).ready(function () {



   $('#bahasa').select2({
    placeholder: "Pilih Bahasa", 
    width: 'resolve',
    dropdownParent: $('#create-modal') 
  });

   $('#bahasa_edit').select2({
    placeholder: "Pilih Bahasa", 
    width: 'resolve',
    dropdownParent: $('#edit-modal') 
  });

   function loadAllBahasa() {
    $.ajax({
      url: '{{ route('bahasa.getAllBahasa') }}', 
      type: 'GET',
      success: function(data) {
        $('#bahasa_edit').empty();
        data.forEach(function(bahasa) {
          $('#bahasa_edit').append(new Option(bahasa.nama_bahasa, bahasa.id));
        });
        $('#bahasa_edit').trigger('change');
      },
      error: function(xhr) {
        console.error('Error fetching all bahasa:', xhr.responseText);
      }
    });
  }

  initDataTable('#datatables', '{{ route('guide.tableGuide') }}', 
    [
      { data: 'no', name: 'no' },
      { data: 'nama_guide', name: 'nama_guide' },
      { data: 'no_telp', name: 'no_telp' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
      ]
    );

  // modal info
  $(document).on('click', '.info-btn', function() {
    let id = $(this).data('id');
    
    $('#table-info').addClass('d-none');
    $('#loading-info').removeClass('d-none');

    $.ajax({
      url: '{{ route("guide.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        let data = response;

        $('#nama_guide_info').text(data.nama_guide);
        $('#no_telp_info').text(data.no_telp);
        $('#bahasa_info').html(data.bahasa);
        $('#status_info').text(data.status);

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
    $('#edit-guide').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    loadAllBahasa();
    $.ajax({
      url: '{{ route("guide.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');

        let data = response;
        $('#nama_guide_edit').val(data.nama_guide);
        $('#no_telp_edit').val(data.no_telp);
        $('#status_edit').val(data.status);
        $('#bahasa_edit').val(data.bahasa_id).trigger('change');

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });


  setupFormSubmit('#create-guide', '{{ route("guide.store") }}', '#datatables', 'Guide created successfully!', true, '#create-modal');

  setupFormSubmit('#edit-guide', '{{ route("guide.update", ":id") }}', '#datatables', 'Guide updated successfully!',false, '#edit-modal');

  setupDeleteButton('.delete-btn', '{{ route("guide.destroy", ":id") }}', '#datatables');

});

</script>

@endsection