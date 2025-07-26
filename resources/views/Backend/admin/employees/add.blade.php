@extends('Backend.master')

@section('title' , 'Add New Employee')


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
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Employee</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_employee') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Employee Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
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
                            <div class="form-group">
                                <label>Job Title <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-badge"></i></span>
                                    </div>
                                    <select id="job_title_id" name="job_title_id" class="form-control">
                                        <option disabled selected hidden>Select Job Title</option>
                                        @foreach($jobTitles as $jobTitle)
                                            <option value="{{ $jobTitle->id }}">{{ $jobTitle->name }}</option>
                                        @endforeach
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
                    </div>

                    <div class="form-group">
                        <label>Short Biography </label>
                        <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30"></textarea>
                    </div>


                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_active" value="active" checked>
                            <label class="form-check-label" for="employee_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_inactive" value="inactive">
                            <label class="form-check-label" for="employee_inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Add Employee</button>
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
                let job_title_id = $('#job_title_id').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let confirm_password = $('#confirm_password').val();
                let phone = $('#phone').val().trim();
                let address = $('#address').val().trim();
                let gender = $('input[name="gender"]:checked').val();
                let short_biography = $('#short_biography').val().trim();
                let status = $('input[name="status"]:checked').val();
                let image = document.querySelector('#image').files[0];


                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('specialty_id', specialty_id);
                formData.append('job_title_id', job_title_id);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('gender', gender);
                formData.append('short_biography', short_biography);
                formData.append('status', status);
                if (image) {
                    formData.append('image', image);
                }

                if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || !isValidSelectValue('specialty_id') || !isValidSelectValue('job_title_id') || email === '' || password === '' || confirm_password === '' || phone === '' ||address === '' || gender === undefined) {
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
                    url: "{{ route('store_employee') }}",
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
                                text: 'This Employee Already Exists',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Employee has been added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/add/employee';
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
    </script>
@endsection
