@extends('Backend.employees.receptionists.master')

@section('title' , 'Edit Appointment')

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

    select.no-arrow {
        -webkit-appearance: none !important;
        appearance: none !important;
        background-image: none !important;
        pointer-events: none;
    }
</style>


<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title" style="margin-bottom: 30px;">Edit Appointment</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <form id="updateForm">

                    @csrf

                    <input type="hidden" id="appointment_id" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" id="clinic_id" name="clinic_id" value="{{ $clinic_id }}">
                    <input type="hidden" id="department_id" name="department_id" value="{{ $department_id }}">

                    <div class="card">
                        <div class="card-header">Appointment Information</div>
                        <div class="card-body">
                            <div class="row">

                                <!-- Clinic Fixed -->
                                <div class="col-sm-6">
                                    <label>Clinic</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-hospital"></i></span>
                                        </div>
                                        <select class="form-control no-arrow" id="clinic_display" disabled>
                                            <option selected>
                                                {{ \App\Models\Clinic::find($clinic_id)->name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Department Fixed -->
                                <div class="col-sm-6">
                                    <label>Department</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <select class="form-control no-arrow" id="department_display" disabled>
                                            <option>{{ \App\Models\Department::find($department_id)->name }}</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Patient -->
                                <div class="col-sm-6">
                                    <label>Patient Name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user-injured"></i>
                                            </span>
                                        </div>

                                        <select class="form-control no-arrow" id="patient_id" disabled>
                                            <option value="{{ $appointment->patient->id }}">
                                                {{ $appointment->patient->user->name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Doctor -->
                                <div class="col-sm-6">
                                    <label>Assigned Doctor</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                        </div>
                                        <select class="form-control" id="doctor_id">
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ $doctor->id == $appointment->doctor_id ? 'selected' : '' }}>
                                                    {{ $doctor->employee->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Day -->
                                <div class="col-sm-6">
                                    <label>Appointment Day</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                        </div>
                                        <select id="appointment_day" class="form-control"></select>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="col-sm-6">
                                    <label>Appointment Time</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select id="appointment_time" class="form-control"></select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mt-3 card">
                        <div class="card-header">Appointment Status</div>
                        <div class="card-body">
                            <label>Select Status</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                </div>
                                <select class="form-control" id="status">
                                    <option value="Accepted" {{ $appointment->status == 'Accepted' ? 'selected' : '' }}>
                                        Accepted
                                    </option>

                                    <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="mt-3 card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <textarea class="form-control" id="notes" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>

                    <div class="text-center" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary submit-btn editBtn" style="text-transform:none !important;">
                            Edit Appointment
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

    const originalData = {
        doctor_id: "{{ $appointment->doctor_id }}",
        appointment_day: "{{ \Carbon\Carbon::parse($appointment->date)->format('l') }}",
        appointment_time: "{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}",
        status: "{{ $appointment->status }}",
        notes: "{{ $appointment->notes }}"
    };

    $(document).ready(function() {

        loadDoctorDays({{ $appointment->doctor_id }});
        loadDoctorTimes({{ $appointment->doctor_id }});

        $('#doctor_id').change(function() {
            let id = $(this).val();
            loadDoctorDays(id);
            loadDoctorTimes(id);
        });
    });

    function loadDoctorDays(doctorId) {
        $.get('/clinics-management/doctor-working-days/' + doctorId, function(days) {
            let daySel = $('#appointment_day');
            daySel.empty();
            let selected = "{{ \Carbon\Carbon::parse($appointment->date)->format('l') }}";
            days.forEach(day => {
                daySel.append(`<option value="${day}" ${day === selected ? 'selected' : ''}>${day}</option>`);
            });
        });
    }

    function loadDoctorTimes(doctorId) {
        $.get('/clinics-management/get-doctor-info/' + doctorId, function(data) {
            let timeSel = $('#appointment_time');
            timeSel.empty();
            let selectedTime = "{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}";
            let [sh, sm] = data.work_start_time.split(':').map(Number);
            let [eh, em] = data.work_end_time.split(':').map(Number);
            let current = new Date();
            current.setHours(sh, sm, 0);
            let end = new Date();
            end.setHours(eh, em, 0);
            while (current <= end) {
                let hh = String(current.getHours()).padStart(2,'0');
                let mm = String(current.getMinutes()).padStart(2,'0');
                let label = `${hh}:${mm}`;
                timeSel.append(`<option value="${label}:00" ${label === selectedTime ? 'selected':''}>${label}</option>`);
                current.setMinutes(current.getMinutes() + 30);
            }
        });
    }

    function noChangesDetected() {
        let currentData = {
            doctor_id: $('#doctor_id').val(),
            appointment_day: $('#appointment_day').val(),
            appointment_time: $('#appointment_time').val().slice(0,5),
            status: $('#status').val(),
            notes: $('#notes').val().trim()
        };

        return JSON.stringify(originalData) === JSON.stringify(currentData);
    }

    $('.editBtn').click(function(e) {
        e.preventDefault();
        if (noChangesDetected()) {
            Swal.fire({
                icon: 'warning',
                title: 'No Changes',
                text: 'You did not change anything in the appointment',
                confirmButtonColor: '#00A8FF'
            });
            return;
        }

        let id = $('#appointment_id').val();

        let status = $('#status').val();
        let notes = $('#notes').val().trim();

        if (status === "Cancelled" && notes.length < 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Cancellation Reason Required',
                text: 'Please write a valid cancellation reason (at least 10 characters).',
                confirmButtonColor: '#00A8FF',
            });
            return;
        }

        if (status === "Cancelled") {
            notes = "Cancellation by Doctor: " + notes;
        }

        let data = {
            patient_id: $('#patient_id').val(),
            clinic_id: $('#clinic_id').val(),
            department_id: $('#department_id').val(),
            doctor_id: $('#doctor_id').val(),
            appointment_day: $('#appointment_day').val(),
            appointment_time: $('#appointment_time').val(),
            status: status,
            notes: notes,
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PUT'
        };

        $.ajax({
            url: "/employee/receptionist/update/appointment/" + id,
            method: "POST",
            data: data,
            success: function(resp) {
                if (resp.data == 4) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Appointment updated successfully',
                        confirmButtonColor: '#00A8FF'
                    }).then(() => window.location.href = '/employee/receptionist/view/appointments');
                    return;
                }

                if (resp.data == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Patient already has this appointment',
                        confirmButtonColor: '#00A8FF'
                    });
                }

                else if (resp.data == 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning!',
                        text: 'This slot is already booked',
                        confirmButtonColor: '#00A8FF'
                    });
                }

                else if (resp.data == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'This time has passed',
                        confirmButtonColor: '#00A8FF'
                    });
                }

                else if (resp.data == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Patient has another appointment at same time',
                        confirmButtonColor: '#00A8FF'
                    });
                }
            }

        });

    });

</script>
@endsection


