@extends('Backend.admin.master')

@section('title', 'Edit Department Manager')

@section('content')

<style>
  .col-sm-6{ margin-bottom:20px; }
  input[type="date"]{ direction:ltr; text-align:left; }
  .card + .card{ margin-top:20px; }
  .card{ border:1px solid #ddd !important; border-radius:8px !important; box-shadow:0 4px 10px rgba(0,0,0,.08) !important; overflow:hidden !important; }
  .card-header{ background-color:#00A8FF !important; color:#fff !important; font-weight:600 !important; padding:12px 15px !important; font-size:16px !important; border-bottom:1px solid #ddd !important; }
  .card-body{ background-color:#fff; padding:20px; }
  .profile-upload .upload-img img{ width:80px; height:80px; object-fit:cover; border-radius:8px; }
</style>

<div class="page-wrapper">
  <div class="content">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title" style="margin-bottom:30px;">Edit Department Manager</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form method="POST" action="{{ route('update_department_manager', ['id' => $department_manager->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- 1) Basic Information --}}
          <div class="card">
            <div class="card-header">Basic Information</div>
            <div class="card-body">
              <div class="row">

                {{-- Name --}}
                <div class="col-sm-6">
                  <label>Manager Name <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $department_manager->name }}">
                  </div>
                </div>

                {{-- DOB --}}
                <div class="col-sm-6">
                  <label>Date of Birth <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ $department_manager->date_of_birth }}">
                  </div>
                </div>

                {{-- Phone --}}
                <div class="col-sm-6">
                  <label>Phone <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $department_manager->phone }}">
                  </div>
                </div>

                {{-- Email --}}
                <div class="col-sm-6">
                  <label>Email <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $department_manager->email }}">
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
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                  </div>
                </div>

                {{-- Address --}}
                <div class="col-sm-6">
                  <label>Address <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $department_manager->address }}">
                  </div>
                </div>

                {{-- Avatar --}}
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Avatar</label>
                    <div class="profile-upload">
                      <div class="upload-img">
                        <img alt="manager image" src="{{ asset($department_manager->image ?? 'assets/img/user.jpg') }}">
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
                        <input type="radio" name="gender" value="male" class="form-check-input" {{ $department_manager->gender === 'male' ? 'checked' : '' }}> Male
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        <input type="radio" name="gender" value="female" class="form-check-input" {{ $department_manager->gender === 'female' ? 'checked' : '' }}> Female
                      </label>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- 2) Clinic Assignment --}}
          <div class="card">
            <div class="card-header">Department Assignment</div>
            <div class="card-body">
              <div class="row">

                {{-- Clinic --}}
                <div class="col-sm-6">
                  <label>Clinic Name <span class="text-danger">*</span></label>
                  <div class="input-group" style="margin-bottom: 20px;">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hospital-alt"></i></span></div>
                    <select class="form-control" id="clinic_id" name="clinic_id">
                      <option disabled selected hidden>Select Clinic</option>
                      @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ optional($department_manager->employee)->clinic_id == $clinic->id ? 'selected' : '' }}>
                          {{ $clinic->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>


                {{-- Department --}}
                <div class="col-sm-6">
                    <label>Department Name <span class="text-danger">*</span></label>
                    <div class="input-group" style="margin-bottom: 20px;">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-building"></i></span></div>
                      <select class="form-control" id="department_id" name="department_id">
                        <option disabled hidden>Select Department</option>
                      </select>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          {{-- 3) Work Schedule --}}
          <div class="card">
            <div class="card-header">Work Schedule</div>
            <div class="card-body">
              <div class="row">

                {{-- Start Time --}}
                <div class="col-sm-6">
                  <label>Work Start Time <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                    <select name="work_start_time" id="work_start_time" class="form-control">
                      <option disabled hidden>Select Start Time</option>
                      @if($department_manager->employee->work_start_time)
                        <option value="{{ $department_manager->employee->work_start_time }}" selected>{{ $department_manager->employee->work_start_time }}</option>
                      @endif
                    </select>
                  </div>
                </div>

                {{-- End Time --}}
                <div class="col-sm-6">
                  <label>Work End Time <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                    <select name="work_end_time" id="work_end_time" class="form-control">
                      <option disabled hidden>Select End Time</option>
                      @if($department_manager->employee->work_end_time)
                        <option value="{{ $department_manager->employee->work_end_time }}" selected>{{ $department_manager->employee->work_end_time }}</option>
                      @endif
                    </select>
                  </div>
                </div>

                {{-- Working Days --}}
                <div class="col-sm-6">
                  <label>Working Days <span class="text-danger">*</span></label>
                  @php
                    $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                    $selectedDays = old('working_days', $department_manager->employee->working_days ?? []);
                  @endphp
                  <div class="row gx-1">
                    <div class="col-6">
                      @foreach(array_slice($all_days,0,4) as $day)
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}" {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                          <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                        </div>
                      @endforeach
                    </div>
                    <div class="col-6">
                      @foreach(array_slice($all_days,4) as $day)
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

          {{-- 4) Biography & Status --}}
          <div class="card">
            <div class="card-header">Biography & Status</div>
            <div class="card-body">
              <div class="form-group">
                <label>Short Biography</label>
                <textarea class="form-control" id="short_biography" name="short_biography" rows="3">{{ $department_manager->employee->short_biography }}</textarea>
              </div>

              <div class="form-group">
                <label class="display-block">Status</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="manager_active" value="active" {{ $department_manager->employee->status === 'active' ? 'checked' : '' }}>
                  <label class="form-check-label" for="manager_active">Active</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="manager_inactive" value="inactive" {{ $department_manager->employee->status === 'inactive' ? 'checked' : '' }}>
                  <label class="form-check-label" for="manager_inactive">Inactive</label>
                </div>
              </div>
            </div>
          </div>

          {{-- Submit --}}
          <div class="text-center m-t-20" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">Edit Department Manager</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection




