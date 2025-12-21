@php
    $data = $notification->data;
    $user = auth()->user();
    $role = $user->role;

    $jobTitle = optional($user->employee)->job_title;
@endphp

@if ($role === 'employee' && $jobTitle === 'Accountant')
    A new <strong>
    @if ($data['payment_status'] === 'Paid')
        Paid
    @elseif ($data['payment_status'] === 'Partially Paid')
        Partially Paid
    @else
        Unpaid
    @endif
    invoice</strong> has been created for patient
    <strong>{{ $data['patient_name'] }}</strong>.
@endif
