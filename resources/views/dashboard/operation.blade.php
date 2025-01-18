{{-- @dd(session()->all()); --}}
<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Dashboard')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
<style>
  /* Tambahkan gaya khusus untuk modal yang muncul dari kanan */
  .modal.right .modal-dialog {
    position: fixed;
    margin: 0;
    width: 400px;
    height: 98%;
    right: 0;
    top: 3;
    bottom: 0;
    transform: translate3d(100%, 0, 0);
    transition: transform 0.3s ease-out;
  }
  .modal.right .modal-content {
    height: 100%;
/*    overflow-y: auto;*/
}
.modal.right.show .modal-dialog {
  transform: translate3d(0, 0, 0);
}
</style>
@endsection

@section('content') 

<div class="container-fluid">
  <div class="card">
    <div>
      <div class="row gx-0">
        <div class="col-lg-12">
          <div class="p-4 calender-sidebar app-calendar">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- tutup modal update reservasi -->
<x-modal id="edit-modal" labelId="editLabel" title="Edit Reservasi" formId="edit-reservasi" method="PUT" size="modal-lg">
 @csrf
 @method('PUT')
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


@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<script src="{{ asset('assets/js/crud/crud.js')}}"></script>
<script>
  $(document).ready(function() {

    $('#calendar').fullCalendar({
      events: "/reservasi/all/",
      eventClick: function(event) {
        let id = event.id;
        $('#edit-reservasi').data('id', id);

        $('#form-edit').addClass('d-none');
        $('#loading-modal-edit').removeClass('d-none');

        $.ajax({
          url: '{{ route("reservasi.get", ":id") }}'.replace(':id', id),
          type: 'GET',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
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
      }
    });


    setupFormSubmit('#edit-reservasi', '{{ route("reservasi.update", ":id") }}', null, 'Reservasi updated successfully!',false, '#edit-modal');
  });
</script>
@endsection 