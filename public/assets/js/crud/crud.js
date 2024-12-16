function initDataTable(selector, ajaxUrl, columns) {
  $(selector).DataTable({
    processing: true,
    serverSide: true,
    ajax: ajaxUrl,
    language: {
      processing: '<div class="spinner-grow  text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span> </div>',
      loadingRecords: '<div class="spinner-grow  text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span> </div>.'
    },
    scrollX: false,
    columns: columns,
  });
}

function setupFormSubmit(formSelector, ajaxUrlTemplate, tableSelector, successMessage, isCreate = false, modalSelector) {
  $(formSelector).submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = $(this).data('id');
    let submitUrl = isCreate ? ajaxUrlTemplate : ajaxUrlTemplate.replace(':id', id);
    $('#loading-spinner').removeClass('d-none');
    $.ajax({
      url: submitUrl,
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        $('#loading-spinner').addClass('d-none');
        $(formSelector).trigger('reset');
        $(tableSelector).DataTable().ajax.reload();
        $(modalSelector).modal('hide');

        Swal.fire({
          title: 'Success!',
          text: successMessage,
          icon: 'success',
          confirmButtonText: 'OK',
        });
      },
      error: function (xhr, status, error) {
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
      },
    });
  });
}

function setupDeleteButton(buttonSelector, ajaxUrlTemplate, tableSelector) {
  $(document).on('click', buttonSelector, function () {
    let id = $(this).data('id');
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
        $.ajax({
          url: deleteUrl,
          type: 'DELETE',
          data: { _token: $('meta[name="csrf-token"]').attr('content') },
          success: function (response) {
            $(tableSelector).DataTable().ajax.reload();
            Swal.fire({
              title: 'Deleted!',
              text: response.message,
              icon: 'success',
              confirmButtonText: 'OK',
            });
          },
          error: function (xhr, status, error) { 
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
}
function showToastr(type, message, title = '') {
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right", 
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000", 
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  switch (type) {
  case 'success':
    toastr.success(message, title);
    break;
  case 'error':
    toastr.error(message, title);
    break;
  case 'info':
    toastr.info(message, title);
    break;
  case 'warning':
    toastr.warning(message, title);
    break;
  default:
    console.error('Invalid toastr type:', type);
  }
}