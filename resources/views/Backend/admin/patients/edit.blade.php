@extends('Backend.master')

@section('title' , 'Edit Patient')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Edit Patient</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('update_patient' , ['id' => $patient->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-sm-6">
                                <label>Patient Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                    </div>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $patient->name }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ $patient->user->date_of_birth }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select id="clinic_id" name="clinic_id" class="form-control">
                                            <option value="" disabled hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ (int)$patient->clinic_id === (int)$clinic->id ? 'selected' : '' }}>
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
                                <label>Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ $patient->user->email }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password (optional)">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter new confirm password (optional)">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $patient->user->phone }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="address" name="address" value="{{ $patient->user->address }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="patient image" src="{{ asset($user->user->image ?? 'assets/img/user.jpg') }}">
                                        </div>
                                        <div class="upload-input">
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group gender-select">
                                    <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" id="gender" name="gender" class="form-check-input" value="male" {{ $patient->user->gender == 'male' ? 'checked' : '' }}>Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" id="gender" name="gender" class="form-check-input" value="female" {{ $patient->user->gender == 'female' ? 'checked' : '' }}>Female
                                        </label>
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
                                    <select name="appointment_day" id="appointment_day" class="form-control" required>
                                        <option value="" disabled selected hidden>Select Day</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Short Biography <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30">{{ $patient->user->short_biography }}</textarea>
                        </div>

                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Patient</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @php
        $appointmentDate = $patient->appointments->last()->appointment_date ?? null;
        $appointmentDay = $appointmentDate ? \Carbon\Carbon::parse($appointmentDate)->format('l') : '';
        $selectedTime = old('appointment_time', $patient->appointments->last()->appointment_time ?? '');
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
        let currentClinicId = "{{ $patient->clinics->first()->id ?? '' }}";
        let selectedSpecialtyId = "{{ $patient->specialties->first()->id ?? '' }}";
        let selectedDoctorId = "{{ $patient->doctors->first()->id ?? '' }}";

        
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
            formData.append('name', $('#name').val().trim());
            formData.append('date_of_birth', $('#date_of_birth').val().trim());
            formData.append('clinic_id', $('#clinic_id').val());
            formData.append('specialty_id', $('#specialty_id').val());
            formData.append('doctor_id', $('#doctor_id').val());
            formData.append('email', $('#email').val());
            formData.append('password', $('#password').val());
            formData.append('confirm_password', $('#confirm_password').val());
            formData.append('phone', $('#phone').val().trim());
            formData.append('address', $('#address').val().trim());
            formData.append('appointment_time', $('#appointment_time').val());
            formData.append('appointment_day', $('#appointment_day').val());
            formData.append('gender', $('input[name="gender"]:checked').val());
            formData.append('short_biography', $('#short_biography').val().trim());

            let image = document.querySelector('#image').files[0];
            if (image) formData.append('image', image);



            if (
                !formData.get('name') || !formData.get('date_of_birth') || !formData.get('email') ||
                !formData.get('phone') || !formData.get('address') || !formData.get('gender') ||
                !isValidSelectValue('clinic_id') || !isValidSelectValue('specialty_id') ||
                !isValidSelectValue('doctor_id') || !isValidSelectValue('appointment_day')
            ) {
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
                url: "{{ route('update_patient', ['id' => $patient->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.data == 0){
                        Swal.fire({
                            title: 'Success',
                            text: 'The Patient Already Exists, But The Data Was Updated Successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else if(response.data == 1){
                        Swal.fire({
                            title: 'Success',
                            text: 'Patient Has Been Updated Successfully',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => window.location.href = '/view/patients');
                    }
                }
            });
        });
    });
</script>
@endsection
