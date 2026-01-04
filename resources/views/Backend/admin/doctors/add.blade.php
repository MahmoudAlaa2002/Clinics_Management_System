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

          {{-- Doctor Information --}}
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
                        <input type="radio" id="gender" name="gender" class="form-check-input" value="Male">Male
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" id="gender" name="gender" class="form-check-input" value="Female">Female
                      </label>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- Assignment (Clinic / Department) --}}
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

              </div>
            </div>
          </div>

          {{-- Professional Information --}}
          <div class="card">
            <div class="card-header">Professional Information</div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-6">
                    <label>Speciality <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-stethoscope"></i></span>
                        </div>
                        <input type="text" class="form-control" id="speciality" name="speciality">
                    </div>
                </div>

                <div class="col-sm-6">
                  <label>Qualification <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-graduation-cap"></i></span>
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
                    <label>Consultation Fee <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                        </div>
                        <input class="form-control" type="number" min="0" id="consultation_fee" name="consultation_fee">
                    </div>
                </div>


                <div class="col-sm-6">
                    <label>Rating <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-star"></i></span>
                        </div>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="" hidden selected>Choose rating</option>
                            <option value="1">1 ⭐</option>
                            <option value="2">2 ⭐⭐</option>
                            <option value="3">3 ⭐⭐⭐</option>
                            <option value="4">4 ⭐⭐⭐⭐</option>
                            <option value="5">5 ⭐⭐⭐⭐⭐</option>
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
    function isValidSelectValue(selectId) {
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
            let speciality = $('#speciality').val().trim();
            let qualification = $('#qualification').val();
            let rating = $('#rating').val();
            let consultation_fee = $('#consultation_fee').val();

            let workingDays = [];
            $('input[name="working_days[]"]:checked').each(function () {
                workingDays.push($(this).val());
            });

            let passwordPattern = /^[A-Za-z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{6,15}$/;

            if (
                name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') ||
                email === '' || password === '' || confirm_password === '' ||
                phone === '' || address === '' || !isValidSelectValue('qualification') ||
                speciality === '' || !isValidSelectValue('rating') || consultation_fee === '' ||
                !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') ||
                gender === undefined || workingDays.length === 0
            ) {
                return Swal.fire({
                    title: 'Error!',
                    text: 'Please enter all required fields',
                    icon: 'error',
                    confirmButtonColor: '#007BFF',
                });
            }

            if (password && !passwordPattern.test(password)) {
                return Swal.fire({
                    title: 'Invalid Password',
                    text: 'Password must be 6–15 characters',
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
            }

            if (password !== confirm_password) {
                return Swal.fire({
                    title: 'Error!',
                    text: 'Password confirmation does not match',
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
            }

            if (consultation_fee <= 0) {
                return Swal.fire({
                    title: 'Error!',
                    text: 'The consultation fee is invalid',
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
            }

            if (parseInt(work_start_time.split(':')[0]) >= parseInt(work_end_time.split(':')[0])) {
                return Swal.fire({
                    title: 'Error!',
                    text: 'The timing is incorrect, Please correct it',
                    icon: 'error',
                    confirmButtonColor: '#007BFF'
                });
            }

            // -------- 1️⃣ فحص الإيميل بالطريقة الجديدة --------
            $.ajax({
                method: 'POST',
                url: "{{ route('check_email') }}",
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function () {

                    // -------- 2️⃣ إذا الإيميل صحيح → نكمل عملية الإضافة --------

                    let formData = new FormData();
                    formData.append('name', name);
                    formData.append('date_of_birth', date_of_birth);
                    formData.append('clinic_id', clinic_id);
                    formData.append('department_id', department_id);
                    formData.append('email', email);
                    formData.append('password', password);
                    formData.append('confirm_password', confirm_password);
                    formData.append('phone', phone);
                    formData.append('address', address);
                    formData.append('work_start_time', work_start_time);
                    formData.append('work_end_time', work_end_time);
                    formData.append('qualification', qualification);
                    formData.append('rating', rating);
                    formData.append('consultation_fee', consultation_fee);
                    formData.append('gender', gender);
                    formData.append('speciality', speciality);
                    formData.append('short_biography', short_biography);
                    formData.append('status', status);

                    if (image) formData.append('image', image);

                    workingDays.forEach(day => formData.append('working_days[]', day));

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
                                    text: 'This email is already used by another user',
                                    icon: 'error',
                                    confirmButtonColor: '#007BFF',
                                });
                            } else if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Doctor has been added successfully',
                                    icon: 'success',
                                    confirmButtonColor: '#007BFF',
                                }).then(() => window.location.href = '/admin/view/doctors');
                            }
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

    // تحميل الأقسام + الأوقات + الأيام حسب العيادة
    $('#clinic_id').on('change', function () {
        const clinicId = $(this).val();
        if (!clinicId) return;

        $.get('/clinics-management/get-departments-by-clinic/' + clinicId, function (data) {
            const departmentSelect = $('#department_id');
            departmentSelect.empty().append('<option disabled selected hidden>Select Department</option>');
            $.each(data, function (i, department) {
                departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
            });
        });

        $.get('/clinics-management/get-clinic-info/' + clinicId, function (data) {
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

        $.get('/clinics-management/clinic-working-days/' + clinicId, function (response) {
            const clinicDays = response.working_days || [];
            const allDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];

            allDays.forEach(day => {
                const checkbox = $('#day_' + day);
                if (clinicDays.includes(day)) {
                    checkbox.prop('disabled', false);
                } else {
                    checkbox.prop('disabled', true).prop('checked', false);
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

