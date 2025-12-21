@php
    $data = $notification->data;
@endphp

@if (auth()->user()->role === 'doctor')
    Nurse
    <strong>{{ $data['nurse_name'] }}</strong>
    has completed the assigned task
    for patient
    <strong>{{ $data['patient_name'] }}</strong>.
@endif
