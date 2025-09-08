@extends('Backend.admin.master')

@section('title' , 'Add New Doctor')


@section('content')

<style>
    .col-sm-6{ margin-bottom:20px; }
    input[type="date"]{ direction:ltr; text-align:left; }
    .card + .card{ margin-top:20px; }
    .card-header{ font-weight:600; }

    .small-gutter > [class^="col-"] {
        padding-left: 30px !important;
        margin-top: 15px !important;
    }

    .card {
        border: 1px solid #ddd !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08) !important;
        overflow: hidden !important;
    }

    .card-header {
        background-color: #00A8FF !important; /* اللون الأزرق المطلوب */
        color: #fff !important; /* النص أبيض */
        font-weight: 600 !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        border-bottom: 1px solid #ddd !important;
    }

    .card-body {
        background-color: #fff;
        padding: 20px;
    }
</style>

<div class="page-wrapper">
  <div class="content">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title" style="margin-bottom:30px;">Add New Doctor</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form method="POST" action="{{ Route('store_doctor') }}" enctype="multipart/form-data">
          @csrf

          {{-- 1) Doctor Information --}}
          <div class="card">
            <div class="card-header">Doctor Information</div>
            <div class="card-body">
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
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
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
            </div>
          </div>

          {{-- 2) Professional Information --}}
          <div class="card">
            <div class="card-header">Professional Information</div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-6">
                  <label>Qualification <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                    </div>
                    <select class="form-control" id="qualification" name="qualification" required>
                      <option disabled selected hidden>Select Qualification</option>
                      <option value="MBBS">MBBS</option>
                      <option value="MD">MD</option>
                      <option value="DO">DO</option>
                      <option value="BDS">BDS</option>
                      <option value="PhD">PhD</option>
                      <option value="MSc">MSc</option>
                      <option value="Fellowship">Fellowship</option>
                      <option value="Diploma">Diploma</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Experience Years <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                    </div>
                    <input class="form-control" type="number" min="0" id="experience_years" name="experience_years">
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- 3) Assignment (Clinic / Department) --}}
          <div class="card">
            <div class="card-header">Assignment</div>
            <div class="card-body">
              <div class="row">

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
                    <label>Department Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <select id="department_id" name="department_id" class="form-control">
                        <option disabled selected hidden>Select Department</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                      <label>Speciality <span class="text-danger">*</span></label>
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

              </div>
            </div>
          </div>

          {{-- 4) Work Schedule --}}
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

          {{-- 5) Short Bio & Status --}}
          <div class="card">
            <div class="card-header">Short Biography & Status</div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Short Biography</label>
                    <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30"></textarea>
                  </div>
                </div>

                <div class="col-sm-12">
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
                </div>

              </div>
            </div>
          </div>

          <div class="text-center m-t-20" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform:none !important;">
              Add Doctor
            </button>
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
                let qualification = $('#qualification').val();
                let experience_years = $('#experience_years').val();

                let workingDays = [];
                $('input[name="working_days[]"]:checked').each(function () {
                    workingDays.push($(this).val());
                });


                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('department_id', department_id);
                formData.append('specialty_id', specialty_id);
                formData.append('email', email);
                formData.append('password', password);
                formData.append('confirm_password', confirm_password);
                formData.append('phone', phone);
                formData.append('address', address);
                formData.append('work_start_time', work_start_time);
                formData.append('work_end_time', work_end_time);
                formData.append('qualification', qualification);
                formData.append('experience_years', experience_years);
                formData.append('gender', gender);
                formData.append('short_biography', short_biography);
                formData.append('status', status);
                if (image) {
                    formData.append('image', image);
                }

                workingDays.forEach(function (day) {
                    formData.append('working_days[]', day);
                });


                if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || !isValidSelectValue('department_id') || !isValidSelectValue('specialty_id')  || email === '' || password === '' || confirm_password === '' || phone === '' || address === '' || !isValidSelectValue('qualification') || experience_years === '' || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') || gender === undefined  || $('input[name="working_days[]"]:checked').length === 0) {
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
                                text: 'Doctor Has Been Added Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin/add/doctor';
                            });
                        }
                    }
                });
            }
            });
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


    </script>
@endsection
