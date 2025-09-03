@extends('Backend.master')

@section('title', 'Edit Clinic Manager')

@section('content')
<style>
  .col-sm-6 { margin-bottom: 20px; }
  input[type="date"] { direction: ltr; text-align: left; }
  .profile-upload .upload-img img{ width:80px;height:80px;object-fit:cover;border-radius:8px; }
</style>

<div class="page-wrapper">
  <div class="content">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <h4 class="page-title" style="margin-bottom: 30px;">Edit Clinic Manager</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <form method="POST" action="{{ route('update_clinics_managers', ['id' => $clinic_manager->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-sm-6">
              <label>Full Name <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                </div>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ $clinic_manager->name }}">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Date of Birth <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                </div>
                <input type="date" id="date_of_birth" name="date_of_birth"
                       class="form-control" dir="ltr" lang="en"
                       value="{{ $clinic_manager->date_of_birth  }}">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Phone <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-phone"></i></span>
                </div>
                <input type="text" class="form-control" id="phone" name="phone"
                       value="{{ $clinic_manager->phone }}">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Email <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                <input class="form-control" type="email" id="email" name="email"
                       value="{{ $clinic_manager->email }}">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                <input type="password" id="password" name="password" class="form-control"
                       placeholder="Enter new password (optional)">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Confirm Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                <input class="form-control" type="password" id="confirm_password" name="confirm_password"
                       placeholder="Enter new confirm password (optional)">
              </div>
            </div>

            <div class="col-sm-6">
              <label>Address <span class="text-danger">*</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                </div>
                <input class="form-control" type="text" id="address" name="address"
                       value="{{ $clinic_manager->address }}">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Avatar</label>
                <div class="profile-upload">
                  <div class="upload-img">
                    <img alt="doctor image" src="{{ asset($clinic_manager->image ?? 'assets/img/user.jpg') }}">
                  </div>
                  <div class="upload-input">
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Clinic Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                  </div>
                  <select class="form-control" id="clinic_id" name="clinic_id">
                    <option disabled selected hidden>Select Clinic</option>
                    @if(isset($clinics) && $clinics->count() > 0)
                      @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}"
                          {{ optional($clinic_manager->employee)->clinic_id == $clinic->id ? 'selected' : '' }}>
                          {{ $clinic->name }}
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Work Start Time <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                  </div>
                  <select name="work_start_time" id="work_start_time" class="form-control">
                    <option disabled hidden>Select Start Time</option>
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
                    <option disabled hidden>Select End Time</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>Working Days <span class="text-danger">*</span></label>
                <div class="row gx-1" id="working_days" name="working_days">

                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group gender-select">
                <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                <div class="form-check-inline">
                  <label class="form-check-label" for="gender_male">
                    <input type="radio" id="gender_male" name="gender" class="form-check-input" value="male"
                           {{ old('gender', $clinic_manager->gender ?? '') === 'male' ? 'checked' : '' }}> Male
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="gender_female">
                    <input type="radio" id="gender_female" name="gender" class="form-check-input" value="female"
                           {{ old('gender', $user->gender ?? '') === 'female' ? 'checked' : '' }}> Female
                  </label>
                </div>
              </div>
            </div>
          </div>

          {{-- Short Biography --}}
          <div class="form-group">
            <label>Short Biography <span class="text-danger">*</span></label>
            <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30">{{ $clinic_manager->employee->short_biography }}</textarea>
          </div>

          {{-- Status --}}
          <div class="form-group">
            <label class="display-block">Status</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active"
                     {{ old('status', $clinic_manager->employee->status ?? 'active') === 'active' ? 'checked' : '' }}>
              <label class="form-check-label" for="doctor_active">Active</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive"
                     {{ old('status', $clinic_manager->employee->status ?? '') === 'inactive' ? 'checked' : '' }}>
              <label class="form-check-label" for="doctor_inactive">Inactive</label>
            </div>
          </div>

          <div class="text-center m-t-20">
            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">
              Edit Clinic Manager
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
@php
  $workStart = old('work_start_time', $clinic_manager->employee->work_start_time ?? '');
  $workEnd   = old('work_end_time',   $clinic_manager->employee->work_end_time   ?? '');
  $currentClinicId = optional($clinic_manager->employee)->clinic_id ?? '';
  $selectedDepartmentId =  $clinic_manager->department->id ?? '';


@endphp

<script>
  // Helper: ensure select has a non-empty value
  function isValidSelectValue(id) {
    const el = document.getElementById(id);
    if (!el) return false;
    const v = el.value;
    return v !== '' && v !== null && v !== undefined;
  }


//   function loadDepartments(clinicId, selectedDepartmentId = '') {
//     $('#department_id').empty().append('<option value="" disabled hidden>Select Department</option>');
//     if (!clinicId) return;
//     $.get('/admin/get-departments-by-clinic/' + clinicId, function (departments) {
//       departments.forEach(function (d) {
//         const sel = (String(d.id) === String(selectedDepartmentId)) ? 'selected' : '';
//         $('#department_id').append(`<option value="${d.id}" ${sel}>${d.name}</option>`);
//       });
//     });
//   }

  
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
    const selectedDays = {!! json_encode($doctor->working_days ?? $working_days ?? []) !!};
    const selectedStart = "{{ $workStart }}";
    const selectedEnd   = "{{ $workEnd }}";


    if (currentClinicId) {
      $('#clinic_id').val(String(currentClinicId));
    //   loadDepartments(currentClinicId, selectedDepartmentId);
      loadWorkingDaysForClinic(currentClinicId, selectedDays);
      loadWorkingTimes(currentClinicId, selectedStart, selectedEnd);
    }

    $('#clinic_id').on('change', function () {
      const clinicId = $(this).val();
      $('#department_id').empty().append('<option disabled selected hidden>Select Department</option>');
    //   loadDepartments(clinicId);
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

      let workingDays = [];
      $('input[name="working_days[]"]:checked').each(function () {
        workingDays.push($(this).val());
      });

      if (!name || !date_of_birth || !clinic_id  || !email || !phone || !address || !gender || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time') || workingDays.length === 0) {
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
      formData.append('gender', gender);
      formData.append('short_biography', short_biography);
      formData.append('status', status);
      if (image) formData.append('image', image);
      workingDays.forEach(d => formData.append('working_days[]', d));

      $.ajax({
        type: 'POST',
        url: "{{ route('update_clinics_managers', ['id' => $clinic_manager->id]) }}",
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
              text: 'This Clinic Manager Already Exists',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          } else if (response.data == 1) {
            Swal.fire({
              title: 'Success',
              text: 'Clinic Manager Has Been Updated Successfully',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => window.location.href = '/admin/view/clinics/managers');
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
