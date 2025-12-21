@php
    $data = $notification->data;
    $user = auth()->user();

    $actorRole = $data['actor_role'] ?? null;
    $actorName = $data['actor_name'] ?? 'Staff';
@endphp

@if ($user->role === 'admin')

    @if ($actorRole === 'clinic_manager')
        A patient account for
        <strong>{{ $data['patient_name'] }}</strong>
        was added by the clinic manager
        <strong>{{ $actorName }}</strong>.
    @elseif ($actorRole === 'employee')
        A patient account for
        <strong>{{ $data['patient_name'] }}</strong>
        was added by the receptionist
        <strong>{{ $actorName }}</strong>.
    @endif

@elseif ($user->role === 'employee' && optional($user->employee)->job_title === 'Receptionist')

    A new patient account for
    <strong>{{ $data['patient_name'] }}</strong>
    was added by the clinic manager
    <strong>{{ $actorName }}</strong>.

@elseif ($user->role === 'clinic_manager')

    A new patient account for
    <strong>{{ $data['patient_name'] }}</strong>
    was added by the receptionist
    <strong>{{ $actorName }}</strong>.

@endif
