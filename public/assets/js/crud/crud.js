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
function initDataTable(selector, ajaxUrl, columns) {
	$(selector).DataTable({
		processing: true,
		serverSide: true,
		ajax: ajaxUrl,
		language: {
			processing: '<div class="spinner-overlay"><div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>',
			loadingRecords: '<div class="spinner-overlay"><div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>',
		},
		scrollX: false,
		columns: columns,
	});

	$(selector).on('processing.dt', function (e, settings, processing) {
		if (processing) {
			$('#loading-spinner').fadeIn();
		} else {
			$('#loading-spinner').fadeOut();
		}
	});

}

function setupFormSubmit(formSelector, ajaxUrlTemplate, tableSelector, successMessage, isCreate = false, modalSelector) {
	$(formSelector).off().on('submit', function (e){
	// $(formSelector).submit(function (e) {
		e.preventDefault();
		let formData = new FormData(this);
		let id = $(this).data('id') || $(this).find('[name="id"]').val();
		let submitUrl = isCreate ? ajaxUrlTemplate : ajaxUrlTemplate.replace(':id', id);
		
		let formData2 = new FormData($(this)[0]);
		
		// for (let pair of formData.entries()) {
		// 	console.log(pair[0] + ": " + pair[1]);
		// }
		// console.log($('meta[name="csrf-token"]').attr('content'));

		let methodType = isCreate ? 'POST' : 'PUT';
		$('#btn').addClass('disabled');
		$('#btn-loading-spinner').removeClass('d-none');
		$(formSelector).find('.error-message').remove(); 
		$(formSelector).find('.is-invalid').removeClass('is-invalid');
		$.ajax({
			url: submitUrl,
			type: 'POST',
			data: formData2, 
            processData: false,
            contentType: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function (response) {
				$('#btn').removeClass('disabled');
				$('#btn-loading-spinner').addClass('d-none');
				$(formSelector).trigger('reset');
				if (tableSelector && $(tableSelector).length) {
					$(tableSelector).DataTable().ajax.reload();
				}
				if (modalSelector && $(modalSelector).length) {
					$(modalSelector).modal('hide');
				}
				showToastr('success', successMessage, 'Success!');
			},
			error: function (xhr, status, error) {
				$('#btn').removeClass('disabled');
				$('#btn-loading-spinner').addClass('d-none');

				console.error("Error:", xhr.status, xhr.responseText);

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
						text: xhr.responseJSON?.message || 'An unexpected error occurred. Please try again later.',
						icon: 'error',
						confirmButtonText: 'OK'
					});
				}
			}
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
				$('#loading-spinner').removeClass('d-none');
				$.ajax({
					url: deleteUrl,
					type: 'DELETE',
					data: { _token: $('meta[name="csrf-token"]').attr('content') },
					success: function (response) {
						$(tableSelector).DataTable().ajax.reload();
						$('#loading-spinner').addClass('d-none');
						showToastr('success',response.message,'Deleted!');
            // Swal.fire({
            //   title: 'Deleted!',
            //   text: response.message,
            //   icon: 'success',
            //   confirmButtonText: 'OK',
            // });
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

function defaultAjax(form) {
    form.off().on("submit", function (e) {
        e.preventDefault();

        var submitButton = $(this).find("button[type=submit]");
        var submitButtonHtml = submitButton.html();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                submitButton.attr("disabled", "disabled");
                submitButton.html(
                    'Memproses <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>'
                );
            },
            success: function (res) {
                toastr.success(`${res.message}`);
                if (res?.redirect) {
                    setTimeout(function () {
                        window.location.href = res.redirect;
                    }, 1000);
                }
            },
            error: function (xhr, status, error) {
                let errorList = "";
                if (typeof (xhr.responseJSON?.errors) === 'object') {
                    $.each(xhr.responseJSON?.errors, function (key, value) {
                        if (value.length > 1) {
                            $.each(value, function (key, value) {
                                errorList += value + "<br/>";
                            });
                        } else {
                            errorList += value + "<br/>";
                        }
                    });
                } else {
                    errorList += xhr.responseJSON?.message;
                }

                toastr.error(`${errorList}`);

                submitButton.removeAttr("disabled");
                submitButton.html(submitButtonHtml);

                if (xhr.responseJSON?.status === "session_expired") {
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            }
        });
    });
}