@extends('Backend.admin.master')

@section('title' , 'Add New Employee')

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
                <h4 class="page-title" style="margin-bottom:30px;">Add New Employee</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ route('store_employee') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- 1) Employee Information --}}
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
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
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
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Address</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Avatar</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="" src="{{ asset('assets/img/user.jpg') }}">
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
                                            <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Job Title --}}
                                <div class="row small-gutter">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Job Titles <span class="text-danger">*</span></label>
                                            <div class="row gx-1">
                                                <div class="col-6">
                                                    @foreach(array_slice($job_titles->toArray(), 0, ceil(count($job_titles)/2)) as $title)
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="checkbox"
                                                                   name="job_title_id[]"
                                                                   value="{{ $title['id'] }}"
                                                                   id="job_{{ $title['id'] }}"
                                                                   data-need-department="{{ $title['need_department'] ?? 0 }}"
                                                                   data-need-doctor="{{ $title['need_doctor'] ?? 0 }}"
                                                                   {{ !empty($employee) && in_array($title['id'], $employee->jobTitles->pluck('id')->toArray() ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="job_{{ $title['id'] }}">{{ $title['name'] }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="col-6">
                                                    @foreach(array_slice($job_titles->toArray(), ceil(count($job_titles)/2)) as $title)
                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="checkbox"
                                                                   name="job_title_id[]"
                                                                   value="{{ $title['id'] }}"
                                                                   id="job_{{ $title['id'] }}"
                                                                   data-need-department="{{ $title['need_department'] ?? 0 }}"
                                                                   data-need-doctor="{{ $title['need_doctor'] ?? 0 }}"
                                                                   {{ !empty($employee) && in_array($title['id'], $employee->jobTitles->pluck('id')->toArray() ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="job_{{ $title['id'] }}">{{ $title['name'] }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Department --}}
                                <div class="col-sm-6" id="department_field" style="display:none;">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select id="department_id" name="department_id" class="form-control">
                                        <option disabled selected hidden>Select Department</option>
                                        {{-- الأقسام تجي من السيرفر --}}
                                    </select>
                                </div>

                                {{-- Doctor --}}
                                {{-- <div class="col-sm-6" id="doctor_field" style="display:none;">
                                    <label>Doctor <span class="text-danger">*</span></label>
                                    <select id="doctor_id" name="doctor_id" class="form-control">
                                        <option disabled selected hidden>Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                            </div>
                        </div>
                    </div>

                    {{-- Work Schedule --}}
                    <div class="card">
                        <div class="card-header">Work Schedule</div>
                        <div class="card-body">
                          <div class="row">

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

                            <div class="row small-gutter">
                                <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Working Days <span class="text-danger">*</span></label>
                                    <div class="row gx-1">
                                    @php
                                        $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
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
                            </div>
                          </div>
                        </div>
                    </div>



                    {{-- 4) Short Biography & Status --}}
                    <div class="card">
                        <div class="card-header">Short Biography & Status</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Short Biography --}}
                                <div class="mb-3 col-sm-12">
                                    <label for="short_biography">Short Biography</label>
                                    <div class="input-group">
                                        <textarea id="short_biography" name="short_biography" class="form-control" rows="4" placeholder="Write a short bio..."></textarea>
                                    </div>
                                </div>

                                {{-- Account Status --}}
                                <div class="col-sm-12">
                                    <label class="d-block">Account Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive">
                                        <label class="form-check-label" for="inactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn" style="text-transform:none !important;">
                            Add Employee
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
    function isValidSelectValue(selectId) {      // هذا الميثود حتى أتجنب خداع الفيكفيار
        let val = $(`#${selectId}`).val();
        return val !== '' && val !== null && val !== undefined && $(`#${selectId} option[value="${val}"]`).length > 0;
    }

    $(document).ready(function () {
        $('.submit-btn').click(function (e) {
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
            formData.append('name', name);
            formData.append('date_of_birth', date_of_birth);
            formData.append('clinic_id', clinic_id);
            if (department_id) formData.append('department_id', department_id); // فقط لو كان ظاهر
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

            jobTitles.forEach(function (id) {
                formData.append('job_title_id[]', id);
            });

            workingDays.forEach(function (day) {
                formData.append('working_days[]', day);
            });

            let start = moment(work_start_time, "HH:mm");
            let end   = moment(work_end_time, "HH:mm");


            // ✅ التحقق من الحقول
            if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || email === '' || phone === '' || address === '' || jobTitles.length === 0 || workingDays.length === 0 || !work_start_time || !work_end_time || gender === undefined) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please Enter All Required Fields',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else if (password !== confirm_password) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The Password Does Not Match The Confirmation Password',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else if (!start.isBefore(end)) {
                Swal.fire({
                    title: 'Error!',
                    text: 'The Timing Is Incorrect, Please Correct It',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else {
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
                                text: 'Employee Has Been Added Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin/add/employee';
                            });
                        }
                    },
                });
            }
        });



        $('#clinic_id').on('change', function () {
            const clinicId = $(this).val();

            if (!clinicId) return;

            // ✅ تحميل التخصصات
            $.get('/admin/get-departments-by-clinic/' + clinicId, function (data) {
                const departmentSelect = $('#department_id');
                departmentSelect.empty().append('<option value="" disabled selected hidden>Select Department</option>');
                $.each(data, function (i, department) {
                    departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
            });
        });


        $('#department_id').on('change', function () {
            const departmentId = $(this).val();
            if (!departmentId) return;

            $.get('/admin/get-specialties-by-department/' + departmentId, function (data) {
                const specialtySelect = $('#specialty_id');
                specialtySelect.empty().append('<option value="" disabled selected hidden>Select Specialty</option>');

                $.each(data, function (i, specialty) {
                    specialtySelect.append('<option value="' + specialty.id + '">' + specialty.name + '</option>');
                });
            });
        });

        // ✅ تحميل أوقات العمل
        $.get('/admin/get-clinic-info/' + clinicId, function (data) {
            const start = parseInt(data.opening_time.split(':')[0]);
            const end = parseInt(data.closing_time.split(':')[0]);

            const workStartSelect = $('#work_start_time');
            const workEndSelect = $('#work_end_time');

            workStartSelect.empty().append('<option disabled selected hidden>Select Start Time</option>');
            workEndSelect.empty().append('<option disabled selected hidden>Select End Time</option>');

            for (let h = start; h <= end; h++) {
                let timeLabel = (h < 10 ? '0' + h : h) + ':00';
                workStartSelect.append(`<option value="${h}:00:00">${timeLabel}</option>`);
                workEndSelect.append(`<option value="${h}:00:00">${timeLabel}</option>`);
            }
        });

        // ✅ تفعيل وتعطيل أيام العمل
        $.get('/admin/clinic-working-days/' + clinicId, function (response) {
            const clinicDays = response.working_days || []; // الأيام من السيرفر
            console.log(clinicDays);
            const allDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

            allDays.forEach(day => {
                const checkbox = $('#day_' + day);
                if (checkbox.length) {
                    if (clinicDays.includes(day)) {
                        // خلي اليوم مفعّل
                        checkbox.prop('disabled', false);
                        checkbox.closest('.form-check').removeClass('text-muted');
                    } else {
                        // عطّل الأيام الغير متاحة
                        checkbox.prop('disabled', true).prop('checked', false);
                        checkbox.closest('.form-check').addClass('text-muted');
                    }
                }
            });
        });
    });





        // ✅ إظهار/إخفاء الحقول بناءً على نوع الوظيفة
        $('input[name="job_title_id[]"]').change(function () {
        // هل أي من الوظائف المختارة يحتاج قسم؟
        let needDepartment = $('input[name="job_title_id[]"]:checked').filter(function () {
            return $(this).data('need-department') == 1;
        }).length > 0;

        // هل أي من الوظائف المختارة يحتاج دكتور؟
        let needDoctor = $('input[name="job_title_id[]"]:checked').filter(function () {
            return $(this).data('need-doctor') == 1;
        }).length > 0;

        // 👇 عرض/إخفاء حقل القسم
        if (needDepartment) {
            $('#department_field').show();
            $('#department_id').prop('required', true);
        } else {
            $('#department_field').hide();
            $('#department_id').prop('required', false).val('');
        }

        // 👇 عرض/إخفاء حقل الدكتور
        if (needDoctor) {
            $('#doctor_field').show();
            $('#doctor_id').prop('required', true);
        } else {
            $('#doctor_field').hide();
            $('#doctor_id').prop('required', false).val('');
        }
    });



        // $('#department_id').change(function () {
        //     let clinicId = $('#clinic_id').val();
        //     let departmentId = $(this).val();

        //     if (clinicId && departmentId) {
        //         $.get("{{ route('get_doctors_by_clinic_and_department') }}", {
        //             clinic_id: clinicId,
        //             department_id: departmentId
        //         }, function (doctors) {
        //             $('#doctor_id').empty().append('<option disabled selected hidden>Select Doctor</option>');
        //             $.each(doctors, function (i, doc) {
        //                 $('#doctor_id').append(`<option value="${doc.id}">${doc.name}</option>`);
        //             });
        //         });
        //     }
        // });
});
</script>
@endsection

