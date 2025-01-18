@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Vendor')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<x-card-breadcrumb title="Activity" isCreate="true"/>
<x-datatable>
  <thead>
    <tr>
      <th>No</th>
      <th>Tour Code</th>
      <th>Date Of Booking</th>
      <th>Tour Date</th>
      <th>Guest Name</th>
      <th>Contact</th>
      <th>Aksi</th>
    </tr>
  </thead>
</x-datatable> 

<!-- modal info activity -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Aktivitas" formId="info-activity" method="POST" :showSaveButton="false">
  <x-loading-spinner id="loading-info"/>
  <table class="table border" id="table-info">
    <thead>
     <tr><th>Tour Code</th><td id="tour_code-info">-</td></tr>
     <tr><th>Date Of Booking</th><td id="dob-info">-</td></tr>
     <tr><th>Tour Date</th><td id="tour_date-info">-</td></tr>
     <tr><th>Guest Name</th><td id="guest_name-info">-</td></tr>
     <tr><th>Contact</th><td id="contact-info">-</td></tr>
     <tr><th>Aktivitas</th><td id="activity-info">-</td></tr>
   </thead>
 </table>
</x-modal>
<!-- tutup modal info activity -->

<!-- modal update activity -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Aktivitas" formId="create-activity" method="POST">
  <x-loading-spinner id="loading-modal-edit"/>
  <div id="form-edit">
    <table class="table border" id="table-info">
      <thead>
        <tr>
          <th>Tour Code</th>
          <th>Aktivitas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="activity_update">
      </tbody>
    </table>
    <x-input id="reservasi_id" type="hidden" name="reservasi_id"></x-input>
    <x-input id="aktivitas" type="text" name="aktivitas">Aktivitas baru</x-input>
  </div>
</x-modal>
<!-- tutup modal update activity -->
<x-loading-spinner id="loading-spinner"/>
@endsection


@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  initDataTable('#datatables', '{{ route('activity.tableActivity') }}', 
    [
      { data: 'no', name: 'no' },
      { data: 'tour_code', name: 'tour_code' },
      { data: 'dob', name: 'dob' },
      { data: 'tour_date', name: 'tour_date' },
      { data: 'guest_name', name: 'guest_name' },
      { data: 'contact', name: 'contact' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
      ]
    );

  // modal info
  $(document).on('click', '.info-btn', function() {
    let id = $(this).data('id');

    $('#table-info').addClass('d-none');
    $('#loading-info').removeClass('d-none');

    $.ajax({
      url: '{{ route("activity.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        let data = response;

        $('#tour_code-info').text(data.tour_code);
        $('#dob-info').text(data.dob);
        $('#tour_date-info').text(data.tour_date);
        $('#guest_name-info').text(data.guest_name);
        $('#contact-info').text(data.contact);
        $('#activity-info').html(data.activity);

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
    $('#edit-activity').data('id', id);

    $('#form-edit').addClass('d-none');
    $('#loading-modal-edit').removeClass('d-none');

    $.ajax({
      url: '{{ route("activity.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');

        let data = response;
        $('#activity_update').html(data.tbody);
        $('#reservasi_id').val(data.reservasi_id);

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#form-edit').removeClass('d-none');
        $('#loading-modal-edit').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });

  setupFormSubmit('#create-activity', '{{ route("activity.store") }}', '#datatables', 'Aktivitas berhasil dibuat!', true, '#edit-modal');

  $(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');
    let ajaxUrlTemplate = '{{ route("activity.destroy", ":id") }}';
    let deleteUrl = ajaxUrlTemplate.replace(':id', id);

    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
      if (result.isConfirmed) {
        $('#loading-spinner').removeClass('d-none');
        $.ajax({
          url: deleteUrl,
          type: 'DELETE',
          data: { _token: $('meta[name="csrf-token"]').attr('content') },
          success: function (response) { 
            $('#edit-modal').modal('hide');
            $('#datatables').DataTable().ajax.reload();
            $('#loading-spinner').addClass('d-none');
            showToastr('success',response.message,'Deleted!');
          },
          error: function (xhr, status, error) { 
            $('#loading-spinner').addClass('d-none');
            if (xhr.status === 422) {
              let errors = xhr.responseJSON.message;                
              Swal.fire({
                title: 'Delete Failed!',
                html: errors,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          },
        });
      }
    });
  });
</script>

@endsection