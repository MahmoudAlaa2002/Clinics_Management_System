@extends('Backend.master')

@section('title' , 'Add New Appointment')

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
                    <h4 class="page-title" style="margin-bottom: 30px;">Add New Appointment</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="POST" action="{{ Route('store_appointment') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Patient Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select class="form-control" id="patient_id" name="patient_id" required>
                                            <option value="" disabled selected hidden>Select Patient</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Clinic <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control" id="clinic_id" name="clinic_id" required>
                                            <option value="" disabled selected hidden>Select Clinic</option>
                                            @foreach($clinics as $clinic)
                                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Department <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select class="form-control" id="department_id" name="department_id" required>
                                            <option value="" disabled selected hidden>Select Department</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assigned to Doctor <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                                            <option value="" disabled selected hidden>Select Doctor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Doctor's Appointment <span class="text-danger">*</span></label>
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

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="appointment_day">Appointment Day <span class="text-danger">*</span></label>
                                    <select name="appointment_day" id="appointment_day" class="form-control" required>
                                        <option value="" disabled selected hidden>Select Day</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Notes </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" cols="30"></textarea>
                        </div>


                        <div class="text-center m-t-20">
                            <button type="submit" class="btn btn-primary submit-btn addBtn" style="text-transform: none !important;">Add Appointment</button>
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
                        confirmButtonText: 'OK'
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
                            Swal.fire({
                                title: 'Error!',
                                text: 'The appointment has already been booked',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.data == 1) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Appointment has been added successfully',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin/add/appointment';
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
                url: '/get-departments-by-clinic/' + clinicId,
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
                    url: '/get-doctors-by-clinic-and-department',
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
                url: '/get-doctor-info/' + doctorId,
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
                url: '/doctor-working-days/' + doctorId,
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
