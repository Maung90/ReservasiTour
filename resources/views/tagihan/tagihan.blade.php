@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Tagihan')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Tagihan" isCreate='true'/>
<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Tour Code</th>
      <th>Total</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable> 

<!-- modal update tagihan -->
@if(session('user.role') == 4 || session('user.role') == 1)
<x-modal id="edit-modal" labelId="editLabel" title="Edit tagihan" formId="edit-tagihan" method="PUT">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <select name="status" id="status" class="form-control">
      <option selected disabled>Pilih Status</option>
      <option value="paid">Paid</option>
      <option value="pending">Pending</option>
    </select>
  </div>
</x-modal>
@endif
<!-- tutup modal update tagihan -->


<!-- modal info tagihan -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Tagihan" formId="info-tagihan" method="POST" :showSaveButton="false">
  <x-loading-spinner id="loading-info"/>
  <table class="table border" id="table-info">
    <thead>
      <tr><th>Tour Code</th><td id="tour_code_info">-</td></tr>
      <tr><th>Total</th><td id="total_info">-</td></tr>
      <tr><th>Status</th><td id="status_info">-</td></tr>
      <tr><th>Create By</th><td id="created_by_info">-</td></tr>
      <tr><th>Update By</th><td id="updated_by_info">-</td></tr>
    </thead>
  </table>
</x-modal>

<!-- tutup modal info tagihan -->
<x-loading-spinner id="loading-spinner"/>
@endsection


@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  initDataTable('#datatables', '{{ route('tagihan.tableTagihan') }}', 
    [
     { data: 'no', name: 'no' },
     { data: 'tour_code', name: 'tour_code' },
     // { data: 'deskripsi', name: 'deskripsi' },
     { data: 'total', name: 'total' ,  render: function(data, type, row) { return `Rp. ${parseInt(data).toLocaleString('id-ID')}`; } }, 
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
      url: '{{ route("tagihan.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        let data = response;

        $('#loading-info').addClass('d-none');
        $('#table-info').removeClass('d-none');
        $('#tour_code_info').text(data.reservasi['tour_code']);
        $('#total_info').text(data.total);
        $('#status_info').text(data.status);
        $('#created_by_info').text(data.creator['nama']);
        $('#updated_by_info').text(data.updator['nama']);


        $('#info-modal').modal('show');
      },
      error: function(xhr, status, error) {
        
        showToastr('error',error,' Please try again later!');
        console.error("Error fetching data:", error);
        $('#loading-info').addClass('d-none');
        $('#table-info').removeClass('d-none');
      }
    });
  });


  // modal edit 
  $(document).on('click', '.edit-btn', function() {
    let id = $(this).data('id');
    $('#edit-tagihan').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    $.ajax({
      url: '{{ route("tagihan.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');

        let data = response;
        $('#status').val(data.status);

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });

  setupFormSubmit('#edit-tagihan', '{{ route("tagihan.update", ":id") }}', '#datatables', 'tagihan updated successfully!',false, '#edit-modal');

  setupDeleteButton('.delete-btn', '{{ route("tagihan.destroy", ":id") }}', '#datatables');

</script>

@endsection