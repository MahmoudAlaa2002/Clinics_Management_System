@extends('Backend.master')

@section('title' , 'Edit Clinic')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Clinic</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_clinic' , ['id' => $clinic->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Clinic Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="name" name="name" value="{{ $clinic->name }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="location" name="location" value="{{ $clinic->location }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Clinic Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input class="form-control" type="text" id="phone" name="phone" value="{{ $clinic->clinic_phone }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Doctor in Charge</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                    </div>
                                    <select class="form-control" id="doctor_in_charge" name="doctor_in_charge">
                                        <option value="" disabled selected hidden>Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('doctor_in_charge', $clinic->doctor_in_charge) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Opening Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="opening_time" class="form-control" style="direction: ltr; text-align: left;" lang="en" id="opening_time" value="{{ $clinic->opening_time }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Closing Time <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="closing_time" class="form-control" style="direction: ltr; text-align: left;" lang="en" id="closing_time" value="{{ $clinic->closing_time }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Working Days <span class="text-danger">*</span></label>
                                <div class="row gx-1">
                                    <div class="col-6">
                                        @php
                                            $left_days = ['Saturday','Sunday','Monday','Tuesday'];
                                        @endphp
                                        @foreach($left_days as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                                   {{ in_array($day, old('working_days', $working_days ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $right_days = ['Wednesday','Thursday','Friday'];
                                        @endphp
                                        @foreach($right_days as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                                   {{ in_array($day, old('working_days', $working_days ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Specialties <span class="text-danger">*</span></label>
                            <div class="row">
                                @php
                                    $split = ceil($all_specialties->count() / 2);
                                    $chunks = $all_specialties->chunk($split);
                                    $clinicSpecialtyIds = $clinic->specialties->pluck('id')->toArray();
                                @endphp

                                @foreach($chunks as $chunk)
                                    <div class="col-md-6">
                                        @foreach($chunk as $specialty)
                                            <div class="mb-2 form-check">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       name="specialties[]"
                                                       id="spec_{{ $specialty->id }}"
                                                       value="{{ $specialty->id }}"
                                                       {{ in_array($specialty->id, $clinicSpecialtyIds) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="spec_{{ $specialty->id }}"
                                                       style="white-space: nowrap;">
                                                    {{ $specialty->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label>Clinic Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the clinic...">{{ old('description', $clinic->description ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="clinic_active" value="active" checked>
                            <label class="form-check-label" for="clinic_active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="clinic_inactive" value="inactive">
                            <label class="form-check-label" for="clinic_inactive">Inactive</label>
                        </div>
                    </div>

                    <div class="text-center m-t-20">
                        <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Edit Clinic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.addBtn').click(function (e) {
                e.preventDefault();

                let name = $('#name').val().trim();
                let location = $('#location').val().trim();
                let phone = $('#phone').val().trim();
                let doctor_in_charge = $('#doctor_in_charge').val();
                let opening_time = $('#opening_time').val();
                let closing_time = $('#closing_time').val();
                let description = $('#description').val().trim();
                let status = $('input[name="status"]:checked').val();

                let working_days = [];
                $('input[name="working_days[]"]:checked').each(function () {
                    working_days.push($(this).val());
                });

                let specialties = [];
                $('input[name="specialties[]"]:checked').each(function () {
                    specialties.push($(this).val());
                });

                if (
                    name === '' || location === '' || phone === '' ||
                    opening_time === '' || closing_time === '' || status === undefined || working_days.length === 0 || specialties.length === 0
                ) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ route('update_clinic', ['id' => $clinic->id]) }}",
                    data: {
                        _method: 'PUT',
                        name: name,
                        location: location,
                        phone: phone,
                        doctor_in_charge: doctor_in_charge,
                        opening_time: opening_time,
                        closing_time: closing_time,
                        description: description,
                        status: status,
                        working_days: working_days,
                        specialties: specialties
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data === 0) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'This Clinic Name Already Exists',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.data === 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Clinic has been updated successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('view_clinics') }}";
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
