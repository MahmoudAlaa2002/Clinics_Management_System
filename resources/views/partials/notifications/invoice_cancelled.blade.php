@php
    $data = $notification->data;
@endphp

@if (auth()->user()->role === 'employee' && optional(auth()->user()->employee)->job_title === 'Accountant')
    The invoice for patient
    <strong>{{ $data['patient_name'] }}</strong>
    has been cancelled.
@endif
