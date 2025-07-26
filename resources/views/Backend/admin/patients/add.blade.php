@extends('Backend.master')

@section('title' , 'Add New Patient')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Add New Patient</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('store_patient') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-sm-6">
                                <label>Patient Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                    </div>
                                <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control" id="clinic_id" name="clinic_id" required>
                                            <option value="" disabled selected hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
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
                                        <select class="form-control" id="specialty_id" name="specialty_id" required>
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
                                        <select class="form-control" id="doctor_id" name="doctor_id" required>
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
                                    <input class="form-control" type="email" id="email" name="email">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" id="password" name="password">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label>Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="address" name="address">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="" src="{{ asset('assets/img/user.jpg') }}">
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
                                            <input type="radio" id="gender" name="gender" class="form-check-input" value="male">Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" id="gender" name="gender" class="form-check-input" value="female">Female
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
                            <label>Short Biography </label>
                            <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" cols="30"></textarea>
                        </div>


                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Add Patient</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function isValidSelectValue(selectId) {      // هذا الميثود حتى أتجنب خداع الفيكفيار
            let val = $(`#${selectId}`).val();
            return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let date_of_birth = $('#date_of_birth').val().trim();
                let clinic_id = $('#clinic_id').val();
                let specialty_id = $('#specialty_id').val();
                let doctor_id = $('#doctor_id').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let confirm_password = $('#confirm_password').val();
                let phone = $('#phone').val().trim();
                let address = $('#address').val().trim();
                let appointment_time = $('#appointment_time').val();
                let appointment_day = $('#appointment_day').val();
                let gender = $('input[name="gender"]:checked').val();
                let short_biography = $('#short_biography').val().trim();
                let notes = $('#notes').val().trim();
                let image = document.querySelector('#image').files[0];



                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('specialty_id', specialty_id);
                formData.append('doctor_id', doctor_id);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('appointment_time', appointment_time);
                formData.append('appointment_day', appointment_day);
                formData.append('gender', gender);
                formData.append('short_biography', short_biography);
                formData.append('notes', notes);
                if (image) {
                    formData.append('image', image);
                }



                if (name == '' || date_of_birth == '' || email == '' || password == '' || confirm_password == '' ||phone == '' || address == '' || gender === undefined || !isValidSelectValue('clinic_id') || !isValidSelectValue('specialty_id') || !isValidSelectValue('doctor_id') || !isValidSelectValue('appointment_time') || !isValidSelectValue('appointment_day')) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;

                }else if (password !== confirm_password){
                    Swal.fire({
                        title: 'Error!',
                        text: 'The password does not match the confirmation password',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ route('store_patient') }}",
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
                                text: 'Email is already used by another person',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'The patient already exists but was added to the new clinic successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/add/patient';
                            });
                        } else if (response.data == 2) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Patient has been added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/add/patient';
                            });
                        }
                    }
                });
            }
        });
    });


    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        // إخفاء خيار "Select Clinic"
        $(this).find('option:first').hide();

        if (clinicId) {
            // جلب التخصصات من العيادة
            $.ajax({
                url: '/get-specialties-by-clinic/' + clinicId,
                type: 'GET',
                success: function (data) {
                    let specialtySelect = $('#specialty_id');
                    specialtySelect.empty().append('<option value="" disabled selected hidden>Select Specialty</option>');

                    let doctorSelect = $('#doctor_id');
                    doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                    $.each(data, function (key, specialty) {
                        specialtySelect.append('<option value="' + specialty.id + '">' + specialty.name + '</option>');
                    });
                }
            });
        }
    });

    $('#specialty_id').on('change', function () {
            var specialtyId = $(this).val();
            var clinicId = $('#clinic_id').val(); // مهم جداً

            if (specialtyId && clinicId) {
                $.ajax({
                    url: '/get-doctors-by-clinic-and-specialty',
                    type: 'GET',
                    data: {
                        clinic_id: clinicId,
                        specialty_id: specialtyId
                    },
                    success: function (data) {
                        let doctorSelect = $('#doctor_id');
                        doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                        $.each(data, function (key, doctor) {
                            doctorSelect.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                        });
                    }
                });
            }
        });


        $('#doctor_id').on('change', function () {
        // إخفاء خيار "Select Doctor"
        $(this).find('option:first').hide();
    });

    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: '/get-doctor-info/' + doctorId,
                type: 'GET',
                success: function (data) {
                    let startParts = data.work_start_time.split(':');
                    let endParts = data.work_end_time.split(':');

                    let startHour = parseInt(startParts[0]);
                    let startMinute = parseInt(startParts[1]);

                    let endHour = parseInt(endParts[0]);
                    let endMinute = parseInt(endParts[1]);

                    let appointmentSelect = $('#appointment_time');
                    appointmentSelect.empty().append('<option disabled selected hidden>Select Appointment Time</option>');

                    let current = new Date();
                    current.setHours(startHour, startMinute, 0, 0);

                    let end = new Date();
                    end.setHours(endHour, endMinute, 0, 0);

                    while (current <= end) {
                        let hh = current.getHours().toString().padStart(2, '0');
                        let mm = current.getMinutes().toString().padStart(2, '0');
                        let timeLabel = `${hh}:${mm}`;
                        appointmentSelect.append(`<option value="${timeLabel}:00">${timeLabel}</option>`);

                        // أضف 30 دقيقة
                        current.setMinutes(current.getMinutes() + 30);
                    }
                },
                error: function (xhr) {
                    console.error('Failed to fetch doctor times', xhr);
                    $('#appointment_time').html('<option value="">Could not load appointment times</option>');
                }
            });
        }
    });

    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: '/doctor-working-days/' + doctorId,
                type: 'GET',
                success: function (doctorDays) {
                    let daySelect = $('#appointment_day');


                    doctorDays.forEach(function(day) {
                        daySelect.append('<option value="' + day + '">' + day + '</option>');
                    });
                },
            });
        }
    });

    </script>
@endsection
