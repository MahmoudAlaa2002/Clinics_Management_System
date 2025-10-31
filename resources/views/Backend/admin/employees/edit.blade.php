@extends('Backend.admin.master')

@section('title', 'Edit Employee')

@section('content')
<style>
    .col-sm-6 { margin-bottom: 20px; }
    input[type="date"] { direction: ltr; text-align: left; }
    .card { border: 1px solid #ddd !important; border-radius: 8px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important; overflow: hidden !important; }
    .card-header { background-color: #00A8FF !important; color: #fff !important; font-weight: 600 !important; padding: 12px 15px !important; font-size: 16px !important; border-bottom: 1px solid #ddd !important; }
    .card-body { background-color: #fff; padding: 20px; }
    .small-gutter > [class^="col-"] { padding-left: 30px !important; margin-top: 15px !important; }
    .profile-upload .upload-img img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="mb-4 page-title">Edit Employee</h4>
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
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $employee->user->name }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $employee->user->date_of_birth }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->user->phone }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $employee->user->email }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $employee->user->address }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="mb-2 upload-img">
                                            <img src="{{ asset($employee->user->image ?? 'assets/img/user.jpg') }}" alt="employee">
                                        </div>
                                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Gender <span class="text-danger">*</span></label><br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" value="male" class="form-check-input" {{ $employee->user->gender == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="gender" value="female" class="form-check-input" {{ $employee->user->gender == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label">Female</label>
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
                                        <option disabled hidden>Select Clinic</option>
                                        @foreach($clinics as $clinic)
                                            <option value="{{ $clinic->id }}" {{ $employee->clinic_id == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Department --}}
                                <div class="col-sm-6" id="department_field" style="{{ in_array($employee->job_title, ['Department Manager', 'Doctor', 'Nurse', 'Receptionist']) ? '' : 'display:none;' }}">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select id="department_id" name="department_id" class="form-control">
                                        <option value="" {{ !$employee->department_id ? 'selected' : '' }} disabled hidden>
                                            Select Department
                                        </option>
                                        @foreach($departments as $department)
                                            <option
                                                value="{{ $department->id }}"
                                                {{ $employee->department_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Job Title --}}
                                <div class="mt-3 col-sm-12">
                                    <label class="mb-2 fw-bold">Job Title <span class="text-danger">*</span></label>
                                    <div class="p-3 card">
                                        @php $job = $employee->job_title; @endphp
                                        @foreach(['Clinic Manager','Department Manager','Doctor','Nurse','Receptionist'] as $title)
                                            <div class="mb-2 form-check">
                                                <input class="form-check-input" type="radio" name="job_title" id="{{ strtolower(str_replace(' ','_',$title)) }}" value="{{ $title }}" {{ $job == $title ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ strtolower(str_replace(' ','_',$title)) }}">{{ $title }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- 3) Doctor Info --}}
                    <div class="card" id="doctor_info_card" style="{{ $employee->job_title == 'Doctor' ? '' : 'display:none;' }}">
                        <div class="card-header">Doctor Job Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Speciality</label>
                                    <input type="text" id="speciality" name="speciality" class="form-control" value="{{ optional($employee->doctor)->speciality }}">
                                </div>

                                <div class="col-sm-6">
                                    <label>Qualification</label>
                                    <select id="qualification" name="qualification" class="form-control">
                                        <option value="" {{ empty(optional($employee->doctor)->qualification) ? 'selected' : '' }} disabled hidden>
                                            Select Qualification
                                        </option>
                                        @foreach(['MBBS','MD','DO','BDS','PhD','MSc','Fellowship','Diploma','Other'] as $q)
                                            <option value="{{ $q }}" {{ optional($employee->doctor)->qualification == $q ? 'selected' : '' }}>
                                                {{ $q }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label>Consultation Fee</label>
                                    <input type="number" id="consultation_fee" name="consultation_fee" class="form-control" min="0" value="{{ optional($employee->doctor)->consultation_fee }}">
                                </div>

                                <div class="col-sm-6">
                                    <label>Rating</label>
                                    <input type="number" id="rating" name="rating" class="form-control" min="1" max="5" value="{{ optional($employee->doctor)->rating }}">
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
                                    <select name="work_start_time" id="work_start_time" class="form-control">
                                        <option disabled selected hidden>Select Start Time</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label>Work End Time <span class="text-danger">*</span></label>
                                    <select name="work_end_time" id="work_end_time" class="form-control">
                                        <option disabled selected hidden>Select End Time</option>
                                    </select>
                                </div>

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

                    {{-- 5) Biography & Status --}}
                    <div class="card">
                        <div class="card-header">Short Biography & Status</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12">
                                    <label>Short Biography</label>
                                    <textarea id="short_biography" name="short_biography" class="form-control" rows="4">{{ $employee->short_biography }}</textarea>
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
    $(document).ready(function () {

        // ✅ تحميل أوقات العمل فور دخول الصفحة بعد تحميل DOM
        const clinicId = "{{ $employee->clinic_id }}";
        if (clinicId) {
            // استخدم تأخير بسيط للتأكد إن الصفحة والـ selects محملة بالكامل
            setTimeout(() => loadClinicTimes(clinicId, true), 200);
        }

        // ✅ عند تغيير العيادة — نعيد تحميل أوقات العمل
        $('#clinic_id').on('change', function () {
            loadClinicTimes($(this).val(), false);
        });

        // ✅ دالة تحميل أوقات العمل الخاصة بالعيادة
        function loadClinicTimes(id, isInitialLoad = false) {
            if (!id) return;

            $.get('/admin/get-clinic-info/' + id, function (data) {
                const start = parseInt(data.opening_time.split(':')[0]);
                const end = parseInt(data.closing_time.split(':')[0]);

                const workStart = $('#work_start_time');
                const workEnd = $('#work_end_time');
                workStart.empty().append('<option disabled hidden>Select Start Time</option>');
                workEnd.empty().append('<option disabled hidden>Select End Time</option>');

                // توليد قائمة الساعات
                for (let h = start; h <= end; h++) {
                    const label = (h < 10 ? '0' + h : h) + ':00';
                    const value = (h < 10 ? '0' + h : h) + ':00:00';
                    workStart.append(`<option value="${value}">${label}</option>`);
                    workEnd.append(`<option value="${value}">${label}</option>`);
                }

                // ✅ تعيين القيم المحفوظة من قاعدة البيانات إذا كانت موجودة
                const savedStart = "{{ $employee->work_start_time }}";
                const savedEnd = "{{ $employee->work_end_time }}";

                if (isInitialLoad) {
                    // أول مرة فقط نعيّن القيم المحفوظة
                    $('#work_start_time').val(savedStart).trigger('change');
                    $('#work_end_time').val(savedEnd).trigger('change');
                }
            });
        }

        // إظهار/إخفاء أقسام حسب الوظيفة
        $('input[name="job_title"]').on('change', function () {
            const job = $(this).val();
            const needDept = ['Department Manager','Doctor','Nurse','Receptionist'];
            $('#department_field').toggle(needDept.includes(job));
            $('#doctor_info_card').toggle(job === 'Doctor');
        });

        // عند الضغط على زر التعديل
        $('.editBtn').on('click', function (e) {
            e.preventDefault();
            const form = $('form')[0];
            const formData = new FormData(form);
            formData.append('_method', 'PUT');

            $.ajax({
                method: 'POST',
                url: "{{ route('update_employee', ['id' => $employee->id]) }}",
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (res) {
                    if (res.data == 0)
                        Swal.fire('Error!', 'This Employee Already Exists', 'error');
                    else if (res.data == 1)
                        Swal.fire('Warning', 'Another Manager Already Exists for this Clinic', 'warning');
                    else if (res.data == 2)
                        Swal.fire('Warning', 'Another Manager Already Exists for this Department', 'warning');
                    else if (res.data == 3)
                        Swal.fire('Success', 'Employee Has Been Updated Successfully', 'success')
                            .then(() => window.location.href = '/admin/view/employees');
                    else
                        Swal.fire('Info', 'Unknown response received', 'info');
                },
                error: function () {
                    Swal.fire('Error!', 'Unexpected error occurred while updating', 'error');
                }
            });
        });

    });
</script>
@endsection

