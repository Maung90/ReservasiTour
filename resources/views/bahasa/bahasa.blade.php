@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Bahasa')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<div class="overflow-hidden shadow-none card bg-light-info position-relative">
  <div class="px-4 py-3 card-body">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="mb-8 fw-semibold">Data Bahasa</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-muted " href="/">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Bahasa</li>
          </ol>
        </nav>
      </div>
      <div class="col-3">
        <div class="text-center mb-n5">  
          <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
        </div>
      </div>
    </div>
    <button class="capitalize btn btn-sm waves-effect waves-light btn-success create-modal" data-bs-toggle="modal" data-bs-target="#create-modal"> <i class="ti ti-plus"></i> Buat Data</button>
  </div>
</div>

<div class="card-body">
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
      <div class="card">
        <div class="card-body"> 
          <div class="table-responsive">
            <table id="datatables" class="table border">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Bahasa</th>
                  <th>Harga Bahasa</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal create bahasa -->
<div class="modal fade p-1" id="create-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <form id="create-bahasa" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myModalLabel">
            Add bahasa 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
          <div class="form-group">
            <label for="nama_bahasa">Nama bahasa</label>
            <input type="text" class="form-control" name="nama_bahasa" id="nama_bahasa" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="harga_bahasa">Harga Bahasa</label>
            <input type="number" class="form-control" name="harga_bahasa" id="harga_bahasa" required autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="font-medium btn btn-light-success text-success waves-effect">
            Save
          </button>
          <button type="button" class="font-medium btn btn-light-danger text-danger waves-effect" data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div> 
    </form>
  </div> 
</div> 
<!-- tutup modal create bahasa -->

<!-- modal update bahasa -->
<div class="modal fade p-1" id="edit-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <form id="edit-bahasa" method="POST" data-id=''>
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myModalLabel">
            Edit Bahasa 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <x-loading-spinner id="loading-modal-edit"/> 
          <div id="form-edit">
            <div class="form-group">
              <label for="nama_bahasa_edit">Nama bahasa</label>
              <input type="text" class="form-control" name="nama_bahasa" id="nama_bahasa_edit" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="harga_bahasa_edit">Harga Bahasa</label>
              <input type="number" class="form-control" name="harga_bahasa" id="harga_bahasa_edit" required autocomplete="off">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="font-medium btn btn-light-success text-success waves-effect">
            Save
          </button>
          <button type="button" class="font-medium btn btn-light-danger text-danger waves-effect" data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div> 
    </form>
  </div> 
</div> 
<!-- tutup modal update bahasa -->
<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script>

  $(document).ready(function () {
    $('#datatables').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('bahasa.tableBahasa') }}',
      scrollX: false,
      columns: [
        { data: 'no', name: 'no' },
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
    });

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



  // button submit create bahasa
    $('#create-bahasa').submit(function(e) {
      e.preventDefault();
      let formData = new FormData(this);
      $('#loading-spinner').removeClass('d-none');

      $.ajax({
        url: "{{ route('bahasa.store') }}",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          $('#loading-spinner').addClass('d-none');

          $('#create-modal').modal('hide');
          $('#datatables').DataTable().ajax.reload();
          $('#create-bahasa').trigger('reset');

          Swal.fire({
            title: 'Success!',
            text: response.message,
            icon: 'success',
            confirmButtonText: 'OK'
          });
        },
        error: function(xhr, status, error) {
          $('#loading-spinner').addClass('d-none');
          console.error("Error uploading data:", error);

          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = '<ul>';

            $.each(errors, function(field, messages) {
              errorMessage += '<li>' + messages.join(', ') + '</li>';
            });

            errorMessage += '</ul>';

            Swal.fire({
              title: 'Validation Error!',
              html: errorMessage,
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
        }
      });
    });

  //button submit edit bahasa
    $('#edit-bahasa').submit(function (e) {
      e.preventDefault();

      let formData = new FormData(this);
      let bahasaId = $(this).data('id'); 

      $('#loading-overlay').removeClass('d-none');

      $.ajax({
        url: "{{ route('bahasa.update', ':id') }}".replace(':id', bahasaId),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          $('#loading-overlay').addClass('d-none');

          $('#edit-modal').modal('hide');
          $('#edit-bahasa').trigger('reset');

          $('#datatables').DataTable().ajax.reload();

          Swal.fire({
            title: 'Success!',
            text: response.message,
            icon: 'success',
            confirmButtonText: 'OK',
          });
        },
        error: function (xhr) {
          $('#loading-overlay').addClass('d-none');

          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = '<ul>';

            $.each(errors, function(field, messages) {
              errorMessage += '<li>' + messages.join(', ') + '</li>';
            });

            errorMessage += '</ul>';

            Swal.fire({
              title: 'Validation Error!',
              html: errorMessage,
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
    });

  // button delete 
    $(document).on('click', '.delete-btn', function() {
      let id = $(this).data('id');
      let deleteUrl = '{{ route("bahasa.destroy", ":id") }}'.replace(':id', id);

      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              $('#datatables').DataTable().ajax.reload();
              Swal.fire({
                title: 'Deleted!',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'OK'
              });
            },
            error: function(xhr, status, error) {
              console.error("Error deleting data:", error);
              Swal.fire({
                title: 'Error!',
                text: 'There was an error deleting the data.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          });
        }
      });
    });
  });

</script>

@endsection