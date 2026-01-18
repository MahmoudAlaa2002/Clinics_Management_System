@php
    $data = $notification->data;

    $role = auth()->user()->role;

    $cancelledBy = $data['cancelled_by'] ?? null;    // doctor | patient | receptionist

    $patientName = $data['patient_name'] ?? 'the patient';
    $doctorName  = $data['doctor_name'] ?? 'the doctor';
@endphp


{{-- ================= DOCTOR ================= --}}
@if ($role === 'doctor')
    @if ($cancelledBy === 'patient')
        <strong>{{ $patientName }}</strong>
        cancelled the appointment.
    @elseif ($cancelledBy === 'receptionist')
        The receptionist cancelled your appointment with
        <strong>{{ $patientName }}</strong>.
    @else
        An appointment has been cancelled.
    @endif


{{-- ================= PATIENT ================= --}}
@elseif ($role === 'patient')
    @if ($cancelledBy === 'doctor')
        Dr. <strong>{{ $doctorName }}</strong> cancelled your appointment.
    @elseif ($cancelledBy === 'receptionist')
        Your appointment with
        <strong>{{ $doctorName }}</strong>
        was cancelled by the receptionist.
    @else
        Your appointment has been cancelled.
    @endif


{{-- ================= RECEPTIONIST (employee) ================= --}}
@elseif ($role === 'employee' && optional(auth()->user()->employee)->job_title === 'Receptionist')
    @if ($cancelledBy === 'patient')
        <strong>{{ $patientName }}</strong>
        cancelled the appointment.
    @elseif ($cancelledBy === 'doctor')
        Dr. <strong>{{ $doctorName }}</strong>
        cancelled the appointment for patient
        <strong>{{ $patientName }}</strong>.
    @else
        An appointment has been cancelled.
    @endif
@endif
