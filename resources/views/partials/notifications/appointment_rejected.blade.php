@php
    $data = $notification->data;
@endphp

@if (auth()->user()->role === 'patient')
    Your appointment request with
    <strong>Dr. {{ $data['doctor_name'] }}</strong>
    at
    <strong>{{ $data['clinic_name'] }}</strong>
    has been rejected.
@endif