@section('js')
@php
  $workStart = old('work_start_time', $department_manager->employee->work_start_time ?? '');
  $workEnd   = old('work_end_time',   $department_manager->employee->work_end_time   ?? '');
  $currentClinicId = optional($department_manager->employee)->clinic_id ?? '';
  $selectedDepartmentId = $department_manager->department->id ?? '';
@endphp

<script>
  // Helper: ensure select has a non-empty value
  function isValidSelectValue(id) {
    const el = document.getElementById(id);
    if (!el) return false;
    const v = el.value;
    return v !== '' && v !== null && v !== undefined;
  }

  // تحميل الأقسام الخاصة بالعيادة
  function loadDepartments(clinicId, selectedDepartmentId = '') {
    $('#department_id').empty().append('<option value="" disabled hidden>Select Department</option>');
    if (!clinicId) return;

    $.get('/admin/get-departments-by-clinic/' + clinicId, function (departments) {
      if (departments.length === 0) {
        $('#department_id').append('<option disabled>No departments available</option>');
      } else {
        departments.forEach(function (d) {
          const sel = (String(d.id) === String(selectedDepartmentId)) ? 'selected' : '';
          $('#department_id').append(`<option value="${d.id}" ${sel}>${d.name}</option>`);
        });
      }
    });
  }

  // تحميل أيام العمل الخاصة بالعيادة
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


  // تحميل أوقات العمل الخاصة بالعيادة
  function loadWorkingTimes(clinicId, selectedStart = '', selectedEnd = '') {
    if (!clinicId) return;
    $.get('/admin/get-clinic-info/' + clinicId, function (data) {
      const openingTime = (data.opening_time || '08:00:00').substring(0,5); // "HH:MM"
      const closingTime = (data.closing_time || '16:00:00').substring(0,5);

      const startHour = parseInt(openingTime.substring(0,2));
      const endHour   = parseInt(closingTime.substring(0,2));

      const $start = $('#work_start_time');
      const $end   = $('#work_end_time');
      $start.empty().append('<option disabled hidden>Select Start Time</option>');
      $end.empty().append('<option disabled hidden>Select End Time</option>');

      for (let hour = startHour; hour <= endHour; hour++) {
        const hh = hour.toString().padStart(2,'0');
        const opt = `${hh}:00`;
        $start.append(`<option value="${opt}">${opt}</option>`);
        $end.append(`<option value="${opt}">${opt}</option>`);
      }

      if (selectedStart) $start.val(selectedStart.substring(0,5));
      if (selectedEnd)   $end.val(selectedEnd.substring(0,5));
    });
  }

  $(document).ready(function () {
    const currentClinicId = "{{ $currentClinicId }}";
    const selectedDepartmentId = "{{ $selectedDepartmentId }}";
    const selectedDays = {!! json_encode($department_manager->employee->working_days ?? []) !!};
    const selectedStart = "{{ $workStart }}";
    const selectedEnd   = "{{ $workEnd }}";

    // تحميل البيانات عند فتح الصفحة
    if (currentClinicId) {
      $('#clinic_id').val(String(currentClinicId));
      loadDepartments(currentClinicId, selectedDepartmentId);
      loadWorkingDaysForClinic(currentClinicId, selectedDays);
      loadWorkingTimes(currentClinicId, selectedStart, selectedEnd);
    }

    // تغيير العيادة
    $('#clinic_id').on('change', function () {
      const clinicId = $(this).val();
      loadDepartments(clinicId); // تحميل الأقسام الجديدة
      loadWorkingTimes(clinicId);
      loadWorkingDaysForClinic(clinicId, []); // تفريغ الأيام عند تغيير العيادة
    });

    // إرسال البيانات عبر AJAX
    $('.editBtn').on('click', function (e) {
      e.preventDefault();

      const name = $('#name').val().trim();
      const date_of_birth = $('#date_of_birth').val().trim();
      const clinic_id = $('#clinic_id').val();
      const department_id = $('#department_id').val();
      const email = $('#email').val();
      const password = $('#password').val();
      const confirm_password = $('#confirm_password').val();
      const phone = $('#phone').val().trim();
      const address = $('#address').val().trim();
      const work_start_time = $('#work_start_time').val();
      const work_end_time = $('#work_end_time').val();
      const gender = $('input[name="gender"]:checked').val();
      const short_biography = $('#short_biography').val().trim();
      const status = $('input[name="status"]:checked').val();
      const image = document.querySelector('#image').files[0];

      let workingDays = [];
      $('input[name="working_days[]"]:checked').each(function () {
        workingDays.push($(this).val());
      });

      if (!name || !date_of_birth || !clinic_id || !department_id || !email || !phone || !address
        || !gender || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') || workingDays.length === 0) {
        Swal.fire({
          title: 'Error!',
          text: 'Please enter all required fields',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        return;
      }

      if (password && password !== confirm_password) {
        Swal.fire({
          title: 'Error!',
          text: 'Password confirmation does not match',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        return;
      }

      const formData = new FormData();
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
      formData.append('gender', gender);
      formData.append('short_biography', short_biography);
      formData.append('status', status);
      if (image) formData.append('image', image);
      workingDays.forEach(d => formData.append('working_days[]', d));

      $.ajax({
        type: 'POST',
        url: "{{ route('update_department_manager', ['id' => $department_manager->id]) }}",
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
              text: 'This department manager already exists',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          } else if (response.data == 1) {
            Swal.fire({
              title: 'Success',
              text: 'Department Manager has been updated successfully',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => window.location.href = '/admin/view/departments-managers');
          } else {
            Swal.fire({
              title: 'Notice',
              text: 'Unexpected response. Please try again.',
              icon: 'info',
              confirmButtonText: 'OK'
            });
          }
        },
      });
    });
  });
</script>
@endsection

