@php
    $data = $notification->data;
    $user = auth()->user();
@endphp

@if ($user->role === 'admin')
    A patient account has been created for
    <strong>{{ $data['patient_name'] }}</strong>.
@endif
