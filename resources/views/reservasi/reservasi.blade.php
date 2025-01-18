@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Reservasi')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection

@section('content') 
<x-card-breadcrumb title="Reservasi"/>
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


<!-- modal create reservasi -->
<x-modal id="create-modal" labelId="createLabel" title="Add reservasi" formId="create-reservasi" method="POST" size="modal-lg">
	<div class="row">

		<div class="col-4">
			<x-input id="tour_date" type="date" name="tour_date">Tour Date</x-input>
			<x-input id="guest_name" type="text" name="guest_name">Guest Name</x-input>
			<x-input id="contact" type="text" name="contact">Contact</x-input>
			<div class="form-group">
				<label for="program_id">Program</label>
				<select class="form-control" id="program_id" name="program_id">
					<option disabled selected>Select Program</option>
					@foreach($programs as $program):
					<option value="{{$program->id}}"> {{ $program->nama_program }}</option>
					@endforeach
				</select>
			</div>
			<x-input id="pax" type="number" name="pax">Pax</x-input>
			<x-input id="hotel" type="text" name="hotel">Hotel</x-input>
		</div>

		<div class="col-4">
			<x-input id="pickup" type="datetime-local" name="pickup">Pickup Time</x-input>
			<div class="form-group">
				<label for="guide_id">Guide</label>
				<select class="form-control" id="guide_id" name="guide_id">
					<option disabled selected>Select Guide</option>
					@foreach($guides as $guide):
					<option value="{{$guide->id}}"> {{ $guide->nama_guide }} - {{ $guide->bahasa->pluck('bahasa.nama_bahasa')->join(', ') }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="bahasa_id">Bahasa</label>
				<select class="form-control" id="bahasa_id" name="bahasa_id">
					<option disabled selected>Select Bahasa</option>
					@foreach($bahasas as $bahasa):
					<option value="{{$bahasa->id}}"> {{ $bahasa->nama_bahasa }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="transport_id">Transport</label>
				<select class="form-control" id="transport_id" name="transport_id">
					<option disabled selected>Select Transport</option>
					@foreach($kendaraans as $kendaraan):
					<option value="{{$kendaraan->id}}"> {{ $kendaraan->jenis_kendaraan }} ( {{ $kendaraan->kapasitas }} )</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="sopir_id">Driver</label>
				<select class="form-control" id="sopir_id" name="sopir_id">
					<option disabled selected>Select Driver</option>
					@foreach($sopirs as $sopir):
					<option value="{{$sopir->id}}"> {{ $sopir->nama_sopir }}</option>
					@endforeach
				</select>
			</div> 
		</div>

		<div class="col-4">
			<x-input id="activities" type="text" name="activities">Activities</x-input>
			<x-input id="arrival_code" type="text" name="flight_code[arrival_code]">Arrival Code</x-input>
			<x-input id="departure_code" type="text" name="flight_code[departure_code]">Departure Code</x-input>
			<x-input id="eta" type="datetime-local" name="flight_code[eta]">ETA</x-input>
			<x-input id="etd" type="datetime-local" name="flight_code[etd]">ETD</x-input>
		</div>

	</div>
</x-modal>
<!-- tutup modal create reservasi -->

<!-- modal info reservasi -->
<x-modal id="info-modal" labelId="infoLabel" title="Info Reservasi" formId="info-reservasi" method="POST" size="modal-lg" :showSaveButton="false">
	<x-loading-spinner id="loading-info"/>
	<table class="table " id="table-info">
		<thead>
			<tr>
				<th>Tour Code</th><td id="tour_code-info">-</td>
				<th>Date Of Booking</th><td id="dob-info">-</td>
				<th>Tour Date</th><td id="tour_date-info">-</td>

			</tr>
			<tr>
				<th>Guest Name</th><td id="guest_name-info">-</td>
				<th>Contact</th><td id="contact-info">-</td>
				<th>Pax</th><td id="pax-info">-</td>
			</tr>

			<tr>
				<th>Hotel</th><td id="hotel-info">-</td>
				<th>PickUp</th><td id="pickup-info">-</td>
				<th>Activities</th><td id="activities-info">-</td>
			</tr>

			<tr>
				<th>Guide</th><td id="guide-info">-</td>
				<th>Driver</th><td id="sopir-info">-</td>
				<th>Transport</th><td id="transport-info">-</td>
			</tr>

			<tr>
				<th>Program</th><td id="program-info">-</td>
				<th>Bahasa</th><td id="bahasa-info">-</td>
				<th rowspan="2" >Remarks</th><td rowspan="2" id="remarks-info">-</td>
			</tr>

			<tr>
				<th>ETA</th><td id="flight_code_eta-info">-</td>
				<th>ETD</th><td id="flight_code_etd-info">-</td>
			</tr>

			<tr>
				<th>Created By</th><td id="created-by-info">-</td>
				<th>Updated By</th><td id="updated-by-info">-</td>
				<th>Updated At</th><td id="updated-at-info">-</td>
			</tr>
		</thead>
	</table>
</x-modal>
<!-- tutup modal info reservasi -->


<!-- tutup modal update reservasi -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Reservasi" formId="edit-reservasi" method="PUT" size="modal-lg">
	<x-loading-spinner id="loading-modal-edit"/>
	<div id="form-edit">
		<div class="row">

			<div class="col-4">
				<x-input id="tour_date-edit" type="date" name="tour_date">Tour Date</x-input>
				<x-input id="guest_name-edit" type="text" name="guest_name">Guest Name</x-input>
				<x-input id="contact-edit" type="text" name="contact">Contact</x-input>
				<div class="form-group">
					<label for="program_id">Program</label>
					<select class="form-control" id="program_id-edit" name="program_id">
						<option disabled selected>Select Program</option>
						@foreach($programs as $program)
						<option value="{{$program->id}}"> {{ $program->nama_program }}</option>
						@endforeach
					</select>
				</div>
				<x-input id="pax-edit" type="number" name="pax">Pax</x-input>
				<x-input id="hotel-edit" type="text" name="hotel">Hotel</x-input>
			</div>

			<div class="col-4">
				<x-input id="pickup-edit" type="datetime-local" name="pickup">Pickup Time</x-input>
				<div class="form-group">
					<label for="guide_id">Guide</label>
					<select class="form-control" id="guide_id-edit" name="guide_id">
						<option disabled selected>Select Guide</option>
						@foreach($guides as $guide):
						<option value="{{$guide->id}}"> {{ $guide->nama_guide }} - {{ $guide->bahasa->pluck('bahasa.nama_bahasa')->join(', ') }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="bahasa_id">Bahasa</label>
					<select class="form-control" id="bahasa_id-edit" name="bahasa_id">
						<option disabled selected>Select Bahasa</option>
						@foreach($bahasas as $bahasa):
						<option value="{{$bahasa->id}}"> {{ $bahasa->nama_bahasa }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="transport_id">Transport</label>
					<select class="form-control" id="transport_id-edit" name="transport_id">
						<option disabled selected>Select Transport</option>
						@foreach($kendaraans as $kendaraan):
						<option value="{{$kendaraan->id}}"> {{ $kendaraan->jenis_kendaraan }} ( {{ $kendaraan->kapasitas }} )</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="sopir_id">Driver</label>
					<select class="form-control" id="sopir_id-edit" name="sopir_id">
						<option disabled selected>Select Driver</option>
						@foreach($sopirs as $sopir):
						<option value="{{$sopir->id}}"> {{ $sopir->nama_sopir }}</option>
						@endforeach
					</select>
				</div>
				<x-input id="remarks-edit" type="text" name="remarks">Remarks</x-input>
			</div>

			<div class="col-4">
				<x-input id="activities-edit" type="text" name="activities">Activities</x-input>
				<x-input id="arrival_code-edit" type="text" name="flight_code[arrival_code]">Arrival Code</x-input>
				<x-input id="departure_code-edit" type="text" name="flight_code[departure_code]">Departure Code</x-input>
				<x-input id="eta-edit" type="datetime-local" name="flight_code[eta]">ETA</x-input>
				<x-input id="etd-edit" type="datetime-local" name="flight_code[etd]">ETD</x-input>
			</div>

		</div>
	</div>
</x-modal>
<!-- tutup modal update reservasi -->

<x-loading-spinner id="loading-spinner"/>
@endsection

@section('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
	initDataTable('#datatables', '{{ route('reservasi.tableReservasi') }}', 
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
			url: '{{ route("reservasi.get", ":id") }}'.replace(':id', id),
			type: 'GET',
			success: function(response) {
				let data = response;

				if (data.updated_at) {
					const date = new Date(data.updated_at);
					const formattedDate = new Intl.DateTimeFormat('id-ID', {
						day: '2-digit',
						month: 'long',
						year: 'numeric',
						hour: '2-digit',
						minute: '2-digit',
					}).format(date);

					$('#updated-at-info').text(formattedDate);
				}

				$('#tour_code-info').text(data.tour_code);
				$('#dob-info').text(data.dob);
				$('#contact-info').text(data.contact);
				$('#guest_name-info').text(data.guest_name);
				$('#pax-info').text(data.pax);
				$('#tour_date-info').text(data.tour_date);

				$('#hotel-info').text(data.hotel);
				$('#pickup-info').text(data.pickup);
				$('#remarks-info').text(data.remarks);

				$('#program-info').text(data.program);
				$('#activities-info').text(data.activities);
				$('#bahasa-info').text(data.bahasa);

				$('#guide-info').text(data.guide);
				$('#sopir-info').text(data.sopir);
				$('#transport-info').text(data.transport);

				$('#flight_code_eta-info').text(data.flight_code_arrival);
				$('#flight_code_etd-info').text(data.flight_code_depacture);

				$('#created-by-info').text(data.creator);
				$('#updated-by-info').text(data.updator);

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
		$('#edit-reservasi').data('id', id);

		$('#form-edit').addClass('d-none');
		$('#loading-modal-edit').removeClass('d-none');

		$.ajax({
			url: '{{ route("reservasi.get", ":id") }}'.replace(':id', id),
			type: 'GET',
			success: function(response) {
				let data = response;

				$('#dob-edit').val(data.dob_edit);
				$('#contact-edit').val(data.contact);
				$('#guest_name-edit').val(data.guest_name);
				$('#pax-edit').val(data.pax);
				$('#tour_date-edit').val(data.tour_date_edit);

				$('#hotel-edit').val(data.hotel);
				$('#pickup-edit').val(data.pickup_edit);
				$('#remarks-edit').val(data.remarks);

				$('#program_id-edit').val(data.program_id);
				$('#activities-edit').val(data.activities);
				$('#bahasa_id-edit').val(data.bahasa_id);

				$('#guide_id-edit').val(data.guide_id);
				$('#sopir_id-edit').val(data.sopir_id);
				$('#transport_id-edit').val(data.transport_id);

				$('#arrival_code-edit').val(data.flight_code_arrival);
				$('#departure_code-edit').val(data.flight_code_depacture);

				$('#eta-edit').val(data.eta);
				$('#etd-edit').val(data.etd);

				$('#loading-modal-edit').addClass('d-none');
				$('#form-edit').removeClass('d-none');

				$('#edit-modal').modal('show');
			},
			error: function(xhr, status, error) {
				$('#loading-modal-edit').addClass('d-none');
				$('#form-edit').removeClass('d-none');
				console.error("Error fetching data:", error);
			}
		});
	});

	setupFormSubmit('#create-reservasi', '{{ route("reservasi.store") }}', '#datatables', 'Reservasi created successfully!', true, '#create-modal');

	setupFormSubmit('#edit-reservasi', '{{ route("reservasi.update", ":id") }}', '#datatables', 'Reservasi updated successfully!',false, '#edit-modal');

	setupDeleteButton('.delete-btn', '{{ route("reservasi.destroy", ":id") }}', '#datatables');
</script>
@endsection
