@extends('Backend.master')

@section('title' , 'Add New Doctor')


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
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Doctor</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_doctor') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Doctor Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
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
                                <label>Clinic Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                    </div>
                                    <select id="clinic_id" name="clinic_id" class="form-control">
                                        <option disabled selected hidden>Select Clinic</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Specialty <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                    </div>
                                    <select id="specialty_id" name="specialty_id" class="form-control">
                                        <option disabled selected hidden>Select Specialty</option>
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
                            <div class="form-group">
                                <label>Work Start Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <select name="work_start_time" id="work_start_time" class="form-control">
                                        <option disabled selected hidden>Select Start Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Work End Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>

                                    <select name="work_end_time" id="work_end_time" class="form-control">
                                        <option disabled selected hidden>Select End Time</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Working Days <span class="text-danger">*</span></label>
                                <div class="row gx-1">
                                    @php
                                        $all_days = [
                                            'Saturday', 'Sunday', 'Monday', 'Tuesday',
                                            'Wednesday', 'Thursday', 'Friday'
                                        ];
                                    @endphp

                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 0, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}">
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
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
                    </div>

                    <div class="form-group">
                        <label>Short Biography </label>
                        <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30"></textarea>
                    </div>


                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active" checked>
                            <label class="form-check-label" for="doctor_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive">
                            <label class="form-check-label" for="doctor_inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Add Doctor</button>
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
                let email = $('#email').val();
                let password = $('#password').val();
                let confirm_password = $('#confirm_password').val();
                let phone = $('#phone').val().trim();
                let address = $('#address').val().trim();
                let work_start_time = $('#work_start_time').val();
                let work_end_time = $('#work_end_time').val();

                let gender = $('input[name="gender"]:checked').val();
                let short_biography = $('#short_biography').val().trim();
                let status = $('input[name="status"]:checked').val();
                let image = document.querySelector('#image').files[0];

                let workingDays = [];
                $('input[name="working_days[]"]:checked').each(function () {
                    workingDays.push($(this).val());
                });


                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('specialty_id', specialty_id);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('work_start_time', work_start_time);
                formData.append('work_end_time', work_end_time);
                formData.append('gender', gender);
                formData.append('short_biography', short_biography);
                formData.append('status', status);
                if (image) {
                    formData.append('image', image);
                }

                workingDays.forEach(function (day) {
                    formData.append('working_days[]', day);
                });

                if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || !isValidSelectValue('specialty_id')  || email === '' || password === '' || confirm_password === '' || phone === '' || address === '' || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') || gender === undefined  || $('input[name="working_days[]"]:checked').length === 0) {
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
                    url: "{{ route('store_doctor') }}",
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
                                text: 'This Doctor Already Exists',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Doctor has been added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/add/doctor';
                            });
                        }
                    }
                });
            }
        });
    });

    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        if (clinicId) {
            $.ajax({
                url: '/get-specialties-by-clinic/' + clinicId,
                type: 'GET',
                success: function (data) {
                    let specialtySelect = $('#specialty_id');
                    specialtySelect.empty().append('<option value="" disabled selected hidden>Select Specialty</option>');

                    $.each(data, function (index, specialty) {
                        specialtySelect.append('<option value="' + specialty.id + '">' + specialty.name + '</option>');
                    });
                }
            });
        }
    });

    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        if (clinicId) {
            $.ajax({
                url: '/get-clinic-info/' + clinicId,
                type: 'GET',
                success: function (data) {
                    // توليد الساعات داخل select
                    let start = parseInt(data.opening_time.split(':')[0]);
                    let end = parseInt(data.closing_time.split(':')[0]);

                    let workStartSelect = $('#work_start_time');
                    let workEndSelect = $('#work_end_time');

                    workStartSelect.empty().append('<option disabled selected hidden>Select Start Time</option>');
                    workEndSelect.empty().append('<option disabled selected hidden>Select End Time</option>');

                    for (let h = start; h <= end; h++) {
                        let timeLabel = (h < 10 ? '0' + h : h) + ':00';
                        workStartSelect.append(`<option value="${h}:00:00">${timeLabel}</option>`);
                        workEndSelect.append(`<option value="${h}:00:00">${timeLabel}</option>`);
                    }
                }
            });
        }
    });

    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        if (clinicId) {
            $.ajax({
                url: '/clinic-working-days/' + clinicId,
                type: 'GET',
                success: function (clinicDays) {
                    const allDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];

                    allDays.forEach(day => {
                        const checkbox = $('#day_' + day);
                        if (clinicDays.includes(day)) {
                            checkbox.prop('disabled', false);
                        } else {
                            checkbox.prop('disabled', true).prop('checked', false);
                        }
                    });
                }
            });
        }
    });
    </script>
@endsection
