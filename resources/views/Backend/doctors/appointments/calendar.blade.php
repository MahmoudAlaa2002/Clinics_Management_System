@extends('Backend.doctors.master')

@section('title', 'Appointments Calendar')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <h4 class="mb-4">Appointments Calendar</h4>

        <div id="calendar"></div>

    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let appointments = {!! $appointmentsJson !!};

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 800,
        editable: false,
        selectable: false,
        eventClick: function(info) {
            alert(
                "Patient: " + info.event.title +
                "\nStatus: " + info.event.extendedProps.status +
                "\nNotes: " + info.event.extendedProps.notes
            );
        },
        events: appointments
    });

    calendar.render();
});
</script>

@endsection
