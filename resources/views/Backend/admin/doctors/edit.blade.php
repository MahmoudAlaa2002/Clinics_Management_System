@extends('Backend.master')

@section('title', 'Edit Doctor')

@section('content')

<style>
  .col-sm-6{ margin-bottom:20px; }
  input[type="date"]{ direction:ltr; text-align:left; }
  .card + .card{ margin-top:20px; }
  .card-header{ font-weight:600; }
  .small-gutter > [class^="col-"]{ padding-left:30px !important; margin-top:15px !important; }
  .card{ border:1px solid #ddd !important; border-radius:8px !important; box-shadow:0 4px 10px rgba(0,0,0,.08) !important; overflow:hidden !important; }
  .card-header{ background-color:#00A8FF !important; color:#fff !important; font-weight:600 !important; padding:12px 15px !important; font-size:16px !important; border-bottom:1px solid #ddd !important; }
  .card-body{ background-color:#fff; padding:20px; }
  .profile-upload .upload-img img{ width:80px; height:80px; object-fit:cover; border-radius:8px; }
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
                {{-- Name --}}
                <div class="col-sm-6">
                  <label>Doctor Name <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-md"></i></span></div>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}">
                  </div>
                </div>

                {{-- DOB --}}
                <div class="col-sm-6">
                  <label>Date of Birth <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar-alt"></i></span></div>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
                  </div>
                </div>

                {{-- Phone --}}
                <div class="col-sm-6">
                  <label>Phone <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-phone"></i></span></div>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                  </div>
                </div>

                {{-- Email --}}
                <div class="col-sm-6">
                  <label>Email <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
                  </div>
                </div>

                {{-- Password --}}
                <div class="col-sm-6">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Enter new password (optional)">
                  </div>
                </div>

                {{-- Confirm --}}
                <div class="col-sm-6">
                  <label>Confirm Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm new password">
                  </div>
                </div>

                {{-- Address --}}
                <div class="col-sm-6">
                  <label>Address <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span></div>
                    <input class="form-control" type="text" id="address" name="address" value="{{ old('address', $user->address ?? '') }}">
                  </div>
                </div>

                {{-- Avatar --}}
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

                {{-- Gender --}}
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

          {{-- 2) Professional Information --}}
          <div class="card">
            <div class="card-header">Professional Information</div>
            <div class="card-body">
              <div class="row">
                {{-- Qualification --}}
                <div class="col-sm-6">
                  <label>Qualification <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user-graduate"></i></span></div>
                    @php
                      $qualifications = ['MBBS','MD','DO','BDS','PhD','MSc','Fellowship','Diploma'];
                      $selectedQualification = old('qualification', $doctor->qualification ?? null);
                    @endphp
                    <select class="form-control" id="qualification" name="qualification">
                      <option disabled {{ $selectedQualification ? '' : 'selected' }} hidden>Select Qualification</option>
                      @foreach($qualifications as $q)
                        <option value="{{ $q }}" @selected($selectedQualification === $q)>{{ $q }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                {{-- Experience --}}
                <div class="col-sm-6">
                  <label>Experience Years <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-briefcase"></i></span></div>
                    <input class="form-control" type="number" min="0" id="experience_years" name="experience_years" value="{{ old('experience_years', $doctor->experience_years ?? '') }}">
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- 3) Assignment --}}
          <div class="card">
            <div class="card-header">Assignment</div>
            <div class="card-body">
              <div class="row">
                {{-- Clinic --}}
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Clinic Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hospital-alt"></i></span></div>
                      <select id="clinic_id" name="clinic_id" class="form-control">
                        <option disabled hidden>Select Clinic</option>
                        @foreach($clinics as $clinic)
                          <option value="{{ $clinic->id }}" {{ optional($doctor->employee)->clinic_id == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                {{-- Department --}}
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Department <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-stethoscope"></i></span></div>
                      <select id="department_id" name="department_id" class="form-control">
                        @php
                          $currentDepartmentId = $doctor->clinicDepartment->department_id ?? null;
                          $currentDepartmentName = $doctor->clinicDepartment->department->name ?? 'Select Department';
                        @endphp
                        <option value="{{ $currentDepartmentId }}" {{ $currentDepartmentId ? 'selected' : '' }}>
                          {{ $currentDepartmentName }}
                        </option>
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
                {{-- Start --}}
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Work Start Time <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                      <select name="work_start_time" id="work_start_time" class="form-control">
                        @php $start = old('work_start_time', $doctor->work_start_time ?? null); @endphp
                        <option disabled hidden>Select Start Time</option>
                        @if($start)<option value="{{ $start }}" selected>{{ $start }}</option>@endif
                      </select>
                    </div>
                  </div>
                </div>

                {{-- End --}}
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Work End Time <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-clock"></i></span></div>
                      <select name="work_end_time" id="work_end_time" class="form-control">
                        @php $end = old('work_end_time', $doctor->work_end_time ?? null); @endphp
                        <option disabled hidden>Select End Time</option>
                        @if($end)<option value="{{ $end }}" selected>{{ $end }}</option>@endif
                      </select>
                    </div>
                  </div>
                </div>

                {{-- Working Days --}}
                <div class="row small-gutter" style="width:100%; margin:0;">
                  <div class="col-sm-12">
                    <label>Working Days <span class="text-danger">*</span></label>
                    @php
                      $all_days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
                      $selectedDays = old('working_days', $working_days ?? []); // مرّر $working_days من الكنترولر
                    @endphp
                    <div class="row gx-1">
                      <div class="col-6">
                        @foreach(array_slice($all_days,0,4) as $day)
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                   {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                            <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                          </div>
                        @endforeach
                      </div>
                      <div class="col-6">
                        @foreach(array_slice($all_days,4) as $day)
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
          </div>

          {{-- 5) Short Bio & Status --}}
          <div class="card">
            <div class="card-header">Short Biography & Status</div>
            <div class="card-body">
              <div class="row">
                {{-- Bio --}}
                <div class="col-sm-12">
                  <div class="form-group">
                    <label>Short Biography</label>
                    <textarea class="form-control" id="short_biography" name="short_biography" rows="3">{{ old('short_biography', $doctor->employee->short_biography ?? '') }}</textarea>
                  </div>
                </div>

                {{-- Status --}}
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="display-block">Status</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active" {{ old('status', $doctor->status ?? 'active') === 'active' ? 'checked' : '' }}>
                      <label class="form-check-label" for="doctor_active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive" {{ old('status', $doctor->status ?? '') === 'inactive' ? 'checked' : '' }}>
                      <label class="form-check-label" for="doctor_inactive">Inactive</label>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- Submit --}}
          <div class="text-center m-t-20" style="margin-top:20px;">
            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform:none !important;">Edit Doctor</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
