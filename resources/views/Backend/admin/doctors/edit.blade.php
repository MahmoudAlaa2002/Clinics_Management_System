@extends('Backend.admin.master')

@section('title' , 'Edit Doctor')

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
        background-color: #00A8FF !important;
        color: #fff !important;
        font-weight: 600 !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        border-bottom: 1px solid #ddd !important;
    }
    .card-body {
        background-color: #fff;
        padding: 20px;
    }
    .profile-upload .upload-img img{
        width:80px; height:80px; object-fit:cover; border-radius:8px;
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
        <form method="POST" action="{{ route('update_doctor', ['id' => $doctor->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- 1) Doctor Information --}}
          <div class="card">
            <div class="card-header">Doctor Information</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <label>Doctor Name <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Date of Birth <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Phone <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Email <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter new password (optional)">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Confirm Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                  </div>
                </div>

                <div class="col-sm-6">
                  <label>Address <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                    <input class="form-control" type="text" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Avatar</label>
                    <div class="profile-upload">
                      <div class="upload-img">
                        <img alt="doctor image" src="{{ asset($user->image ?? 'assets/img/user.jpg') }}">
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
                        <input type="radio" name="gender" value="male" class="form-check-input" {{ old('gender', $user->gender ?? '') === 'male' ? 'checked' : '' }}> Male
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" name="gender" value="female" class="form-check-input" {{ old('gender', $user->gender ?? '') === 'female' ? 'checked' : '' }}> Female
                      </label>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>


          {{-- 2) Assignment --}}
          <div class="card">
            <div class="card-header">Assignment</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <label>Clinic Name <span class="text-danger">*</span></label>
                  <select id="clinic_id" name="clinic_id" class="form-control">
                    <option disabled hidden>Select Clinic</option>
                    @foreach($clinics as $clinic)
                      <option value="{{ $clinic->id }}" {{ optional($doctor->employee)->clinic_id == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-sm-6">
                  <label>Department <span class="text-danger">*</span></label>
                  <select id="department_id" name="department_id" class="form-control">
                    <option value="{{ $doctor->department->id ?? '' }}" selected>{{ $doctor->department->name ?? 'Select Department' }}</option>
                  </select>
                </div>

              </div>
            </div>
          </div>

          {{-- 3) Professional Information --}}
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
                        <input type="text" class="form-control" id="speciality" name="speciality" value="{{ $doctor->speciality }}">
                    </div>
                </div>

                <div class="col-sm-6">
                  <label>Qualification <span class="text-danger">*</span></label>
                  <select class="form-control" id="qualification" name="qualification">
                    @php
                      $qualifications = ['MBBS','MD','DO','BDS','PhD','MSc','Fellowship','Diploma'];
                      $selectedQualification = old('qualification', $doctor->qualification ?? null);
                    @endphp
                    <option disabled {{ $selectedQualification ? '' : 'selected' }} hidden>Select Qualification</option>
                    @foreach($qualifications as $q)
                      <option value="{{ $q }}" @selected($selectedQualification === $q)>{{ $q }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-sm-6">
                    <label>Consultation Fee <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                        </div>
                        <input class="form-control" type="number" min="0" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}">
                    </div>
                </div>

                <div class="col-sm-6">
                    <label>Rating <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-star"></i></span>
                        </div>
                        <input type="number" min="0" class="form-control" id="rating" name="rating" value="{{ $doctor->rating }}">
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
                  <label>Work Start Time</label>
                  <select name="work_start_time" id="work_start_time" class="form-control">
                    <option disabled hidden>Select Start Time</option>
                    @if($doctor->employee->work_start_time)
                      <option value="{{ $doctor->employee->work_start_time }}" selected>{{ $doctor->employee->work_start_time }}</option>
                    @endif
                  </select>
                </div>

                <div class="col-sm-6">
                  <label>Work End Time</label>
                  <select name="work_end_time" id="work_end_time" class="form-control">
                    <option disabled hidden>Select End Time</option>
                    @if($doctor->employee->work_end_time)
                      <option value="{{ $doctor->employee->work_end_time }}" selected>{{ $doctor->employee->work_end_time }}</option>
                    @endif
                  </select>
                </div>

                <div class="row small-gutter">
                    <div class="col-sm-12" id="working_days">
                        <label>Working Days <span class="text-danger">*</span></label>
                        @php
                          $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                          $selectedDays = old('working_days', $doctor->working_days ?? []);
                        @endphp
                        <div class="row">
                          <div class="col-6">
                            @foreach(array_slice($all_days,0,4) as $day)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day,$selectedDays) ? 'checked' : '' }}>
                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                              </div>
                            @endforeach
                          </div>
                          <div class="col-6">
                            @foreach(array_slice($all_days,4) as $day)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day,$selectedDays) ? 'checked' : '' }}>
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

          {{-- 5) Short Bio & Status --}}
          <div class="card">
            <div class="card-header">Short Biography & Status</div>
            <div class="card-body">
                <div class="row">
                    {{-- Short Biography --}}
                    <div class="mb-3 col-sm-12">
                        <label for="short_biography">Short Biography</label>
                        <div class="input-group">
                            <textarea id="short_biography"
                                      name="short_biography"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Write a short bio...">{{ old('short_biography', $doctor->employee->short_biography ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Account Status --}}
                    <div class="mb-3 col-sm-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_active" value="active"
                            {{ old('status', $doctor->employee->status ?? 'active') === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="employee_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="employee_inactive" value="inactive"
                            {{ old('status', $doctor->employee->status ?? '') === 'inactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="employee_inactive">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center" style="margin-top:20px;">
            <button type="button" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">
                Edit Doctor
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
                    let speciality = $('#speciality').val();
                    let qualification = $('#qualification').val();
                    let rating = $('#rating').val();
                    let consultation_fee = $('#consultation_fee').val();
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
                    formData.append('department_id', department_id);
                    formData.append('email', email);
                    formData.append('password', password);
                    formData.append('confirm_password', confirm_password);
                    formData.append('phone', phone);
                    formData.append('address', address);
                    formData.append('speciality', speciality);
                    formData.append('qualification', qualification);
                    formData.append('rating', rating);
                    formData.append('consultation_fee', consultation_fee);
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


                    if (name === '' || date_of_birth === '' || !isValidSelectValue('clinic_id') || !isValidSelectValue('department_id') || email === '' || phone === '' || address === '' ||
                    speciality === '' || !isValidSelectValue('qualification') || rating === '' || consultation_fee === '' || !isValidSelectValue('work_start_time') ||
                    !isValidSelectValue('work_end_time') || gender === undefined ||workingDays.length === 0) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please enter all required fields',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                        return;
                    } else if (password !== confirm_password){
                        Swal.fire({
                            title: 'Error!',
                            text: 'Password confirmation does not match',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                        return;
                    } else if (rating < 1 || rating > 5) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'The rating must be between 1 and 5',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#007BFF',
                            });
                            return;
                    }else if (consultation_fee <= 0) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'The consultation fee is invalid',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                        return;
                    } else if (work_start_time >= work_end_time){
                        Swal.fire({
                            title: 'Error!',
                            text: 'The timing is incorrect, Please correct it',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#007BFF',
                        });
                        return;
                    } else{
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('update_doctor', ['id' => $doctor->id]) }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-HTTP-Method-Override': 'PUT'
                            },
                        success: function (response) {
                            if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This doctor already exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#007BFF',
                                });
                            } else if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Doctor has been updated successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#007BFF',
                                }).then(() => {
                                    window.location.href = '/admin/view/doctors';
                                });
                            }
                        }
                    });
                }
            });


        const currentClinicId = "{{ optional($doctor->employee)->clinic_id ?? '' }}";
        const selectedDays = {!! json_encode($doctor->employee->working_days ?? []) !!};


        if (currentClinicId) {
        loadDepartments(currentClinicId, "{{ $doctor->employee->department->id ?? '' }}");
        loadWorkingTimes(currentClinicId, "{{ $doctor->employee->work_start_time ?? '' }}", "{{ $doctor->employee->work_end_time ?? '' }}");
        loadWorkingDaysForClinic(currentClinicId, selectedDays);
        }

        $('#clinic_id').on('change', function () {
        const clinicId = $(this).val();
        loadDepartments(clinicId);
        loadWorkingTimes(clinicId);
        loadWorkingDaysForClinic(clinicId, []);
        });

        $('#department_id').on('change', function () {
        const depId = $(this).val();
        loadSpecialties(depId);
        });

        function loadDepartments(clinicId, selected = '') {
        $('#department_id').empty().append('<option disabled selected hidden>Select Department</option>');
        $.get('/admin/get-departments-by-clinic/' + clinicId, function (data) {
            data.forEach(d => {
            $('#department_id').append(`<option value="${d.id}" ${d.id == selected ? 'selected':''}>${d.name}</option>`);
            });
        });
        }

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


        function loadWorkingDaysForClinic(clinicId, selectedDays) {
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
    });
</script>
@endsection
