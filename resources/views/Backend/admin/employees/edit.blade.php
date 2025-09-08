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
    .profile-upload .upload-img img {
        width: 80px; height: 80px; object-fit: cover; border-radius: 8px;
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
                <form method="POST" action="{{ route('update_employee' , ['id' => $employee->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1) Employee Information --}}
                    <div class="card">
                        <div class="card-header">Employee Information</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Name --}}
                                <div class="col-sm-6">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $employee->user->name }}">
                                    </div>
                                </div>

                                {{-- DOB --}}
                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" value="{{ $employee->user->date_of_birth }}">
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->user->phone }}">
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $employee->user->email }}">
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="col-sm-6">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="col-sm-6">
                                    <label>Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="col-sm-6">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $employee->user->address }}">
                                    </div>
                                </div>

                                {{-- Avatar --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <div class="profile-upload">
                                            <div class="upload-img">
                                                <img alt="employee image" src="{{ asset($employee->user->image ?? 'assets/img/user.jpg') }}">
                                            </div>
                                            <div class="upload-input">
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Gender --}}
                                <div class="col-sm-6">
                                    <div class="form-group gender-select">
                                        <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="male" class="form-check-input" {{ $employee->user->gender === 'male' ? 'checked' : '' }}> Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" name="gender" value="female" class="form-check-input" {{ $employee->user->gender === 'female' ? 'checked' : '' }}> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Work Assignment --}}
                    <div class="card">
                        <div class="card-header">Work Assignment</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Clinic --}}
                                <div class="col-sm-6">
                                    <label>Clinic <span class="text-danger">*</span></label>
                                    <select id="clinic_id" name="clinic_id" class="form-control">
                                        <option disabled selected hidden>Select Clinic</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{ $clinic->id }}" {{ $employee->clinic_id == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Job Titles --}}
                                <div class="col-sm-6">
                                    <label>Job Titles <span class="text-danger">*</span></label>
                                    <div class="row gx-1">
                                        <div class="col-6">
                                            @foreach(array_slice($jobTitles->toArray(), 0, ceil(count($jobTitles)/2)) as $title)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="job_title_id[]" value="{{ $title['id'] }}" id="job_{{ $title['id'] }}"
                                                           {{ in_array($title['id'], $employee->jobTitles->pluck('id')->toArray() ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="job_{{ $title['id'] }}">{{ $title['name'] }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-6">
                                            @foreach(array_slice($jobTitles->toArray(), ceil(count($jobTitles)/2)) as $title)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="job_title_id[]" value="{{ $title['id'] }}" id="job_{{ $title['id'] }}"
                                                           {{ in_array($title['id'], $employee->jobTitles->pluck('id')->toArray() ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="job_{{ $title['id'] }}">{{ $title['name'] }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Department --}}
                                <div class="col-sm-6">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select id="department_id" name="department_id" class="form-control">
                                        <option disabled selected hidden>Select Department</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- 4 Work Schedule --}}
                    <div class="card">
                        <div class="card-header">Work Schedule</div>
                        <div class="card-body">
                          <div class="row">

                            {{-- Work Start --}}
                            <div class="col-sm-6">
                                <label>Work Start Time <span class="text-danger">*</span></label>
                                <select name="work_start_time" id="work_start_time" class="form-control">
                                    <option disabled hidden>Select Start Time</option>
                                    @if($employee->work_start_time)
                                        <option value="{{ $employee->work_start_time }}" selected>{{ $employee->work_start_time }}</option>
                                    @endif
                                </select>
                            </div>

                            {{-- Work End --}}
                            <div class="col-sm-6">
                                <label>Work End Time <span class="text-danger">*</span></label>
                                <select name="work_end_time" id="work_end_time" class="form-control">
                                    <option disabled hidden>Select End Time</option>
                                    @if($employee->work_end_time)
                                        <option value="{{ $employee->work_end_time }}" selected>{{ $employee->work_end_time }}</option>
                                    @endif
                                </select>
                            </div>

                            {{-- Working Days --}}
                            <div class="col-sm-6">
                                <label>Working Days <span class="text-danger">*</span></label>
                                @php
                                    $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                                    $selectedDays = $employee->working_days ?? [];
                                @endphp
                                <div class="row gx-1">
                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 0, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                          </div>
                        </div>
                    </div>

                    {{-- 3) Short Biography & Status --}}
                    <div class="card">
                        <div class="card-header">Short Biography & Status</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Short Biography</label>
                                <textarea class="form-control" id="short_biography" name="short_biography" rows="3">{{ $employee->short_biography }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="display-block">Status</label>
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

                    {{-- Submit --}}
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">Edit Employee</button>
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
    function isValidSelectValue(selectId) {
        let val = $(`#${selectId}`).val();
        return val !== '' && val !== null && val !== undefined &&
               $(`#${selectId} option[value="${val}"]`).length > 0;
    }

    // ✅ ميثود لملء أوقات العمل من العيادة
    function loadWorkingTimes(clinicId, start='', end='') {
        $.get('/admin/get-clinic-info/' + clinicId, function (data) {
            const sHour = parseInt(data.opening_time.split(':')[0]);
            const eHour = parseInt(data.closing_time.split(':')[0]);

            const $s = $('#work_start_time');
            const $e = $('#work_end_time');

            $s.empty().append('<option disabled hidden>Select Start Time</option>');
            $e.empty().append('<option disabled hidden>Select End Time</option>');

            for (let h = sHour; h <= eHour; h++) {
                let hh = (h < 10 ? '0' : '') + h;
                let value = hh + ':00:00';   // صيغة كاملة مع الثواني
                let label = hh + ':00';      // للعرض فقط

                // قائمة البداية
                $s.append(`<option value="${value}" ${value === start ? 'selected' : ''}>${label}</option>`);

                // قائمة النهاية
                $e.append(`<option value="${value}" ${value === end ? 'selected' : ''}>${label}</option>`);
            }
        });
    }

    // ✅ ميثود لملء أيام العمل
    function loadWorkingDaysForClinic(clinicId, selectedDays=[]) {
        $.get('/admin/clinic-working-days/' + clinicId, function (resp) {
            const clinicDays = resp.working_days || [];
            const allDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];

            allDays.forEach(day=>{
                const $cb = $('#day_'+day);
                if ($cb.length) {
                    if (clinicDays.includes(day)) {
                        $cb.prop('disabled',false);
                        if (selectedDays.includes(day)) $cb.prop('checked',true);
                    } else {
                        $cb.prop('disabled',true).prop('checked',false);
                    }
                }
            });
        });
    }

    $(document).ready(function () {
        $('.editBtn').click(function (e) {
            e.preventDefault();

            let name = $('#name').val().trim();
            let date_of_birth = $('#date_of_birth').val().trim();
            let clinic_id = $('#clinic_id').val();
            let department_id = $('#department_id').val();
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

            let jobTitles = [];
            $('input[name="job_title_id[]"]:checked').each(function () {
                jobTitles.push($(this).val());
            });

            let workingDays = [];
            $('input[name="working_days[]"]:checked').each(function () {
                workingDays.push($(this).val());
            });

            // ✅ استخدم FormData
            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('name', name);
            formData.append('date_of_birth', date_of_birth);
            formData.append('clinic_id', clinic_id);
            if (department_id) formData.append('department_id', department_id);
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

            jobTitles.forEach(id => formData.append('job_title_id[]', id));
            workingDays.forEach(day => formData.append('working_days[]', day));

            let start = moment(work_start_time, "HH:mm");
            let end   = moment(work_end_time, "HH:mm");

            if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') ||
                    !isValidSelectValue('department_id') ||
                    email === '' || phone === '' || address === '' ||
                    !isValidSelectValue('work_start_time') ||
                    !isValidSelectValue('work_end_time') || gender === undefined ||
                    workingDays.length === 0) {

                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter All Required Fields',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else if (password !== confirm_password){
                Swal.fire({
                    title: 'Error!',
                    text: 'The Password Does Not Match The Confirmation Password',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else {
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

        // ✅ عند تحميل الصفحة (edit mode)
        let currentClinicId = $('#clinic_id').val();
        let selectedDepartmentId = "{{ $employee->department_id }}";
        let selectedDays = @json($employee->working_days ?? []);
        let currentStart = "{{ $employee->work_start_time }}";
        let currentEnd   = "{{ $employee->work_end_time }}";

        if (currentClinicId) {
            // حمل الأقسام
            $.get('/admin/get-departments-by-clinic/' + currentClinicId, function (data) {
                let departmentSelect = $('#department_id');
                departmentSelect.empty().append('<option value="" disabled hidden>Select Department</option>');
                $.each(data, function (index, department) {
                    let selected = department.id == selectedDepartmentId ? 'selected' : '';
                    departmentSelect.append('<option value="' + department.id + '" ' + selected + '>' + department.name + '</option>');
                });
            });

            // حمل الأوقات
            loadWorkingTimes(currentClinicId, currentStart, currentEnd);

            // حمل الأيام
            loadWorkingDaysForClinic(currentClinicId, selectedDays);
        }

        // ✅ عند تغيير العيادة
        $('#clinic_id').on('change', function () {
            var clinicId = $(this).val();
            if (clinicId) {
                // جلب الأقسام
                $.get('/admin/get-departments-by-clinic/' + clinicId, function (data) {
                    let departmentSelect = $('#department_id');
                    departmentSelect.empty().append('<option value="" disabled selected hidden>Select Department</option>');
                    $.each(data, function (index, department) {
                        departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                });

                // جلب الأوقات الجديدة
                loadWorkingTimes(clinicId);

                // جلب أيام العمل الجديدة
                loadWorkingDaysForClinic(clinicId, []);
            }
        });
    });
</script>
@endsection

