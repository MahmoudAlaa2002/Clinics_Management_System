@php
    $data = $notification->data;
@endphp

@if (auth()->user()->role === 'patient')
    Your appointment that you booked with
    <strong>Dr. {{ $data['doctor_name'] }}</strong>
    at
    <strong>{{ $data['clinic_name'] }}</strong>
    has been accepted.
@endif
