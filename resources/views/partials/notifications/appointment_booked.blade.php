@php
    $data  = $notification->data;
    $user  = auth()->user();
    $role  = $user->role;
    $actor = $data['created_by_role'] ?? null;

    $jobTitle = optional($user->employee)->job_title;
@endphp

@if ($role === 'admin')
    @if ($actor === 'patient')
        A patient <strong>{{ $data['patient_name'] }}</strong> booked a new appointment.
    @elseif ($actor === 'receptionist')
        A receptionist booked a new appointment for
        <strong>{{ $data['patient_name'] }}</strong>.
    @else
        A new appointment has been booked for
        <strong>{{ $data['patient_name'] }}</strong>.
    @endif

@elseif ($role === 'doctor')
    You have a new appointment with
    <strong>{{ $data['patient_name'] }}</strong>.

@elseif ($role === 'clinic_manager')
    A new appointment has been booked in your clinic for
    <strong>{{ $data['patient_name'] ?? '' }}</strong>.

@elseif ($role === 'department_manager')
    A new appointment has been booked in your department for
    <strong>{{ $data['patient_name'] ?? '' }}</strong>.

@elseif ($role === 'employee' && $jobTitle === 'Receptionist')
    A new appointment has been booked for
    <strong>{{ $data['patient_name'] }}</strong>.
@endif