@php
  $workStart = old('work_start_time', $doctor->employee->work_start_time ?? '');
  $workEnd   = old('work_end_time',   $doctor->employee->work_end_time   ?? '');
  $currentClinicId = optional($doctor->employee)->clinic_id ?? '';
  $selectedDepartmentId =  $doctor->department->id ?? '';


@endphp

<script>
  // Helper: ensure select has a non-empty value
  function isValidSelectValue(id) {
    const el = document.getElementById(id);
    if (!el) return false;
    const v = el.value;
    return v !== '' && v !== null && v !== undefined;
  }

  // Load departments for a clinic
  function loadDepartments(clinicId, selectedDepartmentId = '') {
    $('#department_id').empty().append('<option value="" disabled hidden>Select Department</option>');
    if (!clinicId) return;
    $.get('/admin/get-departments-by-clinic/' + clinicId, function (departments) {
      departments.forEach(function (d) {
        const sel = (String(d.id) === String(selectedDepartmentId)) ? 'selected' : '';
        $('#department_id').append(`<option value="${d.id}" ${sel}>${d.name}</option>`);
      });
    });
  }

  // Load working days allowed by clinic and mark selected ones
  function loadWorkingDaysForClinic(clinicId, selectedDays = []) {
    $.get('/admin/clinic-working-days/' + clinicId, function (clinicDays) {
      const allDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
      const $daysContainer = $('#working_days');
      $daysContainer.empty();


      const $col1 = $('<div class="col-6"></div>');
      const $col2 = $('<div class="col-6"></div>');

      allDays.forEach((day, idx) => {
        const isAvailable = clinicDays.includes(day);
        const isSelected  = selectedDays.includes(day);
        const checkbox = `
          <div class="form-check">
            <input class="form-check-input" type="checkbox"
              name="working_days[]" value="${day}"
              id="day_${day}" ${isSelected ? 'checked' : ''} ${!isAvailable ? 'disabled' : ''}>
            <label class="form-check-label ${!isAvailable ? 'text-muted' : ''}" for="day_${day}">
              ${day}
            </label>
          </div>
        `;
        (idx < 4 ? $col1 : $col2).append(checkbox);
      });

      $daysContainer.append($col1, $col2);
    });
  }

  // Load work times based on clinic opening/closing
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
    // if jQuery/SweetAlert not globally loaded in master, make sure to include them there.

    const currentClinicId = "{{ $currentClinicId }}";
    const selectedDepartmentId = "{{ $selectedDepartmentId }}";
    const selectedDays = {!! json_encode($doctor->working_days ?? $working_days ?? []) !!};
    const selectedStart = "{{ $workStart }}";
    const selectedEnd   = "{{ $workEnd }}";


    if (currentClinicId) {
      $('#clinic_id').val(String(currentClinicId));
      loadDepartments(currentClinicId, selectedDepartmentId);
      loadWorkingDaysForClinic(currentClinicId, selectedDays);
      loadWorkingTimes(currentClinicId, selectedStart, selectedEnd);
    }

    $('#clinic_id').on('change', function () {
      const clinicId = $(this).val();
      $('#department_id').empty().append('<option disabled selected hidden>Select Department</option>');
      loadDepartments(clinicId);
      loadWorkingTimes(clinicId);
      loadWorkingDaysForClinic(clinicId, []); // reset selected days on clinic change
    });

    // Submit via AJAX with validation
    $('.addBtn').on('click', function (e) {
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
      const qualification = $('#qualification').val().trim();
      const experience_years = $('#experience_years').val();

      let workingDays = [];
      $('input[name="working_days[]"]:checked').each(function () {
        workingDays.push($(this).val());
      });

      if (!name || !date_of_birth || !clinic_id || !department_id || !email || !phone || !address || !isValidSelectValue('qualification') || !experience_years ||
          !gender || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') ||
          workingDays.length === 0) {
        Swal.fire({
          title: 'Error!',
          text: 'Please Enter All Required Fields',
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
      formData.append('qualification', qualification);
      formData.append('experience_years', experience_years);
      formData.append('gender', gender);
      formData.append('short_biography', short_biography);
      formData.append('status', status);
      if (image) formData.append('image', image);
      workingDays.forEach(d => formData.append('working_days[]', d));

      $.ajax({
        type: 'POST',
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
              text: 'This Doctor Already Exists',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          } else if (response.data == 1) {
            Swal.fire({
              title: 'Success',
              text: 'Doctor Has Been Updated Successfully',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => window.location.href = '/admin/view/doctors');
          } else {
            Swal.fire({
              title: 'Notice',
              text: 'Unexpected response. Please try again.',
              icon: 'info',
              confirmButtonText: 'OK'
            });
          }
        },
        error: function(xhr){
          Swal.fire({
            title: 'Error!',
            text: (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Request failed',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      });
    });
  });
</script>
@endsection
