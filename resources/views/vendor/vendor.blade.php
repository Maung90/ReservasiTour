@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Vendor')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection


@section('content') 
<div class="overflow-hidden shadow-none card bg-light-info position-relative">
  <div class="px-4 py-3 card-body">
    <div class="row align-items-center">
      <div class="col-9">
        <h4 class="mb-8 fw-semibold">Data Vendor</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="text-muted " href="/">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Vendor</li>
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
          <div class="table">
            <div class="table-responsive">
              <table id="datatables" class="table border">
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
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal create vendor -->
<div class="modal fade p-1" id="create-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <form id="create-vendor" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myModalLabel">
            Add Vendor 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
          <div class="form-group">
            <label for="nama_vendor">Nama Vendor</label>
            <input type="text" class="form-control" name="nama_vendor" id="nama_vendor" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" name="contact" id="contact" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="bank">Bank</label>
            <input type="text" class="form-control" name="bank" id="bank" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="no_rekening">No Rekening</label>
            <input type="number" class="form-control" name="no_rekening" id="no_rekening" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="account_name">Nama Akun</label>
            <input type="text" class="form-control" name="account_name" id="account_name" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="validity_period">Periode Validasi</label>
            <input type="date" class="form-control" name="validity_period" id="validity_period" required autocomplete="off">
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
<!-- tutup modal create vendor -->


<!-- modal info vendor -->
<div class="modal fade p-1" id="info-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md"> 
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          Info Vendor 
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table border">
          <thead>
            <tr>
              <th>Nama Vendor</th>
              <td id="name_vendor-info">-</td>
            </tr>
            <tr>
              <th>Contact</th>
              <td id="contact-info">-</td>
            </tr>
            <tr>
              <th>Bank</th>
              <td id="bank-info">-</td>
            </tr>
            <tr>
              <th>No Rekening</th>
              <td id="no_rekening-info">-</td>
            </tr>
            <tr>
              <th>Nama AKun</th>
              <td id="account_name-info">-</td>
            </tr>
            <tr>
              <th>Periode Validasi</th>
              <td id="validity_period-info">-</td>
            </tr>
            <tr>
              <th>Waktu Dibuat</th>
              <td id="createted-at-info">-</td>
            </tr>
          </thead>
        </table>
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
  </div> 
</div> 
<!-- tutup modal info vendor -->

<!-- modal update vendor -->
<div class="modal fade p-1" id="edit-modal" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-md">
    <form id="edit-vendor" method="POST" data-id=''>
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="myModalLabel">
            Edit Vendor 
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
          <div class="form-group">
            <label for="nama_vendor">Nama Vendor</label>
            <input type="text" class="form-control" name="nama_vendor" id="name_vendor_update" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" name="contact" id="contact_update" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="bank">Bank</label>
            <input type="text" class="form-control" name="bank" id="bank_update" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="no_rekening">No Rekening</label>
            <input type="text" class="form-control" name="no_rekening" id="no_rekening_update" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="account_name">Nama Akun</label>
            <input type="text" class="form-control" name="account_name" id="account_name_update" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="validity_period">Periode Validasi</label>
            <input type="text" class="form-control" name="validity_period" id="validity_period_update" required autocomplete="off">
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
<!-- tutup modal update vendor -->

<div id="loading-spinner" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 1055; ">
  <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>


@endsection
@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script>
  $('#datatables').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('Vendor.tableVendor') }}',
    columns: [
      { data: 'no', name: 'no' },
      { data: 'nama_vendor', name: 'nama_vendor' },
      { data: 'contact', name: 'contact' },
      { data: 'bank', name: 'bank' },
      { data: 'validity_period', name: 'validity_period' },
      { data: 'action', name: 'action' }
      ]
  });

  // modal info
  $(document).on('click', '.info-btn', function() {
    let id = $(this).data('id');
    $.ajax({
      url: '{{ route("vendor.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        let data = response;
        $('#name_vendor-info').text(data.nama_vendor);
        $('#contact-info').text(data.contact);
        $('#bank-info').text(data.bank);
        $('#validity_period-info').text(data.validity_period);
        $('#account_name-info').text(data.account_name);
        $('#no_rekening-info').text(data.no_rekening);
        $('#createted-at-info').text(data.created_at);

        $('#info-modal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error("Error fetching data:", error);
      }
    });
  });

  // modal edit 
  $(document).on('click', '.edit-btn', function() {
    let id = $(this).data('id');
    $('#edit-vendor').data('id', id);
    console.log($('#edit-vendor')) 
    $('#loading-spinner').removeClass('d-none');
    $.ajax({
      url: '{{ route("vendor.get", ":id") }}'.replace(':id', id),
      type: 'GET',
      success: function(response) {
        $('#loading-spinner').addClass('d-none');
        let data = response;
        $('#name_vendor_update').val(data.nama_vendor);
        $('#contact_update').val(data.contact);
        $('#bank_update').val(data.bank);
        $('#validity_period_update').val(data.validity_period);
        $('#account_name_update').val(data.account_name);
        $('#no_rekening_update').val(data.no_rekening);

        $('#edit-modal').modal('show');
      },
      error: function(xhr, status, error) {
        $('#loading-spinner').addClass('d-none');
        console.error("Error fetching data:", error);
      }
    });
  });

  // button submit create vendor
  $('#create-vendor').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $('#loading-spinner').removeClass('d-none');

    $.ajax({
      url: "{{ route('vendor.store') }}",
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        $('#loading-spinner').addClass('d-none');

        $('#create-modal').modal('hide');
        $('#datatables').DataTable().ajax.reload();
        $('#create-vendor').trigger('reset');

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

  //button submit edit vendor
  $('#edit-vendor').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let vendorId = $(this).data('id'); 

    $('#loading-overlay').removeClass('d-none');

    $.ajax({
      url: "{{ route('vendor.update', ':id') }}".replace(':id', vendorId),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        $('#loading-overlay').addClass('d-none');

        $('#edit-modal').modal('hide');
        $('#edit-vendor').trigger('reset');

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

        Swal.fire({
          title: 'Error!',
          text: xhr.responseJSON?.message || 'Something went wrong!',
          icon: 'error',
          confirmButtonText: 'OK',
        });
      },
    });
  });



  // button delete 
  $(document).on('click', '.delete-btn', function() {
    let id = $(this).data('id');
    let deleteUrl = '{{ route("vendor.destroy", ":id") }}'.replace(':id', id);

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
</script>

@endsection