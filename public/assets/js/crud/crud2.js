
function setupFormSubmit(formSelector, ajaxUrlTemplate, tableSelector, successMessage, isCreate = false, modalSelector) {
  $(formSelector).submit(function (e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    let id = $(this).data('id') || $(this).find('[name="id"]').val();
    let submitUrl = isCreate ? ajaxUrlTemplate : ajaxUrlTemplate.replace(':id', id);
    let methodType = isCreate ? 'POST' : 'PUT';

    let submitButton = $(this).find('button[type="submit"]');
    let loadingSpinner = submitButton.find('.btn-loading-spinner'); 

    submitButton.prop('disabled', true); 
    loadingSpinner.removeClass('d-none');

    $(formSelector).find('.error-message').remove(); 
    $(formSelector).find('.is-invalid').removeClass('is-invalid');

    $.ajax({
      url: submitUrl,
      type: methodType, 
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        submitButton.prop('disabled', false);
        loadingSpinner.addClass('d-none'); // Sembunyikan loading spinner
        $(formSelector).trigger('reset'); // Reset form
        
        if (tableSelector) {
          $(tableSelector).DataTable().ajax.reload(); // Reload DataTable
        }
        if (modalSelector) {
          $(modalSelector).modal('hide'); // Tutup modal
        }
        showToastr('success', successMessage, 'Success!');
      },
      error: function (xhr, status, error) {
        submitButton.prop('disabled', false); // Aktifkan kembali tombol submit
        loadingSpinner.addClass('d-none'); // Sembunyikan loading spinner
        console.error("Error uploading data:", error);

        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;

          $.each(errors, function (field, messages) {
            let inputField = $(formSelector).find(`[name="${field}"]`);
            inputField.addClass('is-invalid');

            let errorMessage = $('<span>')
            .addClass('error-message text-danger')
            .text(messages.join(', '));

            inputField.after(errorMessage);
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

