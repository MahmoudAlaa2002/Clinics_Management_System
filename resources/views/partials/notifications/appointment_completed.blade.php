@php
    $data = $notification->data;
    $role = auth()->user()->role;

    $patientName = $data['patient_name'] ?? '';
    $doctorName  = $data['doctor_name'] ?? '';
@endphp


{{-- 👩‍⚕️ Nurse --}}
@if (
    $role === 'employee' &&
    optional(auth()->user()->employee)->job_title === 'Nurse'
)
    The appointment for
    <strong>{{ $patientName }}</strong>
    has been successfully completed.

{{-- 👤 Patient --}}
@elseif ($role === 'patient')
    Your appointment with
    Dr. <strong>{{ $doctorName }}</strong>
    has been completed successfully.
@endif
