@extends('Backend.master')

@section('title' , 'Edit Appointment')

@section('content')

    <style>

        .col-sm-6 {
            margin-bottom: 20px;
        }

        input[type="date"] {
            direction: ltr;
            text-align: left;
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
                    <form method="POST" action="{{ Route('update_appointment' , ['id' => $appointment->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id" required>
                                            <option value="" disabled hidden>Select Patient</option>
                                            @php
                                                $selectedPatientId = old('patient_id', $appointment->patient_id ?? null);
                                            @endphp
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ $patient->id == $selectedPatientId ? 'selected' : '' }}>
                                                    {{ $patient->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select id="clinic_id" name="clinic_id" class="form-control" required>
                                            <option value="" disabled hidden>Select Clinic</option>
                                            @php
                                                $selectedClinicId = old('clinic_id', $patient->clinics->first()->id ?? null);
                                            @endphp
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ (int)$clinic->id === (int)$selectedClinicId ? 'selected' : '' }}>
                                                    {{ $clinic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Specialty <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select id="specialty_id" name="specialty_id" class="form-control">
                                            <option value="" disabled selected hidden>Select Specialty</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select id="doctor_id" name="doctor_id" class="form-control">
                                            <option value="" disabled selected hidden>Select Doctor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
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
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="appointment_day">Appointment Day <span class="text-danger">*</span></label>
                                    <select name="appointment_day" id="appointment_day" class="form-control">
                                        <option value="" disabled selected hidden>Select Day</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" cols="30">{{ $appointment->notes }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')

@php
    $appointmentDate = $appointment->appointment_date ?? null;
    $appointmentDay = $appointmentDate ? \Carbon\Carbon::parse($appointmentDate)->format('l') : '';
    $selectedTime = old('appointment_time', $appointment->appointment_time ?? '');
@endphp

<script>
    function isValidSelectValue(selectId) {
        let val = $(`#${selectId}`).val();
        return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
    }

    function loadDoctors(clinicId, specialtyId, selectedDoctorId = '') {
        $('#doctor_id').empty().append('<option value="" disabled hidden>Select Doctor</option>');
        if (clinicId && specialtyId) {
            $.get('/get-doctors-by-clinic-and-specialty', {
                clinic_id: clinicId,
                specialty_id: specialtyId
            }, function (doctors) {
                doctors.forEach(function (doctor) {
                    $('#doctor_id').append(`<option value="${doctor.id}" ${doctor.id == selectedDoctorId ? 'selected' : ''}>${doctor.name}</option>`);
                });
                if (selectedDoctorId) loadDoctorData(selectedDoctorId);
            });
        }
    }

    function loadDoctorData(doctorId) {
        // Load working hours
        $.get('/get-doctor-info/' + doctorId, function (data) {
            let appointmentSelect = $('#appointment_time');
            appointmentSelect.empty().append('<option disabled selected hidden>Select Appointment Time</option>');

            let current = new Date();
            let end = new Date();

            let [startHour, startMinute] = data.work_start_time.split(':').map(Number);
            let [endHour, endMinute] = data.work_end_time.split(':').map(Number);

            current.setHours(startHour, startMinute, 0, 0);
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
        $.get('/doctor-working-days/' + doctorId, function (doctorDays) {
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
        let currentClinicId = "{{ $appointment->clinic_id ?? '' }}";
        let selectedSpecialtyId = "{{ $appointment->specialty_id ?? '' }}";
        let selectedDoctorId = "{{ $appointment->doctor_id ?? '' }}";

        // Set initial clinic
        $('#clinic_id').val(currentClinicId);

        // Load specialties
        $.get('/get-specialties-by-clinic/' + currentClinicId, function (specialties) {
            let specialtySelect = $('#specialty_id');
            specialtySelect.empty().append('<option value="" disabled hidden>Select Specialty</option>');

            specialties.forEach(function (specialty) {
                specialtySelect.append(`<option value="${specialty.id}" ${specialty.id == selectedSpecialtyId ? 'selected' : ''}>${specialty.name}</option>`);
            });

            // Load doctors if specialty selected
            if (selectedSpecialtyId) loadDoctors(currentClinicId, selectedSpecialtyId, selectedDoctorId);
        });

        // On change clinic
        $('#clinic_id').on('change', function () {
            let clinicId = $(this).val();
            $('#specialty_id').empty().append('<option value="" disabled selected hidden>Select Specialty</option>');
            $('#doctor_id').empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

            $.get('/get-specialties-by-clinic/' + clinicId, function (specialties) {
                specialties.forEach(function (specialty) {
                    $('#specialty_id').append(`<option value="${specialty.id}">${specialty.name}</option>`);
                });
            });
        });

        // On change specialty
        $('#specialty_id').on('change', function () {
            let clinicId = $('#clinic_id').val();
            let specialtyId = $(this).val();
            loadDoctors(clinicId, specialtyId);
        });

        // On change doctor
        $('#doctor_id').on('change', function () {
            let doctorId = $(this).val();
            if (doctorId) loadDoctorData(doctorId);
        });

        // On submit
        $('.addBtn').click(function (e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('patient_id', $('#patient_id').val());
            formData.append('clinic_id', $('#clinic_id').val());
            formData.append('specialty_id', $('#specialty_id').val());
            formData.append('doctor_id', $('#doctor_id').val());
            formData.append('appointment_time', $('#appointment_time').val());
            formData.append('appointment_day', $('#appointment_day').val());
            formData.append('notes', $('#notes').val().trim());



            if (!isValidSelectValue('patient_id') || !isValidSelectValue('clinic_id') || !isValidSelectValue('specialty_id') ||
                !isValidSelectValue('doctor_id') || !isValidSelectValue('appointment_time') || !isValidSelectValue('appointment_day')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter All Required Fields',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                method: 'POST',
                url: "{{ route('update_appointment', ['id' => $appointment->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.data == 0) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'The appointment has already been booked',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }else if (response.data == 1) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Appointment has been updated successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '/view/appointments';
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
