@extends('Backend.admin.master')

@section('title' , 'Edit Employee')

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
    .profile-upload .upload-img img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
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
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1) Employee Information --}}
                    <div class="card">
                        <div class="card-header">Employee Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                        <input type="text" class="form-control" id="name" value="{{ $employee->user->name }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                                        <input type="date" class="form-control" id="date_of_birth" value="{{ $employee->user->date_of_birth }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                                        <input type="text" class="form-control" id="phone" value="{{ $employee->user->phone }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                        <input type="email" class="form-control" id="email" value="{{ $employee->user->email }}">
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
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                                        <input type="text" class="form-control" id="address" value="{{ $employee->user->address }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img mb-2">
                                            <img alt="employee" src="{{ asset($employee->user->image ?? 'assets/img/user.jpg') }}">
                                        </div>
                                        <input type="file" class="form-control" id="image" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Gender <span class="text-danger">*</span></label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" value="Male" class="form-check-input" {{ $employee->user->gender == 'Male' ? 'checked' : '' }}>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" value="Female" class="form-check-input" {{ $employee->user->gender == 'Female' ? 'checked' : '' }}>
                                        <label class="form-check-label">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Work Assignment --}}
                    <div class="card">
                        <div class="card-header">Assignment</div>
                        <div class="card-body">
                            <div class="row">

                                {{-- Clinic --}}
                                <div class="col-sm-6">
                                    <label>Clinic Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select id="clinic_id" class="form-control">
                                            <option disabled hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ $employee->clinic_id == $clinic->id ? 'selected' : '' }}>
                                                    {{ $clinic->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Department --}}
                                <div class="col-sm-6" id="department_field" style="{{ in_array($employee->job_title, ['Department Manager', 'Doctor', 'Nurse', 'Receptionist']) ? '' : 'display:none;' }}">
                                    <label>Department Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <select id="department_id" class="form-control">
                                            <option disabled hidden>Select Department</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Job Title --}}
                                <div class="col-sm-12 mt-3">
                                    <label class="mb-2 fw-bold">Job Title <span class="text-danger">*</span></label>
                                    <div class="p-3 card">
                                        @php $job = $employee->job_title; @endphp
                                        @foreach(['Clinic Manager','Department Manager','Doctor','Nurse','Receptionist' , 'Accountant'] as $title)
                                            <div class="mb-2 form-check">
                                                <input class="form-check-input job-title-radio" type="radio" name="job_title"
                                                    value="{{ $title }}" {{ $job == $title ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $title }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- 3) Doctor Info --}}
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
                                        <select class="form-control" id="rating" name="rating" required>
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


                    {{-- 4) Work Schedule --}}
                    <div class="card">
                        <div class="card-header">Work Schedule</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Work Start Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select id="work_start_time" class="form-control">
                                            <option disabled selected hidden>Select Start Time</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Work End Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select id="work_end_time" class="form-control">
                                            <option disabled selected hidden>Select End Time</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Working Days <span class="text-danger">*</span></label>
                                    @php
                                        $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                                        $selectedDays = $employee->working_days ?? [];
                                    @endphp

                                    <div class="row gx-1">
                                        <div class="col-sm-6">
                                            @foreach(array_slice($all_days, 0, 4) as $day)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-sm-6">
                                            @foreach(array_slice($all_days, 4) as $day)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 5) Biography & Status --}}
                    <div class="card">
                        <div class="card-header">Short Biography & Status</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <label>Short Biography</label>
                                    <textarea id="short_biography" class="form-control" rows="4">{{ $employee->short_biography }}</textarea>
                                </div>

                                <div class="col-sm-12">
                                    <label>Account Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="active" class="form-check-input" {{ $employee->status == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="inactive" class="form-check-input" {{ $employee->status == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="orig_name" value="{{ $employee->user->name }}">
                    <input type="hidden" id="orig_date_of_birth" value="{{ $employee->user->date_of_birth }}">
                    <input type="hidden" id="orig_phone" value="{{ $employee->user->phone }}">
                    <input type="hidden" id="orig_email" value="{{ $employee->user->email }}">
                    <input type="hidden" id="orig_address" value="{{ $employee->user->address }}">
                    <input type="hidden" id="orig_clinic_id" value="{{ $employee->clinic_id }}">
                    <input type="hidden" id="orig_department_id" value="{{ $employee->department_id }}">
                    <input type="hidden" id="orig_job_title" value="{{ $employee->job_title }}">
                    <input type="hidden" id="orig_work_start" value="{{ $employee->work_start_time }}">
                    <input type="hidden" id="orig_work_end" value="{{ $employee->work_end_time }}">
                    <input type="hidden" id="orig_status" value="{{ $employee->status }}">
                    <input type="hidden" id="orig_bio" value="{{ $employee->short_biography }}">
                    <input type="hidden" id="orig_gender" value="{{ $employee->user->gender }}">
                    <input type="hidden" id="orig_working_days" value="{{ implode(',', $employee->working_days ?? []) }}">
                    <input type="hidden" id="orig_speciality" value="{{ optional($employee->doctor)->speciality }}">
                    <input type="hidden" id="orig_qualification" value="{{ optional($employee->doctor)->qualification }}">
                    <input type="hidden" id="orig_consultation_fee" value="{{ optional($employee->doctor)->consultation_fee }}">
                    <input type="hidden" id="orig_rating" value="{{ optional($employee->doctor)->rating }}">



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

    const employeeId = "{{ $employee->id }}";
    const currentClinicId = "{{ $employee->clinic_id ?? '' }}";
    const selectedDays = {!! json_encode($employee->working_days ?? []) !!};

    if (currentClinicId) {
        loadDepartments(currentClinicId, "{{ $employee->department_id ?? '' }}");
        loadWorkingTimes(currentClinicId, "{{ $employee->work_start_time ?? '' }}", "{{ $employee->work_end_time ?? '' }}");
        loadWorkingDaysForClinic(currentClinicId, selectedDays);
    }

    $('#clinic_id').on('change', function () {
        const id = $(this).val();
        loadDepartments(id);
        loadWorkingTimes(id);
        loadWorkingDaysForClinic(id, []);
    });

    function loadDepartments(id, selected='') {
        $('#department_id').empty().append('<option disabled selected hidden>Loading...</option>');
        $.get('/clinics-management/get-departments-by-clinic/' + id, function (data) {
            $('#department_id').empty().append('<option disabled selected hidden>Select Department</option>');
            data.forEach(dep => {
                $('#department_id').append(`<option value="${dep.id}" ${dep.id == selected ? 'selected' : ''}>${dep.name}</option>`);
            });
        });
    }

    function loadWorkingTimes(id, start='', end='') {
        $.get('/clinics-management/get-clinic-info/' + id, function (data) {
            const sHour = parseInt(data.opening_time.split(':')[0]);
            const eHour = parseInt(data.closing_time.split(':')[0]);
            const $s = $('#work_start_time'), $e = $('#work_end_time');
            $s.empty().append('<option disabled hidden>Select Start Time</option>');
            $e.empty().append('<option disabled hidden>Select End Time</option>');
            for (let h = sHour; h <= eHour; h++) {
                let hh = (h < 10 ? '0' : '') + h;
                let value = hh + ':00';
                $s.append(`<option value="${value}" ${value === start ? 'selected' : ''}>${hh}:00</option>`);
                $e.append(`<option value="${value}" ${value === end ? 'selected' : ''}>${hh}:00</option>`);
            }
        });
    }

    function loadWorkingDaysForClinic(id, selectedDays) {
        $.get('/clinics-management/clinic-working-days/' + id, function (resp) {
            const clinicDays = resp.working_days || [];
            const allDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
            allDays.forEach(day => {
                const $cb = $('#day_' + day);
                if (clinicDays.includes(day)) {
                    $cb.prop('disabled', false);
                    if (selectedDays.includes(day)) $cb.prop('checked', true);
                } else {
                    $cb.prop('disabled', true).prop('checked', false);
                }
            });
        });
    }

    $(document).on('change', '.job-title-radio', function () {
        const job = $(this).val().toLowerCase();
        const jobsNeedDept = ['department manager','doctor','nurse','receptionist'];
        if (jobsNeedDept.includes(job)) $('#department_field').slideDown(200);
        else $('#department_field').slideUp(200);

        if (job === 'doctor') $('#doctor_info_card').slideDown(200);
        else $('#doctor_info_card').slideUp(200);
    });

    // ==================  زر التعديل  ==================
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

        let start = moment(work_start_time, "HH:mm");
        let end   = moment(work_end_time, "HH:mm");

        if (!name || !date_of_birth || !clinic_id || !email || !phone || !gender || !work_start_time
            || !work_end_time || workingDays.length === 0 || !job_title) {
            return Swal.fire({
                title: 'Error!',
                text: 'Please Enter All Required Fields',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        // 🔐 فحص الباسوورد فقط
        let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;
        if (password && !passwordPattern.test(password)) {
            return Swal.fire({
                title: 'Invalid Password',
                text: 'Password must be 6–15 characters',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        if (password !== confirm_password) {
            return Swal.fire({
                title: 'Error!',
                text: 'Password confirmation does not match',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        if (!start.isBefore(end)) {
            return Swal.fire({
                title: 'Error!',
                text: 'Invalid work time range',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        if ($('#department_field').is(':visible') && !department_id) {
            return Swal.fire({
                title: 'Error!',
                text: 'Please Select Department',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        if ($('#doctor_info_card').is(':visible') && (!speciality || !qualification || !consultation_fee || !rating)) {
            return Swal.fire({
                title: 'Error!',
                text: 'Please Fill All Doctor Fields',
                icon: 'error',
                confirmButtonColor: '#00A8FF'
            });
        }

        // ================== FormData ==================
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

        // ================== فحص لا يوجد تغييرات ==================
        let origWorkingDays = $('#orig_working_days').val() ? $('#orig_working_days').val().split(',') : [];
        let noChanges =
            name === $('#orig_name').val() &&
            date_of_birth === $('#orig_date_of_birth').val() &&
            phone === $('#orig_phone').val() &&
            email === $('#orig_email').val() &&
            address === $('#orig_address').val() &&
            clinic_id === $('#orig_clinic_id').val() &&
            job_title === $('#orig_job_title').val() &&
            work_start_time === $('#orig_work_start').val() &&
            work_end_time === $('#orig_work_end').val() &&
            short_biography === $('#orig_bio').val() &&
            status === $('#orig_status').val() &&
            gender === $('#orig_gender').val() &&
            workingDays.sort().toString() === origWorkingDays.sort().toString();

        if (job_title === 'Doctor') {
            noChanges = noChanges &&
                speciality === $('#orig_speciality').val() &&
                qualification === $('#orig_qualification').val() &&
                consultation_fee === $('#orig_consultation_fee').val() &&
                Number(rating) === Number($('#orig_rating').val());
        }

        if ($('#department_field').is(':visible')) {
            noChanges = noChanges && department_id === $('#orig_department_id').val();
        }

        if (password !== '' || confirm_password !== '') noChanges = false;

        let imageChanged = image ? true : false;

        if (noChanges && !imageChanged) {
            return Swal.fire({
                icon: 'warning',
                title: 'No Changes',
                text: 'No updates were made to this employee',
                confirmButtonColor: '#00A8FF',
            });
        }

        // ================== فحص الإيميل الحديث (RFC + DNS) ==================
        $.ajax({
            method: 'POST',
            url: "{{ route('check_email') }}",
            data: {
                email: email,
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function () {

                // ========== إذا الإيميل صحيح → نكمل التعديل ==========
                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_employee', ['id' => $employee->id]) }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

                    success: function (res) {
                        if (res.data == 0) {
                            Swal.fire({ title:'Error!', text:'This email is already used by another user', icon:'error', confirmButtonColor:'#00A8FF' });
                        } else if (res.data == 1) {
                            Swal.fire({ title:'Error!', text:'Clinic already has a manager', icon:'error', confirmButtonColor:'#00A8FF' });
                        } else if (res.data == 2) {
                            Swal.fire({ title:'Error!', text:'Department already has a manager', icon:'error', confirmButtonColor:'#00A8FF' });
                        } else if (res.data == 3) {
                            Swal.fire({
                                title:'Success',
                                text:'Employee updated successfully',
                                icon:'success',
                                confirmButtonColor:'#00A8FF'
                            }).then(() => window.location.href = '/admin/view/employees');
                        }
                    },

                    error: function () {
                        Swal.fire({ title:'Error!', text:'Unexpected error occurred', icon:'error', confirmButtonColor:'#00A8FF' });
                    }
                });
            },

            error: function (xhr) {
                let msg = 'Invalid email address';
                if (xhr.responseJSON?.errors?.email) msg = xhr.responseJSON.errors.email[0];
                Swal.fire({
                    title: 'Error!',
                    text: msg,
                    icon: 'error',
                    confirmButtonColor: '#00A8FF'
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

