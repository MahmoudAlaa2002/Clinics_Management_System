@extends('Backend.clinics_managers.master')

@section('title', 'Edit Doctor')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 20px; }
    input[type="date"] { direction: ltr; text-align: left; }
    .card { border: 1px solid #ddd !important; border-radius: 8px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; overflow: hidden !important; }
    .card-header { background-color: #00A8FF !important; color: #fff !important; font-weight: 600 !important; padding: 12px 15px !important; font-size: 16px !important; border-bottom: 1px solid #ddd !important; }
    .card-body { background-color: #fff; padding: 20px; }
    .small-gutter > [class^="col-"] {
        padding-left: 30px !important;
        margin-top: 15px !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom:30px;">Edit Doctor</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="editEmployeeForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Doctor Information --}}
                    <div class="card">
                        <div class="card-header">Doctor Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Doctor Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->employee->user->name }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $doctor->employee->user->date_of_birth }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $doctor->employee->user->phone }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $doctor->employee->user->email }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="password" placeholder="New password (optional)">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $doctor->employee->user->address }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="" src="{{ $doctor->employee->user->image ? asset('storage/' . $doctor->employee->user->image) : asset('assets/img/user.jpg') }}">
                                        </div>
                                        <div class="upload-input">
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group gender-select">
                                        <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="male" {{ $doctor->employee->user->gender == 'male' ? 'checked' : '' }}> Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="female" {{ $doctor->employee->user->gender == 'female' ? 'checked' : '' }}> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Work Assignment --}}
                    <div class="card">
                        <div class="card-header">Work Assignment</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Clinic</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $clinic->name }}" readonly>
                                        <input type="hidden" id="clinic_id" name="clinic_id" value="{{ $clinic->id }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <select id="department_id" name="department_id" class="form-control">
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $doctor->employee->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Professional Information</div>
                        <div class="card-body">
                            <div class="row">

                                {{-- Speciality --}}
                                <div class="col-sm-6">
                                    <label>Speciality <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="speciality" name="speciality" value="{{ $doctor->speciality }}">
                                    </div>
                                </div>

                                {{-- Qualification --}}
                                <div class="col-sm-6">
                                    <label>Qualification <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                        </div>
                                        <select id="qualification" name="qualification" class="form-control">
                                            <option value="" disabled {{ empty(optional($doctor)->qualification) ? 'selected' : '' }}>
                                                Select Qualification
                                            </option>
                                            @foreach(['MBBS','MD','DO','BDS','PhD','MSc','Fellowship','Diploma','Other'] as $q)
                                                <option value="{{ $q }}" {{ optional($doctor)->qualification == $q ? 'selected' : '' }}>
                                                    {{ $q }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Consultation Fee --}}
                                <div class="col-sm-6">
                                    <label>Consultation Fee <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" min="0" value="{{ $doctor->consultation_fee }}">
                                    </div>
                                </div>

                                {{-- Rating --}}
                                <div class="col-sm-6">
                                    <label>Rating <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-star"></i></span>
                                        </div>
                                        <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="{{ $doctor->rating }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Work Schedule --}}
                    <div class="card">
                        <div class="card-header">Work Schedule</div>
                        <div class="card-body">
                            <div class="row">

                                {{-- Work Start Time --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Work Start Time <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                            <select name="work_start_time" id="work_start_time" class="form-control">
                                                <option disabled hidden>Select Start Time</option>
                                                @php
                                                    $open = \Carbon\Carbon::parse($opening_time)->format('H');
                                                    $close = \Carbon\Carbon::parse($closing_time)->format('H');
                                                @endphp
                                                @for($h = $open; $h <= $close; $h++)
                                                    @php $label = sprintf('%02d:00', $h); @endphp
                                                    <option value="{{ $label }}" {{ $doctor->employee->work_start_time == $label ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Work End Time --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Work End Time <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                            <select name="work_end_time" id="work_end_time" class="form-control">
                                                <option disabled hidden>Select End Time</option>
                                                @for($h = $open; $h <= $close; $h++)
                                                    @php $label = sprintf('%02d:00', $h); @endphp
                                                    <option value="{{ $label }}" {{ $doctor->employee->work_end_time == $label ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Working Days --}}
                                <div class="col-sm-6 mt-3">
                                    <div class="form-group">
                                        <label>Working Days <span class="text-danger">*</span></label>

                                        @php
                                            $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                                            $clinic_days = $clinic->working_days ?? [];
                                            $doctor_days = $doctor->employee->working_days ?? [];
                                        @endphp

                                        <div class="row gx-1">
                                            <div class="col-6">
                                                @foreach(array_slice($all_days, 0, 4) as $day)
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            name="working_days[]"
                                                            value="{{ $day }}"
                                                            id="day_{{ $day }}"

                                                            {{ in_array($day, $doctor_days) ? 'checked' : '' }}
                                                            {{ !in_array($day, $clinic_days) ? 'disabled' : '' }}
                                                        >
                                                        <label class="form-check-label" for="day_{{ $day }}">
                                                            {{ $day }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="col-6">
                                                @foreach(array_slice($all_days, 4) as $day)
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            name="working_days[]"
                                                            value="{{ $day }}"
                                                            id="day_{{ $day }}"

                                                            {{ in_array($day, $doctor_days) ? 'checked' : '' }}
                                                            {{ !in_array($day, $clinic_days) ? 'disabled' : '' }}
                                                        >
                                                        <label class="form-check-label" for="day_{{ $day }}">
                                                            {{ $day }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- Biography & Status --}}
                    <div class="card">
                        <div class="card-header">Short Biography & Status</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <label>Short Biography</label>
                                    <textarea id="short_biography" name="short_biography" class="form-control" rows="4">{{ $doctor->employee->short_biography }}</textarea>
                                </div>

                                <div class="col-sm-12">
                                    <label class="d-block">Account Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" {{ $doctor->employee->status == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" {{ $doctor->employee->status == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">
                            Edit Employee
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
$(document).ready(function () {
    $('.editBtn').click(function (e) {
        e.preventDefault();

        let name = $('#name').val().trim(),
            date_of_birth = $('#date_of_birth').val().trim(),
            phone = $('#phone').val().trim(),
            email = $('#email').val().trim(),
            address = $('#address').val().trim(),
            clinic_id = $('#clinic_id').val(),
            department_id = $('#department_id').val(),
            work_start_time = $('#work_start_time').val(),
            work_end_time = $('#work_end_time').val(),
            gender = $('input[name="gender"]:checked').val(),
            status = $('input[name="status"]:checked').val(),
            password = $('#password').val(),
            confirm_password = $('#confirm_password').val(),
            short_biography = $('#short_biography').val().trim(),
            speciality = $('#speciality').val(),
            qualification = $('#qualification').val(),
            consultation_fee = $('#consultation_fee').val(),
            rating = $('#rating').val(),
            image = document.querySelector('#image').files[0];

        let workingDays = [];
        $('input[name="working_days[]"]:checked').each(function () { workingDays.push($(this).val()); });

        if (!name || !date_of_birth || !department_id || !email || !phone || !gender ||
            !work_start_time || !work_end_time || workingDays.length === 0 ||
            !speciality || !qualification || !consultation_fee || !rating) {
                return Swal.fire('Error!', 'Please enter all required fields', 'error');
        }

        if (password !== confirm_password) {
            return Swal.fire('Error!', 'Password confirmation does not match', 'error');
        }

        if (work_start_time >= work_end_time) {
            return Swal.fire('Error!', 'Invalid work time range', 'error');
        }


        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', name);
        formData.append('date_of_birth', date_of_birth);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('clinic_id', clinic_id);
        if (department_id) {
            formData.append('department_id', department_id);
        }
        formData.append('gender', gender);
        formData.append('status', status);
        formData.append('short_biography', short_biography);
        formData.append('password', password);
        formData.append('confirm_password', confirm_password);
        formData.append('work_start_time', work_start_time);
        formData.append('work_end_time', work_end_time);
        workingDays.forEach(d => formData.append('working_days[]', d));
        if (image) formData.append('image', image);
        formData.append('speciality', speciality);
        formData.append('qualification', qualification);
        formData.append('consultation_fee', consultation_fee);
        formData.append('rating', rating);


        $.ajax({
            method: 'POST',
            url: "{{ route('clinic.update_doctor', $doctor->id) }}",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                if (response.data == 0) {
                    Swal.fire({ title: 'Error!',
                    text: 'This Doctor Already Exists',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                }else if (response.data == 1) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Doctor Updated Successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => { window.location.href = '/clinic-manager/view/doctors'; });
                }
            },
            error: function() {
                Swal.fire({ title: 'Error!', text: 'Something went wrong!', icon: 'error', confirmButtonText: 'OK' });
            }
        });
    });

});
</script>
@endsection
