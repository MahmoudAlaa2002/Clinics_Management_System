@extends('Backend.admin.master')

@section('title' , 'Add New Appointment')

@section('content')

<style>
    .col-sm-6 { margin-bottom: 20px; }
    .card + .card { margin-top: 20px; }
    input[type="date"], input[type="time"] { direction: ltr; text-align: left; }

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
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Add New Appointment</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="POST" action="{{ Route('store_appointment') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Basic Info -->
                    <div class="card">
                        <div class="card-header">Appointment Information</div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id">
                                            <option value="" disabled selected hidden>Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control" id="clinic_id" name="clinic_id">
                                            <option value="" disabled selected hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="" disabled selected hidden>Select Department</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Assigned to Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select class="form-control" id="doctor_id" name="doctor_id">
                                            <option value="" disabled selected hidden>Select Doctor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Appointment Day <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                        </div>

                                        <select name="appointment_day" id="appointment_day" class="form-control">
                                            <option value="" disabled selected hidden>Select Day</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>Appointment Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select name="appointment_time" id="appointment_time" class="form-control">
                                            <option value="" disabled selected hidden>Select Appointment Time</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="card mt-3">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter notes here..."></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn addBtn px-5 rounded-pill" style="text-transform: none !important;">
                            Add Appointment
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

                let patient_id = $('#patient_id').val();
                let clinic_id = $('#clinic_id').val();
                let department_id = $('#department_id').val();
                let doctor_id = $('#doctor_id').val();
                let appointment_time = $('#appointment_time').val();
                let appointment_day = $('#appointment_day').val();
                let notes = $('#notes').val().trim();




                // ✅ استخدم FormData
                let formData = new FormData();
                formData.append('patient_id', patient_id);
                formData.append('clinic_id', clinic_id);
                formData.append('department_id', department_id);
                formData.append('doctor_id', doctor_id);
                formData.append('appointment_time', appointment_time);
                formData.append('appointment_day', appointment_day);
                formData.append('notes', notes);


                if (!isValidSelectValue('patient_id') || !isValidSelectValue('clinic_id') || !isValidSelectValue('department_id') || !isValidSelectValue('doctor_id') || !isValidSelectValue('appointment_time') || !isValidSelectValue('appointment_day')) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter All Required Fields',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#007BFF',
                    });
                    return;
                }else{
                    $.ajax({
                    method: 'POST',
                    url: "{{ route('store_appointment') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.data == 0) {
                            Swal.fire('Error!', 'This patient already has an appointment at this time', 'error');
                        }
                        else if (response.data == 1) {
                            Swal.fire('Warning', 'This appointment slot is already booked. Please choose another time', 'warning');
                        }
                        else if (response.data == 2) {
                            Swal.fire('Error!', 'This appointment time has already passed. please select another time', 'error');
                        }
                        else if (response.data == 3) {
                            Swal.fire('Error!', 'You already have an appointment scheduled at another clinic at this time', 'error');
                        }
                        else if (response.data == 4) {
                            Swal.fire('Success', 'Appointment has been added successfully', 'success')
                                .then(() => {
                                    window.location.href = '/admin/view/appointments';
                                });
                        }
                    }
                });
            }
        });
    });


    $('#clinic_id').on('change', function () {
        var clinicId = $(this).val();

        // إخفاء خيار "Select Clinic"
        $(this).find('option:first').hide();

        if (clinicId) {
            // جلب التخصصات من العيادة
            $.ajax({
                url: '/admin/get-departments-by-clinic/' + clinicId,
                type: 'GET',
                success: function (data) {
                    let departmentSelect = $('#department_id');
                    departmentSelect.empty().append('<option value="" disabled selected hidden>Select Department</option>');

                    let doctorSelect = $('#doctor_id');
                    doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                    $.each(data, function (key, department) {
                        departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                }
            });
        }
    });

    $('#department_id').on('change', function () {
            var departmentId = $(this).val();
            var clinicId = $('#clinic_id').val(); // مهم جداً

            if (departmentId && clinicId) {
                $.ajax({
                    url: '/clinics-management/get-doctors-by-clinic-and-department',
                    type: 'GET',
                    data: {
                        clinic_id: clinicId,
                        department_id: departmentId
                    },
                    success: function (data) {
                        let doctorSelect = $('#doctor_id');
                        doctorSelect.empty().append('<option value="" disabled selected hidden>Select Doctor</option>');

                        $.each(data, function (key, doctor) {
                            doctorSelect.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                        });
                    }
                });
            }
        });


        $('#doctor_id').on('change', function () {
        // إخفاء خيار "Select Doctor"
        $(this).find('option:first').hide();
    });

    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: '/clinics-management/get-doctor-info/' + doctorId,
                type: 'GET',
                success: function (data) {
                    let startParts = data.work_start_time.split(':');
                    let endParts = data.work_end_time.split(':');

                    let startHour = parseInt(startParts[0]);
                    let startMinute = parseInt(startParts[1]);

                    let endHour = parseInt(endParts[0]);
                    let endMinute = parseInt(endParts[1]);

                    let appointmentSelect = $('#appointment_time');
                    appointmentSelect.empty().append('<option disabled selected hidden>Select Appointment Time</option>');

                    let current = new Date();
                    current.setHours(startHour, startMinute, 0, 0);

                    let end = new Date();
                    end.setHours(endHour, endMinute, 0, 0);

                    while (current <= end) {
                        let hh = current.getHours().toString().padStart(2, '0');
                        let mm = current.getMinutes().toString().padStart(2, '0');
                        let timeLabel = `${hh}:${mm}`;
                        appointmentSelect.append(`<option value="${timeLabel}:00">${timeLabel}</option>`);

                        // أضف 30 دقيقة
                        current.setMinutes(current.getMinutes() + 30);
                    }
                },
                error: function (xhr) {
                    console.error('Failed to fetch doctor times', xhr);
                    $('#appointment_time').html('<option value="">Could not load appointment times</option>');
                }
            });
        }
    });

    $('#doctor_id').on('change', function () {
        var doctorId = $(this).val();

        if (doctorId) {
            $.ajax({
                url: '/clinics-management/doctor-working-days/' + doctorId,
                type: 'GET',
                success: function (doctorDays) {
                    let daySelect = $('#appointment_day');

                    doctorDays.forEach(function(day) {
                        daySelect.append('<option value="' + day + '">' + day + '</option>');
                    });
                },
            });
        }
    });

    </script>
@endsection
