@extends('Backend.master')

@section('title' , 'Edit Employee')


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
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Employee</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_employee' , ['id' => $employee->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Employee Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                              <input type="text" class="form-control" id="name" name="name" value="{{ $employee->user->name }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ $employee->user->date_of_birth }}">
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
                                            <option value="{{ $clinic->id }}" {{ $employee->clinic_id == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Department <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                    </div>
                                    <select id="department_id" name="department_id" class="form-control">
                                        <option disabled selected hidden>Select Department</option>
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
                                            <option value="{{ $jobTitle->id }}" {{ $employee->job_title_id == $jobTitle->id ? 'selected' : '' }}>{{ $jobTitle->name }}</option>
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
                                <input class="form-control" type="email" id="email" name="email" value="{{ $employee->user->email }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Enter new password (optional)">
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
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->user->phone }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                </div>
                                <input class="form-control" type="text" id="address" name="address" value="{{ $employee->user->address }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Avatar</label>
                                <div class="profile-upload">
                                    <div class="upload-img">
                                        <img alt="" src="{{ asset($employee->user->image ?? 'assets/img/user.jpg') }}">
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
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="male" {{ $employee->user->gender == 'male' ? 'checked' : '' }}>Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="female" {{ $employee->user->gender == 'female' ? 'checked' : '' }}>Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Short Biography </label>
                        <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30">{{ $employee->short_biography }}</textarea>
                    </div>


                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_active" value="active" checked {{ $employee->status == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="employee_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_inactive" value="inactive" {{ $employee->status == 'inactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="employee_inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Employee</button>
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
                let department_id = $('#department_id').val();
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
                formData.append('_method', 'PUT');
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('department_id', department_id);
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

                if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || !isValidSelectValue('department_id') || !isValidSelectValue('job_title_id') || email === '' || phone === '' ||address === '' || gender === undefined) {
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
                        text: 'The Password Does Not Match The Confirmation Password',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ Route('update_employee' , ['id' => $employee->id]) }}",
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
                                text: 'Employee Has Been Edited Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin/view/employees';
                            });
                        }
                    }
                });
            }
        });

        let currentClinicId = $('#clinic_id').val();
        let selectedDepartmentId = "{{ $employee->department_id }}";

        if (currentClinicId) {
            $.ajax({
                url: '/admin/get-departments-by-clinic/' + currentClinicId,
                type: 'GET',
                success: function (data) {
                    let departmentSelect = $('#department_id');
                    departmentSelect.empty().append('<option value="" disabled hidden>Select Department</option>');

                    $.each(data, function (index, department) {
                        let selected = department.id == selectedDepartmentId ? 'selected' : '';
                        departmentSelect.append('<option value="' + department.id + '" ' + selected + '>' + department.name + '</option>');
                    });
                }
            });
        }
    });

    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        if (clinicId) {
            $.ajax({
                url: '/admin/get-departments-by-clinic/' + clinicId,
                type: 'GET',
                success: function (data) {
                    let departmentSelect = $('#department_id');
                    departmentSelect.empty().append('<option value="" disabled selected hidden>Select Department</option>');

                    $.each(data, function (index, department) {
                        departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                }
            });
        }
    });
    </script>
@endsection
