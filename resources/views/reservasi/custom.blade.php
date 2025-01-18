@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Reservasi')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
@endsection

@section('content') 
<form id="create-paket-reservasi" method="POST">
	@csrf
	<div class="container" id="formPilihProgram"> 
		<div class="row"> 
			<div class="col-8"></div>
			<div class="col-12"> 
				<div class="card mt-2"> 
					<h5 class="card-header">Pilih Destinasi</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-12 row" id="list-program"> 
								<?php foreach ($produks as $produk): ?> 
									<div class="col-4"> 
										<div class=" border p-3 rounded">
											<div class="form-check custom-option custom-option-basic ">
												<label class="form-check-label custom-option-content" for="id_produk-<?=$produk->id?>">
													<input name="produk_id[]" class="form-check-input" onchange="handleCheckboxChange(event)" type="checkbox" value="<?=$produk->id?>" id="id_produk-<?=$produk->id?>">
													<span class="custom-option-header d-flex justify-content-between"> 
														<span class="h6 mb-0 "><?=$produk->nama_produk;  ?></span> 
														<small class="text-muted">
															<span >Rp. {{number_format($produk->harga,0,',','.')}} </span> 
														</small> 
													</span>
													<span class="custom-option-body d-block mt-4">
														<small><?=$produk->deskripsi;   ?></small> 
													</span>
													<span class="custom-option-footer">
														<small class="badge bg-primary m-1"> {{ $produk->area }}</small>
													</span>
												</label>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="col-12"> 
								<div class="d-flex justify-content-between"> 
									<div></div>
									<button class="btn btn-primary" type="button" id="btnPilihProgram">Next</button> 
								</div>
							</div> 
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>

	<div class="container d-none" id="formDataDiri">
		<div class="row"> 
			<div class="col-12">
				<div class="card mt-2">
					<h5 class="card-header">Isi Data Tamu</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-6"> 
								<x-input id="tour_date" type="date" name="tour_date">Tour Date</x-input>
								<x-input id="guest_name" type="text" name="guest_name">Guest Name</x-input>
								<x-input id="contact" type="text" name="contact">Contact</x-input>
								<x-input id="pax" type="number" name="pax">Pax</x-input>
								<x-input id="hotel" type="text" name="hotel">Hotel</x-input>
							</div>
							<div class="col-6">
								<x-input id="arrival_code" type="text" name="flight_code[arrival_code]">Arrival Code</x-input>
								<x-input id="departure_code" type="text" name="flight_code[departure_code]">Departure Code</x-input>
								<x-input id="eta" type="datetime-local" name="flight_code[eta]">ETA</x-input>
								<x-input id="etd" type="datetime-local" name="flight_code[etd]">ETD</x-input>
								<div class="form-group">
									<label for="country">Bahasa</label>
									<select class="form-select" name="bahasa" id="bahasa" required>
										<option disabled selected>Pilih Bahasa</option>
										<?php foreach ($bahasas as $b): ?>
											<option value="<?=$b->id;?>"><?=$b->nama_bahasa;?> </option>
										<?php endforeach ?>
									</select>
								</div>
								<x-input id="remarks" type="text" name="remarks">Remarks</x-input>
							</div>
							<div class="col-12">
								<div class="d-flex align-items-center justify-content-between mt-2">
									<button class="btn btn-secondary" type="button" id="prev">Previous</button>
									<button type="submit" class="font-medium btn btn-light-success text-success waves-effect" id="btn">
										<span class="spinner-border spinner-border-sm d-none" id="btn-loading-spinner" role="status" aria-hidden="true"></span>
										Save
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{{-- </form> --}}
	</div>
</div>
</form> 
<x-loading-spinner id="loading-spinner"/>
@endsection
@section('js')
<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
	let selectedProducts = [];

	function handleCheckboxChange(event) {
		let produkId = event.target.value;

		if (event.target.checked) {
			selectedProducts.push(produkId);
		} else {
			selectedProducts = selectedProducts.filter(id => id !== produkId);
		}
	}

	$('#btnPilihProgram').click(function(){
		console.log(selectedProducts);

		if (selectedProducts.length === 0) { 
			showToastr('warning','Pilih setidaknya satu produk!','Warning');
		} else {
			$('#formPilihProgram').addClass('d-none');
			$('#formDataDiri').removeClass('d-none');

			setupFormSubmit('#create-paket-reservasi', '{{ route("reservasi.store") }}', null, 'Reservasi berhasil dibuat!', true, null);
		}
	});


	$('#prev').click(function(){
		$('#formDataDiri').addClass('d-none');
		$('#formPilihProgram').removeClass('d-none');
	});

</script>
@endsection