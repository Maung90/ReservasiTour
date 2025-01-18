@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Reservasi')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection

@section('content') 
<div class="container">
	<div class="row">
		<form action="" method="POST">
			<div class="col-12">
				<div class="card mt-2">
					<h5 class="card-header">Isi Data Tamu</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-6">
								<input type="hidden" name="id" value="<?= $program_id ? $program_id : null?>">
								<div class="form-group">
									<label for="name">Name</label>
									<input required autocomplete="off" type="text" class="form-control" name="name" id="name">
								</div>
								<div class="form-group">
									<label for="tour_code">Tour Code</label>
									<input required autocomplete="off" type="text" class="form-control" name="tour_code" id="tour_code">
								</div>
								<div class="form-group">
									<label for="contact">Contact</label>
									<input required autocomplete="off" type="text" class="form-control" name="contact" id="contact">
								</div>
								<div class="form-group">
									<label for="pax">Pax</label>
									<input required autocomplete="off" type="number" class="form-control" name="pax" id="pax">
								</div>
								<div class="form-group">
									<label for="country">Bahasa</label>
									<select class="form-select" name="bahasa" id="" required>
										<option disabled selected>Pilih Bahasa</option>
										<?php foreach ($bahasas as $b): ?>
											<option value="<?=$b->id;?>"><?=$b->nama_bahasa;?> </option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="form-group">
									<label for="remarks">Remarks</label>
									<input required autocomplete="off" type="text" class="form-control" name="remarks" id="remarks">
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label for="dob">Date Of Booking</label>
									<input required autocomplete="off" type="date" class="form-control" name="dob" id="dob">
								</div>
								<div class="form-group">
									<label for="date">Date</label>
									<input required autocomplete="off" type="date" class="form-control" name="date" id="date" disabled>
								</div>
								<div class="form-group">
									<label for="fac">Flight Arraival Code</label>
									<input required autocomplete="off" type="text" class="form-control" name="fac" id="fac">
								</div>
								<div class="form-group">
									<label for="eta">ETA</label>
									<input required autocomplete="off" type="time" class="form-control" name="eta" id="eta">
								</div>
								<div class="form-group">
									<label for="fdc">Flight Depacture Code</label>
									<input required autocomplete="off" type="text" class="form-control" name="fdc" id="fdc">
								</div>
								<div class="form-group">
									<label for="etd">ETD</label>
									<input required autocomplete="off" type="time" class="form-control" name="etd" id="etd">
								</div>
							</div>
							<div class="col-12">
								<div class="d-flex align-items-center justify-content-between mt-2">
									<a class="btn btn-secondary" onclick="window.history.back();">Previous</a>
									<button class="btn btn-outline-primary" type="submit">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
@endsection