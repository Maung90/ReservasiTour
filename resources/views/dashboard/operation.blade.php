<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('title', 'Senang Tours & Travel - Dashboard')

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


<button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
  Update changes
</button>
<button type="button" class="btn btn-primary btn-add-event">
  Add Event
</button>
<input id="event-title" type="text" class="form-control" />
                                      <input id="event-start-date" type="text" class="form-control" />
                                      <input id="event-end-date" type="text" class="form-control" />




@endsection

@section('js')
<script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('assets/js/apps/calendar-init.js') }}"></script>
@endsection 