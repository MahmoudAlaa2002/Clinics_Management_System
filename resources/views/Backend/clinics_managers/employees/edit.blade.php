@extends('Backend.clinics_managers.master')

@section('title', 'Edit Employee')

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
                <h4 class="page-title" style="margin-bottom:30px;">Edit Employee</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form id="editEmployeeForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Employee Information --}}
                    <div class="card">
                        <div class="card-header">Employee Information</div>
                        <div class="card-body">
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
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $employee->user->date_of_birth }}">
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
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $employee->user->email }}">
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
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $employee->user->address }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="" src="{{ $employee->user->image ? asset('storage/'.$employee->user->image) : asset('assets/img/user.jpg') }}">
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
                                                <input type="radio" name="gender" value="Male" {{ $employee->user->gender == 'Male' ? 'checked' : '' }}> Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="Female" {{ $employee->user->gender == 'Female' ? 'checked' : '' }}> Female
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

                                <div class="col-sm-6" id="department_field" style="display:none;">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <select id="department_id" name="department_id" class="form-control">
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <label class="fw-bold">Job Title <span class="text-danger">*</span></label>
                                    <div class="p-3 card" style="border: 1px solid #ddd; border-radius: 8px;">
                                        @php $jobs = ['Department Manager','Doctor','Nurse','Receptionist','Accountant']; @endphp
                                        @foreach($jobs as $job)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input job-title-radio" type="radio" name="job_title" value="{{ $job }}" {{ $employee->job_title == $job ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $job }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Doctor Info --}}
                    <div class="card" id="doctor_info_card" style="{{ $employee->job_title == 'Doctor' ? '' : 'display:none;' }}">
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
                                        <input type="text" class="form-control" id="speciality" name="speciality" value="{{ optional($employee->doctor)->speciality }}">
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
                                            <option value="" disabled {{ empty(optional($employee->doctor)->qualification) ? 'selected' : '' }}>
                                                Select Qualification
                                            </option>
                                            @foreach(['MBBS','MD','DO','BDS','PhD','MSc','Fellowship','Diploma','Other'] as $q)
                                                <option value="{{ $q }}" {{ optional($employee->doctor)->qualification == $q ? 'selected' : '' }}>
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
                                        <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" min="0" value="{{ optional($employee->doctor)->consultation_fee }}">
                                    </div>
                                </div>

                                {{-- Rating --}}
                                <div class="col-sm-6">
                                    <label>Rating <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-star"></i></span>
                                        </div>
                                        <select class="form-control" id="rating" name="rating">
                                            <option value="1" {{ old('rating', optional($employee->doctor)->rating) == 1 ? 'selected' : '' }}>1 ⭐</option>
                                            <option value="2" {{ old('rating', optional($employee->doctor)->rating) == 2 ? 'selected' : '' }}>2 ⭐⭐</option>
                                            <option value="3" {{ old('rating', optional($employee->doctor)->rating) == 3 ? 'selected' : '' }}>3 ⭐⭐⭐</option>
                                            <option value="4" {{ old('rating', optional($employee->doctor)->rating) == 4 ? 'selected' : '' }}>4 ⭐⭐⭐⭐</option>
                                            <option value="5" {{ old('rating', optional($employee->doctor)->rating) == 5 ? 'selected' : '' }}>5 ⭐⭐⭐⭐⭐</option>
                                        </select>
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
                                                    $open = intval(substr($opening_time, 0, 2));
                                                    $close = intval(substr($closing_time, 0, 2));
                                                @endphp
                                                @for($h = $open; $h <= $close; $h++)
                                                    @php $label = sprintf('%02d:00', $h); @endphp
                                                    <option value="{{ $label }}" {{ $employee->work_start_time == $label ? 'selected' : '' }}>
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
                                                    <option value="{{ $label }}" {{ $employee->work_end_time == $label ? 'selected' : '' }}>
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
                                            $employee_days = $employee->working_days ?? [];
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

                                                            {{ in_array($day, $employee_days) ? 'checked' : '' }}
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

                                                            {{ in_array($day, $employee_days) ? 'checked' : '' }}
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
                                    <textarea id="short_biography" name="short_biography" class="form-control" rows="4">{{ $employee->short_biography }}</textarea>
                                </div>

                                <div class="col-sm-12">
                                    <label class="d-block">Account Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="active" {{ $employee->status == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="inactive" {{ $employee->status == 'inactive' ? 'checked' : '' }}>
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

    $('input[name="job_title"]').on('change', function () {
        if ($(this).val() === 'Doctor') {
            $('#doctor_info_card').slideDown(200);
        } else {
            $('#doctor_info_card').slideUp(200);
        }
    });


    let originalName               = "{{ $employee->user->name }}";
    let originalDob                = "{{ $employee->user->date_of_birth }}";
    let originalPhone              = "{{ $employee->user->phone }}";
    let originalEmail              = "{{ $employee->user->email }}";
    let originalAddress            = "{{ $employee->user->address }}";
    let originalGender             = "{{ $employee->user->gender }}";
    let originalStatus             = "{{ $employee->status }}";
    let originalDepartment         = "{{ $employee->department_id }}";
    let originalJobTitle           = "{{ $employee->job_title }}";
    let originalWorkStart          = "{{ $employee->work_start_time }}";
    let originalWorkEnd            = "{{ $employee->work_end_time }}";
    let originalWorkingDays        = @json($employee->working_days ?? []);
    let originalBiography          = "{{ $employee->short_biography }}";

    let originalSpeciality         = "{{ optional($employee->doctor)->speciality }}";
    let originalQualification      = "{{ optional($employee->doctor)->qualification }}";
    let originalFee                = "{{ optional($employee->doctor)->consultation_fee }}";
    let originalRating             = "{{ optional($employee->doctor)->rating }}";


    $(document).on('change', '.job-title-radio', function () {
        const job = $(this).val().toLowerCase();

        // كل الوظائف تحتاج قسم ماعدا المحاسب
        const jobsNeedDept = ['department manager', 'doctor', 'nurse', 'receptionist'];

        if (jobsNeedDept.includes(job)) {
            $('#department_field').show();
        } else {
            $('#department_field').hide();
        }

        // إظهار/إخفاء معلومات الدكتور
        if (job === 'doctor') {
            $('#doctor_info_card').slideDown(200);
        } else {
            $('#doctor_info_card').slideUp(200);
        }
    });

    $('.job-title-radio:checked').trigger('change');



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
            job_title = $('input[name="job_title"]:checked').val(),
            speciality = $('#speciality').val(),
            qualification = $('#qualification').val(),
            consultation_fee = $('#consultation_fee').val(),
            rating = $('#rating').val(),
            image = document.querySelector('#image').files[0];

        let workingDays = [];
        $('input[name="working_days[]"]:checked').each(function () { workingDays.push($(this).val()); });

        let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

        if (!name || !date_of_birth || !department_id || !email || !phone || !gender || !work_start_time || !work_end_time
            || workingDays.length === 0 || !job_title) {
            return Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please enter all required fields',
                confirmButtonColor: '#007BFF'
            });
        }

        if (password && !passwordPattern.test(password)){
                Swal.fire({
                    title: 'Invalid Password',
                    text: 'Password must be 6–15 characters',
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
                return;
        }

        if (password !== confirm_password) {
            return Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Password confirmation does not match',
                confirmButtonColor: '#007BFF'
            });
        }

        if (work_start_time >= work_end_time) {
            return Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid work time range',
                confirmButtonColor: '#007BFF'
            });
        }

        if ($('#department_field').is(':visible') && !department_id) {
            return Swal.fire({
                title: 'Error!',
                text: 'Please Select Department',
                icon: 'error',
                confirmButtonColor: '#007BFF'
            });
        }

        if ($('#doctor_info_card').is(':visible') && (!speciality || !qualification || !consultation_fee || !rating)) {
            return Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill all doctor fields',
                confirmButtonColor: '#007BFF'
            });
        }

        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', name);
        formData.append('date_of_birth', date_of_birth);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('clinic_id', clinic_id);
        if (department_id) formData.append('department_id', department_id);
        formData.append('gender', gender);
        formData.append('status', status);
        formData.append('job_title', job_title);
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

        let newImageSelected = !!image;

        let noChanges = !newImageSelected &&
            name === originalName &&
            date_of_birth === originalDob &&
            phone === originalPhone &&
            email === originalEmail &&
            address === originalAddress &&
            gender === originalGender &&
            status === originalStatus &&
            department_id == originalDepartment &&
            job_title === originalJobTitle &&
            work_start_time === originalWorkStart &&
            work_end_time === originalWorkEnd &&
            short_biography === originalBiography &&
            JSON.stringify(workingDays.sort()) === JSON.stringify(originalWorkingDays.sort()) &&
            (!$('#doctor_info_card').is(':visible') ||
                (speciality === originalSpeciality &&
                qualification === originalQualification &&
                consultation_fee == originalFee &&
                Number(rating) === Number(originalRating))
            );

        if (password !== '' || confirm_password !== '') noChanges = false;

        if (noChanges) {
            Swal.fire({
                icon: 'warning',
                title: 'No Changes',
                text: 'No updates were made to this employee',
                confirmButtonColor: '#007BFF',
            });
            return;
        }

        // ==========================
        // فحص الإيميل (RFC + DNS)
        // ==========================
        $.ajax({
            method: 'POST',
            url: "{{ route('check_email') }}",
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function () {

                // ====== تنفيذ التعديل ======
                $.ajax({
                    method: 'POST',
                    url: "{{ route('clinic.update_employee', $employee->id) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

                    success: function (response) {
                        if (response.data == 0) {
                            Swal.fire({ title: 'Error!', text: 'This email is already used by another user', icon: 'error', confirmButtonText: 'OK', confirmButtonColor: '#00A8FF' });
                        } else if (response.data == 1) {
                            Swal.fire({ title: 'Error!', text: 'This department already has a manager', icon: 'error', confirmButtonText: 'OK', confirmButtonColor: '#00A8FF' });
                        } else if (response.data == 2) {
                            Swal.fire({ title: 'Error!', text: 'This clinic already has a accountant', icon: 'error', confirmButtonText: 'OK', confirmButtonColor: '#00A8FF' });
                        } else if (response.data == 3) {
                            Swal.fire({ title: 'Error!', text: 'This department already has a receptionist', icon: 'error', confirmButtonText: 'OK', confirmButtonColor: '#00A8FF' });
                        } else if (response.data == 4) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Employee updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#00A8FF',
                            }).then(() => { window.location.href = '/clinic-manager/view/employees'; });
                        }
                    },

                    error: function () {
                        Swal.fire({ title: 'Error!', text: 'Something went wrong!', icon: 'error', confirmButtonText: 'OK', confirmButtonColor: '#00A8FF' });
                    }
                });
            },

            error: function (xhr) {
                let msg = 'Invalid email address';

                if (xhr.responseJSON?.errors?.email) {
                    msg = xhr.responseJSON.errors.email[0];
                }

                Swal.fire({
                    title: 'Error!',
                    text: msg,
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
            }
        });
    });
});



$('#image').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const previewUrl = URL.createObjectURL(file);
        $('.profile-upload .upload-img img').attr('src', previewUrl);
    }
});
</script>
@endsection
