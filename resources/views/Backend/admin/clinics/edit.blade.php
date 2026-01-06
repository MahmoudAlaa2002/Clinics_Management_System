@extends('Backend.admin.master')

@section('title' , 'Edit Clinic')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    .card-header { font-weight: 600; }
    input[type="time"] { direction: ltr; text-align: left; }

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
        background-color: #00A8FF !important; /* اللون الأزرق */
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
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Clinic</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('update_clinic', ['id' => $clinic->id]) }}">
                    @csrf
                    @method('PUT')

                    {{-- 1) Basic Info --}}
                    <div class="card">
                        <div class="card-header">Basic Information</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Name --}}
                                <div class="col-sm-6">
                                    <label>Clinic Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $clinic->name) }}">
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="col-sm-6">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="location" name="location" value="{{ old('location', $clinic->location) }}">
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-sm-6">
                                    <label>Clinic Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $clinic->email) }}">
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-sm-6">
                                    <label>Clinic Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input class="form-control" type="text" id="phone" name="phone" value="{{ old('phone', $clinic->phone) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2) Working Schedule (Hours + Days) --}}
                    <div class="card">
                        <div class="card-header">Working Schedule</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- Opening --}}
                                <div class="col-sm-6">
                                    <label>Opening Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="time" name="opening_time" class="form-control" lang="en" id="opening_time" value="{{ old('opening_time', $clinic->opening_time) }}">
                                    </div>
                                </div>

                                {{-- Closing --}}
                                <div class="col-sm-6">
                                    <label>Closing Time <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="time" name="closing_time" class="form-control" lang="en" id="closing_time" value="{{ old('closing_time', $clinic->closing_time) }}">
                                    </div>
                                </div>

                                {{-- Working Days --}}
                                <div class="row small-gutter" style="width:100%; margin:0;">
                                    <div class="col-sm-6">
                                        <label>Working Days <span class="text-danger">*</span></label>
                                        <div class="row gx-1">
                                            <div class="col-6">
                                                @php $left_days = ['Saturday','Sunday','Monday','Tuesday']; @endphp
                                                @foreach($left_days as $day)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="working_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                                               {{ in_array($day, old('working_days', $working_days ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-6">
                                                @php $right_days = ['Wednesday','Thursday','Friday']; @endphp
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
                            </div>
                        </div>
                    </div>

                    {{-- 3) Departments --}}
                    <div class="card">
                        <div class="card-header">Departments</div>
                        <div class="card-body">
                            <label>Departments <span class="text-danger">*</span></label>
                            <div class="row gx-1">
                                @php
                                    $split = ceil($all_departments->count() / 2);
                                    $chunks = $all_departments->chunk($split);
                                    $clinicDepartmentIds = $clinic->departments->pluck('id')->toArray();
                                @endphp

                                @foreach($chunks as $chunk)
                                    <div class="col-6">
                                        @foreach($chunk as $department)
                                            <div class="form-check mb-2">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="spec_{{ $department->id }}"
                                                       name="departments[]"
                                                       value="{{ $department->id }}"
                                                       {{ in_array($department->id, old('departments', $clinicDepartmentIds)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="spec_{{ $department->id }}">{{ $department->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- 4) Description & Status --}}
                    <div class="card">
                        <div class="card-header">Description & Status</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Clinic Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a short description about the clinic...">{{ old('description', $clinic->description ?? '') }}</textarea>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="clinic_active" value="active" {{ old('status', $clinic->status) === 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="clinic_active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="clinic_inactive" value="inactive" {{ old('status', $clinic->status) === 'inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="clinic_inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center m-t-20" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform: none !important;">
                            Edit Clinic
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $originalName = $clinic->name;
    $originalLocation = $clinic->location;
    $originalEmail = $clinic->email;
    $originalPhone = $clinic->phone;
    $originalOpening = $clinic->opening_time;
    $originalClosing = $clinic->closing_time;
    $originalDescription = $clinic->description ?? '';
    $originalStatus = $clinic->status;
    $originalWorkingDays = $working_days ?? [];
    $clinicDepartmentIds = $clinic->departments->pluck('id')->toArray();
@endphp


@section('js')
<script>

    function isValidSelectValue(id) {
        let value = document.getElementById(id).value;
        return value !== '' && value !== '0';
    }

    $(document).ready(function () {

        $('.editBtn').click(function (e) {
            e.preventDefault();

            let name = $('#name').val().trim();
            let location = $('#location').val().trim();
            let email = $('#email').val().trim();
            let phone = $('#phone').val().trim();
            let opening_time = $('#opening_time').val();
            let closing_time = $('#closing_time').val();
            let description = $('#description').val().trim();
            let status = $('input[name="status"]:checked').val();

            let working_days = [];
            $('input[name="working_days[]"]:checked').each(function () {
                working_days.push($(this).val());
            });

            let departments = [];
            $('input[name="departments[]"]:checked').each(function () {
                departments.push(Number($(this).val()));
            });

            if (name === '' || location === '' || email === '' || phone === '' || !isValidSelectValue('opening_time') ||
                !isValidSelectValue('closing_time') || working_days.length === 0 || departments.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter all required fields',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }

            if (opening_time >= closing_time){
                Swal.fire({
                    title: 'Error!',
                    text: 'The timing is incorrect, please correct it',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }

            let originalWorkingDays = @json($originalWorkingDays);
            let originalDepartments = @json($clinicDepartmentIds).map(Number);

            let noChanges =
                name === "{{ $originalName }}" &&
                location === "{{ $originalLocation }}" &&
                email === "{{ $originalEmail }}" &&
                phone === "{{ $originalPhone }}" &&
                opening_time === "{{ $originalOpening }}" &&
                closing_time === "{{ $originalClosing }}" &&
                description === "{{ $originalDescription }}" &&
                status === "{{ $originalStatus }}" &&
                JSON.stringify(working_days.sort()) === JSON.stringify(originalWorkingDays.sort()) &&
                JSON.stringify(departments.sort()) === JSON.stringify(originalDepartments.sort());

            if (noChanges) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Changes',
                    text: 'No updates were made to this clinic',
                    confirmButtonColor: '#00A8FF',
                });
                return;
            }

            // ====== فحص الإيميل الحقيقي (RFC + DNS) ======
            $.ajax({
                method: 'POST',
                url: "{{ route('check_email') }}",
                data: {
                    email: email,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function () {

                    // ====== التحديث ======
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('update_clinic', ['id' => $clinic->id]) }}",
                        data: {
                            _method: 'PUT',
                            name: name,
                            location: location,
                            email: email,
                            phone: phone,
                            opening_time: opening_time,
                            closing_time: closing_time,
                            description: description,
                            status: status,
                            working_days: working_days,
                            departments: departments,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function (response) {
                            if (response.data === 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This clinic name already exists',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#00A8FF',
                                });
                            } else if (response.data === 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Clinic has been updated successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#00A8FF',
                                }).then(() => {
                                    window.location.href = "{{ route('view_clinics') }}";
                                });
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
                        confirmButtonColor: '#00A8FF'
                    });
                }
            });

        });
    });
</script>
@endsection
