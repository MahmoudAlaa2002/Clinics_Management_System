@php
    $data = $notification->data;
    $user = auth()->user();
    $role = $user->role;

    $jobTitle = optional($user->employee)->job_title;
@endphp

@if ($role === 'employee' && $jobTitle === 'Nurse')
    You have been assigned a task by Dr. <strong>{{ $data['doctor_name'] }}</strong>.
@endif
