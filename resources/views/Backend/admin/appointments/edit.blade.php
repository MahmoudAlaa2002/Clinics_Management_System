@extends('Backend.admin.master')

@section('title' , 'Edit Appointment')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    input[type="date"], input[type="time"] { direction: ltr; text-align: left; }

    .card {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
        overflow: hidden !important;
    }

    .card-header {
        background-color: #00A8FF !important;
        color: #fff !important;
        font-weight: 600 !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        border-bottom: 1px solid #ddd !important;
    }

    .card-body {
        background-color: #fff;
        padding: 20px;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Appointment</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('update_appointment', ['id' => $appointment->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Appointment Info -->
                    <div class="card">
                        <div class="card-header">Appointment Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id">
                                            <option value="" disabled hidden>Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ $patient->id == $appointment->patient_id ? 'selected' : '' }}>
                                                    {{ $patient->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Assigned to Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control" id="clinic_id" name="clinic_id">
                                            <option value="" disabled hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ $clinic->id == $appointment->clinic_id ? 'selected' : '' }}>
                                                    {{ $clinic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Assigned to Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="" disabled selected hidden>Select Department</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Assigned to Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select class="form-control" id="doctor_id" name="doctor_id">
                                            <option value="" disabled selected hidden>Select Doctor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Doctor's Appointment <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select name="appointment_time" id="appointment_time" class="form-control">
                                            <option value="" disabled selected hidden>Select Appointment Time</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Appointment Day <span class="text-danger">*</span></label>
                                    <select name="appointment_day" id="appointment_day" class="form-control">
                                        <option value="" disabled selected hidden>Select Day</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-3 card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="px-5 btn btn-primary submit-btn editBtn rounded-pill" style="text-transform: none !important;">
                            Edit Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')

    @php
        $appointmentDate = $appointment->date ?? null;
        $appointmentDay = $appointmentDate ? \Carbon\Carbon::parse($appointmentDate)->format('l') : '';
        $selectedTime = $appointment->time ?? '';
    @endphp

    <script>
        function isValidSelectValue(selectId) {
            let val = $(`#${selectId}`).val();
            return val && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        function loadDoctors(clinicId, departmentId, selectedDoctorId = '') {
            $('#doctor_id').empty().append('<option value="" disabled hidden>Select Doctor</option>');
            if (clinicId && departmentId) {
                $.get('/admin/get-doctors-by-clinic-and-department', { clinic_id: clinicId, department_id: departmentId }, function (doctors) {
                    doctors.forEach(function (doctor) {
                        $('#doctor_id').append(`<option value="${doctor.id}" ${doctor.id == selectedDoctorId ? 'selected' : ''}>${doctor.name}</option>`);
                    });
                    if (selectedDoctorId) loadDoctorData(selectedDoctorId);
                });
            }
        }

        function loadDoctorData(doctorId) {
            // Load working hours
            $.get('/admin/get-doctor-info/' + doctorId, function (data) {
                let appointmentSelect = $('#appointment_time');
                appointmentSelect.empty().append('<option disabled selected hidden>Select Appointment Time</option>');

                let [startHour, startMinute] = data.work_start_time.split(':').map(Number);
                let [endHour, endMinute] = data.work_end_time.split(':').map(Number);

                let current = new Date();
                current.setHours(startHour, startMinute, 0, 0);
                let end = new Date();
                end.setHours(endHour, endMinute, 0, 0);

                let selectedTime = "{{ $selectedTime }}";

                while (current <= end) {
                    let hh = String(current.getHours()).padStart(2, '0');
                    let mm = String(current.getMinutes()).padStart(2, '0');
                    let time = `${hh}:${mm}:00`;
                    appointmentSelect.append(`<option value="${time}" ${time === selectedTime ? 'selected' : ''}>${hh}:${mm}</option>`);
                    current.setMinutes(current.getMinutes() + 30);
                }
            });

            // Load working days
            $.get('/admin/doctor-working-days/' + doctorId, function (doctorDays) {
                let daySelect = $('#appointment_day');
                daySelect.empty().append('<option value="" disabled hidden>Select Day</option>');

                const selectedDay = "{{ $appointmentDay }}";

                doctorDays.forEach(function(day) {
                    const selected = (day === selectedDay) ? 'selected' : '';
                    daySelect.append(`<option value="${day}" ${selected}>${day}</option>`);
                });
            });
        }

        $(document).ready(function () {
            let currentClinicId = "{{ $appointment->clinicDepartment->clinic_id ?? '' }}";
            let selectedDepartmentId = "{{ $appointment->clinicDepartment->department_id ?? '' }}";
            let selectedDoctorId = "{{ $appointment->doctor_id ?? '' }}";

            // Load departments
            $.get('/admin/get-departments-by-clinic/' + currentClinicId, function (departments) {
                let departmentSelect = $('#department_id');
                departmentSelect.empty().append('<option value="" disabled hidden>Select Department</option>');
                departments.forEach(function (department) {
                    departmentSelect.append(`<option value="${department.id}" ${department.id == selectedDepartmentId ? 'selected' : ''}>${department.name}</option>`);
                });
                if (selectedDepartmentId) loadDoctors(currentClinicId, selectedDepartmentId, selectedDoctorId);
            });

            $('#clinic_id').on('change', function () {
                let clinicId = $(this).val();
                $('#department_id').empty().append('<option value="" disabled selected hidden>Select Department</option>');
                $('#doctor_id').empty().append('<option value="" disabled selected hidden>Select Doctor</option>');
                $.get('/admin/get-departments-by-clinic/' + clinicId, function (departments) {
                    departments.forEach(function (department) {
                        $('#department_id').append(`<option value="${department.id}">${department.name}</option>`);
                    });
                });
            });

            $('#department_id').on('change', function () {
                let clinicId = $('#clinic_id').val();
                let departmentId = $(this).val();
                loadDoctors(clinicId, departmentId);
            });

            $('#doctor_id').on('change', function () {
                let doctorId = $(this).val();
                if (doctorId) loadDoctorData(doctorId);
            });

            $('.editBtn').click(function (e) {
                e.preventDefault();

                let formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('patient_id', $('#patient_id').val());
                formData.append('clinic_id', $('#clinic_id').val());
                formData.append('department_id', $('#department_id').val());
                formData.append('doctor_id', $('#doctor_id').val());
                formData.append('appointment_time', $('#appointment_time').val());
                formData.append('appointment_day', $('#appointment_day').val());
                formData.append('notes', $('#notes').val().trim());

                if (!isValidSelectValue('patient_id') || !isValidSelectValue('clinic_id') || !isValidSelectValue('department_id') ||
                    !isValidSelectValue('doctor_id') || !isValidSelectValue('appointment_time') || !isValidSelectValue('appointment_day')) {
                    Swal.fire('Error!', 'Please Enter All Required Fields', 'error');
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_appointment', ['id' => $appointment->id]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if (response.data == 0) {
                            Swal.fire('Error!', 'This Appointment Slot Is Already Booked', 'error');
                        } else if (response.data == 1) {
                            Swal.fire('Success', 'Appointment Updated Successfully', 'success').then(() => {
                                window.location.href = '/admin/view/appointments';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
