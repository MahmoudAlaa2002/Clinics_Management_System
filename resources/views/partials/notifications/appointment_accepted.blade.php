@php
    $data = $notification->data;
    $user = auth()->user();

    $actorRole = $data['actor_role'] ?? null;
    $actorName = $data['actor_name'] ?? 'Staff';
@endphp

@if($user->role === 'patient')

    @if($actorRole === 'employee')
        Your appointment at
        <strong>{{ $data['clinic_name'] }}</strong>
        has been confirmed by the reception desk.
    @elseif($actorRole === 'doctor')
        Your appointment with
        <strong>Dr. {{ $data['doctor_name'] }}</strong>
        at
        <strong>{{ $data['clinic_name'] }}</strong>
        has been accepted by the doctor.
    @endif

@endif
