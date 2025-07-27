@extends('Backend.master')

@section('title' , 'Edit Doctor')


@section('content')

<style>

    .col-sm-6 {
        margin-bottom: 20px;
    }

    input[type="date"] {
        direction: ltr;
        text-align: left;
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Doctor</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_doctor' , ['id' => $doctor->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                </div>
                              <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->name }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" dir="ltr" lang="en" value="{{ $doctor->date_of_birth }}">
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
                                        <option disabled selected>Select Clinic</option>
                                        @if(isset($clinics) && $clinics->count() > 0)
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}" {{ $doctor->clinic_id == $clinic->id ? 'selected' : '' }}>
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
                                <label>Specialty <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                    </div>
                                    <select class="form-control" id="specialty_id" name="specialty_id">
                                        <option value="">Select Specialty</option>
                                        @if(isset($specialties) && $specialties->count() > 0)
                                            @foreach($specialties as $specialty)
                                                <option value="{{ $specialty->id }}" {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>
                                                    {{ $specialty->name }}
                                                </option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="email" id="email" name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password (optional)">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter new confirm password (optional)">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Phone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                </div>
                                <input class="form-control" type="text" id="address" name="address" value="{{ $user->address }}">
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
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
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
                                        <option disabled {{ !isset($doctor->work_start_time) ? 'selected' : '' }} hidden>Select Start Time</option>
                                        @php
                                            for ($hour = 8; $hour <= 22; $hour++) {
                                                $time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                                $selected = (isset($doctor->work_start_time) && $doctor->work_start_time == $time) ? 'selected' : '';
                                                echo "<option value=\"$time\" $selected>$label</option>";
                                            }
                                        @endphp
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
                                        <option disabled {{ !isset($doctor->work_end_time) ? 'selected' : '' }} hidden>Select End Time</option>
                                        @php
                                            for ($hour = 8; $hour <= 22; $hour++) {
                                                $time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00:00';
                                                $label = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                                                $selected = (isset($doctor->work_end_time) && $doctor->work_end_time == $time) ? 'selected' : '';
                                                echo "<option value=\"$time\" $selected>$label</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Working Days <span class="text-danger">*</span></label>
                                <div class="row gx-1">
                                    @php
                                        $all_days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                                        $selected_days = old('working_days', isset($working_days) ? (is_array($working_days) ? $working_days : explode(',', $working_days)) : []);
                                    @endphp

                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 0, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}"
                                                    id="day_{{ $day }}" {{ in_array($day, $selected_days) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-6">
                                        @foreach(array_slice($all_days, 4) as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}"
                                                    id="day_{{ $day }}" {{ in_array($day, $selected_days) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group gender-select">
                                <label class="gen-label">Gender: <span class="text-danger">*</span></label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="male" {{ $doctor->gender == 'male' ? 'checked' : '' }}>Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" id="gender" name="gender" class="form-check-input" value="female" {{ $doctor->gender == 'female' ? 'checked' : '' }}>Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Short Biography <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="short_biography" name="short_biography" rows="3" cols="30">{{ $doctor->short_biography }}</textarea>
                    </div>


                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="doctor_active" value="active" checked {{ $doctor->status == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="doctor_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="doctor_inactive" value="inactive" {{ $doctor->status == 'inactive' ? 'checked' : '' }}>
                            <label class="form-check-label" for="doctor_inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function isValidSelectValue(id) {
            let value = document.getElementById(id).value;
            return value !== '' && value !== null;
        }

        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let date_of_birth = $('#date_of_birth').val().trim();
                let clinic_id = $('#clinic_id').val();
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
                console.log(password);
                let workingDays = [];
                $('input[name="working_days[]"]:checked').each(function () {
                    workingDays.push($(this).val());
                });

                if (name == '' || date_of_birth == '' || specialty_id == '' || clinic_id == '' || email == '' || phone == '' || address == '' || gender == undefined || !isValidSelectValue('work_start_time') || !isValidSelectValue('work_end_time')  || $('input[name="working_days[]"]:checked').length === 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('name', name);
                formData.append('date_of_birth', date_of_birth);
                formData.append('clinic_id', clinic_id);
                formData.append('specialty_id', specialty_id);
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

                workingDays.forEach(function (day) {
                    formData.append('working_days[]', day);
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('update_doctor' , ['id' => $doctor->id]) }}",
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
                                text: 'Doctor Has Been Added Successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/view/doctors';
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
